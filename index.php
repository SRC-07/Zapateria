<?php 
include("conexion.php"); 
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Tienda de Zapatos</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>

    <nav class="navbar">
        <h2>Zapateria</h2>
        <div class="nav-links">
            <a href="index.php">Inicio</a>
            <a href="clientes.php">Clientes</a>
            <a href="productos.php">Productos</a>
            <a href="proveedores.php">Proveedores</a>
            <a href="inventario.php">Inventario</a>
            <a href="pedidos.php">Pedidos</a>
            <a href="facturas.php">Ventas</a>
            <a href="estadisticas.php">Estadísticas</a>
        </div>
    </nav>

    <div class="container">
        <h1>Panel de Control</h1>
        <p>Bienvenido al sistema de gestión. Aquí tienes un resumen del estado de tu negocio:</p>

        <?php
        $clientes = $conn->query("SELECT COUNT(*) as total FROM clientes")->fetch_assoc();
        $productos = $conn->query("SELECT COUNT(*) as total FROM productos")->fetch_assoc();
        $proveedores = $conn->query("SELECT COUNT(*) as total FROM proveedores")->fetch_assoc();
        $facturas = $conn->query("SELECT COUNT(*) as total FROM facturas")->fetch_assoc();
        $pedidos = $conn->query("SELECT COUNT(*) as total FROM pedidos")->fetch_assoc();
        ?>

        <div class="dashboard-grid">
            <div class="card">
                <h3>Clientes Registrados</h3>
                <div class="numero"><?php echo $clientes['total']; ?></div>
                <a href="clientes.php" class="btn">Gestionar</a>
            </div>

            <div class="card">
                <h3>Catálogo de Productos</h3>
                <div class="numero"><?php echo $productos['total']; ?></div>
                <a href="productos.php" class="btn">Gestionar</a>
            </div>

            <div class="card">
                <h3>Proveedores</h3>
                <div class="numero"><?php echo $proveedores['total']; ?></div>
                <a href="proveedores.php" class="btn">Gestionar</a>
            </div>

            <div class="card">
                <h3>Ventas</h3>
                <div class="numero"><?php echo $facturas['total']; ?></div>
                <a href="facturas.php" class="btn">Historial Ventas</a>
            </div>

            <div class="card">
                <h3>Pedidos Realizados</h3>
                <div class="numero"><?php echo $pedidos['total']; ?></div>
                <a href="pedidos.php" class="btn">Ver Pedidos</a>
            </div>

            <div class="card">
                <h3>Estadísticas</h3>
                <p style="color: #64748b; margin: 15px 0;">Reportes y balances del negocio.</p>
                <a href="estadisticas.php" class="btn">Ver Estadísticas</a>
            </div>
        </div>
    </div>

</body>
</html>
