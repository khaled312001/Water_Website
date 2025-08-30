@extends('layouts.admin')

@section('title', 'إدارة التقييمات - مياه مكة')
@section('page-title', 'إدارة التقييمات')

@section('content')
<div class="fade-in">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="stat-card">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h4 class="mb-2">إدارة التقييمات</h4>
                        <p class="text-muted mb-0">عرض وإدارة جميع التقييمات في النظام</p>
                    </div>
                    <div class="d-flex gap-2">
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
                <form method="GET" action="{{ route('admin.reviews') }}">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">البحث</label>
                            <input type="text" class="form-control" name="search" 
                                   placeholder="البحث في التعليقات..." 
                                   value="{{ request('search') }}">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">التقييم</label>
                            <select class="form-select" name="rating">
                                <option value="">جميع التقييمات</option>
                                <option value="5" {{ request('rating') == '5' ? 'selected' : '' }}>5 نجوم</option>
                                <option value="4" {{ request('rating') == '4' ? 'selected' : '' }}>4 نجوم</option>
                                <option value="3" {{ request('rating') == '3' ? 'selected' : '' }}>3 نجوم</option>
                                <option value="2" {{ request('rating') == '2' ? 'selected' : '' }}>2 نجوم</option>
                                <option value="1" {{ request('rating') == '1' ? 'selected' : '' }}>1 نجمة</option>
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">&nbsp;</label>
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-admin btn-primary flex-grow-1">
                                    <i class="fas fa-search me-2"></i>
                                    بحث
                                </button>
                                <a href="{{ route('admin.reviews') }}" class="btn btn-admin btn-outline-secondary">
                                    <i class="fas fa-times"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Reviews Table -->
    <div class="row">
        <div class="col-12">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="mb-0">
                        <i class="fas fa-star text-warning me-2"></i>
                        قائمة التقييمات ({{ $reviews->total() }})
                    </h5>
                </div>

                @if($reviews->count() > 0)
                    <div class="admin-table">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>المستخدم</th>
                                    <th>المنتج</th>
                                    <th>التقييم</th>
                                    <th>التعليق</th>
                                    <th>التاريخ</th>
                                    <th>الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($reviews as $review)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="user-avatar me-3">
                                                {{ substr($review->user->name ?? 'م', 0, 1) }}
                                            </div>
                                            <div>
                                                <div class="fw-bold">{{ $review->user->name ?? 'غير محدد' }}</div>
                                                <small class="text-muted">{{ $review->user->email ?? '' }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="fw-bold">{{ $review->product->name ?? 'غير محدد' }}</div>
                                        <small class="text-muted">{{ $review->product->supplier->company_name ?? '' }}</small>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="text-warning me-2">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <i class="fas fa-star{{ $i <= ($review->rating ?? 0) ? '' : '-o' }}"></i>
                                                @endfor
                                            </div>
                                            <span class="fw-bold">{{ number_format($review->rating ?? 0, 1) }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="fw-bold">{{ Str::limit($review->comment ?? '', 50) }}</div>
                                    </td>
                                    <td>
                                        <div class="fw-bold">{{ $review->created_at->format('Y-m-d') }}</div>
                                        <small class="text-muted">{{ $review->created_at->format('H:i') }}</small>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.reviews.show', $review->id) }}" class="btn btn-sm btn-outline-primary" title="عرض">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.reviews.edit', $review->id) }}" class="btn btn-sm btn-outline-warning" title="تعديل">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.reviews.delete', $review->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('هل أنت متأكد من حذف هذا التقييم؟')">
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
                        {{ $reviews->links() }}
                    </div>
                @else
                    <div class="text-center py-5">
                        <div class="stat-icon bg-light text-muted mx-auto mb-3" style="width: 80px; height: 80px; font-size: 2rem;">
                            <i class="fas fa-star"></i>
                        </div>
                        <h6 class="text-muted">لا توجد تقييمات</h6>
                        <p class="text-muted mb-0">لم يتم العثور على تقييمات في النظام</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection 