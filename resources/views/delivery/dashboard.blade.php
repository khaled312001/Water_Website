@extends('layouts.delivery')

@section('title', 'لوحة تحكم مندوب التوصيل - سلسبيل مكة')
@section('page-title', 'لوحة تحكم مندوب التوصيل')

@section('content')
<div class="fade-in">
    <!-- Welcome Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="stat-card">
                <div class="d-flex align-items-center">
                    <div class="stat-icon bg-primary text-white me-3">
                        <i class="fas fa-truck"></i>
                    </div>
                    <div>
                        <h4 class="mb-1">مرحباً، {{ auth()->user()->name }}</h4>
                        <p class="text-muted mb-0">مرحباً بك في لوحة تحكم مندوب التوصيل</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stat-card">
                <div class="d-flex align-items-center">
                    <div class="stat-icon bg-primary text-white me-3">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <div>
                        <h3 class="mb-1">{{ $todayOrders }}</h3>
                        <p class="text-muted mb-0">طلبات اليوم</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stat-card">
                <div class="d-flex align-items-center">
                    <div class="stat-icon bg-success text-white me-3">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div>
                        <h3 class="mb-1">{{ $pendingOrders }}</h3>
                        <p class="text-muted mb-0">الطلبات المعلقة</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stat-card">
                <div class="d-flex align-items-center">
                    <div class="stat-icon bg-warning text-white me-3">
                        <i class="fas fa-money-bill-wave"></i>
                    </div>
                    <div>
                        <h3 class="mb-1">{{ number_format($todayEarnings, 2) }} ريال</h3>
                        <p class="text-muted mb-0">أرباح اليوم</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stat-card">
                <div class="d-flex align-items-center">
                    <div class="stat-icon bg-info text-white me-3">
                        <i class="fas fa-star"></i>
                    </div>
                    <div>
                        <h3 class="mb-1">{{ $deliveryMan->rating ?? '4.8' }}</h3>
                        <p class="text-muted mb-0">متوسط التقييم</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Status Control -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="stat-card">
                <h5 class="mb-3">
                    <i class="fas fa-toggle-on text-success me-2"></i>
                    حالة العمل
                </h5>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="statusToggle" 
                                   {{ $deliveryMan->status === 'available' ? 'checked' : '' }}>
                            <label class="form-check-label" for="statusToggle">
                                متاح للطلبات
                            </label>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <button class="btn btn-delivery btn-outline-primary" onclick="updateLocation()">
                            <i class="fas fa-map-marker-alt me-2"></i>
                            تحديث الموقع
                        </button>
                    </div>
                    <div class="col-md-4 mb-3">
                        <button class="btn btn-delivery btn-outline-info" onclick="showStatusReport()">
                            <i class="fas fa-clock me-2"></i>
                            تقرير الحالة
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="stat-card">
                <h5 class="mb-3">
                    <i class="fas fa-bolt text-warning me-2"></i>
                    إجراءات سريعة
                </h5>
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('delivery.orders') }}" class="btn btn-delivery btn-outline-primary w-100">
                            <i class="fas fa-list me-2"></i>
                            عرض الطلبات
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('delivery.earnings') }}" class="btn btn-delivery btn-outline-success w-100">
                            <i class="fas fa-chart-line me-2"></i>
                            تقارير الأرباح
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('delivery.profile') }}" class="btn btn-delivery btn-outline-warning w-100">
                            <i class="fas fa-user-cog me-2"></i>
                            الملف الشخصي
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <button class="btn btn-delivery btn-outline-info w-100" onclick="showSettings()">
                            <i class="fas fa-cog me-2"></i>
                            الإعدادات
                        </button>
                    </div>
                    <div class="col-md-3 mb-3">
                        <button class="btn btn-delivery btn-outline-success w-100" onclick="exportComprehensiveReport()">
                            <i class="fas fa-file-export me-2"></i>
                            تصدير تقرير شامل
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Current Orders -->
    <div class="row">
        <div class="col-lg-8">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="mb-0">
                        <i class="fas fa-clock text-info me-2"></i>
                        الطلبات الحالية
                    </h5>
                    <div class="d-flex gap-2">
                        <a href="{{ route('delivery.export.orders') }}" class="btn btn-delivery btn-sm btn-outline-success">
                            <i class="fas fa-download me-1"></i>
                            تصدير
                        </a>
                        <a href="{{ route('delivery.orders') }}" class="btn btn-delivery btn-sm btn-outline-primary">
                            عرض الكل
                        </a>
                    </div>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>رقم الطلب</th>
                                <th>العميل</th>
                                <th>العنوان</th>
                                <th>المبلغ</th>
                                <th>الحالة</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($currentOrders ?? [] as $order)
                            <tr>
                                <td>#{{ $order->id }}</td>
                                <td>
                                    <div class="fw-bold">{{ $order->customer->name ?? 'غير محدد' }}</div>
                                    <small class="text-muted">{{ $order->customer->phone ?? '' }}</small>
                                </td>
                                <td>{{ Str::limit($order->delivery_address ?? 'غير محدد', 30) }}</td>
                                <td>{{ $order->total_amount ?? 0 }} ريال</td>
                                <td>
                                    @php
                                        $statusColors = [
                                            'assigned' => 'primary',
                                            'picked_up' => 'info',
                                            'delivered' => 'success'
                                        ];
                                        $statusColor = $statusColors[$order->status] ?? 'secondary';
                                    @endphp
                                    <span class="badge bg-{{ $statusColor }}">{{ $order->status }}</span>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('delivery.order.details', $order->id) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <button class="btn btn-sm btn-outline-success" onclick="updateOrderStatus({{ $order->id }})">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">لا توجد طلبات حالية</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="mb-0">
                        <i class="fas fa-chart-pie text-success me-2"></i>
                        إحصائيات سريعة
                    </h5>
                    <a href="{{ route('delivery.export.earnings') }}" class="btn btn-delivery btn-sm btn-outline-success">
                        <i class="fas fa-download me-1"></i>
                        تصدير
                    </a>
                </div>
                
                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span>الطلبات اليوم</span>
                        <span class="fw-bold">{{ $todayOrders }}</span>
                    </div>
                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar bg-primary" style="width: {{ min($todayOrders * 10, 100) }}%"></div>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span>الطلبات المعلقة</span>
                        <span class="fw-bold">{{ $pendingOrders }}</span>
                    </div>
                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar bg-warning" style="width: {{ min($pendingOrders * 10, 100) }}%"></div>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span>أرباح اليوم</span>
                        <span class="fw-bold">{{ number_format($todayEarnings, 2) }} ريال</span>
                    </div>
                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar bg-success" style="width: {{ min($todayEarnings * 2, 100) }}%"></div>
                    </div>
                </div>
            </div>

            <!-- Location Status -->
            <div class="stat-card mt-4">
                <h5 class="mb-3">
                    <i class="fas fa-map-marker-alt text-danger me-2"></i>
                    الموقع الحالي
                </h5>
                <div class="text-center">
                    <div class="mb-3">
                        <i class="fas fa-location-arrow text-primary" style="font-size: 2rem;"></i>
                    </div>
                    <div id="locationStatus">
                        @if($deliveryMan->current_lat && $deliveryMan->current_lng)
                            <p class="text-success mb-2">
                                <i class="fas fa-check-circle me-1"></i>
                                تم تحديد الموقع
                            </p>
                            <small class="text-muted d-block mb-2">
                                آخر تحديث: {{ $deliveryMan->last_active ? $deliveryMan->last_active->diffForHumans() : 'غير محدد' }}
                            </small>
                            <div class="mt-2">
                                <small class="text-muted">
                                    خط العرض: {{ number_format($deliveryMan->current_lat, 6) }}<br>
                                    خط الطول: {{ number_format($deliveryMan->current_lng, 6) }}
                                </small>
                            </div>
                        @else
                            <p class="text-muted mb-2">لم يتم تحديد الموقع بعد</p>
                        @endif
                    </div>
                    <div class="d-flex gap-2">
                        <button class="btn btn-delivery btn-sm btn-outline-primary" onclick="updateLocation()">
                            <i class="fas fa-sync-alt me-2"></i>
                            تحديث الموقع
                        </button>
                        @if($deliveryMan->current_lat && $deliveryMan->current_lng)
                        <button class="btn btn-delivery btn-sm btn-outline-info" onclick="showCurrentLocationMap()">
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

<script>
function updateOrderStatus(orderId) {
    // Get the current status from the table row
    const row = event.target.closest('tr');
    const statusCell = row.querySelector('td:nth-child(5) .badge');
    const currentStatus = statusCell.textContent.trim();
    
    let newStatus = 'delivered';
    let confirmMessage = 'هل تريد تحديث حالة الطلب؟';
    
    // Determine next status based on current status
    if (currentStatus === 'assigned') {
        newStatus = 'picked_up';
        confirmMessage = 'هل تريد استلام الطلب؟';
    } else if (currentStatus === 'picked_up') {
        newStatus = 'delivered';
        confirmMessage = 'هل تريد تأكيد توصيل الطلب؟';
    }
    
    if (confirm(confirmMessage)) {
        const button = event.target.closest('button');
        const originalText = button.innerHTML;
        
        // Show loading state
        button.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
        button.disabled = true;
        
        // Send AJAX request to update order status
        fetch(`/delivery/orders/${orderId}/status`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                status: newStatus
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification('تم تحديث حالة الطلب بنجاح', 'success');
                // Reload page after a short delay to show updated data
                setTimeout(() => {
                    location.reload();
                }, 1000);
            } else {
                showNotification('حدث خطأ أثناء تحديث حالة الطلب', 'error');
                button.innerHTML = originalText;
                button.disabled = false;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('حدث خطأ أثناء تحديث حالة الطلب', 'error');
            button.innerHTML = originalText;
            button.disabled = false;
        });
    }
}

document.getElementById('statusToggle').addEventListener('change', function() {
    const isAvailable = this.checked;
    const button = this;
    const originalChecked = button.checked;
    
    // Send AJAX request to update delivery man status
    fetch('/delivery/status', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            status: isAvailable ? 'available' : 'offline'
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification(
                isAvailable ? 'تم تفعيل حالة العمل بنجاح' : 'تم إيقاف حالة العمل بنجاح', 
                'success'
            );
        } else {
            // Revert the toggle if update failed
            button.checked = !originalChecked;
            showNotification('حدث خطأ أثناء تحديث الحالة', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        // Revert the toggle if update failed
        button.checked = !originalChecked;
        showNotification('حدث خطأ أثناء تحديث الحالة', 'error');
    });
});

// Location update functionality
function updateLocation() {
    const locationStatus = document.getElementById('locationStatus');
    const button = event.target.closest('button');
    const originalText = button.innerHTML;
    
    // Show loading state
    button.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>جاري التحديث...';
    button.disabled = true;
    
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
                    // Update the location status display
                    locationStatus.innerHTML = `
                        <p class="text-success mb-2">
                            <i class="fas fa-check-circle me-1"></i>
                            تم تحديد الموقع
                        </p>
                        <small class="text-muted d-block mb-2">
                            آخر تحديث: الآن
                        </small>
                        <div class="mt-2">
                            <small class="text-muted">
                                خط العرض: ${lat.toFixed(6)}<br>
                                خط الطول: ${lng.toFixed(6)}
                            </small>
                        </div>
                    `;
                    
                    // Show success message
                    showNotification('تم تحديث الموقع بنجاح', 'success');
                    
                    // Show map with current location
                    showLocationMap(lat, lng);
                } else {
                    showNotification('حدث خطأ أثناء تحديث الموقع', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('حدث خطأ أثناء تحديث الموقع', 'error');
            })
            .finally(() => {
                // Restore button state
                button.innerHTML = originalText;
                button.disabled = false;
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
            
            // Restore button state
            button.innerHTML = originalText;
            button.disabled = false;
        });
    } else {
        showNotification('متصفحك لا يدعم تحديد الموقع', 'error');
        button.innerHTML = originalText;
        button.disabled = false;
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

// Status Report Function
function showStatusReport() {
    const currentTime = new Date().toLocaleString('ar-SA');
    const status = document.getElementById('statusToggle').checked ? 'متاح' : 'غير متاح';
    
    const report = `
        <div class="modal fade" id="statusReportModal" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="fas fa-clock me-2"></i>
                            تقرير الحالة
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h6>معلومات الحالة</h6>
                                <p><strong>الحالة الحالية:</strong> ${status}</p>
                                <p><strong>الوقت:</strong> ${currentTime}</p>
                                <p><strong>آخر تحديث:</strong> ${currentTime}</p>
                            </div>
                            <div class="col-md-6">
                                <h6>إحصائيات اليوم</h6>
                                <p><strong>الطلبات اليوم:</strong> {{ $todayOrders }}</p>
                                <p><strong>الطلبات المعلقة:</strong> {{ $pendingOrders }}</p>
                                <p><strong>أرباح اليوم:</strong> {{ number_format($todayEarnings, 2) }} ريال</p>
                            </div>
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
    const existingModal = document.getElementById('statusReportModal');
    if (existingModal) {
        existingModal.remove();
    }
    
    // Add modal to body
    document.body.insertAdjacentHTML('beforeend', report);
    
    // Show modal
    const modal = new bootstrap.Modal(document.getElementById('statusReportModal'));
    modal.show();
    
    // Remove modal from DOM after it's hidden
    document.getElementById('statusReportModal').addEventListener('hidden.bs.modal', function() {
        this.remove();
    });
}

// Settings Function
function showSettings() {
    const settings = `
        <div class="modal fade" id="settingsModal" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="fas fa-cog me-2"></i>
                            الإعدادات
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h6>إعدادات الإشعارات</h6>
                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" type="checkbox" id="orderNotifications" checked>
                                    <label class="form-check-label" for="orderNotifications">
                                        إشعارات الطلبات الجديدة
                                    </label>
                                </div>
                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" type="checkbox" id="locationUpdates" checked>
                                    <label class="form-check-label" for="locationUpdates">
                                        تحديث الموقع التلقائي
                                    </label>
                                </div>
                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" type="checkbox" id="earningsAlerts" checked>
                                    <label class="form-check-label" for="earningsAlerts">
                                        تنبيهات الأرباح
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h6>إعدادات التطبيق</h6>
                                <div class="mb-3">
                                    <label class="form-label">فترة تحديث الموقع (دقائق)</label>
                                    <select class="form-select" id="locationUpdateInterval">
                                        <option value="1">كل دقيقة</option>
                                        <option value="5" selected>كل 5 دقائق</option>
                                        <option value="10">كل 10 دقائق</option>
                                        <option value="15">كل 15 دقيقة</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">اللغة</label>
                                    <select class="form-select" id="language">
                                        <option value="ar" selected>العربية</option>
                                        <option value="en">English</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-delivery btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                        <button type="button" class="btn btn-delivery btn-primary" onclick="saveSettings()">حفظ الإعدادات</button>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    // Remove existing modal if any
    const existingModal = document.getElementById('settingsModal');
    if (existingModal) {
        existingModal.remove();
    }
    
    // Add modal to body
    document.body.insertAdjacentHTML('beforeend', settings);
    
    // Show modal
    const modal = new bootstrap.Modal(document.getElementById('settingsModal'));
    modal.show();
    
    // Remove modal from DOM after it's hidden
    document.getElementById('settingsModal').addEventListener('hidden.bs.modal', function() {
        this.remove();
    });
}

// Save Settings Function
function saveSettings() {
    const settings = {
        orderNotifications: document.getElementById('orderNotifications').checked,
        locationUpdates: document.getElementById('locationUpdates').checked,
        earningsAlerts: document.getElementById('earningsAlerts').checked,
        locationUpdateInterval: document.getElementById('locationUpdateInterval').value,
        language: document.getElementById('language').value
    };
    
    // Save to localStorage
    localStorage.setItem('deliverySettings', JSON.stringify(settings));
    
    // Close modal
    const modal = bootstrap.Modal.getInstance(document.getElementById('settingsModal'));
    modal.hide();
    
    showNotification('تم حفظ الإعدادات بنجاح', 'success');
}

// Comprehensive Report Export Function
function exportComprehensiveReport() {
    const currentTime = new Date().toLocaleString('ar-SA');
    
    const report = `
        <div class="modal fade" id="comprehensiveReportModal" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="fas fa-file-export me-2"></i>
                            تصدير تقرير شامل
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h6>اختر نوع التقرير</h6>
                                <div class="d-grid gap-2">
                                    <a href="{{ route('delivery.export.orders') }}" class="btn btn-delivery btn-outline-primary">
                                        <i class="fas fa-shopping-cart me-2"></i>
                                        تقرير الطلبات
                                    </a>
                                    <a href="{{ route('delivery.export.earnings') }}" class="btn btn-delivery btn-outline-success">
                                        <i class="fas fa-money-bill-wave me-2"></i>
                                        تقرير الأرباح
                                    </a>
                                    <a href="{{ route('delivery.export.profile') }}" class="btn btn-delivery btn-outline-info">
                                        <i class="fas fa-user me-2"></i>
                                        تقرير الملف الشخصي
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h6>ملخص اليوم</h6>
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <p><strong>الطلبات اليوم:</strong> {{ $todayOrders }}</p>
                                        <p><strong>الطلبات المعلقة:</strong> {{ $pendingOrders }}</p>
                                        <p><strong>أرباح اليوم:</strong> {{ number_format($todayEarnings, 2) }} ريال</p>
                                        <p><strong>الوقت:</strong> ${currentTime}</p>
                                    </div>
                                </div>
                            </div>
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
    const existingModal = document.getElementById('comprehensiveReportModal');
    if (existingModal) {
        existingModal.remove();
    }
    
    // Add modal to body
    document.body.insertAdjacentHTML('beforeend', report);
    
    // Show modal
    const modal = new bootstrap.Modal(document.getElementById('comprehensiveReportModal'));
    modal.show();
    
    // Remove modal from DOM after it's hidden
    document.getElementById('comprehensiveReportModal').addEventListener('hidden.bs.modal', function() {
        this.remove();
    });
}

// Notification function
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
</script>
@endsection 