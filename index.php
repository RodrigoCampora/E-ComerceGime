<?php 
    require __DIR__."/lib.php";
    $user="test";
    $productos=load_products();
    $categorias=array_unique(array_column($productos,'categoria'));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Comerce</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
</head>
<body>
    <header class="topbar">
        <nav>
            <a href="index.php">Inicio</a>
            <?php foreach($categorias as $cat):?>
                <a href="?cat=<?php echo urldecode($cat)?>"><?php echo htmlspecialchars($cat) ?></a>
            <?php endforeach; ?>
            <?php if($user): ?>
                <span>Hola,<?php echo htmlspecialchars($user);?></span>
                <a href="cart.php">Carrito</a>
                <a href="logout.php">Cerrar sesion</a>
            <?php else: ?>
                 <a href="login.php">Login</a>
                <a href="register.php">Registro</a>
                <a href="cart.php">Carrito</a>
            <?php endif; ?>
        </nav>
    </header>
    <main>
        <section class="about">
        <div class="about-content">
        <h1> VeneziaStore
        </h1>
        <h2>Tu lugar de confianza</h2>
        <button>shop</button>
        </div>
        
        <div>
            "Cada prenda y accesorio está pensado para acompañarte en tu día a día,
            con diseños exclusivos y producción limitada para que lleves algo tan 
            único como vos."
        </div>
        
        </section>
        <section class="products">
            <?php
            $filtro=$_GET['cat']??null; 
            foreach($productos as $p):
                if($filtro && $p['categoria'] !==$filtro)continue;
                ?>
             <div class="producto <?php echo $p['estado']; ?>">
    <div class="producto-img"></div>
    <h2><?php echo htmlspecialchars($p['nombre']); ?></h2>
    <p>$<?php echo number_format($p['precio'],2);?></p>
    <?php if($p['estado']==='agotado'): ?>
        <span class="agotado">AGOTADO</span>
    <?php else:?>
        <button>Compre Ahora</button>
    <?php endif;?>
</div>
            <?php endforeach; ?>
        </section>
        <section class="contacto">
            <p>Contacto: </p>
        </section>
    </main>    
    <footer>
        
    </footer>
</body>
</html>