@extends('layouts.admin')

@section('title', 'إدارة المدفوعات والأرباح - لوحة الإدارة')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-lg">
                <div class="card-header bg-primary text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">
                            <i class="fas fa-credit-card me-2"></i>
                            إدارة المدفوعات والأرباح
                        </h4>
                        <div>
                            <button class="btn btn-light btn-sm" onclick="distributeProfits()">
                                <i class="fas fa-money-bill-wave me-2"></i>
                                توزيع الأرباح
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Tabs -->
                    <ul class="nav nav-tabs" id="paymentTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="payments-tab" data-bs-toggle="tab" data-bs-target="#payments" type="button" role="tab">
                                <i class="fas fa-credit-card me-2"></i>
                                المدفوعات
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="profits-tab" data-bs-toggle="tab" data-bs-target="#profits" type="button" role="tab">
                                <i class="fas fa-chart-line me-2"></i>
                                الأرباح
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="distributions-tab" data-bs-toggle="tab" data-bs-target="#distributions" type="button" role="tab">
                                <i class="fas fa-share-alt me-2"></i>
                                توزيع الأرباح
                            </button>
                        </li>
                    </ul>

                    <div class="tab-content" id="paymentTabsContent">
                        <!-- Payments Tab -->
                        <div class="tab-pane fade show active" id="payments" role="tabpanel">
                            <div class="table-responsive mt-3">
                                <table class="table table-hover">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>رقم الطلب</th>
                                            <th>العميل</th>
                                            <th>طريقة الدفع</th>
                                            <th>المبلغ</th>
                                            <th>الحالة</th>
                                            <th>التاريخ</th>
                                            <th>الإجراءات</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($payments ?? [] as $payment)
                                        <tr>
                                            <td>
                                                <a href="{{ route('admin.orders.show', $payment->order->id) }}" class="text-decoration-none">
                                                    {{ $payment->order->order_number }}
                                                </a>
                                            </td>
                                            <td>{{ $payment->order->customer_name }}</td>
                                            <td>
                                                <span class="badge bg-info">{{ $payment->payment_method_text }}</span>
                                            </td>
                                            <td>{{ $payment->formatted_amount }}</td>
                                            <td>
                                                @switch($payment->status)
                                                    @case('pending')
                                                        <span class="badge bg-warning">في الانتظار</span>
                                                        @break
                                                    @case('paid')
                                                        <span class="badge bg-success">مدفوع</span>
                                                        @break
                                                    @case('verified')
                                                        <span class="badge bg-primary">مؤكد</span>
                                                        @break
                                                    @case('failed')
                                                        <span class="badge bg-danger">فشل</span>
                                                        @break
                                                @endswitch
                                            </td>
                                            <td>{{ $payment->created_at->format('Y-m-d H:i') }}</td>
                                            <td>
                                                @if($payment->status === 'pending' && $payment->payment_method === 'bank_transfer')
                                                    <button class="btn btn-success btn-sm" onclick="verifyPayment({{ $payment->id }}, 'verified')">
                                                        <i class="fas fa-check me-1"></i>
                                                        تأكيد
                                                    </button>
                                                    <button class="btn btn-danger btn-sm" onclick="verifyPayment({{ $payment->id }}, 'failed')">
                                                        <i class="fas fa-times me-1"></i>
                                                        رفض
                                                    </button>
                                                @endif
                                                @if($payment->receipt_image)
                                                    <a href="{{ route('payments.receipt', $payment->id) }}" class="btn btn-info btn-sm" target="_blank">
                                                        <i class="fas fa-image me-1"></i>
                                                        الإيصال
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="7" class="text-center text-muted">
                                                <i class="fas fa-inbox fa-2x mb-3"></i>
                                                <p>لا توجد مدفوعات حتى الآن</p>
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Profits Tab -->
                        <div class="tab-pane fade" id="profits" role="tabpanel">
                            <div class="table-responsive mt-3">
                                <table class="table table-hover">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>رقم الطلب</th>
                                            <th>سعر المورد</th>
                                            <th>سعر العميل</th>
                                            <th>هامش الربح</th>
                                            <th>عمولة الإدارة</th>
                                            <th>عمولة التوصيل</th>
                                            <th>الحالة</th>
                                            <th>التاريخ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($profits ?? [] as $profit)
                                        <tr>
                                            <td>
                                                <a href="{{ route('admin.orders.show', $profit->order->id) }}" class="text-decoration-none">
                                                    {{ $profit->order->order_number }}
                                                </a>
                                            </td>
                                            <td>{{ $profit->formatted_supplier_price }}</td>
                                            <td>{{ $profit->formatted_customer_price }}</td>
                                            <td>{{ $profit->formatted_profit_margin }}</td>
                                            <td>{{ $profit->formatted_admin_commission }}</td>
                                            <td>{{ $profit->formatted_delivery_commission }}</td>
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
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="8" class="text-center text-muted">
                                                <i class="fas fa-chart-line fa-2x mb-3"></i>
                                                <p>لا توجد أرباح حتى الآن</p>
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Distributions Tab -->
                        <div class="tab-pane fade" id="distributions" role="tabpanel">
                            <div class="table-responsive mt-3">
                                <table class="table table-hover">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>المستخدم</th>
                                            <th>النوع</th>
                                            <th>المبلغ</th>
                                            <th>الحساب البنكي</th>
                                            <th>الحالة</th>
                                            <th>تاريخ التحويل</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($distributions ?? [] as $distribution)
                                        <tr>
                                            <td>{{ $distribution->user->name }}</td>
                                            <td>
                                                <span class="badge bg-{{ $distribution->user_type === 'admin' ? 'primary' : 'success' }}">
                                                    {{ $distribution->user_type_text }}
                                                </span>
                                            </td>
                                            <td>{{ $distribution->formatted_amount }}</td>
                                            <td>
                                                @if($distribution->bankAccount)
                                                    {{ $distribution->bankAccount->bank_name }} - {{ $distribution->bankAccount->formatted_account_number }}
                                                @else
                                                    <span class="text-muted">غير محدد</span>
                                                @endif
                                            </td>
                                            <td>
                                                @switch($distribution->status)
                                                    @case('pending')
                                                        <span class="badge bg-warning">في الانتظار</span>
                                                        @break
                                                    @case('transferred')
                                                        <span class="badge bg-success">تم التحويل</span>
                                                        @break
                                                    @case('failed')
                                                        <span class="badge bg-danger">فشل</span>
                                                        @break
                                                @endswitch
                                            </td>
                                            <td>
                                                @if($distribution->transferred_at)
                                                    {{ $distribution->transferred_at->format('Y-m-d H:i') }}
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="6" class="text-center text-muted">
                                                <i class="fas fa-share-alt fa-2x mb-3"></i>
                                                <p>لا توجد توزيعات حتى الآن</p>
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Verification Modal -->
<div class="modal fade" id="verificationModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">تأكيد الدفع</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="verificationForm" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="verification_status" class="form-label">الحالة</label>
                        <select class="form-select" id="verification_status" name="status" required>
                            <option value="verified">تأكيد الدفع</option>
                            <option value="failed">رفض الدفع</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="verification_notes" class="form-label">ملاحظات</label>
                        <textarea class="form-control" id="verification_notes" name="notes" rows="3" placeholder="أي ملاحظات إضافية..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-primary">تأكيد</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function verifyPayment(paymentId, status) {
    const modal = new bootstrap.Modal(document.getElementById('verificationModal'));
    const form = document.getElementById('verificationForm');
    const statusSelect = document.getElementById('verification_status');
    
    form.action = `/admin/payments/${paymentId}/verify`;
    statusSelect.value = status;
    
    modal.show();
}

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
</script>
@endsection 