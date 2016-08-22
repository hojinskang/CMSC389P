<!doctype html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <title>CMSC389P P1</title>
</head>

<body>
  <fieldset style="width: 30em; margin-left: auto; margin-right: auto;">
    <legend>
      <h1>Order Confirmation</h1>
    </legend>
    <?php
      echo "<strong>Lastname:</strong> ";
      echo trim($_POST['lastName']);
      echo ",&nbsp;&nbsp;&nbsp;<strong>Firstname:</strong> ";
      echo trim($_POST['firstName']);
      echo "<br /><br />";
      echo "<strong>Email:</strong> ";
      echo trim($_POST['email']);
      echo "<br /><br />";
      echo "<strong>Shipping Method:</strong> ";
      echo $_POST['shippingMethod'];
      echo "<br /><br />";
      echo "<strong>Software Order:</strong>";
      echo "<br /><table border=\"1\" cellpadding=\"3\"><tr><th>Software</th><th>Cost</th></tr>";
      include 'softwares.php';
      foreach ($_POST['softs'] as $soft) {
        echo "<tr><td>";
        echo $soft;
        echo "</td><td>$";
        echo $softwares[$soft];
        echo "</td></tr>";
      }
      echo "<tr><td>Total</td><td>$";
      echo getTotal($softwares);
      echo "</td></tr></table><br /><strong>Order Specifications:</strong>";
      echo "<pre style=\"margin: 0px\"><em>";
      echo $_POST['orderSpecs'];
      echo "</em></pre>";
     ?>
     <?php
      function getTotal($softsArry) {
        $total = 0;
        foreach ($_POST['softs'] as $soft)
          $total = $total + $softsArry[$soft];
        return $total;
      }
     ?>
  </fieldset>
</body>
</html>
