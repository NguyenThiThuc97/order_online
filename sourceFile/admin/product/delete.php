<?php 

	$a=new apps_libs_routers();
	$id=intval($a->getGET("idProduct"));//idCategory

	$del_product=new apps_models_product();

//bảo mật: xem thử người dùng đã đăng nhập để thực hiện tác vụ chưa?
		$identity=new apps_libs_userIdentity();
		$result=$del_product->buildQueryParams(
			[
				"where"=>"delete_product(:id)",
				"params"=>[":id"=>$id]
			]
		)->delete();
		$link_ne=$a->createURL("product/index", ["action"=>"view"]);
		header("Location:".$link_ne);
?>