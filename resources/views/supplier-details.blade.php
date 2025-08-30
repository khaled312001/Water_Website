@extends('layouts.app')

@section('title', $supplier->company_name . ' - مياه مكة')

@section('content')
<!-- Breadcrumb -->
<section class="py-3 bg-light">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none">الرئيسية</a></li>
                <li class="breadcrumb-item"><a href="{{ route('suppliers') }}" class="text-decoration-none">الموردين</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $supplier->company_name }}</li>
            </ol>
        </nav>
    </div>
</section>

<!-- Supplier Header -->
<section class="py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8" data-aos="fade-right">
                <div class="d-flex align-items-center mb-4">
                    <img src="{{ $supplier->logo ? asset('storage/' . $supplier->logo) : 'https://images.unsplash.com/photo-1560472354-b33ff0c44a43?ixlib=rb-4.0.3&auto=format&fit=crop&w=200&q=80' }}" 
                         class="rounded-circle me-4" alt="{{ $supplier->company_name }}" 
                         style="width: 120px; height: 120px; object-fit: cover;">
                    <div>
                        <h1 class="h2 fw-bold mb-2">{{ $supplier->company_name }}</h1>
                        <div class="text-warning mb-2">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star{{ $i <= $supplier->rating ? '' : '-o' }} fs-5"></i>
                            @endfor
                            <span class="text-muted ms-2">({{ $supplier->rating }})</span>
                        </div>
                        <span class="badge bg-success px-3 py-2">
                            <i class="fas fa-check-circle me-1"></i>
                            مورد معتمد
                        </span>
                    </div>
                </div>
                
                <p class="lead text-muted mb-4">{{ $supplier->description }}</p>
                
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-map-marker-alt text-primary me-2"></i>
                            <span>{{ $supplier->city }}</span>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-phone text-primary me-2"></i>
                            <span>{{ $supplier->phone }}</span>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-envelope text-primary me-2"></i>
                            <span>{{ $supplier->email }}</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4" data-aos="fade-left">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-3">إحصائيات المورد</h5>
                        
                        <div class="row text-center">
                            <div class="col-6 mb-3">
                                <div class="border-end">
                                    <h4 class="text-primary fw-bold mb-1">{{ $supplier->total_orders }}</h4>
                                    <small class="text-muted">طلب مكتمل</small>
                                </div>
                            </div>
                            <div class="col-6 mb-3">
                                <h4 class="text-success fw-bold mb-1">{{ $supplier->products->count() }}</h4>
                                <small class="text-muted">منتج متوفر</small>
                            </div>
                        </div>
                        
                        <div class="row text-center">
                            <div class="col-6">
                                <div class="border-end">
                                    <h4 class="text-info fw-bold mb-1">{{ $supplier->rating }}</h4>
                                    <small class="text-muted">تقييم</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <h4 class="text-warning fw-bold mb-1">{{ $supplier->status == 'active' ? 'نشط' : 'غير نشط' }}</h4>
                                <small class="text-muted">الحالة</small>
                            </div>
                        </div>
                        
                        <hr class="my-3">
                        
                        <div class="d-grid">
                            <a href="#products" class="btn btn-primary">
                                <i class="fas fa-box me-2"></i>
                                عرض المنتجات
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Products Section -->
<section class="py-5 bg-light" id="products">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="display-5 fw-bold mb-3">منتجات {{ $supplier->company_name }}</h2>
            <p class="lead text-muted">اكتشف تشكيلة المنتجات المتنوعة</p>
        </div>
        
        @if($supplier->products->count() > 0)
            <div class="row">
                @foreach($supplier->products as $index => $product)
                <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="{{ ($index % 3) * 100 }}">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="position-relative overflow-hidden">
                            <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://images.unsplash.com/photo-1559827260-dc66d52bef19?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80' }}" 
                                 class="card-img-top" alt="{{ $product->name }}" style="height: 250px; object-fit: cover;">
                            
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
                            <p class="card-text text-muted mb-3">{{ Str::limit($product->description, 100) }}</p>
                            
                            <!-- Product Tags -->
                            <div class="mb-3">
                                <span class="badge bg-primary me-1">{{ $product->brand }}</span>
                                <span class="badge bg-secondary me-1">{{ $product->size }}</span>
                                <span class="badge bg-info">{{ $product->quantity_per_box }} عبوة</span>
                            </div>
                            
                            <!-- Product Info -->
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <small class="text-muted">
                                    <i class="fas fa-box me-1"></i>
                                    متوفر: {{ $product->stock_quantity }}
                                </small>
                                <small class="text-muted">
                                    <i class="fas fa-chart-line me-1"></i>
                                    مبيعات: {{ $product->total_sales }}
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
        @else
            <div class="text-center py-5" data-aos="fade-up">
                <div class="mb-4">
                    <i class="fas fa-box-open text-muted" style="font-size: 5rem;"></i>
                </div>
                <h3 class="mb-3">لا توجد منتجات</h3>
                <p class="text-muted mb-4">هذا المورد لا يملك منتجات متاحة حالياً</p>
                <a href="{{ route('suppliers') }}" class="btn btn-primary">
                    <i class="fas fa-arrow-left me-2"></i>
                    العودة للموردين
                </a>
            </div>
        @endif
    </div>
</section>

<!-- Supplier Info Section -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8" data-aos="fade-right">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <h3 class="fw-bold mb-4">معلومات المورد</h3>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-user text-primary me-2"></i>
                                    <div>
                                        <strong>الشخص المسؤول:</strong>
                                        <div>{{ $supplier->contact_person }}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-phone text-primary me-2"></i>
                                    <div>
                                        <strong>رقم الهاتف:</strong>
                                        <div>{{ $supplier->phone }}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-envelope text-primary me-2"></i>
                                    <div>
                                        <strong>البريد الإلكتروني:</strong>
                                        <div>{{ $supplier->email }}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-map-marker-alt text-primary me-2"></i>
                                    <div>
                                        <strong>العنوان:</strong>
                                        <div>{{ $supplier->address }}, {{ $supplier->city }}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-certificate text-primary me-2"></i>
                                    <div>
                                        <strong>الرخصة التجارية:</strong>
                                        <div>{{ $supplier->commercial_license }}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-receipt text-primary me-2"></i>
                                    <div>
                                        <strong>الرقم الضريبي:</strong>
                                        <div>{{ $supplier->tax_number }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4" data-aos="fade-left">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <h4 class="fw-bold mb-3">تواصل مع المورد</h4>
                        
                        <div class="d-grid gap-2">
                            <a href="tel:{{ $supplier->phone }}" class="btn btn-outline-primary">
                                <i class="fas fa-phone me-2"></i>
                                اتصل الآن
                            </a>
                            <a href="mailto:{{ $supplier->email }}" class="btn btn-outline-primary">
                                <i class="fas fa-envelope me-2"></i>
                                أرسل بريد إلكتروني
                            </a>
                            <a href="{{ route('contact') }}" class="btn btn-outline-primary">
                                <i class="fas fa-comments me-2"></i>
                                اطلب استفسار
                            </a>
                        </div>
                        
                        <hr class="my-4">
                        
                        <h5 class="fw-bold mb-3">ساعات العمل</h5>
                        <div class="mb-2">
                            <strong>الأحد - الخميس:</strong> 8:00 ص - 8:00 م
                        </div>
                        <div class="mb-2">
                            <strong>الجمعة - السبت:</strong> 9:00 ص - 6:00 م
                        </div>
                        <div class="text-success">
                            <strong>خدمة التوصيل:</strong> 24/7
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-5" style="background: var(--gradient-primary);">
    <div class="container text-center text-white">
        <div class="row justify-content-center">
            <div class="col-lg-8" data-aos="fade-up">
                <h2 class="display-5 fw-bold mb-4">اطلب من {{ $supplier->company_name }}</h2>
                <p class="lead mb-4 opacity-90">احصل على أفضل المنتجات بأسعار منافسة</p>
                <div class="d-flex flex-wrap justify-content-center gap-3">
                    <a href="#products" class="btn btn-light btn-lg px-5 py-3">
                        <i class="fas fa-shopping-cart me-2"></i>
                        اطلب الآن
                    </a>
                    <a href="{{ route('suppliers') }}" class="btn btn-outline-light btn-lg px-5 py-3">
                        <i class="fas fa-store me-2"></i>
                        عرض جميع الموردين
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection 