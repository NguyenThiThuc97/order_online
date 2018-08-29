<?php  

	class apps_libs_routers
	{
		const params_name="r";
		const home_page="home";
		const index_page="index";
		public static $sourcePath;

		public function __construct($sourcePath="")
		{
			if($sourcePath)
			{
				self::$sourcePath=$sourcePath;

			}
		}

		public function getGET($name=null)
		{
			if($name!==null)
			{
				return isset($_GET[$name]) ? $_GET[$name]:null;

			}
			else
				return $_GET;
		}

		public function getPOST($name=null)
		{
			if($name!==null)
			{
				return isset($_POST[$name]) ? $_POST[$name]:null;

			}
			else
				return $_POST;
		}


		public function router()
		{
			$url=$this->getGET(self::params_name);

			
			if(!is_string($url) || !$url ||$url==self::index_page)
			{
				$url=self::home_page;
			}
			$path=self::$sourcePath."/".$url.".php";
			
			if(file_exists($path))
			{
				return require_once $path;
			}
			else
				return $this->pageNotFound();
		}

		public function pageNotFound()
		{
			echo "404 Page Not Found";
			die();
		}

		public function createURL($url, $params=[])
		{
			if($url)
			{
				$params[self::params_name]=$url;
			}
			
			return $_SERVER['PHP_SELF'].'?'.http_build_query($params);
		}
		
		public function redirect($url)
		{
			$u=$this->createURL($url);
			header("Location:$u");
		}

		public function loginPage()
		{
			$this->redirect("login");
		}

		public function homePage()
		{
			$this->redirect(self::home_page);
		}
	}

?>