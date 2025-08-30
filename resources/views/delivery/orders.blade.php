@extends('layouts.delivery')

@section('title', 'إدارة الطلبات - سلسبيل مكة')
@section('page-title', 'إدارة الطلبات')

@section('content')
<div class="fade-in">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="mb-1">إدارة الطلبات</h4>
                        <p class="text-muted mb-0">عرض وإدارة طلبات التوصيل</p>
                    </div>
                    <div class="d-flex gap-2">
                        <button class="btn btn-admin btn-outline-secondary">
                            <i class="fas fa-download me-2"></i>
                            تصدير البيانات
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Search Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="stat-card">
                <form method="GET" action="{{ route('delivery.orders') }}">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label class="form-label">البحث</label>
                            <input type="text" class="form-control" name="search" 
                                   placeholder="البحث برقم الطلب أو اسم العميل..." 
                                   value="{{ request('search') }}">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">حالة الطلب</label>
                            <select class="form-select" name="status">
                                <option value="">جميع الحالات</option>
                                <option value="assigned" {{ request('status') == 'assigned' ? 'selected' : '' }}>تم التعيين</option>
                                <option value="picked_up" {{ request('status') == 'picked_up' ? 'selected' : '' }}>تم الاستلام</option>
                                <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>تم التوصيل</option>
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">التاريخ</label>
                            <input type="date" class="form-control" name="date" value="{{ request('date') }}">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">&nbsp;</label>
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-admin btn-primary flex-grow-1">
                                    <i class="fas fa-search me-2"></i>
                                    بحث
                                </button>
                                <a href="{{ route('delivery.orders') }}" class="btn btn-admin btn-outline-secondary">
                                    <i class="fas fa-times"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Orders Table -->
    <div class="row">
        <div class="col-12">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="mb-0">
                        <i class="fas fa-shopping-cart text-info me-2"></i>
                        قائمة الطلبات ({{ $orders->total() }})
                    </h5>
                    <div class="d-flex gap-2">
                        <a href="{{ route('delivery.export.orders') }}" class="btn btn-delivery btn-outline-success">
                            <i class="fas fa-download me-2"></i>
                            تصدير التقرير
                        </a>
                        <button class="btn btn-delivery btn-outline-info" onclick="updateLocation()">
                            <i class="fas fa-map-marker-alt me-2"></i>
                            تحديث الموقع
                        </button>
                    </div>
                </div>

                @if($orders->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>رقم الطلب</th>
                                <th>العميل</th>
                                <th>المنتج</th>
                                <th>العنوان</th>
                                <th>المبلغ</th>
                                <th>حالة الطلب</th>
                                <th>التاريخ</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                            <tr>
                                <td>
                                    <div class="fw-bold">#{{ $order->order_number ?? $order->id }}</div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="user-avatar me-3">
                                            {{ substr($order->customer->name ?? 'ع', 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="fw-bold">{{ $order->customer->name ?? 'غير محدد' }}</div>
                                            <small class="text-muted">{{ $order->customer->phone ?? '' }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="fw-bold">{{ $order->product->name ?? 'غير محدد' }}</div>
                                    <small class="text-muted">الكمية: {{ $order->quantity ?? 1 }}</small>
                                </td>
                                <td>
                                    <div class="fw-bold">{{ Str::limit($order->delivery_address ?? 'غير محدد', 30) }}</div>
                                </td>
                                <td>
                                    <div class="fw-bold">{{ $order->total_amount ?? 0 }} ريال</div>
                                </td>
                                <td>
                                    @php
                                        $statusColors = [
                                            'assigned' => 'primary',
                                            'picked_up' => 'info',
                                            'delivered' => 'success'
                                        ];
                                        $statusColor = $statusColors[$order->status] ?? 'secondary';
                                    @endphp
                                    <span class="badge-admin bg-{{ $statusColor }}">
                                        {{ $order->status }}
                                    </span>
                                </td>
                                <td>
                                    <div class="fw-bold">{{ $order->created_at->format('Y-m-d') }}</div>
                                    <small class="text-muted">{{ $order->created_at->format('H:i') }}</small>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('delivery.order.details', $order->id) }}" class="btn btn-sm btn-outline-primary" title="عرض">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @if($order->status === 'assigned')
                                        <button class="btn btn-sm btn-outline-info" onclick="updateOrderStatus({{ $order->id }}, 'picked_up')" title="استلام">
                                            <i class="fas fa-hand-holding"></i>
                                        </button>
                                        @endif
                                        @if($order->status === 'picked_up')
                                        <button class="btn btn-sm btn-outline-success" onclick="updateOrderStatus({{ $order->id }}, 'delivered')" title="توصيل">
                                            <i class="fas fa-check"></i>
                                        </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $orders->links() }}
                </div>
                @else
                <div class="text-center py-5">
                    <div class="stat-icon bg-light text-muted mx-auto mb-3" style="width: 80px; height: 80px; font-size: 2rem;">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <h6 class="text-muted">لا توجد طلبات</h6>
                    <p class="text-muted mb-0">لم يتم العثور على طلبات في النظام</p>
                </div>
                @endif
            </div>
        </div>
    </div>
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
<script>
// Location update functionality
function updateLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            const lat = position.coords.latitude;
            const lng = position.coords.longitude;
            
            fetch('/delivery/location', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    lat: lat,
                    lng: lng
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification('تم تحديث الموقع بنجاح', 'success');
                } else {
                    showNotification('حدث خطأ أثناء تحديث الموقع', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('حدث خطأ أثناء تحديث الموقع', 'error');
            });
        }, function(error) {
            let errorMessage = 'لا يمكن تحديد موقعك';
            switch(error.code) {
                case error.PERMISSION_DENIED:
                    errorMessage = 'يرجى السماح بالوصول إلى الموقع';
                    break;
                case error.POSITION_UNAVAILABLE:
                    errorMessage = 'معلومات الموقع غير متاحة';
                    break;
                case error.TIMEOUT:
                    errorMessage = 'انتهت مهلة تحديد الموقع';
                    break;
            }
            showNotification(errorMessage, 'error');
        });
    } else {
        showNotification('متصفحك لا يدعم تحديد الموقع', 'error');
    }
}

// Show notification function
function showNotification(message, type) {
    const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
    const icon = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle';
    
    const notification = document.createElement('div');
    notification.className = `alert ${alertClass} alert-dismissible fade show position-fixed`;
    notification.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
    notification.innerHTML = `
        <i class="fas ${icon} me-2"></i>
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    `;
    
    document.body.appendChild(notification);
    
    // Auto remove after 5 seconds
    setTimeout(() => {
        if (notification.parentNode) {
            notification.remove();
        }
    }, 5000);
}
</script>
@endsection 