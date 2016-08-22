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

$_SESSION['process'] = "submit";
$_SESSION['message'] = "<h2>The following entry has been added to the database:</h2><br />";

$body = "";

if (isset($_POST["login"])) {
  if ($_POST["password"] != $_POST["verify"]) {
    $body = "<h2>Password and password verification values do not match.</h2>";
  } else {
    $body = $_SESSION['message'];
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $gpa = floatval(trim($_POST["gpa"]));
    $year = intval(trim($_POST["year"]));
    $gender = $_POST["gender"];
    $password = $_POST["password"];
    $password = crypt($password, $salt);

    $sqlQuery = sprintf("insert into $table (name, email, gpa, year, gender, password) values ('%s', '%s', %f, %d, '%s', '%s')",
    $name, $email, $gpa, $year, $gender, $password);
    $result = mysqli_query($db, $sqlQuery);
    if (!($result)) {
      $body = "<h2>Inserting records failed.</h2>\n".mysqli_error($db);
    } else {
      $body .= "<strong>Name:</strong> $name<br /><strong>Email:</strong> $email<br /><strong>GPA:</strong> $gpa<br /><strong>Year:</strong> $year<br /><strong>Gender:</strong> $gender";
    }
  }

} else {

  $scriptName = $_SERVER["PHP_SELF"];
  $body = <<<EOBODY
    <form action=$scriptName method="post">
    <strong>Name:</strong> <input type="text" name="name" maxlength="50" />
    <br /><br />
    <strong>Email:</strong> <input type="email" name="email" maxlength="100" />
    <br /><br />
    <strong>GPA:</strong> <input type="number" name="gpa" step="0.1" min="0" max="4" required />
    <br /><br />
    <strong>Year:</strong>
    <input type="radio" name="year" value="10" /> 10
    <input type="radio" name="year" value="11" /> 11
    <input type="radio" name="year" value="12" /> 12
    <br /><br />
    <strong>Gender:</strong>
    <input type="radio" name="gender" value="M" /> M
    <input type="radio" name="gender" value="F" /> F
    <br /><br />
    <strong>Password:</strong> <input type="password" name="password" maxlength="20" />
    <br /><br />
    <strong>Verify Password:</strong> <input type="password" name="verify" maxlength="20" />
    <br /><br />
    <input type="submit" name="login" value="Submit Data"/>
    </form>
EOBODY;

}

$body .= <<<EOBODY
  <br /><br />
  <form action="main.html">
    <input type="submit" value="Return to main menu"/>
  </form>
EOBODY;

mysqli_close($db);

echo generatePage($body, $title);

?>
