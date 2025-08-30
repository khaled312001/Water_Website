@extends('layouts.customer')

@section('title', 'لوحة تحكم العميل - سلسبيل مكة')
@section('page-title', 'لوحة التحكم')

@section('content')
<!-- Welcome Section -->
<div class="row mb-4">
    <div class="col-12">
        <div class="stat-card">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h4 class="mb-2">مرحباً {{ auth()->user()->name }}!</h4>
                    <p class="text-muted mb-0">إليك نظرة عامة على نشاطك في سلسبيل مكة</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('products.index') }}" class="btn btn-customer btn-primary">
                        <i class="fas fa-shopping-cart me-2"></i>
                        طلب مياه جديد
                    </a>
                    <a href="{{ route('orders.create') }}" class="btn btn-customer btn-outline-primary">
                        <i class="fas fa-plus me-2"></i>
                        طلب سريع
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Stats Cards -->
<div class="row mb-4">
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="stat-card">
            <div class="d-flex align-items-center">
                <div class="stat-icon bg-primary bg-opacity-10 text-primary">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <div class="ms-3">
                    <div class="stat-number text-primary">{{ number_format($stats['total_orders'] ?? 0) }}</div>
                    <div class="stat-label">إجمالي الطلبات</div>
                    <div class="stat-change text-success">
                        <i class="fas fa-arrow-up me-1"></i>
                        {{ $stats['recent_orders'] ?? 0 }} هذا الشهر
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-3">
        <div class="stat-card">
            <div class="d-flex align-items-center">
                <div class="stat-icon bg-success bg-opacity-10 text-success">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="ms-3">
                    <div class="stat-number text-success">{{ number_format($stats['completed_orders'] ?? 0) }}</div>
                    <div class="stat-label">الطلبات المكتملة</div>
                    <div class="stat-change text-success">
                        <i class="fas fa-percentage me-1"></i>
                        {{ $stats['completion_rate'] ?? 0 }}% معدل الإنجاز
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-3">
        <div class="stat-card">
            <div class="d-flex align-items-center">
                <div class="stat-icon bg-warning bg-opacity-10 text-warning">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="ms-3">
                    <div class="stat-number text-warning">{{ number_format($stats['pending_orders'] ?? 0) }}</div>
                    <div class="stat-label">الطلبات قيد الانتظار</div>
                    <div class="stat-change text-warning">
                        <i class="fas fa-hourglass-half me-1"></i>
                        قيد المعالجة
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-3">
        <div class="stat-card">
            <div class="d-flex align-items-center">
                <div class="stat-icon bg-info bg-opacity-10 text-info">
                    <i class="fas fa-star"></i>
                </div>
                <div class="ms-3">
                    <div class="stat-number text-info">{{ number_format($stats['total_spent'] ?? 0, 2) }}</div>
                    <div class="stat-label">إجمالي الإنفاق</div>
                    <div class="stat-change text-info">
                        <i class="fas fa-currency-sign me-1"></i>
                        ريال سعودي
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions & Recent Orders -->
<div class="row mb-4">
    <!-- Quick Actions -->
    <div class="col-lg-4 mb-4">
        <div class="stat-card">
            <h5 class="mb-3">
                <i class="fas fa-bolt text-primary me-2"></i>
                إجراءات سريعة
            </h5>
            <div class="quick-actions">
                <a href="{{ route('products.index') }}" class="action-card">
                    <div class="action-icon bg-primary bg-opacity-10 text-primary">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <h6 class="mb-1">طلب مياه جديد</h6>
                    <small class="text-muted">تصفح المنتجات واطلب المياه</small>
                </a>
                
                <a href="{{ route('orders.index') }}" class="action-card">
                    <div class="action-icon bg-success bg-opacity-10 text-success">
                        <i class="fas fa-list"></i>
                    </div>
                    <h6 class="mb-1">عرض طلباتي</h6>
                    <small class="text-muted">تتبع حالة طلباتك</small>
                </a>
                
                <a href="{{ route('cart.index') }}" class="action-card">
                    <div class="action-icon bg-warning bg-opacity-10 text-warning">
                        <i class="fas fa-shopping-bag"></i>
                    </div>
                    <h6 class="mb-1">سلة التسوق</h6>
                    <small class="text-muted">عرض وإدارة مشترياتك</small>
                </a>
                
                <a href="{{ route('profile') }}" class="action-card">
                    <div class="action-icon bg-info bg-opacity-10 text-info">
                        <i class="fas fa-user-cog"></i>
                    </div>
                    <h6 class="mb-1">الملف الشخصي</h6>
                    <small class="text-muted">تعديل معلومات حسابك</small>
                </a>
            </div>
        </div>
    </div>

    <!-- Recent Orders -->
    <div class="col-lg-8 mb-4">
        <div class="stat-card">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <h5 class="mb-0">
                    <i class="fas fa-history text-primary me-2"></i>
                    آخر الطلبات
                </h5>
                <a href="{{ route('orders.index') }}" class="btn btn-customer btn-sm btn-outline-primary">
                    عرض الكل
                </a>
            </div>
            
            @if(isset($recentOrders) && $recentOrders->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>رقم الطلب</th>
                                <th>المنتج</th>
                                <th>التاريخ</th>
                                <th>الحالة</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentOrders as $order)
                            <tr>
                                <td>
                                    <strong>#{{ $order->order_number }}</strong>
                                </td>
                                <td>{{ $order->product->name ?? 'غير محدد' }}</td>
                                <td>{{ $order->created_at->format('Y-m-d') }}</td>
                                <td>
                                    <span class="badge bg-{{ $order->status == 'delivered' ? 'success' : ($order->status == 'shipped' ? 'info' : 'warning') }}">
                                        {{ $order->status_text }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('orders.show', $order->id) }}" class="btn btn-customer btn-sm btn-outline-primary">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-4">
                    <i class="fas fa-shopping-cart text-muted" style="font-size: 3rem;"></i>
                    <p class="text-muted mt-3">لا توجد طلبات حديثة</p>
                    <a href="{{ route('products.index') }}" class="btn btn-customer btn-primary">
                        <i class="fas fa-shopping-cart me-2"></i>
                        طلب مياه جديد
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Featured Products -->
<div class="row mb-4">
    <div class="col-12">
        <div class="stat-card">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <h5 class="mb-0">
                    <i class="fas fa-star text-warning me-2"></i>
                    منتجات مميزة
                </h5>
                <a href="{{ route('products.index') }}" class="btn btn-customer btn-sm btn-outline-primary">
                    عرض الكل
                </a>
            </div>
            
            <div class="row">
                @if(isset($featuredProducts) && $featuredProducts->count() > 0)
                    @foreach($featuredProducts->take(4) as $product)
                    <div class="col-lg-3 col-md-6 mb-3">
                        <div class="card h-100 border-0 shadow-sm">
                            <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://images.unsplash.com/photo-1559827260-dc66d52bef19?ixlib=rb-4.0.3&auto=format&fit=crop&w=300&q=80' }}" 
                                 class="card-img-top" alt="{{ $product->name }}" style="height: 200px; object-fit: cover;">
                            <div class="card-body">
                                <h6 class="card-title">{{ $product->name }}</h6>
                                <p class="card-text text-muted small">{{ Str::limit($product->description, 80) }}</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="fw-bold text-primary">{{ number_format($product->price, 2) }} ريال</span>
                                    <a href="{{ route('products.show', $product->id) }}" class="btn btn-customer btn-sm btn-primary">
                                        <i class="fas fa-eye me-1"></i>
                                        عرض
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="col-12 text-center py-4">
                        <i class="fas fa-box text-muted" style="font-size: 3rem;"></i>
                        <p class="text-muted mt-3">لا توجد منتجات مميزة حالياً</p>
                        <a href="{{ route('products.index') }}" class="btn btn-customer btn-primary">
                            <i class="fas fa-shopping-cart me-2"></i>
                            تصفح المنتجات
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Customer Support -->
<div class="row">
    <div class="col-12">
        <div class="stat-card bg-light">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h5 class="mb-2">هل تحتاج مساعدة؟</h5>
                    <p class="text-muted mb-0">فريق الدعم الفني متاح على مدار الساعة لمساعدتك</p>
                </div>
                <div class="col-md-4 text-md-end">
                    <a href="{{ route('contact') }}" class="btn btn-customer btn-primary me-2">
                        <i class="fas fa-headset me-2"></i>
                        تواصل معنا
                    </a>
                    <a href="tel:+966501234567" class="btn btn-customer btn-outline-primary">
                        <i class="fas fa-phone me-2"></i>
                        اتصل الآن
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 