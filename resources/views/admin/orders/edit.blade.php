@extends('layouts.admin')

@section('title', 'تعديل الطلب - سلسبيل مكة')
@section('page-title', 'تعديل الطلب')

@section('content')
<div class="fade-in">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="mb-0">تعديل الطلب: #{{ $order->order_number ?? $order->id }}</h4>
                    <a href="{{ route('admin.orders') }}" class="btn btn-admin btn-outline-secondary">
                        <i class="fas fa-arrow-right me-2"></i>
                        العودة للقائمة
                    </a>
                </div>

                <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="status" class="form-label">حالة الطلب *</label>
                            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                <option value="">اختر الحالة</option>
                                <option value="pending" {{ old('status', $order->status) == 'pending' ? 'selected' : '' }}>في الانتظار</option>
                                <option value="confirmed" {{ old('status', $order->status) == 'confirmed' ? 'selected' : '' }}>مؤكد</option>
                                <option value="preparing" {{ old('status', $order->status) == 'preparing' ? 'selected' : '' }}>قيد التحضير</option>
                                <option value="assigned" {{ old('status', $order->status) == 'assigned' ? 'selected' : '' }}>تم التعيين</option>
                                <option value="picked_up" {{ old('status', $order->status) == 'picked_up' ? 'selected' : '' }}>تم الاستلام</option>
                                <option value="delivered" {{ old('status', $order->status) == 'delivered' ? 'selected' : '' }}>تم التوصيل</option>
                                <option value="cancelled" {{ old('status', $order->status) == 'cancelled' ? 'selected' : '' }}>ملغي</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="payment_status" class="form-label">حالة الدفع *</label>
                            <select class="form-select @error('payment_status') is-invalid @enderror" id="payment_status" name="payment_status" required>
                                <option value="">اختر حالة الدفع</option>
                                <option value="pending" {{ old('payment_status', $order->payment_status) == 'pending' ? 'selected' : '' }}>في الانتظار</option>
                                <option value="paid" {{ old('payment_status', $order->payment_status) == 'paid' ? 'selected' : '' }}>مدفوع</option>
                                <option value="failed" {{ old('payment_status', $order->payment_status) == 'failed' ? 'selected' : '' }}>فشل</option>
                            </select>
                            @error('payment_status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12 mb-3">
                            <label for="notes" class="form-label">ملاحظات</label>
                            <textarea class="form-control @error('notes') is-invalid @enderror" 
                                      id="notes" name="notes" rows="4">{{ old('notes', $order->notes) }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-admin btn-primary">
                            <i class="fas fa-save me-2"></i>
                            حفظ التغييرات
                        </button>
                        <a href="{{ route('admin.orders') }}" class="btn btn-admin btn-outline-secondary">
                            إلغاء
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection 