<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Create audit logging tables for tracking changes and system events
     */
    public function up(): void
    {
        // ──────────────────────────────────────── COURSE ACTIVITY LOG ───────────────────────────────────────
        // Track all changes to courses: creation, updates, publishing, deletion
        Schema::create('course_activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            
            // Action: 'created', 'updated', 'published', 'unpublished', 'deleted', 'restored'
            $table->string('action', 50);
            
            // Store old and new values as JSON for change tracking
            $table->json('old_data')->nullable();
            $table->json('new_data')->nullable();
            
            // Which specific fields were changed
            $table->json('changed_fields')->nullable();
            
            // Request context
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            
            // Audit trail info
            $table->string('performed_by', 50)->nullable();  // 'instructor', 'admin', 'system'
            $table->text('reason')->nullable();  // Why the change was made
            
            $table->timestamps();
            
            // Indexes for quick queries
            $table->index('course_id');
            $table->index('user_id');
            $table->index('action');
            $table->index('created_at');
            $table->index(['course_id', 'created_at']);
        });

        // ──────────────────────────────────────── ENROLLMENT HISTORY ───────────────────────────────────────
        // Track enrollment status changes and events
        Schema::create('enrollment_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('enrollment_id')->constrained()->onDelete('cascade');
            
            // Status transition
            $table->string('status_from', 50)->nullable();  // 'active', 'completed', 'refunded'
            $table->string('status_to', 50);
            
            // Progress tracking
            $table->decimal('progress_from', 5, 2)->nullable();
            $table->decimal('progress_to', 5, 2)->nullable();
            
            // Why the change happened
            $table->string('reason', 100)->nullable();  // 'manual_update', 'auto_completion', 'refund_requested', etc
            
            // Who made the change
            $table->foreignId('changed_by')->nullable()->constrained('users')->onDelete('set null');
            
            // Additional context
            $table->text('notes')->nullable();
            
            $table->timestamps();
            
            // Indexes
            $table->index('enrollment_id');
            $table->index('status_to');
            $table->index('created_at');
            $table->index(['enrollment_id', 'created_at']);
        });

        // ──────────────────────────────────────── USER ACTIVITY LOG ───────────────────────────────────────
        // Track user actions: login, profile updates, course interactions
        Schema::create('user_activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Activity type: 'login', 'logout', 'profile_update', 'course_viewed', 'lesson_completed', etc
            $table->string('activity_type', 50);
            
            // Related entities
            $table->string('entity_type', 50)->nullable();  // 'course', 'lesson', 'quiz'
            $table->unsignedBigInteger('entity_id')->nullable();
            
            // Details
            $table->json('data')->nullable();  // Additional context
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            
            // Device info for better analytics
            $table->string('device_type', 50)->nullable();  // 'mobile', 'tablet', 'desktop'
            $table->string('browser', 100)->nullable();
            
            $table->timestamps();
            
            // Indexes for analytics queries
            $table->index('user_id');
            $table->index('activity_type');
            $table->index('created_at');
            $table->index(['user_id', 'created_at']);
            $table->index(['entity_type', 'entity_id']);
        });

        // ──────────────────────────────────────── PAYMENT TRANSACTION LOG ───────────────────────────────────────
        // Track payment transitions and gateway interactions
        Schema::create('payment_transaction_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('payment_id')->constrained()->onDelete('cascade');
            
            // Transaction details
            $table->string('status_from', 50)->nullable();
            $table->string('status_to', 50);
            
            $table->string('gateway', 50)->nullable();  // 'midtrans', 'manual', 'stripe'
            $table->string('gateway_transaction_id', 100)->nullable();
            $table->string('gateway_response_code', 50)->nullable();
            
            // Amounts
            $table->decimal('amount', 12, 2)->nullable();
            $table->text('gateway_response')->nullable();  // Raw response from payment gateway
            
            // Error tracking
            $table->string('error_code', 50)->nullable();
            $table->text('error_message')->nullable();
            
            // Initiated by
            $table->string('initiated_by', 50)->nullable();  // 'user', 'admin', 'system', 'webhook'
            
            $table->timestamps();
            
            // Indexes
            $table->index('payment_id');
            $table->index('status_to');
            $table->index('gateway');
            $table->index('created_at');
        });

        // ──────────────────────────────────────── SYSTEM EVENT LOG ───────────────────────────────────────
        // Track system-wide events: migrations, failed jobs, errors, etc
        Schema::create('system_event_logs', function (Blueprint $table) {
            $table->id();
            
            // Event classification
            $table->string('event_type', 50);  // 'migration', 'job_failed', 'payment_error', 'cron_job', etc
            $table->string('severity', 20);  // 'info', 'warning', 'error', 'critical'
            
            // Message and details
            $table->string('message', 500);
            $table->json('data')->nullable();
            
            // Stack trace for errors
            $table->longText('stack_trace')->nullable();
            
            // Associated model (if applicable)
            $table->string('model_type', 100)->nullable();
            $table->unsignedBigInteger('model_id')->nullable();
            
            $table->timestamps();
            
            // Indexes for quick searches
            $table->index('event_type');
            $table->index('severity');
            $table->index('created_at');
            $table->index(['event_type', 'severity']);
        });

        // ──────────────────────────────────────── REVIEW MODERATION LOG ───────────────────────────────────────
        // Track review visibility changes and moderation actions
        Schema::create('review_moderation_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('review_id')->constrained()->onDelete('cascade');
            
            // Visibility change
            $table->boolean('is_visible_before')->nullable();
            $table->boolean('is_visible_after');
            
            // Action
            $table->string('action', 50);  // 'approved', 'rejected', 'hidden', 'flagged'
            $table->text('reason')->nullable();
            
            // Who took action
            $table->foreignId('moderated_by')->nullable()->constrained('users')->onDelete('set null');
            
            $table->timestamps();
            
            $table->index('review_id');
            $table->index('action');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('review_moderation_logs');
        Schema::dropIfExists('system_event_logs');
        Schema::dropIfExists('payment_transaction_logs');
        Schema::dropIfExists('user_activity_logs');
        Schema::dropIfExists('enrollment_history');
        Schema::dropIfExists('course_activity_logs');
    }
};
