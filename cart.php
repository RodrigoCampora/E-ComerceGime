<?php
require __DIR__."/lib.php";
$productos=load_products();
$items=[];
$total=0.0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <header class="topbar">
        <nav>
            <a href="index.php" class="brand">Inicio</a>
            <a href="cart.php">Carrito</a>
        </nav>
    </header>
    <main class="container">
        <h1>Tu Carrito</h1>
        <?php if(empty($items)):?>
            <p>No hay productos en el carrito.</p>
        <?php else:?>
            <table class="cart-table">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                        <th>SubTotal</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($items as $i): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($i['nomnbre'])?></td>
                            <td><?php echo number_format($i['precio'],2)?></td>
                            <td>
                                <form action="post" class="inline">
                                    <input type="hidden" name="action" value="update">
                                    <input type="hidden" name="action" value="<?php echo (int)$i['id']; ?>">
                                    <input type="number" name="qty" value="<?php echo (int)$i['qty']; ?> "min="0">
                                    <button type="submit">Actializar</button>
                                </form>
                            </td>
                            <td>$<?php echo number_format($i['subtotal'],2) ?></td>
                            <td>
                                <form action="post" class="inline">
                                    <input type="hidden" name="action" value="remove">
                                    <input type="hidden" name="action" value="<?php echo (int)$i['id']; ?>">
                                    <button type="submit">Quitar</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach;?>
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="3">Total</th>
                        <th>$<?php echo number_format($total,2) ?></th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>
            <form action="post">
                <input type="hidden" name="action" value="clear">
                <button type="submit">Vaciar carrito</button>
            </form>
        <?php endif;?>
    </main>
</body>
</html>