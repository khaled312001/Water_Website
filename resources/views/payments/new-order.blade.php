@extends('layouts.app')

@section('title', 'إتمام الدفع - سلسبيل مكة')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-lg" data-aos="fade-up">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-credit-card me-2"></i>
                        إتمام الدفع لتأكيد الطلب
                    </h4>
                </div>
                <div class="card-body p-4">
                    <!-- معلومات الطلب -->
                    <div class="alert alert-info mb-4">
                        <h6 class="alert-heading">
                            <i class="fas fa-info-circle me-2"></i>
                            معلومات الطلب
                        </h6>
                        <p class="mb-2"><strong>رقم الطلب:</strong> {{ $order->order_number }}</p>
                        <p class="mb-2"><strong>المنتج:</strong> {{ $order->product->name }}</p>
                        <p class="mb-2"><strong>الكمية:</strong> {{ $order->quantity }}</p>
                        <p class="mb-0"><strong>المجموع:</strong> <span class="text-primary fw-bold">{{ number_format($order->total_amount, 2) }} ريال</span></p>
                    </div>

                    <!-- تفاصيل المنتج -->
                    <div class="card bg-light mb-4">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    @if($order->product->image)
                                        <img src="{{ asset('storage/' . $order->product->image) }}" 
                                             alt="{{ $order->product->name }}" 
                                             class="img-fluid rounded" 
                                             style="max-height: 120px; object-fit: cover;">
                                    @else
                                        <div class="bg-secondary rounded d-flex align-items-center justify-content-center" 
                                             style="height: 120px;">
                                            <i class="fas fa-box text-white" style="font-size: 2rem;"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-md-9">
                                    <h6 class="text-primary mb-2">{{ $order->product->name }}</h6>
                                    <p class="text-muted small mb-2">{{ $order->product->description }}</p>
                                    <div class="d-flex gap-2">
                                        <span class="badge bg-primary">{{ $order->product->brand }}</span>
                                        <span class="badge bg-secondary">{{ $order->product->size }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- نموذج الدفع -->
                    <form method="POST" action="{{ route('payments.process', $order->id) }}" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="mb-4">
                            <label class="form-label fw-bold">
                                <i class="fas fa-credit-card me-1"></i>
                                طريقة الدفع
                            </label>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <div class="card border-2 payment-method-card" data-method="cash">
                                        <div class="card-body text-center">
                                            <i class="fas fa-money-bill-wave text-success mb-2" style="font-size: 2rem;"></i>
                                            <h6 class="mb-1">الدفع النقدي</h6>
                                            <small class="text-muted">الدفع عند الاستلام</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="card border-2 payment-method-card" data-method="bank_transfer">
                                        <div class="card-body text-center">
                                            <i class="fas fa-university text-primary mb-2" style="font-size: 2rem;"></i>
                                            <h6 class="mb-1">تحويل بنكي</h6>
                                            <small class="text-muted">تحويل مباشر للبنك</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="card border-2 payment-method-card" data-method="visa">
                                        <div class="card-body text-center">
                                            <i class="fas fa-credit-card text-warning mb-2" style="font-size: 2rem;"></i>
                                            <h6 class="mb-1">بطاقة ائتمان</h6>
                                            <small class="text-muted">فيزا / ماستركارد</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="payment_method" id="payment_method" required>
                            @error('payment_method')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- حقول إضافية حسب طريقة الدفع -->
                        <div id="bank_transfer_fields" class="mb-4" style="display: none;">
                            <div class="card border-primary">
                                <div class="card-body">
                                    <h6 class="text-primary mb-3">
                                        <i class="fas fa-university me-2"></i>
                                        معلومات التحويل البنكي
                                    </h6>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p class="mb-1"><strong>اسم البنك:</strong> البنك الأهلي السعودي</p>
                                            <p class="mb-1"><strong>رقم الحساب:</strong> 1234567890</p>
                                            <p class="mb-1"><strong>اسم المستفيد:</strong> سلسبيل مكة</p>
                                        </div>
                                        <div class="col-md-6">
                                            <p class="mb-1"><strong>IBAN:</strong> SA0380000000608010167519</p>
                                            <p class="mb-1"><strong>المبلغ:</strong> {{ number_format($order->total_amount, 2) }} ريال</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="visa_fields" class="mb-4" style="display: none;">
                            <div class="card border-warning">
                                <div class="card-body">
                                    <h6 class="text-warning mb-3">
                                        <i class="fas fa-credit-card me-2"></i>
                                        معلومات البطاقة
                                    </h6>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">رقم البطاقة</label>
                                            <input type="text" class="form-control" placeholder="1234 5678 9012 3456" maxlength="19">
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label class="form-label">تاريخ الانتهاء</label>
                                            <input type="text" class="form-control" placeholder="MM/YY" maxlength="5">
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label class="form-label">CVV</label>
                                            <input type="text" class="form-control" placeholder="123" maxlength="3">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- حقول مشتركة -->
                        <div class="mb-3">
                            <label for="transaction_id" class="form-label">
                                <i class="fas fa-hashtag me-1"></i>
                                رقم العملية (اختياري)
                            </label>
                            <input type="text" class="form-control @error('transaction_id') is-invalid @enderror" 
                                   id="transaction_id" name="transaction_id" 
                                   placeholder="أدخل رقم العملية إذا كان متوفراً">
                            @error('transaction_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="receipt_image" class="form-label">
                                <i class="fas fa-image me-1"></i>
                                صورة الإيصال (اختياري)
                            </label>
                            <input type="file" class="form-control @error('receipt_image') is-invalid @enderror" 
                                   id="receipt_image" name="receipt_image" accept="image/*">
                            <small class="text-muted">يمكنك رفع صورة الإيصال كدليل على الدفع</small>
                            @error('receipt_image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="notes" class="form-label">
                                <i class="fas fa-sticky-note me-1"></i>
                                ملاحظات إضافية (اختياري)
                            </label>
                            <textarea class="form-control @error('notes') is-invalid @enderror" 
                                      id="notes" name="notes" rows="3" 
                                      placeholder="أي ملاحظات إضافية حول عملية الدفع">{{ old('notes') }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- ملخص الدفع -->
                        <div class="card bg-light mb-4">
                            <div class="card-body">
                                <h6 class="card-title">
                                    <i class="fas fa-calculator me-2"></i>
                                    ملخص الدفع
                                </h6>
                                <div class="row">
                                    <div class="col-md-6">
                                        <p class="mb-1"><strong>سعر المنتج:</strong> {{ number_format($order->subtotal, 2) }} ريال</p>
                                        <p class="mb-1"><strong>رسوم التوصيل:</strong> {{ number_format($order->delivery_fee, 2) }} ريال</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="mb-1"><strong>المجموع:</strong></p>
                                        <h5 class="text-primary fw-bold mb-0">{{ number_format($order->total_amount, 2) }} ريال</h5>
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
                                إتمام الدفع وتأكيد الطلب
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
    const paymentMethodCards = document.querySelectorAll('.payment-method-card');
    const paymentMethodInput = document.getElementById('payment_method');
    const bankTransferFields = document.getElementById('bank_transfer_fields');
    const visaFields = document.getElementById('visa_fields');

    // إضافة حدث النقر على طرق الدفع
    paymentMethodCards.forEach(card => {
        card.addEventListener('click', function() {
            // إزالة التحديد من جميع البطاقات
            paymentMethodCards.forEach(c => {
                c.classList.remove('border-primary');
                c.classList.add('border-2');
            });
            
            // تحديد البطاقة المختارة
            this.classList.remove('border-2');
            this.classList.add('border-primary');
            
            // تحديث قيمة طريقة الدفع
            const method = this.dataset.method;
            paymentMethodInput.value = method;
            
            // إظهار/إخفاء الحقول الإضافية
            bankTransferFields.style.display = method === 'bank_transfer' ? 'block' : 'none';
            visaFields.style.display = method === 'visa' ? 'block' : 'none';
        });
    });

    // تحديد الدفع النقدي افتراضياً
    const cashCard = document.querySelector('[data-method="cash"]');
    if (cashCard) {
        cashCard.click();
    }
});
</script>

<style>
.payment-method-card {
    cursor: pointer;
    transition: all 0.3s ease;
}

.payment-method-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.payment-method-card.border-primary {
    background-color: #f8f9ff;
}
</style>
@endsection 