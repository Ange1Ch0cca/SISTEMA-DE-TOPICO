<?php
// Incluir archivo de conexión a la base de datos
include '../services/conexion.php';

// Consulta para obtener todos los medicamentos
$query = "SELECT id, nombre, presentacion, marca, cantidad_ingreso, fecha_vencimiento, categoria, laboratorio, lote, fecha_ingreso, proveedor FROM medicamentos";
$resultado = $conn->query($query);
?>


<!DOCTYPE html>
<html lang="en">

<?php include '../layout/head.php'; ?>

<body>

    <!-- Begin page -->
    <div id="../layout-wrapper">
        <div class="header-border"></div>

        <?php include '../layout/header.php'; ?>

        <?php include '../layout/sidebar.php'; ?>


        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">

            <div class="page-content">
                <div class="container-fluid">

                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-flex align-items-center justify-content-between">
                                <h4 class="mb-0 font-size-18">Medicamentos <i
                                        class="fas fa-capsules"></i></h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">SISTOPI</a></li>
                                        <li class="breadcrumb-item active">Medicamentos</li>
                                    </ol>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Lista de Medicamentos</h4>
                                    <p class="card-subtitle mb-4">
                                        La función del buscador es general.
                                    </p>

                                    <table id="state-saving-datatable" class="table activate-select dt-responsive nowrap">
                                        <thead>
                                            <tr>
                                                <th>Nombre</th>
                                                <th>Composición</th>
                                                <th>Presentación</th>
                                                <th>Stock</th>
                                                <th>Categoría</th>
                                                <th>Laboratorio</th>
                                                <th>Proveedor</th>
                                                <th>Lote</th>
                                                <th>Vencimiento</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php
                                            // Consulta SQL para la tabla 'medicamentos'
                                            $sql = "SELECT 
                    m.id, 
                    m.nombre, 
                    m.marca, 
                    m.presentacion, 
                    m.cantidad_ingreso, 
                    m.categoria, 
                    m.laboratorio, 
                    m.proveedor, 
                    m.lote, 
                    m.fecha_vencimiento, 
                    IFNULL(SUM(ai.cantidad), 0) AS salida
                FROM 
                    medicamentos m
                LEFT JOIN 
                    atencion_insumos ai ON m.nombre = ai.insumo_medico
                GROUP BY 
                    m.id, m.nombre, m.marca, m.presentacion, m.cantidad_ingreso, m.categoria, m.laboratorio, m.proveedor, m.lote, m.fecha_vencimiento";

                                            $resultado = $conn->query($sql); // Ejecutar la consulta

                                            if ($resultado->num_rows > 0):
                                                while ($medicamento = $resultado->fetch_assoc()):
                                                    // Cálculo del stock final
                                                    $stock_final = $medicamento['cantidad_ingreso'] - $medicamento['salida'];
                                            ?>
                                                    <tr>
                                                        <td><?php echo htmlspecialchars($medicamento['nombre']); ?></td>
                                                        <td><?php echo htmlspecialchars($medicamento['marca']); ?></td>
                                                        <td><?php echo htmlspecialchars($medicamento['presentacion']); ?></td>
                                                        <td><?php echo htmlspecialchars($stock_final); ?></td> <!-- Aquí mostramos el stock -->
                                                        <td><?php echo htmlspecialchars($medicamento['categoria']); ?></td>
                                                        <td><?php echo htmlspecialchars($medicamento['laboratorio']); ?></td>
                                                        <td><?php echo htmlspecialchars($medicamento['proveedor']); ?></td>
                                                        <td><?php echo htmlspecialchars($medicamento['lote']); ?></td>
                                                        <td><?php echo htmlspecialchars($medicamento['fecha_vencimiento']); ?></td>
                                                    </tr>
                                                <?php endwhile; ?>
                                            <?php else: ?>
                                                <tr>
                                                    <td colspan="9" class="text-center">No se encontraron medicamentos en el almacén.</td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>


                                </div> <!-- end card body-->
                            </div> <!-- end card -->
                        </div><!-- end col-->
                    </div>
                    <!-- end row-->

                </div> <!-- container-fluid -->
            </div>
            <!-- End Page-content -->

            <?php include '../layout/footer.php'; ?>

        </div>
        <!-- END ../layout-wrapper -->

        <!-- Overlay-->
        <div class="menu-overlay"></div>


        <!-- jQuery  -->
        <script src="../assets/js/jquery.min.js"></script>
        <script src="../assets/js/bootstrap.bundle.min.js"></script>
        <script src="../assets/js/metismenu.min.js"></script>
        <script src="../assets/js/waves.js"></script>
        <script src="../assets/js/simplebar.min.js"></script>

        <!-- third party js -->
        <script src="../plugins/datatables/jquery.dataTables.min.js"></script>
        <script src="../plugins/datatables/dataTables.bootstrap4.js"></script>
        <script src="../plugins/datatables/dataTables.responsive.min.js"></script>
        <script src="../plugins/datatables/responsive.bootstrap4.min.js"></script>
        <script src="../plugins/datatables/dataTables.buttons.min.js"></script>
        <script src="../plugins/datatables/buttons.bootstrap4.min.js"></script>
        <script src="../plugins/datatables/buttons.html5.min.js"></script>
        <script src="../plugins/datatables/buttons.flash.min.js"></script>
        <script src="../plugins/datatables/buttons.print.min.js"></script>
        <script src="../plugins/datatables/dataTables.keyTable.min.js"></script>
        <script src="../plugins/datatables/dataTables.select.min.js"></script>
        <script src="../plugins/datatables/pdfmake.min.js"></script>
        <script src="../plugins/datatables/vfs_fonts.js"></script>
        <!-- third party js ends -->

        <!-- Datatables init -->
        <script src="../assets/pages/datatables-demo.js"></script>


        <!-- Sparkline Js-->
        <script src="../plugins/jquery-sparkline/jquery.sparkline.min.js"></script>

        <!-- Chart Js-->
        <script src="../plugins/jquery-knob/jquery.knob.min.js"></script>

        <!-- Chart Custom Js-->
        <script src="../assets/pages/knob-chart-demo.js"></script>


        <!-- Morris Js-->
        <script src="../plugins/morris-js/morris.min.js"></script>

        <!-- Raphael Js-->
        <script src="../plugins/raphael/raphael.min.js"></script>

        <!-- Custom Js -->
        <script src="../assets/pages/dashboard-demo.js"></script>

        <!-- App js -->
        <script src="../assets/js/theme.js"></script>

</body>

</html>