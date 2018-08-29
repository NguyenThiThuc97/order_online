<?php  
	

	include '../apps/bootstrap.php';
	// $a=new apps_models_users();

	// $result=$a->buildQueryParams(["insert"=>"*", "into"=>'',
	// 								"field"=>"(username, password) values (?,?)",
	// 								"value"=>["admin", md5("admin")]])->insert();
	// var_dump($result);


	$router=new apps_libs_routers(__dir__);
	$router->router();
	

?>