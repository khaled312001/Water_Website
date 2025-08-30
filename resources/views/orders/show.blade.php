@extends('layouts.app')

@section('title', 'تفاصيل الطلب - سلسبيل مكة')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 shadow-lg" data-aos="fade-up">
                <div class="card-header bg-primary text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">
                            <i class="fas fa-shopping-bag me-2"></i>
                            تفاصيل الطلب #{{ $order->id }}
                        </h4>
                        <a href="{{ route('orders.index') }}" class="btn btn-light btn-sm">
                            <i class="fas fa-arrow-right me-1"></i>
                            العودة للطلبات
                        </a>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="fw-bold mb-3">معلومات المنتج</h6>
                            <div class="d-flex align-items-center mb-3">
                                @if($order->product->image)
                                    <img src="{{ asset('storage/' . $order->product->image) }}" 
                                         alt="{{ $order->product->name }}" 
                                         class="rounded me-3" 
                                         style="width: 80px; height: 80px; object-fit: cover;">
                                @endif
                                <div>
                                    <h6 class="mb-1">{{ $order->product->name }}</h6>
                                    <p class="text-muted mb-0">{{ $order->supplier->company_name }}</p>
                                    <small class="text-primary">{{ number_format($order->unit_price, 2) }} ريال للوحدة</small>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <strong>الكمية:</strong> {{ $order->quantity }}
                            </div>
                            
                            <div class="mb-3">
                                <strong>السعر الإجمالي:</strong> 
                                <span class="text-primary fw-bold">{{ number_format($order->total_amount, 2) }} ريال</span>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <h6 class="fw-bold mb-3">معلومات التوصيل</h6>
                            <div class="mb-3">
                                <strong>عنوان التوصيل:</strong><br>
                                <span class="text-muted">{{ $order->delivery_address }}</span>
                            </div>
                            
                            @if($order->delivery_notes)
                                <div class="mb-3">
                                    <strong>ملاحظات التوصيل:</strong><br>
                                    <span class="text-muted">{{ $order->delivery_notes }}</span>
                                </div>
                            @endif
                            
                            <div class="mb-3">
                                <strong>تاريخ الطلب:</strong><br>
                                <span class="text-muted">{{ $order->created_at->format('Y-m-d H:i') }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <hr class="my-4">
                    
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="fw-bold mb-3">حالة الطلب</h6>
                            <div class="mb-3">
                                @switch($order->status)
                                    @case('pending_payment')
                                        <span class="badge bg-danger fs-6">في انتظار الدفع</span>
                                        @break
                                    @case('pending')
                                        <span class="badge bg-warning fs-6">قيد الانتظار</span>
                                        @break
                                    @case('confirmed')
                                        <span class="badge bg-info fs-6">مؤكد</span>
                                        @break
                                    @case('processing')
                                        <span class="badge bg-primary fs-6">قيد المعالجة</span>
                                        @break
                                    @case('shipped')
                                        <span class="badge bg-secondary fs-6">تم الشحن</span>
                                        @break
                                    @case('delivered')
                                        <span class="badge bg-success fs-6">تم التوصيل</span>
                                        @break
                                    @case('cancelled')
                                        <span class="badge bg-danger fs-6">ملغي</span>
                                        @break
                                    @default
                                        <span class="badge bg-secondary fs-6">{{ $order->status }}</span>
                                @endswitch
                            </div>
                            
                            <div class="mb-3">
                                <strong>حالة الدفع:</strong>
                                @if($order->payment_status === 'paid')
                                    <span class="badge bg-success">مدفوع</span>
                                    @if($order->payment && $order->payment->status === 'pending')
                                        <br><small class="text-warning">
                                            <i class="fas fa-clock me-1"></i>
                                            في انتظار تأكيد الإدارة لعملية الدفع
                                        </small>
                                    @elseif($order->payment && $order->payment->status === 'verified')
                                        <br><small class="text-success">
                                            <i class="fas fa-check-circle me-1"></i>
                                            تم تأكيد الدفع من الإدارة
                                        </small>
                                    @endif
                                @else
                                    <span class="badge bg-warning">قيد الانتظار</span>
                                @endif
                            </div>

                            @if($order->payment)
                                <div class="mb-3">
                                    <strong>طريقة الدفع:</strong>
                                    <span class="badge bg-info">{{ $order->payment->payment_method_text }}</span>
                                </div>
                                
                                @if($order->payment->status === 'pending')
                                    <div class="alert alert-warning">
                                        <i class="fas fa-clock me-2"></i>
                                        في انتظار تأكيد عملية الدفع من الإدارة
                                        @if($order->payment->payment_method === 'bank_transfer')
                                            <br><small>يرجى إرفاق إيصال التحويل البنكي</small>
                                        @endif
                                    </div>
                                @elseif($order->payment->status === 'verified')
                                    <div class="alert alert-success">
                                        <i class="fas fa-check-circle me-2"></i>
                                        تم تأكيد الدفع من الإدارة بنجاح
                                    </div>
                                @elseif($order->payment->status === 'failed')
                                    <div class="alert alert-danger">
                                        <i class="fas fa-times-circle me-2"></i>
                                        تم رفض الدفع من الإدارة
                                        @if($order->payment->notes)
                                            <br><small>السبب: {{ $order->payment->notes }}</small>
                                        @endif
                                    </div>
                                @endif
                            @endif
                        </div>
                        
                        <div class="col-md-6">
                            <h6 class="fw-bold mb-3">معلومات المندوب</h6>
                            @if($order->deliveryMan)
                                <div class="mb-2">
                                    <strong>اسم المندوب:</strong> {{ $order->deliveryMan->user->name }}
                                </div>
                                <div class="mb-2">
                                    <strong>رقم الهاتف:</strong> {{ $order->deliveryMan->user->phone }}
                                </div>
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
                <div class="card-header bg-info text-white">
                    <h6 class="mb-0">
                        <i class="fas fa-truck me-2"></i>
                        تتبع الطلب
                    </h6>
                </div>
                <div class="card-body">
                    <a href="{{ route('orders.track', $order->id) }}" class="btn btn-info w-100 mb-3">
                        <i class="fas fa-map-marker-alt me-2"></i>
                        تتبع الطلب
                    </a>
                    
                    <div class="d-grid gap-2">
                        @if($order->status === 'pending_payment')
                            <a href="{{ route('payments.new-order', $order->id) }}" class="btn btn-danger">
                                <i class="fas fa-credit-card me-2"></i>
                                إتمام الدفع لتأكيد الطلب
                            </a>
                        @elseif(!$order->payment || $order->payment->status === 'pending')
                            <a href="{{ route('payments.show', $order->id) }}" class="btn btn-primary">
                                <i class="fas fa-credit-card me-2"></i>
                                إتمام الدفع
                            </a>
                        @endif
                        
                        <a href="{{ route('orders.index') }}" class="btn btn-outline-primary">
                            <i class="fas fa-list me-2"></i>
                            جميع الطلبات
                        </a>
                        <a href="{{ route('orders.create') }}" class="btn btn-outline-success">
                            <i class="fas fa-plus me-2"></i>
                            طلب جديد
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 