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
                <div class="button ml-3">
                    <style>
                        @media only screen and (max-width: 1200px) {
                            .mobile-spacing {
                                height: 28em;
                            }
                        }
                    </style>
                    <div class="mobile-spacing"></div>
                    <button type="button" class="btn btn-success" onclick="printProducts()">Imprimir</button>
                    <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#addProductModal">Agregar Producto</button>
                    <button type="button" class="btn btn-info" id="enviarConfiguroweb">Para más desarrollos ConfiguroWeb</button>
                </div>
            </div>
            <hr>
            <div class="table-container table-responsive">
                <table class="table table-sm text-center" id="productTable">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">ID del Producto</th>
                            <th scope="col">Nombre del Producto</th>
                            <th scope="col">Proveedor</th>
                            <th scope="col">Precio de Compra</th>
                            <th scope="col">Precio de Venta</th>
                            <th scope="col">Existencias</th>
                            <th scope="col">Fecha de Actualización</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $stmt = $conn->prepare("SELECT * FROM tbl_product LEFT JOIN tbl_supplier ON tbl_product.tbl_supplier_id = tbl_supplier.tbl_supplier_id");
                        $stmt->execute();
                        $result = $stmt->fetchAll();

                        foreach ($result as $row) {
                            $productID = escape($row["tbl_product_id"]);
                            $productName = escape($row["product_name"]);
                            $supplierID = escape($row["tbl_supplier_id"]);
                            $productSupplier = escape($row["supplier_name"]);
                            $purchase = escape($row["purchase"]);
                            $selling = escape($row["selling"]);
                            $stock = escape($row["stock"]);
                            $dateUpdated = escape($row["date_updated"]);
                        ?>
                            <tr>
                                <th scope="row"><?= $productID ?></th>
                                <td id="productName-<?= $productID ?>"><?= $productName ?></td>
                                <td id="productSupplier-<?= $productID ?>"><?= $productSupplier ?></td>
                                <td id="purchase-<?= $productID ?>"><?= $purchase ?></td>
                                <td id="selling-<?= $productID ?>"><?= $selling ?></td>
                                <td id="stock-<?= $productID ?>"><?= $stock ?></td>
                                <td><?= $dateUpdated ?></td>
                                <td>
                                    <div class="action-button">
                                        <button class="btn btn-secondary" onclick="updateProduct(<?= $productID ?>)">&#128393;</button>
                                        <button class="btn btn-danger" onclick="deleteProduct(<?= $productID ?>)">X</button>
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

    <!-- Modal para agregar producto -->
    <div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProduct" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addProduct">Agregar Producto</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="./endpoint/add-product.php" method="POST">
                        <div class="form-group">
                            <label for="productName">Nombre del Producto:</label>
                            <input type="text" class="form-control" id="productName" name="product_name" required>
                        </div>
                        <div class="form-group">
                            <label for="productSupplier">Proveedor:</label>
                            <select class="form-control" name="tbl_supplier_id" id="productSupplier" required>
                                <option value="">-seleccionar-</option>
                                <?php
                                $stmt = $conn->prepare("SELECT * FROM tbl_supplier");
                                $stmt->execute();
                                $result = $stmt->fetchAll();

                                foreach ($result as $row) {
                                    $supplierID = escape($row['tbl_supplier_id']);
                                    $supplierName = escape($row['supplier_name']);
                                ?>
                                    <option value="<?= $supplierID ?>"><?= $supplierName ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-4">
                                <label for="purchase">Precio de Compra:</label>
                                <input type="number" class="form-control" id="purchase" name="purchase" required>
                            </div>
                            <div class="form-group col-4">
                                <label for="selling">Precio de Venta:</label>
                                <input type="number" class="form-control" id="selling" name="selling" required>
                            </div>
                            <div class="form-group col-4">
                                <label for="stock">Existencias:</label>
                                <input type="number" class="form-control" id="stock" name="stock" required>
                            </div>
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

    <!-- Modal para actualizar producto -->
    <div class="modal fade" id="updateProductModal" tabindex="-1" aria-labelledby="updateProduct" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateProduct">Actualizar Producto</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="./endpoint/update-product.php" method="POST">
                        <input type="hidden" class="form-control" id="updateProductID" name="tbl_product_id">
                        <div class="form-group">
                            <label for="updateProductName">Nombre del Producto:</label>
                            <input type="text" class="form-control" id="updateProductName" name="product_name" required>
                        </div>
                        <div class="form-group">
                            <label for="updateProductSupplier">Proveedor:</label>
                            <select class="form-control" name="tbl_supplier_id" id="updateProductSupplier" required>
                                <option value="">-seleccionar-</option>
                                <?php
                                $stmt = $conn->prepare("SELECT * FROM tbl_supplier");
                                $stmt->execute();
                                $result = $stmt->fetchAll();

                                foreach ($result as $row) {
                                    $supplierID = escape($row['tbl_supplier_id']);
                                    $supplierName = escape($row['supplier_name']);
                                ?>
                                    <option value="<?= $supplierID ?>"><?= $supplierName ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-4">
                                <label for="updatePurchase">Precio de Compra:</label>
                                <input type="number" class="form-control" id="updatePurchase" name="purchase" required>
                            </div>
                            <div class="form-group col-4">
                                <label for="updateSelling">Precio de Venta:</label>
                                <input type="number" class="form-control" id="updateSelling" name="selling" required>
                            </div>
                            <div class="form-group col-4">
                                <label for="updateStock">Existencias:</label>
                                <input type="number" class="form-control" id="updateStock" name="stock" required>
                            </div>
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
    <script src="assets/script.js"></script>

</body>

</html>