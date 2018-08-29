<?php 

	
	$b=new apps_libs_routers();
	$identity=new apps_libs_userIdentity();

   
	if($identity->isLogin()===false)
	{
		$b->loginPage();
	}
  else
    if($userType=$identity->getSESSION("userType")==="employee")//nhân viên vào đúng trang admin
    {
      $userID=$identity->getSESSION("userID");
      $username=$identity->getSESSION("username");

    }
    else //khách hàng sẽ quay trở lại trang home
    {
      header("Location:?r=../public/home");
    }

    //change password

    //get variable from form 

    $oldPass=trim($b->getPOST("oldPass"));
    $newPass=trim($b->getPOST("newPass"));
    $reNewPass=trim($b->getPOST("reNewPass"));

    if($b->getPOST("submit")&&$oldPass&&$newPass&&$reNewPass)
    {
    	//get password from db
    	$userID=$identity->getSESSION("userID");
    	$get_userPass=new apps_models_employee();
    	$userInfor=$get_userPass->view_employee_with_id($userID);
    	$userPass=$userInfor["pass"];
    	//end get password
    	if($userPass===md5($oldPass))
    	{
    		if($newPass===$reNewPass)
    		{
    			$result=$get_userPass->buildQueryParams(
    				[
    					"other"=>"pass=:pass",
    					"where"=>"id=:id",
    					"params"=>
    					[
    						":pass"=>md5($newPass),
    						"id"=>$userID
    					]
    				]
    			)->changePass();
    			if($result)
    			{
    				echo "success!!!";die();
    			}
    			else
    				echo "fail!!";die();
    		}
    		else
    			echo "old and new pass are different!!!";die();

    	}
    	else
    	{
    		echo "password is incorrect!!!";
    		die();
    	}

    }
    

 ?>
 <!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Change Your Password</title>

    <!-- Bootstrap -->
    <link href="/orderOnline/includeFile/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="/orderOnline/includeFile/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="/orderOnline/includeFile/vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- jQuery custom content scroller -->
    <link href="/orderOnline/includeFile/vendors/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.min.css" rel="stylesheet"/>

    <!-- Custom Theme Style -->
    <link href="/orderOnline/includeFile/build/css/custom.min.css" rel="stylesheet">
  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col menu_fixed">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <a href="index.html" class="site_title"><span>Welcome!</span></a>
            </div>

            <div class="clearfix"></div>

            <!-- menu profile quick info -->
            <div class="profile clearfix">
              <div class="profile_pic">
                <img src="/orderOnline/includeFile/production/images/user.png" alt="..." class="img-circle profile_img">
              </div>
              <div class="profile_info">
                <br>
                <h2></h2>
              </div>
            </div>
            <!-- /menu profile quick info -->

            <br />

            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <h3>General</h3>
                <ul class="nav side-menu">
                  <li><a href="https://www.google.com"><i class="fa fa-home"></i> Home </a>
                    
                  </li>
                  
                  <li><a><i class="fa fa-table"></i> Categories <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="#">List Categories</a></li>
                      <li><a href="#">Add A New Category</a></li>
                    </ul>
                  </li>
                <li>
                	<!--Thêm nhân viên mới....................-->
                	<a><i class="fa fa-user"></i> Employee <span class="fa fa-chevron-down"></span></a>
                	<ul class="nav child_menu">
                      <li><a href="<?= $b->createURL("employee/index", ["action"=>"view"])?>">List Employee</a></li>
                      <li><a href="<?= $b->createURL("employee/index", ["action"=>"new"])?>">Add A New Eployee</a></li>
                    </ul>
                </li>

                <li><a><i class="fa fa-table"></i> Company Shipper <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="#">List Companies</a></li>
                      <li><a href="#">Add A New Company</a></li>
                    </ul>
                  </li>

                <li>
                	
                	<a href="<?= $b->createURL("customer/index", ["action"=>"view"])?>"><i class="fa fa-user"></i> Customer </a>
                	
                </li>       
                </ul>
              </div>
              

            </div>
            <!-- /sidebar menu -->

            <!-- /menu footer buttons -->
            <div class="sidebar-footer hidden-small">
              <a data-toggle="tooltip" data-placement="top" title="Settings">
                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Lock">
                <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Logout" href="login.html">
                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
              </a>
            </div>
            <!-- /menu footer buttons -->
          </div>
        </div>

        <!-- top navigation -->
        <div class="top_nav">
          <div class="nav_menu">
            <nav>
              <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
              </div>

              <ul class="nav navbar-nav navbar-right">
                <li class="">
                  <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <img src="images/img.jpg" alt=""><?php echo $username; ?>
                    <span class=" fa fa-angle-down"></span>
                  </a>
                  <ul class="dropdown-menu dropdown-usermenu pull-right">
                    <li><a href="javascript:;"> Profile</a></li>
                    
                    <li><a href="<?= $b->createURL("logout")?>"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
                    <li><a href="#"><i class="fa fa-sign-out pull-right"></i> Change password</a></li>
                  </ul>
                </li>

                <li role="presentation" class="dropdown">
                  
                  
            </nav>
          </div>
        </div>
        <!-- /top navigation -->

        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            
            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  
                  <div class="x_content">

                    <form class="form-horizontal form-label-left" novalidate method="post" action="<?php echo $b->createURL('changePass'); ?>">

                      
                      <span class="section">Change Password</span>

                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name" >Old Password <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input id="name" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" data-validate-words="2"  placeholder="" required="required" type="text" name="oldPass">
                        </div>
                      </div>
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">New Password <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="email" id="email"  required="required" class="form-control col-md-7 col-xs-12" name="newPass">
                        </div>
                      </div>
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Confirm your new password <span class="required" >*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="email" id="email2"  data-validate-linked="email" required="required" class="form-control col-md-7 col-xs-12" name="reNewPass">
                        </div>
                      </div>
                      
                      
                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-6 col-md-offset-3">
                          <button type="submit" class="btn btn-primary" name="cancel">Cancel</button>
                          <input id="send" type="submit" class="btn btn-success" name="submit" value="submit">

                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- /page content -->

        <!-- footer content -->
        <footer>
          <div class="pull-right">
            
          </div>
          <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
      </div>
    </div>

    <!-- jQuery -->
    <script src="/orderOnline/includeFile/vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="/orderOnline/includeFile/vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="/orderOnline/includeFile/vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="/orderOnline/includeFile/vendors/nprogress/nprogress.js"></script>
    <!-- jQuery custom content scroller -->
    <script src="/orderOnline/includeFile/vendors/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js"></script>

    <!-- Custom Theme Scripts -->
    <script src="/orderOnline/includeFile/build/js/custom.min.js"></script>
  </body>
</html>