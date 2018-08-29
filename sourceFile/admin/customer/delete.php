<?php 

	$a=new apps_libs_routers();
	$id=intval($a->getGET("cusID"));//idCategory

	$delCus=new apps_models_customer();


	$identity=new apps_libs_userIdentity();


	if($id==$identity->getSESSION("userID"))
	{
		var_dump("denied!!!");die();
	}
	else
	{
		$result=$delCus->buildQueryParams(
			[
				"where"=>"deleteCus(:id)",
				"params"=>[":id"=>$id]
			]
		)->delete();

	

		$link_ne=$a->createURL("customer/index", ["action"=>"view"]);
		header("Location:".$link_ne);
	}	
	
	
	

?>