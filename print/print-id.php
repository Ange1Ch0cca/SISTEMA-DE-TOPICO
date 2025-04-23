<?php
include('../services/conexion.php'); // Asegúrate de que esto conecta con tu base de datos

// Verifica si el parámetro 'id' está presente en la URL
if (isset($_GET['id'])) {
    $id_atencion = $_GET['id'];

    // Consulta para obtener los detalles de la atención
    $query_atencion = "SELECT * FROM atenciones WHERE id = $id_atencion";
    $result_atencion = mysqli_query($conn, $query_atencion);

    // Si se encuentran los detalles de la atención
    if ($result_atencion && mysqli_num_rows($result_atencion) > 0) {
        $atencion = mysqli_fetch_assoc($result_atencion);

        // Recuperar los datos de la atención
        $dni = $atencion['dni'];
        $nombres = $atencion['nombres'];
        $apellidos = $atencion['apellidos'];
        $fecha_atencion = $atencion['fecha_atencion'];
        $programa_estudios = $atencion['programa_estudios'];
        $semestre = $atencion['semestre'];
        $procedimiento = $atencion['procedimiento'];
        $encargado = $atencion['encargado'];

        // Consulta para obtener los insumos asociados a esta atención
        $query_insumos = "SELECT * FROM atencion_insumos WHERE atencion_id = $id_atencion";
        $result_insumos = mysqli_query($conn, $query_insumos);
        $insumos = mysqli_fetch_all($result_insumos, MYSQLI_ASSOC);
    } else {
        echo "No se encontró la atención con el ID proporcionado.";
        exit;
    }
} else {
    echo "No se ha proporcionado un ID de atención.";
    exit;
}
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
                                <h4 class="mb-0 font-size-18">Imprimir Atención <i
                                        class="fas fa-print"></i></h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">SISTOPI</a></li>
                                        <li class="breadcrumb-item active">Imprimir Atención</li>
                                    </ol>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="clearfix">
                                        <div class="float-left">
                                            <h4 class="m-0 d-print-none"><b>CONSTACIA DE ATENCIÓN</b></h4>
                                        </div>
                                    </div>

                                    <div class="d-print-none my-4">
                                        <div class="text-right">
                                            <a href="../view/atencion.php" class="btn btn-danger waves-effect waves-light">No Imprimir</a>
                                            <a href="javascript:window.print()" class="btn btn-primary waves-effect waves-light"><i class="fa fa-print m-r-5"></i> Imprimir</a>
                                        </div>
                                    </div>

                                    <div class="row mt-4">
                                        <div class="col-6">
                                            <div class="mt-3 float-left">
                                                <p class="mb-2">No. de ATENCIÓN: <strong><?php echo $id_atencion; ?></strong></p>
                                                <p class="mb-2"><strong>TÓPICO I.E.S.T.P. HUANTA</strong></p>
                                                <p class="mb-2"><strong>JR. GENERAL CÓRDOVA 167</strong></p>
                                                <p class="mb-2"><strong>PACIENTE: </strong> <?php echo $apellidos . ' ' . $nombres; ?></p>
                                                <p class="m-b-10"><strong>PROGRAMA DE ESTUDIOS: </strong> <?php echo $programa_estudios; ?></p>
                                            </div>
                                        </div><!-- end col -->
                                        <div class="col-6">
                                            <div class="mt-3 float-right">
                                                <p class="mb-2">FECHA ATENCIÓN: <strong><?php echo date("d/m/Y", strtotime($fecha_atencion)); ?></strong></p>
                                                <p class="mb-2"><br></p>
                                                <p class="mb-2"><br></p>
                                                <p class="mb-2"><strong>DNI: </strong> <?php echo $dni; ?></p>
                                                <p class="m-b-10"><strong>SEMESTRE: </strong> <?php echo $semestre; ?></p>
                                            </div>
                                        </div><!-- end col -->
                                    </div>

                                    <!-- Tabla de insumos -->
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="table-responsive">
                                                <table class="table mt-4">
                                                    <thead>
                                                        <tr>
                                                            <th>No</th>
                                                            <th>CÓDIGO</th>
                                                            <th>INSUMOS MÉDICOS</th>
                                                            <th class="text-right">CANT.</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        // Enumerar los insumos y mostrar las filas de la tabla
                                                        $counter = 1;
                                                        foreach ($insumos as $insumo) {
                                                            echo "<tr>";
                                                            echo "<td>" . $counter++ . "</td>";  // Enumerar
                                                            echo "<td>" . htmlspecialchars($insumo['codigo']) . "</td>";  // Código
                                                            echo "<td>" . htmlspecialchars($insumo['insumo_medico']) . "</td>";  // Insumo Médico
                                                            echo "<td class='text-right'>" . htmlspecialchars($insumo['cantidad']) . "</td>";  // Cantidad
                                                            echo "</tr>";
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
                                                <p><strong>PROCEDIMIENTO:</strong><br> <?php echo nl2br($procedimiento); ?></p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Firma del paciente y encargado -->
                                    <div class="row mt-5">
                                        <div class="col-6">
                                            <div class="mt-5 float-left ml-5 text-center">
                                                <hr style="border-top: 1px solid grey; width: 100%;"><br>
                                                <p class="mb-2">FIRMA DEL PACIENTE</p>
                                            </div>
                                        </div><!-- end col -->

                                        <div class="col-6">
                                            <div class="mt-5 float-right mr-5 text-center">
                                                <hr style="border-top: 1px solid grey; width: 100%;"><br>
                                                <p class="mb-2">FIRMA DEL ENCARGADO</p>
                                            </div>
                                        </div><!-- end col -->
                                    </div>

                                    <!-- Mensaje de advertencia -->
                                    <div class="row">
                                        <div class="col-12 mt-2">
                                            <center>
                                                <h6>TODA ENMENDADURA O DETERIORO INVALIDA LA CONSTANCIA DE ATENCIÓN</h6>
                                            </center>
                                        </div>
                                    </div>

                                    <!-- Información del encargado -->
                                    <div class="row">
                                        <div class="col-4">
                                            <div class="float-left ml-5">
                                                <p class="mb-2">ENCARGADO: <strong><?php echo nl2br($encargado); ?></strong></p>
                                            </div>
                                        </div><!-- end col -->
                                        <div class="col-4">
                                            <div class="float-center">
                                                <p class="mb-2">FEC.IMPRESIÓN: <strong id="fechaImpresion"></strong></p>
                                            </div>
                                        </div>

                                        <script>
                                            // Obtener la fecha actual en la zona horaria de Lima, Perú
                                            const options = {
                                                timeZone: 'America/Lima',
                                                year: 'numeric',
                                                month: '2-digit',
                                                day: '2-digit'
                                            };
                                            const fechaLima = new Date().toLocaleDateString('es-PE', options).replace(/\//g, '/');
                                            document.getElementById('fechaImpresion').textContent = fechaLima;
                                        </script>

                                        <div class="col-4">
                                            <div class="float-right mr-5">
                                                <p class="mb-2">HORA DE IMPRESIÓN: <strong id="horaActual"></strong></p>
                                            </div>
                                        </div>

                                        <script>
                                            // Función para actualizar la hora en tiempo real en la zona horaria de Lima, Perú
                                            function actualizarHora() {
                                                const options = {
                                                    timeZone: 'America/Lima',
                                                    hour: '2-digit',
                                                    minute: '2-digit',
                                                    hour12: false
                                                };
                                                const horaLima = new Date().toLocaleTimeString('es-PE', options);
                                                document.getElementById('horaActual').textContent = horaLima;
                                            }

                                            // Llamar a la función para mostrar la hora actual
                                            actualizarHora();

                                            // Actualizar cada minuto
                                            setInterval(actualizarHora, 60000);
                                        </script>
                                    </div>

                                </div><!-- end card-body -->
                            </div><!-- end card -->
                        </div><!-- end col -->
                    </div><!-- end row -->
                </div>
            </div> <!-- end card-->
        </div> <!-- end col -->
    </div>
    <!-- end row -->

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