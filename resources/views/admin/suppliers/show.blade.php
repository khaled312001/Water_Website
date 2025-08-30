@extends('layouts.admin')

@section('title', 'تفاصيل المورد - سلسبيل مكة')
@section('page-title', 'تفاصيل المورد')

@section('content')
<div class="fade-in">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="mb-0">تفاصيل المورد: {{ $supplier->company_name }}</h4>
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.suppliers.edit', $supplier->id) }}" class="btn btn-admin btn-warning">
                            <i class="fas fa-edit me-2"></i>
                            تعديل
                        </a>
                        <a href="{{ route('admin.suppliers') }}" class="btn btn-admin btn-outline-secondary">
                            <i class="fas fa-arrow-right me-2"></i>
                            العودة للقائمة
                        </a>
                    </div>
                </div>

                <!-- Supplier Information -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="card border-0 bg-light">
                            <div class="card-body">
                                <h6 class="card-title text-primary mb-3">
                                    <i class="fas fa-store me-2"></i>
                                    معلومات الشركة
                                </h6>
                                
                                <div class="mb-3">
                                    <label class="form-label fw-bold">اسم الشركة:</label>
                                    <p class="mb-0">{{ $supplier->company_name }}</p>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">الرخصة التجارية:</label>
                                    <p class="mb-0">{{ $supplier->commercial_license }}</p>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">الرقم الضريبي:</label>
                                    <p class="mb-0">{{ $supplier->tax_number }}</p>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">الحالة:</label>
                                    @if($supplier->status === 'active')
                                        <span class="badge bg-success">نشط</span>
                                    @elseif($supplier->status === 'pending')
                                        <span class="badge bg-warning">في الانتظار</span>
                                    @else
                                        <span class="badge bg-danger">غير نشط</span>
                                    @endif
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">التقييم:</label>
                                    <div class="d-flex align-items-center">
                                        <div class="text-warning me-2">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="fas fa-star{{ $i <= ($supplier->rating ?? 0) ? '' : '-o' }}"></i>
                                            @endfor
                                        </div>
                                        <span class="fw-bold">{{ number_format($supplier->rating ?? 0, 1) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card border-0 bg-light">
                            <div class="card-body">
                                <h6 class="card-title text-primary mb-3">
                                    <i class="fas fa-user me-2"></i>
                                    معلومات الاتصال
                                </h6>
                                
                                <div class="mb-3">
                                    <label class="form-label fw-bold">الشخص المسؤول:</label>
                                    <p class="mb-0">{{ $supplier->contact_person }}</p>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">رقم الهاتف:</label>
                                    <p class="mb-0">{{ $supplier->phone }}</p>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">البريد الإلكتروني:</label>
                                    <p class="mb-0">{{ $supplier->email }}</p>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">المدينة:</label>
                                    <p class="mb-0">{{ $supplier->city }}</p>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">العنوان:</label>
                                    <p class="mb-0">{{ $supplier->address }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @if($supplier->description)
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card border-0 bg-light">
                            <div class="card-body">
                                <h6 class="card-title text-primary mb-3">
                                    <i class="fas fa-info-circle me-2"></i>
                                    الوصف
                                </h6>
                                <p class="mb-0">{{ $supplier->description }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Supplier Statistics -->
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
                                            <h4 class="text-primary">{{ $supplier->products->count() }}</h4>
                                            <p class="text-muted mb-0">المنتجات</p>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="text-center">
                                            <h4 class="text-success">{{ $supplier->orders->count() }}</h4>
                                            <p class="text-muted mb-0">الطلبات</p>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="text-center">
                                            <h4 class="text-info">{{ $supplier->orders->where('status', 'delivered')->count() }}</h4>
                                            <p class="text-muted mb-0">الطلبات المكتملة</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Products -->
                @if($supplier->products->count() > 0)
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card border-0 bg-light">
                            <div class="card-body">
                                <h6 class="card-title text-primary mb-3">
                                    <i class="fas fa-box me-2"></i>
                                    المنتجات
                                </h6>
                                
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>اسم المنتج</th>
                                                <th>السعر</th>
                                                <th>الحالة</th>
                                                <th>تاريخ الإضافة</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($supplier->products->take(5) as $product)
                                            <tr>
                                                <td>{{ $product->name }}</td>
                                                <td>{{ $product->price_per_box }} ريال</td>
                                                <td>
                                                    @if($product->is_active)
                                                        <span class="badge bg-success">متاح</span>
                                                    @else
                                                        <span class="badge bg-danger">غير متاح</span>
                                                    @endif
                                                </td>
                                                <td>{{ $product->created_at->format('Y-m-d') }}</td>
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

                <!-- Recent Orders -->
                @if($supplier->orders->count() > 0)
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
                                            @foreach($supplier->orders->take(5) as $order)
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