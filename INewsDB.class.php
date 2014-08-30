<?php

interface INewsDB {
	//$title; //заголовок новости
	//$category; //категория новости
	//$description; //текст новости
	//$source; //источник новости
	
	function saveNews($title, $category, $description, $source);

	function getNews();
	
	function deleteNews($id);
}

?>