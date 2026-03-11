<?php
include("conexion.php");

if (isset($_GET['eliminar'])) {
    $id_eliminar = $_GET['eliminar'];
    $conn->query("DELETE FROM clientes WHERE id_cliente = $id_eliminar");
    header("Location: clientes.php");
    exit;
}

$id_editar = "";
$nombre_ed = "";
$apellido_ed = "";
$documento_ed = "";
$telefono_ed = "";
$email_ed = "";
$direccion_ed = "";

if (isset($_GET['editar'])) {
    $id_editar = $_GET['editar'];
    $res_edit = $conn->query("SELECT * FROM clientes WHERE id_cliente = $id_editar");
    if ($row_edit = $res_edit->fetch_assoc()) {
        $nombre_ed = $row_edit['nombre'];
        $apellido_ed = $row_edit['apellido'];
        $documento_ed = $row_edit['documento'];
        $telefono_ed = $row_edit['telefono'];
        $email_ed = $row_edit['email'];
        $direccion_ed = $row_edit['direccion'];
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $documento = $_POST['documento'];
    $telefono = $_POST['telefono'];
    $email = $_POST['email'];
    $direccion = $_POST['direccion'];
    
    if (isset($_POST['id_cliente_editar']) && $_POST['id_cliente_editar'] != "") {
        $id_upd = $_POST['id_cliente_editar'];
        $sql = "UPDATE clientes SET nombre='$nombre', apellido='$apellido', documento='$documento', telefono='$telefono', email='$email', direccion='$direccion' WHERE id_cliente = $id_upd";
    } else {
        $sql = "INSERT INTO clientes (nombre, apellido, documento, telefono, email, direccion) 
                VALUES ('$nombre', '$apellido', '$documento', '$telefono', '$email', '$direccion')";
    }
    
    $conn->query($sql);
    header("Location: clientes.php");
    exit;
}

$resultado = $conn->query("SELECT * FROM clientes ORDER BY id_cliente DESC");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clientes - Tienda de Zapatos</title>
    <link rel="stylesheet" href="estilos.css">
    <style>
        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-bottom: 20px;
        }
        input {
            width: 100%;
            padding: 10px;
            border: 1px solid var(--borde);
            border-radius: 6px;
            box-sizing: border-box;
            font-family: inherit;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid var(--borde);
        }
        th {
            background-color: var(--fondo);
            color: var(--oscuro);
            font-weight: 600;
        }
        tr:hover {
            background-color: #f1f5f9;
        }
        .btn-accion {
            padding: 6px 12px;
            text-decoration: none;
            border-radius: 4px;
            font-size: 0.85rem;
            font-weight: bold;
            color: white;
            margin-right: 5px;
            display: inline-block;
        }
        .btn-editar { background-color: #f59e0b; }
        .btn-editar:hover { background-color: #d97706; }
        .btn-eliminar { background-color: #ef4444; }
        .btn-eliminar:hover { background-color: #dc2626; }
        .cancelar {
            background-color: #64748b;
            margin-left: 10px;
        }
    </style>
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
        <h1>Gestión de Clientes</h1>

        <div class="card" style="margin-bottom: 30px; text-align: left;">
            <h3 style="margin-bottom: 20px;"><?php echo ($id_editar != "") ? "Editar Cliente" : "Registrar Nuevo Cliente"; ?></h3>
            <form method="POST">
                <input type="hidden" name="id_cliente_editar" value="<?php echo $id_editar; ?>">
                <div class="form-grid">
                    <input type="text" name="nombre" required placeholder="Nombre" value="<?php echo $nombre_ed; ?>">
                    <input type="text" name="apellido" required placeholder="Apellido" value="<?php echo $apellido_ed; ?>">
                    <input type="text" name="documento" required placeholder="Documento" value="<?php echo $documento_ed; ?>">
                    <input type="text" name="telefono" required placeholder="Teléfono" value="<?php echo $telefono_ed; ?>">
                    <input type="email" name="email" required placeholder="Correo Electrónico" value="<?php echo $email_ed; ?>">
                    <input type="text" name="direccion" required placeholder="Dirección" value="<?php echo $direccion_ed; ?>">
                </div>
                <button type="submit" class="btn"><?php echo ($id_editar != "") ? "Actualizar Datos" : "Guardar Cliente"; ?></button>
                <?php if($id_editar != ""): ?>
                    <a href="clientes.php" class="btn cancelar">Cancelar</a>
                <?php endif; ?>
            </form>
        </div>

        <div class="card" style="text-align: left; overflow-x: auto;">
            <h3 style="margin-bottom: 20px;">Directorio de Clientes</h3>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre Completo</th>
                        <th>Documento</th>
                        <th>Teléfono</th>
                        <th>Email</th>
                        <th>Dirección</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($fila = $resultado->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $fila['id_cliente']; ?></td>
                        <td><?php echo $fila['nombre'] . " " . $fila['apellido']; ?></td>
                        <td><?php echo $fila['documento']; ?></td>
                        <td><?php echo $fila['telefono']; ?></td>
                        <td><?php echo $fila['email']; ?></td>
                        <td><?php echo $fila['direccion']; ?></td>
                        <td>
                            <a href="clientes.php?editar=<?php echo $fila['id_cliente']; ?>" class="btn-accion btn-editar">Editar</a>
                            <a href="clientes.php?eliminar=<?php echo $fila['id_cliente']; ?>" class="btn-accion btn-eliminar" onclick="return confirm('¿Estás seguro de eliminar este cliente?');">Eliminar</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
        
        <div style="text-align: center; margin-top: 30px; padding-bottom: 20px;">
            <a href="index.php" class="btn" style="background-color: #64748b;">Volver al Inicio</a>
        </div>
    </div>

</body>
</html>
