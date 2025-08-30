@extends('layouts.admin')

@section('title', 'إدارة مندوبي التوصيل - مياه مكة')
@section('page-title', 'إدارة مندوبي التوصيل')

@section('content')
<div class="fade-in">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="stat-card">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h4 class="mb-2">إدارة مندوبي التوصيل</h4>
                        <p class="text-muted mb-0">عرض وإدارة جميع مندوبي التوصيل في النظام</p>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.delivery-men.create') }}" class="btn btn-admin btn-primary">
                            <i class="fas fa-plus me-2"></i>
                            إضافة مندوب جديد
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
                <form method="GET" action="{{ route('admin.delivery-men') }}">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">البحث</label>
                            <input type="text" class="form-control" name="search" 
                                   placeholder="البحث بنوع المركبة أو رقم المركبة..." 
                                   value="{{ request('search') }}">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">الحالة</label>
                            <select class="form-select" name="status">
                                <option value="">جميع الحالات</option>
                                <option value="available" {{ request('status') == 'available' ? 'selected' : '' }}>متاح</option>
                                <option value="busy" {{ request('status') == 'busy' ? 'selected' : '' }}>مشغول</option>
                                <option value="offline" {{ request('status') == 'offline' ? 'selected' : '' }}>غير متاح</option>
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">&nbsp;</label>
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-admin btn-primary flex-grow-1">
                                    <i class="fas fa-search me-2"></i>
                                    بحث
                                </button>
                                <a href="{{ route('admin.delivery-men') }}" class="btn btn-admin btn-outline-secondary">
                                    <i class="fas fa-times"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delivery Men Table -->
    <div class="row">
        <div class="col-12">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="mb-0">
                        <i class="fas fa-truck text-warning me-2"></i>
                        قائمة مندوبي التوصيل ({{ $deliveryMen->total() }})
                    </h5>
                </div>

                @if($deliveryMen->count() > 0)
                    <div class="admin-table">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>المندوب</th>
                                    <th>معلومات المركبة</th>
                                    <th>معلومات الاتصال</th>
                                    <th>التقييم</th>
                                    <th>الحالة</th>
                                    <th>الإيرادات</th>
                                    <th>الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($deliveryMen as $deliveryMan)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="user-avatar me-3">
                                                {{ substr($deliveryMan->user->name ?? 'م', 0, 1) }}
                                            </div>
                                            <div>
                                                <div class="fw-bold">{{ $deliveryMan->user->name ?? 'غير محدد' }}</div>
                                                <small class="text-muted">ID: {{ $deliveryMan->id }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="fw-bold">{{ $deliveryMan->vehicle_type ?? 'غير محدد' }}</div>
                                        <small class="text-muted">{{ $deliveryMan->vehicle_number ?? '' }}</small>
                                    </td>
                                    <td>
                                        <div class="fw-bold">{{ $deliveryMan->user->phone ?? 'غير محدد' }}</div>
                                        <small class="text-muted">{{ $deliveryMan->emergency_phone ?? '' }}</small>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="text-warning me-2">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <i class="fas fa-star{{ $i <= ($deliveryMan->rating ?? 0) ? '' : '-o' }}"></i>
                                                @endfor
                                            </div>
                                            <span class="fw-bold">{{ number_format($deliveryMan->rating ?? 0, 1) }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        @if($deliveryMan->status === 'available')
                                            <span class="badge-admin bg-success">
                                                <i class="fas fa-check me-1"></i>
                                                متاح
                                            </span>
                                        @elseif($deliveryMan->status === 'busy')
                                            <span class="badge-admin bg-warning">
                                                <i class="fas fa-clock me-1"></i>
                                                مشغول
                                            </span>
                                        @else
                                            <span class="badge-admin bg-danger">
                                                <i class="fas fa-times me-1"></i>
                                                غير متاح
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="fw-bold text-success">{{ number_format($deliveryMan->total_earnings ?? 0, 2) }} ريال</div>
                                        <small class="text-muted">{{ $deliveryMan->total_deliveries ?? 0 }} توصيل</small>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.delivery-men.show', $deliveryMan->id) }}" class="btn btn-sm btn-outline-primary" title="عرض">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.delivery-men.edit', $deliveryMan->id) }}" class="btn btn-sm btn-outline-warning" title="تعديل">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.delivery-men.delete', $deliveryMan->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('هل أنت متأكد من حذف هذا مندوب التوصيل؟')">
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
                        {{ $deliveryMen->links() }}
                    </div>
                @else
                    <div class="text-center py-5">
                        <div class="stat-icon bg-light text-muted mx-auto mb-3" style="width: 80px; height: 80px; font-size: 2rem;">
                            <i class="fas fa-truck"></i>
                        </div>
                        <h6 class="text-muted">لا توجد مندوبي توصيل</h6>
                        <p class="text-muted mb-0">لم يتم العثور على مندوبي توصيل في النظام</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection 