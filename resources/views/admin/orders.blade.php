@extends('layouts.admin')

@section('title', 'إدارة الطلبات - سلسبيل مكة')
@section('page-title', 'إدارة الطلبات')

@section('content')
<div class="fade-in">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="stat-card">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h4 class="mb-2">إدارة الطلبات</h4>
                        <p class="text-muted mb-0">عرض وإدارة جميع الطلبات في النظام</p>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('orders.create') }}" class="btn btn-admin btn-primary">
                            <i class="fas fa-plus me-2"></i>
                            طلب جديد
                        </a>
                        <a href="{{ route('admin.export.orders') }}" class="btn btn-admin btn-outline-success">
                            <i class="fas fa-file-export me-2"></i>
                            تصدير البيانات
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Search Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="stat-card">
                <form method="GET" action="{{ route('admin.orders') }}">
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
                                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>انتظار</option>
                                <option value="confirmed" {{ request('status') === 'confirmed' ? 'selected' : '' }}>مؤكد</option>
                                <option value="preparing" {{ request('status') === 'preparing' ? 'selected' : '' }}>تحضير</option>
                                <option value="assigned" {{ request('status') === 'assigned' ? 'selected' : '' }}>مخصص</option>
                                <option value="picked_up" {{ request('status') === 'picked_up' ? 'selected' : '' }}>مستلم</option>
                                <option value="delivered" {{ request('status') === 'delivered' ? 'selected' : '' }}>مسلم</option>
                                <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>ملغي</option>
                            </select>
                            <!-- Debug: {{ request('status') }} -->
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">حالة الدفع</label>
                            <select class="form-select" name="payment_status">
                                <option value="">جميع حالات الدفع</option>
                                <option value="pending" {{ request('payment_status') === 'pending' ? 'selected' : '' }}>في الانتظار</option>
                                <option value="paid" {{ request('payment_status') === 'paid' ? 'selected' : '' }}>مدفوع</option>
                                <option value="failed" {{ request('payment_status') === 'failed' ? 'selected' : '' }}>فشل</option>
                            </select>
                            <!-- Debug: {{ request('payment_status') }} -->
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">&nbsp;</label>
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-admin btn-primary flex-grow-1">
                                    <i class="fas fa-search me-2"></i>
                                    بحث
                                </button>
                                <a href="{{ route('admin.orders') }}" class="btn btn-admin btn-outline-secondary">
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
                </div>

                @if($orders->count() > 0)
                    <div class="admin-table">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0 table-sm">
                            <thead>
                                <tr>
                                    <th>رقم الطلب</th>
                                    <th>العميل</th>
                                    <th>المنتج</th>
                                    <th>المورد</th>
                                    <th>المندوب</th>
                                    <th>السعر</th>
                                    <th>الحالة</th>
                                    <th>حالة الدفع</th>
                                    <th>التاريخ</th>
                                    <th>الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orders as $order)
                                <tr>
                                    <td>
                                        <span class="fw-bold">#{{ $order->order_number ?? $order->id }}</span>
                                    </td>
                                    <td>
                                        <div class="fw-bold">{{ Str::limit($order->customer->name ?? 'غير محدد', 15) }}</div>
                                        <small class="text-muted">{{ $order->customer->phone ?? '' }}</small>
                                    </td>
                                    <td>
                                        <div class="fw-bold">{{ Str::limit($order->product->name ?? 'غير محدد', 12) }}</div>
                                        <small class="text-muted">{{ $order->quantity ?? 1 }} قطعة</small>
                                    </td>
                                    <td>
                                        <div class="fw-bold">{{ Str::limit($order->supplier->company_name ?? 'غير محدد', 15) }}</div>
                                    </td>
                                    <td>
                                        @if($order->deliveryMan)
                                            <div class="fw-bold">{{ $order->deliveryMan->user->name ?? 'غير محدد' }}</div>
                                            <small class="text-success">
                                                <i class="fas fa-check-circle me-1"></i>
                                                مخصص
                                            </small>
                                            <button type="button" 
                                                    class="btn btn-sm btn-outline-warning mt-1"
                                                    onclick="changeDeliveryMan({{ $order->id }}, '{{ $order->deliveryMan->user->name ?? '' }}')"
                                                    title="تغيير المندوب">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                        @else
                                            <select class="form-select form-select-sm delivery-man-select" 
                                                    data-order-id="{{ $order->id }}"
                                                    onchange="assignDeliveryMan({{ $order->id }}, this.value)">
                                                <option value="">اختر مندوب التوصيل...</option>
                                            </select>
                                            <small class="text-warning">
                                                <i class="fas fa-clock me-1"></i>
                                                في انتظار التخصيص
                                            </small>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="fw-bold text-success">{{ number_format($order->total_amount ?? 0, 2) }} ريال</span>
                                    </td>
                                    <td>
                                        <div class="fw-bold">
                                            @switch($order->status)
                                                @case('pending')
                                                    <span class="text-warning">انتظار</span>
                                                    @break
                                                @case('confirmed')
                                                    <span class="text-info">مؤكد</span>
                                                    @break
                                                @case('preparing')
                                                    <span class="text-primary">تحضير</span>
                                                    @break
                                                @case('assigned')
                                                    <span class="text-secondary">مخصص</span>
                                                    @break
                                                @case('picked_up')
                                                    <span class="text-info">مستلم</span>
                                                    @break
                                                @case('delivered')
                                                    <span class="text-success">مسلم</span>
                                                    @break
                                                @case('cancelled')
                                                    <span class="text-danger">ملغي</span>
                                                    @break
                                                @default
                                                    <span class="text-muted">انتظار</span>
                                            @endswitch
                                        </div>
                                        <select class="form-select form-select-sm status-select" 
                                                data-order-id="{{ $order->id }}"
                                                onchange="updateOrderStatus({{ $order->id }}, this.value)">
                                            <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>انتظار</option>
                                            <option value="confirmed" {{ $order->status === 'confirmed' ? 'selected' : '' }}>مؤكد</option>
                                            <option value="preparing" {{ $order->status === 'preparing' ? 'selected' : '' }}>تحضير</option>
                                            <option value="assigned" {{ $order->status === 'assigned' ? 'selected' : '' }}>مخصص</option>
                                            <option value="picked_up" {{ $order->status === 'picked_up' ? 'selected' : '' }}>مستلم</option>
                                            <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>مسلم</option>
                                            <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>ملغي</option>
                                        </select>
                                    </td>
                                    <td>
                                        <div class="fw-bold">
                                            @switch($order->payment_status)
                                                @case('pending')
                                                    <span class="text-warning">انتظار</span>
                                                    @break
                                                @case('paid')
                                                    <span class="text-success">مدفوع</span>
                                                    @break
                                                @case('failed')
                                                    <span class="text-danger">فشل</span>
                                                    @break
                                                @default
                                                    <span class="text-muted">انتظار</span>
                                            @endswitch
                                        </div>
                                        <select class="form-select form-select-sm payment-status-select" 
                                                data-order-id="{{ $order->id }}"
                                                onchange="updatePaymentStatus({{ $order->id }}, this.value)">
                                            <option value="pending" {{ $order->payment_status === 'pending' ? 'selected' : '' }}>انتظار</option>
                                            <option value="paid" {{ $order->payment_status === 'paid' ? 'selected' : '' }}>مدفوع</option>
                                            <option value="failed" {{ $order->payment_status === 'failed' ? 'selected' : '' }}>فشل</option>
                                        </select>
                                    </td>
                                    <td>
                                        <div class="fw-bold">{{ $order->created_at->format('m/d') }}</div>
                                        <small class="text-muted">{{ $order->created_at->format('H:i') }}</small>
                                    </td>
                                    <td>
                                        <div class="btn-group-vertical btn-group-sm" role="group">
                                            <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-outline-primary" title="عرض">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.orders.edit', $order->id) }}" class="btn btn-sm btn-outline-warning" title="تعديل">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.orders.delete', $order->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('هل أنت متأكد من حذف هذا الطلب؟')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="حذف">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
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

<!-- Assign Delivery Man Modals -->
@foreach($orders as $order)
    @if($order->status === 'confirmed' && !$order->delivery_man_id)
        <div class="modal fade" id="assignModal{{ $order->id }}" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title">
                            <i class="fas fa-truck me-2"></i>
                            إسناد الطلب لمندوب توصيل
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <form action="{{ route('admin.orders.assign-delivery', $order->id) }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3">
                                <h6>تفاصيل الطلب:</h6>
                                <p><strong>رقم الطلب:</strong> #{{ $order->order_number ?? $order->id }}</p>
                                <p><strong>العميل:</strong> {{ $order->customer->name ?? 'غير محدد' }}</p>
                                <p><strong>المنتج:</strong> {{ $order->product->name ?? 'غير محدد' }}</p>
                                <p><strong>العنوان:</strong> {{ $order->delivery_address ?? 'غير محدد' }}</p>
                            </div>
                            
                            <div class="mb-3">
                                <label for="delivery_man_id{{ $order->id }}" class="form-label">اختر مندوب التوصيل:</label>
                                <select class="form-select" id="delivery_man_id{{ $order->id }}" name="delivery_man_id" required>
                                    <option value="">اختر مندوب التوصيل...</option>
                                </select>
                                <div class="form-text">سيتم عرض مندوبي التوصيل المتاحين فقط</div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-check me-1"></i>
                                إسناد الطلب
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
@endforeach

@endsection

@section('styles')
<style>
.admin-table .table {
    font-size: 0.875rem;
}

.admin-table .table th,
.admin-table .table td {
    padding: 0.5rem;
    vertical-align: middle;
}

.admin-table .table th {
    font-size: 0.8rem;
    font-weight: 600;
    background-color: #f8f9fa;
}

.admin-table .form-select-sm {
    font-size: 0.75rem;
    padding: 0.25rem 0.5rem;
}

.admin-table .btn-group-vertical .btn {
    margin-bottom: 0.25rem;
}

.admin-table .btn-group-vertical .btn:last-child {
    margin-bottom: 0;
}

/* تحسين عرض الأعمدة */
.admin-table .table th:nth-child(1), /* رقم الطلب */
.admin-table .table td:nth-child(1) {
    width: 120px;
}

.admin-table .table th:nth-child(2), /* العميل */
.admin-table .table td:nth-child(2) {
    width: 140px;
}

.admin-table .table th:nth-child(3), /* المنتج */
.admin-table .table td:nth-child(3) {
    width: 120px;
}

.admin-table .table th:nth-child(4), /* المورد */
.admin-table .table td:nth-child(4) {
    width: 140px;
}

.admin-table .table th:nth-child(5), /* المندوب */
.admin-table .table td:nth-child(5) {
    width: 150px;
}

.admin-table .table th:nth-child(6), /* السعر */
.admin-table .table td:nth-child(6) {
    width: 100px;
}

.admin-table .table th:nth-child(7), /* الحالة */
.admin-table .table td:nth-child(7) {
    width: 120px;
}

.admin-table .table th:nth-child(8), /* حالة الدفع */
.admin-table .table td:nth-child(8) {
    width: 120px;
}

.admin-table .table th:nth-child(9), /* التاريخ */
.admin-table .table td:nth-child(9) {
    width: 80px;
}

.admin-table .table th:nth-child(10), /* الإجراءات */
.admin-table .table td:nth-child(10) {
    width: 80px;
}

/* تحسين عرض القوائم المنسدلة في الفلترة */
.stat-card .form-select {
    min-width: 150px;
    max-width: 200px;
    text-overflow: ellipsis;
    white-space: nowrap;
    overflow: hidden;
}

.stat-card .form-select option {
    padding: 8px 12px;
    font-size: 14px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

/* تحسين عرض القوائم المنسدلة في الجدول */
.admin-table .form-select-sm {
    min-width: 120px;
    max-width: 150px;
    text-overflow: ellipsis;
    white-space: nowrap;
    overflow: hidden;
}

.admin-table .form-select-sm option {
    padding: 6px 10px;
    font-size: 12px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

/* تحسين عرض النص في الخلايا */
.admin-table .table td {
    max-width: 0;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.admin-table .table td .fw-bold {
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    display: block;
}
</style>
@endsection

@section('scripts')
<script>
// تحميل مندوبي التوصيل المتاحين عند فتح modal
document.addEventListener('DOMContentLoaded', function() {
    const modals = document.querySelectorAll('[id^="assignModal"]');
    
    modals.forEach(modal => {
        modal.addEventListener('show.bs.modal', function() {
            const orderId = this.id.replace('assignModal', '');
            const select = this.querySelector('select[name="delivery_man_id"]');
            
            // تحميل مندوبي التوصيل المتاحين
            fetch('{{ route("admin.delivery-men.available") }}')
                .then(response => response.json())
                .then(data => {
                    select.innerHTML = '<option value="">اختر مندوب التوصيل...</option>';
                    
                    data.forEach(deliveryMan => {
                        const option = document.createElement('option');
                        option.value = deliveryMan.id;
                        option.textContent = `${deliveryMan.name} (${deliveryMan.phone}) - ${deliveryMan.current_orders} طلب حالياً`;
                        select.appendChild(option);
                    });
                })
                .catch(error => {
                    console.error('Error loading delivery men:', error);
                    select.innerHTML = '<option value="">خطأ في تحميل البيانات</option>';
                });
        });
    });

    // تحميل مندوبي التوصيل في القوائم المنسدلة في الجدول
    loadDeliveryMenInTable();
});

// دالة تحميل مندوبي التوصيل في الجدول
function loadDeliveryMenInTable() {
    const selects = document.querySelectorAll('.delivery-man-select');
    console.log('Found delivery-man-select elements:', selects.length);
    
    selects.forEach(select => {
        console.log('Loading delivery men for select:', select);
        fetch('{{ route("test.delivery-men") }}')
            .then(response => {
                console.log('Response status:', response.status);
                return response.json();
            })
            .then(data => {
                console.log('Delivery men data:', data);
                select.innerHTML = '<option value="">اختر مندوب التوصيل...</option>';
                
                if (data && data.length > 0) {
                    data.forEach(deliveryMan => {
                        const option = document.createElement('option');
                        option.value = deliveryMan.id;
                        option.textContent = `${deliveryMan.name} (${deliveryMan.phone})`;
                        select.appendChild(option);
                    });
                } else {
                    select.innerHTML = '<option value="">لا يوجد مندوبي توصيل متاحين</option>';
                }
            })
            .catch(error => {
                console.error('Error loading delivery men:', error);
                select.innerHTML = '<option value="">خطأ في تحميل البيانات</option>';
            });
    });
}

// دالة إسناد مندوب التوصيل
function assignDeliveryMan(orderId, deliveryManId) {
    if (!deliveryManId) return;
    
    const formData = new FormData();
    formData.append('delivery_man_id', deliveryManId);
    formData.append('_token', '{{ csrf_token() }}');
    
    fetch(`/admin/orders/${orderId}/assign-delivery`, {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // تحديث الصف في الجدول
            location.reload();
        } else {
            alert('حدث خطأ أثناء إسناد الطلب: ' + (data.message || 'خطأ غير معروف'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('حدث خطأ أثناء إسناد الطلب');
    });
}

// دالة تغيير مندوب التوصيل
function changeDeliveryMan(orderId, currentDeliveryManName) {
    const newDeliveryManId = prompt(`تغيير مندوب التوصيل للطلب #${orderId}\nالمندوب الحالي: ${currentDeliveryManName}\n\nأدخل معرف المندوب الجديد:`);
    
    if (newDeliveryManId && newDeliveryManId.trim()) {
        assignDeliveryMan(orderId, newDeliveryManId.trim());
    }
}

// دالة تحديث حالة الطلب
function updateOrderStatus(orderId, newStatus) {
    if (!newStatus) return;
    
    const formData = new FormData();
    formData.append('status', newStatus);
    formData.append('_token', '{{ csrf_token() }}');
    formData.append('_method', 'PUT');
    
    fetch(`/admin/orders/${orderId}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: new URLSearchParams(formData)
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            // تحديث الصف في الجدول
            location.reload();
        } else {
            alert('حدث خطأ أثناء تحديث حالة الطلب: ' + (data.message || 'خطأ غير معروف'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('حدث خطأ أثناء تحديث حالة الطلب');
    });
}

// دالة تحديث حالة الدفع
function updatePaymentStatus(orderId, newPaymentStatus) {
    if (!newPaymentStatus) return;
    
    const formData = new FormData();
    formData.append('payment_status', newPaymentStatus);
    formData.append('_token', '{{ csrf_token() }}');
    formData.append('_method', 'PUT');
    
    fetch(`/admin/orders/${orderId}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: new URLSearchParams(formData)
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            // إظهار إشعار نجاح
            showNotification('تم تحديث حالة الدفع بنجاح', 'success');
            
            // تحديث الصف في الجدول
            setTimeout(() => {
                location.reload();
            }, 1000);
        } else {
            showNotification('حدث خطأ أثناء تحديث حالة الدفع: ' + (data.message || 'خطأ غير معروف'), 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('حدث خطأ أثناء تحديث حالة الدفع');
    });
}

// تحسين تجربة الفلترة
document.addEventListener('DOMContentLoaded', function() {
    // حفظ الفلاتر في localStorage
    const statusSelect = document.querySelector('select[name="status"]');
    const paymentStatusSelect = document.querySelector('select[name="payment_status"]');
    const searchInput = document.querySelector('input[name="search"]');
    
    // استعادة الفلاتر المحفوظة
    if (localStorage.getItem('admin_orders_status')) {
        statusSelect.value = localStorage.getItem('admin_orders_status');
    }
    if (localStorage.getItem('admin_orders_payment_status')) {
        paymentStatusSelect.value = localStorage.getItem('admin_orders_payment_status');
    }
    if (localStorage.getItem('admin_orders_search')) {
        searchInput.value = localStorage.getItem('admin_orders_search');
    }
    
    // حفظ الفلاتر عند التغيير
    statusSelect.addEventListener('change', function() {
        localStorage.setItem('admin_orders_status', this.value);
    });
    
    paymentStatusSelect.addEventListener('change', function() {
        localStorage.setItem('admin_orders_payment_status', this.value);
    });
    
    searchInput.addEventListener('input', function() {
        localStorage.setItem('admin_orders_search', this.value);
    });
    
    // مسح الفلاتر المحفوظة عند الضغط على زر المسح
    document.querySelector('a[href="{{ route("admin.orders") }}"]').addEventListener('click', function() {
        localStorage.removeItem('admin_orders_status');
        localStorage.removeItem('admin_orders_payment_status');
        localStorage.removeItem('admin_orders_search');
    });
});

// دالة إظهار الإشعارات
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