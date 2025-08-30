@extends('layouts.admin')

@section('title', 'لوحة تحكم مندوب التوصيل - سلسبيل مكة')
@section('page-title', 'لوحة تحكم مندوب التوصيل')

@section('content')
<div class="fade-in">
    <!-- Welcome Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="stat-card">
                <div class="d-flex align-items-center">
                    <div class="stat-icon bg-primary text-white me-3">
                        <i class="fas fa-truck"></i>
                    </div>
                    <div>
                        <h4 class="mb-1">مرحباً، {{ auth()->user()->name }}</h4>
                        <p class="text-muted mb-0">مرحباً بك في لوحة تحكم مندوب التوصيل</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stat-card">
                <div class="d-flex align-items-center">
                    <div class="stat-icon bg-primary text-white me-3">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <div>
                        <h3 class="mb-1">{{ $stats['total_orders'] ?? 0 }}</h3>
                        <p class="text-muted mb-0">إجمالي الطلبات</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stat-card">
                <div class="d-flex align-items-center">
                    <div class="stat-icon bg-success text-white me-3">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div>
                        <h3 class="mb-1">{{ $stats['delivered_orders'] ?? 0 }}</h3>
                        <p class="text-muted mb-0">الطلبات المكتملة</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stat-card">
                <div class="d-flex align-items-center">
                    <div class="stat-icon bg-warning text-white me-3">
                        <i class="fas fa-money-bill-wave"></i>
                    </div>
                    <div>
                        <h3 class="mb-1">{{ number_format($stats['total_earnings'] ?? 0, 2) }} ريال</h3>
                        <p class="text-muted mb-0">إجمالي الأرباح</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stat-card">
                <div class="d-flex align-items-center">
                    <div class="stat-icon bg-info text-white me-3">
                        <i class="fas fa-star"></i>
                    </div>
                    <div>
                        <h3 class="mb-1">4.8</h3>
                        <p class="text-muted mb-0">متوسط التقييم</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Status Control -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="stat-card">
                <h5 class="mb-3">
                    <i class="fas fa-toggle-on text-success me-2"></i>
                    حالة العمل
                </h5>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="statusToggle" checked>
                            <label class="form-check-label" for="statusToggle">
                                متاح للطلبات
                            </label>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <button class="btn btn-admin btn-outline-primary">
                            <i class="fas fa-map-marker-alt me-2"></i>
                            تحديث الموقع
                        </button>
                    </div>
                    <div class="col-md-4 mb-3">
                        <button class="btn btn-admin btn-outline-info">
                            <i class="fas fa-clock me-2"></i>
                            تقرير الحالة
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="stat-card">
                <h5 class="mb-3">
                    <i class="fas fa-bolt text-warning me-2"></i>
                    إجراءات سريعة
                </h5>
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('delivery.orders') }}" class="btn btn-admin btn-outline-primary w-100">
                            <i class="fas fa-list me-2"></i>
                            عرض الطلبات
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('delivery.earnings') }}" class="btn btn-admin btn-outline-success w-100">
                            <i class="fas fa-chart-line me-2"></i>
                            تقارير الأرباح
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('delivery.profile') }}" class="btn btn-admin btn-outline-warning w-100">
                            <i class="fas fa-user-cog me-2"></i>
                            الملف الشخصي
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="#" class="btn btn-admin btn-outline-info w-100">
                            <i class="fas fa-cog me-2"></i>
                            الإعدادات
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Current Orders -->
    <div class="row">
        <div class="col-lg-8">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="mb-0">
                        <i class="fas fa-clock text-info me-2"></i>
                        الطلبات الحالية
                    </h5>
                    <a href="{{ route('delivery.orders') }}" class="btn btn-admin btn-sm btn-outline-primary">
                        عرض الكل
                    </a>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>رقم الطلب</th>
                                <th>العميل</th>
                                <th>العنوان</th>
                                <th>المبلغ</th>
                                <th>الحالة</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($currentOrders ?? [] as $order)
                            <tr>
                                <td>#{{ $order->id }}</td>
                                <td>
                                    <div class="fw-bold">{{ $order->customer->name ?? 'غير محدد' }}</div>
                                    <small class="text-muted">{{ $order->customer->phone ?? '' }}</small>
                                </td>
                                <td>{{ Str::limit($order->delivery_address ?? 'غير محدد', 30) }}</td>
                                <td>{{ $order->total_amount ?? 0 }} ريال</td>
                                <td>
                                    @php
                                        $statusColors = [
                                            'assigned' => 'primary',
                                            'picked_up' => 'info',
                                            'delivered' => 'success'
                                        ];
                                        $statusColor = $statusColors[$order->status] ?? 'secondary';
                                    @endphp
                                    <span class="badge bg-{{ $statusColor }}">{{ $order->status }}</span>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('delivery.order.details', $order->id) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <button class="btn btn-sm btn-outline-success" onclick="updateOrderStatus({{ $order->id }})">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">لا توجد طلبات حالية</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="stat-card">
                <h5 class="mb-3">
                    <i class="fas fa-chart-pie text-success me-2"></i>
                    إحصائيات سريعة
                </h5>
                
                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span>الطلبات اليوم</span>
                        <span class="fw-bold">{{ $stats['today_orders'] ?? 0 }}</span>
                    </div>
                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar bg-primary" style="width: {{ min(($stats['today_orders'] ?? 0) * 10, 100) }}%"></div>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span>الطلبات المكتملة</span>
                        <span class="fw-bold">{{ $stats['completed_today'] ?? 0 }}</span>
                    </div>
                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar bg-success" style="width: {{ min(($stats['completed_today'] ?? 0) * 10, 100) }}%"></div>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span>أرباح اليوم</span>
                        <span class="fw-bold">{{ number_format($stats['today_earnings'] ?? 0, 2) }} ريال</span>
                    </div>
                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar bg-warning" style="width: {{ min(($stats['today_earnings'] ?? 0) * 2, 100) }}%"></div>
                    </div>
                </div>
            </div>

            <!-- Location Status -->
            <div class="stat-card mt-4">
                <h5 class="mb-3">
                    <i class="fas fa-map-marker-alt text-danger me-2"></i>
                    الموقع الحالي
                </h5>
                <div class="text-center">
                    <div class="mb-3">
                        <i class="fas fa-location-arrow text-primary" style="font-size: 2rem;"></i>
                    </div>
                    <p class="text-muted mb-2">جاري تحديد الموقع...</p>
                    <button class="btn btn-admin btn-sm btn-outline-primary">
                        <i class="fas fa-sync-alt me-2"></i>
                        تحديث الموقع
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function updateOrderStatus(orderId) {
    if (confirm('هل تريد تحديث حالة الطلب؟')) {
        // Send AJAX request to update order status
        fetch(`/delivery/orders/${orderId}/status`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                status: 'delivered'
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        });
    }
}

document.getElementById('statusToggle').addEventListener('change', function() {
    const isAvailable = this.checked;
    // Send AJAX request to update delivery man status
    fetch('/delivery/status', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            status: isAvailable ? 'available' : 'offline'
        })
    });
});
</script>
@endsection 