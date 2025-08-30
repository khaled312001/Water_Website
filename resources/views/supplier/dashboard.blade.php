@extends('layouts.supplier')

@section('title', 'لوحة تحكم المورد - سلسبيل مكة')
@section('page-title', 'لوحة تحكم المورد')

@section('content')
<div class="fade-in">
    <!-- Welcome Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="stat-card">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon bg-primary text-white me-3">
                            <i class="fas fa-store"></i>
                        </div>
                        <div>
                            <h4 class="mb-1">مرحباً، {{ auth()->user()->name }}</h4>
                            <p class="text-muted mb-0">مرحباً بك في لوحة تحكم المورد</p>
                        </div>
                    </div>
                    <div class="dropdown">
                        <button class="btn btn-admin btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-file-export me-2"></i>
                            تصدير البيانات
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('supplier.export.dashboard') }}">
                                <i class="fas fa-chart-line me-2"></i>
                                تصدير لوحة التحكم
                            </a></li>
                            <li><a class="dropdown-item" href="{{ route('supplier.export.products') }}">
                                <i class="fas fa-box me-2"></i>
                                تصدير المنتجات
                            </a></li>
                            <li><a class="dropdown-item" href="{{ route('supplier.export.orders') }}">
                                <i class="fas fa-shopping-cart me-2"></i>
                                تصدير الطلبات
                            </a></li>
                            <li><a class="dropdown-item" href="{{ route('supplier.export.earnings') }}">
                                <i class="fas fa-money-bill-wave me-2"></i>
                                تصدير الأرباح
                            </a></li>
                        </ul>
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
                        <i class="fas fa-box"></i>
                    </div>
                    <div>
                        <h3 class="mb-1">{{ $stats['total_products'] }}</h3>
                        <p class="text-muted mb-0">المنتجات</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stat-card">
                <div class="d-flex align-items-center">
                    <div class="stat-icon bg-success text-white me-3">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <div>
                        <h3 class="mb-1">{{ $stats['total_orders'] }}</h3>
                        <p class="text-muted mb-0">الطلبات</p>
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
                        <h3 class="mb-1">{{ number_format($stats['total_earnings'], 2) }} ريال</h3>
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
                        <h3 class="mb-1">4.5</h3>
                        <p class="text-muted mb-0">متوسط التقييم</p>
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
                        <a href="{{ route('supplier.products') }}" class="btn btn-admin btn-outline-primary w-100">
                            <i class="fas fa-box me-2"></i>
                            إدارة المنتجات
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('supplier.orders') }}" class="btn btn-admin btn-outline-success w-100">
                            <i class="fas fa-shopping-cart me-2"></i>
                            عرض الطلبات
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('supplier.earnings') }}" class="btn btn-admin btn-outline-warning w-100">
                            <i class="fas fa-chart-line me-2"></i>
                            تقارير الأرباح
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Recent Orders -->
    <div class="row">
        <div class="col-lg-8">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="mb-0">
                        <i class="fas fa-clock text-info me-2"></i>
                        آخر الطلبات
                    </h5>
                    <a href="{{ route('supplier.orders') }}" class="btn btn-admin btn-sm btn-outline-primary">
                        عرض الكل
                    </a>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>رقم الطلب</th>
                                <th>العميل</th>
                                <th>المنتج</th>
                                <th>المبلغ</th>
                                <th>الحالة</th>
                                <th>التاريخ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentOrders ?? [] as $order)
                            <tr>
                                <td>#{{ $order->id }}</td>
                                <td>{{ $order->customer->name ?? 'غير محدد' }}</td>
                                <td>{{ $order->product->name ?? 'غير محدد' }}</td>
                                <td>{{ $order->total_amount ?? 0 }} ريال</td>
                                <td>
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
                                </td>
                                <td>{{ $order->created_at->format('Y-m-d') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">لا توجد طلبات حديثة</td>
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
                        <span>الطلبات الجديدة</span>
                        <span class="fw-bold">{{ $stats['new_orders'] ?? 0 }}</span>
                    </div>
                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar bg-primary" style="width: {{ min(($stats['new_orders'] ?? 0) * 10, 100) }}%"></div>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span>الطلبات المكتملة</span>
                        <span class="fw-bold">{{ $stats['completed_orders'] ?? 0 }}</span>
                    </div>
                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar bg-success" style="width: {{ min(($stats['completed_orders'] ?? 0) * 10, 100) }}%"></div>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span>المنتجات النشطة</span>
                        <span class="fw-bold">{{ $stats['active_products'] ?? 0 }}</span>
                    </div>
                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar bg-info" style="width: {{ min(($stats['active_products'] ?? 0) * 10, 100) }}%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 