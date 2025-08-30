@extends('layouts.app')

@section('title', 'الدفع - سلسبيل مكة')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-lg" data-aos="fade-up">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-credit-card me-2"></i>
                        إتمام الدفع
                    </h4>
                </div>
                <div class="card-body p-4">
                    <!-- تفاصيل الطلب -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5 class="text-primary mb-3">
                                <i class="fas fa-shopping-cart me-2"></i>
                                تفاصيل الطلب
                            </h5>
                            <div class="bg-light p-3 rounded">
                                <p><strong>رقم الطلب:</strong> {{ $order->order_number }}</p>
                                <p><strong>المنتج:</strong> {{ $order->product->name }}</p>
                                <p><strong>الكمية:</strong> {{ $order->quantity }}</p>
                                <p><strong>السعر الإجمالي:</strong> {{ $order->formatted_total }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h5 class="text-primary mb-3">
                                <i class="fas fa-map-marker-alt me-2"></i>
                                عنوان التوصيل
                            </h5>
                            <div class="bg-light p-3 rounded">
                                <p><strong>الاسم:</strong> {{ $order->customer_name }}</p>
                                <p><strong>الهاتف:</strong> {{ $order->customer_phone }}</p>
                                <p><strong>العنوان:</strong> {{ $order->delivery_address }}</p>
                                <p><strong>المدينة:</strong> {{ $order->delivery_city }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- طرق الدفع -->
                    <div class="mb-4">
                        <h5 class="text-primary mb-3">
                            <i class="fas fa-credit-card me-2"></i>
                            اختر طريقة الدفع
                        </h5>
                        
                        <form method="POST" action="{{ route('payments.process', $order->id) }}" enctype="multipart/form-data">
                            @csrf
                            
                            <!-- فيزا -->
                            <div class="card mb-3 border-2" id="visa-card">
                                <div class="card-body">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="payment_method" id="visa" value="visa">
                                        <label class="form-check-label fw-bold" for="visa">
                                            <i class="fab fa-cc-visa text-primary me-2"></i>
                                            الدفع ببطاقة فيزا
                                        </label>
                                    </div>
                                    <div class="visa-details mt-3" style="display: none;">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="card_number" class="form-label">رقم البطاقة</label>
                                                <input type="text" class="form-control" id="card_number" placeholder="1234 5678 9012 3456">
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label for="expiry" class="form-label">تاريخ الانتهاء</label>
                                                <input type="text" class="form-control" id="expiry" placeholder="MM/YY">
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label for="cvv" class="form-label">CVV</label>
                                                <input type="text" class="form-control" id="cvv" placeholder="123">
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="card_holder" class="form-label">اسم حامل البطاقة</label>
                                            <input type="text" class="form-control" id="card_holder" placeholder="اسم حامل البطاقة">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- تحويل بنكي -->
                            <div class="card mb-3 border-2" id="bank-card">
                                <div class="card-body">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="payment_method" id="bank_transfer" value="bank_transfer">
                                        <label class="form-check-label fw-bold" for="bank_transfer">
                                            <i class="fas fa-university text-success me-2"></i>
                                            التحويل البنكي
                                        </label>
                                    </div>
                                    <div class="bank-details mt-3" style="display: none;">
                                        <div class="alert alert-info">
                                            <h6 class="alert-heading">
                                                <i class="fas fa-info-circle me-2"></i>
                                                معلومات الحساب البنكي
                                            </h6>
                                            <p class="mb-2"><strong>اسم البنك:</strong> البنك الأهلي السعودي</p>
                                            <p class="mb-2"><strong>رقم الحساب:</strong> 1234567890</p>
                                            <p class="mb-2"><strong>IBAN:</strong> SA0380000000608010167519</p>
                                            <p class="mb-0"><strong>اسم المستفيد:</strong> سلسبيل مكة للمياه</p>
                                        </div>
                                        <div class="mb-3">
                                            <label for="transaction_id" class="form-label">رقم العملية البنكية</label>
                                            <input type="text" class="form-control" name="transaction_id" placeholder="أدخل رقم العملية">
                                        </div>
                                        <div class="mb-3">
                                            <label for="receipt_image" class="form-label">صورة الإيصال</label>
                                            <input type="file" class="form-control" name="receipt_image" accept="image/*">
                                            <div class="form-text">قم برفع صورة واضحة لإيصال التحويل البنكي</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- الدفع نقداً -->
                            <div class="card mb-3 border-2" id="cash-card">
                                <div class="card-body">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="payment_method" id="cash" value="cash">
                                        <label class="form-check-label fw-bold" for="cash">
                                            <i class="fas fa-money-bill-wave text-success me-2"></i>
                                            الدفع نقداً عند التوصيل
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <!-- ملاحظات -->
                            <div class="mb-4">
                                <label for="notes" class="form-label">ملاحظات إضافية (اختياري)</label>
                                <textarea class="form-control" name="notes" id="notes" rows="3" placeholder="أي ملاحظات إضافية..."></textarea>
                            </div>

                            <!-- أزرار التحكم -->
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <a href="{{ route('orders.show', $order->id) }}" class="btn btn-outline-secondary btn-lg">
                                    <i class="fas fa-arrow-right me-2"></i>
                                    إلغاء
                                </a>
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fas fa-check me-2"></i>
                                    إتمام الدفع
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const visaRadio = document.getElementById('visa');
    const bankRadio = document.getElementById('bank_transfer');
    const cashRadio = document.getElementById('cash');
    const visaDetails = document.querySelector('.visa-details');
    const bankDetails = document.querySelector('.bank-details');

    // إظهار/إخفاء تفاصيل فيزا
    visaRadio.addEventListener('change', function() {
        if (this.checked) {
            visaDetails.style.display = 'block';
            bankDetails.style.display = 'none';
        }
    });

    // إظهار/إخفاء تفاصيل التحويل البنكي
    bankRadio.addEventListener('change', function() {
        if (this.checked) {
            bankDetails.style.display = 'block';
            visaDetails.style.display = 'none';
        }
    });

    // إخفاء التفاصيل عند اختيار الدفع نقداً
    cashRadio.addEventListener('change', function() {
        if (this.checked) {
            visaDetails.style.display = 'none';
            bankDetails.style.display = 'none';
        }
    });

    // تنسيق رقم البطاقة
    const cardNumber = document.getElementById('card_number');
    if (cardNumber) {
        cardNumber.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\s+/g, '').replace(/[^0-9]/gi, '');
            let formattedValue = value.match(/.{1,4}/g)?.join(' ') || value;
            e.target.value = formattedValue;
        });
    }

    // تنسيق تاريخ الانتهاء
    const expiry = document.getElementById('expiry');
    if (expiry) {
        expiry.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length >= 2) {
                value = value.substring(0, 2) + '/' + value.substring(2, 4);
            }
            e.target.value = value;
        });
    }
});
</script>
@endsection 