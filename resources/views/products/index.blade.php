@extends('layouts.app')

@section('title', 'المنتجات - مياه مكة')

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6" data-aos="fade-right">
                <h1 class="display-3 fw-bold mb-4">منتجات المياه</h1>
                <p class="lead mb-4 opacity-90">
                    اكتشف تشكيلة واسعة من المياه العذبة والنقية من أفضل الموردين في مكة المكرمة
                </p>
            </div>
            <div class="col-lg-6" data-aos="fade-left">
                <form action="{{ route('products.search') }}" method="GET" class="d-flex">
                    <input type="text" name="q" class="form-control form-control-lg me-2" 
                           placeholder="ابحث عن منتج..." value="{{ request('q') }}">
                    <button type="submit" class="btn btn-light btn-lg px-4">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- Filters Section -->
<section class="py-4 bg-light">
    <div class="container">
        <form method="GET" action="{{ route('products.index') }}" class="row g-3">
            <div class="col-lg-3 col-md-6">
                <label class="form-label fw-bold">نوع المياه</label>
                <select name="type" class="form-select">
                    <option value="">جميع الأنواع</option>
                    <option value="mineral" {{ request('type') == 'mineral' ? 'selected' : '' }}>مياه معدنية</option>
                    <option value="distilled" {{ request('type') == 'distilled' ? 'selected' : '' }}>مياه مقطرة</option>
                    <option value="spring" {{ request('type') == 'spring' ? 'selected' : '' }}>مياه عين</option>
                    <option value="alkaline" {{ request('type') == 'alkaline' ? 'selected' : '' }}>مياه قلوية</option>
                </select>
            </div>
            <div class="col-lg-3 col-md-6">
                <label class="form-label fw-bold">المورد</label>
                <select name="supplier_id" class="form-select">
                    <option value="">جميع الموردين</option>
                    @foreach($suppliers as $supplier)
                        <option value="{{ $supplier->id }}" {{ request('supplier_id') == $supplier->id ? 'selected' : '' }}>
                            {{ $supplier->company_name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-lg-2 col-md-6">
                <label class="form-label fw-bold">السعر من</label>
                <input type="number" name="min_price" class="form-control" placeholder="0" value="{{ request('min_price') }}">
            </div>
            <div class="col-lg-2 col-md-6">
                <label class="form-label fw-bold">السعر إلى</label>
                <input type="number" name="max_price" class="form-control" placeholder="1000" value="{{ request('max_price') }}">
            </div>
            <div class="col-lg-2 col-md-12">
                <label class="form-label fw-bold">&nbsp;</label>
                <button type="submit" class="btn btn-primary w-100">
                    <i class="fas fa-filter me-2"></i>
                    فلترة
                </button>
            </div>
        </form>
    </div>
</section>

<!-- Products Section -->
<section class="py-5">
    <div class="container">
        @if($products->count() > 0)
            <!-- Results Info -->
            <div class="d-flex justify-content-between align-items-center mb-4" data-aos="fade-up">
                <div>
                    <h4 class="mb-0">نتائج البحث</h4>
                    <p class="text-muted mb-0">تم العثور على {{ $products->total() }} منتج</p>
                </div>
                <div class="d-flex align-items-center">
                    <span class="me-3 text-muted">ترتيب حسب:</span>
                    <select class="form-select" style="width: auto;">
                        <option>الأكثر شعبية</option>
                        <option>السعر: من الأقل للأعلى</option>
                        <option>السعر: من الأعلى للأقل</option>
                        <option>التقييم الأعلى</option>
                    </select>
                </div>
            </div>

            <div class="row">
                @foreach($products as $index => $product)
                <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="{{ ($index % 3) * 100 }}">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="position-relative overflow-hidden">
                            <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://images.unsplash.com/photo-1559827260-dc66d52bef19?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80' }}" 
                                 class="card-img-top" alt="{{ $product->name }}" style="height: 280px; object-fit: cover;">
                            
                            <!-- Badges -->
                            <div class="position-absolute top-0 start-0 m-3">
                                @if($product->is_featured)
                                    <span class="badge bg-warning text-dark px-3 py-2 mb-2">
                                        <i class="fas fa-star me-1"></i>
                                        مميز
                                    </span>
                                @endif
                                @if($product->stock_quantity <= 10 && $product->stock_quantity > 0)
                                    <span class="badge bg-warning text-dark px-3 py-2">
                                        آخر الكمية
                                    </span>
                                @endif
                                @if($product->stock_quantity == 0)
                                    <span class="badge bg-danger px-3 py-2">
                                        نفذت الكمية
                                    </span>
                                @endif
                            </div>

                            <!-- Price Overlay -->
                            <div class="position-absolute bottom-0 start-0 end-0 bg-gradient-dark p-3" style="background: linear-gradient(transparent, rgba(0,0,0,0.8));">
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
                            <p class="card-text text-muted mb-3">{{ Str::limit($product->description, 120) }}</p>
                            
                            <!-- Product Tags -->
                            <div class="mb-3">
                                <span class="badge bg-primary me-1">{{ $product->brand }}</span>
                                <span class="badge bg-secondary me-1">{{ $product->size }}</span>
                                <span class="badge bg-info">{{ $product->quantity_per_box }} عبوة</span>
                            </div>
                            
                            <!-- Product Info -->
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

                            <!-- Price Details -->
                            <div class="bg-light rounded p-3 mb-3">
                                <div class="row text-center">
                                    <div class="col-6">
                                        <div class="border-end">
                                            <h6 class="text-primary mb-1">{{ $product->formatted_price }}</h6>
                                            <small class="text-muted">للصندوق</small>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <h6 class="text-secondary mb-1">{{ $product->formatted_bottle_price }}</h6>
                                        <small class="text-muted">للعبوة</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer bg-transparent border-0 p-4">
                            <div class="d-grid gap-2">
                                <a href="{{ route('products.show', $product->id) }}" class="btn btn-primary">
                                    <i class="fas fa-eye me-2"></i>
                                    عرض التفاصيل
                                </a>
                                @if($product->stock_quantity > 0)
                                    <a href="{{ route('orders.create', ['product_id' => $product->id]) }}" class="btn btn-success">
                                        <i class="fas fa-shopping-cart me-2"></i>
                                        اطلب الآن
                                    </a>
                                @else
                                    <button class="btn btn-secondary" disabled>
                                        <i class="fas fa-times me-2"></i>
                                        نفذت الكمية
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-5" data-aos="fade-up">
                {{ $products->links() }}
            </div>
        @else
            <div class="text-center py-5" data-aos="fade-up">
                <div class="mb-4">
                    <i class="fas fa-box-open text-muted" style="font-size: 5rem;"></i>
                </div>
                <h3 class="mb-3">لا توجد منتجات</h3>
                <p class="text-muted mb-4">لم نتمكن من العثور على منتجات تطابق معايير البحث</p>
                <div class="d-flex justify-content-center gap-3">
                    <a href="{{ route('products.index') }}" class="btn btn-primary">
                        <i class="fas fa-arrow-left me-2"></i>
                        العودة لجميع المنتجات
                    </a>
                    <a href="{{ route('contact') }}" class="btn btn-outline-primary">
                        <i class="fas fa-headset me-2"></i>
                        تواصل معنا
                    </a>
                </div>
            </div>
        @endif
    </div>
</section>

<!-- Features Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="display-5 fw-bold mb-3">مميزاتنا</h2>
            <p class="lead text-muted">نقدم لك أفضل تجربة تسوق</p>
        </div>
        
        <div class="row">
            <div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="100">
                <div class="text-center">
                    <div class="feature-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h5 class="mb-2">جودة مضمونة</h5>
                    <p class="text-muted small">جميع منتجاتنا من موردين معتمدين ومرخصين</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="200">
                <div class="text-center">
                    <div class="feature-icon">
                        <i class="fas fa-shipping-fast"></i>
                    </div>
                    <h5 class="mb-2">توصيل سريع</h5>
                    <p class="text-muted small">نوصل طلبك خلال ساعات قليلة</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="300">
                <div class="text-center">
                    <div class="feature-icon">
                        <i class="fas fa-undo"></i>
                    </div>
                    <h5 class="mb-2">ضمان الاسترداد</h5>
                    <p class="text-muted small">إذا لم تكن راضياً، سنقوم باسترداد المبلغ</p>
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

<!-- Newsletter Section -->
<section class="py-5" style="background: var(--gradient-secondary);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center text-white" data-aos="fade-up">
                <h3 class="mb-3">اشترك في النشرة البريدية</h3>
                <p class="mb-4 opacity-90">احصل على آخر العروض والمنتجات الجديدة</p>
                <form class="d-flex gap-2 justify-content-center">
                    <input type="email" class="form-control form-control-lg" placeholder="أدخل بريدك الإلكتروني" style="max-width: 400px;">
                    <button type="submit" class="btn btn-light btn-lg px-4">
                        <i class="fas fa-paper-plane me-2"></i>
                        اشتراك
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection 