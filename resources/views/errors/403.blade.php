@extends('layouts.app')

@section('title', 'غير مصرح - سلسبيل مكة')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card border-0 shadow-lg text-center" data-aos="fade-up">
                <div class="card-body p-5">
                    <div class="mb-4">
                        <i class="fas fa-exclamation-triangle text-warning" style="font-size: 4rem;"></i>
                    </div>
                    
                    <h3 class="text-danger mb-3">غير مصرح لك بالوصول</h3>
                    
                    <p class="text-muted mb-4">
                        عذراً، لا تملك الصلاحية لعرض هذه الصفحة. 
                        @if(!auth()->check())
                            <br><strong>يجب تسجيل الدخول أولاً.</strong>
                        @else
                            <br><strong>هذا المحتوى لا يخص حسابك.</strong>
                        @endif
                    </p>
                    
                    <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                        @if(!auth()->check())
                            <a href="{{ route('login') }}" class="btn btn-primary btn-lg">
                                <i class="fas fa-sign-in-alt me-2"></i>
                                تسجيل الدخول
                            </a>
                        @endif
                        
                        <a href="{{ route('home') }}" class="btn btn-outline-secondary btn-lg">
                            <i class="fas fa-home me-2"></i>
                            العودة للرئيسية
                        </a>
                        
                        @if(auth()->check())
                            <a href="{{ route('orders.index') }}" class="btn btn-outline-primary btn-lg">
                                <i class="fas fa-list me-2"></i>
                                طلباتي
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 