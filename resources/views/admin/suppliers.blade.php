@extends('layouts.admin')

@section('title', 'إدارة الموردين - مياه مكة')
@section('page-title', 'إدارة الموردين')

@section('content')
<div class="fade-in">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="stat-card">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h4 class="mb-2">إدارة الموردين</h4>
                        <p class="text-muted mb-0">عرض وإدارة جميع الموردين في النظام</p>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.suppliers.create') }}" class="btn btn-admin btn-primary">
                            <i class="fas fa-plus me-2"></i>
                            إضافة مورد جديد
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
                <form method="GET" action="{{ route('admin.suppliers') }}">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">البحث</label>
                            <input type="text" class="form-control" name="search" 
                                   placeholder="البحث باسم الشركة أو الشخص المسؤول..." 
                                   value="{{ request('search') }}">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">الحالة</label>
                            <select class="form-select" name="status">
                                <option value="">جميع الحالات</option>
                                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>نشط</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>في الانتظار</option>
                                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>غير نشط</option>
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">&nbsp;</label>
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-admin btn-primary flex-grow-1">
                                    <i class="fas fa-search me-2"></i>
                                    بحث
                                </button>
                                <a href="{{ route('admin.suppliers') }}" class="btn btn-admin btn-outline-secondary">
                                    <i class="fas fa-times"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Suppliers Table -->
    <div class="row">
        <div class="col-12">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="mb-0">
                        <i class="fas fa-store text-success me-2"></i>
                        قائمة الموردين ({{ $suppliers->total() }})
                    </h5>
                </div>

                @if($suppliers->count() > 0)
                    <div class="admin-table">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>المورد</th>
                                    <th>الشركة</th>
                                    <th>معلومات الاتصال</th>
                                    <th>التقييم</th>
                                    <th>الحالة</th>
                                    <th>تاريخ التسجيل</th>
                                    <th>الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($suppliers as $supplier)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="user-avatar me-3">
                                                {{ substr($supplier->user->name ?? 'م', 0, 1) }}
                                            </div>
                                            <div>
                                                <div class="fw-bold">{{ $supplier->user->name ?? 'غير محدد' }}</div>
                                                <small class="text-muted">ID: {{ $supplier->id }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="fw-bold">{{ $supplier->company_name ?? 'غير محدد' }}</div>
                                        <small class="text-muted">{{ $supplier->city ?? '' }}</small>
                                    </td>
                                    <td>
                                        <div class="fw-bold">{{ $supplier->phone ?? 'غير محدد' }}</div>
                                        <small class="text-muted">{{ $supplier->email ?? '' }}</small>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="text-warning me-2">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <i class="fas fa-star{{ $i <= ($supplier->rating ?? 0) ? '' : '-o' }}"></i>
                                                @endfor
                                            </div>
                                            <span class="fw-bold">{{ number_format($supplier->rating ?? 0, 1) }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        @if($supplier->status === 'active')
                                            <span class="badge-admin bg-success">
                                                <i class="fas fa-check me-1"></i>
                                                نشط
                                            </span>
                                        @elseif($supplier->status === 'pending')
                                            <span class="badge-admin bg-warning">
                                                <i class="fas fa-clock me-1"></i>
                                                في الانتظار
                                            </span>
                                        @else
                                            <span class="badge-admin bg-danger">
                                                <i class="fas fa-times me-1"></i>
                                                غير نشط
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="fw-bold">{{ $supplier->created_at->format('Y-m-d') }}</div>
                                        <small class="text-muted">{{ $supplier->created_at->format('H:i') }}</small>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.suppliers.show', $supplier->id) }}" class="btn btn-sm btn-outline-primary" title="عرض">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.suppliers.edit', $supplier->id) }}" class="btn btn-sm btn-outline-warning" title="تعديل">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.suppliers.delete', $supplier->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('هل أنت متأكد من حذف هذا المورد؟')">
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
                        {{ $suppliers->links() }}
                    </div>
                @else
                    <div class="text-center py-5">
                        <div class="stat-icon bg-light text-muted mx-auto mb-3" style="width: 80px; height: 80px; font-size: 2rem;">
                            <i class="fas fa-store"></i>
                        </div>
                        <h6 class="text-muted">لا توجد موردين</h6>
                        <p class="text-muted mb-0">لم يتم العثور على موردين في النظام</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection 