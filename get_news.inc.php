<?php
	$all_news_result = $news->getNews();
	if(!is_array($all_news_result))
		$errMsg = "Произошла ошибка при выводе новостной ленты!";
	else {
		foreach ($all_news_result as $key => $value) {
			$id = $all_news_result[$key]['id'];
			$title = $all_news_result[$key]['title'];
			$category = $all_news_result[$key]['category'];
			$description = $all_news_result[$key]['description'];
			$href = $all_news_result[$key]['source'];
			$time = date('H:i j.m.Y', $all_news_result[$key]['datetime']);
			echo "<div class='newsContainer'>";
				echo "<h2>".$title."</h2>";
				echo "<p class='newsCategoryAndTime'>".$category." ".$time."</p>";
				echo "<p class='newsDescription'>".$description."</p>";
				echo "<a class='newsSource' href='http://$href'>$href</a><br>";
				echo "<a class='newsSource' href='news.php?del=$id'>Удалить новость</a>";
			echo "</div>";
			echo "<hr>";
		}
	}
?>