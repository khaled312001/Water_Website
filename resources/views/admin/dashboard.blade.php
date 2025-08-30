@extends('layouts.admin')

@section('title', 'لوحة التحكم - سلسبيل مكة')
@section('page-title', 'لوحة التحكم')

@section('content')
<div class="fade-in">
    <!-- Welcome Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="stat-card">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h4 class="mb-2">مرحباً {{ auth()->user()->name }} 👋</h4>
                        <p class="text-muted mb-0">إليك نظرة عامة على أداء النظام اليوم</p>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <div class="text-end me-3">
                            <div class="text-muted">آخر تحديث</div>
                            <div class="fw-bold">{{ now()->format('Y-m-d H:i') }}</div>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-admin btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-file-export me-2"></i>
                                تصدير البيانات
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('admin.export.dashboard') }}">
                                    <i class="fas fa-chart-line me-2"></i>
                                    تصدير لوحة التحكم
                                </a></li>
                                <li><a class="dropdown-item" href="{{ route('admin.export.users') }}">
                                    <i class="fas fa-users me-2"></i>
                                    تصدير المستخدمين
                                </a></li>
                                <li><a class="dropdown-item" href="{{ route('admin.export.orders') }}">
                                    <i class="fas fa-shopping-cart me-2"></i>
                                    تصدير الطلبات
                                </a></li>
                                <li><a class="dropdown-item" href="{{ route('admin.export.products') }}">
                                    <i class="fas fa-box me-2"></i>
                                    تصدير المنتجات
                                </a></li>
                                <li><a class="dropdown-item" href="{{ route('admin.export.suppliers') }}">
                                    <i class="fas fa-store me-2"></i>
                                    تصدير الموردين
                                </a></li>
                                <li><a class="dropdown-item" href="{{ route('admin.export.delivery-men') }}">
                                    <i class="fas fa-truck me-2"></i>
                                    تصدير مندوبي التوصيل
                                </a></li>
                                <li><a class="dropdown-item" href="{{ route('admin.export.reviews') }}">
                                    <i class="fas fa-star me-2"></i>
                                    تصدير التقييمات
                                </a></li>
                            </ul>
                        </div>
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
                    <div class="stat-icon bg-primary bg-opacity-10 text-primary">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="ms-3">
                        <div class="stat-number text-primary">{{ number_format($stats['total_users']) }}</div>
                        <div class="stat-label">إجمالي المستخدمين</div>
                        <div class="stat-change text-success">
                            <i class="fas fa-arrow-up me-1"></i>
                            +{{ $stats['new_users_this_month'] }} هذا الشهر
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stat-card">
                <div class="d-flex align-items-center">
                    <div class="stat-icon bg-success bg-opacity-10 text-success">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <div class="ms-3">
                        <div class="stat-number text-success">{{ number_format($stats['total_orders']) }}</div>
                        <div class="stat-label">إجمالي الطلبات</div>
                        <div class="stat-change text-success">
                            <i class="fas fa-arrow-up me-1"></i>
                            +{{ $stats['new_orders_today'] }} اليوم
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stat-card">
                <div class="d-flex align-items-center">
                    <div class="stat-icon bg-warning bg-opacity-10 text-warning">
                        <i class="fas fa-store"></i>
                    </div>
                    <div class="ms-3">
                        <div class="stat-number text-warning">{{ number_format($stats['total_suppliers']) }}</div>
                        <div class="stat-label">إجمالي الموردين</div>
                        <div class="stat-change text-warning">
                            <i class="fas fa-check me-1"></i>
                            {{ $stats['active_suppliers'] }} نشط
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stat-card">
                <div class="d-flex align-items-center">
                    <div class="stat-icon bg-info bg-opacity-10 text-info">
                        <i class="fas fa-money-bill-wave"></i>
                    </div>
                    <div class="ms-3">
                        <div class="stat-number text-info">{{ number_format($stats['total_revenue'], 2) }}</div>
                        <div class="stat-label">إجمالي الإيرادات</div>
                        <div class="stat-change text-info">
                            <i class="fas fa-arrow-up me-1"></i>
                            +{{ number_format($stats['revenue_this_month'], 2) }} هذا الشهر
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions & Recent Orders -->
    <div class="row mb-4">
        <!-- Quick Actions -->
        <div class="col-lg-4 mb-4">
            <div class="stat-card">
                <h5 class="mb-3">
                    <i class="fas fa-bolt text-primary me-2"></i>
                    إجراءات سريعة
                </h5>
                <div class="quick-actions">
                    <a href="{{ route('admin.users') }}" class="action-card">
                        <div class="action-icon bg-primary bg-opacity-10 text-primary">
                            <i class="fas fa-users"></i>
                        </div>
                        <h6 class="mb-1">إدارة المستخدمين</h6>
                        <small class="text-muted">عرض وتعديل المستخدمين</small>
                    </a>
                    
                    <a href="{{ route('admin.suppliers') }}" class="action-card">
                        <div class="action-icon bg-success bg-opacity-10 text-success">
                            <i class="fas fa-store"></i>
                        </div>
                        <h6 class="mb-1">إدارة الموردين</h6>
                        <small class="text-muted">عرض وتعديل الموردين</small>
                    </a>
                    
                    <a href="{{ route('admin.products') }}" class="action-card">
                        <div class="action-icon bg-warning bg-opacity-10 text-warning">
                            <i class="fas fa-box"></i>
                        </div>
                        <h6 class="mb-1">إدارة المنتجات</h6>
                        <small class="text-muted">عرض وتعديل المنتجات</small>
                    </a>
                    
                    <a href="{{ route('admin.orders') }}" class="action-card">
                        <div class="action-icon bg-info bg-opacity-10 text-info">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                        <h6 class="mb-1">إدارة الطلبات</h6>
                        <small class="text-muted">عرض وتتبع الطلبات</small>
                    </a>
                </div>
            </div>
        </div>

        <!-- Recent Orders -->
        <div class="col-lg-8">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="mb-0">
                        <i class="fas fa-clock text-primary me-2"></i>
                        آخر الطلبات
                    </h5>
                    <a href="{{ route('admin.orders') }}" class="btn btn-admin btn-outline-primary btn-sm">
                        عرض الكل
                    </a>
                </div>
                
                @if($recentOrders->count() > 0)
                    <div class="admin-table">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>رقم الطلب</th>
                                    <th>العميل</th>
                                    <th>المنتج</th>
                                    <th>السعر</th>
                                    <th>الحالة</th>
                                    <th>التاريخ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentOrders as $order)
                                <tr>
                                    <td>
                                        <span class="fw-bold">#{{ $order->order_number ?? $order->id }}</span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="user-avatar me-2" style="width: 30px; height: 30px; font-size: 0.75rem;">
                                                {{ substr($order->customer->name ?? 'م', 0, 1) }}
                                            </div>
                                            <div>
                                                <div class="fw-bold">{{ $order->customer->name ?? 'غير محدد' }}</div>
                                                <small class="text-muted">{{ $order->customer->phone ?? '' }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="fw-bold">{{ Str::limit($order->product->name ?? 'غير محدد', 20) }}</div>
                                        <small class="text-muted">{{ $order->quantity ?? 1 }} قطعة</small>
                                    </td>
                                    <td>
                                        <span class="fw-bold text-success">{{ number_format($order->total_amount ?? 0, 2) }} ريال</span>
                                    </td>
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
                                            $statusColor = $statusColors[$order->status ?? 'pending'] ?? 'warning';
                                        @endphp
                                        <span class="badge-admin bg-{{ $statusColor }}">
                                            {{ $order->status_text ?? 'في الانتظار' }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="fw-bold">{{ $order->created_at->format('Y-m-d') }}</div>
                                        <small class="text-muted">{{ $order->created_at->format('H:i') }}</small>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5">
                        <div class="stat-icon bg-light text-muted mx-auto mb-3" style="width: 80px; height: 80px; font-size: 2rem;">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                        <h6 class="text-muted">لا توجد طلبات حديثة</h6>
                        <p class="text-muted mb-0">ستظهر الطلبات الجديدة هنا</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="row mb-4">
        <!-- Orders Chart -->
        <div class="col-lg-6 mb-4">
            <div class="chart-container">
                <h5 class="mb-3">
                    <i class="fas fa-chart-line text-primary me-2"></i>
                    إحصائيات الطلبات
                </h5>
                <canvas id="ordersChart" width="400" height="200"></canvas>
            </div>
        </div>

        <!-- Revenue Chart -->
        <div class="col-lg-6 mb-4">
            <div class="chart-container">
                <h5 class="mb-3">
                    <i class="fas fa-chart-bar text-success me-2"></i>
                    إحصائيات الإيرادات
                </h5>
                <canvas id="revenueChart" width="400" height="200"></canvas>
            </div>
        </div>
    </div>

    <!-- System Status & Notifications -->
    <div class="row">
        <!-- System Status -->
        <div class="col-lg-6 mb-4">
            <div class="stat-card">
                <h5 class="mb-3">
                    <i class="fas fa-server text-primary me-2"></i>
                    حالة النظام
                </h5>
                <div class="row">
                    <div class="col-6 mb-3">
                        <div class="d-flex justify-content-between align-items-center p-3 bg-light rounded">
                            <div>
                                <div class="fw-bold">قاعدة البيانات</div>
                                <small class="text-muted">MySQL</small>
                            </div>
                            <span class="badge-admin bg-success">متصل</span>
                        </div>
                    </div>
                    <div class="col-6 mb-3">
                        <div class="d-flex justify-content-between align-items-center p-3 bg-light rounded">
                            <div>
                                <div class="fw-bold">الخادم</div>
                                <small class="text-muted">Apache/Nginx</small>
                            </div>
                            <span class="badge-admin bg-success">يعمل</span>
                        </div>
                    </div>
                    <div class="col-6 mb-3">
                        <div class="d-flex justify-content-between align-items-center p-3 bg-light rounded">
                            <div>
                                <div class="fw-bold">التطبيق</div>
                                <small class="text-muted">Laravel</small>
                            </div>
                            <span class="badge-admin bg-success">متاح</span>
                        </div>
                    </div>
                    <div class="col-6 mb-3">
                        <div class="d-flex justify-content-between align-items-center p-3 bg-light rounded">
                            <div>
                                <div class="fw-bold">آخر تحديث</div>
                                <small class="text-muted">{{ now()->format('H:i') }}</small>
                            </div>
                            <span class="badge-admin bg-info">محدث</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="col-lg-6 mb-4">
            <div class="stat-card">
                <h5 class="mb-3">
                    <i class="fas fa-bell text-warning me-2"></i>
                    النشاط الأخير
                </h5>
                <div class="timeline">
                    <div class="d-flex align-items-start mb-3">
                        <div class="flex-shrink-0">
                            <div class="stat-icon bg-primary bg-opacity-10 text-primary" style="width: 40px; height: 40px; font-size: 1rem;">
                                <i class="fas fa-user-plus"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <div class="fw-bold">مستخدم جديد مسجل</div>
                            <small class="text-muted">تم تسجيل مستخدم جديد في النظام</small>
                            <div class="text-muted mt-1">{{ now()->subMinutes(5)->diffForHumans() }}</div>
                        </div>
                    </div>
                    
                    <div class="d-flex align-items-start mb-3">
                        <div class="flex-shrink-0">
                            <div class="stat-icon bg-success bg-opacity-10 text-success" style="width: 40px; height: 40px; font-size: 1rem;">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <div class="fw-bold">طلب جديد</div>
                            <small class="text-muted">تم إنشاء طلب جديد من العميل</small>
                            <div class="text-muted mt-1">{{ now()->subMinutes(15)->diffForHumans() }}</div>
                        </div>
                    </div>
                    
                    <div class="d-flex align-items-start mb-3">
                        <div class="flex-shrink-0">
                            <div class="stat-icon bg-warning bg-opacity-10 text-warning" style="width: 40px; height: 40px; font-size: 1rem;">
                                <i class="fas fa-star"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <div class="fw-bold">تقييم جديد</div>
                            <small class="text-muted">تم إضافة تقييم جديد للمنتج</small>
                            <div class="text-muted mt-1">{{ now()->subMinutes(30)->diffForHumans() }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
// Orders Chart
const ordersCtx = document.getElementById('ordersChart').getContext('2d');
const ordersChart = new Chart(ordersCtx, {
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

// Revenue Chart
const revenueCtx = document.getElementById('revenueChart').getContext('2d');
const revenueChart = new Chart(revenueCtx, {
    type: 'bar',
    data: {
        labels: ['يناير', 'فبراير', 'مارس', 'أبريل', 'مايو', 'يونيو'],
        datasets: [{
            label: 'الإيرادات',
            data: [12000, 19000, 3000, 5000, 2000, 3000],
            backgroundColor: 'rgba(5, 150, 105, 0.8)',
            borderColor: '#059669',
            borderWidth: 0,
            borderRadius: 8
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
</script>
@endsection 