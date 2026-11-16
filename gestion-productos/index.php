<?php
session_start();
include("./conn/conn.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $enteredUsername = trim($_POST["username"]);
    $enteredPassword = trim($_POST["password"]);

    // Preparar la consulta para seleccionar el hash de la contraseña
    $stmt = $conn->prepare("SELECT user_id, password FROM tbl_users WHERE username = :username");
    $stmt->bindParam(':username', $enteredUsername);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($enteredPassword, $user['password'])) {
        $_SESSION['user_id'] = $user['user_id'];
        header("Location: home.php");
        exit();
    } else {
        $errorMessage = "Usuario o Contraseña Incorrecta";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('assets/head.php'); ?>
</head>

<body>
    <div class="main">
        <div class="login-container">
            <h2 class="text-center">Sistema de Gestión de Productos - Login</h2>
            <?php if (isset($errorMessage)) : ?>
                <div class="alert alert-danger text-center" role="alert">
                    <?php echo htmlspecialchars($errorMessage); ?>
                </div>
            <?php endif; ?>
            <form action="#" method="POST">
                <div class="form-group">
                    <label for="username">Usuario:</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
                <div class="form-group">
                    <label for="password">Contraseña:</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <button type="submit" class="btn btn-dark form-control">Acceder</button>
            </form>
        </div>
    </div>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>
</body>

</html>