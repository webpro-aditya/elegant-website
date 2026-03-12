@section('meta_title', 'Thank You – Elegant Training Center')
@section('meta_description', 'Your enquiry has been submitted successfully. Our team will contact you shortly.')
@section('title', 'Thank You')
@section('canonical', url()->current())
@push('script')
    <script src="{{ mix('/js/web/course/courseList.js') }}"></script>
@endpush
<x-web-layout>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Inter:wght@400;500;600&display=swap');
    
    .thank-you-container {
        background: #0F75BC;
        min-height: 70vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem 1rem;
        position: relative;
        overflow: hidden;
        padding: 350px 0;
    }

    .btn.btn-primary {
        background: #0F75BC !important;
        color: #fff;
        display: flex;
        justify-content: center;
        gap: 10px;
    }
    
    .thank-you-container::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: 
            radial-gradient(circle at 20% 50%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
            radial-gradient(circle at 80% 80%, rgba(255, 255, 255, 0.1) 0%, transparent 50%);
        animation: pulse 8s ease-in-out infinite;
    }
    
    @keyframes pulse {
        0%, 100% { opacity: 0.5; }
        50% { opacity: 1; }
    }
    
    .thank-you-card {
        background: white;
        border-radius: 24px;
        box-shadow: 
            0 20px 60px rgba(0, 0, 0, 0.3),
            0 0 0 1px rgba(255, 255, 255, 0.1);
        max-width: 600px;
        width: 100%;
        padding: 3rem 2rem;
        text-align: center;
        position: relative;
        z-index: 1;
        animation: slideUp 0.6s ease-out;
    }
    
    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .success-icon {
        width: 80px;
        height: 80px;
        margin: 0 auto 1.5rem;
        background: #EC1C24;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        animation: scaleIn 0.5s ease-out 0.2s both;
        position: relative;
    }
    
    .success-icon::after {
        content: '';
        position: absolute;
        width: 100%;
        height: 100%;
        border-radius: 50%;
        border: 3px solid #EC1C24;
        animation: ripple 1.5s ease-out infinite;
    }
    
    @keyframes scaleIn {
        from {
            transform: scale(0);
        }
        to {
            transform: scale(1);
        }
    }
    
    @keyframes ripple {
        0% {
            transform: scale(1);
            opacity: 1;
        }
        100% {
            transform: scale(1.5);
            opacity: 0;
        }
    }
    
    .checkmark {
        width: 40px;
        height: 40px;
        stroke: white;
        stroke-width: 3;
        stroke-linecap: round;
        fill: none;
        animation: drawCheck 0.5s ease-out 0.4s both;
    }
    
    @keyframes drawCheck {
        0% {
            stroke-dasharray: 0, 100;
        }
        100% {
            stroke-dasharray: 100, 0;
        }
    }
    
    .thank-you-title {
        font-size: 2rem;
        font-weight: 700;
        color: #1a202c;
        margin-bottom: 0.75rem;
        animation: fadeIn 0.6s ease-out 0.3s both;
        line-height: 1.2;
    }
    
    .thank-you-message {
        color: #4a5568;
        font-size: 1rem;
        line-height: 1.6;
        margin-bottom: 2rem;
        animation: fadeIn 0.6s ease-out 0.4s both;
    }
    
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .info-box {
        background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%);
        border-left: 4px solid #667eea;
        border-radius: 12px;
        padding: 1.25rem;
        margin-bottom: 2rem;
        text-align: left;
        animation: fadeIn 0.6s ease-out 0.5s both;
    }
    
    .info-item {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 0.75rem;
        color: #2d3748;
        font-size: 0.95rem;
    }
    
    .info-item:last-child {
        margin-bottom: 0;
    }
    
    .info-item-icon {
        font-size: 1.5rem;
        flex-shrink: 0;
    }
    
    .cta-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 0.875rem;
        margin-bottom: 1.5rem;
        animation: fadeIn 0.6s ease-out 0.6s both;
    }
    
    @media (min-width: 640px) {
        .cta-grid {
            grid-template-columns: 1fr 1fr;
        }
    }
    
    .btn {
        padding: 0.875rem 1.5rem;
        border-radius: 12px;
        font-weight: 600;
        font-size: 0.95rem;
        text-decoration: none;
        display: inline-block;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }
    
    .btn::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.3);
        transform: translate(-50%, -50%);
        transition: width 0.6s, height 0.6s;
    }
    
    .btn:hover::before {
        width: 300px;
        height: 300px;
    }
    
    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
    }
    
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.5);
    }
    
    .btn-secondary {
        background: white;
        color: #667eea;
        border: 2px solid #667eea;
    }
    
    .btn-secondary:hover {
        background: #667eea;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
    }
    
    .btn-whatsapp {
        background: linear-gradient(135deg, #25d366 0%, #128c7e 100%);
        color: white;
        border: none;
        box-shadow: 0 4px 15px rgba(37, 211, 102, 0.4);
    }
    
    .btn-whatsapp:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(37, 211, 102, 0.5);
    }
    
    .btn-outline {
        background: white;
        color: #4a5568;
        border: 2px solid #e2e8f0;
    }
    
    .btn-outline:hover {
        background: #f7fafc;
        border-color: #cbd5e0;
        transform: translateY(-2px);
    }
    
    .footer-text {
        color: #718096;
        font-size: 0.875rem;
        animation: fadeIn 0.6s ease-out 0.7s both;
    }
    
    .countdown-text {
        color: #667eea;
        font-weight: 600;
    }
    
    /* Mobile optimizations */
    @media (max-width: 640px) {
        .thank-you-card {
            padding: 2rem 1.5rem;
        }
        
        .thank-you-title {
            font-size: 1.75rem;
        }
        
        .success-icon {
            width: 70px;
            height: 70px;
        }
        
        .checkmark {
            width: 35px;
            height: 35px;
        }
    }
    
    /* Decorative elements */
    .decorative-circle {
        position: absolute;
        border-radius: 50%;
        opacity: 0.1;
    }
    
    .circle-1 {
        width: 300px;
        height: 300px;
        background: white;
        top: -150px;
        right: -100px;
        animation: float 6s ease-in-out infinite;
    }
    
    .circle-2 {
        width: 200px;
        height: 200px;
        background: white;
        bottom: -100px;
        left: -50px;
        animation: float 8s ease-in-out infinite reverse;
    }
    
    @keyframes float {
        0%, 100% {
            transform: translateY(0) rotate(0deg);
        }
        50% {
            transform: translateY(-20px) rotate(5deg);
        }
    }
</style>

<div class="thank-you-container">
    <div class="decorative-circle circle-1"></div>
    <div class="decorative-circle circle-2"></div>
    
    <div class="thank-you-card">
        <!-- Success Icon -->
        <div class="success-icon">
            <svg class="checkmark" viewBox="0 0 52 52">
                <path d="M14 27l8 8 16-16" />
            </svg>
        </div>

        <!-- Title -->
        <h1 class="thank-you-title">
            Enquiry Submitted Successfully!
        </h1>

        <!-- Message -->
        <p class="thank-you-message">
            Thank you for contacting <strong>Elegant Training Center</strong>. 
            Our academic counselor will reach out to you shortly to assist you with the best course options tailored to your needs.
        </p>

        <!-- Info Box -->
        <div class="info-box">
            <div class="info-item">
                <span class="info-item-icon">⏱️</span>
                <div>
                    We'll contact you soon.
                </div>
            </div>
            <div class="info-item">
                <span class="info-item-icon">📞</span>
                <div>
                    Please keep your phone available for our call
                </div>
            </div>
        </div>

        <!-- CTA Buttons -->
        <div class="cta-grid">
            <a href="/en/course-list" class="btn btn-primary">
                <span class="btn-icon">📚</span>
                Explore Courses
            </a>

            <a href="/en/training-calander" class="btn btn-secondary">
                <span class="btn-icon">📅</span>
                Upcoming Batches
            </a>

            <a href="https://wa.me/971547495664" target="_blank" rel="noopener noreferrer" class="btn btn-whatsapp">
                <span class="btn-icon">💬</span>
                Chat on WhatsApp
            </a>

            <a href="/" class="btn btn-outline">
                <span class="btn-icon">🏠</span>
                Return Home
            </a>
        </div>

        <!-- Footer Text -->
        <p class="footer-text">
            Feel free to continue exploring our website.
            <span id="countdownText" class="countdown-text" style="display: none;">
                <br>Redirecting to homepage in <span id="timer">15</span> seconds...
            </span>
        </p>
    </div>
</div>
</x-web-layout>

<!-- AUTO-REDIRECT SCRIPT -->
@push('script')
<script>
(function() {
    let seconds = 15;
    const timer = document.getElementById('timer');
    const countdownText = document.getElementById('countdownText');
    
    // Enable auto-redirect by uncommenting the line below
    // countdownText.style.display = 'inline';
    
    if (timer && countdownText && countdownText.style.display !== 'none') {
        const interval = setInterval(() => {
            seconds--;
            timer.textContent = seconds;
            if (seconds <= 0) {
                clearInterval(interval);
                window.location.href = "/";
            }
        }, 1000);
    }
})();
</script>   
@endpush
