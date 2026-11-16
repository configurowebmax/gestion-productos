<?php

session_start(); // Iniciar sesión en PHP

// Verificar si el usuario está logueado
if (!isset($_SESSION['user_id'])) {
    // Si no hay información de sesión, redirigir al usuario a la página de login
    header('Location: index.php');
    exit();
}

include("./conn/conn.php");

// Total Stocks
$totalStocksStmt = $conn->prepare("SELECT SUM(stock) as totalStocks FROM tbl_product");
$totalStocksStmt->execute();
$totalStocksResult = $totalStocksStmt->fetch(PDO::FETCH_ASSOC);
$totalStocks = $totalStocksResult["totalStocks"];

// Total Suppliers
$totalSuppliersStmt = $conn->prepare("SELECT COUNT(*) as totalSuppliers FROM tbl_supplier");
$totalSuppliersStmt->execute();
$totalSuppliersResult = $totalSuppliersStmt->fetch(PDO::FETCH_ASSOC);
$totalSuppliers = $totalSuppliersResult["totalSuppliers"];

// Total Products
$totalProductsStmt = $conn->prepare("SELECT COUNT(*) as totalProducts FROM tbl_product");
$totalProductsStmt->execute();
$totalProductsResult = $totalProductsStmt->fetch(PDO::FETCH_ASSOC);
$totalProducts = $totalProductsResult["totalProducts"];

// Top Supplier
$topSupplierStmt = $conn->prepare("SELECT tbl_supplier.supplier_name, COUNT(tbl_product.tbl_supplier_id) as productCount 
                                    FROM tbl_supplier 
                                    INNER JOIN tbl_product ON tbl_supplier.tbl_supplier_id = tbl_product.tbl_supplier_id 
                                    GROUP BY tbl_supplier.supplier_name 
                                    ORDER BY productCount DESC 
                                    LIMIT 1");
$topSupplierStmt->execute();
$topSupplierResult = $topSupplierStmt->fetch(PDO::FETCH_ASSOC);
$topSupplierName = $topSupplierResult["supplier_name"];

// Retrieve total stocks for each product
$stocksPerProductStmt = $conn->prepare("SELECT product_name, stock FROM tbl_product");
$stocksPerProductStmt->execute();
$stocksPerProductData = $stocksPerProductStmt->fetchAll(PDO::FETCH_ASSOC);

// Retrieve total products from each supplier
$totalProductsPerSupplierStmt = $conn->prepare("SELECT tbl_supplier.supplier_name, COUNT(tbl_product.tbl_supplier_id) as totalProducts 
                                                FROM tbl_supplier 
                                                LEFT JOIN tbl_product ON tbl_supplier.tbl_supplier_id = tbl_product.tbl_supplier_id 
                                                GROUP BY tbl_supplier.supplier_name");
$totalProductsPerSupplierStmt->execute();
$totalProductsPerSupplierData = $totalProductsPerSupplierStmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<?php include('assets/head.php'); ?>

<body>

    <?php include("./assets/header.php"); ?>
    <div class="main-home">
        <div class="cards">
            <div class="card">
                <h3>Existencias totales:</h3>
                <p><?= $totalStocks ?></p>
            </div>
            <div class="card">
                <h3>Proveedores totales:</h3>
                <p><?= $totalSuppliers ?></p>
            </div>
            <div class="card">
                <h3>Productos totales:</h3>
                <p><?= $totalProducts ?></p>
            </div>
            <div class="card">
                <h3>Proveedor principal:</h3>
                <p><?= $topSupplierName ?></p>
            </div>
        </div>

        <div class="graphs row">
            <div class="graph-container">
                <canvas id="stocksChart"></canvas>
            </div>
            <div class="graph-container">
                <canvas id="supplierChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Pass PHP data to JavaScript -->
    <script>
        const stocksPerProductData = <?php echo json_encode($stocksPerProductData); ?>;
        const totalProductsPerSupplierData = <?php echo json_encode($totalProductsPerSupplierData); ?>;
    </script>

    <!-- Custom JS -->
    <script src="assets/script.js"></script>

</body>

</html>