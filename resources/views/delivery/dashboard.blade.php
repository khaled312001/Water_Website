@extends('layouts.app')

@section('title', 'لوحة تحكم مندوب التوصيل - مياه مكة')

@section('content')
<!-- Delivery Header -->
<section class="py-4 bg-success text-white">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="h2 mb-2">
                    <i class="fas fa-truck me-2"></i>
                    لوحة تحكم مندوب التوصيل
                </h1>
                <p class="mb-0 opacity-75">مرحباً {{ auth()->user()->name }}، إليك نظرة عامة على طلباتك</p>
            </div>
            <div class="col-md-4 text-md-end">
                <div class="d-flex gap-2 justify-content-md-end">
                    <button class="btn btn-light btn-sm" onclick="updateLocation()">
                        <i class="fas fa-map-marker-alt me-1"></i>
                        تحديث الموقع
                    </button>
                    <button class="btn btn-outline-light btn-sm" onclick="toggleStatus()">
                        <i class="fas fa-toggle-on me-1"></i>
                        تغيير الحالة
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Stats Cards -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="100">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="bg-primary bg-opacity-10 rounded-3 p-3">
                                    <i class="fas fa-shopping-cart text-primary fs-4"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h3 class="fw-bold mb-1">{{ number_format($stats['total_deliveries']) }}</h3>
                                <p class="text-muted mb-0">إجمالي التوصيلات</p>
                            </div>
                        </div>
                        <div class="mt-3">
                            <span class="badge bg-success">
                                <i class="fas fa-check me-1"></i>
                                {{ $stats['completed_deliveries'] }} مكتملة
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="200">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="bg-warning bg-opacity-10 rounded-3 p-3">
                                    <i class="fas fa-clock text-warning fs-4"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h3 class="fw-bold mb-1">{{ number_format($stats['pending_deliveries']) }}</h3>
                                <p class="text-muted mb-0">طلبات في الانتظار</p>
                            </div>
                        </div>
                        <div class="mt-3">
                            <span class="badge bg-warning">
                                <i class="fas fa-hourglass-half me-1"></i>
                                قيد المعالجة
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="300">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="bg-success bg-opacity-10 rounded-3 p-3">
                                    <i class="fas fa-money-bill-wave text-success fs-4"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h3 class="fw-bold mb-1">{{ number_format($stats['total_earnings'], 2) }}</h3>
                                <p class="text-muted mb-0">إجمالي الأرباح</p>
                            </div>
                        </div>
                        <div class="mt-3">
                            <span class="badge bg-success">
                                <i class="fas fa-arrow-up me-1"></i>
                                +{{ number_format($stats['earnings_this_month'], 2) }} هذا الشهر
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="400">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="bg-info bg-opacity-10 rounded-3 p-3">
                                    <i class="fas fa-star text-info fs-4"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h3 class="fw-bold mb-1">{{ number_format($stats['rating'], 1) }}</h3>
                                <p class="text-muted mb-0">التقييم العام</p>
                            </div>
                        </div>
                        <div class="mt-3">
                            <div class="text-warning">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star{{ $i <= $stats['rating'] ? '' : '-o' }}"></i>
                                @endfor
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Current Orders & Profile -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row">
            <!-- Current Orders -->
            <div class="col-lg-8 mb-4" data-aos="fade-right">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-transparent border-0 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fas fa-list text-primary me-2"></i>
                            الطلبات الحالية
                        </h5>
                        <a href="{{ route('delivery.orders') }}" class="btn btn-sm btn-outline-primary">
                            عرض الكل
                        </a>
                    </div>
                    <div class="card-body p-0">
                        @if($currentOrders->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>رقم الطلب</th>
                                            <th>العميل</th>
                                            <th>العنوان</th>
                                            <th>المنتج</th>
                                            <th>الحالة</th>
                                            <th>الإجراءات</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($currentOrders as $order)
                                        <tr>
                                            <td>
                                                <a href="{{ route('delivery.order.details', $order->id) }}" class="text-decoration-none">
                                                    #{{ $order->order_number }}
                                                </a>
                                            </td>
                                            <td>
                                                <div>
                                                    <strong>{{ $order->customer_name }}</strong>
                                                    <br>
                                                    <small class="text-muted">{{ $order->customer_phone }}</small>
                                                </div>
                                            </td>
                                            <td>
                                                <small>{{ Str::limit($order->delivery_address, 30) }}</small>
                                            </td>
                                            <td>{{ Str::limit($order->product->name, 20) }}</td>
                                            <td>
                                                <span class="badge bg-{{ $order->status == 'shipped' ? 'info' : 'warning' }}">
                                                    {{ $order->status_text }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <a href="{{ route('delivery.order.details', $order->id) }}" class="btn btn-outline-primary">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <button class="btn btn-outline-success" onclick="updateOrderStatus({{ $order->id }}, 'delivered')">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="fas fa-truck text-muted" style="font-size: 3rem;"></i>
                                <p class="text-muted mt-3">لا توجد طلبات حالية</p>
                                <p class="text-muted">ستظهر هنا الطلبات الجديدة المخصصة لك</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Profile & Status -->
            <div class="col-lg-4" data-aos="fade-left">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-transparent border-0">
                        <h5 class="mb-0">
                            <i class="fas fa-user text-primary me-2"></i>
                            الملف الشخصي
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="text-center mb-4">
                            <img src="{{ auth()->user()->deliveryMan->profile_image ? asset('storage/' . auth()->user()->deliveryMan->profile_image) : 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-4.0.3&auto=format&fit=crop&w=150&q=80' }}" 
                                 class="rounded-circle mb-3" alt="صورة الملف الشخصي" style="width: 100px; height: 100px; object-fit: cover;">
                            <h5 class="mb-1">{{ auth()->user()->name }}</h5>
                            <p class="text-muted mb-2">مندوب توصيل</p>
                            <span class="badge bg-{{ auth()->user()->deliveryMan->status == 'available' ? 'success' : 'warning' }} px-3 py-2">
                                <i class="fas fa-circle me-1"></i>
                                {{ auth()->user()->deliveryMan->status == 'available' ? 'متاح' : 'مشغول' }}
                            </span>
                        </div>

                        <hr>

                        <div class="mb-3">
                            <h6 class="fw-bold mb-2">معلومات المركبة</h6>
                            <div class="d-flex justify-content-between mb-1">
                                <span>نوع المركبة:</span>
                                <span>{{ auth()->user()->deliveryMan->vehicle_type }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-1">
                                <span>رقم المركبة:</span>
                                <span>{{ auth()->user()->deliveryMan->vehicle_number }}</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span>رقم الرخصة:</span>
                                <span>{{ auth()->user()->deliveryMan->license_number }}</span>
                            </div>
                        </div>

                        <hr>

                        <div class="mb-3">
                            <h6 class="fw-bold mb-2">معلومات الاتصال</h6>
                            <div class="d-flex justify-content-between mb-1">
                                <span>الهاتف:</span>
                                <span>{{ auth()->user()->phone }}</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span>الطوارئ:</span>
                                <span>{{ auth()->user()->deliveryMan->emergency_phone }}</span>
                            </div>
                        </div>

                        <hr>

                        <div class="d-grid gap-2">
                            <a href="{{ route('delivery.profile') }}" class="btn btn-outline-primary">
                                <i class="fas fa-edit me-2"></i>
                                تعديل الملف الشخصي
                            </a>
                            <a href="{{ route('delivery.earnings') }}" class="btn btn-outline-success">
                                <i class="fas fa-money-bill-wave me-2"></i>
                                عرض الأرباح
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Map Section -->
<section class="py-5">
    <div class="container">
        <div class="card border-0 shadow-sm" data-aos="fade-up">
            <div class="card-header bg-transparent border-0">
                <h5 class="mb-0">
                    <i class="fas fa-map text-primary me-2"></i>
                    موقعك الحالي
                </h5>
            </div>
            <div class="card-body p-0">
                <div id="map" style="height: 400px; width: 100%;">
                    <!-- Map will be loaded here -->
                    <div class="d-flex align-items-center justify-content-center h-100 bg-light">
                        <div class="text-center">
                            <i class="fas fa-map-marker-alt text-muted" style="font-size: 3rem;"></i>
                            <p class="text-muted mt-3">جاري تحميل الخريطة...</p>
                            <button class="btn btn-primary" onclick="loadMap()">
                                <i class="fas fa-sync-alt me-2"></i>
                                تحديث الموقع
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Recent Activity -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="card border-0 shadow-sm" data-aos="fade-up">
            <div class="card-header bg-transparent border-0">
                <h5 class="mb-0">
                    <i class="fas fa-history text-primary me-2"></i>
                    النشاط الأخير
                </h5>
            </div>
            <div class="card-body p-4">
                @if($recentActivity->count() > 0)
                    <div class="timeline">
                        @foreach($recentActivity as $activity)
                        <div class="timeline-item">
                            <div class="timeline-marker">
                                <i class="fas fa-circle"></i>
                            </div>
                            <div class="timeline-content">
                                <h6 class="fw-bold">{{ $activity->title }}</h6>
                                <p class="text-muted mb-1">{{ $activity->description }}</p>
                                <small class="text-muted">{{ $activity->created_at->diffForHumans() }}</small>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-clock text-muted" style="font-size: 3rem;"></i>
                        <p class="text-muted mt-3">لا يوجد نشاط حديث</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

<style>
.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 15px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: #e9ecef;
}

.timeline-item {
    position: relative;
    margin-bottom: 20px;
    padding-left: 30px;
}

.timeline-item:last-child {
    margin-bottom: 0;
}

.timeline-marker {
    position: absolute;
    left: -22px;
    top: 0;
    width: 30px;
    height: 30px;
    border-radius: 50%;
    background: var(--primary-color);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    z-index: 1;
}

.timeline-content {
    background: white;
    padding: 15px;
    border-radius: 8px;
    border-left: 3px solid var(--primary-color);
}
</style>

<script>
function updateLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            const lat = position.coords.latitude;
            const lng = position.coords.longitude;
            
            // Send location to server
            fetch('{{ route("delivery.update-location") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    lat: lat,
                    lng: lng
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('تم تحديث الموقع بنجاح');
                    loadMap();
                }
            });
        });
    } else {
        alert('متصفحك لا يدعم تحديد الموقع');
    }
}

function toggleStatus() {
    const currentStatus = '{{ auth()->user()->deliveryMan->status }}';
    const newStatus = currentStatus === 'available' ? 'busy' : 'available';
    
    fetch('{{ route("delivery.update-status") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            status: newStatus
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    });
}

function updateOrderStatus(orderId, status) {
    if (confirm('هل أنت متأكد من تحديث حالة الطلب؟')) {
        fetch(`/delivery/orders/${orderId}/status`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                status: status
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        });
    }
}

function loadMap() {
    // Map loading logic here
    console.log('Loading map...');
}
</script>
@endsection 