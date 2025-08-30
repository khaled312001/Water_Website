@extends('layouts.app')

@section('title', 'اتصل بنا - سلسبيل مكة')

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="display-4 fw-bold mb-4">اتصل بنا</h1>
                <p class="lead mb-4">
                    نحن هنا لمساعدتك. لا تتردد في التواصل معنا لأي استفسار أو طلب
                </p>
                <div class="d-flex gap-3">
                    <a href="tel:+966501234567" class="btn btn-light btn-lg">
                        <i class="fas fa-phone me-2"></i>
                        اتصل الآن
                    </a>
                    <a href="https://wa.me/966501234567" target="_blank" class="btn btn-success btn-lg">
                        <i class="fab fa-whatsapp me-2"></i>
                        واتساب
                    </a>
                </div>
            </div>
            <div class="col-lg-6 text-center">
                <img src="https://images.unsplash.com/photo-1559827260-dc66d52bef19?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" 
                     alt="اتصل بنا" class="img-fluid rounded-3 shadow-lg">
            </div>
        </div>
    </div>
</section>

<!-- Contact Content -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="card border-0 shadow-lg" data-aos="fade-up">
                    <div class="card-header bg-primary text-white">
                        <h3 class="mb-0">
                            <i class="fas fa-paper-plane me-2"></i>
                            أرسل لنا رسالة
                        </h3>
                    </div>
                    <div class="card-body p-5">
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="fas fa-check-circle me-2"></i>
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('contact.submit') }}" id="contactForm">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label fw-bold">
                                        <i class="fas fa-user me-1"></i>
                                        الاسم الكامل
                                    </label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           id="name" name="name" value="{{ old('name') }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label fw-bold">
                                        <i class="fas fa-envelope me-1"></i>
                                        البريد الإلكتروني
                                    </label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                           id="email" name="email" value="{{ old('email') }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="phone" class="form-label fw-bold">
                                    <i class="fas fa-phone me-1"></i>
                                    رقم الهاتف
                                </label>
                                <input type="tel" class="form-control @error('phone') is-invalid @enderror" 
                                       id="phone" name="phone" value="{{ old('phone') }}" required>
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="subject" class="form-label fw-bold">
                                    <i class="fas fa-tag me-1"></i>
                                    الموضوع
                                </label>
                                <select class="form-select @error('subject') is-invalid @enderror" 
                                        id="subject" name="subject" required>
                                    <option value="">اختر الموضوع</option>
                                    @foreach(App\Models\Contact::getSubjectOptions() as $key => $value)
                                        <option value="{{ $key }}" {{ old('subject') == $key ? 'selected' : '' }}>
                                            {{ $value }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('subject')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label for="message" class="form-label fw-bold">
                                    <i class="fas fa-comment me-1"></i>
                                    الرسالة
                                </label>
                                <textarea class="form-control @error('message') is-invalid @enderror" 
                                          id="message" name="message" rows="5" 
                                          placeholder="اكتب رسالتك هنا..." required>{{ old('message') }}</textarea>
                                <div class="form-text">
                                    <span id="charCount">0</span> / 2000 حرف
                                </div>
                                @error('message')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg" id="submitBtn">
                                    <i class="fas fa-paper-plane me-2"></i>
                                    إرسال الرسالة
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card border-0 shadow-lg" data-aos="fade-up" data-aos-delay="200">
                    <div class="card-header bg-info text-white">
                        <h4 class="mb-0">
                            <i class="fas fa-info-circle me-2"></i>
                            معلومات التواصل
                        </h4>
                    </div>
                    <div class="card-body p-4">
                        <div class="contact-item mb-4">
                            <div class="d-flex align-items-center mb-2">
                                <div class="contact-icon bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" 
                                     style="width: 50px; height: 50px;">
                                    <i class="fas fa-phone"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1 fw-bold">الهاتف</h6>
                                    <p class="mb-0 text-muted">+966 50 123 4567</p>
                                </div>
                            </div>
                            <a href="tel:+966501234567" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-phone me-1"></i>
                                اتصل الآن
                            </a>
                        </div>

                        <div class="contact-item mb-4">
                            <div class="d-flex align-items-center mb-2">
                                <div class="contact-icon bg-success text-white rounded-circle d-flex align-items-center justify-content-center me-3" 
                                     style="width: 50px; height: 50px;">
                                    <i class="fab fa-whatsapp"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1 fw-bold">واتساب</h6>
                                    <p class="mb-0 text-muted">+966 50 123 4567</p>
                                </div>
                            </div>
                            <a href="https://wa.me/966501234567" target="_blank" class="btn btn-outline-success btn-sm">
                                <i class="fab fa-whatsapp me-1"></i>
                                راسلنا على واتساب
                            </a>
                        </div>

                        <div class="contact-item mb-4">
                            <div class="d-flex align-items-center mb-2">
                                <div class="contact-icon bg-warning text-white rounded-circle d-flex align-items-center justify-content-center me-3" 
                                     style="width: 50px; height: 50px;">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1 fw-bold">البريد الإلكتروني</h6>
                                    <p class="mb-0 text-muted">info@makkah-water.com</p>
                                </div>
                            </div>
                            <a href="mailto:info@makkah-water.com" class="btn btn-outline-warning btn-sm">
                                <i class="fas fa-envelope me-1"></i>
                                أرسل بريد إلكتروني
                            </a>
                        </div>

                        <div class="contact-item mb-4">
                            <div class="d-flex align-items-center mb-2">
                                <div class="contact-icon bg-danger text-white rounded-circle d-flex align-items-center justify-content-center me-3" 
                                     style="width: 50px; height: 50px;">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1 fw-bold">العنوان</h6>
                                    <p class="mb-0 text-muted">مكة المكرمة، المملكة العربية السعودية</p>
                                </div>
                            </div>
                        </div>

                        <div class="contact-item mb-4">
                            <div class="d-flex align-items-center mb-2">
                                <div class="contact-icon bg-info text-white rounded-circle d-flex align-items-center justify-content-center me-3" 
                                     style="width: 50px; height: 50px;">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1 fw-bold">ساعات العمل</h6>
                                    <p class="mb-1 text-muted small">الأحد - الخميس: 8:00 ص - 8:00 م</p>
                                    <p class="mb-1 text-muted small">الجمعة - السبت: 9:00 ص - 6:00 م</p>
                                    <p class="mb-0 text-success small fw-bold">خدمة التوصيل: 24/7</p>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <h6 class="fw-bold mb-3">تابعنا</h6>
                        <div class="d-flex gap-2">
                            <a href="#" class="btn btn-outline-primary" title="فيسبوك">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="#" class="btn btn-outline-info" title="تويتر">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="#" class="btn btn-outline-danger" title="إنستغرام">
                                <i class="fab fa-instagram"></i>
                            </a>
                            <a href="#" class="btn btn-outline-success" title="يوتيوب">
                                <i class="fab fa-youtube"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="display-5 fw-bold">الأسئلة الشائعة</h2>
            <p class="lead text-muted">إجابات على أكثر الأسئلة شيوعاً</p>
        </div>
        
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="accordion" id="faqAccordion">
                    <div class="accordion-item border-0 shadow-sm mb-3">
                        <h2 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                <i class="fas fa-question-circle text-primary me-2"></i>
                                كيف يمكنني طلب المياه؟
                            </button>
                        </h2>
                        <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                يمكنك طلب المياه بسهولة من خلال تصفح المنتجات المتاحة، اختيار الكمية المطلوبة، وإدخال عنوان التوصيل. سيتم توصيل طلبك خلال ساعات قليلة.
                            </div>
                        </div>
                    </div>
                    
                    <div class="accordion-item border-0 shadow-sm mb-3">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                <i class="fas fa-credit-card text-primary me-2"></i>
                                ما هي طرق الدفع المتاحة؟
                            </button>
                        </h2>
                        <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                نقبل الدفع نقداً عند التوصيل، أو عبر البطاقات الائتمانية، أو التحويل البنكي الإلكتروني.
                            </div>
                        </div>
                    </div>
                    
                    <div class="accordion-item border-0 shadow-sm mb-3">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                <i class="fas fa-truck text-primary me-2"></i>
                                كم تستغرق مدة التوصيل؟
                            </button>
                        </h2>
                        <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                عادةً ما يتم التوصيل خلال 2-4 ساعات من وقت الطلب. في أوقات الذروة قد تستغرق مدة أطول قليلاً.
                            </div>
                        </div>
                    </div>
                    
                    <div class="accordion-item border-0 shadow-sm mb-3">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq4">
                                <i class="fas fa-shield-alt text-primary me-2"></i>
                                هل المياه مضمونة الجودة؟
                            </button>
                        </h2>
                        <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                نعم، جميع منتجاتنا مضمونة الجودة من موردين معتمدين ومرخصين. إذا لم تكن راضياً عن الجودة، سنقوم باستبدال المنتج أو استرداد المبلغ.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item border-0 shadow-sm mb-3">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq5">
                                <i class="fas fa-undo text-primary me-2"></i>
                                هل يمكنني إلغاء الطلب؟
                            </button>
                        </h2>
                        <div id="faq5" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                نعم، يمكنك إلغاء الطلب قبل بدء التجهيز. للاستفسار عن إمكانية الإلغاء، يرجى التواصل معنا فوراً.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.contact-item {
    transition: all 0.3s ease;
}

.contact-item:hover {
    transform: translateY(-2px);
}

.contact-icon {
    transition: all 0.3s ease;
}

.contact-item:hover .contact-icon {
    transform: scale(1.1);
}

.accordion-button:not(.collapsed) {
    background-color: var(--primary-color);
    color: white;
}

.accordion-button:focus {
    box-shadow: 0 0 0 0.25rem rgba(30, 58, 138, 0.25);
}

.form-control:focus, .form-select:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 0.2rem rgba(30, 58, 138, 0.25);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const messageTextarea = document.getElementById('message');
    const charCount = document.getElementById('charCount');
    const submitBtn = document.getElementById('submitBtn');
    const contactForm = document.getElementById('contactForm');

    // Character counter
    messageTextarea.addEventListener('input', function() {
        const count = this.value.length;
        charCount.textContent = count;
        
        if (count > 1800) {
            charCount.style.color = '#dc3545';
        } else if (count > 1500) {
            charCount.style.color = '#ffc107';
        } else {
            charCount.style.color = '#6c757d';
        }
    });

    // Form submission
    contactForm.addEventListener('submit', function() {
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>جاري الإرسال...';
        submitBtn.disabled = true;
    });

    // Phone number formatting
    const phoneInput = document.getElementById('phone');
    phoneInput.addEventListener('input', function() {
        let value = this.value.replace(/\D/g, '');
        if (value.startsWith('966')) {
            value = '+' + value;
        } else if (value.startsWith('0')) {
            value = '+966' + value.substring(1);
        } else if (value.length > 0 && !value.startsWith('+')) {
            value = '+966' + value;
        }
        this.value = value;
    });
});
</script>
@endsection 