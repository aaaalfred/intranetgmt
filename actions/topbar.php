<div class="topbar">            
    <!-- Navbar -->
    <nav class="navbar-custom" id="navbar-custom">    
        <ul class="list-unstyled topbar-nav float-end mb-0">
            <li class="dropdown">
                <a class="nav-link dropdown-toggle nav-user" data-bs-toggle="dropdown" href="#" role="button"
                    aria-haspopup="false" aria-expanded="false">
                    <div class="d-flex align-items-center">
                        <img src="<?php echo $views;?>../assets/images/users/user-4.jpg" alt="profile-user" class="rounded-circle me-2 thumb-sm" />
                        <div>
                            <small class="d-none d-md-block font-11"><?php echo htmlspecialchars($_SESSION['rol_gmt']); ?></small>
                            <span class="d-none d-md-block fw-semibold font-12"><?php echo htmlspecialchars($_SESSION['nombre_gmt']); ?> <i class="mdi mdi-chevron-down"></i></span>
                        </div>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-end">
                    <a class="dropdown-item" href="#"><i class="ti ti-user font-16 me-1 align-text-bottom"></i> Perfil</a>
                    <div class="dropdown-divider mb-0"></div>
                    <a class="dropdown-item" href="<?php echo $views; ?>../actions/logout.php"><i class="ti ti-power font-16 me-1 align-text-bottom"></i> Cerrar sesión</a>
                </div>
            </li>
        </ul>
        <ul class="list-unstyled topbar-nav mb-0">                        
            <li>
                <button class="nav-link button-menu-mobile nav-icon" id="togglemenu">
                    <i class="ti ti-menu-2"></i>
                </button>
            </li>                      
        </ul>
    </nav>
    <!-- end navbar-->
</div>

<!-- Información de sesión para pruebas -->
<div class="container mt-3">
    <div class="card">

    </div>
</div>