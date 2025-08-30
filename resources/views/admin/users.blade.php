@extends('layouts.admin')

@section('title', 'إدارة المستخدمين - سلسبيل مكة')
@section('page-title', 'إدارة المستخدمين')

@section('content')
<div class="fade-in">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="stat-card">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h4 class="mb-2">إدارة المستخدمين</h4>
                        <p class="text-muted mb-0">عرض وإدارة جميع المستخدمين في النظام</p>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.users.create') }}" class="btn btn-admin btn-primary">
                            <i class="fas fa-plus me-2"></i>
                            إضافة مستخدم جديد
                        </a>
                        <a href="{{ route('admin.export.users') }}" class="btn btn-admin btn-outline-success">
                            <i class="fas fa-file-export me-2"></i>
                            تصدير البيانات
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="stat-card">
                <form method="GET" action="{{ route('admin.users') }}">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label class="form-label">البحث</label>
                            <input type="text" class="form-control" name="search" 
                                   placeholder="البحث بالاسم أو البريد الإلكتروني..." 
                                   value="{{ request('search') }}">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">الدور</label>
                            <select class="form-select" name="role">
                                <option value="">جميع الأدوار</option>
                                <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>مدير</option>
                                <option value="customer" {{ request('role') == 'customer' ? 'selected' : '' }}>عميل</option>
                                <option value="supplier" {{ request('role') == 'supplier' ? 'selected' : '' }}>مورد</option>
                                <option value="delivery" {{ request('role') == 'delivery' ? 'selected' : '' }}>مندوب توصيل</option>
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">الحالة</label>
                            <select class="form-select" name="status">
                                <option value="">جميع الحالات</option>
                                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>نشط</option>
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
                                <a href="{{ route('admin.users') }}" class="btn btn-admin btn-outline-secondary">
                                    <i class="fas fa-times"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Users Table -->
    <div class="row">
        <div class="col-12">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="mb-0">
                        <i class="fas fa-users text-primary me-2"></i>
                        قائمة المستخدمين ({{ $users->total() }})
                    </h5>
                    <div class="d-flex gap-2">
                        <span class="text-muted">عرض {{ $users->firstItem() ?? 0 }} إلى {{ $users->lastItem() ?? 0 }} من {{ $users->total() }} مستخدم</span>
                    </div>
                </div>

                @if($users->count() > 0)
                    <div class="admin-table">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>المستخدم</th>
                                    <th>البريد الإلكتروني</th>
                                    <th>الهاتف</th>
                                    <th>الدور</th>
                                    <th>الحالة</th>
                                    <th>تاريخ التسجيل</th>
                                    <th>الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="user-avatar me-3">
                                                {{ substr($user->name, 0, 1) }}
                                            </div>
                                            <div>
                                                <div class="fw-bold">{{ $user->name }}</div>
                                                <small class="text-muted">ID: {{ $user->id }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="fw-bold">{{ $user->email }}</div>
                                        @if($user->email_verified_at)
                                            <small class="text-success">
                                                <i class="fas fa-check-circle me-1"></i>
                                                مؤكد
                                            </small>
                                        @else
                                            <small class="text-warning">
                                                <i class="fas fa-clock me-1"></i>
                                                في الانتظار
                                            </small>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="fw-bold">{{ $user->phone ?? 'غير محدد' }}</div>
                                    </td>
                                    <td>
                                        @php
                                            $roleColors = [
                                                'admin' => 'danger',
                                                'customer' => 'primary',
                                                'supplier' => 'success',
                                                'delivery' => 'warning'
                                            ];
                                            $roleNames = [
                                                'admin' => 'مدير',
                                                'customer' => 'عميل',
                                                'supplier' => 'مورد',
                                                'delivery' => 'مندوب توصيل'
                                            ];
                                            $roleColor = $roleColors[$user->role] ?? 'secondary';
                                            $roleName = $roleNames[$user->role] ?? $user->role;
                                        @endphp
                                        <span class="badge-admin bg-{{ $roleColor }}">
                                            {{ $roleName }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($user->is_active)
                                            <span class="badge-admin bg-success">
                                                <i class="fas fa-check me-1"></i>
                                                نشط
                                            </span>
                                        @else
                                            <span class="badge-admin bg-danger">
                                                <i class="fas fa-times me-1"></i>
                                                غير نشط
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="fw-bold">{{ $user->created_at->format('Y-m-d') }}</div>
                                        <small class="text-muted">{{ $user->created_at->format('H:i') }}</small>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-sm btn-outline-primary" title="عرض">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-outline-warning" title="تعديل">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.users.delete', $user->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('هل أنت متأكد من حذف هذا المستخدم؟')">
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
                        {{ $users->links() }}
                    </div>
                @else
                    <div class="text-center py-5">
                        <div class="stat-icon bg-light text-muted mx-auto mb-3" style="width: 80px; height: 80px; font-size: 2rem;">
                            <i class="fas fa-users"></i>
                        </div>
                        <h6 class="text-muted">لا توجد مستخدمين</h6>
                        <p class="text-muted mb-0">لم يتم العثور على مستخدمين مطابقين للبحث</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection 