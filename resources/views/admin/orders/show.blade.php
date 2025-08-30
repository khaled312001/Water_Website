@extends('layouts.admin')

@section('title', 'تفاصيل الطلب - سلسبيل مكة')
@section('page-title', 'تفاصيل الطلب')

@section('content')
<div class="fade-in">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="mb-0">تفاصيل الطلب: #{{ $order->order_number ?? $order->id }}</h4>
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.orders.edit', $order->id) }}" class="btn btn-admin btn-warning">
                            <i class="fas fa-edit me-2"></i>
                            تعديل
                        </a>
                        <a href="{{ route('admin.orders') }}" class="btn btn-admin btn-outline-secondary">
                            <i class="fas fa-arrow-right me-2"></i>
                            العودة للقائمة
                        </a>
                    </div>
                </div>

                <!-- Order Information -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="card border-0 bg-light">
                            <div class="card-body">
                                <h6 class="card-title text-primary mb-3">
                                    <i class="fas fa-shopping-cart me-2"></i>
                                    معلومات الطلب
                                </h6>
                                
                                <div class="mb-3">
                                    <label class="form-label fw-bold">رقم الطلب:</label>
                                    <p class="mb-0">#{{ $order->order_number ?? $order->id }}</p>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">المنتج:</label>
                                    <p class="mb-0">{{ $order->product->name ?? 'غير محدد' }}</p>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">الكمية:</label>
                                    <p class="mb-0">{{ $order->quantity ?? 1 }}</p>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">المبلغ الإجمالي:</label>
                                    <p class="mb-0">{{ $order->total_amount ?? 0 }} ريال</p>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">حالة الطلب:</label>
                                    @php
                                        $statusColors = [
                                            'pending' => 'warning',
                                            'confirmed' => 'info',
                                            'preparing' => 'primary',
                                            'assigned' => 'secondary',
                                            'picked_up' => 'info',
                                            'delivered' => 'success',
                                            'cancelled' => 'danger'
                                        ];
                                        $statusColor = $statusColors[$order->status] ?? 'secondary';
                                    @endphp
                                    <span class="badge bg-{{ $statusColor }}">{{ $order->status }}</span>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">حالة الدفع:</label>
                                    @if($order->payment_status === 'paid')
                                        <span class="badge bg-success">مدفوع</span>
                                    @elseif($order->payment_status === 'pending')
                                        <span class="badge bg-warning">في الانتظار</span>
                                    @else
                                        <span class="badge bg-danger">فشل</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card border-0 bg-light">
                            <div class="card-body">
                                <h6 class="card-title text-primary mb-3">
                                    <i class="fas fa-user me-2"></i>
                                    معلومات العميل
                                </h6>
                                
                                <div class="mb-3">
                                    <label class="form-label fw-bold">اسم العميل:</label>
                                    <p class="mb-0">{{ $order->customer->name ?? 'غير محدد' }}</p>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">رقم الهاتف:</label>
                                    <p class="mb-0">{{ $order->customer->phone ?? 'غير محدد' }}</p>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">البريد الإلكتروني:</label>
                                    <p class="mb-0">{{ $order->customer->email ?? 'غير محدد' }}</p>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">عنوان التوصيل:</label>
                                    <p class="mb-0">{{ $order->delivery_address ?? 'غير محدد' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Supplier and Delivery Information -->
                <div class="row mt-4">
                    <div class="col-md-6">
                        <div class="card border-0 bg-light">
                            <div class="card-body">
                                <h6 class="card-title text-primary mb-3">
                                    <i class="fas fa-store me-2"></i>
                                    معلومات المورد
                                </h6>
                                
                                <div class="mb-3">
                                    <label class="form-label fw-bold">اسم الشركة:</label>
                                    <p class="mb-0">{{ $order->supplier->company_name ?? 'غير محدد' }}</p>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">رقم الهاتف:</label>
                                    <p class="mb-0">{{ $order->supplier->phone ?? 'غير محدد' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card border-0 bg-light">
                            <div class="card-body">
                                <h6 class="card-title text-primary mb-3">
                                    <i class="fas fa-truck me-2"></i>
                                    معلومات التوصيل
                                </h6>
                                
                                <div class="mb-3">
                                    <label class="form-label fw-bold">مندوب التوصيل:</label>
                                    <p class="mb-0">{{ $order->deliveryMan->user->name ?? 'غير محدد' }}</p>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">نوع المركبة:</label>
                                    <p class="mb-0">{{ $order->deliveryMan->vehicle_type ?? 'غير محدد' }}</p>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">رقم المركبة:</label>
                                    <p class="mb-0">{{ $order->deliveryMan->vehicle_number ?? 'غير محدد' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @if($order->notes)
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card border-0 bg-light">
                            <div class="card-body">
                                <h6 class="card-title text-primary mb-3">
                                    <i class="fas fa-sticky-note me-2"></i>
                                    ملاحظات
                                </h6>
                                <p class="mb-0">{{ $order->notes }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Order Timeline -->
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card border-0 bg-light">
                            <div class="card-body">
                                <h6 class="card-title text-primary mb-3">
                                    <i class="fas fa-clock me-2"></i>
                                    الجدول الزمني
                                </h6>
                                
                                <div class="timeline">
                                    <div class="timeline-item">
                                        <div class="timeline-marker bg-primary"></div>
                                        <div class="timeline-content">
                                            <h6 class="mb-1">تم إنشاء الطلب</h6>
                                            <p class="text-muted mb-0">{{ $order->created_at->format('Y-m-d H:i') }}</p>
                                        </div>
                                    </div>
                                    
                                    @if($order->updated_at != $order->created_at)
                                    <div class="timeline-item">
                                        <div class="timeline-marker bg-info"></div>
                                        <div class="timeline-content">
                                            <h6 class="mb-1">آخر تحديث</h6>
                                            <p class="text-muted mb-0">{{ $order->updated_at->format('Y-m-d H:i') }}</p>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
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

.timeline-item {
    position: relative;
    margin-bottom: 20px;
}

.timeline-marker {
    position: absolute;
    left: -35px;
    top: 5px;
    width: 12px;
    height: 12px;
    border-radius: 50%;
}

.timeline-content {
    padding-left: 20px;
    border-left: 2px solid #e9ecef;
    padding-bottom: 10px;
}
</style>
@endsection 