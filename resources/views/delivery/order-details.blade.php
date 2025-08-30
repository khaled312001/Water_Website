@extends('layouts.delivery')

@section('title', 'تفاصيل الطلب - سلسبيل مكة')
@section('page-title', 'تفاصيل الطلب')

@section('content')
<div class="fade-in">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="mb-1">تفاصيل الطلب #{{ $order->order_number ?? $order->id }}</h4>
                        <p class="text-muted mb-0">عرض تفاصيل الطلب وإدارة التوصيل</p>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('delivery.export.orders') }}" class="btn btn-delivery btn-outline-success">
                            <i class="fas fa-download me-2"></i>
                            تصدير التقرير
                        </a>
                        <a href="{{ route('delivery.orders') }}" class="btn btn-delivery btn-outline-secondary">
                            <i class="fas fa-arrow-right me-2"></i>
                            العودة للطلبات
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Order Status -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-2">حالة الطلب</h5>
                        @php
                            $statusColors = [
                                'assigned' => 'primary',
                                'picked_up' => 'info',
                                'delivered' => 'success',
                                'cancelled' => 'danger'
                            ];
                            $statusColor = $statusColors[$order->status] ?? 'secondary';
                        @endphp
                        <span class="badge-admin bg-{{ $statusColor }} fs-6">
                            {{ $order->status_text }}
                        </span>
                    </div>
                    <div>
                        @if($order->status === 'assigned')
                        <button class="btn btn-admin btn-info" onclick="updateOrderStatus({{ $order->id }}, 'picked_up')">
                            <i class="fas fa-hand-holding me-2"></i>
                            استلام الطلب
                        </button>
                        @elseif($order->status === 'picked_up')
                        <button class="btn btn-admin btn-success" onclick="updateOrderStatus({{ $order->id }}, 'delivered')">
                            <i class="fas fa-check me-2"></i>
                            تأكيد التوصيل
                        </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Order Details -->
    <div class="row">
        <!-- Customer Information -->
        <div class="col-md-6 mb-4">
            <div class="stat-card h-100">
                <h5 class="mb-3">
                    <i class="fas fa-user text-primary me-2"></i>
                    معلومات العميل
                </h5>
                <div class="row">
                    <div class="col-12 mb-3">
                        <label class="form-label fw-bold">اسم العميل</label>
                        <div class="form-control-plaintext">{{ $order->customer->name ?? 'غير محدد' }}</div>
                    </div>
                    <div class="col-12 mb-3">
                        <label class="form-label fw-bold">رقم الهاتف</label>
                        <div class="form-control-plaintext">{{ $order->customer->phone ?? 'غير محدد' }}</div>
                    </div>
                    <div class="col-12 mb-3">
                        <label class="form-label fw-bold">عنوان التوصيل</label>
                        <div class="form-control-plaintext">{{ $order->delivery_address ?? 'غير محدد' }}</div>
                    </div>
                    <div class="col-12 mb-3">
                        <label class="form-label fw-bold">المدينة</label>
                        <div class="form-control-plaintext">{{ $order->delivery_city ?? 'غير محدد' }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Product Information -->
        <div class="col-md-6 mb-4">
            <div class="stat-card h-100">
                <h5 class="mb-3">
                    <i class="fas fa-box text-success me-2"></i>
                    معلومات المنتج
                </h5>
                <div class="row">
                    <div class="col-12 mb-3">
                        <label class="form-label fw-bold">اسم المنتج</label>
                        <div class="form-control-plaintext">{{ $order->product->name ?? 'غير محدد' }}</div>
                    </div>
                    <div class="col-12 mb-3">
                        <label class="form-label fw-bold">الكمية</label>
                        <div class="form-control-plaintext">{{ $order->quantity ?? 1 }}</div>
                    </div>
                    <div class="col-12 mb-3">
                        <label class="form-label fw-bold">سعر الوحدة</label>
                        <div class="form-control-plaintext">{{ $order->unit_price ?? 0 }} ريال</div>
                    </div>
                    <div class="col-12 mb-3">
                        <label class="form-label fw-bold">المورد</label>
                        <div class="form-control-plaintext">{{ $order->supplier->name ?? 'غير محدد' }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Summary -->
        <div class="col-md-6 mb-4">
            <div class="stat-card h-100">
                <h5 class="mb-3">
                    <i class="fas fa-receipt text-warning me-2"></i>
                    ملخص الطلب
                </h5>
                <div class="row">
                    <div class="col-12 mb-3">
                        <label class="form-label fw-bold">رقم الطلب</label>
                        <div class="form-control-plaintext">#{{ $order->order_number ?? $order->id }}</div>
                    </div>
                    <div class="col-12 mb-3">
                        <label class="form-label fw-bold">تاريخ الطلب</label>
                        <div class="form-control-plaintext">{{ $order->created_at->format('Y-m-d H:i') }}</div>
                    </div>
                    <div class="col-12 mb-3">
                        <label class="form-label fw-bold">المبلغ الإجمالي</label>
                        <div class="form-control-plaintext fw-bold text-success">{{ $order->total_amount ?? 0 }} ريال</div>
                    </div>
                    <div class="col-12 mb-3">
                        <label class="form-label fw-bold">رسوم التوصيل</label>
                        <div class="form-control-plaintext">{{ $order->delivery_fee ?? 0 }} ريال</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delivery Information -->
        <div class="col-md-6 mb-4">
            <div class="stat-card h-100">
                <h5 class="mb-3">
                    <i class="fas fa-truck text-info me-2"></i>
                    معلومات التوصيل
                </h5>
                <div class="row">
                    <div class="col-12 mb-3">
                        <label class="form-label fw-bold">الوقت المتوقع للتوصيل</label>
                        <div class="form-control-plaintext">
                            {{ $order->estimated_delivery_time ? $order->estimated_delivery_time->format('Y-m-d H:i') : 'غير محدد' }}
                        </div>
                    </div>
                    <div class="col-12 mb-3">
                        <label class="form-label fw-bold">وقت التوصيل الفعلي</label>
                        <div class="form-control-plaintext">
                            {{ $order->actual_delivery_time ? $order->actual_delivery_time->format('Y-m-d H:i') : 'لم يتم التوصيل بعد' }}
                        </div>
                    </div>
                    <div class="col-12 mb-3">
                        <label class="form-label fw-bold">ملاحظات</label>
                        <div class="form-control-plaintext">{{ $order->notes ?? 'لا توجد ملاحظات' }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    @if($order->status !== 'delivered' && $order->status !== 'cancelled')
    <div class="row">
        <div class="col-12">
            <div class="stat-card">
                <div class="d-flex justify-content-center gap-3">
                    @if($order->status === 'assigned')
                    <button class="btn btn-admin btn-info btn-lg" onclick="updateOrderStatus({{ $order->id }}, 'picked_up')">
                        <i class="fas fa-hand-holding me-2"></i>
                        استلام الطلب
                    </button>
                    @elseif($order->status === 'picked_up')
                    <button class="btn btn-admin btn-success btn-lg" onclick="updateOrderStatus({{ $order->id }}, 'delivered')">
                        <i class="fas fa-check me-2"></i>
                        تأكيد التوصيل
                    </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

<script>
function updateOrderStatus(orderId, status) {
    const statusText = status === 'picked_up' ? 'استلام' : 'توصيل';
    if (confirm(`هل تريد ${statusText} الطلب؟`)) {
        fetch(`/delivery/orders/${orderId}/status`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                status: status
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('حدث خطأ أثناء تحديث حالة الطلب');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('حدث خطأ أثناء تحديث حالة الطلب');
        });
    }
}
</script>
@endsection 