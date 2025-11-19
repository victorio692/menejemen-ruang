<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title', 'Dashboard'); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-color: #f7f9fc;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        /* ==================== BUTTON STYLES ==================== */
        .btn {
            transition: all 0.3s ease;
            font-weight: 600;
            border: none;
            border-radius: 8px;
            padding: 10px 18px;
            font-size: 14px;
            position: relative;
            overflow: hidden;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.15);
        }

        .btn:active {
            transform: translateY(0);
        }

        /* Primary Button */
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #5568d3 0%, #6a4290 100%);
            color: white;
        }

        .btn-primary:focus {
            background: linear-gradient(135deg, #5568d3 0%, #6a4290 100%);
            color: white;
            box-shadow: 0 0 0 0.25rem rgba(102, 126, 234, 0.5);
        }

        /* Success Button */
        .btn-success {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            border: none;
        }

        .btn-success:hover {
            background: linear-gradient(135deg, #0d8678 0%, #2ed66a 100%);
            color: white;
        }

        .btn-success:focus {
            background: linear-gradient(135deg, #0d8678 0%, #2ed66a 100%);
            color: white;
            box-shadow: 0 0 0 0.25rem rgba(17, 153, 142, 0.5);
        }

        /* Danger Button */
        .btn-danger {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            border: none;
        }

        .btn-danger:hover {
            background: linear-gradient(135deg, #ee7ae1 0%, #f44050 100%);
            color: white;
        }

        .btn-danger:focus {
            background: linear-gradient(135deg, #ee7ae1 0%, #f44050 100%);
            color: white;
            box-shadow: 0 0 0 0.25rem rgba(245, 87, 108, 0.5);
        }

        /* Secondary Button */
        .btn-secondary {
            background: linear-gradient(135deg, #868f96 0%, #596164 100%);
            border: none;
        }

        .btn-secondary:hover {
            background: linear-gradient(135deg, #707980 0%, #484b50 100%);
            color: white;
        }

        .btn-secondary:focus {
            background: linear-gradient(135deg, #707980 0%, #484b50 100%);
            color: white;
            box-shadow: 0 0 0 0.25rem rgba(134, 143, 150, 0.5);
        }

        /* Info Button */
        .btn-info {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            border: none;
        }

        .btn-info:hover {
            background: linear-gradient(135deg, #3f96e8 0%, #00d5e8 100%);
            color: white;
        }

        /* Warning Button */
        .btn-warning {
            background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
            border: none;
            color: white;
        }

        .btn-warning:hover {
            background: linear-gradient(135deg, #f85882 0%, #fdd130 100%);
            color: white;
        }

        /* Small Button */
        .btn-sm {
            padding: 6px 12px;
            font-size: 12px;
        }

        /* Large Button */
        .btn-lg {
            padding: 14px 32px;
            font-size: 16px;
            border-radius: 10px;
        }

        /* Outline Buttons */
        .btn-outline-primary {
            border: 2px solid #667eea;
            background: transparent;
            color: #667eea;
        }

        .btn-outline-primary:hover {
            background: #667eea;
            color: white;
        }

        /* Button Group Responsive */
        .btn-group-responsive {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        @media (max-width: 576px) {
            .btn {
                padding: 8px 14px;
                font-size: 13px;
            }

            .btn-sm {
                padding: 5px 10px;
                font-size: 11px;
            }

            .btn-lg {
                padding: 12px 24px;
                font-size: 14px;
            }

            .btn-group-responsive {
                flex-direction: column;
            }

            .btn-block, .w-100 {
                width: 100% !important;
            }
        }

        /* Icon Button Spacing */
        .btn i {
            margin-right: 4px;
        }

        .btn i:last-child {
            margin-right: 0;
        }

        /* ==================== END BUTTON STYLES ==================== */

        /* ==================== UTILITY CLASSES ==================== */
        
        /* Flex utilities for responsive layout */
        @media (min-width: 768px) {
            .flex-md-grow-1 {
                flex: 1;
            }

            .align-md-items-center {
                align-items: center;
            }

            .flex-md-row {
                flex-direction: row;
            }

            .d-md-flex {
                display: flex !important;
            }

            .gap-md-3 {
                gap: 1rem;
            }
        }

        /* Card hover effects */
        .card {
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12) !important;
        }

        /* Form focus states */
        .form-control:focus, .form-select:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }

        /* Table striped */
        .table-hover tbody tr:hover {
            background-color: rgba(102, 126, 234, 0.1);
        }

        /* Badge styling */
        .badge {
            padding: 6px 12px;
            border-radius: 6px;
            font-weight: 500;
            font-size: 12px;
        }

        /* Alert styling */
        .alert {
            border-radius: 8px;
            border: none;
            padding: 15px 20px;
        }

        /* Modal improvements */
        .modal-content {
            border-radius: 12px;
            border: none;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        }

        .modal-header {
            border-bottom: 1px solid #e9ecef;
            background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
        }

        /* List group improvements */
        .list-group-item {
            border: 1px solid #e9ecef;
        }

        .list-group-item:hover {
            background-color: #f8f9fa;
        }

        /* ==================== END UTILITY CLASSES ==================== */

        /* Sidebar Styles */
        .sidebar {
            width: 260px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            position: fixed !important;
            left: 0 !important;
            top: 0 !important;
            padding: 20px;
            color: white;
            overflow-y: auto;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
            z-index: 1000 !important;
            display: block !important; /* Force display to prevent hiding */
            visibility: visible !important;
            opacity: 1 !important;
        }

        /* Ensure sidebar always visible on desktop */
        @media (min-width: 992px) {
            .sidebar {
                display: block !important;
                position: fixed !important;
                left: 0 !important;
                visibility: visible !important;
                opacity: 1 !important;
            }
            
            .sidebar.active {
                display: block !important;
                visibility: visible !important;
                opacity: 1 !important;
            }
        }
                visibility: visible !important;
            }
        }

        .sidebar-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }

        .sidebar-logo {
            width: 45px;
            height: 45px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            font-weight: bold;
        }

        .sidebar-title {
            font-size: 18px;
            font-weight: 700;
            margin: 0;
        }

        .sidebar-subtitle {
            font-size: 12px;
            opacity: 0.8;
        }

        .nav-section {
            margin-bottom: 25px;
        }

        .nav-section-title {
            font-size: 12px;
            text-transform: uppercase;
            opacity: 0.7;
            font-weight: 600;
            margin-bottom: 10px;
            padding: 0 10px;
            letter-spacing: 0.5px;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 15px;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.3s ease;
            margin-bottom: 6px;
            font-size: 14px;
            font-weight: 500;
        }

        .nav-item:hover {
            background: rgba(255, 255, 255, 0.15);
            color: white;
            transform: translateX(5px);
        }

        .nav-item.active {
            background: rgba(255, 255, 255, 0.25);
            color: white;
            border-left: 3px solid white;
        }

        .nav-icon {
            font-size: 18px;
            width: 24px;
            text-align: center;
        }

        /* Main Content Area */
        .main-wrapper {
            margin-left: 260px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* When no sidebar (for user) */
        .main-wrapper.no-sidebar {
            margin-left: 0;
        }

        /* Navbar */
        .navbar-custom {
            background: white;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            padding: 15px 30px;
            position: sticky;
            top: 0;
            z-index: 999;
        }

        .navbar-brand {
            font-size: 20px;
            font-weight: 700;
            color: #667eea !important;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 8px 12px;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .user-profile:hover {
            background-color: #f0f0f0;
        }

        .user-info {
            text-align: right;
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .user-name {
            font-weight: 600;
            color: #333;
            font-size: 14px;
        }

        .user-role {
            font-size: 12px;
            color: #999;
            text-transform: capitalize;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea, #764ba2);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
        }

        /* Content Area */
        .content-area {
            flex: 1;
            padding: 30px;
        }

        .card-custom {
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .btn-modern {
            border-radius: 50px;
        }

        table th,
        table td {
            vertical-align: middle !important;
        }

        /* Mobile Responsive */
        @media (max-width: 992px) {
            .sidebar {
                width: 260px;
                position: fixed;
                left: -260px;
                transition: left 0.3s ease;
                height: 100vh;
            }

            .sidebar.active {
                left: 0;
            }

            .main-wrapper {
                margin-left: 0;
            }

            .sidebar-overlay {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(0, 0, 0, 0.5);
                z-index: 999;
            }

            .sidebar-overlay.active {
                display: block;
            }

            .toggle-sidebar-btn {
                display: flex;
                align-items: center;
                justify-content: center;
                width: 40px;
                height: 40px;
                background: #667eea;
                color: white;
                border: none;
                border-radius: 8px;
                cursor: pointer;
                font-size: 20px;
                transition: all 0.3s ease;
            }

            .toggle-sidebar-btn:hover {
                background: #764ba2;
            }

            .navbar-custom {
                padding: 12px 15px;
            }

            .navbar-brand {
                font-size: 16px;
            }

            .user-info {
                display: none;
            }

            .user-avatar {
                width: 35px;
                height: 35px;
                font-size: 14px;
            }

            .content-area {
                padding: 15px;
            }

            .stat-card {
                padding: 16px;
            }

            /* Responsive Form */
            .form-label {
                font-size: 13px;
            }

            .form-control, .form-select {
                padding: 8px 12px;
                font-size: 13px;
            }

            /* Responsive Cards */
            .card {
                margin-bottom: 15px;
            }

            .card-header {
                padding: 12px 15px;
                font-size: 14px;
            }

            .card-body {
                padding: 15px;
            }

            /* Table Responsive */
            .table {
                font-size: 13px;
                margin-bottom: 0;
            }

            .table th, .table td {
                padding: 8px 6px;
            }

            /* Responsive Grid */
            .row {
                margin-right: -7.5px;
                margin-left: -7.5px;
            }

            .col-12, .col-md-6, .col-md-4, .col-md-3 {
                padding-right: 7.5px;
                padding-left: 7.5px;
                margin-bottom: 15px;
            }

            /* Modal Responsive */
            .modal-dialog {
                margin: 10px auto;
            }

            .modal-header {
                padding: 12px 15px;
            }

            .modal-body {
                padding: 15px;
            }
        }

        /* Tablet Responsive */
        @media (min-width: 768px) and (max-width: 992px) {
            .main-wrapper {
                margin-left: 0;
            }

            .content-area {
                padding: 20px;
            }

            .btn-group-responsive {
                gap: 8px;
            }
        }

        /* Desktop - Sidebar always visible */
        @media (min-width: 993px) {
            .toggle-sidebar-btn {
                display: none !important;
            }

            .main-wrapper {
                margin-left: 260px;
                transition: margin-left 0.3s ease;
            }

            .content-area {
                padding: 30px;
            }

            .navbar-custom {
                padding: 15px 20px;
            }

            .card-header {
                padding: 15px 20px;
            }

            .card-body {
                padding: 20px;
            }

            .table th, .table td {
                padding: 12px 10px;
            }

            .btn-group-responsive {
                gap: 12px;
            }
        }

        /* Large Desktop */
        @media (min-width: 1200px) {
            .container-fluid {
                max-width: 1400px;
                margin: 0 auto;
            }

            .content-area {
                padding: 40px;
            }
        }

        /* Ultra-wide screens */
        @media (min-width: 1400px) {
            .sidebar {
                width: 280px;
            }

            .main-wrapper {
                margin-left: 280px;
            }

            .container-fluid {
                max-width: 1600px;
            }
        }

            .stat-number {
                font-size: 24px;
            }
        }

        @media (max-width: 576px) {
            .navbar-custom {
                padding: 10px 12px;
            }

            .navbar-brand {
                font-size: 14px;
            }

            .content-area {
                padding: 10px;
            }

            .user-profile {
                gap: 5px;
            }

            .user-profile span {
                display: none;
            }

            .stat-card {
                padding: 12px;
            }

            .stat-number {
                font-size: 20px;
            }

            .stat-label {
                font-size: 12px;
            }

            .data-card .table-responsive {
                font-size: 12px;
            }

            .row.g-3 > .col-lg-8,
            .row.g-3 > .col-lg-4 {
                --bs-gutter-x: 0.75rem;
            }
        }
    </style>
</head>

<body>
    <!-- Sidebar Overlay -->
    <?php if(auth()->guard()->check()): ?>
    <div class="sidebar-overlay" id="sidebarOverlay"></div>
    <?php endif; ?>
    
    <div class="main-wrapper <?php if(!Auth::check() || (Auth::check() && Auth::user()->role !== 'admin' && Auth::user()->role !== 'petugas')): ?> no-sidebar <?php endif; ?>">
        <!-- Sidebar - Only for Admin & Petugas -->
        <?php if(auth()->guard()->check()): ?>
        <?php if(Auth::user()->role === 'admin' || Auth::user()->role === 'petugas'): ?>
        <aside class="sidebar">
            <div class="sidebar-header">
                <div class="sidebar-logo">🏢</div>
                <div>
                    <h5 class="sidebar-title">MENEJEMEN</h5>
                    <p class="sidebar-subtitle">Manajemen Ruang</p>
                </div>
            </div>

            <!-- Main Navigation -->
            <nav class="nav-section">
                <div class="nav-section-title">Main</div>
                <?php if(Auth::user()->role === 'admin'): ?>
                <a href="<?php echo e(route('admin.dashboard')); ?>" class="nav-item <?php echo e(request()->routeIs('admin.dashboard') ? 'active' : ''); ?>">
                    <span class="nav-icon">📊</span>
                    <span>Dashboard</span>
                </a>
                <?php elseif(Auth::user()->role === 'petugas'): ?>
                <a href="<?php echo e(route('petugas.dashboard')); ?>" class="nav-item <?php echo e(request()->routeIs('petugas.dashboard') ? 'active' : ''); ?>">
                    <span class="nav-icon">📊</span>
                    <span>Dashboard</span>
                </a>
                <?php endif; ?>
            </nav>

            <!-- Management -->
            <nav class="nav-section">
                <div class="nav-section-title">Management</div>
                <?php if(Auth::user()->role === 'admin'): ?>
                <a href="<?php echo e(route('admin.petugas')); ?>" class="nav-item <?php echo e(request()->routeIs('admin.petugas*') ? 'active' : ''); ?>">
                    <span class="nav-icon">👥</span>
                    <span>Manajemen User</span>
                </a>
                <a href="<?php echo e(route('admin.rooms')); ?>" class="nav-item <?php echo e(request()->routeIs('admin.rooms*') ? 'active' : ''); ?>">
                    <span class="nav-icon">🏢</span>
                    <span>Manajemen Ruangan</span>
                </a>
                <a href="<?php echo e(route('admin.bookings')); ?>" class="nav-item <?php echo e(request()->routeIs('admin.bookings*') ? 'active' : ''); ?>">
                    <span class="nav-icon">📋</span>
                    <span>Manajemen Booking</span>
                </a>
                <a href="<?php echo e(route('admin.jadwal_reguler')); ?>" class="nav-item <?php echo e(request()->routeIs('admin.jadwal_reguler') ? 'active' : ''); ?>">
                    <span class="nav-icon">📅</span>
                    <span>Jadwal Reguler</span>
                </a>
                <a href="<?php echo e(route('admin.jadwal_reguler.mingguan')); ?>" class="nav-item <?php echo e(request()->routeIs('admin.jadwal_reguler.mingguan*') ? 'active' : ''); ?>">
                    <span class="nav-icon">📊</span>
                    <span>Jadwal Mingguan</span>
                </a>
                <?php elseif(Auth::user()->role === 'petugas'): ?>
                <a href="<?php echo e(route('petugas.rooms')); ?>" class="nav-item <?php echo e(request()->routeIs('petugas.rooms*') ? 'active' : ''); ?>">
                    <span class="nav-icon">🏢</span>
                    <span>Manajemen Ruangan</span>
                </a>
                <a href="<?php echo e(route('petugas.bookings')); ?>" class="nav-item <?php echo e(request()->routeIs('petugas.bookings*') ? 'active' : ''); ?>">
                    <span class="nav-icon">📋</span>
                    <span>Manajemen Booking</span>
                </a>
                <a href="<?php echo e(route('petugas.jadwal_reguler')); ?>" class="nav-item <?php echo e(request()->routeIs('petugas.jadwal_reguler') ? 'active' : ''); ?>">
                    <span class="nav-icon">📅</span>
                    <span>Jadwal Reguler</span>
                </a>
                <a href="<?php echo e(route('petugas.jadwal_reguler.mingguan')); ?>" class="nav-item <?php echo e(request()->routeIs('petugas.jadwal_reguler.mingguan*') ? 'active' : ''); ?>">
                    <span class="nav-icon">📊</span>
                    <span>Jadwal Mingguan</span>
                </a>
                <?php endif; ?>
            </nav>

            <!-- Reports -->
            <nav class="nav-section">
                <div class="nav-section-title">Reports</div>
                <?php if(Auth::user()->role === 'admin'): ?>
                <a href="<?php echo e(route('admin.reports.index')); ?>" class="nav-item <?php echo e(request()->routeIs('admin.reports.*') ? 'active' : ''); ?>">
                    <span class="nav-icon">📊</span>
                    <span>Generate Laporan</span>
                </a>
                <?php elseif(Auth::user()->role === 'petugas'): ?>
                <a href="<?php echo e(route('petugas.reports.index')); ?>" class="nav-item <?php echo e(request()->routeIs('petugas.reports.*') ? 'active' : ''); ?>">
                    <span class="nav-icon">📊</span>
                    <span>Generate Laporan</span>
                </a>
                <?php endif; ?>
            </nav>

        </aside>
        <?php endif; ?>
        <?php endif; ?>

        <!-- Navbar & Content -->
        <nav class="navbar-custom">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-3">
                    <button class="toggle-sidebar-btn d-none d-lg-none" id="toggleSidebarBtn" title="Toggle Sidebar">
                        <i class="bi bi-list"></i>
                    </button>
                    <h5 class="navbar-brand mb-0"><?php echo $__env->yieldContent('title', 'Dashboard'); ?></h5>
                </div>
                <div class="user-profile" id="userProfile" style="cursor: pointer;" title="Klik untuk logout">
                    <div class="user-info">
                        <div class="user-name"><?php echo e(auth()->user()->name ?? 'Admin'); ?></div>
                        <div class="user-role"><?php echo e(ucfirst(auth()->user()->role ?? 'admin')); ?></div>
                    </div>
                    <div class="user-avatar"><?php echo e(substr(auth()->user()->name ?? 'A', 0, 1)); ?></div>
                </div>
                
                <!-- Logout Form (Hidden) -->
                <form id="logoutForm" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
                    <?php echo csrf_field(); ?>
                </form>
            </div>
        </nav>

        <div class="content-area">
            <?php echo $__env->yieldContent('content'); ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // ==================== CSRF Token Handling ====================
        // Set default CSRF token for all AJAX requests
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        // Update fetch default headers with CSRF token
        const originalFetch = window.fetch;
        window.fetch = function(...args) {
            if (args[1] && !args[1].headers) {
                args[1] = { ...args[1], headers: {} };
            }
            if (args[1]) {
                args[1].headers = args[1].headers || {};
                if (!args[1].headers['X-CSRF-TOKEN']) {
                    args[1].headers['X-CSRF-TOKEN'] = token;
                }
            }
            return originalFetch.apply(this, args);
        };

        // Refresh CSRF token every 30 minutes to prevent expiration
        function refreshCSRFToken() {
            const refreshUrl = '<?php echo e(route("api.refresh-csrf")); ?>';
            if (!refreshUrl) return; // Skip if route not available
            
            fetch(refreshUrl, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': token,
                    'Content-Type': 'application/json'
                }
            })
            .then(response => {
                if (response.ok) {
                    return response.json();
                }
                throw new Error('CSRF refresh failed');
            })
            .then(data => {
                if (data && data.token) {
                    // Update meta tag with new token
                    document.querySelector('meta[name="csrf-token"]').setAttribute('content', data.token);
                    // Update all form tokens
                    document.querySelectorAll('input[name="_token"]').forEach(input => {
                        input.value = data.token;
                    });
                    console.debug('CSRF token refreshed');
                }
            })
            .catch(error => console.debug('CSRF refresh skipped:', error.message));
        }

        // Auto-refresh CSRF token every 25 minutes
        setInterval(refreshCSRFToken, 25 * 60 * 1000);

        // ==================== Session Check ====================
        // Check if user is still authenticated (reduced frequency to prevent false positives)
        let lastSessionCheck = Date.now();
        let isSessionValid = true;
        let sessionCheckInProgress = false;
        
        function checkSession() {
            // Prevent multiple simultaneous checks
            if (sessionCheckInProgress) {
                return;
            }
            
            sessionCheckInProgress = true;
            
            // Only check session for certain pages (not API, not form submissions)
            fetch(window.location.href, {
                method: 'HEAD',  // Use HEAD instead of GET to minimize server load
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                if (response.status === 401) {
                    // Session expired
                    console.warn('Session expired (401)');
                    isSessionValid = false;
                    showSessionExpiredMessage();
                } else {
                    // Session still valid
                    isSessionValid = true;
                    lastSessionCheck = Date.now();
                }
            })
            .catch(error => {
                // Ignore network errors - don't assume session expired on network issues
                console.debug('Session check skipped (network):', error.message);
            })
            .finally(() => {
                sessionCheckInProgress = false;
            });
        }

        // Check session every 15 minutes (reduced from 3 minutes)
        setInterval(checkSession, 15 * 60 * 1000);
        
        // Also check on page visibility change (when user returns to tab)
        document.addEventListener('visibilitychange', function() {
            if (!document.hidden && (Date.now() - lastSessionCheck) > (10 * 60 * 1000)) {
                // Page is visible and last check was more than 10 minutes ago
                console.debug('Page became visible, checking session...');
                checkSession();
            }
        });
        
        // Check session on page focus (only if long time has passed)
        window.addEventListener('focus', function() {
            if ((Date.now() - lastSessionCheck) > (10 * 60 * 1000)) {
                console.debug('Window focused, verifying session...');
                setTimeout(checkSession, 500);
            }
        });

        // Show warning before redirecting
        function showSessionExpiredMessage() {
            // Only show if not already shown
            if (document.querySelector('#sessionExpiredWarning')) {
                return;
            }
            
            const warning = document.createElement('div');
            warning.id = 'sessionExpiredWarning';
            warning.className = 'alert alert-warning alert-dismissible fade show';
            warning.style.cssText = 'position: fixed; top: 20px; right: 20px; z-index: 9999; max-width: 400px; box-shadow: 0 4px 12px rgba(0,0,0,0.15);';
            warning.innerHTML = `
                <strong>⚠️ Sesi Berakhir</strong>
                <p class="mb-2">Sesi Anda telah berakhir. Silakan login kembali.</p>
                <button type="button" class="btn btn-sm btn-warning" onclick="window.location.href='<?php echo e(route("login")); ?>';">
                    Go ke Login
                </button>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;
            document.body.appendChild(warning);
            
            // Auto redirect after 10 seconds
            setTimeout(() => {
                window.location.href = '<?php echo e(route("login")); ?>';
            }, 10000);
        }

        // ==================== Sidebar Persistence ====================
        // Ensure sidebar is always visible and never disappears
        let sidebarMonitorInterval = null;
        
        document.addEventListener('DOMContentLoaded', function() {
            const mainWrapper = document.querySelector('.main-wrapper');
            const sidebar = document.querySelector('.sidebar');
            
            if (mainWrapper && !mainWrapper.classList.contains('no-sidebar') && sidebar) {
                // Force sidebar to be visible on desktop
                if (window.innerWidth > 992) {
                    sidebar.style.display = 'block !important';
                    sidebar.style.visibility = 'visible !important';
                    sidebar.style.position = 'fixed !important';
                    sidebar.style.left = '0 !important';
                    sidebar.style.top = '0 !important';
                }
            }
            
            // Monitor sidebar visibility periodically
            sidebarMonitorInterval = setInterval(function() {
                const sidebar = document.querySelector('.sidebar');
                const mainWrapper = document.querySelector('.main-wrapper');
                
                if (sidebar && mainWrapper && !mainWrapper.classList.contains('no-sidebar')) {
                    if (window.innerWidth > 992) {
                        // Ensure sidebar is visible on desktop
                        const computed = getComputedStyle(sidebar);
                        if (computed.display === 'none' || computed.visibility === 'hidden') {
                            sidebar.style.display = 'block !important';
                            sidebar.style.visibility = 'visible !important';
                            console.debug('Sidebar visibility restored');
                        }
                    }
                }
            }, 2000);  // Check every 2 seconds
        });
        
        // Stop monitoring when user leaves page
        window.addEventListener('beforeunload', function() {
            if (sidebarMonitorInterval) {
                clearInterval(sidebarMonitorInterval);
            }
        });

        // ==================== Logout Handler ====================
        const userProfileElement = document.getElementById('userProfile');
        if (userProfileElement) {
            userProfileElement.addEventListener('click', function() {
                if(confirm('Apakah Anda yakin ingin logout?')) {
                    document.getElementById('logoutForm').submit();
                }
            });
        }

        // ==================== Sidebar Toggle Handler ====================
        // Keep sidebar visible on desktop, allow toggle on mobile only
        const toggleBtn = document.getElementById('toggleSidebarBtn');
        const sidebar = document.querySelector('.sidebar');
        const overlay = document.getElementById('sidebarOverlay');

        if(toggleBtn && sidebar && overlay) {
            toggleBtn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                // Only toggle on mobile (screen width < 992px)
                if (window.innerWidth < 992) {
                    sidebar.classList.toggle('active');
                    overlay.classList.toggle('active');
                }
            });

            overlay.addEventListener('click', function() {
                // Only close sidebar on mobile
                if (window.innerWidth < 992) {
                    sidebar.classList.remove('active');
                    overlay.classList.remove('active');
                }
            });

            // Close sidebar when clicking on nav item (mobile only)
            document.querySelectorAll('.nav-item').forEach(item => {
                item.addEventListener('click', function(e) {
                    // Only close sidebar on mobile when navigating
                    if (window.innerWidth < 992 && this.getAttribute('href')) {
                        setTimeout(function() {
                            sidebar.classList.remove('active');
                            overlay.classList.remove('active');
                        }, 100);
                    }
                });
            });

            // Handle resize events
            window.addEventListener('resize', function() {
                if(window.innerWidth > 992) {
                    // On desktop, ensure sidebar is always open
                    sidebar.classList.remove('active');
                    overlay.classList.remove('active');
                    // Force sidebar visibility on desktop
                    sidebar.style.display = 'block !important';
                    sidebar.style.visibility = 'visible !important';
                } else {
                    // On mobile, hide sidebar on resize
                    sidebar.classList.remove('active');
                    overlay.classList.remove('active');
                }
            });
            
            // Initial check on load
            if(window.innerWidth > 992) {
                sidebar.style.display = 'block !important';
                sidebar.style.visibility = 'visible !important';
                sidebar.classList.remove('active');
            }
        }

        // ==================== Form CSRF Token Handler ====================
        // Update all form CSRF tokens before submission
        document.addEventListener('submit', function(event) {
            const form = event.target;
            const tokenInput = form.querySelector('input[name="_token"]');
            if (tokenInput && token) {
                tokenInput.value = token;
            }
        });
        
        // ==================== Navigation Persistence ====================
        // Prevent accidental navigation changes that would lose session
        let currentUserRole = '<?php echo e(Auth::user()->role); ?>';
        let navigationCount = 0;
        
        // Monitor links to ensure they don't inadvertently change role context
        document.addEventListener('click', function(e) {
            const link = e.target.closest('a');
            if (link && !link.target) {
                const href = link.getAttribute('href');
                
                // Check if navigating to protected route with wrong role
                if (href && !href.includes('logout') && !href.includes('profile')) {
                    navigationCount++;
                    
                    // Log navigation for debugging
                    console.debug('Navigation [' + navigationCount + ']: ' + href + ' (Role: ' + currentUserRole + ')');
                    
                    // Ensure sidebar persists after navigation
                    setTimeout(function() {
                        const sidebar = document.querySelector('.sidebar');
                        if (sidebar && window.innerWidth > 992) {
                            sidebar.style.display = 'block !important';
                            sidebar.style.visibility = 'visible !important';
                        }
                    }, 500);
                }
            }
        }, true);
        
        // Maintain sidebar visibility on every page transition
        window.addEventListener('beforeunload', function() {
            const sidebar = document.querySelector('.sidebar');
            if (sidebar) {
                sidebar.style.display = 'block !important';
                sidebar.style.visibility = 'visible !important';
            }
        });
        
        // Re-check sidebar visibility after page navigation completes
        window.addEventListener('load', function() {
            setTimeout(function() {
                const sidebar = document.querySelector('.sidebar');
                const mainWrapper = document.querySelector('.main-wrapper');
                
                if (sidebar && mainWrapper && !mainWrapper.classList.contains('no-sidebar')) {
                    sidebar.style.display = 'block !important';
                    sidebar.style.visibility = 'visible !important';
                    
                    if (window.innerWidth > 992) {
                        sidebar.style.position = 'fixed !important';
                        sidebar.style.left = '0 !important';
                        sidebar.style.top = '0 !important';
                    }
                }
            }, 100);
        });
    </script>
</body>

</html>
<?php /**PATH C:\laragon\www\menejemen-ruang\resources\views/layouts/app.blade.php ENDPATH**/ ?>