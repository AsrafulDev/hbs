<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
        <span class="brand-text font-weight-light">Hotel Booking</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="dashboard.php" class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'dashboard.php') ? 'active' : ''; ?>">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="new_booking.php" class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'new_booking.php') ? 'active' : ''; ?>">
                        <i class="nav-icon fas fa-plus"></i>
                        <p>
                            New Booking
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="booking_list.php" class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'booking_list.php') ? 'active' : ''; ?>">
                        <i class="nav-icon fas fa-list"></i>
                        <p>
                            Booking List
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="add_room.php" class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'add_room.php') ? 'active' : ''; ?>">
                        <i class="nav-icon fas fa-plus"></i>
                        <p>
                            New Room
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="hotel_room_management.php" class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'hotel_room_management.php') ? 'active' : ''; ?>">
                        <i class="nav-icon fas fa-hotel"></i>
                        <p>
                            Room Management
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="add_package.php" class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'add_package.php') ? 'active' : ''; ?>">
                        <i class="nav-icon fas fa-plus"></i>
                        <p>
                            New Package
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="booking_package.php" class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'booking_package.php') ? 'active' : ''; ?>">
                        <i class="nav-icon fas fa-box"></i>
                        <p>
                            Package Management
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="profile.php" class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'profile.php') ? 'active' : ''; ?>">
                        <i class="nav-icon fas fa-user"></i>
                        <p>
                            Profile
                        </p>
                    </a>
                </li>

                <li class="nav-item" ><a href="logout.php"class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'logout.php') ? 'active' : ''; ?>">
                <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>
                        Logout
                        </p></a></li>
                <!-- Add more menu items as needed -->
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
<!-- sidebar.php -->
