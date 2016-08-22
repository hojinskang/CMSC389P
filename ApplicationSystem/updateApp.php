<?php
session_start();

$_SESSION['process'] = "update";
$_SESSION['message'] = "<h2>The entry has been updated in the database and the new values are:</h2><br />";

require_once("support.php");

$title = "Application System";

$body = <<<EOBODY
  <form action="updateData.php" method="post">
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
