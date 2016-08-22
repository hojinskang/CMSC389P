<?php

$salt = '$5$rounds=5000$usesomesillystringforsalt$';

function generatePage($body, $title="Application System") {
    $page = <<<EOPAGE
<!doctype html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>$title</title>
        <link rel="stylesheet" type="text/css" href="stylesheet.css">
    </head>

    <body>
      <div>
            $body
      </div>
    </body>
</html>
EOPAGE;

    return $page;
}

function connectToDB($host, $user, $password, $database) {
  $db = mysqli_connect($host, $user, $password, $database);
  if (mysqli_connect_errno()) {
    echo "<h2>Connect failed.</h2>\n".mysqli_connect_error();
    exit();
  }
  return $db;
}

?>
