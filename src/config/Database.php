<?php
class Database{
	protected $dbh;
	protected $stmt;

	/*
	 * Connection to database
	 */
	public function __construct(){
		try
		{
			$this->dbh = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
			if(!$this->dbh)
			{
				throw new PDOException('Connection failed!');
			}
		}catch (PDOException $e)
		{
			$e->getMessage();
		}
	}

	/*
	 * Query builder
	 */
	public function query($query){
		$this->stmt = $this->dbh->prepare($query);
	}

	/*
	 * Bind params
	 */
	public function bind($param, $value, $type = null){
		if(is_null($type)){
			switch (true){
				case is_int($value):
					$type = PDO::PARAM_INT;
					break;
				case is_bool($value):
					$type = PDO::PARAM_BOOL;
					break;
				case is_null($value):
					$type = PDO::PARAM_NULL;
					break;
				default:
					$type = PDO::PARAM_STR;
			}
		}
		$this->stmt->bindValue($param, $value, $type);
	}

	/*
	 * Execute query
	 * @return bool
	 */
	public function execute(){
		$this->stmt->execute();

	}

	/*
	 * Execute query
	 * @return object
	 */
	public function resultSet(){
		$this->execute();
		return $this->stmt->fetchAll(PDO::FETCH_OBJ);
	}

	/*
	 * Execute query
	 * @return array
	 */
	public function single(){
		$this->execute();
		return $this->stmt->fetch(PDO::FETCH_ASSOC);
	}

	/*
	 * Shows last inserted ID
	 * @return int
	 */
	public function lastInsertId(){
		return $this->dbh->lastInsertId();
	}
}