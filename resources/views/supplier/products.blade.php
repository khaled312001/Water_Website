@extends('layouts.admin')

@section('title', 'إدارة المنتجات - سلسبيل مكة')
@section('page-title', 'إدارة المنتجات')

@section('content')
<div class="fade-in">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="mb-1">إدارة المنتجات</h4>
                        <p class="text-muted mb-0">إدارة منتجاتك وعرض إحصائياتها</p>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.products.create') }}" class="btn btn-admin btn-primary">
                            <i class="fas fa-plus me-2"></i>
                            إضافة منتج جديد
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
                <form method="GET" action="{{ route('supplier.products') }}">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">البحث</label>
                            <input type="text" class="form-control" name="search" 
                                   placeholder="البحث باسم المنتج أو الوصف..." 
                                   value="{{ request('search') }}">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">الحالة</label>
                            <select class="form-select" name="status">
                                <option value="">جميع الحالات</option>
                                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>متاح</option>
                                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>غير متاح</option>
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">&nbsp;</label>
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-admin btn-primary flex-grow-1">
                                    <i class="fas fa-search me-2"></i>
                                    بحث
                                </button>
                                <a href="{{ route('supplier.products') }}" class="btn btn-admin btn-outline-secondary">
                                    <i class="fas fa-times"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Products Table -->
    <div class="row">
        <div class="col-12">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="mb-0">
                        <i class="fas fa-box text-warning me-2"></i>
                        قائمة المنتجات ({{ $products->total() }})
                    </h5>
                </div>

                @if($products->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>المنتج</th>
                                <th>السعر</th>
                                <th>التقييم</th>
                                <th>عدد الطلبات</th>
                                <th>الحالة</th>
                                <th>تاريخ الإضافة</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $product)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="product-avatar me-3">
                                            <i class="fas fa-box"></i>
                                        </div>
                                        <div>
                                            <div class="fw-bold">{{ $product->name }}</div>
                                            <small class="text-muted">{{ Str::limit($product->description, 50) }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="fw-bold">{{ $product->price_per_box }} ريال</div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="text-warning me-2">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="fas fa-star{{ $i <= ($product->reviews->avg('rating') ?? 0) ? '' : '-o' }}"></i>
                                            @endfor
                                        </div>
                                        <span class="fw-bold">{{ number_format($product->reviews->avg('rating') ?? 0, 1) }}</span>
                                        <span class="text-muted ms-2">({{ $product->reviews->count() }})</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="fw-bold">{{ $product->orders->count() }}</div>
                                </td>
                                <td>
                                    @if($product->is_active)
                                        <span class="badge-admin bg-success">
                                            <i class="fas fa-check me-1"></i>
                                            متاح
                                        </span>
                                    @else
                                        <span class="badge-admin bg-danger">
                                            <i class="fas fa-times me-1"></i>
                                            غير متاح
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <div class="fw-bold">{{ $product->created_at->format('Y-m-d') }}</div>
                                    <small class="text-muted">{{ $product->created_at->format('H:i') }}</small>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.products.show', $product->id) }}" class="btn btn-sm btn-outline-primary" title="عرض">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-sm btn-outline-warning" title="تعديل">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.products.delete', $product->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('هل أنت متأكد من حذف هذا المنتج؟')">
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
                    {{ $products->links() }}
                </div>
                @else
                <div class="text-center py-5">
                    <div class="stat-icon bg-light text-muted mx-auto mb-3" style="width: 80px; height: 80px; font-size: 2rem;">
                        <i class="fas fa-box"></i>
                    </div>
                    <h6 class="text-muted">لا توجد منتجات</h6>
                    <p class="text-muted mb-0">لم يتم العثور على منتجات في النظام</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
.product-avatar {
    width: 40px;
    height: 40px;
    background: #f8f9fa;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #6c757d;
}
</style>
@endsection 