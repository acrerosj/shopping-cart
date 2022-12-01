<?php include('includes/connection.php'); ?>
<?php
  session_start();
  
  if (isset($_GET['id']) && isset($_GET['name']) && isset($_GET['price'])) {
    $found = false;
    if (isset($_SESSION['cart'])) {
      for ($i=0; $i<count($_SESSION['cart']) && !$found; $i++) {
        if ($_SESSION['cart'][$i]['id'] == $_GET['id']) {
          $_SESSION['cart'][$i]['amount']++;
          $found = true;
        }
      }
    }
    if (!$found) {
      $new = ['id'=> $_GET['id'],
            'name' => $_GET['name'],
            'price' => $_GET['price'],
            'amount' => 1            
      ];
      $_SESSION['cart'][] = $new;
    }
  }

  if (isset($_SESSION['cart'])) {
    $numProductsCart = count($_SESSION['cart']);
  } else {
    $numProductsCart = 0; 
  }


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
<?php include('includes/header.inc.php'); ?>
  <h1>Productos</h1>
  <p><a href="cart.php">Carrito (<?= $numProductsCart?>)</a></p>
  <table>
    <thead>
      <tr>
        <th>Id</th>
        <th><a href="/index.php?order=name">Nombre</a></th>
        <th><a href="/index.php?order=price">Precio</a></th>
        <th><a href="/index.php?order=amount">Cantidad</a></th>
        <th>Carrito</th>
      </tr>
    </thead>
    <tbody>
<?php
  while ($row = $result->fetch_assoc()):
?>
      <tr>
        <td><?=$row['id']?></td>
        <td><?=$row['name']?></td>
        <td><?=$row['price']?>€</td>
        <td><?=$row['amount']?></td>
<?php if ($row['amount']==0) { ?>
        <td></td>
<?php } else { ?>
        <td><a href="index.php?id=<?=$row['id']?>&name=<?=$row['name']?>&price=<?=$row['price']?>">Añadir a carrito</a></td>
<?php } ?>
      </tr>
<?php
  endwhile;
  $result->close();
?>      
    </tbody>
  </table>
  <?php include('includes/footer.inc.php'); ?>
  <?php include('includes/close-connection.php'); ?>