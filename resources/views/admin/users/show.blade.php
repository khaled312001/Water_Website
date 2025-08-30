@extends('layouts.admin')

@section('title', 'تفاصيل المستخدم - سلسبيل مكة')
@section('page-title', 'تفاصيل المستخدم')

@section('content')
<div class="fade-in">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="mb-0">تفاصيل المستخدم: {{ $user->name }}</h4>
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-admin btn-warning">
                            <i class="fas fa-edit me-2"></i>
                            تعديل
                        </a>
                        <a href="{{ route('admin.users') }}" class="btn btn-admin btn-outline-secondary">
                            <i class="fas fa-arrow-right me-2"></i>
                            العودة للقائمة
                        </a>
                    </div>
                </div>

                <!-- User Information -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="card border-0 bg-light">
                            <div class="card-body">
                                <h6 class="card-title text-primary mb-3">
                                    <i class="fas fa-user me-2"></i>
                                    المعلومات الأساسية
                                </h6>
                                
                                <div class="mb-3">
                                    <label class="form-label fw-bold">الاسم الكامل:</label>
                                    <p class="mb-0">{{ $user->name }}</p>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">البريد الإلكتروني:</label>
                                    <p class="mb-0">{{ $user->email }}</p>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">رقم الهاتف:</label>
                                    <p class="mb-0">{{ $user->phone ?? 'غير محدد' }}</p>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">الدور:</label>
                                    @php
                                        $roleNames = [
                                            'admin' => 'مدير',
                                            'customer' => 'عميل',
                                            'supplier' => 'مورد',
                                            'delivery' => 'مندوب توصيل'
                                        ];
                                        $roleName = $roleNames[$user->role] ?? $user->role;
                                    @endphp
                                    <p class="mb-0">{{ $roleName }}</p>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">الحالة:</label>
                                    @if($user->is_active)
                                        <span class="badge bg-success">نشط</span>
                                    @else
                                        <span class="badge bg-danger">غير نشط</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card border-0 bg-light">
                            <div class="card-body">
                                <h6 class="card-title text-primary mb-3">
                                    <i class="fas fa-info-circle me-2"></i>
                                    معلومات إضافية
                                </h6>
                                
                                <div class="mb-3">
                                    <label class="form-label fw-bold">تاريخ التسجيل:</label>
                                    <p class="mb-0">{{ $user->created_at->format('Y-m-d H:i') }}</p>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">آخر تحديث:</label>
                                    <p class="mb-0">{{ $user->updated_at->format('Y-m-d H:i') }}</p>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">تأكيد البريد الإلكتروني:</label>
                                    @if($user->email_verified_at)
                                        <span class="badge bg-success">مؤكد</span>
                                    @else
                                        <span class="badge bg-warning">غير مؤكد</span>
                                    @endif
                                </div>

                                @if($user->supplier)
                                <div class="mb-3">
                                    <label class="form-label fw-bold">معلومات المورد:</label>
                                    <p class="mb-0">{{ $user->supplier->company_name ?? 'غير محدد' }}</p>
                                </div>
                                @endif

                                @if($user->deliveryMan)
                                <div class="mb-3">
                                    <label class="form-label fw-bold">معلومات مندوب التوصيل:</label>
                                    <p class="mb-0">{{ $user->deliveryMan->vehicle_type ?? 'غير محدد' }}</p>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- User Statistics -->
                @if($user->orders->count() > 0 || $user->reviews->count() > 0)
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card border-0 bg-light">
                            <div class="card-body">
                                <h6 class="card-title text-primary mb-3">
                                    <i class="fas fa-chart-bar me-2"></i>
                                    الإحصائيات
                                </h6>
                                
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="text-center">
                                            <h4 class="text-primary">{{ $user->orders->count() }}</h4>
                                            <p class="text-muted mb-0">الطلبات</p>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="text-center">
                                            <h4 class="text-success">{{ $user->reviews->count() }}</h4>
                                            <p class="text-muted mb-0">التقييمات</p>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="text-center">
                                            <h4 class="text-info">{{ $user->orders->where('status', 'delivered')->count() }}</h4>
                                            <p class="text-muted mb-0">الطلبات المكتملة</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Recent Orders -->
                @if($user->orders->count() > 0)
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
                                                <th>المنتج</th>
                                                <th>المبلغ</th>
                                                <th>الحالة</th>
                                                <th>التاريخ</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($user->orders->take(5) as $order)
                                            <tr>
                                                <td>{{ $order->order_number ?? $order->id }}</td>
                                                <td>{{ $order->product->name ?? 'غير محدد' }}</td>
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