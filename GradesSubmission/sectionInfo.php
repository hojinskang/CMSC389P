<?php
require_once('support.php');

session_start();

if(isset($_COOKIE["logged"]) && $_COOKIE["logged"]) {
  $title = "CMSC389P Grades Submission";
  $body = <<<EOBODY
  <form action="submissionForm.php" method="post">
  <h1>Section Information</h1>
  <strong>Course Name (e.g., cmsc128):</strong> <input type="text" name="course" />
  <br /><br />
  <strong>Section (e.g., 0101):</strong> <input type="text" name="section" />
  <br /><br />
  <input type="submit" value="Submit"/>
  </form>
EOBODY;

  # Generating final page
  echo generatePage($body, $title);
} else {
  die("<h1>Not logged in.</h1>");
}
?>
