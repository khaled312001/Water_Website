@extends('layouts.app')

@section('title', 'سلسبيل مكة - توصيل المياه في مكة المكرمة')

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6" data-aos="fade-right">
                <h1 class="display-3 fw-bold mb-4">
                    <i class="fas fa-tint water-drop me-3"></i>
                    سلسبيل مكة
                </h1>
                <h2 class="h2 mb-4 fw-light">أفضل منصة لتوصيل المياه العذبة في مكة المكرمة</h2>
                <p class="lead mb-4 opacity-90">
                    نوصل لك المياه النقية والعذبة مباشرة لباب بيتك. 
                    تعامل مع أفضل الموردين وأسرع مندوبي التوصيل في مكة المكرمة.
                </p>
                <div class="d-flex flex-wrap gap-3">
                    <a href="{{ route('products.index') }}" class="btn btn-light btn-lg px-4 py-3">
                        <i class="fas fa-shopping-cart me-2"></i>
                        اطلب الآن
                    </a>
                    <a href="{{ route('about') }}" class="btn btn-outline-light btn-lg px-4 py-3">
                        <i class="fas fa-info-circle me-2"></i>
                        اعرف أكثر
                    </a>
                </div>
                
                <!-- Quick Stats -->
                <div class="row mt-5 pt-4">
                    <div class="col-4 text-center">
                        <div class="text-white">
                            <h4 class="fw-bold mb-1">{{ number_format($stats['total_products']) }}+</h4>
                            <small class="opacity-75">منتج متوفر</small>
                        </div>
                    </div>
                    <div class="col-4 text-center">
                        <div class="text-white">
                            <h4 class="fw-bold mb-1">{{ number_format($stats['total_suppliers']) }}+</h4>
                            <small class="opacity-75">مورد معتمد</small>
                        </div>
                    </div>
                    <div class="col-4 text-center">
                        <div class="text-white">
                            <h4 class="fw-bold mb-1">{{ number_format($stats['total_orders']) }}+</h4>
                            <small class="opacity-75">طلب مكتمل</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 text-center" data-aos="fade-left">
                <div class="position-relative">
                    <img src="https://images.unsplash.com/photo-1559827260-dc66d52bef19?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80" 
                         alt="مياه عذبة" class="img-fluid rounded-4 shadow-lg" style="max-height: 500px; width: 100%; object-fit: cover;">
                    
                    <!-- Floating Elements -->
                    <div class="position-absolute top-0 start-0 bg-white rounded-3 p-3 shadow-lg" style="transform: translate(-20px, -20px);">
                        <i class="fas fa-truck text-primary fs-4"></i>
                        <div class="small text-muted">توصيل سريع</div>
                    </div>
                    <div class="position-absolute bottom-0 end-0 bg-white rounded-3 p-3 shadow-lg" style="transform: translate(20px, 20px);">
                        <i class="fas fa-shield-alt text-success fs-4"></i>
                        <div class="small text-muted">جودة مضمونة</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="100">
                <div class="stats-card">
                    <div class="stats-number">{{ number_format($stats['total_products']) }}</div>
                    <h5 class="text-muted mb-3">منتج متوفر</h5>
                    <i class="fas fa-box text-primary fs-1"></i>
                </div>
            </div>
            <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="200">
                <div class="stats-card">
                    <div class="stats-number">{{ number_format($stats['total_suppliers']) }}</div>
                    <h5 class="text-muted mb-3">مورد معتمد</h5>
                    <i class="fas fa-store text-primary fs-1"></i>
                </div>
            </div>
            <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="300">
                <div class="stats-card">
                    <div class="stats-number">{{ number_format($stats['total_orders']) }}</div>
                    <h5 class="text-muted mb-3">طلب مكتمل</h5>
                    <i class="fas fa-check-circle text-primary fs-1"></i>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="display-5 fw-bold mb-3">لماذا تختار سلسبيل مكة؟</h2>
            <p class="lead text-muted">نقدم لك أفضل خدمة توصيل المياه في مكة المكرمة</p>
        </div>
        
        <div class="row">
            <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="100">
                <div class="card h-100 text-center border-0 shadow-sm">
                    <div class="card-body p-4">
                        <div class="feature-icon">
                            <i class="fas fa-tint"></i>
                        </div>
                        <h4 class="mb-3">مياه عذبة ونقية</h4>
                        <p class="text-muted mb-0">نختار لك أفضل أنواع المياه من موردين معتمدين ومرخصين</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="200">
                <div class="card h-100 text-center border-0 shadow-sm">
                    <div class="card-body p-4">
                        <div class="feature-icon">
                            <i class="fas fa-shipping-fast"></i>
                        </div>
                        <h4 class="mb-3">توصيل سريع</h4>
                        <p class="text-muted mb-0">نوصل طلبك خلال ساعات قليلة مع مندوبين محترفين</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="300">
                <div class="card h-100 text-center border-0 shadow-sm">
                    <div class="card-body p-4">
                        <div class="feature-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <h4 class="mb-3">جودة مضمونة</h4>
                        <p class="text-muted mb-0">جميع منتجاتنا مضمونة الجودة مع ضمان استرداد الأموال</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Products -->
@if($featuredProducts->count() > 0)
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="display-5 fw-bold mb-3">منتجات مميزة</h2>
            <p class="lead text-muted">أفضل المنتجات المختارة خصيصاً لك</p>
        </div>
        
        <div class="row">
            @foreach($featuredProducts as $index => $product)
            <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="{{ ($index + 1) * 100 }}">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="position-relative overflow-hidden">
                        <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://images.unsplash.com/photo-1559827260-dc66d52bef19?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80' }}" 
                             class="card-img-top" alt="{{ $product->name }}" style="height: 250px; object-fit: cover;">
                        @if($product->is_featured)
                            <div class="position-absolute top-0 start-0 m-3">
                                <span class="badge bg-warning text-dark px-3 py-2">
                                    <i class="fas fa-star me-1"></i>
                                    مميز
                                </span>
                            </div>
                        @endif
                        <div class="position-absolute bottom-0 start-0 end-0 bg-gradient-dark p-3" style="background: linear-gradient(transparent, rgba(0,0,0,0.7));">
                            <div class="d-flex justify-content-between align-items-center text-white">
                                <span class="h5 mb-0">{{ $product->formatted_price }}</span>
                                <div class="text-warning">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star{{ $i <= $product->rating ? '' : '-o' }}"></i>
                                    @endfor
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <h5 class="card-title mb-2">{{ $product->name }}</h5>
                        <p class="card-text text-muted mb-3">{{ Str::limit($product->description, 100) }}</p>
                        
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <small class="text-muted">
                                <i class="fas fa-store me-1"></i>
                                {{ $product->supplier->company_name }}
                            </small>
                            <small class="text-muted">
                                <i class="fas fa-box me-1"></i>
                                متوفر: {{ $product->stock_quantity }}
                            </small>
                        </div>
                        
                        <a href="{{ route('products.show', $product->id) }}" class="btn btn-primary w-100">
                            <i class="fas fa-eye me-2"></i>
                            عرض التفاصيل
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <div class="text-center mt-5" data-aos="fade-up">
            <a href="{{ route('products.index') }}" class="btn btn-outline-primary btn-lg px-5">
                <i class="fas fa-box me-2"></i>
                عرض جميع المنتجات
            </a>
        </div>
    </div>
</section>
@endif

<!-- Top Suppliers -->
@if($topSuppliers->count() > 0)
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="display-5 fw-bold mb-3">أفضل الموردين</h2>
            <p class="lead text-muted">تعامل مع موردين معتمدين ومرخصين</p>
        </div>
        
        <div class="row">
            @foreach($topSuppliers as $index => $supplier)
            <div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="{{ ($index + 1) * 100 }}">
                <div class="card h-100 text-center border-0 shadow-sm">
                    <div class="card-body p-4">
                        <div class="position-relative mb-4">
                            <img src="{{ $supplier->logo ? asset('storage/' . $supplier->logo) : 'https://images.unsplash.com/photo-1560472354-b33ff0c44a43?ixlib=rb-4.0.3&auto=format&fit=crop&w=200&q=80' }}" 
                                 class="rounded-circle mb-3" alt="{{ $supplier->company_name }}" 
                                 style="width: 100px; height: 100px; object-fit: cover;">
                            <div class="position-absolute top-0 end-0">
                                <span class="badge bg-success">
                                    <i class="fas fa-check-circle me-1"></i>
                                    معتمد
                                </span>
                            </div>
                        </div>
                        
                        <h5 class="card-title mb-2">{{ $supplier->company_name }}</h5>
                        <p class="card-text text-muted mb-3">{{ Str::limit($supplier->description, 80) }}</p>
                        
                        <div class="text-warning mb-3">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star{{ $i <= $supplier->rating ? '' : '-o' }}"></i>
                            @endfor
                            <span class="text-muted ms-2">({{ $supplier->rating }})</span>
                        </div>
                        
                        <div class="row text-center mb-3">
                            <div class="col-6">
                                <div class="border-end">
                                    <h6 class="text-primary mb-1">{{ $supplier->total_orders }}</h6>
                                    <small class="text-muted">طلب مكتمل</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <h6 class="text-success mb-1">{{ $supplier->products->count() }}</h6>
                                <small class="text-muted">منتج متوفر</small>
                            </div>
                        </div>
                        
                        <a href="{{ route('supplier.details', $supplier->id) }}" class="btn btn-outline-primary w-100">
                            <i class="fas fa-store me-2"></i>
                            عرض المنتجات
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- CTA Section -->
<section class="py-5" style="background: var(--gradient-primary);">
    <div class="container text-center text-white">
        <div class="row justify-content-center">
            <div class="col-lg-8" data-aos="fade-up">
                <h2 class="display-5 fw-bold mb-4">ابدأ طلبك الآن</h2>
                <p class="lead mb-4 opacity-90">انضم لآلاف العملاء الراضين واحصل على المياه العذبة بأسعار منافسة</p>
                <div class="d-flex flex-wrap justify-content-center gap-3">
                    <a href="{{ route('products.index') }}" class="btn btn-light btn-lg px-5 py-3">
                        <i class="fas fa-shopping-cart me-2"></i>
                        اطلب الآن
                    </a>
                    <a href="{{ route('register') }}" class="btn btn-outline-light btn-lg px-5 py-3">
                        <i class="fas fa-user-plus me-2"></i>
                        إنشاء حساب
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="display-5 fw-bold mb-3">آراء العملاء</h2>
            <p class="lead text-muted">ماذا يقول عملاؤنا عن خدماتنا</p>
        </div>
        
        <div class="row">
            <div class="col-lg-4 mb-4" data-aos="fade-up" data-aos-delay="100">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4 text-center">
                        <div class="text-warning mb-3">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <p class="mb-3">"خدمة ممتازة وتوصيل سريع. المياه عذبة ونقية كما هو مطلوب."</p>
                        <div class="d-flex align-items-center justify-content-center">
                            <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80" 
                                 class="rounded-circle me-3" alt="عميل" style="width: 50px; height: 50px; object-fit: cover;">
                            <div>
                                <h6 class="mb-0">أحمد محمد</h6>
                                <small class="text-muted">عميل دائم</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 mb-4" data-aos="fade-up" data-aos-delay="200">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4 text-center">
                        <div class="text-warning mb-3">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <p class="mb-3">"أفضل منصة لتوصيل المياه في مكة. الأسعار منافسة والجودة عالية."</p>
                        <div class="d-flex align-items-center justify-content-center">
                            <img src="https://images.unsplash.com/photo-1494790108755-2616b612b786?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80" 
                                 class="rounded-circle me-3" alt="عميل" style="width: 50px; height: 50px; object-fit: cover;">
                            <div>
                                <h6 class="mb-0">فاطمة أحمد</h6>
                                <small class="text-muted">ربة منزل</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 mb-4" data-aos="fade-up" data-aos-delay="300">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4 text-center">
                        <div class="text-warning mb-3">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <p class="mb-3">"مندوبي التوصيل محترفين والخدمة سريعة. أنصح الجميع بالتجربة."</p>
                        <div class="d-flex align-items-center justify-content-center">
                            <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80" 
                                 class="rounded-circle me-3" alt="عميل" style="width: 50px; height: 50px; object-fit: cover;">
                            <div>
                                <h6 class="mb-0">علي حسن</h6>
                                <small class="text-muted">مدير شركة</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection 