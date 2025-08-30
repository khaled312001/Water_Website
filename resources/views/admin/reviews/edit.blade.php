@extends('layouts.admin')

@section('title', 'تعديل التقييم - سلسبيل مكة')
@section('page-title', 'تعديل التقييم')

@section('content')
<div class="fade-in">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="mb-0">تعديل التقييم #{{ $review->id }}</h4>
                    <a href="{{ route('admin.reviews') }}" class="btn btn-admin btn-outline-secondary">
                        <i class="fas fa-arrow-right me-2"></i>
                        العودة للقائمة
                    </a>
                </div>

                <form action="{{ route('admin.reviews.update', $review->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="rating" class="form-label">التقييم *</label>
                            <select class="form-select @error('rating') is-invalid @enderror" id="rating" name="rating" required>
                                <option value="">اختر التقييم</option>
                                <option value="5" {{ old('rating', $review->rating) == 5 ? 'selected' : '' }}>5 نجوم</option>
                                <option value="4" {{ old('rating', $review->rating) == 4 ? 'selected' : '' }}>4 نجوم</option>
                                <option value="3" {{ old('rating', $review->rating) == 3 ? 'selected' : '' }}>3 نجوم</option>
                                <option value="2" {{ old('rating', $review->rating) == 2 ? 'selected' : '' }}>2 نجوم</option>
                                <option value="1" {{ old('rating', $review->rating) == 1 ? 'selected' : '' }}>1 نجمة</option>
                            </select>
                            @error('rating')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12 mb-3">
                            <label for="comment" class="form-label">التعليق</label>
                            <textarea class="form-control @error('comment') is-invalid @enderror" 
                                      id="comment" name="comment" rows="4">{{ old('comment', $review->comment) }}</textarea>
                            @error('comment')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-admin btn-primary">
                            <i class="fas fa-save me-2"></i>
                            حفظ التغييرات
                        </button>
                        <a href="{{ route('admin.reviews') }}" class="btn btn-admin btn-outline-secondary">
                            إلغاء
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection 