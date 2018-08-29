<?php 

	$a=new apps_libs_routers();
	$id=intval($a->getGET("idEmp"));//idCategory

	$delEmp=new apps_models_employee();


	$identity=new apps_libs_userIdentity();


	if($id==$identity->getSESSION("userID"))
	{
		var_dump("denied!!!");die();
	}
	else
	{
		$result=$delEmp->buildQueryParams(
			[
				"where"=>"deleteEmployee(:id)",
				"params"=>[":id"=>$id]
			]
		)->delete();

	

		$link_ne=$a->createURL("employee/index", ["action"=>"view"]);
		header("Location:".$link_ne);
	}
	
	
	

?>