<?php

	class apps_models_customer extends apps_libs_DbConnection
	{
		protected $tableName="customer";
		
		public function view_customer_with_id($id=0)
		{
			$listCus=new apps_models_customer();
			$cus=$listCus->buildQueryParams(
				[
					"select"=>"*",
					"where"=>"customerID=:id",
					"params"=>[":id"=>$id]
				]
			)->selectOne();
			return $cus;
		}

		
		
	}
?>