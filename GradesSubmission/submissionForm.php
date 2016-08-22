<?php
if(isset($_COOKIE["logged"]) && $_COOKIE["logged"]) {
  require_once('support.php');

  session_start();

  require_once('studentClass.php');

  if (!isset($_SESSION["studentInfo"])) {
    $_SESSION['course'] = trim($_POST['course']);
    $_SESSION['section'] = trim($_POST['section']);
  }

  $filename = $_SESSION['course'].$_SESSION['section'].".txt";

  $title = "CMSC389P Grades Submission";
  $body = "<form action=\"toSubmit.php\" method=\"post\">
          <h1>Grades Submission Form</h1>
          <h1>Course: {$_SESSION['course']},
          Section: {$_SESSION['section']}</h1>";

  $body .= "<table border=\"1\" cellpadding=\"3\">";

  if (!isset($_SESSION["studentInfo"])) {

    $_SESSION["numStudents"] = 0;
    $index = 0;

    $fp = fopen($filename, "r") or die("Could not open file");
    while (!feof($fp)) {
      $line = trim(fgets($fp));
      if (!($line === "")) {
        $_SESSION["Student".$index] = $line;
        $body .= "<tr><td>$line</td>";
        $body .= "<td><input type=\"radio\" name=\"grade$index\" value=\"A\"/> A</td>";
        $body .= "<td><input type=\"radio\" name=\"grade$index\" value=\"B\"/> B</td>";
        $body .= "<td><input type=\"radio\" name=\"grade$index\" value=\"C\"/> C</td>";
        $body .= "<td><input type=\"radio\" name=\"grade$index\" value=\"D\"/> D</td>";
        $body .= "<td><input type=\"radio\" name=\"grade$index\" value=\"F\"/> F</td></tr>";
        $index++;
      }
    }
    $_SESSION["numStudents"] = $index;
    fclose($fp);

  } else {

    $index = 0;
    $students = unserialize($_SESSION['studentInfo']);

    for ($x = 0; $x < count($students); $x++) {
      $body .= "<tr><td>";
      $body .= $students[$x]->getName();
      $body .= "</td>";
      if ($students[$x]->getGrade() === "A") {
        $body .= "<td><input type=\"radio\" name=\"grade$index\" value=\"A\" checked/> A</td>";
      } else {
        $body .= "<td><input type=\"radio\" name=\"grade$index\" value=\"A\"/> A</td>";
      }
      if ($students[$x]->getGrade() === "B") {
        $body .= "<td><input type=\"radio\" name=\"grade$index\" value=\"B\" checked/> B</td>";
      } else {
        $body .= "<td><input type=\"radio\" name=\"grade$index\" value=\"B\"/> B</td>";
      }
      if ($students[$x]->getGrade() === "C") {
        $body .= "<td><input type=\"radio\" name=\"grade$index\" value=\"C\" checked/> C</td>";
      } else {
        $body .= "<td><input type=\"radio\" name=\"grade$index\" value=\"C\"/> C</td>";
      }
      if ($students[$x]->getGrade() === "D") {
        $body .= "<td><input type=\"radio\" name=\"grade$index\" value=\"D\" checked/> D</td>";
      } else {
        $body .= "<td><input type=\"radio\" name=\"grade$index\" value=\"D\"/> D</td>";
      }
      if ($students[$x]->getGrade() === "F") {
        $body .= "<td><input type=\"radio\" name=\"grade$index\" value=\"F\" checked/> F</td>";
      } else {
        $body .= "<td><input type=\"radio\" name=\"grade$index\" value=\"F\"/> F</td>";
      }
      $body .="</tr>";
      $index++;
    }

  }

  $body .= "</table><br />
            <input type=\"submit\" value=\"Continue\"/>
            </form>";



  # Generating final page
  echo generatePage($body, $title);
} else {
  die("<h1>Not logged in.</h1>");
}
?>
