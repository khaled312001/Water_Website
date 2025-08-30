@extends('layouts.app')

@section('title', 'الموردين - سلسبيل مكة')

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="display-4 fw-bold mb-4">الموردين المعتمدين</h1>
                <p class="lead mb-4">
                    تعامل مع أفضل موردين المياه المعتمدين والمرخصين في مكة المكرمة
                </p>
                <div class="row text-center">
                    <div class="col-md-4">
                        <div class="stat-item">
                            <h3 class="text-primary">{{ $suppliers->total() }}</h3>
                            <p class="text-muted">مورد معتمد</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="stat-item">
                            <h3 class="text-success">{{ $suppliers->avg('rating') ? number_format($suppliers->avg('rating'), 1) : '4.5' }}</h3>
                            <p class="text-muted">متوسط التقييم</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="stat-item">
                            <h3 class="text-info">{{ $suppliers->sum('total_orders') }}</h3>
                            <p class="text-muted">طلب مكتمل</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 text-center">
                <img src="https://images.unsplash.com/photo-1560472354-b33ff0c44a43?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" 
                     alt="الموردين" class="img-fluid rounded-3 shadow-lg">
            </div>
        </div>
    </div>
</section>

<!-- Suppliers Section -->
<section class="py-5">
    <div class="container">
        @if($suppliers->count() > 0)
            <div class="row">
                @foreach($suppliers as $supplier)
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-body text-center">
                            <img src="{{ $supplier->user->profile_image ? asset('storage/' . $supplier->user->profile_image) : 'https://images.unsplash.com/photo-1560472354-b33ff0c44a43?ixlib=rb-4.0.3&auto=format&fit=crop&w=200&q=80' }}" 
                                 class="rounded-circle mb-3" alt="{{ $supplier->company_name }}" 
                                 style="width: 100px; height: 100px; object-fit: cover;">
                            
                            <h5 class="card-title">{{ $supplier->company_name }}</h5>
                            <p class="card-text text-muted mb-2">{{ Str::limit($supplier->description, 120) }}</p>
                            <p class="text-muted small mb-3">
                                <i class="fas fa-user me-1"></i>
                                {{ $supplier->user->name }}
                            </p>
                            
                            <div class="mb-3">
                                <div class="text-warning">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star{{ $i <= $supplier->rating ? '' : '-o' }}"></i>
                                    @endfor
                                    <span class="text-muted ms-2">({{ $supplier->rating }})</span>
                                </div>
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
                            
                            <div class="mb-3">
                                <small class="text-muted">
                                    <i class="fas fa-map-marker-alt me-1"></i>
                                    {{ $supplier->city }}
                                </small>
                                <br>
                                <small class="text-muted">
                                    <i class="fas fa-phone me-1"></i>
                                    {{ $supplier->phone }}
                                </small>
                            </div>
                            
                            <a href="{{ route('supplier.details', $supplier->id) }}" class="btn btn-primary">
                                <i class="fas fa-store me-2"></i>
                                عرض المنتجات
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $suppliers->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-store text-muted" style="font-size: 4rem;"></i>
                <h3 class="mt-3">لا يوجد موردين</h3>
                <p class="text-muted">لا يوجد موردين متاحين حالياً</p>
            </div>
        @endif
    </div>
</section>

<!-- Features Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="display-5 fw-bold">لماذا تتعامل مع مورديننا؟</h2>
            <p class="lead text-muted">نختار لك أفضل الموردين المعتمدين</p>
        </div>
        
        <div class="row">
            <div class="col-md-4 text-center mb-4">
                <div class="feature-icon">
                    <i class="fas fa-certificate"></i>
                </div>
                <h4>معتمدين ومرخصين</h4>
                <p class="text-muted">جميع مورديننا معتمدين من الجهات المختصة ومرخصين</p>
            </div>
            <div class="col-md-4 text-center mb-4">
                <div class="feature-icon">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <h4>جودة مضمونة</h4>
                <p class="text-muted">نضمن لك أعلى معايير الجودة في جميع المنتجات</p>
            </div>
            <div class="col-md-4 text-center mb-4">
                <div class="feature-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <h4>توصيل سريع</h4>
                <p class="text-muted">مورديننا يضمنون التوصيل السريع والموثوق</p>
            </div>
        </div>
    </div>
</section>
@endsection

<style>
.stat-item {
    padding: 1rem;
    border-radius: 10px;
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    margin-bottom: 1rem;
}

.stat-item h3 {
    margin-bottom: 0.5rem;
    font-weight: bold;
}

.feature-icon {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1rem;
    color: white;
    font-size: 2rem;
}

.card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border: none;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
}

.hero-section {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 4rem 0;
    margin-bottom: 2rem;
}

.hero-section h1 {
    color: white;
}

.hero-section .lead {
    color: rgba(255, 255, 255, 0.9);
}
</style> 