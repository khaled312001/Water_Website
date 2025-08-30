@extends('layouts.admin')

@section('title', 'إدارة الأرباح - لوحة الإدارة')

@section('content')
<div class="container-fluid">
    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 shadow-lg h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="stat-icon bg-primary text-white">
                                <i class="fas fa-chart-line"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1">إجمالي هامش الربح</h6>
                            <h4 class="mb-0 text-primary">{{ number_format($totalProfitMargin, 2) }} ريال</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 shadow-lg h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="stat-icon bg-success text-white">
                                <i class="fas fa-user-tie"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1">عمولة الإدارة</h6>
                            <h4 class="mb-0 text-success">{{ number_format($totalAdminCommission, 2) }} ريال</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 shadow-lg h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="stat-icon bg-info text-white">
                                <i class="fas fa-truck"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1">عمولة التوصيل</h6>
                            <h4 class="mb-0 text-info">{{ number_format($totalDeliveryCommission, 2) }} ريال</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 shadow-lg h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="stat-icon bg-warning text-white">
                                <i class="fas fa-clock"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1">أرباح معلقة</h6>
                            <h4 class="mb-0 text-warning">{{ $pendingProfits }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Profits Table -->
    <div class="card border-0 shadow-lg">
        <div class="card-header bg-primary text-white">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="mb-0">
                    <i class="fas fa-chart-line me-2"></i>
                    تفاصيل الأرباح
                </h4>
                <button class="btn btn-light btn-sm" onclick="distributeProfits()">
                    <i class="fas fa-money-bill-wave me-2"></i>
                    توزيع الأرباح المعلقة
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>رقم الطلب</th>
                            <th>المنتج</th>
                            <th>سعر المورد</th>
                            <th>سعر العميل</th>
                            <th>هامش الربح</th>
                            <th>عمولة الإدارة</th>
                            <th>عمولة التوصيل</th>
                            <th>الحالة</th>
                            <th>التاريخ</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($profits as $profit)
                        <tr>
                            <td>
                                <a href="{{ route('admin.orders.show', $profit->order->id) }}" class="text-decoration-none">
                                    {{ $profit->order->order_number }}
                                </a>
                            </td>
                            <td>{{ $profit->order->product->name }}</td>
                            <td>{{ $profit->formatted_supplier_price }}</td>
                            <td>{{ $profit->formatted_customer_price }}</td>
                            <td>
                                <span class="badge bg-success">{{ $profit->formatted_profit_margin }}</span>
                            </td>
                            <td>
                                <span class="badge bg-primary">{{ $profit->formatted_admin_commission }}</span>
                            </td>
                            <td>
                                <span class="badge bg-info">{{ $profit->formatted_delivery_commission }}</span>
                            </td>
                            <td>
                                @switch($profit->status)
                                    @case('pending')
                                        <span class="badge bg-warning">في الانتظار</span>
                                        @break
                                    @case('distributed')
                                        <span class="badge bg-success">تم التوزيع</span>
                                        @break
                                    @case('cancelled')
                                        <span class="badge bg-danger">ملغي</span>
                                        @break
                                @endswitch
                            </td>
                            <td>{{ $profit->created_at->format('Y-m-d H:i') }}</td>
                            <td>
                                @if($profit->status === 'pending')
                                    <button class="btn btn-success btn-sm" onclick="distributeSingleProfit({{ $profit->id }})">
                                        <i class="fas fa-share-alt me-1"></i>
                                        توزيع
                                    </button>
                                @endif
                                @if($profit->distributions->count() > 0)
                                    <button class="btn btn-info btn-sm" onclick="showDistributions({{ $profit->id }})">
                                        <i class="fas fa-eye me-1"></i>
                                        التفاصيل
                                    </button>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="10" class="text-center text-muted">
                                <i class="fas fa-chart-line fa-2x mb-3"></i>
                                <p>لا توجد أرباح حتى الآن</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($profits->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    {{ $profits->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Distributions Modal -->
<div class="modal fade" id="distributionsModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">تفاصيل توزيع الأرباح</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="distributionsContent">
                <!-- Content will be loaded here -->
            </div>
        </div>
    </div>
</div>

<style>
.stat-icon {
    width: 50px;
    height: 50px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
}
</style>

<script>
function distributeProfits() {
    if (confirm('هل أنت متأكد من توزيع جميع الأرباح المعلقة؟')) {
        fetch('/admin/profits/distribute', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
            },
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('تم توزيع الأرباح بنجاح!');
                location.reload();
            } else {
                alert('حدث خطأ أثناء توزيع الأرباح');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('حدث خطأ أثناء توزيع الأرباح');
        });
    }
}

function distributeSingleProfit(profitId) {
    if (confirm('هل أنت متأكد من توزيع هذا الربح؟')) {
        fetch(`/admin/profits/${profitId}/distribute`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
            },
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('تم توزيع الربح بنجاح!');
                location.reload();
            } else {
                alert('حدث خطأ أثناء توزيع الربح');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('حدث خطأ أثناء توزيع الربح');
        });
    }
}

function showDistributions(profitId) {
    fetch(`/admin/profits/${profitId}/distributions`)
        .then(response => response.text())
        .then(html => {
            document.getElementById('distributionsContent').innerHTML = html;
            new bootstrap.Modal(document.getElementById('distributionsModal')).show();
        })
        .catch(error => {
            console.error('Error:', error);
            alert('حدث خطأ أثناء تحميل التفاصيل');
        });
}
</script>
@endsection 