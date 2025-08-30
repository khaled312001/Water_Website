@extends('layouts.delivery')

@section('title', 'الملف الشخصي - سلسبيل مكة')
@section('page-title', 'الملف الشخصي')

@section('content')
<div class="fade-in">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="mb-0">الملف الشخصي</h4>
                    <div class="d-flex gap-2">
                        <a href="{{ route('delivery.export.profile') }}" class="btn btn-delivery btn-outline-success">
                            <i class="fas fa-download me-2"></i>
                            تصدير التقرير
                        </a>
                        <button class="btn btn-delivery btn-warning" onclick="toggleEditMode()" id="editBtn">
                            <i class="fas fa-edit me-2"></i>
                            تعديل
                        </button>
                    </div>
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

                <!-- Edit Profile Form (Hidden by default) -->
                <div id="editForm" style="display: none;">
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card border-0 bg-light">
                                <div class="card-body">
                                    <h6 class="card-title text-primary mb-3">
                                        <i class="fas fa-edit me-2"></i>
                                        تعديل الملف الشخصي
                                    </h6>
                                    
                                    <form action="{{ route('delivery.profile.update') }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">الاسم الكامل *</label>
                                                    <input type="text" class="form-control" name="name" value="{{ auth()->user()->name }}" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">رقم الهاتف</label>
                                                    <input type="text" class="form-control" name="phone" value="{{ auth()->user()->phone }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">العنوان</label>
                                                    <input type="text" class="form-control" name="address" value="{{ auth()->user()->address }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">المدينة</label>
                                                    <input type="text" class="form-control" name="city" value="{{ auth()->user()->city }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">جهة اتصال الطوارئ</label>
                                                    <input type="text" class="form-control" name="emergency_contact" value="{{ auth()->user()->deliveryMan->emergency_contact }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">رقم الطوارئ</label>
                                                    <input type="text" class="form-control" name="emergency_phone" value="{{ auth()->user()->deliveryMan->emergency_phone }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">نوع المركبة</label>
                                                    <input type="text" class="form-control" name="vehicle_type" value="{{ auth()->user()->deliveryMan->vehicle_type }}">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">رقم المركبة</label>
                                                    <input type="text" class="form-control" name="vehicle_number" value="{{ auth()->user()->deliveryMan->vehicle_number }}">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">رقم الرخصة</label>
                                                    <input type="text" class="form-control" name="license_number" value="{{ auth()->user()->deliveryMan->license_number }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="text-center mt-4">
                                            <button type="submit" class="btn btn-delivery btn-success me-2">
                                                <i class="fas fa-save me-2"></i>
                                                حفظ التغييرات
                                            </button>
                                            <button type="button" class="btn btn-delivery btn-secondary" onclick="toggleEditMode()">
                                                <i class="fas fa-times me-2"></i>
                                                إلغاء
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Location Information -->
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card border-0 bg-light">
                            <div class="card-body">
                                <h6 class="card-title text-primary mb-3">
                                    <i class="fas fa-map-marker-alt me-2"></i>
                                    معلومات الموقع
                                </h6>
                                
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">خط العرض:</label>
                                            <p class="mb-0">{{ auth()->user()->deliveryMan->current_lat ?? 'غير محدد' }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">خط الطول:</label>
                                            <p class="mb-0">{{ auth()->user()->deliveryMan->current_lng ?? 'غير محدد' }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">آخر تحديث:</label>
                                            <p class="mb-0">{{ auth()->user()->deliveryMan->last_active ? auth()->user()->deliveryMan->last_active->diffForHumans() : 'غير محدد' }}</p>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="text-center mt-3">
                                    <div class="d-flex gap-2 justify-content-center">
                                        <button class="btn btn-delivery btn-primary" onclick="updateLocation()">
                                            <i class="fas fa-sync-alt me-2"></i>
                                            تحديث الموقع الآن
                                        </button>
                                        @if($deliveryMan->current_lat && $deliveryMan->current_lng)
                                        <button class="btn btn-delivery btn-outline-info" onclick="showCurrentLocationMap()">
                                            <i class="fas fa-map me-2"></i>
                                            عرض الخريطة
                                        </button>
                                        @endif
                                    </div>
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
                                            <label class="form-label fw-bold">رقم الطوارئ:</label>
                                            <p class="mb-0">{{ auth()->user()->deliveryMan->emergency_phone ?? 'غير محدد' }}</p>
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
function toggleEditMode() {
    const editForm = document.getElementById('editForm');
    const editBtn = document.getElementById('editBtn');
    const isEditing = editForm.style.display !== 'none';
    
    if (isEditing) {
        // Hide edit form
        editForm.style.display = 'none';
        editBtn.innerHTML = '<i class="fas fa-edit me-2"></i>تعديل';
        editBtn.className = 'btn btn-delivery btn-warning';
    } else {
        // Show edit form
        editForm.style.display = 'block';
        editBtn.innerHTML = '<i class="fas fa-eye me-2"></i>عرض';
        editBtn.className = 'btn btn-delivery btn-info';
        
        // Scroll to edit form
        editForm.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
}

// Show success/error messages
@if(session('success'))
    showNotification('{{ session('success') }}', 'success');
@endif

@if(session('error'))
    showNotification('{{ session('error') }}', 'error');
@endif

function showNotification(message, type) {
    const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
    const icon = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle';
    
    const notification = document.createElement('div');
    notification.className = `alert ${alertClass} alert-dismissible fade show position-fixed`;
    notification.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
    notification.innerHTML = `
        <i class="fas ${icon} me-2"></i>
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    `;
    
    document.body.appendChild(notification);
    
    // Auto remove after 5 seconds
    setTimeout(() => {
        if (notification.parentNode) {
            notification.remove();
        }
    }, 5000);
}

// Location update functionality
function updateLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            const lat = position.coords.latitude;
            const lng = position.coords.longitude;
            
            fetch('/delivery/location', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    lat: lat,
                    lng: lng
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification('تم تحديث الموقع بنجاح', 'success');
                    showLocationMap(lat, lng);
                    // Reload page to show updated coordinates
                    setTimeout(() => {
                        location.reload();
                    }, 2000);
                } else {
                    showNotification('حدث خطأ أثناء تحديث الموقع', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('حدث خطأ أثناء تحديث الموقع', 'error');
            });
        }, function(error) {
            let errorMessage = 'لا يمكن تحديد موقعك';
            switch(error.code) {
                case error.PERMISSION_DENIED:
                    errorMessage = 'يرجى السماح بالوصول إلى الموقع';
                    break;
                case error.POSITION_UNAVAILABLE:
                    errorMessage = 'معلومات الموقع غير متاحة';
                    break;
                case error.TIMEOUT:
                    errorMessage = 'انتهت مهلة تحديد الموقع';
                    break;
            }
            showNotification(errorMessage, 'error');
        });
    } else {
        showNotification('متصفحك لا يدعم تحديد الموقع', 'error');
    }
}

// Show current location map function
function showCurrentLocationMap() {
    const currentLat = {{ $deliveryMan->current_lat ?? 0 }};
    const currentLng = {{ $deliveryMan->current_lng ?? 0 }};
    
    if (currentLat && currentLng) {
        showLocationMap(currentLat, currentLng);
    } else {
        showNotification('لا يوجد موقع محدد حالياً. يرجى تحديث الموقع أولاً.', 'warning');
    }
}

// Show location map function
function showLocationMap(lat, lng) {
    const mapModal = `
        <div class="modal fade" id="locationMapModal" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="fas fa-map-marker-alt me-2"></i>
                            موقعك الحالي
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div id="map" style="height: 400px; width: 100%; border-radius: 8px;"></div>
                        <div class="mt-3">
                            <p><strong>الإحداثيات:</strong></p>
                            <p>خط العرض: ${lat.toFixed(6)}</p>
                            <p>خط الطول: ${lng.toFixed(6)}</p>
                            <a href="https://www.google.com/maps?q=${lat},${lng}" target="_blank" class="btn btn-delivery btn-outline-primary btn-sm">
                                <i class="fas fa-external-link-alt me-1"></i>
                                فتح في Google Maps
                            </a>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-delivery btn-secondary" data-bs-dismiss="modal">إغلاق</button>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    // Remove existing modal if any
    const existingModal = document.getElementById('locationMapModal');
    if (existingModal) {
        existingModal.remove();
    }
    
    // Add modal to body
    document.body.insertAdjacentHTML('beforeend', mapModal);
    
    // Show modal
    const modal = new bootstrap.Modal(document.getElementById('locationMapModal'));
    modal.show();
    
    // Initialize map after modal is shown
    setTimeout(() => {
        initializeMap(lat, lng);
    }, 500);
    
    // Remove modal from DOM after it's hidden
    document.getElementById('locationMapModal').addEventListener('hidden.bs.modal', function() {
        this.remove();
    });
}

// Initialize map function
function initializeMap(lat, lng) {
    // Check if Leaflet is loaded
    if (typeof L === 'undefined') {
        // Load Leaflet CSS and JS dynamically
        const leafletCSS = document.createElement('link');
        leafletCSS.rel = 'stylesheet';
        leafletCSS.href = 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.css';
        document.head.appendChild(leafletCSS);
        
        const leafletJS = document.createElement('script');
        leafletJS.src = 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.js';
        leafletJS.onload = function() {
            createMap(lat, lng);
        };
        document.head.appendChild(leafletJS);
    } else {
        createMap(lat, lng);
    }
}

// Create map function
function createMap(lat, lng) {
    const map = L.map('map').setView([lat, lng], 15);
    
    // Add OpenStreetMap tiles
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);
    
    // Add marker for current location
    const marker = L.marker([lat, lng]).addTo(map);
    marker.bindPopup('<b>موقعك الحالي</b><br>تم تحديث الموقع بنجاح').openPopup();
    
    // Add circle to show accuracy
    L.circle([lat, lng], {
        color: 'red',
        fillColor: '#f03',
        fillOpacity: 0.2,
        radius: 100
    }).addTo(map);
}
</script>
@endsection 