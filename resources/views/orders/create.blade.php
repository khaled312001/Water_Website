@extends('layouts.app')

@section('title', 'إنشاء طلب جديد - سلسبيل مكة')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-lg" data-aos="fade-up">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-plus me-2"></i>
                        إنشاء طلب جديد
                    </h4>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('orders.store') }}">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="product_id" class="form-label fw-bold">
                                <i class="fas fa-box me-1"></i>
                                المنتج
                            </label>
                            <select class="form-select @error('product_id') is-invalid @enderror" 
                                    id="product_id" name="product_id" required>
                                <option value="">اختر المنتج</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}" 
                                            data-price="{{ $product->price_per_box }}"
                                            data-supplier="{{ $product->supplier->company_name }}">
                                        {{ $product->name }} - {{ $product->supplier->company_name }} 
                                        ({{ number_format($product->price_per_box, 2) }} ريال)
                                    </option>
                                @endforeach
                            </select>
                            @error('product_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="quantity" class="form-label fw-bold">
                                <i class="fas fa-sort-numeric-up me-1"></i>
                                الكمية
                            </label>
                            <input type="number" class="form-control @error('quantity') is-invalid @enderror" 
                                   id="quantity" name="quantity" min="1" max="50" value="1" required>
                            @error('quantity')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="delivery_address" class="form-label fw-bold">
                                <i class="fas fa-map-marker-alt me-1"></i>
                                عنوان التوصيل
                            </label>
                            <textarea class="form-control @error('delivery_address') is-invalid @enderror" 
                                      id="delivery_address" name="delivery_address" rows="3" 
                                      placeholder="أدخل عنوان التوصيل الكامل" required>{{ old('delivery_address', auth()->user()->address) }}</textarea>
                            @error('delivery_address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="delivery_notes" class="form-label fw-bold">
                                <i class="fas fa-sticky-note me-1"></i>
                                ملاحظات التوصيل (اختياري)
                            </label>
                            <textarea class="form-control @error('delivery_notes') is-invalid @enderror" 
                                      id="delivery_notes" name="delivery_notes" rows="3" 
                                      placeholder="أي ملاحظات إضافية للتوصيل">{{ old('delivery_notes') }}</textarea>
                            @error('delivery_notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Order Summary -->
                        <div class="card bg-light mb-4">
                            <div class="card-body">
                                <h6 class="card-title">
                                    <i class="fas fa-calculator me-2"></i>
                                    ملخص الطلب
                                </h6>
                                <div class="row">
                                    <div class="col-md-6">
                                        <p class="mb-1"><strong>المنتج:</strong> <span id="selectedProduct">-</span></p>
                                        <p class="mb-1"><strong>المورد:</strong> <span id="selectedSupplier">-</span></p>
                                        <p class="mb-1"><strong>السعر للوحدة:</strong> <span id="unitPrice">-</span></p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="mb-1"><strong>الكمية:</strong> <span id="selectedQuantity">1</span></p>
                                        <p class="mb-1"><strong>المجموع:</strong> <span id="totalAmount" class="text-primary fw-bold">-</span></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary btn-lg">
                                <i class="fas fa-arrow-right me-2"></i>
                                إلغاء
                            </a>
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-check me-2"></i>
                                إنشاء الطلب
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const productSelect = document.getElementById('product_id');
    const quantityInput = document.getElementById('quantity');
    const selectedProduct = document.getElementById('selectedProduct');
    const selectedSupplier = document.getElementById('selectedSupplier');
    const unitPrice = document.getElementById('unitPrice');
    const selectedQuantity = document.getElementById('selectedQuantity');
    const totalAmount = document.getElementById('totalAmount');

    function updateOrderSummary() {
        const selectedOption = productSelect.options[productSelect.selectedIndex];
        
        if (productSelect.value) {
            const price = parseFloat(selectedOption.dataset.price);
            const quantity = parseInt(quantityInput.value);
            const total = price * quantity;

            selectedProduct.textContent = selectedOption.text.split(' - ')[0];
            selectedSupplier.textContent = selectedOption.dataset.supplier;
            unitPrice.textContent = price.toFixed(2) + ' ريال';
            selectedQuantity.textContent = quantity;
            totalAmount.textContent = total.toFixed(2) + ' ريال';
        } else {
            selectedProduct.textContent = '-';
            selectedSupplier.textContent = '-';
            unitPrice.textContent = '-';
            selectedQuantity.textContent = '1';
            totalAmount.textContent = '-';
        }
    }

    productSelect.addEventListener('change', updateOrderSummary);
    quantityInput.addEventListener('input', updateOrderSummary);
});
</script>
@endsection 