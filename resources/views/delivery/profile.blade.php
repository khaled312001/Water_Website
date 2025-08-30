@extends('layouts.admin')

@section('title', 'الملف الشخصي - سلسبيل مكة')
@section('page-title', 'الملف الشخصي')

@section('content')
<div class="fade-in">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="mb-0">الملف الشخصي</h4>
                    <button class="btn btn-admin btn-warning" onclick="editProfile()">
                        <i class="fas fa-edit me-2"></i>
                        تعديل
                    </button>
                </div>

                <!-- Personal Information -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="card border-0 bg-light">
                            <div class="card-body">
                                <h6 class="card-title text-primary mb-3">
                                    <i class="fas fa-user me-2"></i>
                                    المعلومات الشخصية
                                </h6>
                                
                                <div class="mb-3">
                                    <label class="form-label fw-bold">الاسم الكامل:</label>
                                    <p class="mb-0">{{ auth()->user()->name }}</p>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">البريد الإلكتروني:</label>
                                    <p class="mb-0">{{ auth()->user()->email }}</p>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">رقم الهاتف:</label>
                                    <p class="mb-0">{{ auth()->user()->phone ?? 'غير محدد' }}</p>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">تاريخ التسجيل:</label>
                                    <p class="mb-0">{{ auth()->user()->created_at->format('Y-m-d') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card border-0 bg-light">
                            <div class="card-body">
                                <h6 class="card-title text-primary mb-3">
                                    <i class="fas fa-truck me-2"></i>
                                    معلومات التوصيل
                                </h6>
                                
                                <div class="mb-3">
                                    <label class="form-label fw-bold">الرقم الوطني:</label>
                                    <p class="mb-0">{{ auth()->user()->deliveryMan->national_id ?? 'غير محدد' }}</p>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">نوع المركبة:</label>
                                    <p class="mb-0">{{ auth()->user()->deliveryMan->vehicle_type ?? 'غير محدد' }}</p>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">رقم المركبة:</label>
                                    <p class="mb-0">{{ auth()->user()->deliveryMan->vehicle_number ?? 'غير محدد' }}</p>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">رقم الرخصة:</label>
                                    <p class="mb-0">{{ auth()->user()->deliveryMan->license_number ?? 'غير محدد' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact Information -->
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card border-0 bg-light">
                            <div class="card-body">
                                <h6 class="card-title text-primary mb-3">
                                    <i class="fas fa-phone me-2"></i>
                                    معلومات الاتصال
                                </h6>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">جهة اتصال الطوارئ:</label>
                                            <p class="mb-0">{{ auth()->user()->deliveryMan->emergency_contact ?? 'غير محدد' }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">رقم هاتف الطوارئ:</label>
                                            <p class="mb-0">{{ auth()->user()->deliveryMan->emergency_phone ?? 'غير محدد' }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">المدينة:</label>
                                    <p class="mb-0">{{ auth()->user()->deliveryMan->city ?? 'غير محدد' }}</p>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">العنوان:</label>
                                    <p class="mb-0">{{ auth()->user()->deliveryMan->address ?? 'غير محدد' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Work Statistics -->
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card border-0 bg-light">
                            <div class="card-body">
                                <h6 class="card-title text-primary mb-3">
                                    <i class="fas fa-chart-bar me-2"></i>
                                    إحصائيات العمل
                                </h6>
                                
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="text-center">
                                            <h4 class="text-primary">{{ $totalDeliveries ?? 0 }}</h4>
                                            <p class="text-muted mb-0">إجمالي التوصيلات</p>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="text-center">
                                            <h4 class="text-success">{{ $completedDeliveries ?? 0 }}</h4>
                                            <p class="text-muted mb-0">التوصيلات المكتملة</p>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="text-center">
                                            <h4 class="text-warning">{{ number_format($totalEarnings ?? 0, 2) }} ريال</h4>
                                            <p class="text-muted mb-0">إجمالي الأرباح</p>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="text-center">
                                            <h4 class="text-info">4.8</h4>
                                            <p class="text-muted mb-0">متوسط التقييم</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card border-0 bg-light">
                            <div class="card-body">
                                <h6 class="card-title text-primary mb-3">
                                    <i class="fas fa-history me-2"></i>
                                    النشاط الأخير
                                </h6>
                                
                                <div class="timeline">
                                    @forelse($recentActivity ?? [] as $activity)
                                    <div class="timeline-item">
                                        <div class="timeline-marker bg-primary"></div>
                                        <div class="timeline-content">
                                            <h6 class="mb-1">{{ $activity->title }}</h6>
                                            <p class="text-muted mb-0">{{ $activity->description }}</p>
                                            <small class="text-muted">{{ $activity->created_at->diffForHumans() }}</small>
                                        </div>
                                    </div>
                                    @empty
                                    <div class="text-center py-3">
                                        <p class="text-muted mb-0">لا يوجد نشاط حديث</p>
                                    </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline-item {
    position: relative;
    margin-bottom: 20px;
}

.timeline-marker {
    position: absolute;
    left: -35px;
    top: 5px;
    width: 12px;
    height: 12px;
    border-radius: 50%;
}

.timeline-content {
    padding-left: 20px;
    border-left: 2px solid #e9ecef;
    padding-bottom: 10px;
}
</style>

<script>
function editProfile() {
    // Redirect to edit profile page or show edit modal
    alert('سيتم إضافة صفحة تعديل الملف الشخصي قريباً');
}
</script>
@endsection 