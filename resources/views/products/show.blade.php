@extends('layouts.app')

@section('title', $product->name . ' - سلسبيل مكة')

@section('content')
<!-- Breadcrumb -->
<section class="py-3 bg-light">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none">الرئيسية</a></li>
                <li class="breadcrumb-item"><a href="{{ route('products.index') }}" class="text-decoration-none">المنتجات</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
            </ol>
        </nav>
    </div>
</section>

<!-- Product Details -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <!-- Product Images -->
            <div class="col-lg-6 mb-4" data-aos="fade-right">
                <div class="position-relative">
                    <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://images.unsplash.com/photo-1559827260-dc66d52bef19?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80' }}" 
                         class="img-fluid rounded-4 shadow-lg" alt="{{ $product->name }}" style="width: 100%; height: 500px; object-fit: cover;"
                         onerror="this.src='https://images.unsplash.com/photo-1559827260-dc66d52bef19?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80'">
                    
                    <!-- Floating Badges -->
                    @if($product->is_featured)
                        <div class="position-absolute top-0 start-0 m-3">
                            <span class="badge bg-warning text-dark px-3 py-2">
                                <i class="fas fa-star me-1"></i>
                                منتج مميز
                            </span>
                        </div>
                    @endif
                    
                    @if($product->stock_quantity <= 10 && $product->stock_quantity > 0)
                        <div class="position-absolute top-0 end-0 m-3">
                            <span class="badge bg-warning text-dark px-3 py-2">
                                <i class="fas fa-exclamation-triangle me-1"></i>
                                آخر الكمية
                            </span>
                        </div>
                    @endif
                    
                    @if($product->stock_quantity == 0)
                        <div class="position-absolute top-0 end-0 m-3">
                            <span class="badge bg-danger px-3 py-2">
                                <i class="fas fa-times me-1"></i>
                                نفذت الكمية
                            </span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Product Info -->
            <div class="col-lg-6" data-aos="fade-left">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <h1 class="h2 fw-bold mb-3">{{ $product->name }}</h1>
                        
                        <!-- Rating -->
                        <div class="mb-3">
                            <div class="text-warning mb-2">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star{{ $i <= $product->rating ? '' : '-o' }} fs-5"></i>
                                @endfor
                                <span class="text-muted ms-2">({{ $product->rating }})</span>
                            </div>
                            <p class="text-muted mb-0">
                                <i class="fas fa-store me-1"></i>
                                المورد: <strong>{{ $product->supplier->company_name }}</strong>
                            </p>
                        </div>

                        <!-- Price Section -->
                        <div class="bg-light rounded-3 p-4 mb-4">
                            <div class="row text-center">
                                <div class="col-6">
                                    <div class="border-end">
                                        <h3 class="text-primary fw-bold mb-1">{{ $product->formatted_price }}</h3>
                                        <small class="text-muted">للصندوق</small>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <h4 class="text-secondary fw-bold mb-1">{{ $product->formatted_bottle_price }}</h4>
                                    <small class="text-muted">للعبوة الواحدة</small>
                                </div>
                            </div>
                        </div>

                        <!-- Product Specifications -->
                        <div class="mb-4">
                            <h5 class="fw-bold mb-3">المواصفات:</h5>
                            <div class="row">
                                <div class="col-6 mb-2">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-tag text-primary me-2"></i>
                                        <span><strong>النوع:</strong> 
                                            @switch($product->type)
                                                @case('mineral')
                                                    مياه معدنية
                                                    @break
                                                @case('distilled')
                                                    مياه مقطرة
                                                    @break
                                                @case('spring')
                                                    مياه عين
                                                    @break
                                                @case('alkaline')
                                                    مياه قلوية
                                                    @break
                                            @endswitch
                                        </span>
                                    </div>
                                </div>
                                <div class="col-6 mb-2">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-trademark text-primary me-2"></i>
                                        <span><strong>العلامة التجارية:</strong> {{ $product->brand }}</span>
                                    </div>
                                </div>
                                <div class="col-6 mb-2">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-ruler text-primary me-2"></i>
                                        <span><strong>الحجم:</strong> {{ $product->size }}</span>
                                    </div>
                                </div>
                                <div class="col-6 mb-2">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-box text-primary me-2"></i>
                                        <span><strong>الكمية في الصندوق:</strong> {{ $product->quantity_per_box }} عبوة</span>
                                    </div>
                                </div>
                                <div class="col-6 mb-2">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-warehouse text-primary me-2"></i>
                                        <span><strong>المخزون المتوفر:</strong> {{ $product->stock_quantity }}</span>
                                    </div>
                                </div>
                                <div class="col-6 mb-2">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-chart-line text-primary me-2"></i>
                                        <span><strong>المبيعات:</strong> {{ $product->total_sales }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="mb-4">
                            <h5 class="fw-bold mb-3">الوصف:</h5>
                            <p class="text-muted">{{ $product->description }}</p>
                        </div>

                        <!-- Action Buttons -->
                        @if($product->stock_quantity > 0)
                            <div class="d-grid gap-3">
                                <a href="{{ route('orders.create', ['product_id' => $product->id]) }}" class="btn btn-primary btn-lg">
                                    <i class="fas fa-shopping-cart me-2"></i>
                                    اطلب الآن
                                </a>
                                <a href="{{ route('products.index') }}" class="btn btn-outline-primary">
                                    <i class="fas fa-arrow-left me-2"></i>
                                    العودة للمنتجات
                                </a>
                            </div>
                        @else
                            <div class="alert alert-warning text-center">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                هذا المنتج غير متوفر حالياً
                            </div>
                            <div class="d-grid">
                                <a href="{{ route('products.index') }}" class="btn btn-outline-primary">
                                    <i class="fas fa-arrow-left me-2"></i>
                                    العودة للمنتجات
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Reviews Section -->
        @if($product->reviews->count() > 0)
        <div class="row mt-5">
            <div class="col-12">
                <div class="card border-0 shadow-sm" data-aos="fade-up">
                    <div class="card-header bg-transparent border-0">
                        <h4 class="mb-0">
                            <i class="fas fa-star text-warning me-2"></i>
                            التقييمات والتعليقات ({{ $product->reviews->count() }})
                        </h4>
                    </div>
                    <div class="card-body">
                        @foreach($product->reviews as $review)
                        <div class="border-bottom pb-4 mb-4">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="flex-grow-1">
                                    <div class="d-flex align-items-center mb-2">
                                        <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-4.0.3&auto=format&fit=crop&w=50&q=80" 
                                             class="rounded-circle me-3" alt="عميل" style="width: 40px; height: 40px; object-fit: cover;">
                                        <div>
                                            <h6 class="mb-0">{{ $review->user->name }}</h6>
                                            <small class="text-muted">{{ $review->created_at->format('Y-m-d') }}</small>
                                        </div>
                                    </div>
                                    <div class="text-warning mb-2">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="fas fa-star{{ $i <= $review->rating ? '' : '-o' }}"></i>
                                        @endfor
                                    </div>
                                    @if($review->comment)
                                        <p class="mb-0">{{ $review->comment }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Related Products -->
        @if($relatedProducts->count() > 0)
        <div class="row mt-5">
            <div class="col-12">
                <h3 class="mb-4" data-aos="fade-up">منتجات مشابهة</h3>
                <div class="row">
                    @foreach($relatedProducts as $index => $relatedProduct)
                    <div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="{{ ($index + 1) * 100 }}">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="position-relative overflow-hidden">
                                <img src="{{ $relatedProduct->image ? asset('storage/' . $relatedProduct->image) : 'https://images.unsplash.com/photo-1559827260-dc66d52bef19?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80' }}" 
                                     class="card-img-top" alt="{{ $relatedProduct->name }}" style="height: 200px; object-fit: cover;">
                                <div class="position-absolute bottom-0 start-0 end-0 bg-gradient-dark p-2" style="background: linear-gradient(transparent, rgba(0,0,0,0.7));">
                                    <div class="d-flex justify-content-between align-items-center text-white">
                                        <span class="h6 mb-0">{{ $relatedProduct->formatted_price }}</span>
                                        <div class="text-warning">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="fas fa-star{{ $i <= $relatedProduct->rating ? '' : '-o' }}"></i>
                                            @endfor
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body p-3">
                                <h6 class="card-title mb-2">{{ $relatedProduct->name }}</h6>
                                <a href="{{ route('products.show', $relatedProduct->id) }}" class="btn btn-outline-primary btn-sm w-100">
                                    عرض التفاصيل
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif
    </div>
</section>

<!-- Features Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="100">
                <div class="text-center">
                    <div class="feature-icon">
                        <i class="fas fa-shipping-fast"></i>
                    </div>
                    <h5 class="mb-2">توصيل سريع</h5>
                    <p class="text-muted small">نوصل طلبك خلال ساعات قليلة</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="200">
                <div class="text-center">
                    <div class="feature-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h5 class="mb-2">جودة مضمونة</h5>
                    <p class="text-muted small">جميع المنتجات مضمونة الجودة</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="300">
                <div class="text-center">
                    <div class="feature-icon">
                        <i class="fas fa-undo"></i>
                    </div>
                    <h5 class="mb-2">ضمان الاسترداد</h5>
                    <p class="text-muted small">استرداد المبلغ إذا لم تكن راضياً</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="400">
                <div class="text-center">
                    <div class="feature-icon">
                        <i class="fas fa-headset"></i>
                    </div>
                    <h5 class="mb-2">دعم 24/7</h5>
                    <p class="text-muted small">فريق دعم متاح على مدار الساعة</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection 