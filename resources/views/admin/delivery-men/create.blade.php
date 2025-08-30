@extends('layouts.admin')

@section('title', 'إضافة مندوب توصيل جديد - سلسبيل مكة')
@section('page-title', 'إضافة مندوب توصيل جديد')

@section('content')
<div class="fade-in">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="mb-0">إضافة مندوب توصيل جديد</h4>
                    <a href="{{ route('admin.delivery-men') }}" class="btn btn-admin btn-outline-secondary">
                        <i class="fas fa-arrow-right me-2"></i>
                        العودة للقائمة
                    </a>
                </div>

                <form action="{{ route('admin.delivery-men.store') }}" method="POST">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="user_id" class="form-label">المستخدم *</label>
                            <select class="form-select @error('user_id') is-invalid @enderror" id="user_id" name="user_id" required>
                                <option value="">اختر المستخدم</option>
                                @foreach(\App\Models\User::where('role', 'delivery')->get() as $user)
                                    <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }} ({{ $user->email }})
                                    </option>
                                @endforeach
                            </select>
                            @error('user_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="national_id" class="form-label">الرقم الوطني *</label>
                            <input type="text" class="form-control @error('national_id') is-invalid @enderror" 
                                   id="national_id" name="national_id" value="{{ old('national_id') }}" required>
                            @error('national_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="vehicle_type" class="form-label">نوع المركبة *</label>
                            <select class="form-select @error('vehicle_type') is-invalid @enderror" id="vehicle_type" name="vehicle_type" required>
                                <option value="">اختر نوع المركبة</option>
                                <option value="motorcycle" {{ old('vehicle_type') == 'motorcycle' ? 'selected' : '' }}>دراجة نارية</option>
                                <option value="car" {{ old('vehicle_type') == 'car' ? 'selected' : '' }}>سيارة</option>
                                <option value="truck" {{ old('vehicle_type') == 'truck' ? 'selected' : '' }}>شاحنة</option>
                                <option value="van" {{ old('vehicle_type') == 'van' ? 'selected' : '' }}>فان</option>
                            </select>
                            @error('vehicle_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="vehicle_number" class="form-label">رقم المركبة *</label>
                            <input type="text" class="form-control @error('vehicle_number') is-invalid @enderror" 
                                   id="vehicle_number" name="vehicle_number" value="{{ old('vehicle_number') }}" required>
                            @error('vehicle_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="license_number" class="form-label">رقم الرخصة *</label>
                            <input type="text" class="form-control @error('license_number') is-invalid @enderror" 
                                   id="license_number" name="license_number" value="{{ old('license_number') }}" required>
                            @error('license_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="emergency_contact" class="form-label">جهة اتصال الطوارئ *</label>
                            <input type="text" class="form-control @error('emergency_contact') is-invalid @enderror" 
                                   id="emergency_contact" name="emergency_contact" value="{{ old('emergency_contact') }}" required>
                            @error('emergency_contact')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="emergency_phone" class="form-label">رقم هاتف الطوارئ *</label>
                            <input type="text" class="form-control @error('emergency_phone') is-invalid @enderror" 
                                   id="emergency_phone" name="emergency_phone" value="{{ old('emergency_phone') }}" required>
                            @error('emergency_phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="city" class="form-label">المدينة *</label>
                            <input type="text" class="form-control @error('city') is-invalid @enderror" 
                                   id="city" name="city" value="{{ old('city') }}" required>
                            @error('city')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12 mb-3">
                            <label for="address" class="form-label">العنوان *</label>
                            <textarea class="form-control @error('address') is-invalid @enderror" 
                                      id="address" name="address" rows="3" required>{{ old('address') }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-admin btn-primary">
                            <i class="fas fa-save me-2"></i>
                            حفظ مندوب التوصيل
                        </button>
                        <a href="{{ route('admin.delivery-men') }}" class="btn btn-admin btn-outline-secondary">
                            إلغاء
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection 