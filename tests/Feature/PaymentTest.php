<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Payment;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class PaymentTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected User $user;
    protected Course $course;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create(['role' => 'student']);
        $this->course = Course::factory()->create([
            'price' => 499000,
            'certificate_price' => 0,
            'currency' => 'IDR',
        ]);
    }

    /** @test */
    public function user_can_view_payment_page()
    {
        $response = $this->actingAs($this->user)
            ->get(route('payment.index', [
                'course' => $this->course->id,
                'track' => 'verified'
            ]));

        $response->assertStatus(200);
        $response->assertViewIs('payment');
        $response->assertViewHas('course', $this->course);
        $response->assertViewHas('price', 499000);
    }

    /** @test */
    public function unauthenticated_user_cannot_access_payment()
    {
        $response = $this->get(route('payment.index', [
            'course' => $this->course->id
        ]));

        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function user_cannot_proceed_payment_for_invalid_course()
    {
        $response = $this->actingAs($this->user)
            ->get(route('payment.index', ['course' => 99999]));

        $response->assertRedirect(route('courses.index'));
    }

    /** @test */
    public function user_can_complete_payment_with_valid_card()
    {
        $response = $this->actingAs($this->user)
            ->post(route('payment.store'), [
                'course_id' => $this->course->id,
                'track' => 'verified',
                'first_name' => 'John',
                'last_name' => 'Doe',
                'country' => 'Indonesia',
                'card_number' => '4532015112830366',  // Valid test Visa
                'card_expiry' => '12/25',
                'card_cvc' => '123',
                'coupon_code' => null,
            ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('payments', [
            'user_id' => $this->user->id,
            'amount' => 499000,
            'status' => 'paid',
            'card_brand' => 'visa',
            'card_last4' => '0366',
        ]);
    }

    /** @test */
    public function payment_creates_enrollment_record()
    {
        $this->actingAs($this->user)
            ->post(route('payment.store'), [
                'course_id' => $this->course->id,
                'track' => 'verified',
                'first_name' => 'John',
                'last_name' => 'Doe',
                'country' => 'Indonesia',
                'card_number' => '5425233010103010',  // Valid test Mastercard
                'card_expiry' => '12/25',
                'card_cvc' => '123',
            ]);

        $this->assertDatabaseHas('enrollments', [
            'user_id' => $this->user->id,
            'course_id' => $this->course->id,
            'type' => 'verified',
            'status' => 'active',
        ]);
    }

    /** @test */
    public function payment_validates_card_number()
    {
        $response = $this->actingAs($this->user)
            ->post(route('payment.store'), [
                'course_id' => $this->course->id,
                'track' => 'verified',
                'first_name' => 'John',
                'last_name' => 'Doe',
                'country' => 'Indonesia',
                'card_number' => '1234',  // Invalid (too short)
                'card_expiry' => '12/25',
                'card_cvc' => '123',
            ]);

        $response->assertSessionHasErrors('card_number');
    }

    /** @test */
    public function payment_validates_card_expiry_format()
    {
        $response = $this->actingAs($this->user)
            ->post(route('payment.store'), [
                'course_id' => $this->course->id,
                'track' => 'verified',
                'first_name' => 'John',
                'last_name' => 'Doe',
                'country' => 'Indonesia',
                'card_number' => '4532015112830366',
                'card_expiry' => 'invalid',  // Invalid format
                'card_cvc' => '123',
            ]);

        $response->assertSessionHasErrors('card_expiry');
    }

    /** @test */
    public function payment_validates_cvc()
    {
        $response = $this->actingAs($this->user)
            ->post(route('payment.store'), [
                'course_id' => $this->course->id,
                'track' => 'verified',
                'first_name' => 'John',
                'last_name' => 'Doe',
                'country' => 'Indonesia',
                'card_number' => '4532015112830366',
                'card_expiry' => '12/25',
                'card_cvc' => '12',  // Too short
            ]);

        $response->assertSessionHasErrors('card_cvc');
    }

    /** @test */
    public function coupon_code_coursify10_applies_10_percent_discount()
    {
        $this->actingAs($this->user)
            ->post(route('payment.store'), [
                'course_id' => $this->course->id,
                'track' => 'verified',
                'first_name' => 'John',
                'last_name' => 'Doe',
                'country' => 'Indonesia',
                'card_number' => '4532015112830366',
                'card_expiry' => '12/25',
                'card_cvc' => '123',
                'coupon_code' => 'COURSIFY10',
            ]);

        $discount = 499000 * 0.10;
        $this->assertDatabaseHas('payments', [
            'user_id' => $this->user->id,
            'discount_amount' => $discount,
            'amount' => 499000 - $discount,
            'coupon_code' => 'COURSIFY10',
        ]);
    }

    /** @test */
    public function invalid_coupon_code_is_ignored()
    {
        $this->actingAs($this->user)
            ->post(route('payment.store'), [
                'course_id' => $this->course->id,
                'track' => 'verified',
                'first_name' => 'John',
                'last_name' => 'Doe',
                'country' => 'Indonesia',
                'card_number' => '4532015112830366',
                'card_expiry' => '12/25',
                'card_cvc' => '123',
                'coupon_code' => 'INVALID_CODE',
            ]);

        $this->assertDatabaseHas('payments', [
            'user_id' => $this->user->id,
            'amount' => 499000,
            'discount_amount' => 0,
        ]);
    }

    /** @test */
    public function payment_requires_required_fields()
    {
        $response = $this->actingAs($this->user)
            ->post(route('payment.store'), []);

        $response->assertSessionHasErrors([
            'course_id',
            'track',
            'first_name',
            'last_name',
            'country',
            'card_number',
            'card_expiry',
            'card_cvc',
        ]);
    }

    /** @test */
    public function card_brand_visa_is_detected_correctly()
    {
        $this->actingAs($this->user)
            ->post(route('payment.store'), [
                'course_id' => $this->course->id,
                'track' => 'verified',
                'first_name' => 'John',
                'last_name' => 'Doe',
                'country' => 'Indonesia',
                'card_number' => '4532015112830366',  // Visa
                'card_expiry' => '12/25',
                'card_cvc' => '123',
            ]);

        $this->assertDatabaseHas('payments', [
            'card_brand' => 'visa',
        ]);
    }

    /** @test */
    public function card_brand_mastercard_is_detected_correctly()
    {
        $this->actingAs($this->user)
            ->post(route('payment.store'), [
                'course_id' => $this->course->id,
                'track' => 'verified',
                'first_name' => 'John',
                'last_name' => 'Doe',
                'country' => 'Indonesia',
                'card_number' => '5425233010103010',  // Mastercard
                'card_expiry' => '12/25',
                'card_cvc' => '123',
            ]);

        $this->assertDatabaseHas('payments', [
            'card_brand' => 'mastercard',
        ]);
    }

    /** @test */
    public function payment_creates_transaction_id()
    {
        $this->actingAs($this->user)
            ->post(route('payment.store'), [
                'course_id' => $this->course->id,
                'track' => 'verified',
                'first_name' => 'John',
                'last_name' => 'Doe',
                'country' => 'Indonesia',
                'card_number' => '4532015112830366',
                'card_expiry' => '12/25',
                'card_cvc' => '123',
            ]);

        $payment = Payment::where('user_id', $this->user->id)->first();
        $this->assertNotNull($payment->transaction_id);
        $this->assertStringStartsWith('CRS-', $payment->transaction_id);
    }

    /** @test */
    public function user_already_verified_enrollment_cannot_payment()
    {
        Enrollment::factory()->create([
            'user_id' => $this->user->id,
            'course_id' => $this->course->id,
            'type' => 'verified',
            'status' => 'active',
        ]);

        $response = $this->actingAs($this->user)
            ->post(route('payment.store'), [
                'course_id' => $this->course->id,
                'track' => 'verified',
                'first_name' => 'John',
                'last_name' => 'Doe',
                'country' => 'Indonesia',
                'card_number' => '4532015112830366',
                'card_expiry' => '12/25',
                'card_cvc' => '123',
            ]);

        $response->assertRedirect();
    }

    /** @test */
    public function payment_uses_transaction()
    {
        // If an error occurs during payment, data should not be partially saved
        $this->actingAs($this->user)
            ->post(route('payment.store'), [
                'course_id' => $this->course->id,
                'track' => 'verified',
                'first_name' => 'John',
                'last_name' => 'Doe',
                'country' => 'Indonesia',
                'card_number' => '4532015112830366',
                'card_expiry' => '12/25',
                'card_cvc' => '123',
            ]);

        $payment = Payment::where('user_id', $this->user->id)->first();
        $enrollment = Enrollment::where('user_id', $this->user->id)->first();

        // Both should exist together (atomicity)
        $this->assertNotNull($payment);
        $this->assertNotNull($enrollment);
        $this->assertEquals($payment->id, $enrollment->payment_id);
    }
}
