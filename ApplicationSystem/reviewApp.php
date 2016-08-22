<?php
session_start();

$_SESSION['process'] = "review";
$_SESSION['message'] = "<h2>Application found in the database with the following values:</h2><br />";

require_once("support.php");

$title = "Application System";

$body = <<<EOBODY
  <form action="reviewData.php" method="post">
    <strong>Email associated with application:</strong>
    <input type="email" name="email" maxlength="100" required />
    <br /><br />
    <strong>Password associated with application:</strong>
    <input type="password" name="password" maxlength="20" required />
    <br /><br />
    <input type="submit" value="Submit"/>
  </form>
  <br />
  <form action="main.html">
    <input type="submit" value="Return to main menu"/>
  </form>
EOBODY;

echo generatePage($body, $title);

?>
