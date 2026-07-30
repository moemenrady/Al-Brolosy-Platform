@extends('layouts.app')

@section('title', 'Contact Us')

@section('content')
<div class="contact-container">
    <h1 class="page-title">Contact Us</h1>

    {{-- Social Media Icons --}}
    <div class="social-icons">
        {{-- تأكد من استبدال # بروابط حساباتك الفعلية --}}
        <a href="https://www.instagram.com/hijabk_hena" target="_blank" class="icon-link instagram">
            <i class="fab fa-instagram"></i>
        </a>
        <a href="https://www.facebook.com/share/1S51MWNXd7/" target="_blank" class="icon-link facebook">
            <i class="fab fa-facebook-f"></i>
        </a>
        {{-- استبدل 201000000000 برقم الواتساب الخاص بك مع رمز الدولة (بدون +) --}}
        <a href="https://wa.me/201094619040" target="_blank" class="icon-link whatsapp">
            <i class="fab fa-whatsapp"></i>
        </a>
    </div>
    
    <p class="section-description">
        Feel free to reach out to us through social media or send us a direct message below.
    </p>

    {{-- Contact Form --}}
    <div class="contact-form-wrapper">
        <form action="{{ route('contact.send') }}" method="POST" class="contact-form">
            @csrf
            
            @if(session('success'))
                <div class="alert success-alert">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert error-alert">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="form-group">
                <label for="name">Your Name (Optional)</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}">
            </div>

            <div class="form-group">
                <label for="email">Your Email <span class="required">*</span></label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required>
            </div>

            <div class="form-group">
                <label for="message">Your Message <span class="required">*</span></label>
                <textarea id="message" name="message" rows="5" required>{{ old('message') }}</textarea>
            </div>

            <button type="submit" class="submit-btn">Send Message</button>
        </form>
    </div>

</div>
@endsection

@section('style')
{{-- Include Font Awesome for icons (يمكنك إضافتها في الـ layout إذا كانت تستخدم في كل مكان) --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
<style>
    /* General Contact Page Styling */
    .contact-container {
        max-width: 800px;
        margin: 0 auto;
        padding: 40px 20px;
        text-align: center;
    }

    .page-title {
        font-size: 32px;
        font-weight: 700;
        color: var(--text-color);
        margin-bottom: 25px;
        border-bottom: 2px solid var(--primary-color);
        display: inline-block;
        padding-bottom: 5px;
    }
    
    .section-description {
        color: var(--light-text-color);
        margin-bottom: 30px;
        font-size: 16px;
    }

    /* Social Icons Styling */
    .social-icons {
        margin-bottom: 30px;
        display: flex;
        justify-content: center;
        gap: 25px;
    }

    .icon-link {
        font-size: 28px;
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        color: white;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .icon-link:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    /* Specific Icon Colors (Matching the provided theme) */
    .instagram { background-color: #d7a7a4; } /* Primary Color */
    .facebook { background-color: #624641; } /* Text Color */
    .whatsapp { background-color: #9c7b74; } /* Light Text Color */

    /* Form Styling */
    .contact-form-wrapper {
        background: white;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        text-align: left;
    }
    
    .contact-form {
        display: grid;
        gap: 15px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: var(--text-color);
        font-size: 14px;
    }

    .form-group input[type="text"],
    .form-group input[type="email"],
    .form-group textarea {
        width: 100%;
        padding: 12px;
        border: 1px solid #ddd;
        border-radius: 4px;
        box-sizing: border-box;
        font-size: 16px;
        color: var(--text-color);
        background-color: var(--bg-color); /* Light background for inputs */
        transition: border-color 0.3s ease;
    }

    .form-group input:focus,
    .form-group textarea:focus {
        border-color: var(--primary-color);
        outline: none;
        box-shadow: 0 0 0 3px rgba(215, 167, 164, 0.2);
    }

    .form-group textarea {
        resize: vertical;
    }

    .submit-btn {
        background-color: var(--primary-color);
        color: white;
        padding: 12px 25px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
        font-weight: 600;
        transition: background-color 0.3s ease, transform 0.1s ease;
        justify-self: start; /* Start alignment for button */
    }

    .submit-btn:hover {
        background-color: #c98c89; /* A slightly darker shade */
    }
    
    /* Alerts Styling */
    .alert {
        padding: 15px;
        border-radius: 4px;
        margin-bottom: 20px;
        font-size: 15px;
    }
    .success-alert {
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }
    .error-alert {
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }
    
    .required {
        color: #e74c3c;
    }
</style>
@endsection