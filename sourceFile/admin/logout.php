<?php  

	$user=new apps_libs_userIdentity();
	$user->logout();

	(new apps_libs_routers())->loginPage();

?>