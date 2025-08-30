@extends('layouts.supplier')

@section('title', 'إضافة منتج جديد - سلسبيل مكة')
@section('page-title', 'إضافة منتج جديد')

@section('content')
<div class="fade-in">
    <div class="row">
        <div class="col-12">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="mb-0">
                        <i class="fas fa-plus text-success me-2"></i>
                        إضافة منتج جديد
                    </h4>
                    <a href="{{ route('supplier.products') }}" class="btn btn-supplier btn-outline-secondary">
                        <i class="fas fa-arrow-right me-2"></i>
                        العودة للمنتجات
                    </a>
                </div>

                <form action="{{ route('supplier.products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">اسم المنتج *</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">العلامة التجارية *</label>
                            <input type="text" class="form-control @error('brand') is-invalid @enderror" 
                                   name="brand" value="{{ old('brand') }}" required>
                            @error('brand')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12 mb-3">
                            <label class="form-label">وصف المنتج *</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      name="description" rows="4" required>{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">حجم العبوة *</label>
                            <input type="text" class="form-control @error('size') is-invalid @enderror" 
                                   name="size" value="{{ old('size') }}" placeholder="مثال: 500 مل" required>
                            @error('size')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">عدد العبوات في الصندوق *</label>
                            <input type="number" class="form-control @error('quantity_per_box') is-invalid @enderror" 
                                   name="quantity_per_box" value="{{ old('quantity_per_box') }}" min="1" required>
                            @error('quantity_per_box')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">نوع الماء *</label>
                            <select class="form-select @error('type') is-invalid @enderror" name="type" required>
                                <option value="">اختر النوع</option>
                                <option value="mineral" {{ old('type') == 'mineral' ? 'selected' : '' }}>معدني</option>
                                <option value="distilled" {{ old('type') == 'distilled' ? 'selected' : '' }}>مقطر</option>
                                <option value="spring" {{ old('type') == 'spring' ? 'selected' : '' }}>عين</option>
                                <option value="alkaline" {{ old('type') == 'alkaline' ? 'selected' : '' }}>قلوي</option>
                            </select>
                            @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">سعر الصندوق (ريال) *</label>
                            <input type="number" step="0.01" class="form-control @error('price_per_box') is-invalid @enderror" 
                                   name="price_per_box" value="{{ old('price_per_box') }}" min="0" required>
                            @error('price_per_box')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">سعر العبوة (ريال) *</label>
                            <input type="number" step="0.01" class="form-control @error('price_per_bottle') is-invalid @enderror" 
                                   name="price_per_bottle" value="{{ old('price_per_bottle') }}" min="0" required>
                            @error('price_per_bottle')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">الكمية المتوفرة *</label>
                            <input type="number" class="form-control @error('stock_quantity') is-invalid @enderror" 
                                   name="stock_quantity" value="{{ old('stock_quantity') }}" min="0" required>
                            @error('stock_quantity')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">صورة المنتج</label>
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
                                   name="barcode" value="{{ old('barcode') }}">
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
                        <button type="submit" class="btn btn-supplier btn-primary">
                            <i class="fas fa-save me-2"></i>
                            حفظ المنتج
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection 