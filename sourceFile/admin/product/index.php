<?php

  $b=new apps_libs_routers();
  $identity=new apps_libs_userIdentity();

  //kiểm tra đăng nhập
  if($identity->isLogin()===false)
  {
    $b->loginPage();
  }

//lấy danh sách các thể loại

 $listCate=new apps_models_category();
  $Cate=$listCate->buildQueryParams(
    [
      "select"=>"*"

    ]
  )->select();

//end lấy danh sách các thể loại


  //thêm sản phẩm mới

  $name=trim($b->getPOST("productName"));
  $cateID=trim($b->getPOST("cateID"));
  $unitNames=trim($b->getPOST("unitNames"));
  $unitScales=trim($b->getPOST("unitScales"));
  $discontinueds=trim($b->getPOST("discontinueds"));
  $discontinuedPrices=trim($b->getPOST("discontinuedPrices"));
  $prices=trim($b->getPOST("prices"));
  $empIds=$identity->getSESSION("userID");
  $product=new apps_models_product();
  
  // if($b->getPOST("submit"))
  // {
  //   var_dump($name." - ".$cateID." - ".$unitNames." - ".$unitScales." - ".$discontinuedPrices." - ".$name." - ".$empIds." - ".$prices." - ".$_FILES["choose_image"]["name"]." - ".$discontinueds);die();
  // }
  if($b->getPOST("submit")&&$name&&$cateID&&$unitNames&&$unitScales&&$prices&&$empIds&&isset($_FILES["choose_image"]) && $_FILES["choose_image"]["error"] == 0)
  {
      $allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "gif" => "image/gif", "png" => "image/png");
      $filename = $_FILES["choose_image"]["name"];
      $filetype = $_FILES["choose_image"]["type"];
      $filesize = $_FILES["choose_image"]["size"];

      // Verify file extension
      $ext = pathinfo($filename, PATHINFO_EXTENSION);
      if(!array_key_exists($ext, $allowed)) 
        die("Error: Please select a valid file format.");
      // Verify MYME type of the file
        if(in_array($filetype, $allowed))
        {
          if(file_exists("image_product/" . $_FILES["choose_image"]["name"]))
          {
                echo $_FILES["choose_image"]["name"] . " is already exists.";
            } 
            else
            {
              $result=null;
              if($discontinuedPrices&&$discontinueds)
              {
                
                $result=$product->add_new_product($name, $cateID, $unitNames, $unitScales, 1, $discontinuedPrices, $empIds, $prices, $_FILES["choose_image"]["name"]);
              }
              
              else
              {
                
                $result=$product->add_new_product($name, $cateID, $unitNames, $unitScales, 0, 0, $empIds, $prices, $_FILES["choose_image"]["name"]);
              }
              
              if($result!==false)
              {
               $save="/orderOnline/includeFile/image_product";
               $namee=basename($_FILES["choose_image"]["name"][$key]);
                  if(move_uploaded_file($_FILES["choose_image"]["tmp_name"][$key],"$save/$namee"))
                  {
                    $link_ne=$b->createURL("product/index", ["action"=>"view"]);
                  header("Location:".$link_ne);
                  }
                  else
                  {
                    var_dump("$save/$namee"." - ".move_uploaded_file($_FILES["choose_image"]["tmp_name"][$key],"$save/$namee"));die();
                  }
                  
              }
              else
              {
                var_dump("error");die();
                
              }
            }
        }
        else
        {
          var_dump("Error: There was a problem uploading your file. Please try again."); die();
        }
    //end thêm sản phẩm mới
  }
//view a product

  $view_product=$product->view_product();

//update product
  $productID_update=$b->getPOST("productID_update");
  $productName_update=$b->getPOST("productName_update");
  $cateID_update=$b->getPOST("cateID_update");
  $unitNames_update=$b->getPOST("unitNames_update");
  $unitScales_update=$b->getPOST("unitScales_update");
  $prices_update=$b->getPOST("prices_update");
  $discontinueds_update=$b->getPOST("discontinueds_update");
  $discontinuedPrice_update=$b->getPOST("discontinuedPrice_update");

  if($b->getPOST("submit_update")&&$productID_update &&$productName_update&&$cateID_update&&$unitNames_update&&$unitScales_update&&$prices_update&&$discontinueds_update&&$discontinuedPrice_update)
  {
    
    $result_update=$product->buildQueryParams(
      [
        "where"=>"update_product(:ids ,:name, :cateID, :unitNames, :unitScales, :discontinueds,:discontinuedPrices,:prices, :image)",
        "params"=>
        [
          ":ids"=>$productID_update,
          ":name"=>$productName_update,
          ":cateID"=>$cateID_update,
          ":unitNames"=>$unitNames_update,
          ":unitScales"=>$unitScales_update,
          ":discontinueds"=>1,
          ":discontinuedPrices"=>$discontinuedPrice_update,
          ":prices"=>$prices_update
        ]
      ]
    )->update();
    if($result_add!==false)
      {
        $link_ne=$b->createURL("product/index", ["action"=>"view"]);
        header("Location:".$link_ne);
      }
      else{
        var_dump("fail!!!");die();
      }
  }
  else
    if($b->getPOST("submit_update")&&$productID_update &&$productName_update&&$cateID_update&&$unitNames_update&&$unitScales_update&&$prices_update)
    {
     
      $result_update=$product->buildQueryParams(
      [
        "where"=>"update_product(:ids ,:name, :cateID, :unitNames, :unitScales, :discontinueds,:discontinuedPrices,:prices)",
        "params"=>
        [
          ":ids"=>$productID_update,
          ":name"=>$productName_update,
          ":cateID"=>$cateID_update,
          ":unitNames"=>$unitNames_update,
          ":unitScales"=>$unitScales_update,
          ":discontinueds"=>0,
          ":discontinuedPrices"=>0,
          ":prices"=>$prices_update
        ]
      ]
    )->update();
    if($result_add!==false)
      {
        $link_ne=$b->createURL("product/index", ["action"=>"view"]);
        header("Location:".$link_ne);
      }
      else{
        var_dump("fail!!!");die();
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

    <title>Product</title>

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

    <!-- bootstrap -->
    
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
                      <li><a href="<?= $b->createURL("employee/index", ["action"=>"new"])?>">Add New Employee</a></li>
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
                    <h2>List of all product<small>Custom design</small></h2>
                    
                    <div class="clearfix"></div>
                  </div>

                  <div class="x_content">

                    

                    <div class="table-responsive">
                      <table class="table table-striped jambo_table bulk_action">
                        <thead>
                          <tr class="headings">
                            
                            <th class="column-title">ID </th>
                            <th class="column-title">Name </th>
                            <th class="column-title">Unit Name </th>
                            <th class="column-title">Price </th>
                            <th class="column-title">Unit Scale </th>
                            
                            <!-- nếu có giảm giá thì hiện giá sản phẩm sau khi giảm, nếu không giảm thì để cột giá giảm trống -->
                            <th class="column-title">Discontinued </th>
                            <th class="column-title">DiscontinuedPrice </th>
                            <th class="column-title">Created by </th>
                            <th class="column-title">Date Created </th>
                            <th class="column-title">Category </th>
                            <th class="column-title no-link last"><center><span class="nobr">Action</span></center>
                            </th>
                            <th></th>
                            
                          </tr>
                        </thead>

                        <tbody>
                          <?php foreach ($view_product as $value_product) {
                            # code...
                           ?>
                           <tr>
                              
                              <td><?php echo $value_product["productID"] ?></td>
                              <td><?php echo $value_product["productName"] ?></td>
                              <td><?php echo $value_product["unitName"] ?></td>
                              <td><?php echo $value_product["price"] ?></td>
                              <td><?php echo $value_product["unitScale"] ?></td>
                              <td><?php echo $value_product["discontinued"] ?></td>
                              <td><?php echo $value_product["discontinuedPrice"] ?></td>
                              <td><?php echo $value_product["name"] ?></td>
                              <td><?php echo $value_product["dateCreate"] ?></td>
                              <td><?php echo $value_product["categoryName"] ?></td>
                              <td><a href="<?= $b->createURL("product/index", ["action"=>"update", "idUpdate"=>$value_product["productID"]])?>"><i class="fa fa-wrench"></i></a></td>
                              <td><a href="<?= $b->createURL("product/delete", ["idProduct"=>$value_product["productID"]])?>"><i class="fa fa-close"></i></a></td>
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
                  {//add new product

            ?>
              <div class="x_content">
                    <br />
                    <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" action="<?php echo $b->createURL('product/index'); ?>" method="post" enctype="multipart/form-data">

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Product Name <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="first-name" required="required" class="form-control col-md-7 col-xs-12" name="productName">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Category</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <select class="select2_single form-control" tabindex="-1" name="cateID">
                            
                            <?php foreach ($Cate as $value) {
                             ?>
                             <option value="<?php echo $value["categoryID"] ?>"><?php echo $value["categoryName"] ?></option>
                             <?php
                            } ?>
                            
                          </select>
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Unit Name</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <select class="select2_single form-control" tabindex="-1" name="unitNames">
                            <option></option>
                            <option value="Cuốn">Cuốn</option>
                            <option value="Bộ">Bộ</option>
                            
                          </select>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Unit Scale <span class="required">*</span>
                        </label>
                        <div class="col-md-2 col-sm-2 col-xs-12">
                          <input type="number" id="first-name" required="required" class="form-control col-md-7 col-xs-12" name="unitScales">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Price <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="number" id="price"  required="required" class="form-control col-md-7 col-xs-12" name="prices">
                        </div>
                        </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Sale? <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="checkbox" id="myCheck"  onclick="myFunction()" name="discontinueds">
                          
                        </div>
                        </div>

                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" style="display:none" for="last-name" id="last-name1">Price Sale <span class="required">*</span>
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            
                            <input type="number" id="last-name"   class="form-control col-md-7 col-xs-12" name="discontinuedPrices" style="display:none">
                            
                          </div>
                        </div>
                        <script>
                            function myFunction() {
                                var checkBox = document.getElementById("myCheck");
                                var text1 = document.getElementById("last-name1");
                                var text = document.getElementById("last-name");
                                if (checkBox.checked == true){
                                  text1.style.display = "block";
                                    text.style.display = "block";
                                    
                                } else {
                                  text1.style.display = "none";
                                   text.style.display = "none";
                                   
                                }
                            }
                          </script>


                      <div class="form-group">
                        <input type="file" name="choose_image" value="choose_image" onchange="readURL(this);" class="btn btn-success col-md-3 col-sm-3 col-xs-12" id='choose_image'>
                          <div class="col-md-3 col-sm-3 col-xs-12">
                            <div class="profile_img">
                              <div id="crop-avatar">
                                
                                <img id="blah" src="#" class="img-responsive avatar-view"  alt="Avatar" title="Change the avatar">
                              </div>
                            </div><br>
                        </div>
                        
                      </div>

                      <script>
                          function readURL(input) {
                          if (input.files && input.files[0]) 
                          {
                              var extension_ss = ["jpg", "jpeg", "gif", "png"];


                              if(extension_ss.includes(input.value.split('.')[1]))
                              {
                                  var reader = new FileReader();

                                  reader.onload = function (e) {
                                      $('#blah')
                                          .attr('src', e.target.result)
                                          .width(150)
                                          .height(200);
                                  };

                                  reader.readAsDataURL(input.files[0]);

                              }
                              else
                              {
                                  alert("invalid file format");
                                  document.getElementById("choose_image").value = "";
                              }
                          }
    }


                      </script>
                      
                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                          <a href="<?= $b->createURL("product/index", ["action"=>"view"])?>"><button class="btn btn-primary" type="button">Cancel</button></a>
              
                          <input type="submit" class="btn btn-success" value="submit" name="submit">
                        </div>
                      </div>

                    </form>
                  </div>
                <?php } else if($b->getGET("action")==="update") { 
                  $idNeUpdate=$b->getGET("idUpdate");
                  $other_product=$product->view_product_with_id($idNeUpdate);
                  
                  ?>

                  <div class="x_content">
                    <br />
                    <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" action="<?php echo $b->createURL('product/index'); ?>" method="post">
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Product ID <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="first-name" required="required" class="form-control col-md-7 col-xs-12" name="productID_update" value="<?php echo $other_product[0]["productID"] ?>">
                        </div>
                      </div>
      
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Product Name <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="first-name" required="required" class="form-control col-md-7 col-xs-12" name="productName_update" value="<?php echo $other_product[0]["productName"] ?>">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Category</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <select class="select2_single form-control" tabindex="-1" name="cateID_update">
                            
                            <?php foreach ($Cate as $value) {
                             ?>
                             <option value="<?php echo $value["categoryID"] ?>" <?php $other_product[0]["categoryName"]===$value["categoryName"]?"selected":"" ?>><?php echo $value["categoryName"] ?></option>
                             <?php
                            } ?>
                            
                          </select>
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Unit Name</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <select class="select2_single form-control" tabindex="-1" name="unitNames_update">
                            <?php if($other_product["unitName"]==="Cuốn") {?>
                            <option value="Cuốn" selected="">Cuốn</option>
                            <option value="Bộ">Bộ</option>
                          <?php } 
                          else
                            {?>
                              <option value="Cuốn">Cuốn</option>
                            <option value="Bộ" selected="">Bộ</option><?php } ?>
                            
                          </select>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Unit Scale <span class="required">*</span>
                        </label>
                        <div class="col-md-2 col-sm-2 col-xs-12">
                          <input type="number" id="first-name" required="required" class="form-control col-md-7 col-xs-12" name="unitScales_update" value="<?php echo $other_product[0]["unitScale"] ?>">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Price <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="number" id="price"  required="required" class="form-control col-md-7 col-xs-12" name="prices_update" value="<?php echo $other_product[0]["price"] ?>">
                        </div>
                        </div>
                        <?php if($other_product[0]["discontinued"]==="1") {?>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Sale? <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="checkbox" id="myCheck" checked onclick="myFunction()" name="discontinueds_update">
                          
                        </div>
                        </div>

                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12"  for="last-name" id="last-name1">Price Sale <span class="required">*</span>
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            
                            <input type="number" id="last-name"   class="form-control col-md-7 col-xs-12" name="discontinuedPrice_update" value="<?php echo $other_product[0]["discontinuedPrice"] ?>">
                            
                          </div>
                        </div>
                        <?php }
                        else {
                          ?>
                        <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Sale? <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="checkbox" id="myCheck" onclick="myFunction()" name="discontinueds_update">
                          
                        </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" style="display:none" for="last-name" id="last-name1">Price Sale <span class="required">*</span>
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            
                            <input type="number" id="last-name"   class="form-control col-md-7 col-xs-12" name="discontinuedPrice_update" style="display:none">
                            
                          </div>
                        </div>  
<?php } ?>
                        
                        <script>
                            function myFunction() {
                                var checkBox = document.getElementById("myCheck");
                                var text1 = document.getElementById("last-name1");
                                var text = document.getElementById("last-name");
                                if (checkBox.checked == true){
                                  text1.style.display = "block";
                                    text.style.display = "block";
                                    
                                } else {
                                  text1.style.display = "none";
                                   text.style.display = "none";
                                   
                                }
                            }
                          </script>

                      
                      
                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                          <a href="<?= $b->createURL("product/index", ["action"=>"view"])?>"><button class="btn btn-primary" type="button">Cancel</button></a>
              
                          <input type="submit" class="btn btn-success" value="submit" name="submit_update">
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