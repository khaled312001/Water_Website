@extends('layouts.admin')

@section('title', 'تفاصيل المنتج - سلسبيل مكة')
@section('page-title', 'تفاصيل المنتج')

@section('content')
<div class="fade-in">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="mb-0">تفاصيل المنتج: {{ $product->name }}</h4>
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-admin btn-warning">
                            <i class="fas fa-edit me-2"></i>
                            تعديل
                        </a>
                        <a href="{{ route('admin.products') }}" class="btn btn-admin btn-outline-secondary">
                            <i class="fas fa-arrow-right me-2"></i>
                            العودة للقائمة
                        </a>
                    </div>
                </div>

                <!-- Product Information -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="card border-0 bg-light">
                            <div class="card-body">
                                <h6 class="card-title text-primary mb-3">
                                    <i class="fas fa-box me-2"></i>
                                    معلومات المنتج
                                </h6>
                                
                                <div class="mb-3">
                                    <label class="form-label fw-bold">اسم المنتج:</label>
                                    <p class="mb-0">{{ $product->name }}</p>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">السعر:</label>
                                    <p class="mb-0">{{ $product->price_per_box }} ريال</p>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">المورد:</label>
                                    <p class="mb-0">{{ $product->supplier->company_name ?? 'غير محدد' }}</p>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">الحالة:</label>
                                    @if($product->is_active)
                                        <span class="badge bg-success">متاح</span>
                                    @else
                                        <span class="badge bg-danger">غير متاح</span>
                                    @endif
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">التقييم:</label>
                                    <div class="d-flex align-items-center">
                                        <div class="text-warning me-2">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="fas fa-star{{ $i <= ($product->reviews->avg('rating') ?? 0) ? '' : '-o' }}"></i>
                                            @endfor
                                        </div>
                                        <span class="fw-bold">{{ number_format($product->reviews->avg('rating') ?? 0, 1) }}</span>
                                        <span class="text-muted ms-2">({{ $product->reviews->count() }} تقييم)</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card border-0 bg-light">
                            <div class="card-body">
                                <h6 class="card-title text-primary mb-3">
                                    <i class="fas fa-info-circle me-2"></i>
                                    معلومات إضافية
                                </h6>
                                
                                <div class="mb-3">
                                    <label class="form-label fw-bold">تاريخ الإضافة:</label>
                                    <p class="mb-0">{{ $product->created_at->format('Y-m-d H:i') }}</p>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">آخر تحديث:</label>
                                    <p class="mb-0">{{ $product->updated_at->format('Y-m-d H:i') }}</p>
                                </div>

                                @if($product->description)
                                <div class="mb-3">
                                    <label class="form-label fw-bold">الوصف:</label>
                                    <p class="mb-0">{{ $product->description }}</p>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Product Statistics -->
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card border-0 bg-light">
                            <div class="card-body">
                                <h6 class="card-title text-primary mb-3">
                                    <i class="fas fa-chart-bar me-2"></i>
                                    الإحصائيات
                                </h6>
                                
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="text-center">
                                            <h4 class="text-primary">{{ $product->reviews->count() }}</h4>
                                            <p class="text-muted mb-0">التقييمات</p>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="text-center">
                                            <h4 class="text-success">{{ $product->reviews->where('rating', 5)->count() }}</h4>
                                            <p class="text-muted mb-0">تقييمات 5 نجوم</p>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="text-center">
                                            <h4 class="text-info">{{ number_format($product->reviews->avg('rating') ?? 0, 1) }}</h4>
                                            <p class="text-muted mb-0">متوسط التقييم</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Reviews -->
                @if($product->reviews->count() > 0)
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card border-0 bg-light">
                            <div class="card-body">
                                <h6 class="card-title text-primary mb-3">
                                    <i class="fas fa-star me-2"></i>
                                    آخر التقييمات
                                </h6>
                                
                                @foreach($product->reviews->take(5) as $review)
                                <div class="border-bottom pb-3 mb-3">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <h6 class="mb-1">{{ $review->user->name ?? 'مستخدم' }}</h6>
                                            <div class="text-warning mb-2">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <i class="fas fa-star{{ $i <= $review->rating ? '' : '-o' }}"></i>
                                                @endfor
                                                <span class="text-muted ms-2">{{ $review->rating }}/5</span>
                                            </div>
                                            @if($review->comment)
                                                <p class="mb-0 text-muted">{{ $review->comment }}</p>
                                            @endif
                                        </div>
                                        <small class="text-muted">{{ $review->created_at->format('Y-m-d') }}</small>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection 