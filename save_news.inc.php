<?php
	$t = $news->clearStr($_POST['title']);
	$c = $news->clearInt($_POST['category']);
	$d = $news->clearStr($_POST['description']);
	$s = $news->clearStr($_POST['source']);
	$s = $news->clearSource($s);

	if(empty($t) || empty($d)) {
		$errMsg = "Заполните все поля формы!";
	}
	else {
		$result = $news->saveNews($t, $c, $d, $s);

		if($result) {
			header("Location: news.php");
			exit;
		}
		else
			$errMsg = "Произошла ошибка при добавлении новости!";		
	}
?>