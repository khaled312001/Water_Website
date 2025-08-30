@extends('layouts.supplier')

@section('title', 'تقارير الأرباح - سلسبيل مكة')
@section('page-title', 'تقارير الأرباح')

@section('content')
<div class="fade-in">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="mb-1">تقارير الأرباح</h4>
                        <p class="text-muted mb-0">عرض إحصائيات الأرباح والإيرادات</p>
                    </div>
                    <div class="d-flex gap-2">
                        <button class="btn btn-admin btn-outline-secondary">
                            <i class="fas fa-download me-2"></i>
                            تصدير التقرير
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Earnings Statistics -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stat-card">
                <div class="d-flex align-items-center">
                    <div class="stat-icon bg-primary text-white me-3">
                        <i class="fas fa-money-bill-wave"></i>
                    </div>
                    <div>
                        <h3 class="mb-1">{{ number_format($totalEarnings ?? 0, 2) }} ريال</h3>
                        <p class="text-muted mb-0">إجمالي الأرباح</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stat-card">
                <div class="d-flex align-items-center">
                    <div class="stat-icon bg-success text-white me-3">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <div>
                        <h3 class="mb-1">{{ number_format($monthlyEarnings ?? 0, 2) }} ريال</h3>
                        <p class="text-muted mb-0">أرباح هذا الشهر</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stat-card">
                <div class="d-flex align-items-center">
                    <div class="stat-icon bg-warning text-white me-3">
                        <i class="fas fa-calendar-day"></i>
                    </div>
                    <div>
                        <h3 class="mb-1">{{ number_format($todayEarnings ?? 0, 2) }} ريال</h3>
                        <p class="text-muted mb-0">أرباح اليوم</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stat-card">
                <div class="d-flex align-items-center">
                    <div class="stat-icon bg-info text-white me-3">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <div>
                        <h3 class="mb-1">{{ $totalOrders ?? 0 }}</h3>
                        <p class="text-muted mb-0">إجمالي الطلبات</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Earnings Chart -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="stat-card">
                <h5 class="mb-3">
                    <i class="fas fa-chart-area text-primary me-2"></i>
                    الأرباح الشهرية
                </h5>
                <canvas id="earningsChart" height="100"></canvas>
            </div>
        </div>
    </div>

    <!-- Daily Earnings Table -->
    <div class="row">
        <div class="col-12">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="mb-0">
                        <i class="fas fa-table text-success me-2"></i>
                        الأرباح اليومية
                    </h5>
                </div>

                @if($earnings->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>التاريخ</th>
                                <th>عدد الطلبات</th>
                                <th>إجمالي المبيعات</th>
                                <th>صافي الأرباح</th>
                                <th>متوسط الطلب</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($earnings as $earning)
                            <tr>
                                <td>
                                    <div class="fw-bold">{{ \Carbon\Carbon::parse($earning->date)->format('Y-m-d') }}</div>
                                    <small class="text-muted">{{ \Carbon\Carbon::parse($earning->date)->format('l') }}</small>
                                </td>
                                <td>
                                    <div class="fw-bold">{{ $earning->order_count ?? 0 }}</div>
                                </td>
                                <td>
                                    <div class="fw-bold text-success">{{ number_format($earning->daily_earnings ?? 0, 2) }} ريال</div>
                                </td>
                                <td>
                                    <div class="fw-bold text-primary">{{ number_format(($earning->daily_earnings ?? 0) * 0.8, 2) }} ريال</div>
                                    <small class="text-muted">(80% من المبيعات)</small>
                                </td>
                                <td>
                                    <div class="fw-bold">{{ $earning->order_count > 0 ? number_format(($earning->daily_earnings ?? 0) / $earning->order_count, 2) : 0 }} ريال</div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $earnings->links() }}
                </div>
                @else
                <div class="text-center py-5">
                    <div class="stat-icon bg-light text-muted mx-auto mb-3" style="width: 80px; height: 80px; font-size: 2rem;">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h6 class="text-muted">لا توجد بيانات</h6>
                    <p class="text-muted mb-0">لم يتم العثور على بيانات الأرباح</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('earningsChart').getContext('2d');
    
    // Sample data - replace with actual data from backend
    const earningsData = {
        labels: ['يناير', 'فبراير', 'مارس', 'أبريل', 'مايو', 'يونيو'],
        datasets: [{
            label: 'الأرباح الشهرية',
            data: [12000, 19000, 15000, 25000, 22000, 30000],
            borderColor: 'rgb(75, 192, 192)',
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            tension: 0.1
        }]
    };

    new Chart(ctx, {
        type: 'line',
        data: earningsData,
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'الأرباح الشهرية'
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return value + ' ريال';
                        }
                    }
                }
            }
        }
    });
});
</script>
@endsection
@endsection 