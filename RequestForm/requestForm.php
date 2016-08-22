<!doctype html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <title>CMSC389P P1</title>
  <style type="text/css">
    label {
      font-weight: bold;
    }
  </style>
</head>

<body>
  <fieldset style="width: 30em; margin-left: auto; margin-right: auto;">
    <legend>
      <h1>Order Request Form</h1>
    </legend>
    <form action="processRequest.php" method="post">
      <p>
        <label for="lastName">Lastname:</label> <input type="text" name="lastName" />
        &nbsp;&nbsp;&nbsp;
        <label for="firstName">Firstname:</label> <input type="text" name="firstName" />
        <br /><br />
        <label for="email">Email:</label> <input type="email" name="email" placeholder="example@notreal.notreal" required />
        <br /><br />
        <label for="shippingMethod">Shipping Method:</label>
        <input type="radio" name="shippingMethod" value="UPSS" /> UPSS&nbsp;
        <input type="radio" name="shippingMethod" value="FedEX" />FedEX&nbsp;
        <input type="radio" name="shippingMethod" value="USMAIL" checked="checked" />USMAIL&nbsp;
        <input type="radio" name="shippingMethod" value="Other" />Other
        <br /><br />
        <label for="softwares">Softwares:</label>
        <br />
        <?php
          require 'softwares.php';
        ?>
        <select name="softs[]" multiple="multiple">
          <?php
            foreach ($softwares as $key => $value)
            echo "<option value=\"$key\">$key (\$$value)</option>";
          ?>
        </select>
        <br />
        <br />
        <label for="orderSpecs">Order Specifications:</label>
        <br />
        <textarea rows="7" cols="70" name="orderSpecs"></textarea>
      </p>

      <!--We need the submit button-->
      <p>
        <input type="reset" value="Reset Fields" />
        <input type="submit" value="Submit Request" />
      </p>
    </form>
  </fieldset>
</body>
</html>
