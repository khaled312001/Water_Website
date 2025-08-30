@extends('layouts.app')

@section('title', 'طلباتي - سلسبيل مكة')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-lg" data-aos="fade-up">
                <div class="card-header bg-primary text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">
                            <i class="fas fa-shopping-bag me-2"></i>
                            طلباتي
                        </h4>
                        <a href="{{ route('orders.create') }}" class="btn btn-light btn-sm">
                            <i class="fas fa-plus me-1"></i>
                            طلب جديد
                        </a>
                    </div>
                </div>
                <div class="card-body p-4">
                    @if($orders->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>رقم الطلب</th>
                                        <th>المنتج</th>
                                        <th>الكمية</th>
                                        <th>السعر الإجمالي</th>
                                        <th>الحالة</th>
                                        <th>تاريخ الطلب</th>
                                        <th>الإجراءات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orders as $order)
                                        <tr>
                                            <td>
                                                <strong>#{{ $order->id }}</strong>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    @if($order->product->image)
                                                        <img src="{{ asset('storage/' . $order->product->image) }}" 
                                                             alt="{{ $order->product->name }}" 
                                                             class="rounded me-2" 
                                                             style="width: 40px; height: 40px; object-fit: cover;">
                                                    @endif
                                                    <div>
                                                        <div class="fw-bold">{{ $order->product->name }}</div>
                                                        <small class="text-muted">{{ $order->supplier->company_name }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{ $order->quantity }}</td>
                                            <td>
                                                <span class="fw-bold text-primary">{{ number_format($order->total_amount, 2) }} ريال</span>
                                            </td>
                                            <td>
                                                @switch($order->status)
                                                    @case('pending_payment')
                                                        <span class="badge bg-danger">في انتظار الدفع</span>
                                                        @break
                                                    @case('pending')
                                                        <span class="badge bg-warning">قيد الانتظار</span>
                                                        @break
                                                    @case('confirmed')
                                                        <span class="badge bg-info">مؤكد</span>
                                                        @break
                                                    @case('processing')
                                                        <span class="badge bg-primary">قيد المعالجة</span>
                                                        @break
                                                    @case('shipped')
                                                        <span class="badge bg-secondary">تم الشحن</span>
                                                        @break
                                                    @case('delivered')
                                                        <span class="badge bg-success">تم التوصيل</span>
                                                        @break
                                                    @case('cancelled')
                                                        <span class="badge bg-danger">ملغي</span>
                                                        @break
                                                    @default
                                                        <span class="badge bg-secondary">{{ $order->status }}</span>
                                                @endswitch
                                            </td>
                                            <td>{{ $order->created_at->format('Y-m-d H:i') }}</td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <a href="{{ route('orders.show', $order->id) }}" 
                                                       class="btn btn-outline-primary" title="عرض التفاصيل">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    @if($order->status === 'pending_payment')
                                                        <a href="{{ route('payments.new-order', $order->id) }}" 
                                                           class="btn btn-outline-danger" title="إتمام الدفع">
                                                            <i class="fas fa-credit-card"></i>
                                                        </a>
                                                    @else
                                                        <a href="{{ route('orders.track', $order->id) }}" 
                                                           class="btn btn-outline-info" title="تتبع الطلب">
                                                            <i class="fas fa-truck"></i>
                                                        </a>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="d-flex justify-content-center mt-4">
                            {{ $orders->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-shopping-bag text-muted" style="font-size: 4rem;"></i>
                            <h4 class="mt-3 text-muted">لا توجد طلبات</h4>
                            <p class="text-muted">لم تقم بإنشاء أي طلبات بعد</p>
                            <a href="{{ route('orders.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>
                                إنشاء طلب جديد
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 