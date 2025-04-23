<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">
    <div data-simplebar class="h-100">

        <div class="navbar-brand-box">
            <a href="../view/dashboard.php" class="logo">
                <img width="50px" src="../assets/images/Logo_Sistopi.png" alt="LogoSistopi">
                <span>
                    SISTOPI
                </span>
            </a>
        </div>

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title">Menu</li>

                <li>
                    <a href="../view/dashboard.php" class="waves-effect"><i class="mdi mdi-home-analytics"></i><span>Dashboard</span></a>
                </li>

                <!-- Mostrar solo para Atencion, Almacen, y Administrador -->
                <?php if ($_SESSION['cargo'] == 'Administrador' || $_SESSION['cargo'] == 'Atencion'): ?>
                    <li><a href="../view/atencion.php" class="waves-effect"><i class="fas fa-user-md"></i><span>Atención</span></a></li>
                <?php endif; ?>

                <!-- Mostrar solo para Administrador, Atencion y Almacen -->
                <?php if ($_SESSION['cargo'] == 'Administrador' || $_SESSION['cargo'] == 'Atencion'): ?>
                    <li><a href="../view/medicamentos.php" class="waves-effect"><i class="fas fa-capsules"></i><span>Medicamentos</span></a></li>
                <?php endif; ?>

                <!-- Mostrar solo para Atencion, Almacen y Administrador -->
                <?php if ($_SESSION['cargo'] == 'Administrador' || $_SESSION['cargo'] == 'Atencion'): ?>
                    <li><a href="../view/mmedico.php" class="waves-effect"><i class="fas fa-briefcase-medical"></i><span>Materiales Médicos</span></a></li>
                <?php endif; ?>

                <!-- Mostrar solo para Almacen y Administrador -->
                <?php if ($_SESSION['cargo'] == 'Administrador' || $_SESSION['cargo'] == 'Almacen'): ?>
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect"><i class="fas fa-boxes"></i><span>Almacén</span></a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="../view/almacen_medicamentos.php">Medicamentos</a></li>
                            <li><a href="../view/almacen_mmedico.php">Materiales Médicos</a></li>
                            <li><a href="../view/categorias.php">Categorías</a></li>
                            <li><a href="../view/laboratorios.php">Laboratorios</a></li>
                            <li><a href="../view/proveedores.php">Proveedores</a></li>
                        </ul>
                    </li>
                <?php endif; ?>

                <!-- Mostrar solo para Administrador -->
                <?php if ($_SESSION['cargo'] == 'Administrador'): ?>
                    <li><a href="../view/pacientes.php" class="waves-effect"><i class="fas fa-user-injured"></i><span>Pacientes</span></a></li>
                    <li><a href="../view/usuarios.php" class="waves-effect"><i class="fas fa-users-cog"></i><span>Usuarios</span></a></li>
                <?php endif; ?>
            </ul>

            <!-- Reportes -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title">Reportes</li>

                <!-- Mostrar para Administrador, Atencion, Almacen -->
                <?php if ($_SESSION['cargo'] == 'Administrador'): ?>
                    <li><a href="../view/reporte_atencion.php" class="waves-effect"><i class="fas fa-file-medical-alt"></i><span>Atención</span></a></li>
                <?php endif; ?>

                <!-- Mostrar para Administrador, Atencion, Almacen -->
                <?php if ($_SESSION['cargo'] == 'Administrador' || $_SESSION['cargo'] == 'Almacen'): ?>
                    <li><a href="../view/reporte_medicamento.php" class="waves-effect"><i class="fas fa-file-alt"></i><span>Medicamentos</span></a></li>
                <?php endif; ?>

                <!-- Mostrar para Administrador, Atencion, Almacen -->
                <?php if ($_SESSION['cargo'] == 'Administrador' || $_SESSION['cargo'] == 'Almacen'): ?>
                    <li><a href="../view/reporte_mmedico.php" class="waves-effect"><i class="fas fa-file-alt"></i><span>Material Médico</span></a></li>
                <?php endif; ?>
            </ul>

            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title">Datos de la Empresa</li>

                <li><a href="../view/datos_empresa.php" class="waves-effect"><i class="fas fa-city"></i><span>Empresa</span></a></li>
            </ul>

            <ul class="metismenu list-unstyled" id="side-menu">
                <?php if ($_SESSION['cargo'] == 'Administrador'): ?>
                    <div class="mt-3">
                        <a href="https://wa.me/51955436291?text=Hola,%20estoy%20interesado%20en%20contratar%20su%20sistema%20de%20tópico." target="_blank" class="btn btn-secondary buynow-link w-100 px-2">
                            Contratar Sistema
                        </a>
                    </div>
                    <div class="mt-3 mb-5">
                        <a href="https://wa.me/51906829934?text=Hola,%20quiero%20contactar%20con%20el%20departamento%20de%20sistemas%20para%20desarrollar%20un%20proyecto%20que%20tengo%20en%20mente." target="_blank" class="btn btn-dark buynow-link w-100 px-2">
                            Departamento de Sistemas
                        </a>
                    </div>
                <?php endif; ?>
            </ul>
        </div>
    </div>
    <!-- Sidebar End -->
</div>