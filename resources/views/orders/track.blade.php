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
                                'pending' => ['قيد الانتظار', 'fas fa-clock', 'warning'],
                                'confirmed' => ['مؤكد', 'fas fa-check-circle', 'info'],
                                'processing' => ['قيد المعالجة', 'fas fa-cogs', 'primary'],
                                'shipped' => ['تم الشحن', 'fas fa-truck', 'secondary'],
                                'delivered' => ['تم التوصيل', 'fas fa-home', 'success']
                            ];
                        @endphp
                        
                        @foreach($statuses as $status => $info)
                            @php
                                $isActive = $order->status === $status;
                                $isCompleted = array_search($order->status, array_keys($statuses)) >= array_search($status, array_keys($statuses));
                            @endphp
                            
                            <div class="timeline-item">
                                <div class="timeline-marker {{ $isCompleted ? 'bg-' . $info[2] : 'bg-light' }}">
                                    <i class="{{ $info[1] }} {{ $isCompleted ? 'text-white' : 'text-muted' }}"></i>
                                </div>
                                <div class="timeline-content">
                                    <h6 class="mb-1 {{ $isActive ? 'fw-bold' : '' }}">{{ $info[0] }}</h6>
                                    @if($isActive)
                                        <small class="text-success">الحالة الحالية</small>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
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