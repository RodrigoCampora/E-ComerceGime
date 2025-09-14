<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['is_admin'] != 1) {
    die("Acceso denegado.");
}

$productsFile = __DIR__ . "/Data/products.json";
$productos = file_exists($productsFile) ? json_decode(file_get_contents($productsFile), true) : [];

if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['action'] == "add") {
    $nuevo = [
        "id" => time(),
        "nombre" => $_POST['nombre'],
        "precio" => floatval($_POST['precio']),
        "categoria" => $_POST['categoria'],
        "estado" => ($_POST['stock'] > 0) ? "disponible" : "agotado",
        "stock" => intval($_POST['stock'])
    ];
    $productos[] = $nuevo;
    file_put_contents($productsFile, json_encode($productos, JSON_PRETTY_PRINT));
    header("Location: viewAdmin.php");
    exit;
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $productos = array_filter($productos, fn($p) => $p['id'] != $id);
    file_put_contents($productsFile, json_encode(array_values($productos), JSON_PRETTY_PRINT));
    header("Location: viewAdmin.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['action'] == "update") {
    $id = $_POST['id'];
    foreach ($productos as &$p) {
        if ($p['id'] == $id) {
            $p['stock'] += intval($_POST['cantidad']);
            $p['estado'] = ($p['stock'] > 0) ? "disponible" : "agotado";
            break;
        }
    }
    file_put_contents($productsFile, json_encode($productos, JSON_PRETTY_PRINT));
    header("Location: viewAdmin.php");
    exit;
}
?>

<h1>Panel Admin</h1>

<h2>Agregar nuevo producto</h2>
<form method="post">
    <input type="hidden" name="action" value="add">
    Nombre: <input type="text" name="nombre" required><br>
    Precio: <input type="number" step="0.01" name="precio" required><br>
    Categoría: <input type="text" name="categoria" required><br>
    Stock inicial: <input type="number" name="stock" value="0"><br>
    <button type="submit">Agregar producto</button>
</form>

<hr>

<h2>Productos existentes</h2>
<table>
    <tr>
        <th>ID</th><th>Nombre</th><th>Precio</th><th>Categoría</th><th>Stock</th><th>Acciones</th>
    </tr>
    <?php foreach ($productos as $p): ?>
    <tr>
        <td><?php echo $p['id']; ?></td>
        <td><?php echo htmlspecialchars($p['nombre']); ?></td>
        <td><?php echo number_format($p['precio'], 2); ?></td>
        <td><?php echo htmlspecialchars($p['categoria']); ?></td>
        <td><?php echo $p['stock']; ?></td>
        <td>
            <a href="?delete=<?php echo $p['id']; ?>">Eliminar</a>
            <form method="post" style="display:inline;">
                <input type="hidden" name="action" value="update">
                <input type="hidden" name="id" value="<?php echo $p['id']; ?>">
                <input type="number" name="cantidad" value="1">
                <button type="submit">Agregar stock</button>
            </form>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

<a href="index.php">Volver a la tienda</a>
