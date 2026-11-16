<?php
include("../conn/conn.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['product_name'], $_POST['tbl_supplier_id'], $_POST['purchase'], $_POST['selling'], $_POST['stock'])) {
        $productName = $_POST['product_name'];
        $productSupplier = $_POST['tbl_supplier_id'];
        $purchase = $_POST['purchase'];
        $selling = $_POST['selling'];
        $stock = $_POST['stock'];
        $dateUpdated = date("Y-m-d H:i:s");

        try {
            $stmt = $conn->prepare("INSERT INTO tbl_product (product_name, tbl_supplier_id, purchase, selling, stock, date_updated) VALUES (:product_name, :tbl_supplier_id, :purchase, :selling, :stock, :date_updated)");

            $stmt->bindParam(":product_name", $productName, PDO::PARAM_STR);
            $stmt->bindParam(":tbl_supplier_id", $productSupplier, PDO::PARAM_INT);
            $stmt->bindParam(":purchase", $purchase, PDO::PARAM_STR);
            $stmt->bindParam(":selling", $selling, PDO::PARAM_STR);
            $stmt->bindParam(":stock", $stock, PDO::PARAM_STR);
            $stmt->bindParam(":date_updated", $dateUpdated, PDO::PARAM_STR);

            $stmt->execute();

            header("Location: ../products.php");

            exit();
        } catch (PDOException $e) {
            echo "Error:" . $e->getMessage();
        }
    } else {
        echo "
            <script>
                alert('Por favor, rellena todos los campos!');
                window.location.href = '../products.php';
            </script>
        ";
    }
}
