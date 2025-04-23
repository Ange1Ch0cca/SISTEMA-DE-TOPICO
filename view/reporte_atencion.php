<?php
// Incluir el archivo de conexión
include('../services/conexion.php');

// Consulta SQL para obtener los datos
$sql = "
    SELECT 
        a.id AS atencion_id,
        a.dni,
        CONCAT(a.nombres, ' ', a.apellidos) AS nombre_completo,
        a.programa_estudios,
        a.encargado,
        a.fecha_atencion,
        a.procedimiento
    FROM 
        atenciones a
    ORDER BY 
        a.id DESC;  -- Se ordena por ID en orden descendente
";

// Ejecutar la consulta
$resultado = mysqli_query($conn, $sql);

if (!$resultado) {
    die("Error en la consulta: " . mysqli_error($conn));
}
?>


<!DOCTYPE html>
<html lang="en">

<?php include '../layout/head.php'; ?>

<body>

    <!-- Begin page -->
    <div id="layout-wrapper">
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
                                <h4 class="mb-0 font-size-18">Reporte de Atención</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">SISTOPI</a></li>
                                        <li class="breadcrumb-item active">Reporte de Atención</li>
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
                                    <p class="card-subtitle mb-4">
                                        <strong>IMPORTANTE:</strong> Para exportar el reporte correctamente presionar en el botón <strong>PDF</strong>
                                    </p>
                                    <table id="datatable-buttons" class="table table-striped dt-responsive nowrap">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>DNI</th>
                                                <th>Nombre</th>
                                                <th>P.E.</th>
                                                <th>Insumos</th>
                                                <th>Responsable</th>
                                                <th>Fecha</th>
                                                <th>Proc.</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            // Verificar si la consulta ha devuelto resultados
                                            if (mysqli_num_rows($resultado) > 0) {
                                                // Si hay resultados, mostrar las filas de la tabla
                                                while ($row = mysqli_fetch_assoc($resultado)) {
                                            ?>
                                                    <tr>
                                                        <!-- Mostrar el ID de la atención en la columna # -->
                                                        <td><?php echo $row['atencion_id']; ?></td>
                                                        <td><?php echo $row['dni']; ?></td>
                                                        <td><?php echo $row['nombre_completo']; ?></td>
                                                        <td><?php echo $row['programa_estudios']; ?></td>

                                                        <!-- Mostrar los insumos con su cantidad -->
                                                        <td>
                                                            <?php
                                                            // Obtener los insumos y cantidades de la atención actual
                                                            $insumoQuery = "SELECT * FROM atencion_insumos WHERE atencion_id = " . $row['atencion_id'];
                                                            $insumoResult = mysqli_query($conn, $insumoQuery);
                                                            $insumosHtml = '';
                                                            while ($insumo = mysqli_fetch_assoc($insumoResult)) {
                                                                $insumosHtml .= $insumo['insumo_medico'] . " (Cantidad: " . $insumo['cantidad'] . ")<br>";
                                                            }
                                                            echo $insumosHtml;
                                                            ?>
                                                        </td>

                                                        <td><?php echo $row['encargado']; ?></td>
                                                        <td><?php echo date('d/m/Y', strtotime($row['fecha_atencion'])); ?></td>

                                                        <!-- Mostrar el procedimiento directamente en la tabla -->
                                                        <td>
                                                            <?php
                                                            // Mostrar el procedimiento de atención directamente en la tabla
                                                            echo $row['procedimiento'];
                                                            ?>
                                                        </td>
                                                    </tr>
                                                <?php
                                                }
                                            } else {
                                                // Si no hay registros, mostrar un mensaje indicando que no hay datos
                                                ?>
                                                <tr>
                                                    <td colspan="9" class="text-center">No se encontraron registros</td>
                                                </tr>
                                            <?php
                                            }
                                            ?>
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
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->

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

    <!-- App js -->
    <script src="../assets/js/theme.js"></script>

</body>

</html>