<?php
	require "NewsDB.class.php";

	$news = new NewsDB;
	$errMsg = "";

	if($_SERVER['REQUEST_METHOD'] == 'POST')
		include "save_news.inc.php";
	if(isset($_GET['del']))
		include "delete_news.inc.php";
?>

<!DOCTYPE html>

<html>
<head>
	<title>Новостная лента</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>

<h1>Последние новости</h1>
<?php
	include "get_news.inc.php";
	if ($errMsg)
		echo "<h3>$errMsg</h3>";
?>
<form action="<?= $_SERVER['PHP_SELF']; ?>" method="post">

Заголовок новости:<br />
<input type="text" name="title" /><br />
Выберите категорию:<br />
<select name="category">
<option value="1">Политика</option>
<option value="2">Культура</option>
<option value="3">Спорт</option>
</select>
<br />
Текст новости:<br />
<textarea name="description" cols="50" rows="5"></textarea><br />
Источник:<br />
<input type="text" name="source" /><br />
<br />
<input type="submit" value="Добавить!" />

</form>

<?php

?>

</body>
</html>