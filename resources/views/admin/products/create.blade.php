@extends('layouts.admin')

@section('title', 'إضافة منتج جديد - سلسبيل مكة')
@section('page-title', 'إضافة منتج جديد')

@section('content')
<div class="fade-in">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="mb-0">إضافة منتج جديد</h4>
                    <a href="{{ route('admin.products') }}" class="btn btn-admin btn-outline-secondary">
                        <i class="fas fa-arrow-right me-2"></i>
                        العودة للقائمة
                    </a>
                </div>

                <form action="{{ route('admin.products.store') }}" method="POST">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">اسم المنتج *</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="supplier_id" class="form-label">المورد *</label>
                            <select class="form-select @error('supplier_id') is-invalid @enderror" id="supplier_id" name="supplier_id" required>
                                <option value="">اختر المورد</option>
                                @foreach($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}" {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>
                                        {{ $supplier->company_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('supplier_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="price_per_box" class="form-label">سعر الصندوق *</label>
                            <input type="number" step="0.01" class="form-control @error('price_per_box') is-invalid @enderror" 
                                   id="price_per_box" name="price_per_box" value="{{ old('price_per_box') }}" required>
                            @error('price_per_box')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="price_per_bottle" class="form-label">سعر العبوة *</label>
                            <input type="number" step="0.01" class="form-control @error('price_per_bottle') is-invalid @enderror" 
                                   id="price_per_bottle" name="price_per_bottle" value="{{ old('price_per_bottle') }}" required>
                            @error('price_per_bottle')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="quantity_per_box" class="form-label">عدد العبوات في الصندوق *</label>
                            <input type="number" class="form-control @error('quantity_per_box') is-invalid @enderror" 
                                   id="quantity_per_box" name="quantity_per_box" value="{{ old('quantity_per_box') }}" required>
                            @error('quantity_per_box')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="stock_quantity" class="form-label">الكمية المتوفرة *</label>
                            <input type="number" class="form-control @error('stock_quantity') is-invalid @enderror" 
                                   id="stock_quantity" name="stock_quantity" value="{{ old('stock_quantity', 0) }}" required>
                            @error('stock_quantity')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="brand" class="form-label">العلامة التجارية *</label>
                            <input type="text" class="form-control @error('brand') is-invalid @enderror" 
                                   id="brand" name="brand" value="{{ old('brand') }}" required>
                            @error('brand')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="size" class="form-label">حجم العبوة *</label>
                            <input type="text" class="form-control @error('size') is-invalid @enderror" 
                                   id="size" name="size" value="{{ old('size') }}" required>
                            @error('size')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="type" class="form-label">نوع المياه *</label>
                            <select class="form-select @error('type') is-invalid @enderror" id="type" name="type" required>
                                <option value="">اختر النوع</option>
                                <option value="mineral" {{ old('type') == 'mineral' ? 'selected' : '' }}>معدنية</option>
                                <option value="distilled" {{ old('type') == 'distilled' ? 'selected' : '' }}>مقطرة</option>
                                <option value="spring" {{ old('type') == 'spring' ? 'selected' : '' }}>عين طبيعية</option>
                                <option value="alkaline" {{ old('type') == 'alkaline' ? 'selected' : '' }}>قلوية</option>
                            </select>
                            @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="status" class="form-label">الحالة *</label>
                            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                <option value="available" {{ old('status') == 'available' ? 'selected' : '' }}>متاح</option>
                                <option value="out_of_stock" {{ old('status') == 'out_of_stock' ? 'selected' : '' }}>نفذت الكمية</option>
                                <option value="discontinued" {{ old('status') == 'discontinued' ? 'selected' : '' }}>متوقف</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12 mb-3">
                            <label for="description" class="form-label">الوصف</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="4">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-admin btn-primary">
                            <i class="fas fa-save me-2"></i>
                            حفظ المنتج
                        </button>
                        <a href="{{ route('admin.products') }}" class="btn btn-admin btn-outline-secondary">
                            إلغاء
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection 