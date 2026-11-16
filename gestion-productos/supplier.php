<?php
session_start();

// Verificar si el usuario está logueado
if (!isset($_SESSION['user_id'])) {
    // Si no hay información de sesión, redirigir al usuario a la página de login
    header('Location: index.php');
    exit();
}

include("./conn/conn.php");

function escape($html)
{
    return htmlspecialchars($html, ENT_QUOTES, 'UTF-8');
}
?>

<!DOCTYPE html>
<html lang="es">

<?php include('assets/head.php'); ?>

<body>

    <?php include("./assets/header.php"); ?>

    <div class="main">
        <div class="product-container">
            <div class="row">
                <h4 class="col-10 mr-4">Lista de Proveedores</h4>
                <div class="button ml-5">
                    <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#addSupplierModal">Agregar Proveedor</button>
                </div>
            </div>
            <hr>
            <div class="table-container table-responsive">
                <table class="table table-sm text-center" id="supplierTable">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">ID del Proveedor</th>
                            <th scope="col">Nombre del Proveedor</th>
                            <th scope="col">Contacto</th>
                            <th scope="col">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $stmt = $conn->prepare("SELECT * FROM tbl_supplier");
                        $stmt->execute();
                        $result = $stmt->fetchAll();

                        foreach ($result as $row) {
                            $supplierID = escape($row["tbl_supplier_id"]);
                            $supplierName = escape($row["supplier_name"]);
                            $supplierContact = escape($row["supplier_contact"]);
                        ?>
                            <tr>
                                <th scope="row"><?= $supplierID ?></th>
                                <td id="supplierName-<?= $supplierID ?>"><?= $supplierName ?></td>
                                <td id="supplierContact-<?= $supplierID ?>"><?= $supplierContact ?></td>
                                <td>
                                    <div class="action-button">
                                        <button class="btn btn-secondary" onclick="updateSupplier(<?= $supplierID ?>)">&#128393;</button>
                                        <button class="btn btn-danger" onclick="deleteSupplier(<?= $supplierID ?>)">X</button>
                                    </div>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal para agregar proveedor -->
    <div class="modal fade" id="addSupplierModal" tabindex="-1" aria-labelledby="addSupplier" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addSupplier">Agregar Proveedor</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="./endpoint/add-supplier.php" method="POST">
                        <div class="form-group">
                            <label for="supplierName">Nombre del Proveedor:</label>
                            <input type="text" class="form-control" id="supplierName" name="supplier_name" required>
                        </div>
                        <div class="form-group">
                            <label for="supplierContact">Contacto del Proveedor:</label>
                            <input type="text" class="form-control" id="supplierContact" name="supplier_contact" required>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-dark">Agregar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para actualizar proveedor -->
    <div class="modal fade" id="updateSupplierModal" tabindex="-1" aria-labelledby="updateSupplier" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateSupplier">Actualizar Proveedor</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="./endpoint/update-supplier.php" method="POST">
                        <input type="hidden" id="updateSupplierID" name="tbl_supplier_id">
                        <div class="form-group">
                            <label for="updateSupplierName">Nombre del Proveedor:</label>
                            <input type="text" class="form-control" id="updateSupplierName" name="supplier_name" required>
                        </div>
                        <div class="form-group">
                            <label for="updateSupplierContact">Contacto del Proveedor:</label>
                            <input type="text" class="form-control" id="updateSupplierContact" name="supplier_contact" required>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-dark">Guardar cambios</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>

    <!-- Data Table -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.js"></script>

    <!-- Custom JS -->
    <script src="assets/script.js"></script>
</body>

</html>