<?php 

	/**
	 * 

	 */
	class apps_models_category extends apps_libs_DbConnection
	{
		
		protected $tableName="productCategory";

		public function addNewCate($new_name="")
		{
			$cate=new apps_models_category();
			$sql=$cate->buildQueryParams(
				[
					"where"=>"add_new_category(:name)",
					"params"=>[":name"=>$new_name]
				]
			)->insert();
			if($sql!==false)
			{
				
				return true;
			}
			else
				return false;
		}

		public function view_category_with_id($id=0)
		{
			$listCate=new apps_models_category();
			$cate=$listCate->buildQueryParams(
				[
					"select"=>"*",
					"where"=>"categoryID=:id",
					"params"=>[":id"=>$id]
				]
			)->selectOne();
			return $cate;
		}
	}

 ?>