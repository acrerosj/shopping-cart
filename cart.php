<?php
  session_start();
  // Clear de shopping-cart
  if (isset($_GET['action']) && $_GET['action']=='clear') {
    $_SESSION['cart']=[];
  }

  // Increment amount product.
  if (isset($_GET['add'])) {
    $found = false;
    for ($i=0; $i<count($_SESSION['cart']) && !$found; $i++) {
      if ($_SESSION['cart'][$i]['id'] == $_GET['add']) {
        $_SESSION['cart'][$i]['amount']++;
        $found = true;
      }
    }
  }

  // Decrement amount product.
  if (isset($_GET['remove'])) {
    $found = false;
    for ($i=0; $i<count($_SESSION['cart']) && !$found; $i++) {
      if ($_SESSION['cart'][$i]['id'] == $_GET['remove']) {
        $_SESSION['cart'][$i]['amount']--;
        // When amount is zero, remove product of shopping cart.
        if ($_SESSION['cart'][$i]['amount']==0) {
          array_splice($_SESSION['cart'], $i, 1);
        }
        $found = true;
      }
    }
  }
?>
<?php include('includes/header.inc.php'); ?>
  <h1>Carrito</h1>
  <p>
    <a href="/index.php">volver a tienda</a>
  </p>
  <p><a href="/cart.php?action=clear">Eliminar el carrito</a></p>
  <table>
    <thead>
      <tr>
        <th>Id</th>
        <th>Nombre</th>
        <th>Precio</th>
        <th>Cantidad</th>
        <th>SubTotal</th>
      </tr>
    </thead>
    <tbody>
<?php
  $total = 0;
  if (isset($_SESSION['cart'])):
    foreach($_SESSION['cart'] as $product):
      $subtotal = $product['price']*$product['amount'];
      $total += $subtotal;
?>
      <tr>
        <td><?=$product['id']?></td>
        <td><?=$product['name']?></td>
        <td><?=$product['price']?>€</td>
        <td>
          <a href="cart.php?remove=<?=$product['id']?>">-</a>
          <?=$product['amount']?>
          <a href="cart.php?add=<?=$product['id']?>">+</a>
        </td>
        <td><?=$subtotal?>€</td>
        <td></td>
      </tr>
<?php
    endforeach;
  endif;
?>      
    </tbody>
    <tfoot>
      <th colspan="4">TOTAL</th>
      <th><?=$total?></th>
    </tfoot>
<?php include('includes/footer.inc.php'); ?>
