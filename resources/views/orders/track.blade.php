@extends('layouts.app')

@section('title', 'تتبع الطلب - سلسبيل مكة')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 shadow-lg" data-aos="fade-up">
                <div class="card-header bg-info text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">
                            <i class="fas fa-truck me-2"></i>
                            تتبع الطلب #{{ $order->id }}
                        </h4>
                        <a href="{{ route('orders.show', $order->id) }}" class="btn btn-light btn-sm">
                            <i class="fas fa-arrow-right me-1"></i>
                            تفاصيل الطلب
                        </a>
                    </div>
                </div>
                <div class="card-body p-4">
                    <!-- Order Status Timeline -->
                    <div class="timeline">
                        @php
                            $statuses = [
                                'pending' => ['قيد الانتظار', 'fas fa-clock', 'warning', 'تم استلام طلبك بنجاح'],
                                'confirmed' => ['مؤكد', 'fas fa-check-circle', 'info', 'تم تأكيد طلبك من الإدارة'],
                                'preparing' => ['قيد التحضير', 'fas fa-cogs', 'primary', 'جاري تحضير طلبك'],
                                'assigned' => ['تم التعيين', 'fas fa-user', 'secondary', 'تم تعيين مندوب التوصيل'],
                                'picked_up' => ['تم الاستلام', 'fas fa-truck', 'info', 'تم استلام الطلب من المندوب'],
                                'delivered' => ['تم التوصيل', 'fas fa-home', 'success', 'تم توصيل الطلب بنجاح']
                            ];
                            
                            $currentStatusIndex = array_search($order->status, array_keys($statuses));
                            if ($currentStatusIndex === false) {
                                $currentStatusIndex = 0; // إذا كانت الحالة غير موجودة، نبدأ من البداية
                            }
                            
                            // إذا كان المندوب معين في حالة التحضير، نعتبر أن مرحلة التعيين مكتملة
                            if ($order->status === 'preparing' && $order->deliveryMan) {
                                $assignedIndex = array_search('assigned', array_keys($statuses));
                                if ($assignedIndex !== false && $assignedIndex < $currentStatusIndex) {
                                    $currentStatusIndex = $assignedIndex;
                                }
                            }
                        @endphp
                        
                        @foreach($statuses as $status => $info)
                            @php
                                $index = array_search($status, array_keys($statuses));
                            @endphp
                            @php
                                $isActive = $order->status === $status;
                                $isCompleted = $index <= $currentStatusIndex;
                                $isFuture = $index > $currentStatusIndex;
                            @endphp
                            
                            <div class="timeline-item">
                                <div class="timeline-marker {{ $isCompleted ? 'bg-' . $info[2] : 'bg-light' }}">
                                    <i class="{{ $info[1] }} {{ $isCompleted ? 'text-white' : 'text-muted' }}"></i>
                                </div>
                                <div class="timeline-content">
                                    <h6 class="mb-1 {{ $isActive ? 'fw-bold' : '' }}">{{ $info[0] }}</h6>
                                    @if($isActive)
                                        <small class="text-success">الحالة الحالية</small>
                                        <p class="text-muted mb-0 mt-1">{{ $info[3] }}</p>
                                    @elseif($isCompleted)
                                        <small class="text-success">مكتمل</small>
                                        <p class="text-muted mb-0 mt-1">{{ $info[3] }}</p>
                                    @else
                                        <small class="text-muted">قادم</small>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <!-- Current Status Alert -->
                    <div class="alert alert-info mt-4">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-info-circle me-3 fs-4"></i>
                            <div>
                                <h6 class="mb-1">الحالة الحالية: {{ $order->status_text }}</h6>
                                @if($order->status === 'pending')
                                    <p class="mb-0">طلبك قيد المراجعة من الإدارة. سيتم تأكيده قريباً.</p>
                                @elseif($order->status === 'confirmed')
                                    <p class="mb-0">تم تأكيد طلبك. جاري تحضيره.</p>
                                @elseif($order->status === 'preparing')
                                    @if($order->deliveryMan)
                                        <p class="mb-0">جاري تحضير طلبك. تم تعيين مندوب التوصيل: {{ $order->deliveryMan->user->name }}</p>
                                    @else
                                        <p class="mb-0">جاري تحضير طلبك. سيتم تعيين مندوب التوصيل قريباً.</p>
                                    @endif
                                @elseif($order->status === 'assigned')
                                    <p class="mb-0">تم تعيين مندوب التوصيل لطلبك. سيتم التواصل معك قريباً.</p>
                                @elseif($order->status === 'picked_up')
                                    <p class="mb-0">تم استلام طلبك من المندوب. في الطريق إليك.</p>
                                @elseif($order->status === 'delivered')
                                    <p class="mb-0">تم توصيل طلبك بنجاح. نتمنى لك تجربة طيبة!</p>
                                @else
                                    <p class="mb-0">طلبك في مرحلة {{ $order->status_text }}.</p>
                                @endif
                                <small class="text-muted">تاريخ الطلب: {{ $order->created_at->format('Y-m-d H:i') }}</small>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Estimated Delivery Time -->
                    @if($order->estimated_delivery_time)
                        <div class="alert alert-success mt-3">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-clock me-3 fs-4"></i>
                                <div>
                                    <h6 class="mb-1">الوقت المتوقع للتوصيل</h6>
                                    <p class="mb-0">{{ $order->estimated_delivery_time->format('Y-m-d H:i') }}</p>
                                </div>
                            </div>
                        </div>
                    @endif
                    
                    <!-- Delivery Man Assigned Alert -->
                    @if($order->deliveryMan && $order->status === 'preparing')
                        <div class="alert alert-warning mt-3">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-user me-3 fs-4"></i>
                                <div>
                                    <h6 class="mb-1">تم تعيين مندوب التوصيل</h6>
                                    <p class="mb-0">تم تعيين {{ $order->deliveryMan->user->name }} لطلبك. سيبدأ في تحضير الطلب قريباً.</p>
                                </div>
                            </div>
                        </div>
                    @endif
                    
                    <hr class="my-4">
                    
                    <!-- Delivery Information -->
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="fw-bold mb-3">معلومات التوصيل</h6>
                            <div class="mb-3">
                                <strong>عنوان التوصيل:</strong><br>
                                <span class="text-muted">{{ $order->delivery_address }}</span>
                            </div>
                            
                            @if($order->delivery_notes)
                                <div class="mb-3">
                                    <strong>ملاحظات:</strong><br>
                                    <span class="text-muted">{{ $order->delivery_notes }}</span>
                                </div>
                            @endif
                            
                            <div class="mb-3">
                                <strong>حالة الدفع:</strong><br>
                                @php
                                    $paymentStatusColors = [
                                        'pending' => 'warning',
                                        'paid' => 'success',
                                        'failed' => 'danger'
                                    ];
                                    $paymentStatusColor = $paymentStatusColors[$order->payment_status] ?? 'secondary';
                                @endphp
                                <span class="badge bg-{{ $paymentStatusColor }}">{{ $order->payment_status_text }}</span>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <h6 class="fw-bold mb-3">معلومات المندوب</h6>
                            @if($order->deliveryMan)
                                <div class="mb-2">
                                    <strong>اسم المندوب:</strong> {{ $order->deliveryMan->user->name }}
                                </div>
                                <div class="mb-2">
                                    <strong>رقم الهاتف:</strong> 
                                    <a href="tel:{{ $order->deliveryMan->user->phone }}" class="text-decoration-none">
                                        {{ $order->deliveryMan->user->phone }}
                                    </a>
                                </div>
                                @if($order->deliveryMan->vehicle_type)
                                    <div class="mb-2">
                                        <strong>نوع المركبة:</strong> {{ $order->deliveryMan->vehicle_type }}
                                    </div>
                                @endif
                            @else
                                <p class="text-muted">لم يتم تعيين مندوب بعد</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="card border-0 shadow-lg" data-aos="fade-up" data-aos-delay="200">
                <div class="card-header bg-primary text-white">
                    <h6 class="mb-0">
                        <i class="fas fa-info-circle me-2"></i>
                        معلومات الطلب
                    </h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <strong>رقم الطلب:</strong> #{{ $order->id }}
                    </div>
                    
                    <div class="mb-3">
                        <strong>المنتج:</strong> {{ $order->product->name }}
                    </div>
                    
                    <div class="mb-3">
                        <strong>الكمية:</strong> {{ $order->quantity }}
                    </div>
                    
                    <div class="mb-3">
                        <strong>السعر الإجمالي:</strong> 
                        <span class="text-primary fw-bold">{{ number_format($order->total_amount, 2) }} ريال</span>
                    </div>
                    
                    <div class="mb-3">
                        <strong>تاريخ الطلب:</strong><br>
                        <span class="text-muted">{{ $order->created_at->format('Y-m-d H:i') }}</span>
                    </div>
                    
                    <hr>
                    
                    <div class="d-grid gap-2">
                        <a href="{{ route('orders.show', $order->id) }}" class="btn btn-outline-primary">
                            <i class="fas fa-eye me-2"></i>
                            تفاصيل الطلب
                        </a>
                        <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-list me-2"></i>
                            جميع الطلبات
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

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
}

.timeline-marker {
    position: absolute;
    left: -22px;
    top: 0;
    width: 30px;
    height: 30px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 3px solid #fff;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.timeline-content {
    padding-left: 20px;
}
</style>
@endsection 