<?php
require_once("support.php");

$host = "localhost";
$user = "dbuser";
$password = "goodbyeWorld";
$database = "applicationdb";
$table = "applicants";
$db = connectToDB($host, $user, $password, $database);

if (!isset($_POST['displayFlds'])) {
  $body = "<h2>Error.</h2>";
  $body .= <<<EOBODY
    <br /><br />
    <form action="main.html">
      <input type="submit" value="Return to main menu"/>
    </form>
EOBODY;
  echo generatePage($body);
  return false;
}

$body = <<<EOBODY
  <h2>Applications</h2>
  <br />
  <table border="1" cellpadding="3">
  <tr>
EOBODY;

//print_r($_POST['displayFlds']);

$display = $_POST['displayFlds'];
$sort = $_POST['sortFlds'];
$condition = trim($_POST['condition']);

if (count($display) == 0) {
  $fields = "*";
  $body .= "<th>Name</th><th>Email</th><th>GPA</th><th>Year</th><th>Gender</th>";
} else {
  $fields = $display[0];
  $body .= "<th>{$fields}</th>";
  for ($x = 1; $x < count($display); $x++) {
    $fields .= ",";
    $fields .= $display[$x];
    $body .= "<th>{$display[$x]}</th>";
  }
}

$body .= "</tr>";

if (isset($_POST['condition']) && strlen($condition) > 0) {
  $sqlQuery = sprintf("select %s from %s where %s order by %s ", $fields, $table, $condition, $sort);
} else {
  $sqlQuery = sprintf("select %s from %s order by %s ", $fields, $table, $sort);
}
$result = mysqli_query($db, $sqlQuery);
if ($result) {
  $numberOfRows = mysqli_num_rows($result);
  if ($numberOfRows == 0) {
    $body = "<h2>No entry exists in the database for the specified email and password.</h2>\n";
  } else {
    while ($recordArray = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
      $body .= "<tr>";
      if (isset($recordArray['name'])) {
        $name = $recordArray['name'];
        $body .= "<td>{$name}</td>";
      }
      if (isset($recordArray['email'])) {
        $email = $recordArray['email'];
        $body .= "<td>{$email}</td>";
      }
      if (isset($recordArray['gpa'])) {
        $gpa = $recordArray['gpa'];
        $body .= "<td>{$gpa}</td>";
      }
      if (isset($recordArray['year'])) {
        $year = $recordArray['year'];
        $body .= "<td>{$year}</td>";
      }
      if (isset($recordArray['gender'])) {
        $gender = $recordArray['gender'];
        $body .= "<td>{$gender}</td>";
      }
      $body .= "</tr>";
    }
  }
  mysqli_free_result($result);
}  else {
  $body = "<h2>Retrieving records failed.</h2>\n".mysqli_error($db);
}

mysqli_close($db);

$body .= <<<EOBODY
  </table>
  <br /><br />
  <form action="main.html">
    <input type="submit" value="Return to main menu"/>
  </form>
EOBODY;

echo generatePage($body);
?>
