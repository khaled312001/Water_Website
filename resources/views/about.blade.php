@extends('layouts.app')

@section('title', 'عن الموقع - مياه مكة')

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="display-4 fw-bold mb-4">عن مياه مكة</h1>
                <p class="lead mb-4">
                    منصة رائدة في توصيل المياه العذبة والنقية في مكة المكرمة. 
                    نربط بين أفضل الموردين والعملاء مع ضمان الجودة والسرعة.
                </p>
            </div>
            <div class="col-lg-6 text-center">
                <img src="https://images.unsplash.com/photo-1559827260-dc66d52bef19?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" 
                     alt="مياه عذبة" class="img-fluid rounded-3 shadow-lg">
            </div>
        </div>
    </div>
</section>

<!-- About Content -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="card">
                    <div class="card-body">
                        <h2 class="text-center mb-4">قصتنا</h2>
                        <p class="lead text-center mb-5">
                            بدأت رحلتنا في مكة المكرمة بهدف توفير المياه العذبة والنقية لجميع سكان المدينة المقدسة
                        </p>
                        
                        <div class="row mb-5">
                            <div class="col-md-6">
                                <h4><i class="fas fa-bullseye text-primary me-2"></i>رؤيتنا</h4>
                                <p>أن نكون المنصة الأولى في توصيل المياه العذبة في مكة المكرمة، مع ضمان الجودة والسرعة في التوصيل.</p>
                            </div>
                            <div class="col-md-6">
                                <h4><i class="fas fa-flag text-primary me-2"></i>رسالتنا</h4>
                                <p>توفير المياه العذبة والنقية لجميع سكان مكة المكرمة بأسعار منافسة وخدمة متميزة.</p>
                            </div>
                        </div>

                        <h3 class="mb-4">قيمنا</h3>
                        <div class="row">
                            <div class="col-md-4 mb-4">
                                <div class="text-center">
                                    <div class="feature-icon">
                                        <i class="fas fa-shield-alt"></i>
                                    </div>
                                    <h5>الجودة</h5>
                                    <p class="text-muted">نضمن لك أعلى معايير الجودة في جميع منتجاتنا</p>
                                </div>
                            </div>
                            <div class="col-md-4 mb-4">
                                <div class="text-center">
                                    <div class="feature-icon">
                                        <i class="fas fa-clock"></i>
                                    </div>
                                    <h5>السرعة</h5>
                                    <p class="text-muted">نوصل طلبك في أسرع وقت ممكن</p>
                                </div>
                            </div>
                            <div class="col-md-4 mb-4">
                                <div class="text-center">
                                    <div class="feature-icon">
                                        <i class="fas fa-handshake"></i>
                                    </div>
                                    <h5>الثقة</h5>
                                    <p class="text-muted">نبنى علاقات طويلة الأمد مع عملائنا</p>
                                </div>
                            </div>
                        </div>

                        <h3 class="mb-4">خدماتنا</h3>
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <div class="d-flex">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-tint text-primary fs-4"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h5>توصيل المياه</h5>
                                        <p class="text-muted">نوصل لك المياه العذبة والنقية مباشرة لباب بيتك</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <div class="d-flex">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-store text-primary fs-4"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h5>موردين معتمدين</h5>
                                        <p class="text-muted">نتعامل مع أفضل الموردين المعتمدين والمرخصين</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <div class="d-flex">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-truck text-primary fs-4"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h5>مندوبين محترفين</h5>
                                        <p class="text-muted">فريق مندوبين محترفين ومتدربين على أعلى مستوى</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <div class="d-flex">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-headset text-primary fs-4"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h5>دعم فني</h5>
                                        <p class="text-muted">فريق دعم فني متاح على مدار الساعة لمساعدتك</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="text-center mt-5">
                            <a href="{{ route('products.index') }}" class="btn btn-primary btn-lg">
                                <i class="fas fa-shopping-cart me-2"></i>
                                ابدأ طلبك الآن
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection 