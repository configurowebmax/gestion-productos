<?php
// Incluir la conexión a la base de datos
include('../conn/conn.php');

// Verificar si se ha proporcionado un ID de producto
if (isset($_GET['id'])) {
    $productID = $_GET['id'];

    // Preparar y ejecutar la consulta para eliminar el producto
    $stmt = $conn->prepare("DELETE FROM tbl_product WHERE tbl_product_id = ?");
    $stmt->bindParam(1, $productID);

    if ($stmt->execute()) {
        // Redirigir a la página de productos después de eliminar con éxito
        header('Location: ../products.php');
        exit();
    } else {
        echo "Error al eliminar el producto.";
    }
} else {
    echo "ID de producto no proporcionado.";
}
