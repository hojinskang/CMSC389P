<?php
require_once("support.php");

// IMPORTANT: This is just an example and you do not want to have plain passwords like this
class Adm {
  var $u = 'main';
  var $p = 'terps';

  function getUser() {
    return $this->u;
  }

  function getPass() {
    return $this->p;
  }
}

$adm = new Adm;

$user = crypt($adm->getUser(),$salt);
$password = crypt($adm->getPass(),$salt);

$fields = array("name", "email", "gpa", "year", "gender");

$body = "";
$title = "Application System";

if(isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW']) &&
crypt($_SERVER['PHP_AUTH_USER'], $user) == $user && crypt($_SERVER['PHP_AUTH_PW'], $password) == $password){
  $body .= <<<EOBODY
    <h2>Applications</h2>
    <br />
    <strong>Select fields to display</strong>
    <br />
    <form action="adminData.php" method="post">
      <select name="displayFlds[]" multiple="multiple">
        <option value="name">name</option>
        <option value="email">email</option>
        <option value="gpa" selected>gpa</option>
        <option value="year">year</option>
        <option value="gender">gender</option>
      </select>
      <br /><br />
      <strong>Select field to sort applications</strong>
      <select name="sortFlds">
        <option value="name">name</option>
        <option value="email">email</option>
        <option value="gpa" selected>gpa</option>
        <option value="year">year</option>
        <option value="gender">gender</option>
      </select>
      <br /><br />
      <strong>Filter condition</strong> <input type="text" name="condition" />
      <br /><br />
      <input type="submit" value="Display Applications"/>
    </form>
    <br />
    <form action="main.html">
      <input type="submit" value="Return to main menu"/>
    </form>
EOBODY;

  echo generatePage($body, $title);
} else {
  header("WWW-Authenticate: Basic realm=\"Example System\"");
  header("HTTP/1.0 401 Unauthorized");
  exit;
}
?>
