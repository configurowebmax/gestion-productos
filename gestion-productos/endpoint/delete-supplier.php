<?php
include('../conn/conn.php');

if (isset($_GET['id'])) {
    $supplierID = $_GET['id'];

    $stmt = $conn->prepare("DELETE FROM tbl_supplier WHERE tbl_supplier_id = ?");
    $stmt->bindParam(1, $supplierID);

    if ($stmt->execute()) {
        header('Location: ../supplier.php');
        exit();
    } else {
        echo "Error al eliminar el proveedor.";
    }
} else {
    echo "ID del proveedor no proporcionado.";
}
