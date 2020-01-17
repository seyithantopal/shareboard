<?php

class Database {

	private $pdo 			= null;

	// SQL query
	private $sql 			= null;

	// Last statement
	private $statement 		= null;

	// Selected columns
	private $select 		= '*';

	// From table
	private $from 			= null;

	// Where string
	private $where 			= [];

	// Join string
	private $join 			= [];

	// OrderBy string
	private $order_by 		= [];

	// Having string
	private $having 		= [];

	// GroupBy string
	private $group_by 		= null;

	// Limit string
	private $limit 			= null;

	// Total row count
	private $num_rows 		= 0;

	// Last insert id
	private $insert_id		= null;

	// Table prefix
	private $prefix 		= null;

	// Error
	private $error 			= null;

	private $in = [];

	private static $instance;

	// Getting instance
	public static function init($config = [])
	{
		if (null === static::$instance) {
			static::$instance = new static($config);
		}

		return self::$instance;
	}

	public function __construct($config = []) {
		$config['db_driver']	= (@$config['db_driver']) ? $config['db_driver'] : 'mysql';
		$config['db_host']		= (@$config['db_host']) ? $config['db_host'] : 'localhost';
		$config['db_charset']	= (@$config['db_charset']) ? $config['db_charset'] : 'utf8';
		$config['db_collation']	= (@$config['db_collation']) ? $config['db_collation'] : 'utf8_general_ci';
		$config['db_prefix']	= (@$config['db_prefix']) ? $config['db_prefix'] : '';


		// Setting prefix
		$this->prefix = $config['db_prefix'];

		$dsn = '';

		// Setting connection string
		if($config['db_driver'] == 'mysql' || $config['db_driver'] == '') {
			$dsn = $config['db_driver'] . ':host=' . $config['db_host'] . ';dbname=' . $config['db_name'] . ';charset=' . $config['db_charset'];
		}

		// Connecting to server
		try
		{
			$this->pdo = new \PDO($dsn, $config['db_user'], $config['db_pass']);
			/*$this->pdo->exec("SET NAMES '" . $config['db_charset'] . "' COLLATE '" . $config['db_collation'] . "'");
			$this->pdo->exec("SET CHARACTER SET '" . $config['db_charset'] . "'");
			$this->pdo->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_OBJ);*/
		}
		catch(\PDOException $e)
		{
			die('Cannot connect to Database with PDO.<br /><br />'.$e->getMessage());
		}

		return $this->pdo;
	}

	private function escape($data)
	{
		return $this->pdo->quote(trim($data));
	}

	public function execute($sql, $val = [], $single = false) {
		try{
			if($single == true) {
				$query 				= $this->pdo->prepare($this->sql);
				$insert 			= $query->execute($val);
				$this->insert_id 	= $this->pdo->lastInsertId();
				$result				= $query->fetch(PDO::FETCH_ASSOC);
				for ($i=0; $i<count($this->where); $i++)
				{
					unset($this->where[$i]);
				}
				return $result;
			}
			else {
				$query 				= $this->pdo->prepare($this->sql);
				$insert 			= $query->execute($val);
				$this->insert_id 	= $this->pdo->lastInsertId();
				$result				= $query->fetchAll(PDO::FETCH_ASSOC);
				for ($i=0; $i<count($this->where); $i++)
				{
					unset($this->where[$i]);
				}
				return $result;
			}

		} catch(\PDOException  $e) {
			$this->error($e->getMessage());
		}
	}

	public function insert($table, $params = []) {

		// INSERT INTO uyeler VALUES (:kadi, :sifre);
		// INSERT INTO uyeler SET kadi = ? ,sifre = ?

		$this->sql = 'INSERT INTO ' . $this->prefix . $table . ' SET ';
		$col 	= [];
		$val 	= [];
		$stmt 	= [];
		foreach($params as $column => $value) {
			$col[] 	= $column . ' = ?';
			$val[] 	= $value;
			$stmt[] = $column . ' = ' . $this->escape($value);
		}

		$this->statement = $this->sql . implode(', ', $stmt);
		$this->sql .= implode(', ', $col);
		$this->execute($this->sql, $val);
	}


	/*public function where($params = [])
	{
		$col 	= [];
		$val 	= [];
		$stmt 	= [];
		foreach($params as $column => $value) {
			$col[] 	= $column . ' = ?';
			$val[] 	= $value;
			$stmt[] = $column . ' = ' . $this->escape($value);
		}
		$this->statement = $this->sql . implode(' AND ', $stmt);
		$this->sql .= implode(' AND ', $col);
		return $this;
	}*/


	public function where($params = [])
	{
		
		foreach($params as $column => $value) {
			$this->where[] = ['col' => $column, 'val' => $value];
		}
		return $this;
	}

	public function join($params)
	{
		
		foreach($params as $column => $value) {
			$this->join[] = ['col' => $column, 'val' => $value];
		}
		return $this;
	}
	public function order_by($column, $value) {
		$this->order_by = ['col' => $column, 'val' => $value];
		return $this;
	}

	public function in($column, $value) {
		$this->in = ['col' => $column, 'val' => $value];
		return $this;
	}

	public function delete($table) {

		$this->sql = 'DELETE FROM ' . $this->prefix . $table;
		$col 	= [];
		$val 	= [];
		$stmt 	= [];
		
		// WHERE
		
		if(count($this->where) > 0) {
			$this->sql .= ' WHERE ';
			
			foreach($this->where as $where) {
				$col[] 	= $where['col'] . ' = ?';
				$val[] 	= $where['val'];
				$stmt[] = $where['col'] . ' = ' . $this->escape($where['val']);
			}
			$this->statement = $this->sql . implode(' AND ', $stmt);
			$this->sql .= implode(' AND ', $col);
		}
		$this->execute($this->sql, $val);
	}

	public function get($table) {

		$this->sql = 'SELECT * FROM ' . $this->prefix . $table;
		$col 	= [];
		$val 	= [];
		$stmt 	= [];

		// JOIN
		
		if(count($this->join) > 0) {
			$this->sql .= ' JOIN ';
			$join = '';
			$condition = '';
			foreach($this->join as $key => $value) {
				$join = $value['col'];
				$condition = $value['val'];
			}
			$this->statement = $this->sql . $join . ' ON ' . $condition;
			$this->sql .= $join . ' ON ' . $condition;
		}

		// WHERE
		
		if(count($this->where) > 0) {
			$this->sql .= ' WHERE ';
			
			foreach($this->where as $where) {
				$col[] 	= $where['col'] . ' = ?';
				$val[] 	= $where['val'];
				$stmt[] = $where['col'] . ' = ' . $this->escape($where['val']);
			}
			$this->statement = $this->sql . implode(' AND ', $stmt);
			$this->sql .= implode(' AND ', $col);
		}

		// IN

		if(count($this->in) > 0) {
			if(count($this->where) <= 0) $this->sql .= ' WHERE ';
			$this->statement = $this->sql . $this->in['col'] . ' IN (' . $this->in['val'] . ')';
			$this->sql .= $this->in['col'] . ' IN (' . $this->in['val'] . ')';
		}

		// WHERE
		
		if(count($this->order_by) > 0) {
			$this->sql .= ' ORDER BY ';		
			$this->statement = $this->sql . $this->order_by['col'] . ' ' . $this->order_by['val'];
			$this->sql .= $this->order_by['col'] . ' ' . $this->order_by['val'];
		}

		return $this->execute($this->sql, $val, false);
	}

	public function row($table) {
		$this->sql = 'SELECT * FROM ' . $this->prefix . $table;
		$col 	= [];
		$val 	= [];
		$stmt 	= [];
		
		// WHERE
		
		if(count($this->where) > 0) {
			$this->sql .= ' WHERE ';
			
			foreach($this->where as $where) {
				$col[] 	= $where['col'] . ' = ?';
				$val[] 	= $where['val'];
				$stmt[] = $where['col'] . ' = ' . $this->escape($where['val']);
			}
			$this->statement = $this->sql . implode(' AND ', $stmt);
			$this->sql .= implode(' AND ', $col);
		}
		return $this->execute($this->sql, $val,true);
	}

	public function result() {

	}

	public function update($table, $params = []) {

		$this->sql = 'UPDATE ' . $this->prefix . $table . ' SET ';
		$col 	= [];
		$val 	= [];
		$stmt 	= [];

		$col2 	= [];
		$val2 	= [];
		$stmt2 	= [];

		foreach($params as $column => $value) {
			$col2[] 	= $column . ' = ?';
			$val2[] 	= $value;
			$stmt2[] = $column . ' = ' . $this->escape($value);
		}
		$this->statement = $this->sql . implode(', ', $stmt2);
		$this->sql .= implode(', ', $col2);

		// WHERE
		
		if(count($this->where) > 0) {
			$this->sql .= ' WHERE ';
			
			foreach($this->where as $where) {
				$col[] 	= $where['col'] . ' = ?';
				$val[] 	= $where['val'];
				$stmt[] = $where['col'] . ' = ' . $this->escape($where['val']);
			}
			$this->statement = $this->sql . implode(' AND ', $stmt);
			$this->sql .= implode(' AND ', $col);
			$this->execute($this->sql, array_merge($val2, $val));
		}

	}

	public function truncate($table) {

		$this->sql = 'TRUNCATE TABLE ' . $this->prefix . $table;
		$this->execute($this->sql, null);
	}

}
