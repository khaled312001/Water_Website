@extends('layouts.app')

@section('title', 'تفاصيل الطلب - سلسبيل مكة')

<style>
.alert-sm {
    padding: 0.5rem 0.75rem;
    font-size: 0.875rem;
    margin-bottom: 0.5rem;
}
</style>

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 shadow-lg" data-aos="fade-up">
                <div class="card-header bg-primary text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">
                            <i class="fas fa-shopping-bag me-2"></i>
                            تفاصيل الطلب #{{ $order->id }}
                        </h4>
                        <a href="{{ route('orders.index') }}" class="btn btn-light btn-sm">
                            <i class="fas fa-arrow-right me-1"></i>
                            العودة للطلبات
                        </a>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="fw-bold mb-3">معلومات المنتج</h6>
                            <div class="d-flex align-items-center mb-3">
                                @if($order->product->image)
                                    <img src="{{ asset('storage/' . $order->product->image) }}" 
                                         alt="{{ $order->product->name }}" 
                                         class="rounded me-3" 
                                         style="width: 80px; height: 80px; object-fit: cover;">
                                @endif
                                <div>
                                    <h6 class="mb-1">{{ $order->product->name }}</h6>
                                    <p class="text-muted mb-0">{{ $order->supplier->company_name }}</p>
                                    <small class="text-primary">{{ number_format($order->unit_price, 2) }} ريال للوحدة</small>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <strong>الكمية:</strong> {{ $order->quantity }}
                            </div>
                            
                            <div class="mb-3">
                                <strong>السعر الإجمالي:</strong> 
                                <span class="text-primary fw-bold">{{ number_format($order->total_amount, 2) }} ريال</span>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <h6 class="fw-bold mb-3">معلومات التوصيل</h6>
                            <div class="mb-3">
                                <strong>عنوان التوصيل:</strong><br>
                                <span class="text-muted">{{ $order->delivery_address }}</span>
                            </div>
                            
                            @if($order->delivery_notes)
                                <div class="mb-3">
                                    <strong>ملاحظات التوصيل:</strong><br>
                                    <span class="text-muted">{{ $order->delivery_notes }}</span>
                                </div>
                            @endif
                            
                            <div class="mb-3">
                                <strong>تاريخ الطلب:</strong><br>
                                <span class="text-muted">{{ $order->created_at->format('Y-m-d H:i') }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <hr class="my-4">
                    
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="fw-bold mb-3">حالة الطلب</h6>
                            <div class="mb-3">
                                @php
                                    $statusColors = [
                                        'pending_payment' => 'danger',
                                        'pending' => 'warning',
                                        'confirmed' => 'info',
                                        'preparing' => 'primary',
                                        'assigned' => 'secondary',
                                        'picked_up' => 'info',
                                        'delivered' => 'success',
                                        'cancelled' => 'danger'
                                    ];
                                    $statusColor = $statusColors[$order->status] ?? 'secondary';
                                @endphp
                                <span class="badge bg-{{ $statusColor }} fs-6">{{ $order->status_text }}</span>
                            </div>
                            
                            <div class="mb-3">
                                <strong>حالة الدفع:</strong>
                                @if($order->payment)
                                    @php
                                        $paymentStatusColors = [
                                            'pending' => 'warning',
                                            'verified' => 'success',
                                            'failed' => 'danger'
                                        ];
                                        $paymentStatusColor = $paymentStatusColors[$order->payment->status] ?? 'secondary';
                                        $paymentStatusTexts = [
                                            'pending' => 'في انتظار التأكيد',
                                            'verified' => 'مؤكد',
                                            'failed' => 'مرفوض'
                                        ];
                                        $paymentStatusText = $paymentStatusTexts[$order->payment->status] ?? $order->payment->status;
                                    @endphp
                                    <span class="badge bg-{{ $paymentStatusColor }}">{{ $paymentStatusText }}</span>
                                @else
                                    @php
                                        $paymentStatusColors = [
                                            'pending' => 'warning',
                                            'paid' => 'success',
                                            'failed' => 'danger'
                                        ];
                                        $paymentStatusColor = $paymentStatusColors[$order->payment_status] ?? 'secondary';
                                    @endphp
                                    <span class="badge bg-{{ $paymentStatusColor }}">{{ $order->payment_status_text }}</span>
                                @endif
                            </div>

                            @if($order->payment)
                                <div class="mb-3">
                                    <strong>طريقة الدفع:</strong>
                                    <span class="badge bg-info">{{ $order->payment->payment_method_text }}</span>
                                </div>
                            @endif

                        <!-- Order Status Updates -->
                        <div class="mb-3">
                            <strong>آخر تحديث:</strong>
                            <span id="lastUpdate" class="text-muted">{{ $order->updated_at->diffForHumans() }}</span>
                            <button type="button" class="btn btn-sm btn-outline-primary ms-2" onclick="updateOrderStatus()">
                                <i class="fas fa-sync-alt"></i>
                                تحديث
                            </button>
                        </div>

                        <!-- Status History -->
                        <div class="mb-3">
                            <strong>سجل التحديثات:</strong>
                            <div id="statusHistory" class="mt-2">
                                <div class="alert alert-info alert-sm">
                                    <i class="fas fa-info-circle me-1"></i>
                                    <strong>{{ $order->status_text }}</strong> - {{ $order->updated_at->format('Y-m-d H:i') }}
                                </div>
                            </div>
                        </div>
                                
                                @if($order->payment && $order->payment->status === 'pending')
                                    <div id="paymentAlert" class="alert alert-warning">
                                        <i class="fas fa-clock me-2"></i>
                                        في انتظار تأكيد عملية الدفع من الإدارة
                                        @if($order->payment->payment_method === 'bank_transfer')
                                            <br><small>يرجى إرفاق إيصال التحويل البنكي</small>
                                        @endif
                                    </div>
                                @elseif($order->payment && $order->payment->status === 'verified')
                                    <div id="paymentAlert" class="alert alert-success">
                                        <i class="fas fa-check-circle me-2"></i>
                                        تم تأكيد الدفع من الإدارة بنجاح
                                    </div>
                                @elseif($order->payment && $order->payment->status === 'failed')
                                    <div id="paymentAlert" class="alert alert-danger">
                                        <i class="fas fa-times-circle me-2"></i>
                                        تم رفض الدفع من الإدارة
                                        @if($order->payment->notes)
                                            <br><small>السبب: {{ $order->payment->notes }}</small>
                                        @endif
                                    </div>
                                @endif
                        </div>
                        
                        <div class="col-md-6">
                            <h6 class="fw-bold mb-3">معلومات المندوب</h6>
                            @if($order->deliveryMan)
                                <div class="mb-2">
                                    <strong>اسم المندوب:</strong> {{ $order->deliveryMan->user->name }}
                                </div>
                                <div class="mb-2">
                                    <strong>رقم الهاتف:</strong> {{ $order->deliveryMan->user->phone }}
                                </div>
                            @else
                                <p class="text-muted">لم يتم تعيين مندوب بعد</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="card border-0 shadow-lg" data-aos="fade-up" data-aos-delay="200">
                <div class="card-header bg-info text-white">
                    <h6 class="mb-0">
                        <i class="fas fa-truck me-2"></i>
                        تتبع الطلب
                    </h6>
                </div>
                <div class="card-body">
                    <a href="{{ route('orders.track', $order->id) }}" class="btn btn-info w-100 mb-3">
                        <i class="fas fa-map-marker-alt me-2"></i>
                        تتبع الطلب
                    </a>
                    
                    <div class="d-grid gap-2">
                        @if($order->status === 'pending_payment')
                            <a href="{{ route('payments.new-order', $order->id) }}" class="btn btn-danger">
                                <i class="fas fa-credit-card me-2"></i>
                                إتمام الدفع لتأكيد الطلب
                            </a>
                        @elseif(!$order->payment || $order->payment->status === 'pending')
                            <a href="{{ route('payments.show', $order->id) }}" class="btn btn-primary">
                                <i class="fas fa-credit-card me-2"></i>
                                إتمام الدفع
                            </a>
                        @endif
                        
                        <a href="{{ route('orders.index') }}" class="btn btn-outline-primary">
                            <i class="fas fa-list me-2"></i>
                            جميع الطلبات
                        </a>
                        <a href="{{ route('orders.create') }}" class="btn btn-outline-success">
                            <i class="fas fa-plus me-2"></i>
                            طلب جديد
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Auto-refresh order status every 30 seconds
let refreshInterval;

function startAutoRefresh() {
    refreshInterval = setInterval(function() {
        updateOrderStatus();
    }, 10000); // 10 seconds for faster updates
}

function updateOrderStatus() {
    fetch(`/api/orders/{{ $order->id }}/status`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update status badge
                const statusBadge = document.querySelector('.badge.bg-' + getStatusColor('{{ $order->status }}'));
                if (statusBadge) {
                    statusBadge.textContent = data.order.status_text;
                    statusBadge.className = 'badge bg-' + getStatusColor(data.order.status) + ' fs-6';
                }

                // Update last update time
                const lastUpdate = document.getElementById('lastUpdate');
                if (lastUpdate) {
                    lastUpdate.textContent = data.order.updated_at_diff;
                }

                // Update delivery man info if available
                if (data.order.delivery_man) {
                    const deliveryManInfo = document.querySelector('.col-md-6:last-child');
                    if (deliveryManInfo) {
                        const deliveryManSection = deliveryManInfo.querySelector('h6 + div');
                        if (deliveryManSection) {
                            deliveryManSection.innerHTML = `
                                <div class="mb-2">
                                    <strong>اسم المندوب:</strong> ${data.order.delivery_man.user.name}
                                </div>
                                <div class="mb-2">
                                    <strong>رقم الهاتف:</strong> ${data.order.delivery_man.user.phone}
                                </div>
                            `;
                        }
                    }
                }

                // Update payment status if available
                if (data.order.payment) {
                    updatePaymentStatus(data.order.payment);
                    updatePaymentButtons(data.order.payment);
                }

                // Show notification if status changed
                if (data.order.status !== '{{ $order->status }}') {
                    showNotification(`تم تحديث حالة الطلب إلى: ${data.order.status_text}`, 'success');
                    
                    // Update page title with notification
                    const originalTitle = document.title;
                    document.title = `🔔 ${data.order.status_text} - ${originalTitle}`;
                    setTimeout(() => {
                        document.title = originalTitle;
                    }, 3000);
                    
                    // Add to status history
                    const statusHistory = document.getElementById('statusHistory');
                    if (statusHistory) {
                        const newStatus = document.createElement('div');
                        newStatus.className = 'alert alert-success alert-sm';
                        newStatus.innerHTML = `
                            <i class="fas fa-check-circle me-1"></i>
                            <strong>${data.order.status_text}</strong> - ${data.order.updated_at_diff}
                        `;
                        statusHistory.insertBefore(newStatus, statusHistory.firstChild);
                    }
                }

                // Show notification if payment status changed
                if (data.order.payment && data.order.payment.status !== '{{ $order->payment->status ?? "none" }}') {
                    let paymentMessage = '';
                    if (data.order.payment.status === 'verified') {
                        paymentMessage = 'تم تأكيد الدفع من الإدارة بنجاح';
                        // Update page title with notification
                        const originalTitle = document.title;
                        document.title = `🔔 تم تأكيد الدفع - ${originalTitle}`;
                        setTimeout(() => {
                            document.title = originalTitle;
                        }, 3000);
                    } else if (data.order.payment.status === 'failed') {
                        paymentMessage = 'تم رفض الدفع من الإدارة';
                    }
                    
                    if (paymentMessage) {
                        showNotification(paymentMessage, 'success');
                        
                        // Add to status history
                        const statusHistory = document.getElementById('statusHistory');
                        if (statusHistory) {
                            const newStatus = document.createElement('div');
                            newStatus.className = 'alert alert-success alert-sm';
                            newStatus.innerHTML = `
                                <i class="fas fa-check-circle me-1"></i>
                                <strong>${paymentMessage}</strong> - ${data.order.updated_at_diff}
                            `;
                            statusHistory.insertBefore(newStatus, statusHistory.firstChild);
                        }
                    }
                }
            }
        })
        .catch(error => {
            console.error('Error updating order status:', error);
        });
}

function getStatusColor(status) {
    const statusColors = {
        'pending_payment': 'danger',
        'pending': 'warning',
        'confirmed': 'info',
        'preparing': 'primary',
        'assigned': 'secondary',
        'picked_up': 'info',
        'delivered': 'success',
        'cancelled': 'danger'
    };
    return statusColors[status] || 'secondary';
}

function updatePaymentStatus(payment) {
    // Find the payment alert by ID
    const paymentAlert = document.getElementById('paymentAlert');
    
    if (paymentAlert) {
        // Update existing alert
        if (payment.status === 'pending') {
            paymentAlert.className = 'alert alert-warning';
            paymentAlert.innerHTML = `
                <i class="fas fa-clock me-2"></i>
                في انتظار تأكيد عملية الدفع من الإدارة
                ${payment.payment_method === 'bank_transfer' ? '<br><small>يرجى إرفاق إيصال التحويل البنكي</small>' : ''}
            `;
        } else if (payment.status === 'verified') {
            paymentAlert.className = 'alert alert-success';
            paymentAlert.innerHTML = `
                <i class="fas fa-check-circle me-2"></i>
                تم تأكيد الدفع من الإدارة بنجاح
            `;
        } else if (payment.status === 'failed') {
            paymentAlert.className = 'alert alert-danger';
            paymentAlert.innerHTML = `
                <i class="fas fa-times-circle me-2"></i>
                تم رفض الدفع من الإدارة
                ${payment.notes ? `<br><small>السبب: ${payment.notes}</small>` : ''}
            `;
        }
    } else {
        // Create new alert if it doesn't exist
        const paymentSection = document.querySelector('.col-md-6:first-child');
        if (!paymentSection) return;

        let alertHtml = '';
        if (payment.status === 'pending') {
            alertHtml = `
                <div id="paymentAlert" class="alert alert-warning">
                    <i class="fas fa-clock me-2"></i>
                    في انتظار تأكيد عملية الدفع من الإدارة
                    ${payment.payment_method === 'bank_transfer' ? '<br><small>يرجى إرفاق إيصال التحويل البنكي</small>' : ''}
                </div>
            `;
        } else if (payment.status === 'verified') {
            alertHtml = `
                <div id="paymentAlert" class="alert alert-success">
                    <i class="fas fa-check-circle me-2"></i>
                    تم تأكيد الدفع من الإدارة بنجاح
                </div>
            `;
        } else if (payment.status === 'failed') {
            alertHtml = `
                <div id="paymentAlert" class="alert alert-danger">
                    <i class="fas fa-times-circle me-2"></i>
                    تم رفض الدفع من الإدارة
                    ${payment.notes ? `<br><small>السبب: ${payment.notes}</small>` : ''}
                </div>
            `;
        }

        if (alertHtml) {
            // Insert the new alert after the payment status section
            const paymentStatusSection = paymentSection.querySelector('.mb-3:has(.badge)');
            if (paymentStatusSection) {
                paymentStatusSection.insertAdjacentHTML('afterend', alertHtml);
            } else {
                // If not found, append to the end of the first column
                paymentSection.insertAdjacentHTML('beforeend', alertHtml);
            }
        }
    }
}

function updatePaymentButtons(payment) {
    // Find the payment buttons section
    const buttonsSection = document.querySelector('.d-grid.gap-2');
    if (!buttonsSection) return;

    // Remove existing payment buttons
    const existingButtons = buttonsSection.querySelectorAll('a[href*="payments"]');
    existingButtons.forEach(button => button.remove());

    // Add new payment button based on status
    let buttonHtml = '';
    if (payment.status === 'pending') {
        buttonHtml = `
            <a href="/payments/${payment.order_id}" class="btn btn-primary">
                <i class="fas fa-credit-card me-2"></i>
                إتمام الدفع
            </a>
        `;
    }

    if (buttonHtml) {
        // Insert at the beginning of the buttons section
        buttonsSection.insertAdjacentHTML('afterbegin', buttonHtml);
    }
}

function showNotification(message, type) {
    const alertClass = type === 'success' ? 'alert-success' : 'alert-info';
    const icon = type === 'success' ? 'fa-check-circle' : 'fa-info-circle';
    
    // Play notification sound for status changes
    if (type === 'success') {
        playNotificationSound();
    }
    
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

function playNotificationSound() {
    // Create a simple notification sound using Web Audio API
    try {
        const audioContext = new (window.AudioContext || window.webkitAudioContext)();
        const oscillator = audioContext.createOscillator();
        const gainNode = audioContext.createGain();
        
        oscillator.connect(gainNode);
        gainNode.connect(audioContext.destination);
        
        oscillator.frequency.setValueAtTime(800, audioContext.currentTime);
        oscillator.frequency.setValueAtTime(600, audioContext.currentTime + 0.1);
        
        gainNode.gain.setValueAtTime(0.1, audioContext.currentTime);
        gainNode.gain.exponentialRampToValueAtTime(0.01, audioContext.currentTime + 0.2);
        
        oscillator.start(audioContext.currentTime);
        oscillator.stop(audioContext.currentTime + 0.2);
    } catch (error) {
        console.log('Audio notification not supported');
    }
}

function toggleAutoRefresh() {
    const button = document.getElementById('autoRefreshToggle');
    const icon = button.querySelector('i');
    
    if (refreshInterval) {
        // Stop auto-refresh
        clearInterval(refreshInterval);
        refreshInterval = null;
        icon.className = 'fas fa-play';
        button.innerHTML = '<i class="fas fa-play"></i> تشغيل التحديث';
        button.className = 'btn btn-sm btn-outline-success ms-1';
        showNotification('تم إيقاف التحديث التلقائي', 'info');
    } else {
        // Start auto-refresh
        startAutoRefresh();
        icon.className = 'fas fa-pause';
        button.innerHTML = '<i class="fas fa-pause"></i> إيقاف التحديث';
        button.className = 'btn btn-sm btn-outline-warning ms-1';
        showNotification('تم تشغيل التحديث التلقائي', 'success');
    }
}

// Start auto-refresh when page loads
document.addEventListener('DOMContentLoaded', function() {
    // Update immediately when page loads
    updateOrderStatus();
    
    // Start auto-refresh
    startAutoRefresh();
    
    // Stop auto-refresh when page is hidden
    document.addEventListener('visibilitychange', function() {
        if (document.hidden) {
            clearInterval(refreshInterval);
        } else {
            startAutoRefresh();
        }
    });
});
</script>
@endsection 