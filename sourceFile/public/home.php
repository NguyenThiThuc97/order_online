<?php
	$b=new apps_libs_routers();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Home Page</title>
</head>
<body>
	<a href="<?= $b->createURL("logout")?>">Log Out</a>
</body>
</html>