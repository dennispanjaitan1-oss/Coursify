<?php

namespace App\Events;

use App\Models\Review;
use App\Events\NewReviewCreated;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class NewReviewCreated implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public $review;

    public function __construct(Review $review)
    {
        $this->review = $review;
    }

    public function broadcastOn()
    {
        return new Channel('instructor.' . $this->review->course->instructor_id);
    }

    public function broadcastWith()
    {
        return [
            'user_name' => $this->review->user->name,
            'course_title' => $this->review->course->title,
            'rating' => $this->review->rating,
            'comment' => $this->review->comment,
            'created_at' => $this->review->created_at->diffForHumans(),
        ];
    }

    public function submitReview(Request $request, Course $course)
{
    $request->validate([
        'rating'  => 'required|integer|min:1|max:5',
        'comment' => 'nullable|string|max:1000',
    ]);

    $review = Review::updateOrCreate(
        ['user_id' => auth()->id(), 'course_id' => $course->id],
        ['rating' => $request->rating, 'comment' => $request->comment]
    );

    // Broadcast event untuk real-time notification
    broadcast(new NewReviewCreated($review));

    return back()->with('success', 'Review submitted successfully!');
}

public function __construct(Review $review)
{
    $this->review = $review;
    \Log::info('NewReviewCreated event triggered for review ID: ' . $review->id);
}

}
