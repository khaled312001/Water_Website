@extends('layouts.app')

@section('title', 'اتصل بنا - مياه مكة')

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
                <div class="card">
                    <div class="card-body">
                        <h2 class="mb-4">أرسل لنا رسالة</h2>
                        <form>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label">الاسم الكامل</label>
                                    <input type="text" class="form-control" id="name" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">البريد الإلكتروني</label>
                                    <input type="email" class="form-control" id="email" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="phone" class="form-label">رقم الهاتف</label>
                                <input type="tel" class="form-control" id="phone" required>
                            </div>
                            <div class="mb-3">
                                <label for="subject" class="form-label">الموضوع</label>
                                <select class="form-select" id="subject" required>
                                    <option value="">اختر الموضوع</option>
                                    <option value="general">استفسار عام</option>
                                    <option value="order">مشكلة في الطلب</option>
                                    <option value="delivery">مشكلة في التوصيل</option>
                                    <option value="quality">مشكلة في الجودة</option>
                                    <option value="suggestion">اقتراح</option>
                                    <option value="complaint">شكوى</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="message" class="form-label">الرسالة</label>
                                <textarea class="form-control" id="message" rows="5" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-paper-plane me-2"></i>
                                إرسال الرسالة
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <h3 class="mb-4">معلومات التواصل</h3>
                        
                        <div class="d-flex mb-4">
                            <div class="flex-shrink-0">
                                <i class="fas fa-phone text-primary fs-4"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h5>الهاتف</h5>
                                <p class="mb-1">+966 50 123 4567</p>
                                <p class="mb-0">+966 12 345 6789</p>
                            </div>
                        </div>

                        <div class="d-flex mb-4">
                            <div class="flex-shrink-0">
                                <i class="fas fa-envelope text-primary fs-4"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h5>البريد الإلكتروني</h5>
                                <p class="mb-1">info@makkah-water.com</p>
                                <p class="mb-0">support@makkah-water.com</p>
                            </div>
                        </div>

                        <div class="d-flex mb-4">
                            <div class="flex-shrink-0">
                                <i class="fas fa-map-marker-alt text-primary fs-4"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h5>العنوان</h5>
                                <p class="mb-0">مكة المكرمة، المملكة العربية السعودية</p>
                            </div>
                        </div>

                        <div class="d-flex mb-4">
                            <div class="flex-shrink-0">
                                <i class="fas fa-clock text-primary fs-4"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h5>ساعات العمل</h5>
                                <p class="mb-1">الأحد - الخميس: 8:00 ص - 8:00 م</p>
                                <p class="mb-1">الجمعة - السبت: 9:00 ص - 6:00 م</p>
                                <p class="mb-0">خدمة التوصيل: 24/7</p>
                            </div>
                        </div>

                        <h5 class="mb-3">تابعنا</h5>
                        <div class="d-flex gap-2">
                            <a href="#" class="btn btn-outline-primary">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="#" class="btn btn-outline-primary">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="#" class="btn btn-outline-primary">
                                <i class="fab fa-instagram"></i>
                            </a>
                            <a href="#" class="btn btn-outline-primary">
                                <i class="fab fa-whatsapp"></i>
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
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                كيف يمكنني طلب المياه؟
                            </button>
                        </h2>
                        <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                يمكنك طلب المياه بسهولة من خلال تصفح المنتجات المتاحة، اختيار الكمية المطلوبة، وإدخال عنوان التوصيل. سيتم توصيل طلبك خلال ساعات قليلة.
                            </div>
                        </div>
                    </div>
                    
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                ما هي طرق الدفع المتاحة؟
                            </button>
                        </h2>
                        <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                نقبل الدفع نقداً عند التوصيل، أو عبر البطاقات الائتمانية، أو التحويل البنكي الإلكتروني.
                            </div>
                        </div>
                    </div>
                    
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                كم تستغرق مدة التوصيل؟
                            </button>
                        </h2>
                        <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                عادةً ما يتم التوصيل خلال 2-4 ساعات من وقت الطلب. في أوقات الذروة قد تستغرق مدة أطول قليلاً.
                            </div>
                        </div>
                    </div>
                    
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq4">
                                هل المياه مضمونة الجودة؟
                            </button>
                        </h2>
                        <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                نعم، جميع منتجاتنا مضمونة الجودة من موردين معتمدين ومرخصين. إذا لم تكن راضياً عن الجودة، سنقوم باستبدال المنتج أو استرداد المبلغ.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection 