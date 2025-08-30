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
                        <button class="btn btn-admin btn-outline-secondary">
                            <i class="fas fa-download me-2"></i>
                            تصدير البيانات
                        </button>
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
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>في الانتظار</option>
                                <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>مؤكد</option>
                                <option value="preparing" {{ request('status') == 'preparing' ? 'selected' : '' }}>قيد التحضير</option>
                                <option value="assigned" {{ request('status') == 'assigned' ? 'selected' : '' }}>تم التعيين</option>
                                <option value="picked_up" {{ request('status') == 'picked_up' ? 'selected' : '' }}>تم الاستلام</option>
                                <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>تم التوصيل</option>
                                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>ملغي</option>
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">حالة الدفع</label>
                            <select class="form-select" name="payment_status">
                                <option value="">جميع حالات الدفع</option>
                                <option value="pending" {{ request('payment_status') == 'pending' ? 'selected' : '' }}>في الانتظار</option>
                                <option value="paid" {{ request('payment_status') == 'paid' ? 'selected' : '' }}>مدفوع</option>
                                <option value="failed" {{ request('payment_status') == 'failed' ? 'selected' : '' }}>فشل</option>
                            </select>
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
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>رقم الطلب</th>
                                    <th>العميل</th>
                                    <th>المنتج</th>
                                    <th>المورد</th>
                                    <th>المندوب</th>
                                    <th>السعر</th>
                                    <th>الحالة</th>
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
                                        <div class="fw-bold">{{ $order->supplier->company_name ?? 'غير محدد' }}</div>
                                    </td>
                                    <td>
                                        <div class="fw-bold">{{ $order->deliveryMan->user->name ?? 'غير محدد' }}</div>
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
                                    <td>
                                        <div class="btn-group" role="group">
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
@endsection 