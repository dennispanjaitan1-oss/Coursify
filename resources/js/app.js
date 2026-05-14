import './bootstrap';
import Alpine from 'alpinejs';
import focus from '@alpinejs/focus';

// Register Alpine plugins
Alpine.plugin(focus);
window.Alpine = Alpine;

// ═══════════════════════════════════════════════════════════════
// DASHBOARD COMPONENT — Stats Polling + Real-time WebSocket
// ═══════════════════════════════════════════════════════════════
Alpine.data('dashboard', () => ({
    // Stats data (AJAX Polling)
    publishedCount: 0,
    studentsCount: 0,
    avgRating: 0.0,

    // AJAX Polling data
enrollments: [],
reviews: [],
messages: [],

    init() {
    this.fetchStats();
    this.fetchReviews();
    this.fetchEnrollments();
    this.fetchMessages();

    setInterval(() => {
        this.fetchStats();
        this.fetchReviews();
        this.fetchEnrollments();
        this.fetchMessages();
    }, 30000);
},

    // ─── AJAX Polling Methods ───
    fetchStats() {
        fetch('/api/instructor/stats')
            .then(res => res.json())
            .then(data => {
                this.publishedCount = data.publishedCount;
                this.studentsCount = data.studentsCount;
                this.avgRating = data.avgRating.toFixed(1);
            })
            .catch(err => console.error('Error fetching stats:', err));
    },

    fetchReviews() {
    fetch('/api/instructor/reviews')
        .then(res => res.json())
        .then(data => { this.reviews = data; })
        .catch(err => console.error('Error fetching reviews:', err));
},

fetchEnrollments() {
    fetch('/api/instructor/enrollments')
        .then(res => res.json())
        .then(data => { this.enrollments = data; })
        .catch(err => console.error('Error fetching enrollments:', err));
},

fetchMessages() {
    fetch('/api/instructor/messages')
        .then(res => res.json())
        .then(data => { this.messages = data; })
        .catch(err => console.error('Error fetching messages:', err));
},
}));

Alpine.start();
