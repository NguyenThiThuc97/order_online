<?php 

	$a=new apps_libs_routers();
	$id=intval($a->getGET("idCate"));//idCategory

	$delEmp=new apps_models_category();


	$identity=new apps_libs_userIdentity();


	
		$result=$delEmp->buildQueryParams(
			[
				"where"=>"delete_category(:id)",
				"params"=>[":id"=>$id]
			]
		)->delete();

	

		$link_ne=$a->createURL("category/index", ["action"=>"view"]);
		header("Location:".$link_ne);
	
	
	
	

?>