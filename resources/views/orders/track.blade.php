@extends('layouts.app')

@section('title', 'تتبع الطلب - مياه مكة')

@section('content')
<!-- Breadcrumb -->
<section class="py-3 bg-light">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none">الرئيسية</a></li>
                <li class="breadcrumb-item"><a href="{{ route('orders.index') }}" class="text-decoration-none">طلباتي</a></li>
                <li class="breadcrumb-item active" aria-current="page">تتبع الطلب</li>
            </ol>
        </nav>
    </div>
</section>

<!-- Order Tracking -->
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="text-center mb-5" data-aos="fade-up">
                    <h1 class="display-5 fw-bold mb-3">تتبع طلبك</h1>
                    <p class="lead text-muted">تابع حالة طلبك خطوة بخطوة</p>
                </div>

                <!-- Order Details Card -->
                <div class="card border-0 shadow-sm mb-4" data-aos="fade-up">
                    <div class="card-header bg-primary text-white">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <h4 class="mb-0">
                                    <i class="fas fa-receipt me-2"></i>
                                    طلب رقم: {{ $order->order_number }}
                                </h4>
                            </div>
                            <div class="col-md-6 text-md-end">
                                <span class="badge bg-light text-primary fs-6 px-3 py-2">
                                    {{ $order->status_text }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <h6 class="fw-bold text-primary">تفاصيل الطلب</h6>
                                <p class="mb-1"><strong>التاريخ:</strong> {{ $order->created_at->format('Y-m-d H:i') }}</p>
                                <p class="mb-1"><strong>المنتج:</strong> {{ $order->product->name }}</p>
                                <p class="mb-1"><strong>الكمية:</strong> {{ $order->quantity }} صندوق</p>
                                <p class="mb-1"><strong>المورد:</strong> {{ $order->supplier->company_name }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <h6 class="fw-bold text-primary">معلومات التوصيل</h6>
                                <p class="mb-1"><strong>الاسم:</strong> {{ $order->customer_name }}</p>
                                <p class="mb-1"><strong>الهاتف:</strong> {{ $order->customer_phone }}</p>
                                <p class="mb-1"><strong>العنوان:</strong> {{ $order->delivery_address }}</p>
                                <p class="mb-1"><strong>المدينة:</strong> {{ $order->delivery_city }}</p>
                            </div>
                        </div>
                        
                        <hr>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="fw-bold text-primary">التكلفة</h6>
                                <div class="d-flex justify-content-between mb-1">
                                    <span>سعر الوحدة:</span>
                                    <span>{{ $order->formatted_unit_price }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-1">
                                    <span>المجموع الفرعي:</span>
                                    <span>{{ $order->formatted_subtotal }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-1">
                                    <span>رسوم التوصيل:</span>
                                    <span>{{ $order->delivery_fee }} ريال</span>
                                </div>
                                <div class="d-flex justify-content-between fw-bold">
                                    <span>الإجمالي:</span>
                                    <span class="text-primary">{{ $order->formatted_total }}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h6 class="fw-bold text-primary">معلومات الدفع</h6>
                                <p class="mb-1"><strong>طريقة الدفع:</strong> {{ $order->payment_method_text }}</p>
                                <p class="mb-1"><strong>حالة الدفع:</strong> 
                                    <span class="badge {{ $order->payment_status == 'paid' ? 'bg-success' : 'bg-warning' }}">
                                        {{ $order->payment_status_text }}
                                    </span>
                                </p>
                                @if($order->estimated_delivery_time)
                                    <p class="mb-1"><strong>وقت التوصيل المتوقع:</strong> {{ $order->estimated_delivery_time }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tracking Timeline -->
                <div class="card border-0 shadow-sm" data-aos="fade-up">
                    <div class="card-header bg-transparent border-0">
                        <h4 class="mb-0">
                            <i class="fas fa-route text-primary me-2"></i>
                            مسار الطلب
                        </h4>
                    </div>
                    <div class="card-body p-4">
                        <div class="timeline">
                            <!-- Step 1: Order Placed -->
                            <div class="timeline-item {{ $order->status != 'cancelled' ? 'completed' : '' }}">
                                <div class="timeline-marker">
                                    <i class="fas fa-shopping-cart"></i>
                                </div>
                                <div class="timeline-content">
                                    <h6 class="fw-bold">تم تقديم الطلب</h6>
                                    <p class="text-muted mb-1">{{ $order->created_at->format('Y-m-d H:i') }}</p>
                                    <p class="mb-0">تم استلام طلبك بنجاح وسيتم مراجعته قريباً</p>
                                </div>
                            </div>

                            <!-- Step 2: Order Confirmed -->
                            <div class="timeline-item {{ in_array($order->status, ['confirmed', 'processing', 'shipped', 'delivered']) ? 'completed' : '' }}">
                                <div class="timeline-marker">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                                <div class="timeline-content">
                                    <h6 class="fw-bold">تم تأكيد الطلب</h6>
                                    @if(in_array($order->status, ['confirmed', 'processing', 'shipped', 'delivered']))
                                        <p class="text-muted mb-1">{{ $order->updated_at->format('Y-m-d H:i') }}</p>
                                        <p class="mb-0">تم تأكيد طلبك وسيتم تجهيزه للتوصيل</p>
                                    @else
                                        <p class="text-muted mb-0">في انتظار تأكيد الطلب</p>
                                    @endif
                                </div>
                            </div>

                            <!-- Step 3: Processing -->
                            <div class="timeline-item {{ in_array($order->status, ['processing', 'shipped', 'delivered']) ? 'completed' : '' }}">
                                <div class="timeline-marker">
                                    <i class="fas fa-box"></i>
                                </div>
                                <div class="timeline-content">
                                    <h6 class="fw-bold">قيد التجهيز</h6>
                                    @if(in_array($order->status, ['processing', 'shipped', 'delivered']))
                                        <p class="text-muted mb-1">جاري تجهيز طلبك</p>
                                        <p class="mb-0">يتم تجهيز المنتجات وتعبئتها للتوصيل</p>
                                    @else
                                        <p class="text-muted mb-0">في انتظار بدء التجهيز</p>
                                    @endif
                                </div>
                            </div>

                            <!-- Step 4: Shipped -->
                            <div class="timeline-item {{ in_array($order->status, ['shipped', 'delivered']) ? 'completed' : '' }}">
                                <div class="timeline-marker">
                                    <i class="fas fa-truck"></i>
                                </div>
                                <div class="timeline-content">
                                    <h6 class="fw-bold">تم الشحن</h6>
                                    @if(in_array($order->status, ['shipped', 'delivered']))
                                        <p class="text-muted mb-1">تم تسليم الطلب لمندوب التوصيل</p>
                                        @if($order->delivery_man)
                                            <p class="mb-0">مندوب التوصيل: {{ $order->delivery_man->user->name }}</p>
                                        @endif
                                    @else
                                        <p class="text-muted mb-0">في انتظار الشحن</p>
                                    @endif
                                </div>
                            </div>

                            <!-- Step 5: Delivered -->
                            <div class="timeline-item {{ $order->status == 'delivered' ? 'completed' : '' }}">
                                <div class="timeline-marker">
                                    <i class="fas fa-home"></i>
                                </div>
                                <div class="timeline-content">
                                    <h6 class="fw-bold">تم التوصيل</h6>
                                    @if($order->status == 'delivered')
                                        <p class="text-muted mb-1">{{ $order->actual_delivery_time }}</p>
                                        <p class="mb-0">تم توصيل طلبك بنجاح</p>
                                    @else
                                        <p class="text-muted mb-0">في انتظار التوصيل</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Delivery Man Info -->
                @if($order->delivery_man && in_array($order->status, ['shipped', 'delivered']))
                <div class="card border-0 shadow-sm mt-4" data-aos="fade-up">
                    <div class="card-header bg-transparent border-0">
                        <h4 class="mb-0">
                            <i class="fas fa-user-tie text-primary me-2"></i>
                            مندوب التوصيل
                        </h4>
                    </div>
                    <div class="card-body p-4">
                        <div class="row align-items-center">
                            <div class="col-md-3 text-center">
                                <img src="{{ $order->delivery_man->profile_image ? asset('storage/' . $order->delivery_man->profile_image) : 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-4.0.3&auto=format&fit=crop&w=150&q=80' }}" 
                                     class="rounded-circle mb-3" alt="مندوب التوصيل" style="width: 100px; height: 100px; object-fit: cover;">
                            </div>
                            <div class="col-md-6">
                                <h5 class="mb-2">{{ $order->delivery_man->user->name }}</h5>
                                <p class="text-muted mb-2">
                                    <i class="fas fa-phone me-1"></i>
                                    {{ $order->delivery_man->user->phone }}
                                </p>
                                <p class="text-muted mb-2">
                                    <i class="fas fa-car me-1"></i>
                                    {{ $order->delivery_man->vehicle_type }} - {{ $order->delivery_man->vehicle_number }}
                                </p>
                                <div class="text-warning mb-2">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star{{ $i <= $order->delivery_man->rating ? '' : '-o' }}"></i>
                                    @endfor
                                    <span class="text-muted ms-2">({{ $order->delivery_man->rating }})</span>
                                </div>
                            </div>
                            <div class="col-md-3 text-center">
                                <a href="tel:{{ $order->delivery_man->user->phone }}" class="btn btn-primary mb-2">
                                    <i class="fas fa-phone me-2"></i>
                                    اتصل به
                                </a>
                                <a href="https://wa.me/{{ $order->delivery_man->user->phone }}" class="btn btn-success" target="_blank">
                                    <i class="fab fa-whatsapp me-2"></i>
                                    واتساب
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Action Buttons -->
                <div class="text-center mt-4" data-aos="fade-up">
                    <div class="d-flex flex-wrap justify-content-center gap-3">
                        <a href="{{ route('orders.index') }}" class="btn btn-outline-primary">
                            <i class="fas fa-arrow-left me-2"></i>
                            العودة لطلباتي
                        </a>
                        @if($order->status == 'delivered')
                            <a href="{{ route('reviews.create', ['order_id' => $order->id]) }}" class="btn btn-success">
                                <i class="fas fa-star me-2"></i>
                                قيم الطلب
                            </a>
                        @endif
                        @if($order->status == 'pending')
                            <button class="btn btn-danger" onclick="cancelOrder()">
                                <i class="fas fa-times me-2"></i>
                                إلغاء الطلب
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="100">
                <div class="text-center">
                    <div class="feature-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <h5 class="mb-2">تتبع فوري</h5>
                    <p class="text-muted small">تابع طلبك في الوقت الفعلي</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="200">
                <div class="text-center">
                    <div class="feature-icon">
                        <i class="fas fa-bell"></i>
                    </div>
                    <h5 class="mb-2">إشعارات فورية</h5>
                    <p class="text-muted small">احصل على تحديثات فورية</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="300">
                <div class="text-center">
                    <div class="feature-icon">
                        <i class="fas fa-headset"></i>
                    </div>
                    <h5 class="mb-2">دعم متواصل</h5>
                    <p class="text-muted small">فريق دعم متاح 24/7</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="400">
                <div class="text-center">
                    <div class="feature-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h5 class="mb-2">ضمان الجودة</h5>
                    <p class="text-muted small">جميع الطلبات مضمونة الجودة</p>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 15px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: #e9ecef;
}

.timeline-item {
    position: relative;
    margin-bottom: 30px;
    padding-left: 30px;
}

.timeline-item:last-child {
    margin-bottom: 0;
}

.timeline-marker {
    position: absolute;
    left: -22px;
    top: 0;
    width: 30px;
    height: 30px;
    border-radius: 50%;
    background: #e9ecef;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #6c757d;
    z-index: 1;
}

.timeline-item.completed .timeline-marker {
    background: var(--success-color);
    color: white;
}

.timeline-content {
    background: #f8f9fa;
    padding: 20px;
    border-radius: 10px;
    border-left: 4px solid #e9ecef;
}

.timeline-item.completed .timeline-content {
    border-left-color: var(--success-color);
    background: #f0f8f0;
}
</style>

<script>
function cancelOrder() {
    if (confirm('هل أنت متأكد من إلغاء هذا الطلب؟')) {
        // Add cancel order logic here
        alert('تم إرسال طلب الإلغاء بنجاح');
    }
}
</script>
@endsection 