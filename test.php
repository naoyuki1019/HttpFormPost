<?php

if ("POST" === $_SERVER["REQUEST_METHOD"]) {

	echo ('$_POST => ' . nl2br(str_replace(" ", "&nbsp", print_r($_POST, true)) . '<br>'));
	echo ('$_COOKIE => ' . nl2br(str_replace(" ", "&nbsp", print_r($_COOKIE, true)) . '<br>'));
	echo ('$_SERVER["HTTP_REFERER"] => ' . nl2br(str_replace(" ", "&nbsp", print_r($_SERVER["HTTP_REFERER"], true)) . '<br><br>'));
	echo ('$_FILES => ' . nl2br(str_replace(" ", "&nbsp", print_r($_FILES, true)) . '<br>'));
}
else {

	include "HttpFormPost.php";

	echo "<h1>success</h1>";
	$ins = new HttpFormPost();
	$ins->set_url((empty($_SERVER["HTTPS"]) ? "http://" : "https://") . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);

	// add_text
	$ins->add_text("name", "yamada taro");
	$ins->add_text("age", "20");
	$ins->add_text("param[]", "param1");
	$ins->add_text("param[]", "param2");

	// add_keyval_array
	$keyval = array('pref' => 'tokyo', 'address1' => 'bunkyo');
	$ins->add_keyval_array("param", $keyval);

	// add_file
	$ins->add_file("upload_file[]", "abc.txt", "abc1.txt", "text/plain");
	$ins->add_file("upload_file[]", "abc.txt", "abc2.txt", "text/plain");

	// add_header
	$ins->add_header("Referer: http://umauma.com");
	$ins->add_header("Cookie: session_id=7XgoV3iJqVc%2Bus%");

	$response = $ins->submit();
	if (FALSE === $response) {
		echo implode("<br>", $ins->errors()) . "<br>";
	}
	else {
		echo $response;
	}


	echo "<h1>error Attachment not found</h1>";
	$ins->initialize();
	$ins->set_url((empty($_SERVER["HTTPS"]) ? "http://" : "https://") . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
	$ins->add_file("upload_file2", "missing.txt", "missing", "text/plain");
	$response = $ins->submit();
	if (FALSE === $response) {
		echo implode("<br>", $ins->errors()) . "<br>";
	}
	else {
		echo $response;
	}


	echo "<h1>error 404</h1>";
	$ins->initialize();
	$ins->set_url("http://abcd.not.found.com");
	$response = $ins->submit();
	if (FALSE === $response) {
		echo implode("<br>", $ins->errors()) . "<br>";
	}
	else {
		echo $response;
	}
}
