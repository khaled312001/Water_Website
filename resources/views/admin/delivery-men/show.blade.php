@extends('layouts.admin')

@section('title', 'تفاصيل مندوب التوصيل - سلسبيل مكة')
@section('page-title', 'تفاصيل مندوب التوصيل')

@section('content')
<div class="fade-in">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="mb-0">تفاصيل مندوب التوصيل: {{ $deliveryMan->user->name ?? 'غير محدد' }}</h4>
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.delivery-men.edit', $deliveryMan->id) }}" class="btn btn-admin btn-warning">
                            <i class="fas fa-edit me-2"></i>
                            تعديل
                        </a>
                        <a href="{{ route('admin.delivery-men') }}" class="btn btn-admin btn-outline-secondary">
                            <i class="fas fa-arrow-right me-2"></i>
                            العودة للقائمة
                        </a>
                    </div>
                </div>

                <!-- Delivery Man Information -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="card border-0 bg-light">
                            <div class="card-body">
                                <h6 class="card-title text-primary mb-3">
                                    <i class="fas fa-user me-2"></i>
                                    معلومات مندوب التوصيل
                                </h6>
                                
                                <div class="mb-3">
                                    <label class="form-label fw-bold">الاسم:</label>
                                    <p class="mb-0">{{ $deliveryMan->user->name ?? 'غير محدد' }}</p>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">البريد الإلكتروني:</label>
                                    <p class="mb-0">{{ $deliveryMan->user->email ?? 'غير محدد' }}</p>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">رقم الهاتف:</label>
                                    <p class="mb-0">{{ $deliveryMan->user->phone ?? 'غير محدد' }}</p>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">الرقم الوطني:</label>
                                    <p class="mb-0">{{ $deliveryMan->national_id }}</p>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">الحالة:</label>
                                    @if($deliveryMan->status === 'available')
                                        <span class="badge bg-success">متاح</span>
                                    @elseif($deliveryMan->status === 'busy')
                                        <span class="badge bg-warning">مشغول</span>
                                    @else
                                        <span class="badge bg-danger">غير متاح</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card border-0 bg-light">
                            <div class="card-body">
                                <h6 class="card-title text-primary mb-3">
                                    <i class="fas fa-truck me-2"></i>
                                    معلومات المركبة
                                </h6>
                                
                                <div class="mb-3">
                                    <label class="form-label fw-bold">نوع المركبة:</label>
                                    <p class="mb-0">{{ $deliveryMan->vehicle_type }}</p>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">رقم المركبة:</label>
                                    <p class="mb-0">{{ $deliveryMan->vehicle_number }}</p>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">رقم الرخصة:</label>
                                    <p class="mb-0">{{ $deliveryMan->license_number }}</p>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">المدينة:</label>
                                    <p class="mb-0">{{ $deliveryMan->city }}</p>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">العنوان:</label>
                                    <p class="mb-0">{{ $deliveryMan->address }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Emergency Contact Information -->
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card border-0 bg-light">
                            <div class="card-body">
                                <h6 class="card-title text-primary mb-3">
                                    <i class="fas fa-phone me-2"></i>
                                    معلومات الطوارئ
                                </h6>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">جهة اتصال الطوارئ:</label>
                                            <p class="mb-0">{{ $deliveryMan->emergency_contact }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">رقم هاتف الطوارئ:</label>
                                            <p class="mb-0">{{ $deliveryMan->emergency_phone }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Delivery Statistics -->
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card border-0 bg-light">
                            <div class="card-body">
                                <h6 class="card-title text-primary mb-3">
                                    <i class="fas fa-chart-bar me-2"></i>
                                    إحصائيات التوصيل
                                </h6>
                                
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="text-center">
                                            <h4 class="text-primary">{{ $deliveryMan->orders->count() }}</h4>
                                            <p class="text-muted mb-0">إجمالي الطلبات</p>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="text-center">
                                            <h4 class="text-success">{{ $deliveryMan->orders->where('status', 'delivered')->count() }}</h4>
                                            <p class="text-muted mb-0">الطلبات المكتملة</p>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="text-center">
                                            <h4 class="text-info">{{ $deliveryMan->orders->where('status', 'picked_up')->count() }}</h4>
                                            <p class="text-muted mb-0">قيد التوصيل</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Orders -->
                @if($deliveryMan->orders->count() > 0)
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card border-0 bg-light">
                            <div class="card-body">
                                <h6 class="card-title text-primary mb-3">
                                    <i class="fas fa-shopping-cart me-2"></i>
                                    آخر الطلبات
                                </h6>
                                
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>رقم الطلب</th>
                                                <th>العميل</th>
                                                <th>المبلغ</th>
                                                <th>الحالة</th>
                                                <th>التاريخ</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($deliveryMan->orders->take(5) as $order)
                                            <tr>
                                                <td>{{ $order->order_number ?? $order->id }}</td>
                                                <td>{{ $order->customer->name ?? 'غير محدد' }}</td>
                                                <td>{{ $order->total_amount ?? 0 }} ريال</td>
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
                                                        $statusColor = $statusColors[$order->status] ?? 'secondary';
                                                    @endphp
                                                    <span class="badge bg-{{ $statusColor }}">{{ $order->status }}</span>
                                                </td>
                                                <td>{{ $order->created_at->format('Y-m-d') }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection 