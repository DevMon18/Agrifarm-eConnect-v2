<?php
require_once '../includes/session_manager.php';
ensure_session_started();

// Start output buffering if not already started
if (ob_get_level() == 0) ob_start();

// Get current page for active state
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!-- Hamburger Button for Mobile -->
<button id="sidebar-toggle" class="btn text-white position-fixed d-lg-none" style="top: 10px; right: 10px; z-index: 1031;">
    <i class="bi bi-list fs-4"></i>
</button>

<!-- Admin sidebar -->
<aside class="main-sidebar sidebar-dark-indigo">
    <!-- Brand Logo -->
    <div class="brand-container p-3 border-bottom border-secondary">
        <a href="dashboard1.php" class="brand-link text-decoration-none d-flex align-items-center">
            <i class="bi bi-flower1 text-success me-2"></i>
            <span class="brand-text fw-bold text-white">Agrifarm eConnect</span>
        </a>
    </div>

    <!-- Sidebar Content -->
    <div class="sidebar" id="sidebar-content">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-flat nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- Monitor Section -->
                <li class="nav-header">
                    <span class="text-uppercase fw-bold text-muted ms-2 small">Monitor</span>
                </li>
                <li class="nav-item">
                    <a href="dashboard1.php" class="nav-link d-flex align-items-center position-relative <?php echo $current_page == 'dashboard1.php' ? 'active' : ''; ?>">
                        <i class="nav-icon bi bi-tv-fill"></i>
                        <span class="nav-text ms-2">Dashboard</span>
                        <span class="hover-indicator"></span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="products1.php" class="nav-link d-flex align-items-center position-relative <?php echo $current_page == 'products1.php' ? 'active' : ''; ?>">
                        <i class="nav-icon bi bi-handbag-fill"></i>
                        <span class="nav-text ms-2">Products</span>
                        <span class="hover-indicator"></span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="placed_orders1.php" class="nav-link d-flex align-items-center position-relative <?php echo $current_page == 'placed_orders1.php' ? 'active' : ''; ?>">
                        <i class="nav-icon bi bi-bag-check-fill"></i>
                        <span class="nav-text ms-2">Orders</span>
                        <span class="hover-indicator"></span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="messages1.php" class="nav-link d-flex align-items-center position-relative <?php echo $current_page == 'messages1.php' ? 'active' : ''; ?>">
                        <i class="nav-icon bi bi-envelope-fill"></i>
                        <span class="nav-text ms-2">Messages</span>
                        <span class="hover-indicator"></span>
                    </a>
                </li>

                <!-- Administration Section -->
                <li class="nav-header mt-4">
                    <span class="text-uppercase fw-bold text-muted ms-2 small">Administration</span>
                </li>
                <li class="nav-item">
                    <a href="admin_accounts1.php" class="nav-link d-flex align-items-center position-relative <?php echo $current_page == 'admin_accounts1.php' ? 'active' : ''; ?>">
                        <i class="nav-icon bi bi-person-fill-lock"></i>
                        <span class="nav-text ms-2">Admin</span>
                        <span class="hover-indicator"></span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="users_accounts1.php" class="nav-link d-flex align-items-center position-relative <?php echo $current_page == 'users_accounts1.php' ? 'active' : ''; ?>">
                        <i class="nav-icon bi bi-people-fill"></i>
                        <span class="nav-text ms-2">Users</span>
                        <span class="hover-indicator"></span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>

    <style>
    /* Main Sidebar Styles */
    .main-sidebar {
        background: #1a1c23;
        border-right: 1px solid rgba(255,255,255,0.1);
        transition: all 0.3s ease;
        width: 250px;
        position: fixed;
        top: 0;
        bottom: 0;
        left: 0;
        z-index: 1030;
    }

    /* Content Wrapper Adjustment */
    .content-wrapper {
        margin-left: 250px;
        padding: 1rem;
        transition: margin-left 0.3s ease;
    }

    /* Sidebar Content */
    .sidebar {
        height: calc(100% - 70px);
        overflow-y: auto;
        padding: 0.5rem;
    }

    /* Navigation Links */
    .nav-link {
        color: #a0aec0 !important;
        padding: 0.75rem 1rem;
        transition: all 0.3s ease;
        border-radius: 0.5rem;
        margin: 0.25rem 0;
        white-space: nowrap;
    }

    .nav-link:hover {
        color: #fff !important;
        background: rgba(255,255,255,0.1);
    }

    .nav-link.active {
        background: #21a67a !important;
        color: #fff !important;
        box-shadow: 0 4px 6px -1px rgba(33, 166, 122, 0.2);
    }

    /* Icons and Text */
    .nav-icon {
        font-size: 1.1rem;
        width: 1.5rem;
        text-align: center;
        margin-right: 0.5rem;
    }

    .nav-text {
        font-size: 0.95rem;
        font-weight: 500;
    }

    /* Headers and Sections */
    .nav-header {
        padding: 0.75rem 1rem;
        margin-bottom: 0.5rem;
    }

    .brand-container {
        height: 70px;
        display: flex;
        align-items: center;
        background: rgba(255,255,255,0.05);
        padding: 0 1rem;
    }

    .brand-text {
        font-size: 1.25rem;
    }

    /* Hamburger Button */
    #sidebar-toggle {
        background: #1a1c23;
        border: 1px solid rgba(255,255,255,0.1);
        padding: 0.5rem;
        border-radius: 0.5rem;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
    }

    #sidebar-toggle:hover {
        background: rgba(255,255,255,0.1);
    }

    #sidebar-toggle:active {
        transform: scale(0.95);
    }

    /* Responsive Styles */
    @media (max-width: 991.98px) {
        .main-sidebar {
            transform: translateX(-100%);
            box-shadow: none;
        }

        .main-sidebar.show {
            transform: translateX(0);
            box-shadow: 4px 0 8px rgba(0,0,0,0.1);
        }

        .content-wrapper {
            margin-left: 0;
        }

        body.sidebar-open {
            overflow: hidden;
        }

        .sidebar-backdrop {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.5);
            z-index: 1029;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .sidebar-backdrop.show {
            display: block;
            opacity: 1;
        }
    }

    /* Scrollbar Styling */
    .sidebar::-webkit-scrollbar {
        width: 6px;
    }

    .sidebar::-webkit-scrollbar-track {
        background: transparent;
    }

    .sidebar::-webkit-scrollbar-thumb {
        background: rgba(255,255,255,0.2);
        border-radius: 3px;
    }

    .sidebar::-webkit-scrollbar-thumb:hover {
        background: rgba(255,255,255,0.3);
    }

    /* Hover Indicator */
    .hover-indicator {
        position: absolute;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
        width: 3px;
        height: 0;
        background: #21a67a;
        transition: height 0.2s ease;
        border-radius: 0 3px 3px 0;
    }

    .nav-link:hover .hover-indicator {
        height: 70%;
    }

    /* Accessibility Focus Styles */
    .nav-link:focus {
        outline: 2px solid #21a67a;
        outline-offset: -2px;
    }
    </style>

    <!-- Add backdrop div for mobile -->
    <div class="sidebar-backdrop"></div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const sidebar = document.querySelector('.main-sidebar');
        const backdrop = document.querySelector('.sidebar-backdrop');
        const toggleBtn = document.getElementById('sidebar-toggle');
        const body = document.body;

        // Toggle sidebar with animation
        function toggleSidebar() {
            sidebar.classList.toggle('show');
            backdrop.classList.toggle('show');
            body.classList.toggle('sidebar-open');
        }

        // Event listeners
        toggleBtn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            toggleSidebar();
        });

        // Close sidebar when clicking outside
        backdrop.addEventListener('click', function() {
            toggleSidebar();
        });

        // Close sidebar on window resize if in mobile view
        window.addEventListener('resize', function() {
            if (window.innerWidth > 991.98) {
                sidebar.classList.remove('show');
                backdrop.classList.remove('show');
                body.classList.remove('sidebar-open');
            }
        });

        // Handle escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && sidebar.classList.contains('show')) {
                toggleSidebar();
            }
        });

        // Prevent clicks inside sidebar from closing it
        sidebar.addEventListener('click', function(e) {
            e.stopPropagation();
        });
    });
    </script>
</aside>

<!-- Add this to your main content wrapper -->
<style>
.main-content {
    transition: margin-left 0.3s ease;
}

@media (min-width: 992px) {
    .main-content {
        margin-left: 250px;
    }
}

@media (max-width: 991.98px) {
    .main-content {
        margin-left: 0;
    }
}
</style>