<?php

  $b=new apps_libs_routers();
  $identity=new apps_libs_userIdentity();

  //kiểm tra đăng nhập
  if($identity->isLogin()===false)
  {
    $b->loginPage();
  }
//lấy danh dách toàn bộ các nhân viên
  $listEmp=new apps_models_employee();
  $Emp=$listEmp->buildQueryParams(
    [
      "select"=>"*"

    ]
  )->select();



  //thêm nhân viên mới
  $newName=trim($b->getPOST("name"));
  $newPass=trim($b->getPOST("pass"));


  if($b->getPOST("submit") && $newName && $newPass)
  {
    $result=$listEmp->addNewEmp($newName, $newPass);
    if($result!==false){
      //back to index.php with action="view"
    
      header("Location:".$b->createURL("employee/index", ["action"=>"view"]));
    }
    else{
      var_dump("false");die();
    }
  }
  //chỉnh sửa thông tin nhân viên
  $idUpdate=trim($b->getGET("idUpdate"));
  $name_for_update=trim($b->getPOST("name_for_update"));
  if($b->getPOST("submit")&&$idUpdate&&$name_for_update)
  {
    $updateUser=$listEmp->buildQueryParams(
      [
        "where"=>"updateEmp(:ids, :names)",
        "params"=>
        [
          ":ids"=>$idUpdate,
          ":names"=>$name_for_update
        ]
      ]
    )->update();


    if($updateUser)
    {
      if($idUpdate===$identity->getSESSION("userID"))
      {
          $_SESSION["username"]=$name_for_update;
      }
      $link_ne=$b->createURL("employee/index", ["action"=>"view"]);
    header("Location:".$link_ne);
    }
    else
    {
      echo "fail update employee "; die();
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

    <title>Employee</title>

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
                <h2>John Doe</h2>
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
                      <li><a href="<?= $b->createURL("category/index", ["action"=>"view"])?>">List Categories</a></li>
                      <li><a href="<?= $b->createURL("category/index", ["action"=>"new"])?>">Add A New Category</a></li>
                    </ul>
                  </li>
                  <li>
                  <!--add a new product ....................-->
                  <a><i class="fa fa-user"></i> Product <span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu">
                      <li><a href="<?= $b->createURL("product/index", ["action"=>"view"])?>">List Products</a></li>
                      <li><a href="<?= $b->createURL("product/index", ["action"=>"new"])?>">Add New product</a></li>
                    </ul>
                </li>
                <li>
                  <!--Thêm nhân viên mới....................-->
                  <a><i class="fa fa-user"></i> Employee <span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu">
                      <li><a href="<?= $b->createURL("employee/index", ["action"=>"view"])?>">List Employee</a></li>
                      <li><a href="<?= $b->createURL("employee/index", ["action"=>"new"])?>">Add New Eployee</a></li>
                    </ul>
                </li>
                <li><a><i class="fa fa-table"></i> Company Shipper <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="#">List Companies</a></li>
                      <li><a href="#">Add A New Company</a></li>
                    </ul>
                  </li>
                <li>
                  
                  <a href="<?= $b->createURL("customer/index", ['action'=>'view'])?>"><i class="fa fa-user"></i> Customer </a>
                  
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
                    <img src="images/img.jpg" alt=""><?php echo $identity->getSESSION("username"); ?>
                    <span class=" fa fa-angle-down"></span>
                  </a>
                  <ul class="dropdown-menu dropdown-usermenu pull-right">
                    <li><a href="javascript:;"> Profile</a></li>
                    
                    <li><a href="<?= $b->createURL("logout")?>"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
                    <li><a href="<?= $b->createURL("changePass")?>"><i class="fa fa-sign-out pull-right"></i> Change password</a></li>
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
            <div class="page-title">
              

              
            </div>

            <div class="clearfix"></div>

            <div class="row">
            
              <div class="clearfix"></div>


              <div class="clearfix"></div>
              

              <?php if($b->getGET("action")==="view")
              {

              ?>
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>List of all employee<small>Custom design</small></h2>
                    
                    <div class="clearfix"></div>
                  </div>

                  <div class="x_content">

                    

                    <div class="table-responsive">
                      <table class="table table-striped jambo_table bulk_action">
                        <thead>
                          <tr class="headings">
                            
                            <th class="column-title">ID </th>
                            <th class="column-title">Name </th>
                            <th class="column-title">Password </th>
                            
                            <th class="column-title no-link last"><center><span class="nobr">Action</span></center>
                            </th>
                            <th></th>
                            
                          </tr>
                        </thead>

                        <tbody>
                          <?php foreach ($Emp as $value) {
                            # code...
                           ?>
                           <tr>
                              
                              <td><?php echo $value["ID"] ?></td>
                              <td><?php echo $value["name"] ?></td>
                              <td><?php echo $value["pass"] ?></td>
                              <td><a href="<?= $b->createURL("employee/index", ["action"=>"update", "idUpdate"=>$value["ID"]])?>"><i class="fa fa-wrench"></i></a></td>
                              <td><a href="<?= $b->createURL("employee/delete", ["idEmp"=>$value["ID"]])?>"><i class="fa fa-close"></i></a></td>
                           </tr>
                           <?php } ?>
                        </tbody>
                      </table>
                    </div>
              
            
                  </div>
                </div>
              </div>
            <?php } 
            else if($b->getGET("action")==="new") 
                  {//sign in new employee

            ?>
              <div class="x_content">
                    <br />
                    <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" action="<?php echo $b->createURL('employee/index'); ?>" method="post">

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Your Name <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="first-name" required="required" class="form-control col-md-7 col-xs-12" name="name">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Password <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="last-name"  required="required" class="form-control col-md-7 col-xs-12" name="pass">
                        </div>
                      </div>
                      
                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                          <a href="<?= $b->createURL("employee/index", ["action"=>"view"])?>"><button class="btn btn-primary" type="button">Cancel</button></a>
              
                          <input type="submit" class="btn btn-success" value="submit" name="submit">
                        </div>
                      </div>

                    </form>
                  </div>
                <?php } else if($b->getGET("action")==="update") { 
                  $idNeUpdate=$b->getGET("idUpdate");
                  $otherEmp=$listEmp->view_employee_with_id($idNeUpdate);
                  
                  ?>

                  <div class="x_content">
                    <br />
                    <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" action="<?php echo $b->createURL('employee/index', ["idUpdate"=>$idNeUpdate]); ?>" method="post">
                      <!-- no see password -->
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Employee Name <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="first-name" required="required" class="form-control col-md-7 col-xs-12" name="name_for_update" value="<?php echo $otherEmp["name"] ?>">
                        </div>
                      </div>
                      <!-- <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Password <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="last-name"  required="required" class="form-control col-md-7 col-xs-12" name="pass_for_update" value="">
                        </div>
                      </div> -->
                      
                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                          <a href="<?= $b->createURL("employee/index", ["action"=>"view"])?>"><button class="btn btn-primary" type="button">Cancel</button></a>
              
                          <input type="submit" class="btn btn-success" value="submit" name="submit">
                        </div>
                      </div>

                    </form>
                  </div>
                <?php 


              }
                ?>

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