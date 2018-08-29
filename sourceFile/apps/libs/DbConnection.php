<?php  
	class apps_libs_DbConnection
	{
		protected $username="root";
		protected $password="";
		protected $database="dborderonline";
		protected $host="localhost";
		protected $port=3303;
		protected $tableName;
		protected static $connectionInstance=null;
		protected $queryParams=[];


		public function __construct()
		{
			$this->connect();
		}
		public function connect()
		{
			if(self::$connectionInstance ===null)
			{
				try
				{
					self::$connectionInstance = new PDO("mysql:host=".$this->host.":".$this->port.";dbname=".$this->database, $this->username, $this->password);		
					self::$connectionInstance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				}
				catch(Exception $e)
				{
					echo "ERROR: ".$e->getMessage();
					die();
				}

			}
			else
				return self::$connectionInstance;
		}

		public function query($sql, $params=[])
		{
			$q=self::$connectionInstance->prepare($sql);

			// $sql="select * from posts where id=:id";
			// $params=
			// [
			// 	":id"=1;
			// ];
			// $q->execute($params);
			
			if(is_array($params)&&$params)
			{
				$q->execute($params);
			}
			else
			{
				$q->execute();
			}
			
			return $q;
		}

		public function buildQueryParams($params)
		{
			$default=
			[
				"select"=>"",
				"where"=>"",
				"other"=>"",
				"params"=>[],
				"field"=>"",
				"value"=>[],
				"join"=>""
			];
			$this->queryParams=array_merge($default, $params);
			/*
				các phần tử thuộc mảng params truyền vào sẽ ghi đè lên các phần tử của default
			*/
			return $this;
		}

		public function buildCondition($condition)
		{
			if(trim($condition))
			{
				return "where ".$condition;
			}
			else
				return "";
		}

		public function select()
		{

			//kiểm tra xem có điều kiện where không

			// if(trim($this->buildCondition($this->queryParams["where"])))//nếu có điều kiện trong where
			// {
			// 	var_dump($queryParams["params"]);die();
			// 	$sql="select ".$this->queryParams["select"]." from ".$this->tableName." ".$this->buildCondition($this->queryParams["where"])." =".$this->queryParams["params"]." ".$this->queryParams["other"];
				
			// }
			// else
			// {
			// 	$sql="select ".$this->queryParams["select"]." from ".$this->tableName." ".$this->queryParams["other"];
			// }

			$sql="select ".$this->queryParams["select"]." from ".$this->tableName." ".$this->queryParams["join"].$this->buildCondition($this->queryParams["where"])." ".$this->queryParams["other"];
			
			$query=$this->query($sql, $this->queryParams["params"]);
			
			return $query->fetchAll(PDO::FETCH_ASSOC);
		}

		public function selectOne()
		{
			
			$this->queryParams["other"]="limit 1";
			$data=$this->select();
			if($data)
			{
				return $data[0];
			}
			else
				return [];
		}

		public function insert()
		{

			$sql="call  ".$this->queryParams["where"];
			
			$result=$this->query($sql, $this->queryParams["params"]);
			
			if($result)
			{
				
				return self::$connectionInstance->lastInsertId();
				//sau khi chèn vào lấy kết quả cuối cùng ra
			}	
			else
				return false;
		}

		public function update()//finished
		{
			// $sql="update ".$this->tableName." set ".$this->queryParams["field"]."=".$this->$this->queryParams["values"].$this->buildCondition($this->queryParams["where"])." ".$this->queryParams["other"];
			$sql="call ".$this->queryParams["where"];
			
			return $this->query($sql, $this->queryParams["params"]);
		}

		public function delete()//finished
		{

			$sql="call ".$this->queryParams["where"];
			
			return $this->query($sql, $this->queryParams["params"]);
		}


		public function changePass()
		{
			
			$sql="update ".$this->tableName." set ".$this->queryParams["other"]." ".$this->buildCondition($this->queryParams["where"])." ";
			
			return $this->query($sql, $this->queryParams["params"]);

		}

		public function select_xam_xi()
		{
			$sql="call ".$this->queryParams["where"];
			
			
			$query=$this->query($sql, $this->queryParams["params"]);
			
			return $query->fetchAll(PDO::FETCH_ASSOC);
		}
	}
?>