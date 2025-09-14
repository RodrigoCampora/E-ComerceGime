 <?php
 session_start();
 if (!isset($_SESSION['user_id'])){
    die("Debes iniciar session");
 }

 $userid=$_SESSION['user_id'];
 $cartFile=__DIR__."Data/carts.json";
 $productsFile=__DIR__."Data/products.json";

 $productos=json_decode(file_get_contents($productsFile),true);
 $id =$_GET['id']??null;

 $producto=null;
 foreach($productos as $p){
    if($p['id']==$id) $producto=$p;
 }
 if(!$producto) die("Producto no encontrado");

 $carrito=file_exists($cartFile) ? json_decode(file_get_contents($cartFile),true) : [];
 if (!isset($carrito[$userid])) $carrito[$userid]=[];

 $carrito[$userid][]=[
        "id"=>$producto['id'],
        "nombre"=>$producto['nombre'],
        "precio"=>$producto['precio']
 ];
file_put_contents($cartFile,json_encode($carrito,JSON_PRETTY_PRINT));
header("Location: cart.php");
exit;