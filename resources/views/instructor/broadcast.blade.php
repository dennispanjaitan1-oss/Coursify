@extends('layouts.instructor')

@section('title', 'Broadcast Message')

@section('content')

    {{-- TOP BAR --}}
    <header class="topbar" role="banner">
        <div class="topbar__search">
            <i class="fa-solid fa-magnifying-glass topbar__search-icon" aria-hidden="true"></i>
            <label for="search" class="sr-only">Search</label>
            <input type="text"
                   id="search"
                   class="topbar__search-input"
                   placeholder="Search..."
                   aria-label="Search">
        </div>

        <div class="topbar__actions">
            <button class="icon-btn"
                    aria-label="Notifications - 2 new"
                    title="Notifications">
                <i class="fa-solid fa-bell" aria-hidden="true"></i>
                <span class="icon-btn__dot" aria-hidden="true"></span>
            </button>
        </div>
    </header>

    {{-- PAGE TITLE --}}
    <section class="page-header" aria-label="Page title">
        <div>
            <h1 class="page-title">Broadcast Message</h1>
            <p class="page-subtitle">Send announcement to your students</p>
        </div>
    </section>

    {{-- BROADCAST FORM --}}
    <section class="card-wrap" aria-labelledby="broadcast-form-title">
        <div class="card-head">
            <h2 class="card-title" id="broadcast-form-title">Send Announcement</h2>
        </div>

        <form method="POST" class="broadcast-form">
            @csrf
            
            <div class="form-group">
                <label for="broadcast-type" class="form-label">Send To *</label>
                <select id="broadcast-type" name="broadcast_type" class="form-control" required>
                    <option value="">-- Select recipients --</option>
                    <option value="all">All Students</option>
                    <option value="course">Specific Course</option>
                    <option value="individual">Individual Student</option>
                </select>
            </div>

            <div class="form-group" id="course-select-group" style="display: none;">
                <label for="course-select" class="form-label">Select Course *</label>
                <select id="course-select" name="course_id" class="form-control">
                    <option value="">-- Choose a course --</option>
                    <option value="">Web Development 101</option>
                    <option value="">PHP Fundamentals</option>
                    <option value="">Laravel Mastery</option>
                </select>
            </div>

            <div class="form-group">
                <label for="subject" class="form-label">Subject *</label>
                <input type="text" id="subject" name="subject" class="form-control" placeholder="e.g., New lesson available!" required>
            </div>

            <div class="form-group">
                <label for="message" class="form-label">Message *</label>
                <textarea id="message" name="message" class="form-control" rows="8" placeholder="Write your announcement here..." required></textarea>
                <div class="form-hint">{{ 0 }} / 1000 characters</div>
            </div>

            <div class="form-group">
                <label class="checkbox-option">
                    <input type="checkbox" name="include_email" value="1">
                    Also send as email notification
                </label>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-primary">
                    <i class="fa-solid fa-paper-plane" aria-hidden="true"></i>
                    Send Announcement
                </button>
                <a href="{{ route('instructor.dashboard') }}" class="btn-secondary">Cancel</a>
            </div>
        </form>
    </section>

    {{-- RECENT BROADCASTS --}}
    <section class="card-wrap" aria-labelledby="recent-broadcasts-title">
        <div class="card-head">
            <h2 class="card-title" id="recent-broadcasts-title">Recent Announcements</h2>
        </div>

        <div class="empty-state" role="status">
            <div class="empty-state__icon">
                <i class="fa-regular fa-bell"></i>
            </div>
            <h3 class="empty-state__title">No announcements sent yet</h3>
            <p class="empty-state__desc">Your announcements will appear here.</p>
        </div>
    </section>

@endsection
