<?php
  session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <h1>Carrito</h1>
  <a href="/index.php">volver a tienda</a>
  <table>
    <thead>
      <tr>
        <th>Id</th>
        <th>Nombre</th>
        <th>Precio</th>
        <th>Cantidad</th>
      </tr>
    </thead>
    <tbody>
<?php
  if (isset($_SESSION['cart'])):
    //printf('El carrito tiene %s', implode(', ',$_SESSION['cart']));
    foreach($_SESSION['cart'] as $product):    
?>
      <tr>
        <td><?=$product['id']?></td>
        <td><?=$product['name']?></td>
        <td><?=$product['price']?></td>
        <td></td>
      </tr>
<?php
    endforeach;
  endif;
?>      
    </tbody>
</body>
</html>
