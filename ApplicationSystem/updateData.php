<?php
session_start();

$title = "Application System";

require_once("support.php");

$host = "localhost";
$user = "dbuser";
$password = "goodbyeWorld";
$database = "applicationdb";
$table = "applicants";
$db = connectToDB($host, $user, $password, $database);

$body = "";

if (isset($_SESSION['process']) && $_SESSION['process'] == "update" && isset($_POST['email']) && isset($_POST['password'])) {
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
        $password = $recordArray['password'];
      }
    }
    mysqli_free_result($result);
  }  else {
    $body = "<h2>Retrieving records failed.</h2>\n".mysqli_error($db);
  }

  // no error
  if ($body == "") {
    $body = <<<EOBODY
      <form action="submitUpdate.php" method="post">
      <strong>Name:</strong> <input type="text" name="name" maxlength="50" value='$name' />
      <br /><br />
      <strong>Email:</strong> <input type="email" name="email" maxlength="100" value='$email' required />
      <br /><br />
      <strong>GPA:</strong> <input type="number" name="gpa" step="0.1" min="0" max="4" value=$gpa />
      <br /><br />
      <strong>Year:</strong>
EOBODY;

    if ($year == 10) {
      $body .= "<input type=\"radio\" name=\"year\" value=\"10\" checked /> 10";
    } else {
      $body .= "<input type=\"radio\" name=\"year\" value=\"10\" /> 10";
    }
    if ($year == 11) {
      $body .= "<input type=\"radio\" name=\"year\" value=\"11\" checked /> 11";
    } else {
      $body .= "<input type=\"radio\" name=\"year\" value=\"11\" /> 11";
    }
    if ($year == 12) {
      $body .= "<input type=\"radio\" name=\"year\" value=\"12\" checked /> 12";
    } else {
      $body .= "<input type=\"radio\" name=\"year\" value=\"12\" /> 12";
    }

    $body .= <<<EOBODY
      <br /><br />
      <strong>Gender:</strong>
EOBODY;

    if ($gender == 'M') {
      $body .= "<input type=\"radio\" name=\"gender\" value=\"M\" checked /> M";
    } else {
      $body .= "<input type=\"radio\" name=\"gender\" value=\"M\" /> M";
    }
    if ($gender == 'F') {
      $body .= "<input type=\"radio\" name=\"gender\" value=\"F\" checked /> F";
    } else {
      $body .= "<input type=\"radio\" name=\"gender\" value=\"F\" /> F";
    }

    $pp = $_POST['password'];

    $body .= <<<EOBODY
      <br /><br />
      <strong>Password:</strong> <input type="password" name="password" maxlength="20" value=$pp />
      <br /><br />
      <strong>Verify Password:</strong> <input type="password" name="verify" maxlength="20" value=$pp />
      <br /><br />
      <input type="submit" name="login" value="Submit Data"/>
      </form>
EOBODY;
  }
} else {
  $body = "<h2>Error.</h2><br />";
}

$body .= <<<EOBODY
  <br />
  <form action="main.html">
  <input type="submit" value="Return to main menu"/>
  </form>
EOBODY;

//mysqli_close($db);

echo generatePage($body, $title);

?>
