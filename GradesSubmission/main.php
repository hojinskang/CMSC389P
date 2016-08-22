<?php
	require_once("support.php");

	session_start();

	if (isset($_COOKIE["logged"]) && $_COOKIE["logged"]) {
		echo "<h1>Already logged in.<br />Redirecting page in 5 seconds...</h1>";
		header("refresh:5; url=sectionInfo.php");
	} else {
		$body = "";
		if (isset($_POST["login"])) {
			$idValue = trim($_POST["id"]);
			$passwordValue = trim($_POST["password"]);

			if (!($idValue === "cmsc298s" && $passwordValue === "terps")) {
				$body .= "<br /><h1>Invalid login information provided.</h1><br />";
			}
			if ($body == "") {
				$_SESSION[$idValue] = $passwordValue;
				setcookie("logged", TRUE);
				header("Location: sectionInfo.php");
			}
		} else {
			$idValue = "";
			$passwordValue = "";
		}

		// superglobals are not accessible in heredoc
		$scriptName = $_SERVER["PHP_SELF"];
		$topPart = <<<EOBODY
			<h1>Grades Submission System</h1>
			<form action="$scriptName" method="post">
			<strong>LoginId:</strong> <input type="text" name="id" value="$idValue" />
			<br /><br />
			<strong>Password:</strong> <input type="password" name="password" value="$passwordValue" />
			<br /><br />
			<input type="submit" name="login" value="Submit"/>
			</form>
EOBODY;
		$body = $topPart.$body;

		$page = generatePage($body);
		echo $page;
	}
?>
