@extends('layouts.admin')

@section('title', 'الطلبات التي تحتاج تأكيد الدفع - لوحة الإدارة')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-lg">
                <div class="card-header bg-warning text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">
                            <i class="fas fa-clock me-2"></i>
                            الطلبات التي تحتاج تأكيد الدفع
                        </h4>
                        <span class="badge bg-light text-dark fs-6">{{ $pendingPayments->total() }} طلب</span>
                    </div>
                </div>
                <div class="card-body p-4">
                    @if($pendingPayments->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>رقم الطلب</th>
                                        <th>العميل</th>
                                        <th>المنتج</th>
                                        <th>طريقة الدفع</th>
                                        <th>المبلغ</th>
                                        <th>تاريخ الدفع</th>
                                        <th>الإيصال</th>
                                        <th>الإجراءات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pendingPayments as $payment)
                                        <tr>
                                            <td>
                                                <strong>#{{ $payment->order->id }}</strong>
                                                <br>
                                                <small class="text-muted">{{ $payment->order->order_number }}</small>
                                            </td>
                                            <td>
                                                <div>
                                                    <strong>{{ $payment->order->customer->name }}</strong>
                                                    <br>
                                                    <small class="text-muted">{{ $payment->order->customer->phone }}</small>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    @if($payment->order->product->image)
                                                        <img src="{{ asset('storage/' . $payment->order->product->image) }}" 
                                                             alt="{{ $payment->order->product->name }}" 
                                                             class="rounded me-2" 
                                                             style="width: 40px; height: 40px; object-fit: cover;">
                                                    @endif
                                                    <div>
                                                        <div class="fw-bold">{{ $payment->order->product->name }}</div>
                                                        <small class="text-muted">الكمية: {{ $payment->order->quantity }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge bg-info">{{ $payment->payment_method_text }}</span>
                                                @if($payment->transaction_id)
                                                    <br>
                                                    <small class="text-muted">رقم العملية: {{ $payment->transaction_id }}</small>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="fw-bold text-primary">{{ number_format($payment->amount, 2) }} ريال</span>
                                            </td>
                                            <td>
                                                {{ $payment->created_at->format('Y-m-d H:i') }}
                                                <br>
                                                <small class="text-muted">{{ $payment->created_at->diffForHumans() }}</small>
                                            </td>
                                            <td>
                                                @if($payment->receipt_image)
                                                    <a href="{{ asset('storage/' . $payment->receipt_image) }}" 
                                                       target="_blank" 
                                                       class="btn btn-sm btn-outline-primary">
                                                        <i class="fas fa-image me-1"></i>
                                                        عرض الإيصال
                                                    </a>
                                                @else
                                                    <span class="text-muted">لا يوجد إيصال</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <button type="button" 
                                                            class="btn btn-success" 
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#verifyModal{{ $payment->id }}">
                                                        <i class="fas fa-check me-1"></i>
                                                        تأكيد
                                                    </button>
                                                    <button type="button" 
                                                            class="btn btn-danger" 
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#rejectModal{{ $payment->id }}">
                                                        <i class="fas fa-times me-1"></i>
                                                        رفض
                                                    </button>
                                                    <a href="{{ route('admin.orders.show', $payment->order->id) }}" 
                                                       class="btn btn-outline-primary" 
                                                       title="عرض تفاصيل الطلب">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Pagination -->
                        <div class="d-flex justify-content-center mt-4">
                            {{ $pendingPayments->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-check-circle text-success" style="font-size: 4rem;"></i>
                            <h4 class="mt-3 text-success">لا توجد طلبات تحتاج تأكيد الدفع</h4>
                            <p class="text-muted">جميع الطلبات تم تأكيد دفعها أو رفضها</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Verify Modals -->
@foreach($pendingPayments as $payment)
    <div class="modal fade" id="verifyModal{{ $payment->id }}" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title">
                        <i class="fas fa-check-circle me-2"></i>
                        تأكيد الدفع
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('admin.payments.verify', $payment->id) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <p>هل أنت متأكد من تأكيد دفع الطلب رقم <strong>#{{ $payment->order->id }}</strong>؟</p>
                        <p><strong>العميل:</strong> {{ $payment->order->customer->name }}</p>
                        <p><strong>المبلغ:</strong> {{ number_format($payment->amount, 2) }} ريال</p>
                        <p><strong>طريقة الدفع:</strong> {{ $payment->payment_method_text }}</p>
                        
                        <div class="mb-3">
                            <label for="notes{{ $payment->id }}" class="form-label">ملاحظات (اختياري)</label>
                            <textarea class="form-control" id="notes{{ $payment->id }}" name="notes" rows="3" 
                                      placeholder="أي ملاحظات إضافية حول تأكيد الدفع"></textarea>
                        </div>
                        
                        <input type="hidden" name="status" value="verified">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-check me-1"></i>
                            تأكيد الدفع
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Reject Modal -->
    <div class="modal fade" id="rejectModal{{ $payment->id }}" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">
                        <i class="fas fa-times-circle me-2"></i>
                        رفض الدفع
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('admin.payments.verify', $payment->id) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <p>هل أنت متأكد من رفض دفع الطلب رقم <strong>#{{ $payment->order->id }}</strong>؟</p>
                        <p><strong>العميل:</strong> {{ $payment->order->customer->name }}</p>
                        <p><strong>المبلغ:</strong> {{ number_format($payment->amount, 2) }} ريال</p>
                        
                        <div class="mb-3">
                            <label for="reject_notes{{ $payment->id }}" class="form-label">سبب الرفض (مطلوب)</label>
                            <textarea class="form-control" id="reject_notes{{ $payment->id }}" name="notes" rows="3" 
                                      placeholder="يرجى توضيح سبب رفض الدفع" required></textarea>
                        </div>
                        
                        <input type="hidden" name="status" value="failed">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-times me-1"></i>
                            رفض الدفع
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach
@endsection 