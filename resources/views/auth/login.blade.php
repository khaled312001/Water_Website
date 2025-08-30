@extends('layouts.app')

@section('title', 'تسجيل الدخول - سلسبيل مكة')

@section('content')
<div class="min-vh-100 d-flex align-items-center justify-content-center" style="background: var(--gradient-primary);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <div class="card border-0 shadow-lg" data-aos="fade-up">
                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            <h2 class="fw-bold text-primary mb-2">
                                <i class="fas fa-tint water-drop me-2"></i>
                                سلسبيل مكة
                            </h2>
                            <p class="text-muted">تسجيل الدخول إلى حسابك</p>
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

                        <!-- Role Detection Alert -->
                        <div id="roleAlert" class="alert alert-info d-none" role="alert">
                            <div class="d-flex align-items-center">
                                <i id="roleIcon" class="fas fa-user me-2"></i>
                                <div class="flex-grow-1">
                                    <strong id="roleTitle">تم اكتشاف نوع الحساب:</strong>
                                    <div id="roleDescription" class="small">سيتم توجيهك إلى لوحة التحكم المناسبة</div>
                                </div>
                                <div class="ms-2">
                                    <span id="roleBadge" class="badge bg-primary"></span>
                                </div>
                            </div>
                        </div>

                        <form method="POST" action="{{ route('login') }}" id="loginForm">
                            @csrf
                            
                            <!-- Hidden role field -->
                            <input type="hidden" name="detected_role" id="detectedRole" value="">
                            
                            <div class="mb-3">
                                <label for="email" class="form-label fw-bold">
                                    <i class="fas fa-envelope me-1"></i>
                                    البريد الإلكتروني
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-envelope"></i>
                                    </span>
                                    <input type="email" class="form-control" id="email" name="email" 
                                           value="{{ old('email') }}" required autofocus 
                                           placeholder="أدخل بريدك الإلكتروني">
                                </div>
                                <div class="form-text">
                                    <i class="fas fa-info-circle me-1"></i>
                                    سيتم اكتشاف نوع الحساب تلقائياً
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label fw-bold">
                                    <i class="fas fa-lock me-1"></i>
                                    كلمة المرور
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-lock"></i>
                                    </span>
                                    <input type="password" class="form-control" id="password" name="password" 
                                           required placeholder="أدخل كلمة المرور">
                                    <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="remember" name="remember">
                                <label class="form-check-label" for="remember">
                                    <i class="fas fa-remember me-1"></i>
                                    تذكرني
                                </label>
                            </div>

                            <div class="d-grid mb-3">
                                <button type="submit" class="btn btn-primary btn-lg" id="loginBtn">
                                    <i class="fas fa-sign-in-alt me-2"></i>
                                    تسجيل الدخول
                                </button>
                            </div>

                            <div class="text-center">
                                <p class="mb-0">
                                    ليس لديك حساب؟ 
                                    <a href="{{ route('register') }}" class="text-decoration-none">
                                        <i class="fas fa-user-plus me-1"></i>
                                        إنشاء حساب جديد
                                    </a>
                                </p>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Demo Accounts -->
                <div class="card border-0 shadow-sm mt-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="card-body p-4">
                        <h6 class="fw-bold mb-3">
                            <i class="fas fa-info-circle text-info me-2"></i>
                            حسابات تجريبية
                        </h6>
                        
                        <div class="mb-3">
                            <small class="text-muted d-block">
                                <i class="fas fa-user-shield me-1"></i>
                                المدير:
                            </small>
                            <small class="text-muted">admin@makkah-water.com / 12345678</small>
                        </div>
                        
                        <div class="mb-3">
                            <small class="text-muted d-block">
                                <i class="fas fa-store me-1"></i>
                                المورد:
                            </small>
                            <small class="text-muted">supplier1@makkah-water.com / 12345678</small>
                        </div>
                        
                        <div class="mb-3">
                            <small class="text-muted d-block">
                                <i class="fas fa-truck me-1"></i>
                                المندوب:
                            </small>
                            <small class="text-muted">delivery1@makkah-water.com / 12345678</small>
                        </div>
                        
                        <div>
                            <small class="text-muted d-block">
                                <i class="fas fa-user me-1"></i>
                                العميل:
                            </small>
                            <small class="text-muted">customer1@makkah-water.com / 12345678</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.alert {
    border-radius: var(--border-radius);
    border: none;
    box-shadow: var(--shadow-light);
}

.alert-info {
    background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
    color: #1e40af;
}

.alert-danger {
    background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
    color: #dc2626;
}

.alert-warning {
    background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
    color: #d97706;
}

.alert-success {
    background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
    color: #059669;
}

.badge {
    font-size: 0.75rem;
    padding: 0.5rem 0.75rem;
    border-radius: var(--border-radius);
}

.input-group-text {
    background: #f8fafc;
    border-color: #e2e8f0;
}

.form-control:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 0.2rem rgba(30, 58, 138, 0.25);
}

.btn-outline-secondary:hover {
    background-color: var(--primary-color);
    border-color: var(--primary-color);
    color: white;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const emailInput = document.getElementById('email');
    const passwordInput = document.getElementById('password');
    const togglePassword = document.getElementById('togglePassword');
    const roleAlert = document.getElementById('roleAlert');
    const roleIcon = document.getElementById('roleIcon');
    const roleTitle = document.getElementById('roleTitle');
    const roleDescription = document.getElementById('roleDescription');
    const roleBadge = document.getElementById('roleBadge');
    const detectedRole = document.getElementById('detectedRole');
    const loginBtn = document.getElementById('loginBtn');

    // Toggle password visibility
    togglePassword.addEventListener('click', function() {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        this.innerHTML = type === 'password' ? '<i class="fas fa-eye"></i>' : '<i class="fas fa-eye-slash"></i>';
    });

    // Role detection patterns
    const rolePatterns = {
        admin: {
            pattern: /admin@makkah-water\.com/i,
            icon: 'fas fa-user-shield',
            title: 'تم اكتشاف حساب المدير',
            description: 'سيتم توجيهك إلى لوحة تحكم المدير',
            color: 'alert-danger',
            badgeColor: 'bg-danger'
        },
        supplier: {
            pattern: /supplier\d*@makkah-water\.com/i,
            icon: 'fas fa-store',
            title: 'تم اكتشاف حساب المورد',
            description: 'سيتم توجيهك إلى لوحة تحكم المورد',
            color: 'alert-warning',
            badgeColor: 'bg-warning'
        },
        delivery: {
            pattern: /delivery\d*@makkah-water\.com/i,
            icon: 'fas fa-truck',
            title: 'تم اكتشاف حساب المندوب',
            description: 'سيتم توجيهك إلى لوحة تحكم المندوب',
            color: 'alert-success',
            badgeColor: 'bg-success'
        },
        customer: {
            pattern: /customer\d*@makkah-water\.com/i,
            icon: 'fas fa-user',
            title: 'تم اكتشاف حساب العميل',
            description: 'سيتم توجيهك إلى الصفحة الرئيسية',
            color: 'alert-info',
            badgeColor: 'bg-info'
        }
    };

    function detectRole(email) {
        for (const [role, config] of Object.entries(rolePatterns)) {
            if (config.pattern.test(email)) {
                return { role, ...config };
            }
        }
        return null;
    }

    function showRoleAlert(roleConfig) {
        if (roleConfig) {
            roleAlert.className = `alert ${roleConfig.color} d-block`;
            roleIcon.className = roleConfig.icon + ' me-2';
            roleTitle.textContent = roleConfig.title;
            roleDescription.textContent = roleConfig.description;
            roleBadge.className = `badge ${roleConfig.badgeColor}`;
            roleBadge.textContent = getRoleName(roleConfig.role);
            detectedRole.value = roleConfig.role;
            
            // Update login button text and style
            loginBtn.innerHTML = `<i class="fas fa-sign-in-alt me-2"></i>تسجيل الدخول كـ ${getRoleName(roleConfig.role)}`;
            loginBtn.className = `btn btn-${getButtonColor(roleConfig.role)} btn-lg`;
        } else {
            roleAlert.className = 'alert alert-info d-none';
            detectedRole.value = '';
            loginBtn.innerHTML = '<i class="fas fa-sign-in-alt me-2"></i>تسجيل الدخول';
            loginBtn.className = 'btn btn-primary btn-lg';
        }
    }

    function getRoleName(role) {
        const roleNames = {
            admin: 'مدير',
            supplier: 'مورد',
            delivery: 'مندوب',
            customer: 'عميل'
        };
        return roleNames[role] || role;
    }

    function getButtonColor(role) {
        const buttonColors = {
            admin: 'danger',
            supplier: 'warning',
            delivery: 'success',
            customer: 'primary'
        };
        return buttonColors[role] || 'primary';
    }

    // Detect role on email input with debouncing
    let debounceTimer;
    emailInput.addEventListener('input', function() {
        clearTimeout(debounceTimer);
        const email = this.value.trim();
        
        debounceTimer = setTimeout(() => {
            if (email) {
                const detected = detectRole(email);
                showRoleAlert(detected);
            } else {
                showRoleAlert(null);
            }
        }, 300);
    });

    // Detect role on page load if email is pre-filled
    if (emailInput.value.trim()) {
        const detected = detectRole(emailInput.value.trim());
        showRoleAlert(detected);
    }

    // Add loading state to form submission
    document.getElementById('loginForm').addEventListener('submit', function() {
        loginBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>جاري تسجيل الدخول...';
        loginBtn.disabled = true;
    });
});
</script>
@endsection 