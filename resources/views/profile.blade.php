@extends('layouts.app')

@section('title', 'الملف الشخصي - مياه مكة')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-lg" data-aos="fade-up">
                <div class="card-header bg-primary text-white text-center py-4">
                    <h3 class="mb-0">
                        <i class="fas fa-user-circle me-2"></i>
                        الملف الشخصي
                    </h3>
                </div>
                <div class="card-body p-5">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-4 text-center mb-4">
                            <div class="profile-avatar mb-3">
                                @if(auth()->user()->profile_image)
                                    <img src="{{ asset('storage/' . auth()->user()->profile_image) }}" 
                                         alt="الصورة الشخصية" class="rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
                                @else
                                    <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center mx-auto" 
                                         style="width: 150px; height: 150px; font-size: 3rem; color: white;">
                                        {{ substr(auth()->user()->name, 0, 1) }}
                                    </div>
                                @endif
                            </div>
                            
                            <div class="role-badge mb-3">
                                @if(auth()->user()->isAdmin())
                                    <span class="badge bg-danger fs-6">
                                        <i class="fas fa-user-shield me-1"></i>
                                        مدير
                                    </span>
                                @elseif(auth()->user()->isSupplier())
                                    <span class="badge bg-warning fs-6">
                                        <i class="fas fa-store me-1"></i>
                                        مورد
                                    </span>
                                @elseif(auth()->user()->isDeliveryMan())
                                    <span class="badge bg-success fs-6">
                                        <i class="fas fa-truck me-1"></i>
                                        مندوب
                                    </span>
                                @else
                                    <span class="badge bg-info fs-6">
                                        <i class="fas fa-user me-1"></i>
                                        عميل
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="col-md-8">
                            <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="name" class="form-label fw-bold">
                                            <i class="fas fa-user me-1"></i>
                                            الاسم الكامل
                                        </label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                               id="name" name="name" value="{{ old('name', auth()->user()->name) }}" required>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label for="email" class="form-label fw-bold">
                                            <i class="fas fa-envelope me-1"></i>
                                            البريد الإلكتروني
                                        </label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                               id="email" name="email" value="{{ old('email', auth()->user()->email) }}" required>
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="phone" class="form-label fw-bold">
                                            <i class="fas fa-phone me-1"></i>
                                            رقم الهاتف
                                        </label>
                                        <input type="tel" class="form-control @error('phone') is-invalid @enderror" 
                                               id="phone" name="phone" value="{{ old('phone', auth()->user()->phone) }}" required>
                                        @error('phone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label for="city" class="form-label fw-bold">
                                            <i class="fas fa-map-marker-alt me-1"></i>
                                            المدينة
                                        </label>
                                        <input type="text" class="form-control @error('city') is-invalid @enderror" 
                                               id="city" name="city" value="{{ old('city', auth()->user()->city) }}" required>
                                        @error('city')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="address" class="form-label fw-bold">
                                        <i class="fas fa-home me-1"></i>
                                        العنوان
                                    </label>
                                    <textarea class="form-control @error('address') is-invalid @enderror" 
                                              id="address" name="address" rows="3">{{ old('address', auth()->user()->address) }}</textarea>
                                    @error('address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="profile_image" class="form-label fw-bold">
                                        <i class="fas fa-camera me-1"></i>
                                        الصورة الشخصية
                                    </label>
                                    <input type="file" class="form-control @error('profile_image') is-invalid @enderror" 
                                           id="profile_image" name="profile_image" accept="image/*">
                                    @error('profile_image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">يمكنك تحميل صورة شخصية (JPG, PNG, GIF)</div>
                                </div>
                                
                                <hr class="my-4">
                                
                                <h5 class="mb-3">
                                    <i class="fas fa-lock me-2"></i>
                                    تغيير كلمة المرور
                                </h5>
                                
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="current_password" class="form-label fw-bold">كلمة المرور الحالية</label>
                                        <input type="password" class="form-control @error('current_password') is-invalid @enderror" 
                                               id="current_password" name="current_password">
                                        @error('current_password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label for="new_password" class="form-label fw-bold">كلمة المرور الجديدة</label>
                                        <input type="password" class="form-control @error('new_password') is-invalid @enderror" 
                                               id="new_password" name="new_password">
                                        @error('new_password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="mb-4">
                                    <label for="new_password_confirmation" class="form-label fw-bold">تأكيد كلمة المرور الجديدة</label>
                                    <input type="password" class="form-control" 
                                           id="new_password_confirmation" name="new_password_confirmation">
                                </div>
                                
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <i class="fas fa-save me-2"></i>
                                        حفظ التغييرات
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Account Statistics -->
            <div class="card border-0 shadow-lg mt-4" data-aos="fade-up" data-aos-delay="200">
                <div class="card-header bg-light">
                    <h5 class="mb-0">
                        <i class="fas fa-chart-bar me-2"></i>
                        إحصائيات الحساب
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-3 mb-3">
                            <div class="stat-item">
                                <i class="fas fa-shopping-cart text-primary fs-1 mb-2"></i>
                                <h4 class="fw-bold">{{ auth()->user()->orders->count() }}</h4>
                                <p class="text-muted">الطلبات</p>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="stat-item">
                                <i class="fas fa-star text-warning fs-1 mb-2"></i>
                                <h4 class="fw-bold">{{ auth()->user()->reviews->count() }}</h4>
                                <p class="text-muted">التقييمات</p>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="stat-item">
                                <i class="fas fa-calendar-alt text-success fs-1 mb-2"></i>
                                <h4 class="fw-bold">{{ auth()->user()->created_at->diffForHumans() }}</h4>
                                <p class="text-muted">تاريخ التسجيل</p>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="stat-item">
                                <i class="fas fa-clock text-info fs-1 mb-2"></i>
                                <h4 class="fw-bold">{{ auth()->user()->last_login_at ?? 'غير محدد' }}</h4>
                                <p class="text-muted">آخر تسجيل دخول</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.profile-avatar img {
    border: 4px solid var(--primary-color);
    box-shadow: var(--shadow-medium);
}

.stat-item {
    padding: 1rem;
    border-radius: var(--border-radius);
    background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
    transition: all 0.3s ease;
}

.stat-item:hover {
    transform: translateY(-5px);
    box-shadow: var(--shadow-medium);
}

.role-badge .badge {
    font-size: 1rem;
    padding: 0.75rem 1.5rem;
}
</style>
@endsection 