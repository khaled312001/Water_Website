@extends('layouts.app')

@section('title', 'سلة التسوق - مياه مكة')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 shadow-lg" data-aos="fade-up">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-shopping-cart me-2"></i>
                        سلة التسوق
                    </h4>
                </div>
                <div class="card-body p-4">
                    @if(count($cartItems) > 0)
                        <div class="cart-items">
                            @foreach($cartItems as $item)
                                <div class="cart-item border-bottom pb-3 mb-3" data-product-id="{{ $item['product']->id }}">
                                    <div class="row align-items-center">
                                        <div class="col-md-2">
                                            <img src="{{ asset('storage/' . $item['product']->image) }}" 
                                                 alt="{{ $item['product']->name }}" 
                                                 class="img-fluid rounded" 
                                                 style="width: 80px; height: 80px; object-fit: cover;">
                                        </div>
                                        <div class="col-md-4">
                                            <h6 class="mb-1">{{ $item['product']->name }}</h6>
                                            <small class="text-muted">{{ $item['product']->supplier->company_name }}</small>
                                            <div class="text-primary fw-bold">{{ number_format($item['product']->price, 2) }} ريال</div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="input-group input-group-sm">
                                                <button class="btn btn-outline-secondary decrease-quantity" type="button">
                                                    <i class="fas fa-minus"></i>
                                                </button>
                                                <input type="number" class="form-control text-center quantity-input" 
                                                       value="{{ $item['quantity'] }}" min="1" max="50">
                                                <button class="btn btn-outline-secondary increase-quantity" type="button">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="col-md-2 text-end">
                                            <div class="fw-bold text-primary">{{ number_format($item['subtotal'], 2) }} ريال</div>
                                        </div>
                                        <div class="col-md-1 text-end">
                                            <button class="btn btn-outline-danger btn-sm remove-item" 
                                                    data-product-id="{{ $item['product']->id }}">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <button class="btn btn-outline-danger" id="clearCart">
                                <i class="fas fa-trash me-2"></i>
                                تفريغ السلة
                            </button>
                            <div class="text-end">
                                <h5 class="mb-0">
                                    المجموع: <span class="text-primary">{{ number_format($total, 2) }} ريال</span>
                                </h5>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-shopping-cart text-muted" style="font-size: 4rem;"></i>
                            <h4 class="mt-3 text-muted">السلة فارغة</h4>
                            <p class="text-muted">لم تقم بإضافة أي منتجات إلى السلة بعد</p>
                            <a href="{{ route('products.index') }}" class="btn btn-primary">
                                <i class="fas fa-shopping-bag me-2"></i>
                                تصفح المنتجات
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            @if(count($cartItems) > 0)
                <div class="card border-0 shadow-lg" data-aos="fade-up" data-aos-delay="200">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-credit-card me-2"></i>
                            ملخص الطلب
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <span>عدد المنتجات:</span>
                            <span>{{ count($cartItems) }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>إجمالي الكمية:</span>
                            <span>{{ array_sum(array_column($cartItems, 'quantity')) }}</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-3">
                            <strong>المجموع الكلي:</strong>
                            <strong class="text-primary">{{ number_format($total, 2) }} ريال</strong>
                        </div>
                        
                        <form action="{{ route('orders.create') }}" method="GET">
                            <button type="submit" class="btn btn-success btn-lg w-100">
                                <i class="fas fa-check me-2"></i>
                                إتمام الطلب
                            </button>
                        </form>
                        
                        <div class="text-center mt-3">
                            <a href="{{ route('products.index') }}" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-plus me-1"></i>
                                إضافة المزيد
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Update quantity
    function updateQuantity(productId, quantity) {
        fetch(`/cart/update/${productId}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ quantity: quantity })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                updateCartCount(data.cart_count);
                location.reload(); // Refresh to update totals
            } else {
                alert('حدث خطأ أثناء تحديث الكمية');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('حدث خطأ أثناء تحديث الكمية');
        });
    }

    // Remove item
    function removeItem(productId) {
        if (confirm('هل أنت متأكد من إزالة هذا المنتج من السلة؟')) {
            fetch(`/cart/remove/${productId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    updateCartCount(data.cart_count);
                    location.reload();
                } else {
                    alert('حدث خطأ أثناء إزالة المنتج');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('حدث خطأ أثناء إزالة المنتج');
            });
        }
    }

    // Clear cart
    document.getElementById('clearCart')?.addEventListener('click', function() {
        if (confirm('هل أنت متأكد من تفريغ السلة؟')) {
            fetch('/cart/clear', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    updateCartCount(data.cart_count);
                    location.reload();
                } else {
                    alert('حدث خطأ أثناء تفريغ السلة');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('حدث خطأ أثناء تفريغ السلة');
            });
        }
    });

    // Quantity controls
    document.querySelectorAll('.increase-quantity').forEach(button => {
        button.addEventListener('click', function() {
            const input = this.parentElement.querySelector('.quantity-input');
            const productId = this.closest('.cart-item').dataset.productId;
            const newQuantity = parseInt(input.value) + 1;
            
            if (newQuantity <= 50) {
                input.value = newQuantity;
                updateQuantity(productId, newQuantity);
            }
        });
    });

    document.querySelectorAll('.decrease-quantity').forEach(button => {
        button.addEventListener('click', function() {
            const input = this.parentElement.querySelector('.quantity-input');
            const productId = this.closest('.cart-item').dataset.productId;
            const newQuantity = parseInt(input.value) - 1;
            
            if (newQuantity >= 1) {
                input.value = newQuantity;
                updateQuantity(productId, newQuantity);
            }
        });
    });

    // Quantity input change
    document.querySelectorAll('.quantity-input').forEach(input => {
        input.addEventListener('change', function() {
            const productId = this.closest('.cart-item').dataset.productId;
            const quantity = parseInt(this.value);
            
            if (quantity >= 1 && quantity <= 50) {
                updateQuantity(productId, quantity);
            } else {
                this.value = 1;
                updateQuantity(productId, 1);
            }
        });
    });

    // Remove item buttons
    document.querySelectorAll('.remove-item').forEach(button => {
        button.addEventListener('click', function() {
            const productId = this.dataset.productId;
            removeItem(productId);
        });
    });

    // Update cart count in header
    function updateCartCount(count) {
        const cartCount = document.getElementById('cartCount');
        if (cartCount) {
            if (count > 0) {
                cartCount.textContent = count;
                cartCount.style.display = 'block';
            } else {
                cartCount.style.display = 'none';
            }
        }
    }
});
</script>
@endsection 