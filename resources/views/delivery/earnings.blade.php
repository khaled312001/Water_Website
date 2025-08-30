@extends('layouts.delivery')

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
                        <a href="{{ route('delivery.export.earnings') }}" class="btn btn-delivery btn-outline-success">
                            <i class="fas fa-download me-2"></i>
                            تصدير التقرير
                        </a>
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
                        <h3 class="mb-1">{{ $totalDeliveries ?? 0 }}</h3>
                        <p class="text-muted mb-0">إجمالي التوصيلات</p>
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
                    الأرباح الأسبوعية
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

                @if($earningsHistory->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>التاريخ</th>
                                <th>عدد التوصيلات</th>
                                <th>إجمالي الأرباح</th>
                                <th>متوسط التوصيل</th>
                                <th>الحالة</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($earningsHistory as $earning)
                            <tr>
                                <td>
                                    <div class="fw-bold">{{ \Carbon\Carbon::parse($earning->date)->format('Y-m-d') }}</div>
                                    <small class="text-muted">{{ \Carbon\Carbon::parse($earning->date)->format('l') }}</small>
                                </td>
                                <td>
                                    <div class="fw-bold">{{ $earning->deliveries ?? 0 }}</div>
                                </td>
                                <td>
                                    <div class="fw-bold text-success">{{ number_format($earning->total_earnings ?? 0, 2) }} ريال</div>
                                </td>
                                <td>
                                    <div class="fw-bold text-primary">{{ $earning->deliveries > 0 ? number_format(($earning->total_earnings ?? 0) / $earning->deliveries, 2) : 0 }} ريال</div>
                                </td>
                                <td>
                                    @if(($earning->total_earnings ?? 0) > 100)
                                        <span class="badge bg-success">ممتاز</span>
                                    @elseif(($earning->total_earnings ?? 0) > 50)
                                        <span class="badge bg-warning">جيد</span>
                                    @else
                                        <span class="badge bg-info">عادي</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $earningsHistory->links() }}
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

    <!-- Performance Summary -->
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="stat-card">
                <h5 class="mb-3">
                    <i class="fas fa-trophy text-warning me-2"></i>
                    ملخص الأداء
                </h5>
                
                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span>أرباح اليوم</span>
                        <span class="fw-bold">{{ number_format($todayEarnings, 2) }} ريال</span>
                    </div>
                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar bg-primary" style="width: {{ min($todayEarnings * 2, 100) }}%"></div>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span>أرباح الأسبوع</span>
                        <span class="fw-bold">{{ number_format($weekEarnings, 2) }} ريال</span>
                    </div>
                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar bg-success" style="width: {{ min($weekEarnings * 2, 100) }}%"></div>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span>أرباح الشهر</span>
                        <span class="fw-bold">{{ number_format($monthEarnings, 2) }} ريال</span>
                    </div>
                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar bg-warning" style="width: {{ min($monthEarnings * 2, 100) }}%"></div>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span>نسبة الطلبات المكتملة</span>
                        <span class="fw-bold">{{ $completionRate ?? 0 }}%</span>
                    </div>
                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar bg-info" style="width: {{ $completionRate ?? 0 }}%"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="stat-card">
                <h5 class="mb-3">
                    <i class="fas fa-target text-danger me-2"></i>
                    الأهداف
                </h5>
                
                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span>الهدف اليومي (10 توصيلات)</span>
                        <span class="fw-bold">{{ $todayDeliveries ?? 0 }}/10</span>
                    </div>
                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar bg-warning" style="width: {{ min(($todayDeliveries ?? 0) * 10, 100) }}%"></div>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span>الهدف الشهري (300 توصيل)</span>
                        <span class="fw-bold">{{ $monthlyDeliveries ?? 0 }}/300</span>
                    </div>
                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar bg-danger" style="width: {{ min(($monthlyDeliveries ?? 0) / 3, 100) }}%"></div>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span>الهدف المالي الشهري (5000 ريال)</span>
                        <span class="fw-bold">{{ number_format($monthlyEarnings ?? 0, 2) }}/5000 ريال</span>
                    </div>
                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar bg-success" style="width: {{ min(($monthlyEarnings ?? 0) / 50, 100) }}%"></div>
                    </div>
                </div>
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
        labels: ['الأحد', 'الاثنين', 'الثلاثاء', 'الأربعاء', 'الخميس', 'الجمعة', 'السبت'],
        datasets: [{
            label: 'الأرباح اليومية',
            data: [150, 200, 180, 250, 220, 300, 280],
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
                    text: 'الأرباح الأسبوعية'
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