@extends('layouts.supplier')

@section('title', 'تعديل المنتج - سلسبيل مكة')
@section('page-title', 'تعديل المنتج')

@section('content')
<div class="fade-in">
    <div class="row">
        <div class="col-12">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="mb-0">
                        <i class="fas fa-edit text-warning me-2"></i>
                        تعديل المنتج
                    </h4>
                    <div class="d-flex gap-2">
                        <a href="{{ route('supplier.products.show', $product->id) }}" class="btn btn-supplier btn-info">
                            <i class="fas fa-eye me-2"></i>
                            عرض
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

                <form action="{{ route('supplier.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">اسم المنتج *</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   name="name" value="{{ old('name', $product->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">العلامة التجارية *</label>
                            <input type="text" class="form-control @error('brand') is-invalid @enderror" 
                                   name="brand" value="{{ old('brand', $product->brand) }}" required>
                            @error('brand')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12 mb-3">
                            <label class="form-label">وصف المنتج *</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      name="description" rows="4" required>{{ old('description', $product->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">حجم العبوة *</label>
                            <input type="text" class="form-control @error('size') is-invalid @enderror" 
                                   name="size" value="{{ old('size', $product->size) }}" placeholder="مثال: 500 مل" required>
                            @error('size')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">عدد العبوات في الصندوق *</label>
                            <input type="number" class="form-control @error('quantity_per_box') is-invalid @enderror" 
                                   name="quantity_per_box" value="{{ old('quantity_per_box', $product->quantity_per_box) }}" min="1" required>
                            @error('quantity_per_box')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">نوع الماء *</label>
                            <select class="form-select @error('type') is-invalid @enderror" name="type" required>
                                <option value="">اختر النوع</option>
                                <option value="mineral" {{ old('type', $product->type) == 'mineral' ? 'selected' : '' }}>معدني</option>
                                <option value="distilled" {{ old('type', $product->type) == 'distilled' ? 'selected' : '' }}>مقطر</option>
                                <option value="spring" {{ old('type', $product->type) == 'spring' ? 'selected' : '' }}>عين</option>
                                <option value="alkaline" {{ old('type', $product->type) == 'alkaline' ? 'selected' : '' }}>قلوي</option>
                            </select>
                            @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">سعر الصندوق (ريال) *</label>
                            <input type="number" step="0.01" class="form-control @error('price_per_box') is-invalid @enderror" 
                                   name="price_per_box" value="{{ old('price_per_box', $product->price_per_box) }}" min="0" required>
                            @error('price_per_box')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">سعر العبوة (ريال) *</label>
                            <input type="number" step="0.01" class="form-control @error('price_per_bottle') is-invalid @enderror" 
                                   name="price_per_bottle" value="{{ old('price_per_bottle', $product->price_per_bottle) }}" min="0" required>
                            @error('price_per_bottle')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">الكمية المتوفرة *</label>
                            <input type="number" class="form-control @error('stock_quantity') is-invalid @enderror" 
                                   name="stock_quantity" value="{{ old('stock_quantity', $product->stock_quantity) }}" min="0" required>
                            @error('stock_quantity')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">صورة المنتج</label>
                            @if($product->image)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="الصورة الحالية" 
                                         class="img-thumbnail" style="max-height: 100px;">
                                    <small class="form-text text-muted">الصورة الحالية</small>
                                </div>
                            @endif
                            <input type="file" class="form-control @error('image') is-invalid @enderror" 
                                   name="image" accept="image/*">
                            <small class="form-text text-muted">يُسمح بملفات JPG, PNG, GIF بحجم أقصى 2MB</small>
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">الباركود (اختياري)</label>
                            <input type="text" class="form-control @error('barcode') is-invalid @enderror" 
                                   name="barcode" value="{{ old('barcode', $product->barcode) }}">
                            @error('barcode')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="{{ route('supplier.products') }}" class="btn btn-supplier btn-outline-secondary">
                            <i class="fas fa-times me-2"></i>
                            إلغاء
                        </a>
                        <button type="submit" class="btn btn-supplier btn-warning">
                            <i class="fas fa-save me-2"></i>
                            حفظ التعديلات
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection 