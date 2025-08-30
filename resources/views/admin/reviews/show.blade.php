@extends('layouts.admin')

@section('title', 'تفاصيل التقييم - سلسبيل مكة')
@section('page-title', 'تفاصيل التقييم')

@section('content')
<div class="fade-in">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="mb-0">تفاصيل التقييم #{{ $review->id }}</h4>
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.reviews.edit', $review->id) }}" class="btn btn-admin btn-warning">
                            <i class="fas fa-edit me-2"></i>
                            تعديل
                        </a>
                        <a href="{{ route('admin.reviews') }}" class="btn btn-admin btn-outline-secondary">
                            <i class="fas fa-arrow-right me-2"></i>
                            العودة للقائمة
                        </a>
                    </div>
                </div>

                <!-- Review Information -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="card border-0 bg-light">
                            <div class="card-body">
                                <h6 class="card-title text-primary mb-3">
                                    <i class="fas fa-star me-2"></i>
                                    معلومات التقييم
                                </h6>
                                
                                <div class="mb-3">
                                    <label class="form-label fw-bold">التقييم:</label>
                                    <div class="d-flex align-items-center">
                                        <div class="text-warning me-2">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="fas fa-star{{ $i <= $review->rating ? '' : '-o' }}"></i>
                                            @endfor
                                        </div>
                                        <span class="fw-bold">{{ $review->rating }}/5</span>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">التعليق:</label>
                                    <p class="mb-0">{{ $review->comment ?? 'لا يوجد تعليق' }}</p>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">تاريخ التقييم:</label>
                                    <p class="mb-0">{{ $review->created_at->format('Y-m-d H:i') }}</p>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">آخر تحديث:</label>
                                    <p class="mb-0">{{ $review->updated_at->format('Y-m-d H:i') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card border-0 bg-light">
                            <div class="card-body">
                                <h6 class="card-title text-primary mb-3">
                                    <i class="fas fa-user me-2"></i>
                                    معلومات المستخدم
                                </h6>
                                
                                <div class="mb-3">
                                    <label class="form-label fw-bold">اسم المستخدم:</label>
                                    <p class="mb-0">{{ $review->user->name ?? 'غير محدد' }}</p>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">البريد الإلكتروني:</label>
                                    <p class="mb-0">{{ $review->user->email ?? 'غير محدد' }}</p>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">رقم الهاتف:</label>
                                    <p class="mb-0">{{ $review->user->phone ?? 'غير محدد' }}</p>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">الدور:</label>
                                    @php
                                        $roleNames = [
                                            'admin' => 'مدير',
                                            'customer' => 'عميل',
                                            'supplier' => 'مورد',
                                            'delivery' => 'مندوب توصيل'
                                        ];
                                        $roleName = $roleNames[$review->user->role ?? ''] ?? 'غير محدد';
                                    @endphp
                                    <p class="mb-0">{{ $roleName }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Product Information -->
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card border-0 bg-light">
                            <div class="card-body">
                                <h6 class="card-title text-primary mb-3">
                                    <i class="fas fa-box me-2"></i>
                                    معلومات المنتج
                                </h6>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">اسم المنتج:</label>
                                            <p class="mb-0">{{ $review->product->name ?? 'غير محدد' }}</p>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label fw-bold">السعر:</label>
                                            <p class="mb-0">{{ $review->product->price_per_box ?? 0 }} ريال</p>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">المورد:</label>
                                            <p class="mb-0">{{ $review->product->supplier->company_name ?? 'غير محدد' }}</p>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label fw-bold">حالة المنتج:</label>
                                            @if($review->product->is_active ?? false)
                                                <span class="badge bg-success">متاح</span>
                                            @else
                                                <span class="badge bg-danger">غير متاح</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                @if($review->product->description)
                                <div class="mb-3">
                                    <label class="form-label fw-bold">وصف المنتج:</label>
                                    <p class="mb-0">{{ $review->product->description }}</p>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 