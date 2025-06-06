<?php
// Incluir archivo de conexión a la base de datos
include '../services/conexion.php';

$id = $_GET['id'] ?? null;

// Recuperar datos actuales del mmedicamento si se ha proporcionado un ID
if ($id) {
    $query = "SELECT * FROM mmedicamentos WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $mmedicamento = $result->fetch_assoc();
}

// Procesar actualización cuando se envía el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $presentacion = $_POST['presentacion'];
    $marca = $_POST['marca'];
    $cantidad = $_POST['cantidad'];
    $fecha_vencimiento = $_POST['fecha_vencimiento'];
    $categoria = $_POST['categoria'];
    $laboratorio = $_POST['laboratorio'];
    $lote = $_POST['lote'];
    $fecha_ingreso = $_POST['fecha_ingreso'];
    $proveedor = $_POST['proveedor'];

    $update_query = "UPDATE mmedicamentos SET nombre = ?, presentacion = ?, marca = ?, cantidad_ingreso = ?, fecha_vencimiento = ?, categoria = ?, laboratorio = ?, lote = ?, fecha_ingreso = ?, proveedor = ? WHERE id = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("sssissssssi", $nombre, $presentacion, $marca, $cantidad, $fecha_vencimiento, $categoria, $laboratorio, $lote, $fecha_ingreso, $proveedor, $id);

    if ($stmt->execute()) {
        header("Location: ../view/almacen_mmedico.php");
        exit();
    } else {
        echo "Error al actualizar el material medico.";
    }
}

// Consulta para obtener solo los nombres de las categorías
$query = "SELECT nombre FROM categoria";
$resultado = $conn->query($query);

// Almacenar resultados en un array
$categorias = [];
while ($fila = $resultado->fetch_assoc()) {
    $categorias[] = $fila['nombre'];
}

// Consulta para obtener solo los nombres de los laboratorios
$query = "SELECT nombre FROM laboratorio";
$resultado = $conn->query($query);

// Almacenar resultados en un array
$laboratorios = [];
while ($fila = $resultado->fetch_assoc()) {
    $laboratorios[] = $fila['nombre'];
}

// Consulta para obtener solo los nombres de los proveedores
$query = "SELECT razon_social FROM proveedores";
$resultado = $conn->query($query);

// Almacenar resultados en un array
$proveedores = [];
while ($fila = $resultado->fetch_assoc()) {
    $proveedores[] = $fila['razon_social'];
}

// Cerrar conexión a la base de datos
$conn->close();
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
                                <h4 class="mb-0 font-size-18">Editar Material Medico</h4>
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">SISTOPI</a></li>
                                        <li class="breadcrumb-item active">Editar Material Médico</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Editar Material Médico</h4>
                                    <form class="needs-validation" novalidate action="editar_mmedico.php?id=<?= $id ?>" method="POST">
                                        <input type="hidden" name="id" value="<?= htmlspecialchars($id) ?>">
                                        <div class="form-row">
                                            <div class="col-md-4 mb-3">
                                                <label for="validationTooltip01">Nombre</label>
                                                <input type="text" class="form-control" id="validationTooltip01" name="nombre" required value="<?= htmlspecialchars($mmedicamento['nombre']) ?>">
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label for="validationTooltip02">Presentación</label>
                                                <input type="text" class="form-control" id="validationTooltip02" name="presentacion" required value="<?= htmlspecialchars($mmedicamento['presentacion']) ?>">
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label for="validationTooltip03">Marca</label>
                                                <input type="text" class="form-control" id="validationTooltip03" name="marca" required value="<?= htmlspecialchars($mmedicamento['marca']) ?>">
                                            </div>
                                            <div class="col-md-2 mb-3">
                                                <label for="validationTooltip04">Cantidad/Unidades</label>
                                                <input type="text" class="form-control" id="validationTooltip04" name="cantidad" required pattern="[1-9][0-9]*" value="<?= htmlspecialchars($mmedicamento['cantidad_ingreso']) ?>" oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/^0+/, '')">
                                                <div class="invalid-tooltip">Cantidad inválida.</div>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-md-3 mb-3">
                                                <label for="fecha_vencimiento">Fecha de Vencimiento</label>
                                                <input type="date" name="fecha_vencimiento" class="form-control" id="fecha_vencimiento" required value="<?= htmlspecialchars($mmedicamento['fecha_vencimiento']) ?>">
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label for="categoria">Categoría</label>
                                                <select class="form-control mb-3" name="categoria" required>
                                                    <option disabled>Seleccionar</option>
                                                    <?php foreach ($categorias as $categoria): ?>
                                                        <option <?= $categoria == $mmedicamento['categoria'] ? 'selected' : '' ?>><?= htmlspecialchars($categoria) ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label for="laboratorio">Laboratorio</label>
                                                <select class="form-control mb-3" name="laboratorio" required>
                                                    <option disabled>Seleccionar</option>
                                                    <?php foreach ($laboratorios as $laboratorio): ?>
                                                        <option <?= $laboratorio == $mmedicamento['laboratorio'] ? 'selected' : '' ?>><?= htmlspecialchars($laboratorio) ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            <div class="col-md-2 mb-3">
                                                <label for="lote">Lote</label>
                                                <input type="text" class="form-control" id="lote" name="lote" required pattern="\d*" value="<?= htmlspecialchars($mmedicamento['lote']) ?>" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-md-3 mb-3">
                                                <label for="fecha_ingreso">Fecha de Ingreso</label>
                                                <input type="date" class="form-control" id="fecha_ingreso" name="fecha_ingreso" autocomplete="off" value="<?= htmlspecialchars($mmedicamento['fecha_ingreso']) ?>">
                                            </div>
                                            <div class="col-md-3 mb-3 ml-auto">
                                                <label for="proveedor">Proveedor</label>
                                                <select class="form-control mb-3" name="proveedor" required>
                                                    <option disabled>Seleccionar</option>
                                                    <?php foreach ($proveedores as $proveedor): ?>
                                                        <option <?= $proveedor == $mmedicamento['proveedor'] ? 'selected' : '' ?>><?= htmlspecialchars($proveedor) ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <button class="btn btn-primary waves-effect waves-light" type="submit">Guardar</button>
                                        <a class="btn btn-secondary waves-effect" href="../view/almacen_mmedico.php">Cancelar</a>
                                    </form>

                                </div> <!-- end card-body-->
                            </div> <!-- end card -->
                        </div> <!-- end col-->
                    </div> <!-- end row -->

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