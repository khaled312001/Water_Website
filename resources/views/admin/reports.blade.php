@extends('layouts.admin')

@section('title', 'التقارير - مياه مكة')
@section('page-title', 'التقارير')

@section('content')
<div class="fade-in">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="stat-card">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h4 class="mb-2">التقارير والإحصائيات</h4>
                        <p class="text-muted mb-0">عرض تقارير مفصلة عن أداء النظام</p>
                    </div>
                    <div class="d-flex gap-2">
                        <button class="btn btn-admin btn-primary">
                            <i class="fas fa-download me-2"></i>
                            تصدير التقرير
                        </button>
                        <button class="btn btn-admin btn-outline-secondary">
                            <i class="fas fa-print me-2"></i>
                            طباعة
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="row mb-4">
        <!-- Monthly Orders Chart -->
        <div class="col-lg-6 mb-4">
            <div class="chart-container">
                <h5 class="mb-3">
                    <i class="fas fa-chart-line text-primary me-2"></i>
                    إحصائيات الطلبات الشهرية
                </h5>
                <canvas id="monthlyOrdersChart" width="400" height="200"></canvas>
            </div>
        </div>

        <!-- Top Products Chart -->
        <div class="col-lg-6 mb-4">
            <div class="chart-container">
                <h5 class="mb-3">
                    <i class="fas fa-chart-bar text-success me-2"></i>
                    أفضل المنتجات
                </h5>
                <canvas id="topProductsChart" width="400" height="200"></canvas>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stat-card">
                <div class="d-flex align-items-center">
                    <div class="stat-icon bg-primary bg-opacity-10 text-primary">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <div class="ms-3">
                        <div class="stat-number text-primary">{{ $monthlyOrders->sum('count') ?? 0 }}</div>
                        <div class="stat-label">إجمالي الطلبات</div>
                        <div class="stat-change text-success">
                            <i class="fas fa-arrow-up me-1"></i>
                            هذا العام
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stat-card">
                <div class="d-flex align-items-center">
                    <div class="stat-icon bg-success bg-opacity-10 text-success">
                        <i class="fas fa-star"></i>
                    </div>
                    <div class="ms-3">
                        <div class="stat-number text-success">{{ $topProducts->count() ?? 0 }}</div>
                        <div class="stat-label">المنتجات المقيّمة</div>
                        <div class="stat-change text-success">
                            <i class="fas fa-check me-1"></i>
                            نشط
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stat-card">
                <div class="d-flex align-items-center">
                    <div class="stat-icon bg-warning bg-opacity-10 text-warning">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="ms-3">
                        <div class="stat-number text-warning">{{ $monthlyOrders->avg('count') ?? 0 }}</div>
                        <div class="stat-label">متوسط الطلبات</div>
                        <div class="stat-change text-warning">
                            <i class="fas fa-chart-bar me-1"></i>
                            شهرياً
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stat-card">
                <div class="d-flex align-items-center">
                    <div class="stat-icon bg-info bg-opacity-10 text-info">
                        <i class="fas fa-trending-up"></i>
                    </div>
                    <div class="ms-3">
                        <div class="stat-number text-info">{{ $monthlyOrders->max('count') ?? 0 }}</div>
                        <div class="stat-label">أعلى طلبات</div>
                        <div class="stat-change text-info">
                            <i class="fas fa-arrow-up me-1"></i>
                            في شهر واحد
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Detailed Reports -->
    <div class="row">
        <!-- Monthly Orders Table -->
        <div class="col-lg-6 mb-4">
            <div class="stat-card">
                <h5 class="mb-3">
                    <i class="fas fa-calendar text-primary me-2"></i>
                    الطلبات الشهرية
                </h5>
                @if($monthlyOrders->count() > 0)
                    <div class="admin-table">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>الشهر</th>
                                    <th>عدد الطلبات</th>
                                    <th>النسبة</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($monthlyOrders as $order)
                                <tr>
                                    <td>
                                        <div class="fw-bold">
                                            @php
                                                $monthNames = [
                                                    1 => 'يناير', 2 => 'فبراير', 3 => 'مارس', 4 => 'أبريل',
                                                    5 => 'مايو', 6 => 'يونيو', 7 => 'يوليو', 8 => 'أغسطس',
                                                    9 => 'سبتمبر', 10 => 'أكتوبر', 11 => 'نوفمبر', 12 => 'ديسمبر'
                                                ];
                                                echo $monthNames[$order->month] ?? $order->month;
                                            @endphp
                                        </div>
                                    </td>
                                    <td>
                                        <span class="fw-bold text-primary">{{ $order->count }}</span>
                                    </td>
                                    <td>
                                        @php
                                            $total = $monthlyOrders->sum('count');
                                            $percentage = $total > 0 ? ($order->count / $total) * 100 : 0;
                                        @endphp
                                        <div class="progress" style="height: 8px;">
                                            <div class="progress-bar bg-primary" style="width: {{ $percentage }}%"></div>
                                        </div>
                                        <small class="text-muted">{{ number_format($percentage, 1) }}%</small>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-3">
                        <p class="text-muted mb-0">لا توجد بيانات للطلبات الشهرية</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Top Products Table -->
        <div class="col-lg-6 mb-4">
            <div class="stat-card">
                <h5 class="mb-3">
                    <i class="fas fa-trophy text-warning me-2"></i>
                    أفضل المنتجات
                </h5>
                @if($topProducts->count() > 0)
                    <div class="admin-table">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>المنتج</th>
                                    <th>التقييمات</th>
                                    <th>التقييم</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($topProducts as $product)
                                <tr>
                                    <td>
                                        <div class="fw-bold">{{ $product->name ?? 'غير محدد' }}</div>
                                        <small class="text-muted">{{ $product->supplier->company_name ?? '' }}</small>
                                    </td>
                                    <td>
                                        <span class="fw-bold text-info">{{ $product->reviews_count ?? 0 }}</span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="text-warning me-2">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <i class="fas fa-star{{ $i <= ($product->rating ?? 0) ? '' : '-o' }}"></i>
                                                @endfor
                                            </div>
                                            <span class="fw-bold">{{ number_format($product->rating ?? 0, 1) }}</span>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-3">
                        <p class="text-muted mb-0">لا توجد بيانات للمنتجات</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
// Monthly Orders Chart
const monthlyOrdersCtx = document.getElementById('monthlyOrdersChart').getContext('2d');
const monthlyOrdersChart = new Chart(monthlyOrdersCtx, {
    type: 'line',
    data: {
        labels: ['يناير', 'فبراير', 'مارس', 'أبريل', 'مايو', 'يونيو'],
        datasets: [{
            label: 'الطلبات',
            data: [12, 19, 3, 5, 2, 3],
            borderColor: '#2563eb',
            backgroundColor: 'rgba(37, 99, 235, 0.1)',
            tension: 0.4,
            fill: true
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                grid: {
                    color: 'rgba(0,0,0,0.05)'
                }
            },
            x: {
                grid: {
                    display: false
                }
            }
        }
    }
});

// Top Products Chart
const topProductsCtx = document.getElementById('topProductsChart').getContext('2d');
const topProductsChart = new Chart(topProductsCtx, {
    type: 'doughnut',
    data: {
        labels: ['منتج 1', 'منتج 2', 'منتج 3', 'منتج 4', 'منتج 5'],
        datasets: [{
            data: [30, 25, 20, 15, 10],
            backgroundColor: [
                '#2563eb',
                '#059669',
                '#d97706',
                '#dc2626',
                '#0891b2'
            ],
            borderWidth: 0
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    }
});
</script>
@endsection 