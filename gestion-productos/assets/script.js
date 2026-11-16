$(document).ready(function() {
    $('#productTable').DataTable();
});

function updateProduct(id) {
    $("#updateProductModal").modal("show");

    let updateProductName = $("#productName-" + id).text();
    let updateProductSupplier = $("#productSupplier-" + id).text();
    let updatePurchase = $("#purchase-" + id).text();
    let updateSelling = $("#selling-" + id).text();
    let updateStock = $("#stock-" + id).text();

    $("#updateProductID").val(id);
    $("#updateProductName").val(updateProductName);
    $("#updateProductSupplier option").each(function() {
        let supplier = $(this).text();
        if (supplier === updateProductSupplier) {
            $(this).prop("selected", true);
            return false;
        }
    });
    $("#updatePurchase").val(updatePurchase);
    $("#updateSelling").val(updateSelling);
    $("#updateStock").val(updateStock);
}

function deleteProduct(id) {
    if (confirm("¿Estás seguro de que deseas eliminar este producto?")) {
        window.location.href = './endpoint/delete-product.php?id=' + id;
    }
}

function printProducts() {
    const printContents = document.querySelector('.table-container').innerHTML;
    const originalContents = document.body.innerHTML;

    document.body.innerHTML = printContents;
    window.print();
    document.body.innerHTML = originalContents;
}


// desde aquí los scripts del home.php

$(document).ready(function() {
    // Get the canvas elements
    const stocksChart = document.getElementById('stocksChart').getContext('2d');
    const supplierChart = document.getElementById('supplierChart').getContext('2d');

    // Stocks per Product data
    const stocksPerProductLabels = [];
    const stocksPerProductValues = [];
    stocksPerProductData.forEach(data => {
        stocksPerProductLabels.push(data.product_name);
        stocksPerProductValues.push(data.stock);
    });

    // Total Products per Supplier data
    const supplierLabels = [];
    const supplierProducts = [];
    totalProductsPerSupplierData.forEach(data => {
        supplierLabels.push(data.supplier_name);
        supplierProducts.push(data.totalProducts);
    });

    // Configure the options for the charts
    const chartOptions = {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    };

    // Create the Stocks per Product chart
    new Chart(stocksChart, {
        type: 'line',
        data: {
            labels: stocksPerProductLabels,
            datasets: [{
                label: 'Existencias por producto',
                data: stocksPerProductValues,
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1
            }]
        },
        options: chartOptions
    });

    // Create the Total Products per Supplier chart
    new Chart(supplierChart, {
        type: 'bar',
        data: {
            labels: supplierLabels,
            datasets: [{
                label: 'Productos totales por proveedor',
                data: supplierProducts,
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: chartOptions
    });
});

$(document).ready(function() {
    $('#supplierTable').DataTable();
});

function updateSupplier(id) {
    $("#updateSupplierModal").modal("show");

    let updateSupplierName = $("#supplierName-" + id).text();
    let updateSupplierContact = $("#supplierContact-" + id).text();

    $("#updateSupplierID").val(id);
    $("#updateSupplierName").val(updateSupplierName);
    $("#updateSupplierContact").val(updateSupplierContact);
}

function deleteSupplier(id) {
    if (confirm("¿Estás seguro de que deseas eliminar este proveedor?")) {
        window.location.href = './endpoint/delete-supplier.php?id=' + id;
    }
}

document.getElementById('enviarConfiguroweb').addEventListener('click', function() {
    window.location.href = 'https://www.configuroweb.com/';
  });


