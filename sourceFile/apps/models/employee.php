<?php

	class apps_models_employee extends apps_libs_DbConnection
	{
		protected $tableName="employee";



		//md5($this->password)

		public function addNewEmp($name, $pass)
		{

			$passEncrypt=md5($pass);
			
			$newEmp=$this->buildQueryParams
			(
				[
					"where"=>"addNewEmp(:name, :pass)",
					"params"=>
					[
						":name"=>$name,
						":pass"=>$passEncrypt
					]
				]
			)->insert();

			return $newEmp;//$newEmp===false||number
			
		}
		public function view_employee_with_id($id=0)
		{
			$listEmp=new apps_models_employee();
			$emp=$listEmp->buildQueryParams(
				[
					"select"=>"*",
					"where"=>"id=:id",
					"params"=>[":id"=>$id]
				]
			)->selectOne();
			return $emp;
		}
//update name, and pass is different
		// public function updateEmployee($id=0, $name="", $pass="")
		// {
		// 	$updateEmp=new apps_models_employee();
		// 	$result=$updateEmp->buildQueryParams(
		// 		[
					
		// 		]
		// 	)
		// }
	}
?>