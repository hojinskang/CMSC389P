<?php
session_start();

require_once("support.php");

$title = "Application System";

$host = "localhost";
$user = "dbuser";
$password = "goodbyeWorld";
$database = "applicationdb";
$table = "applicants";
$db = connectToDB($host, $user, $password, $database);

$body = $_SESSION["message"];

if (isset($_SESSION['process']) && $_SESSION['process'] == "update" && isset($_POST['email']) && isset($_POST['password'])) {
  if ($_POST["password"] != $_POST["verify"]) {
    $body = "<h2>Password and password verification values do not match.</h2>";
  } else {
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $gpa = floatval(trim($_POST["gpa"]));
    $year = intval(trim($_POST["year"]));
    $gender = $_POST["gender"];
    $password = $_POST["password"];
    $password = crypt($password,$salt);

    $sqlQuery = sprintf("update ignore $table set name='%s',email='%s',gpa=%f,year=%d,gender='%s',password='%s'",
    $name, $email, $gpa, $year, $gender, $password);
    $result = mysqli_query($db, $sqlQuery);
    if (!($result)) {
      $body = "<h2>Updating records failed.</h2>\n".mysqli_error($db);
    } else {
      $body .= "<strong>Name:</strong> $name<br /><strong>Email:</strong> $email<br /><strong>GPA:</strong> $gpa<br /><strong>Year:</strong> $year<br /><strong>Gender:</strong> $gender";
    }
  }
} else {
  $body = "<h2>Error.</h2>";
}

mysqli_close($db);

$body .= <<<EOBODY
  <br /><br />
  <form action="main.html">
    <input type="submit" value="Return to main menu"/>
  </form>
EOBODY;

echo generatePage($body, $title);

?>
