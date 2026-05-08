<?php

namespace App\Events;

use App\Models\Enrollment;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class NewEnrollment implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public $enrollment;

    public function __construct(Enrollment $enrollment)
    {
        $this->enrollment = $enrollment;
    }

    public function broadcastOn()
    {
        return new Channel('instructor.' . $this->enrollment->course->instructor_id);
    }

    public function broadcastWith()
    {
        return [
            'student_name' => $this->enrollment->user->name,
            'course_title' => $this->enrollment->course->title,
            'created_at' => $this->enrollment->created_at->diffForHumans(),
        ];
    }
}
