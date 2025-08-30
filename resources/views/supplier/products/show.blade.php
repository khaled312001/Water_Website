@extends('layouts.supplier')

@section('title', 'تفاصيل المنتج - سلسبيل مكة')
@section('page-title', 'تفاصيل المنتج')

@section('content')
<div class="fade-in">
    <div class="row">
        <div class="col-12">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="mb-0">
                        <i class="fas fa-box text-primary me-2"></i>
                        تفاصيل المنتج
                    </h4>
                    <div class="d-flex gap-2">
                        <a href="{{ route('supplier.products.edit', $product->id) }}" class="btn btn-supplier btn-warning">
                            <i class="fas fa-edit me-2"></i>
                            تعديل
                        </a>
                        <form action="{{ route('supplier.products.delete', $product->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('هل أنت متأكد من حذف هذا المنتج؟')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-supplier btn-danger">
                                <i class="fas fa-trash me-2"></i>
                                حذف
                            </button>
                        </form>
                        <a href="{{ route('supplier.products') }}" class="btn btn-supplier btn-outline-secondary">
                            <i class="fas fa-arrow-right me-2"></i>
                            العودة للمنتجات
                        </a>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="text-center mb-4">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" 
                                     class="img-fluid rounded" style="max-height: 300px;"
                                     onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                            @else
                                <div class="bg-light rounded d-flex align-items-center justify-content-center" 
                                     style="height: 300px;">
                                    <i class="fas fa-box text-muted" style="font-size: 4rem;"></i>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">اسم المنتج</label>
                                <p class="form-control-plaintext">{{ $product->name }}</p>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">العلامة التجارية</label>
                                <p class="form-control-plaintext">{{ $product->brand }}</p>
                            </div>

                            <div class="col-12 mb-3">
                                <label class="form-label fw-bold">وصف المنتج</label>
                                <p class="form-control-plaintext">{{ $product->description }}</p>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold">حجم العبوة</label>
                                <p class="form-control-plaintext">{{ $product->size }}</p>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold">عدد العبوات في الصندوق</label>
                                <p class="form-control-plaintext">{{ $product->quantity_per_box }}</p>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold">نوع الماء</label>
                                <p class="form-control-plaintext">
                                    @switch($product->type)
                                        @case('mineral')
                                            معدني
                                            @break
                                        @case('distilled')
                                            مقطر
                                            @break
                                        @case('spring')
                                            عين
                                            @break
                                        @case('alkaline')
                                            قلوي
                                            @break
                                        @default
                                            {{ $product->type }}
                                    @endswitch
                                </p>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold">سعر الصندوق</label>
                                <p class="form-control-plaintext text-success fw-bold">{{ $product->price_per_box }} ريال</p>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold">سعر العبوة</label>
                                <p class="form-control-plaintext text-success fw-bold">{{ $product->price_per_bottle }} ريال</p>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold">الكمية المتوفرة</label>
                                <p class="form-control-plaintext">
                                    @if($product->stock_quantity > 0)
                                        <span class="text-success">{{ $product->stock_quantity }}</span>
                                    @else
                                        <span class="text-danger">غير متوفر</span>
                                    @endif
                                </p>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold">التقييم</label>
                                <div class="d-flex align-items-center">
                                    <div class="text-warning me-2">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="fas fa-star{{ $i <= ($product->rating ?? 0) ? '' : '-o' }}"></i>
                                        @endfor
                                    </div>
                                    <span class="fw-bold">{{ number_format($product->rating ?? 0, 1) }}</span>
                                </div>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold">عدد الطلبات</label>
                                <p class="form-control-plaintext">{{ $product->orders->count() }}</p>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold">الحالة</label>
                                <p class="form-control-plaintext">
                                    @if($product->status == 'available')
                                        <span class="badge bg-success">متاح</span>
                                    @elseif($product->status == 'out_of_stock')
                                        <span class="badge bg-warning">نفذت الكمية</span>
                                    @else
                                        <span class="badge bg-danger">متوقف</span>
                                    @endif
                                </p>
                            </div>

                            @if($product->barcode)
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">الباركود</label>
                                <p class="form-control-plaintext">{{ $product->barcode }}</p>
                            </div>
                            @endif

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">تاريخ الإضافة</label>
                                <p class="form-control-plaintext">{{ $product->created_at->format('Y-m-d H:i') }}</p>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">آخر تحديث</label>
                                <p class="form-control-plaintext">{{ $product->updated_at->format('Y-m-d H:i') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 