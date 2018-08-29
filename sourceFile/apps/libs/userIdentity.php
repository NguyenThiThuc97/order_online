<?php  

	/**
	 * 
	 */

	include '../apps/bootstrap.php'; 

	session_start();
	class apps_libs_userIdentity
	{
		public $username;
		public $password;

		protected $id;

		public function __construct($username="", $password="")
		{
			# code...
			$this->username=$username;
			$this->password=$password;
		}

		public function ecryptPassword($pass="")
		{
			return md5($pass);
		}
		//md5($this->password)

		public function loginEmp()
		{
			
			$userInfo=new apps_models_employee();
			$result=$userInfo->buildQueryParams
			([
				"select"=>"*",
				"where"=>"name=:userN and pass=:pass",
				"params"=>
				[
					":userN"=>trim($this->username),
					":pass"=>$this->ecryptPassword($this->password)
				]

			])->selectOne();

			if($result)
			{
				$_SESSION["userID"]=$result["ID"];
				$_SESSION["username"]=$result["name"];
				$_SESSION["userType"]="employee";
				return true;

			}
			else
			{
				return false;
			}
		}

		public function loginCus($cusName="", $cusPass="")
		{
			
			$userInfo=new apps_models_customer();
			$result=$userInfo->buildQueryParams
			([
				"select"=>"*",
				"where"=>"customerName=:userN and pass=:pass",
				"params"=>
				[
					":userN"=>trim($cusName),
					":pass"=>$this->ecryptPassword($cusPass)
				]

			])->selectOne();

			if($result)
			{
				$_SESSION["userID"]=$result["customerID"];
				$_SESSION["username"]=$result["customerName"];
				$_SESSION["userType"]="customer";
				return true;

			}
			else
			{
				
				return false;
			}
		}
			//registerAccount for customer
		public function registerAccount($cusName="", $phone=0, $address="", $pass="")
		{
			$newUser=new apps_models_customer();

			$result=$newUser->buildQueryParams
			(
				[
					"where"=>"addNewCus(:a, :b, :c, :d)",
					"params"=>
					[
						":a"=>$cusName,
						":b"=>$phone,
						":c"=>$address,
						":d"=>$this->ecryptPassword($pass)
					]
				]
			)->insert();
			if($result!==false)
			{

				
				return true;

			}
			else
			{
				
				return false;
			}

		}

		public function logout()
		{
			unset($_SESSION["userID"]);
			unset($_SESSION["username"]);
			unset($_SESSION["userType"]);
		}

		public function getSESSION($name)
		{
			if($name!==null)
			{
				return isset($_SESSION[$name]) ? $_SESSION[$name]:null;
			}
			return $_SESSION;
		}


		public function isLogin()
		{

			if($this->getSESSION("userID"))
			{

				return true;
			}
			return false;
		}

		public function getID()
		{
			return $this->getSESSION("userID");
		}
	}

?>