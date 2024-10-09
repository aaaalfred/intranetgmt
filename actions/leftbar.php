<div class="leftbar-tab-menu">
    <div class="main-icon-menu">
        <a href="<?php echo $views;?>index.php" class="logo logo-metrica d-block text-center">
            <span>
                <img src="<?php echo $views;?>../assets/images/logoa.png" alt="logo-small" class="logo-sm">
            </span>
        </a>
        <div class="main-icon-menu-body">
            <div class="position-reletive h-100" data-simplebar style="overflow-x: hidden;">
                <ul class="nav nav-tabs" role="tablist" id="tab-menu">
                    <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right" title="Inicio" data-bs-trigger="hover">
                        <a href="#MetricaInicio" id="inicio-tab" class="nav-link">
                            <i class="ti ti-smart-home menu-icon"></i>
                        </a><!--end nav-link-->
                    </li><!--end nav-item-->
                    <?php if($_SESSION['rol_gmt'] != "SEGURO"){ ?>
                    <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right" title="Personal" data-bs-trigger="hover">
                        <a href="#MetricaPersonal" id="personal-tab" class="nav-link">
                            <i class="ti ti-user menu-icon"></i>
                        </a><!--end nav-link-->
                    </li><!--end nav-item-->
                    <?php } ?>
                    <?php if($_SESSION['rol_gmt'] != "CAPITAL_HUMANO" AND $_SESSION['rol_gmt'] != "CONTRATOS" AND $_SESSION['rol_gmt'] != "NOMINAS"){ ?>
                    <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right" title="Nominas" data-bs-trigger="hover">
                        <a href="#MetricaNominas" id="nominas-tab" class="nav-link">
                            <i class="ti ti-report-money menu-icon"></i>
                        </a><!--end nav-link-->
                    </li><!--end nav-item-->
                    <?php } ?>
                    <?php if($_SESSION['rol_gmt'] == "EJECUTIVO"){ ?>
                    <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right" title="Fondos y presupuestos" data-bs-trigger="hover">
                        <a href="#MetricaFondos" id="fondos-tab" class="nav-link">
                            <i class="ti ti-wallet menu-icon"></i>
                        </a><!--end nav-link-->
                    </li><!--end nav-item-->
                    <?php } ?>
                    <?php if($_SESSION['tipo_gmt'] == "GROUPER"){ ?>
                    <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right" title="Grouper" data-bs-trigger="hover">
                        <a href="#MetricaGrouper" id="grouper-tab" class="nav-link">
                            <i class="ti ti-users menu-icon"></i>
                        </a><!--end nav-link-->
                    </li><!--end nav-item-->
                    <?php } ?>
                    <?php if($_SESSION['tipo_gmt'] == "RH"){ ?>
                    <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right" title="RH" data-bs-trigger="hover">
                        <a href="#MetricaRh" id="grouper-tab" class="nav-link">
                            <i class="ti ti-users menu-icon"></i>
                        </a><!--end nav-link-->
                    </li><!--end nav-item-->
                    <?php } ?>
                </ul><!--end nav-->
            </div><!--end /div-->
        </div><!--end main-icon-menu-body-->
    </div>
    <!--end main-icon-menu-->

    <div class="main-menu-inner">
        <!-- LOGO -->
        <div class="topbar-left">
            <a href="<?php echo $views;?>index.php" class="logo">
                <span>
                    <!-- <img src="../../assets/images/logomi.jpg" alt="logo-large" class="logo-lg"> -->
                </span>
            </a><!--end logo-->
        </div><!--end topbar-left-->
        <!--end logo-->
        <div class="menu-body navbar-vertical tab-content" data-simplebar>
            <div id="MetricaInicio" class="main-icon-menu-pane tab-pane" role="tabpanel"
                aria-labelledby="inicio-tab">
                <div class="title-box">
                    <h6 class="menu-title">Inicio</h6>
                </div>

                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $views;?>index.php">Panel de Control</a>
                    </li><!--end nav-item-->
                </ul><!--end nav-->
            </div><!-- end Dashboards -->

            <div id="MetricaPersonal" class="main-icon-menu-pane tab-pane" role="tabpanel"
                aria-labelledby="personal-tab">
                <div class="title-box">
                    <h6 class="menu-title">Personal</h6>
                </div>

                <div class="collapse navbar-collapse" id="sidebarCollapse">
                    <!-- Navigation -->
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo $views;?>dashboard.php">Dashboard</a>
                        </li><!--end nav-item-->
                        <?php //if($_SESSION['rol_gmt'] != "CONTRATOS"){ ?>
                        <li class="nav-item">
                            <a class="nav-link" href="#sidebarCrypto" data-bs-toggle="collapse" role="button"
                                aria-expanded="false" aria-controls="sidebarCrypto">
                                Mi personal y contratación
                            </a>
                            <div class="collapse " id="sidebarCrypto">
                                <ul class="nav flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link" href="<?php echo $views;?>personal/solicitud_personal.php">Solicitud de personal</a>
                                    </li><!--end nav-item-->
                                    <li class="nav-item">
                                        <a class="nav-link" href="<?php echo $views;?>personal/missolper.php">Mis solicitudes</a>
                                    </li><!--end nav-item-->
                                    <li class="nav-item">
                                        <a class="nav-link" href="<?php echo $views;?>personal/candidatos.php">Candidatos</a>
                                    </li><!--end nav-item-->
                                    <li class="nav-item">
                                        <a class="nav-link" href="<?php echo $views;?>personal/preaprobados.php">Preaprobados</a>
                                    </li><!--end nav-item-->
                                    <li class="nav-item">
                                        <a class="nav-link" href="<?php echo $views;?>personal/mipersonal.php">Aprobados</a>
                                    </li><!--end nav-item-->
                                    <li class="nav-item">
                                        <a class="nav-link" href="<?php echo $views;?>personal/standby.php">Personal libre</a>
                                    </li><!--end nav-item-->
                                    <li class="nav-item">
                                        <a class="nav-link" href="<?php echo $views;?>personal/buscador.php">
                                            <i class="ti ti-search menu-icon"></i>
                                            <span>Buscador</span>
                                        </a>
                                    </li>
                                </ul><!--end nav-->
                            </div><!--end sidebarCrypto-->
                        </li><!--end nav-item-->





                        <li class="nav-item">
                            <a class="nav-link" href="#sidebarCrypto" data-bs-toggle="collapse" role="button"
                                aria-expanded="false" aria-controls="sidebarCrypto">
                                Contratos
                            </a>
                            <div class="collapse " id="sidebarCrypto">
                                <ul class="nav flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link" href="<?php echo $views;?>personal/contratos/liberacion.php">Status</a>
                                    </li><!--end nav-item-->
                                    <li class="nav-item">
                                        <a class="nav-link" href="<?php echo $views;?>personal/contratos/generar.php">Generar Contratos</a>
                                    </li><!--end nav-item-->
                                    <li class="nav-item">
                                        <a class="nav-link" href="<?php echo $views;?>personal/contratos_digitales.php">Contratos digitales</a>
                                    </li><!--end nav-item-->
                                </ul><!--end nav-->
                            </div><!--end sidebarCrypto-->
                        </li><!--end nav-item-->




                        <?php //} ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo $views;?>personal/exportar.php">Exportar datos</a>
                        </li><!--end nav-item-->
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo $views;?>personal/recibos.php">Recibos</a>
                        </li><!--end nav-item-->
                    </ul><!--end navbar-nav--->
                </div><!--end sidebarCollapse-->
            </div><!-- end Crypto -->

            <div id="MetricaNominas" class="main-icon-menu-pane  tab-pane" role="tabpanel"
                aria-labelledby="nominas-tab">
                <div class="title-box">
                    <h6 class="menu-title">Nominas</h6>
                </div>
                <div class="collapse navbar-collapse" id="sidebarCollapse_2">
                    <!-- Navigation -->
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="#sidebarElements" data-bs-toggle="collapse" role="button"
                                aria-expanded="false" aria-controls="sidebarElements">
                            Movimientos
                            </a>
                            <div class="collapse " id="sidebarElements">
                                <ul class="nav flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link" href="<?php echo $views;?>nominas/altas.php">Altas</a>
                                    </li><!--end nav-item--> 
                                    <li class="nav-item">
                                        <a class="nav-link" href="<?php echo $views;?>nominas/integracion_salarios.php">Integración de salario</a>
                                    </li><!--end nav-item-->
                                    <li class="nav-item">
                                        <a class="nav-link" href="<?php echo $views;?>nominas/bajas.php">Bajas</a>
                                    </li><!--end nav-item-->
                                </ul><!--end nav-->
                            </div><!--end sidebarElements-->
                        </li><!--end nav-item-->
                        <?php if($_SESSION['rol_gmt'] != "SEGURO"){ ?>
                        <li class="nav-item">
                            <a class="nav-link" href="#sidebarAdvancedUI" data-bs-toggle="collapse" role="button"
                                aria-expanded="false" aria-controls="sidebarAdvancedUI">
                                Nomina
                            </a>
                            <div class="collapse " id="sidebarAdvancedUI">
                                <ul class="nav flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link" href="<?php echo $views;?>nominas/validacion.php">Validación</a>
                                    </li><!--end nav-item-->
                                    <li class="nav-item">
                                        <a class="nav-link" href="<?php echo $views;?>nominas/prenomina.php">Prenomina</a>
                                    </li><!--end nav-item-->
                                    <li class="nav-item">
                                        <a class="nav-link" href="<?php echo $views;?>nominas/nomina.php">Nomina</a>
                                    </li><!--end nav-item-->
                                    <li class="nav-item">
                                        <a class="nav-link" href="<?php echo $views;?>nominas/procesar.php">Procesar</a>
                                    </li><!--end nav-item-->
                                </ul><!--end nav-->
                            </div><!--end sidebarAdvancedUI-->
                        </li><!--end nav-item--> 
                        <?php } ?>
                    </ul><!--end navbar-nav--->
                </div><!--end sidebarCollapse_2-->
            </div><!-- end Others -->

            <div id="MetricaFondos" class="main-icon-menu-pane tab-pane" role="tabpanel" aria-labelledby="pages-tab">
                <div class="fondos-box">
                    <h6 class="menu-title">Fondos y presupuestos</h6>
                </div>
                <ul class="navbar-nav">
                    <li class="nav-item">
                            <a class="nav-link" href="#sidebarpresupuestos" data-bs-toggle="collapse" role="button"
                                aria-expanded="false" aria-controls="sidebarpresupuestos">
                            Presupuestos
                            </a>
                            <div class="collapse " id="sidebarpresupuestos">
                                <ul class="nav flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link" href="<?php echo $views;?>presupuestos/altapresupuestos.php">Alta de presupuestos</a>
                                    </li><!--end nav-item--> 
                                    <li class="nav-item">
                                        <a class="nav-link" href="<?php echo $views;?>presupuestos/presupuestos.php">Presupuestos</a>
                                    </li><!--end nav-item-->
                                </ul><!--end nav-->
                            </div><!--end sidebarpresupuestos-->
                        </li><!--end nav-item-->

                        <li class="nav-item">
                            <a class="nav-link" href="#sidebarFondos" data-bs-toggle="collapse" role="button"
                                aria-expanded="false" aria-controls="sidebarFondos">
                                Fondos
                            </a>
                            <div class="collapse " id="sidebarFondos">
                                <ul class="nav flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link" href="<?php echo $views;?>presupuestos/solicitar_fondos.php">Solicitar fondos</a>
                                    </li><!--end nav-item-->
                                    <li class="nav-item">
                                        <a class="nav-link" href="<?php echo $views;?>presupuestos/mis_solicitudes.php">Mis solicitudes</a>
                                    </li><!--end nav-item-->
                                    <li class="nav-item">
                                        <a class="nav-link" href="<?php echo $views;?>presupuestos/consultar_solicitudes.php">Consultar solicitudes</a>
                                    </li><!--end nav-item-->
                                    <li class="nav-item">
                                        <a class="nav-link" href="<?php echo $views;?>presupuestos/comprobaciones.php">Comprobaciones</a>
                                    </li><!--end nav-item-->
                                </ul><!--end nav-->
                            </div><!--end sidebarFondos-->
                        </li><!--end nav-item--> 
                </ul><!--end nav-->
            </div><!-- end Pages -->







            <div id="MetricaGrouper" class="main-icon-menu-pane tab-pane" role="tabpanel"
                aria-labelledby="personal-tab">
                <div class="title-box">
                    <h6 class="menu-title">Grouper</h6>
                </div>

                <div class="collapse navbar-collapse" id="sidebarCollapse">
                    <!-- Navigation -->
                    <ul class="navbar-nav">
                        <?php //if($_SESSION['rol_gmt'] != "CONTRATOS"){ ?>
                        <li class="nav-item">
                            <a class="nav-link" href="#sidebarCrypto" data-bs-toggle="collapse" role="button"
                                aria-expanded="false" aria-controls="sidebarCrypto">
                                Clientes
                            </a>
                            <div class="collapse " id="sidebarCrypto">
                                <ul class="nav flex-column">
                                    <li class="nav-item">
                                    <a class="nav-link" href="<?php echo $views;?>grouper/clientes.php">Catalogo de Clientes</a>
                                    </li><!--end nav-item-->
                                    <li class="nav-item">
                                    <a class="nav-link" href="<?php echo $views;?>grouper/altaclientes.php">Alta Clientes</a>
                                    </li><!--end nav-item-->
                                </ul><!--end nav-->
                            </div><!--end sidebarCrypto-->
                        </li><!--end nav-item-->
                        <?php //} ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo $views;?>grouper/ejecutivos.php">Ejecutivos</a>
                        </li><!--end nav-item-->
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo $views;?>grouper/ccp.php">Clave Cliente Proyecto</a>
                        </li><!--end nav-item-->
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo $views;?>grouper/misccp.php">Mis Claves </a>
                        </li><!--end nav-item-->
                    </ul><!--end navbar-nav--->
                </div><!--end sidebarCollapse-->
            </div><!-- end Crypto -->

            <div id="MetricaRh" class="main-icon-menu-pane tab-pane" role="tabpanel"
                aria-labelledby="rh-tab">
                <div class="title-box">
                    <h6 class="menu-title">RH</h6>
                </div>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a href="#sidebarPortal " class="nav-link" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarPortal">
                            Portal 
                        </a>
                        <div class="collapse " id="sidebarPortal">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a class="nav-link" href="<?php echo $views;?>personal/publicar_solicitudes.php">Publicar Solicitudes</a>
                                </li><!--end nav-item-->
                                <li class="nav-item">
                                    <a class="nav-link" href="<?php echo $views;?>personal/postulaciones.php">Postulaciones</a>
                                </li><!--end nav-item-->
                                <li class="nav-item">
                                    <a class="nav-link" href="<?php echo $views;?>personal/vacantes.php">Vacantes</a>
                                </li><!--end nav-item-->
                            </ul><!--end nav-->
                        </div><!--end sidebarPortal-->
                    </li><!--end nav-item-->
                </ul><!--end nav-->
            </div><!-- end Authentication-->
        </div>
        <!--end menu-body-->
    </div><!-- end main-menu-inner-->
</div>