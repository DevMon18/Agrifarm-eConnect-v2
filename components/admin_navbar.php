<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light border-0">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item" title="Menu">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                <h5><i class="bi bi-list"></i></h5>
            </a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Profile Dropdown Menu -->
        <li class="nav-item dropdown user-menu">
            <a href="#" class="nav-link dropdown-toggle" onclick="confirmLogout()">
                <i class="bi bi-person-fill-lock"></i>
            </a>
        </li>
    </ul>
</nav>

<script>
    // Function to show SweetAlert confirmation
    function confirmLogout() {
        Swal.fire({
            icon: 'question',
            text: 'Are you sure you want to logout from the website?',
            showCancelButton: true,
            confirmButtonText: 'Yes',
            cancelButtonText: 'No',
        }).then((result) => {
            if (result.isConfirmed) {
                // Redirect to logout page
                window.location.href = '../components/admin_logout.php';
            }
        });
    }
</script>