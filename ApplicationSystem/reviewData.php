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

$body = $_SESSION['message'];

if (isset($_SESSION["process"]) && $_SESSION["process"] == "review") {
  $pw = $_POST['password'];
  $pw = crypt($pw,$salt);
  $sqlQuery = sprintf("select * from %s where email='%s' and password='%s'", $table, $_POST['email'], $pw);
  $result = mysqli_query($db, $sqlQuery);
  if ($result) {
    $numberOfRows = mysqli_num_rows($result);
    if ($numberOfRows == 0) {
      $body = "<h2>No entry exists in the database for the specified email and password.</h2>";
    } else {
      while ($recordArray = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $name = $recordArray['name'];
        $email = $recordArray['email'];
        $gpa = $recordArray['gpa'];
        $year = $recordArray['year'];
        $gender = $recordArray['gender'];
        $body .= "<strong>Name:</strong> $name<br /><strong>Email:</strong> $email<br /><strong>GPA:</strong> $gpa<br /><strong>Year:</strong> $year<br /><strong>Gender:</strong> $gender";
      }
    }
    mysqli_free_result($result);
  }  else {
    $body = "<h2>Retrieving records failed.</h2>\n".mysqli_error($db);
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
