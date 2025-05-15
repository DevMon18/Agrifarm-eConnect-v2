<?php
require_once '../includes/session_manager.php';
ensure_session_started();
$admin_id = check_admin_login();

require_once '../components/connect.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/apexcharts@3.44.0/dist/apexcharts.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/index.min.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
        .dashboard-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            transition: transform 0.2s ease;
        }
        .dashboard-card:hover {
            transform: translateY(-5px);
        }
        .card-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            margin-bottom: 1rem;
        }
        .stats-value {
            font-size: 24px;
            font-weight: 600;
            color: #2c3345;
            margin-bottom: 0.25rem;
        }
        .stats-label {
            color: #6b7280;
            font-size: 0.875rem;
        }
        .bg-gradient-primary {
            background: linear-gradient(45deg, #4f46e5, #6366f1);
        }
        .bg-gradient-success {
            background: linear-gradient(45deg, #059669, #10b981);
        }
        .bg-gradient-warning {
            background: linear-gradient(45deg, #d97706, #fbbf24);
        }
        .bg-gradient-info {
            background: linear-gradient(45deg, #0891b2, #22d3ee);
        }
        .content-header {
            padding: 2rem 0 1rem;
        }
        .content-header h3 {
            font-weight: 600;
            color: #2c3345;
        }
        .chart-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            padding: 1.5rem;
            margin-top: 2rem;
        }
    </style>
</head>
    <body class="hold-transition layout-fixed layout-navbar-fixed layout-footer-fixed antialiased">
<!-- Dashboard header -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <h3>Dashboard Overview</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<!-- Dashboard content -->
<section class="content">
    <div class="container-fluid">
        <!-- Stats Cards -->
        <div class="row">
            <!-- Pending Orders -->
            <div class="col-12 col-sm-6 col-lg-3 mb-4">
                <div class="dashboard-card p-4">
                    <?php
                        $total_pendings = 0;
                        $select_pendings = $conn->prepare("SELECT * FROM `orders` WHERE payment_status = ?");
                        $select_pendings->execute(['pending']);
                        if($select_pendings->rowCount() > 0){
                        while($fetch_pendings = $select_pendings->fetch(PDO::FETCH_ASSOC)){
                            $total_pendings += $fetch_pendings['total_price'];
                        }
                        }
                    ?>
                    <div class="card-icon bg-gradient-warning text-white">
                        <i class="bi bi-hourglass-split"></i>
                    </div>
                    <h4 class="stats-value">₱<?= number_format($total_pendings, 2) ?></h4>
                    <p class="stats-label mb-0">Pending Orders</p>
                </div>
            </div>

            <!-- Completed Orders -->
            <div class="col-12 col-sm-6 col-lg-3 mb-4">
                <div class="dashboard-card p-4">
                    <?php
                        $total_completes = 0;
                        $select_completes = $conn->prepare("SELECT * FROM `orders` WHERE payment_status = ?");
                        $select_completes->execute(['completed']);
                        if($select_completes->rowCount() > 0){
                        while($fetch_completes = $select_completes->fetch(PDO::FETCH_ASSOC)){
                            $total_completes += $fetch_completes['total_price'];
                        }
                        }
                    ?>
                    <div class="card-icon bg-gradient-success text-white">
                        <i class="bi bi-bag-check-fill"></i>
                    </div>
                    <h4 class="stats-value">₱<?= number_format($total_completes, 2) ?></h4>
                    <p class="stats-label mb-0">Completed Orders</p>
                </div>
            </div>

            <!-- Total Orders -->
            <div class="col-12 col-sm-6 col-lg-3 mb-4">
                <div class="dashboard-card p-4">
                    <?php
                        $select_orders = $conn->prepare("SELECT * FROM `orders`");
                        $select_orders->execute();
                        $number_of_orders = $select_orders->rowCount()
                    ?>
                    <div class="card-icon bg-gradient-primary text-white">
                        <i class="bi bi-cart-check-fill"></i>
                    </div>
                    <h4 class="stats-value"><?= $number_of_orders ?></h4>
                    <p class="stats-label mb-0">Total Orders</p>
                </div>
            </div>

            <!-- Products -->
            <div class="col-12 col-sm-6 col-lg-3 mb-4">
                <div class="dashboard-card p-4">
                    <?php
                        $select_products = $conn->prepare("SELECT * FROM `products`");
                        $select_products->execute();
                        $number_of_products = $select_products->rowCount()
                    ?>
                    <div class="card-icon bg-gradient-info text-white">
                        <i class="bi bi-box-seam-fill"></i>
                    </div>
                    <h4 class="stats-value"><?= $number_of_products ?></h4>
                    <p class="stats-label mb-0">Total Products</p>
                </div>
            </div>

            <!-- Users -->
            <div class="col-12 col-sm-6 col-lg-3 mb-4">
                <div class="dashboard-card p-4">
                    <?php
                        $select_users = $conn->prepare("SELECT * FROM `users`");
                        $select_users->execute();
                        $number_of_users = $select_users->rowCount()
                    ?>
                    <div class="card-icon bg-gradient-primary text-white">
                        <i class="bi bi-people-fill"></i>
                    </div>
                    <h4 class="stats-value"><?= $number_of_users ?></h4>
                    <p class="stats-label mb-0">Total Users</p>
                </div>
            </div>

            <!-- Messages -->
            <div class="col-12 col-sm-6 col-lg-3 mb-4">
                <div class="dashboard-card p-4">
                    <?php
                        $select_messages = $conn->prepare("SELECT * FROM `messages`");
                        $select_messages->execute();
                        $number_of_messages = $select_messages->rowCount()
                    ?>
                    <div class="card-icon bg-gradient-success text-white">
                        <i class="bi bi-envelope-fill"></i>
                    </div>
                    <h4 class="stats-value"><?= $number_of_messages ?></h4>
                    <p class="stats-label mb-0">Total Messages</p>
                </div>
            </div>
        </div>

        <!-- Charts Row -->
        <div class="row">
            <!-- Sales Chart -->
            <div class="col-12 col-lg-8 mb-4">
                <div class="chart-card">
                    <h5 class="mb-4">Sales Overview</h5>
                    <div id="salesChart"></div>
                </div>
            </div>
            
            <!-- Orders Status Chart -->
            <div class="col-12 col-lg-4 mb-4">
                <div class="chart-card">
                    <h5 class="mb-4">Orders Status</h5>
                    <div id="ordersChart"></div>
                </div>
            </div>
        </div>

        <!-- Recent Orders Table -->
        <div class="row">
            <div class="col-12">
                <div class="chart-card">
                    <h5 class="mb-4">Recent Orders</h5>
                    <div class="table-responsive">
                        <table id="recentOrders" class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Customer</th>
                                    <th>Product</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $select_orders = $conn->prepare("SELECT o.*, u.name as customer_name FROM `orders` o JOIN `users` u ON o.user_id = u.id ORDER BY o.placed_on DESC LIMIT 5");
                                $select_orders->execute();
                                while($order = $select_orders->fetch(PDO::FETCH_ASSOC)) {
                                    $status_class = '';
                                    switch($order['payment_status']) {
                                        case 'pending': $status_class = 'warning'; break;
                                        case 'completed': $status_class = 'success'; break;
                                        default: $status_class = 'info';
                                    }
                                    ?>
                                    <tr>
                                        <td>#<?= $order['id'] ?></td>
                                        <td><?= $order['customer_name'] ?></td>
                                        <td><?= $order['total_products'] ?></td>
                                        <td>₱<?= number_format($order['total_price'], 2) ?></td>
                                        <td><span class="badge bg-<?= $status_class ?>"><?= ucfirst($order['payment_status']) ?></span></td>
                                        <td><?= date('M d, Y', strtotime($order['placed_on'])) ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
// Initialize DataTables
$(document).ready(function() {
    $('#recentOrders').DataTable({
        pageLength: 5,
        lengthMenu: [[5, 10, 25, 50], [5, 10, 25, 50]]
    });
});

// Sales Chart
var salesOptions = {
    series: [{
        name: 'Sales',
        data: [30, 40, 35, 50, 49, 60, 70, 91, 125]
    }],
    chart: {
        height: 350,
        type: 'area',
        toolbar: {
            show: false
        }
    },
    colors: ['#4f46e5'],
    fill: {
        type: 'gradient',
        gradient: {
            shadeIntensity: 1,
            opacityFrom: 0.7,
            opacityTo: 0.2,
            stops: [0, 90, 100]
        }
    },
    stroke: {
        curve: 'smooth'
    },
    xaxis: {
        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep']
    },
    tooltip: {
        theme: 'dark'
    }
};

var salesChart = new ApexCharts(document.querySelector("#salesChart"), salesOptions);
salesChart.render();

// Orders Status Chart
var ordersOptions = {
    series: [44, 55, 13],
    chart: {
        type: 'donut',
        height: 350
    },
    labels: ['Pending', 'Completed', 'Processing'],
    colors: ['#fbbf24', '#10b981', '#4f46e5'],
    legend: {
        position: 'bottom'
    },
    responsive: [{
        breakpoint: 480,
        options: {
            chart: {
                width: 200
            },
            legend: {
                position: 'bottom'
            }
        }
    }]
};

var ordersChart = new ApexCharts(document.querySelector("#ordersChart"), ordersOptions);
ordersChart.render();
</script>

</body>
</html>