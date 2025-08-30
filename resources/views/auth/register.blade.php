@extends('layouts.app')

@section('title', 'إنشاء حساب جديد - مياه مكة')

@section('content')
<div class="min-vh-100 d-flex align-items-center justify-content-center" style="background: var(--gradient-primary);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card border-0 shadow-lg" data-aos="fade-up">
                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            <h2 class="fw-bold text-primary mb-2">
                                <i class="fas fa-tint water-drop me-2"></i>
                                مياه مكة
                            </h2>
                            <p class="text-muted">إنشاء حساب جديد</p>
                        </div>

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label fw-bold">الاسم الكامل</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-user"></i>
                                        </span>
                                        <input type="text" class="form-control" id="name" name="name" 
                                               value="{{ old('name') }}" required autofocus>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="phone" class="form-label fw-bold">رقم الهاتف</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-phone"></i>
                                        </span>
                                        <input type="tel" class="form-control" id="phone" name="phone" 
                                               value="{{ old('phone') }}" required>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label fw-bold">البريد الإلكتروني</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-envelope"></i>
                                    </span>
                                    <input type="email" class="form-control" id="email" name="email" 
                                           value="{{ old('email') }}" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="password" class="form-label fw-bold">كلمة المرور</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-lock"></i>
                                        </span>
                                        <input type="password" class="form-control" id="password" name="password" required>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="password_confirmation" class="form-label fw-bold">تأكيد كلمة المرور</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-lock"></i>
                                        </span>
                                        <input type="password" class="form-control" id="password_confirmation" 
                                               name="password_confirmation" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="city" class="form-label fw-bold">المدينة</label>
                                    <select class="form-select" id="city" name="city" required>
                                        <option value="">اختر المدينة</option>
                                        <option value="مكة المكرمة" {{ old('city') == 'مكة المكرمة' ? 'selected' : '' }}>مكة المكرمة</option>
                                        <option value="جدة" {{ old('city') == 'جدة' ? 'selected' : '' }}>جدة</option>
                                        <option value="الرياض" {{ old('city') == 'الرياض' ? 'selected' : '' }}>الرياض</option>
                                        <option value="المدينة المنورة" {{ old('city') == 'المدينة المنورة' ? 'selected' : '' }}>المدينة المنورة</option>
                                        <option value="الطائف" {{ old('city') == 'الطائف' ? 'selected' : '' }}>الطائف</option>
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="role" class="form-label fw-bold">نوع الحساب</label>
                                    <select class="form-select" id="role" name="role" required>
                                        <option value="">اختر نوع الحساب</option>
                                        <option value="customer" {{ old('role') == 'customer' ? 'selected' : '' }}>عميل</option>
                                        <option value="supplier" {{ old('role') == 'supplier' ? 'selected' : '' }}>مورد</option>
                                        <option value="delivery" {{ old('role') == 'delivery' ? 'selected' : '' }}>مندوب توصيل</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="address" class="form-label fw-bold">العنوان</label>
                                <textarea class="form-control" id="address" name="address" rows="2" 
                                          placeholder="اكتب عنوانك التفصيلي...">{{ old('address') }}</textarea>
                            </div>

                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="terms" name="terms" required>
                                <label class="form-check-label" for="terms">
                                    أوافق على <a href="#" class="text-decoration-none">الشروط والأحكام</a> 
                                    و <a href="#" class="text-decoration-none">سياسة الخصوصية</a>
                                </label>
                            </div>

                            <div class="d-grid mb-3">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fas fa-user-plus me-2"></i>
                                    إنشاء الحساب
                                </button>
                            </div>

                            <div class="text-center">
                                <p class="mb-0">
                                    لديك حساب بالفعل؟ 
                                    <a href="{{ route('login') }}" class="text-decoration-none">تسجيل الدخول</a>
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 