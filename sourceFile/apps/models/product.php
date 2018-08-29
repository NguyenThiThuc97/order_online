<?php 
	/**
	 * 
	 */
	class apps_models_product extends apps_libs_DbConnection
	{
		protected $tableName="product";
		

		public function view_product()
		{
			$product=new apps_models_product();
			$result=$product->buildQueryParams(
				[
					"where"=>"view_all_product()",
					"params"=>[]
				]
			)->select_xam_xi();
			return $result;
		}	
		public function view_product_with_id($id=0)
		{
			$product=new apps_models_product();
			$result=$product->buildQueryParams(
				[
					"where"=>"view_product_with_id(:id)",
					"params"=>[":id"=>$id]
				]
			)->select_xam_xi();
			return $result;
		}

		public function add_new_product($name="", $cateID=0, $unitNames="", $unitScales=0, $discontinueds=0, $discontinuedPrices=0, $empIds=0, $price=0, $image="")
		{
			$product=new apps_models_product();

			
			$result=$product->buildQueryParams
			(
			    [
			      "where"=>"add_new_product(:name,:cateID, :unitNames, :unitScales, :discontinueds, :discontinuedPrices, :empIds, :price, :image)",
			      "params"=>[
			        ":name"=>$name,
			        ":cateID"=>$cateID,
			        ":unitNames"=>$unitNames,
			        ":unitScales"=>$unitScales,
			        ":discontinueds"=>$discontinueds,
			        ":discontinuedPrices"=>$discontinuedPrices,
			        ":empIds"=>$empIds,
			        ":price"=>$price,
			        ":image"=>$image
			      ]
			    ]
			  )->insert();

			return $result;
		}

		public function update_product($name="", $cateID=0, $unitNames="", $unitScales=0, $discontinueds=0, $discontinuedPrices=0, $empIds=0, $price=0, $image="")
		{

		}
	}
 ?>