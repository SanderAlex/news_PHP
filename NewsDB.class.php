<?php

require "INewsDB.class.php";

class NewsDB implements INewsDB {
	const DB_NAME = "news.db";	//имя файла с базой данных
	protected $_db;	//объект класса SQLite3

	function __construct() {
		if(file_exists(self::DB_NAME)) {
			$this->_db = new SQLite3(self::DB_NAME);
		}
		else {
			$this->_db = new SQLite3(self::DB_NAME);

			try {
				$sql = "CREATE TABLE msgs(
									id INTEGER PRIMARY KEY AUTOINCREMENT,
									title TEXT,
									category INTEGER,
									description TEXT,
									source TEXT,
									datetime INTEGER)";
				$res = $this->_db->exec($sql);
				if(!$res)
					throw new Exception($this->_db->lastErrorMsg());

				$sql = "CREATE TABLE category(
									id INTEGER,
									name TEXT)";
				$res = $this->_db->exec($sql);
				if(!$res)
					throw new Exception($this->_db->lastErrorMsg());

				$sql = "INSERT INTO category(id, name)
								SELECT 1 as id, 'Политика' as name
								UNION SELECT 2 as id, 'Культура' as name
								UNION SELECT 3 as id, 'Спорт' as name";
				$res = $this->_db->exec($sql);
				if(!$res)
					throw new Exception($this->_db->lastErrorMsg());
			}
			catch(Exception $e) {
				return false;
			}
		}
	}

	function __destruct() {
		unset($this->_db);
	}

	function clearStr($str) {
		$data = strip_tags(trim($str));
		return $this->_db->escapeString($data);
	}

	function clearInt($int) {
		return abs((int)$int);
	}

	function clearSource($source) {
		if (substr($source, 0, 7) == "http://")
			$source = substr($source, 7);
		return $source;
	}

	function saveNews($title, $category, $description, $source) {
		try {
			$datetime = time();
			$sql = "INSERT INTO msgs(title, category, description, source, datetime)
					VALUES ('$title', $category, '$description', '$source', $datetime)";
			$res = $this->_db->exec($sql);
			if(!$res)
				throw new Exception($this->_db->lastErrorMsg());
			return $res;
		}
		catch(Exception $e) {
			return false;
		}	
	}
	
	function getNews() {
		try {
			$result_array = array();
			$sql = "SELECT msgs.id as id, title, category.name as category, description, source, datetime
					FROM msgs, category
					WHERE category.id = msgs.category
					ORDER BY msgs.datetime DESC";
			$result = $this->_db->query($sql);
			if(!$result)
				throw new Exception($this->_db->lastErrorMsg());
			while($res = $result->fetchArray(SQLITE3_ASSOC)) {
				$result_array[] = $res;
			}
			return $result_array;
		}
		catch(Exception $e) {
			return false;
		}
	}

	function deleteNews($id) {
		try {
			$sql = "DELETE FROM msgs
					WHERE id=$id";
			$res = $this->_db->exec($sql);
			if(!$res)
				throw new Exception($this->_db->lastErrorMsg());
			return true;
		}
		catch(Exception $e) {
			return false;
		}	
	}	
}

?>