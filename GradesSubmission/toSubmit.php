<?php
if(isset($_COOKIE["logged"]) && $_COOKIE["logged"]) {
  require_once('support.php');

  session_start();

  require_once('studentClass.php');

  $numOfStudents = $_SESSION['numStudents'];
  $students = array();
  for ($x = 0; $x < $numOfStudents; $x++) {
    $students[$x] = new Student($_SESSION["Student".$x], $_POST["grade".$x]);
  }

  $_SESSION['studentInfo'] = serialize($students);

  $title = "CMSC389P Grades Submission";
  $body = <<<EOBODY
    <form action="submitted.php" method="post">
      <h1>Grades to Submit</h1>
      <table border="1" cellpadding="3">
        <tr>
          <th>Name</th>
          <th>Grade</th>
        </tr>
EOBODY;

  for ($x = 0; $x < $numOfStudents; $x++) {
    $body .= "<tr><td>";
    $body .= $students[$x]->getName();
    $body .= "</td><td>";
    $body .= $students[$x]->getGrade();
    $body .="</td></tr>";
  }

  $body .= <<<EOBODY
      </table>
      <br />
      <input type="submit" value="Submit Grades" />
    </form>
    <br />
    <form action="submissionForm.php">
      <input type="submit" value="Back" />
    </form>
EOBODY;


  # Generating final page
  echo generatePage($body, $title);
} else {
  die("<h1>Not logged in.</h1>");
}
?>
