<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'لوحة تحكم مندوب التوصيل - سلسبيل مكة')</title>
    
    <!-- Bootstrap RTL CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <style>
        :root {
            --primary-color: #dc2626;
            --secondary-color: #ef4444;
            --success-color: #059669;
            --warning-color: #d97706;
            --danger-color: #dc2626;
            --info-color: #0891b2;
            --light-color: #f8fafc;
            --dark-color: #1e293b;
            --sidebar-width: 280px;
            --header-height: 70px;
        }

        * {
            font-family: 'Cairo', sans-serif;
        }

        body {
            background-color: #f1f5f9;
            margin: 0;
            padding: 0;
        }

        /* Sidebar Styles */
        .delivery-sidebar {
            position: fixed;
            top: 0;
            right: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: linear-gradient(135deg, var(--primary-color) 0%, #b91c1c 100%);
            color: white;
            z-index: 1000;
            transition: all 0.3s ease;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
            overflow: hidden;
        }

        .sidebar-header {
            padding: 1.5rem;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            text-align: center;
            position: relative;
        }

        .sidebar-header h3 {
            margin: 0;
            font-weight: 600;
            font-size: 1.25rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .sidebar-header p {
            margin: 0.5rem 0 0 0;
            opacity: 0.8;
            font-size: 0.875rem;
        }

        .sidebar-close {
            position: absolute;
            top: 1rem;
            left: 1rem;
            background: rgba(255,255,255,0.1);
            border: none;
            color: white;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: none;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .sidebar-close:hover {
            background: rgba(255,255,255,0.2);
        }

        .sidebar-menu {
            padding: 1rem 0;
            overflow-y: auto;
            height: calc(100vh - 200px);
            scrollbar-width: thin;
            scrollbar-color: rgba(255,255,255,0.3) transparent;
        }

        .sidebar-menu::-webkit-scrollbar {
            width: 4px;
        }

        .sidebar-menu::-webkit-scrollbar-track {
            background: transparent;
        }

        .sidebar-menu::-webkit-scrollbar-thumb {
            background: rgba(255,255,255,0.3);
            border-radius: 2px;
        }

        .sidebar-menu::-webkit-scrollbar-thumb:hover {
            background: rgba(255,255,255,0.5);
        }

        .sidebar-menu .nav-link {
            color: rgba(255,255,255,0.8);
            padding: 0.875rem 1.5rem;
            display: flex;
            align-items: center;
            transition: all 0.3s ease;
            border: none;
            background: transparent;
            width: 100%;
            text-align: right;
            position: relative;
            margin: 0.25rem 0;
        }

        .sidebar-menu .nav-link:hover,
        .sidebar-menu .nav-link.active {
            color: white;
            background: rgba(255,255,255,0.15);
            transform: translateX(-5px);
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .sidebar-menu .nav-link.active::before {
            content: '';
            position: absolute;
            right: 0;
            top: 0;
            bottom: 0;
            width: 4px;
            background: white;
            border-radius: 0 2px 2px 0;
        }

        .sidebar-menu .nav-link i {
            margin-left: 0.75rem;
            width: 20px;
            text-align: center;
            font-size: 1.1rem;
        }

        .sidebar-menu .nav-link .badge {
            margin-right: auto;
            background: rgba(255,255,255,0.2);
            color: white;
            font-size: 0.7rem;
            padding: 0.25rem 0.5rem;
        }

        .sidebar-footer {
            position: absolute;
            bottom: 0;
            width: 100%;
            padding: 1rem 1.5rem;
            border-top: 1px solid rgba(255,255,255,0.1);
            background: rgba(0,0,0,0.1);
            backdrop-filter: blur(10px);
        }

        .sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 999;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }

        .sidebar-overlay.show {
            opacity: 1;
            visibility: visible;
        }

        /* Main Content */
        .delivery-main {
            margin-right: var(--sidebar-width);
            min-height: 100vh;
            transition: all 0.3s ease;
        }

        /* Header */
        .delivery-header {
            background: white;
            height: var(--header-height);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 2rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.5rem 1rem;
            background: var(--light-color);
            border-radius: 50px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .user-info:hover {
            background: #e2e8f0;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--primary-color);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
        }

        /* Content Area */
        .delivery-content {
            padding: 2rem;
        }

        /* Cards */
        .stat-card {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            border: 1px solid #e2e8f0;
            transition: all 0.3s ease;
            height: 100%;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }

        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .stat-label {
            color: var(--secondary-color);
            font-size: 0.875rem;
            margin-bottom: 0.5rem;
        }

        .stat-change {
            font-size: 0.75rem;
            font-weight: 500;
        }

        /* Tables */
        .delivery-table {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            border: 1px solid #e2e8f0;
        }

        .delivery-table .table {
            margin: 0;
        }

        .delivery-table .table th {
            background: #f8fafc;
            border: none;
            padding: 1rem;
            font-weight: 600;
            color: var(--dark-color);
        }

        .delivery-table .table td {
            padding: 1rem;
            border: none;
            border-bottom: 1px solid #e2e8f0;
            vertical-align: middle;
        }

        /* Buttons */
        .btn-delivery {
            border-radius: 10px;
            padding: 0.5rem 1rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-delivery:hover {
            transform: translateY(-2px);
        }

        /* Badges */
        .badge-delivery {
            padding: 0.5rem 0.75rem;
            border-radius: 8px;
            font-size: 0.75rem;
            font-weight: 500;
        }

        /* Responsive */
        @media (max-width: 768px) {
            :root {
                --sidebar-width: 280px;
            }

            .delivery-sidebar {
                transform: translateX(100%);
                width: 100%;
                max-width: 320px;
            }

            .delivery-sidebar.show {
                transform: translateX(0);
            }

            .delivery-main {
                margin-right: 0;
            }

            .sidebar-toggle {
                display: block !important;
            }

            .sidebar-close {
                display: flex !important;
            }

            .sidebar-header h3 {
                font-size: 1.1rem;
            }

            .sidebar-menu .nav-link {
                padding: 1rem 1.5rem;
                font-size: 1rem;
            }

            .sidebar-menu .nav-link i {
                font-size: 1.2rem;
            }
        }

        @media (max-width: 576px) {
            .delivery-sidebar {
                width: 100%;
                max-width: none;
            }

            .sidebar-header {
                padding: 1rem;
            }

            .sidebar-menu {
                padding: 0.5rem 0;
            }

            .sidebar-menu .nav-link {
                padding: 0.875rem 1rem;
            }

            .sidebar-footer {
                padding: 0.75rem 1rem;
            }
        }

        /* Animations */
        .fade-in {
            animation: fadeIn 0.5s ease-in;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Charts */
        .chart-container {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            border: 1px solid #e2e8f0;
        }

        /* Quick Actions */
        .quick-actions {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
        }

        .action-card {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            border: 1px solid #e2e8f0;
            transition: all 0.3s ease;
            text-decoration: none;
            color: inherit;
        }

        .action-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            text-decoration: none;
            color: inherit;
        }

        .action-icon {
            width: 60px;
            height: 60px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin: 0 auto 1rem;
        }
    </style>
</head>
<body>
    <!-- Sidebar Overlay -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Sidebar -->
    <div class="delivery-sidebar" id="deliverySidebar">
        <div class="sidebar-header">
            <button class="sidebar-close" id="sidebarClose">
                <i class="fas fa-times"></i>
            </button>
            <h3><i class="fas fa-truck me-2"></i>سلسبيل مكة</h3>
            <p>لوحة تحكم مندوب التوصيل</p>
        </div>
        
        <div class="sidebar-menu">
            <nav class="nav flex-column">
                <a href="{{ route('delivery.dashboard') }}" class="nav-link {{ request()->routeIs('delivery.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt"></i>
                    لوحة التحكم
                </a>
                <a href="{{ route('delivery.orders') }}" class="nav-link {{ request()->routeIs('delivery.orders') ? 'active' : '' }}">
                    <i class="fas fa-shopping-cart"></i>
                    الطلبات
                </a>
                <a href="{{ route('delivery.earnings') }}" class="nav-link {{ request()->routeIs('delivery.earnings') ? 'active' : '' }}">
                    <i class="fas fa-money-bill-wave"></i>
                    الأرباح
                </a>
                <a href="{{ route('delivery.profile') }}" class="nav-link {{ request()->routeIs('delivery.profile') ? 'active' : '' }}">
                    <i class="fas fa-user-cog"></i>
                    الملف الشخصي
                </a>
                <a href="{{ route('delivery.location') }}" class="nav-link {{ request()->routeIs('delivery.location') ? 'active' : '' }}">
                    <i class="fas fa-map-marker-alt"></i>
                    تحديث الموقع
                </a>
            </nav>
        </div>
        
        <div class="sidebar-footer">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <small class="d-block opacity-75">{{ auth()->user()->name }}</small>
                    <small class="d-block opacity-50">مندوب توصيل</small>
                </div>
                <a href="{{ route('logout') }}" class="btn btn-outline-light btn-sm" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="delivery-main">
        <!-- Header -->
        <header class="delivery-header">
            <div class="header-left">
                <button class="btn btn-link d-md-none sidebar-toggle">
                    <i class="fas fa-bars"></i>
                </button>
                <h4 class="mb-0">@yield('page-title', 'لوحة التحكم')</h4>
            </div>
            
            <div class="header-right">
                <a href="{{ route('home') }}" class="btn btn-outline-danger me-3" title="الذهاب إلى الموقع">
                    <i class="fas fa-external-link-alt me-1"></i>
                    الذهاب إلى الموقع
                </a>
                <div class="user-info">
                    <div class="user-avatar">
                        @if(auth()->user()->profile_image)
                            <img src="{{ asset('storage/' . auth()->user()->profile_image) }}" alt="صورة المستخدم" class="rounded-circle" style="width: 100%; height: 100%; object-fit: cover;">
                        @else
                            {{ substr(auth()->user()->name, 0, 1) }}
                        @endif
                    </div>
                    <div>
                        <div class="fw-bold">{{ auth()->user()->name }}</div>
                        <small class="text-muted">مندوب توصيل</small>
                    </div>
                </div>
            </div>
        </header>

        <!-- Content -->
        <main class="delivery-content">
            <!-- Success Messages -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Error Messages -->
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <!-- Logout Form -->
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Enhanced sidebar functionality
        const sidebar = document.getElementById('deliverySidebar');
        const sidebarToggle = document.querySelector('.sidebar-toggle');
        const sidebarClose = document.getElementById('sidebarClose');
        const sidebarOverlay = document.getElementById('sidebarOverlay');

        // Toggle sidebar
        sidebarToggle?.addEventListener('click', function() {
            sidebar.classList.add('show');
            sidebarOverlay.classList.add('show');
            document.body.style.overflow = 'hidden';
        });

        // Close sidebar
        function closeSidebar() {
            sidebar.classList.remove('show');
            sidebarOverlay.classList.remove('show');
            document.body.style.overflow = '';
        }

        sidebarClose?.addEventListener('click', closeSidebar);
        sidebarOverlay?.addEventListener('click', closeSidebar);

        // Close sidebar on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && sidebar.classList.contains('show')) {
                closeSidebar();
            }
        });

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(e) {
            if (window.innerWidth <= 768) {
                if (!sidebar.contains(e.target) && !sidebarToggle.contains(e.target)) {
                    closeSidebar();
                }
            }
        });

        // Handle window resize
        window.addEventListener('resize', function() {
            if (window.innerWidth > 768) {
                closeSidebar();
            }
        });

        // Add fade-in animation to content
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelector('.delivery-content').classList.add('fade-in');
            
            // Add hover effects to menu items
            const menuItems = document.querySelectorAll('.sidebar-menu .nav-link');
            menuItems.forEach(item => {
                item.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateX(-5px) scale(1.02)';
                });
                
                item.addEventListener('mouseleave', function() {
                    this.style.transform = '';
                });
            });
        });

        // Add notification badges (example)
        function addNotificationBadge(menuItem, count) {
            const badge = document.createElement('span');
            badge.className = 'badge';
            badge.textContent = count;
            menuItem.appendChild(badge);
        }

        // Example: Add notification badges to menu items
        // addNotificationBadge(document.querySelector('a[href*="orders"]'), 5);
        // addNotificationBadge(document.querySelector('a[href*="earnings"]'), 3);
    </script>

    @yield('scripts')
</body>
</html> 