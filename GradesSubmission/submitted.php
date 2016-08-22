<?php
session_start();

if(isset($_COOKIE["logged"]) && $_COOKIE["logged"]) {
  require_once('support.php');

  $title = "CMSC389P Grades Submission";
  $body = <<<EOBODY
      <h1>Grades submitted and e-mail confirmation sent.</h1>
      <h1>This is submission &num;1</h1>
EOBODY;

session_destroy();
  # Generating final page
  echo generatePage($body, $title);
} else {
  die("<h1>Not logged in.</h1>");
}
?>
