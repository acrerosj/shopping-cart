<?php include('includes/connection.php'); ?>
<?php
  $sql = "SELECT * FROM products";
  if (isset($_GET['order'])) {
    $order = $_GET['order'];
    if ($order=='name' || $order=='price' || $order=='amount') {
      setcookie('order', $_GET['order']);
    } else {
      unset($order);
    }
  }

  if (empty($order) && isset($_COOKIE['order'])) {
    $order = $_COOKIE['order'];
    if (!($order=='name' || $order=='price' || $order=='amount')) {
      unset($order);
      setcookie('order', '', time());
    }
  }

  if (isset($order)) {
    $sql .= " ORDER BY " . $order;
  }
  $result = $conn->query($sql);

?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tienda</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <h1>Productos</h1>
  <table>
    <thead>
      <tr>
        <th>Id</th>
        <th><a href="/index.php?order=name">Nombre</a></th>
        <th><a href="/index.php?order=price">Precio</a></th>
        <th><a href="/index.php?order=amount">Cantidad</a></th>
      </tr>
    </thead>
    <tbody>
<?php
  while ($row = $result->fetch_assoc()):
?>
      <tr>
        <td><?=$row['id']?></td>
        <td><?=$row['name']?></td>
        <td><?=$row['price']?></td>
        <td><?=$row['amount']?></td>
      </tr>
<?php
  endwhile
?>      
    </tbody>
  </table>
</body>
</html>