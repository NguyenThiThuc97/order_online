<?php
//nhân viên đăng nhập vào trang
//nhân viên đăng kí tạo tài khoản
//nhân viên up sản phẩm
	$abc=new apps_libs_routers();
	$identity=new apps_libs_userIdentity();

	$username=trim($abc->getPOST("username"));
	$password=trim($abc->getPOST("password"));
	$userType=trim($abc->getPOST("userType"));

	$cusName=trim($abc->getPOST("cusName"));
	$phone=trim($abc->getPOST("phone"));
	$pass=trim($abc->getPOST("pass"));
  $address=trim($abc->getPOST("address"));

// $lamthu=new apps_models_employee();
// $ketqua=$lamthu->addNewEmp("nguyen van a", md5('123')); echo "them thanh cong";die();



	if($identity->isLogin())
	{
		$abc->homePage();
	}
//đăng nhập (employee)
	if($abc->getPOST("submit") && $username && $password && $userType==="userEmp")
	{
		$identity->username=$username;
		$identity->password=$password;
		if($identity->loginEmp())
		{

				header("Location:?r=home");
			
		}
		else
			echo "username or password is incorrect!!!";
			

	} //đăng nhập (customer)
   else if($abc->getPOST("submit") && $username && $password && $userType==="userCus")
  {
    $identity->username=$username;
    $identity->password=$password;
    if($identity->loginCus($username, $password))
    {

        header("Location:?r=../public/home");
      
    }
    else
      echo "(cus)username or password is incorrect!!!";
      

  }
  /*
  nhân viên đăng nhập thì có 1 session,
  khách hàng đăng nhập có 1 session,
  khách hàng đăng kí thì tự tạo 1 session và hướng thẳng tới trang home
  */
	//đăng kí (customer)
	if($abc->getPOST("submit") && $cusName && $phone && $pass && $address)
	{
		  if($identity->registerAccount($cusName, $phone, $address, $pass))
      {
                 $abc->loginPage();
      }
      else
      {

        echo "Đăng kí tài khoản thất bại, vui lòng nhập lại thông tin"; 
        
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

    <title>Login</title>

    <!-- Bootstrap -->
    <link href="../../includeFile/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="../../includeFile/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="../../includeFile/vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- Animate.css -->
    <link href="../../includeFile/vendors/animate.css/animate.min.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="../../includeFile/build/css/custom.min.css" rel="stylesheet">
  </head>

  <body class="login">
    <div>
      <a class="hiddenanchor" id="signup"></a>
      <a class="hiddenanchor" id="signin"></a>

      <div class="login_wrapper">
        <div class="animate form login_form">
          <section class="login_content">
            <form method="post" action="<?php echo $abc->createURL('login'); ?>" >


              <h1>Login Form</h1>
              Employee&nbsp;<input type="radio" name="userType" value="userEmp"> &nbsp;&nbsp;&nbsp;
              Customer&nbsp;<input type="radio" name="userType" value="userCus">
              <div>
                <input type="text" class="form-control" placeholder="Username" required="" name="username"/>
              </div>
              <div>
                <input type="password" class="form-control" placeholder="Password" required="" type="password" name="password"/>
              </div>
              <div>
<center>
                <input type="submit" name="submit" value="Log In" class="btn btn-default submit"></center>
                <a class="reset_pass" href="#">Lost your password?</a>
              </div>

              <div class="clearfix"></div>

              <div class="separator">
                <p class="change_link">New to site?
                  <a href="#signup" class="to_register"> Create Account (for Customer)</a>
                </p>

                <div class="clearfix"></div>
                <br />

                <!-- <div>
                  <h1><i class="fa fa-paw"></i> Gentelella Alela!</h1>
                  <p>©2016 All Rights Reserved. Gentelella Alela! is a Bootstrap 3 template. Privacy and Terms</p>
                </div> -->
              </div>
            </form>
          </section>
        </div>
<!--register-->
        <div id="register" class="animate form registration_form">
          <section class="login_content">
            <form method="post" action="<?php echo $abc->createURL('login'); ?>">
              <h1>Create Account (for Customer)</h1>
              <div>
                <input type="text" class="form-control" placeholder="Full Name" required="" name="cusName"/>
              </div>
              <div>
                <input type="text" class="form-control" placeholder="Your Phone Number" required="" name="phone"/>
              </div>
              <div>
                <input type="text" class="form-control" placeholder="Address" required="" name="address"/>
              </div>
              <div>
                <input type="text" class="form-control" placeholder="Password" required="" name="pass"/>
              </div>
              <div>

              	<input type="submit" class="btn btn-default submit" name="submit" value="Register">
               
              </div>

              <div class="clearfix"></div>
              
              <div class="separator">
                <p class="change_link">Already a member ?
                  <a href="#signin" class="to_register"> Log in </a>
                </p>

                <div class="clearfix"></div>
                <br />

                <div>
                  <h1><i class="fa fa-paw"></i> Gentelella Alela!</h1>
                  <p>©2016 All Rights Reserved. Gentelella Alela! is a Bootstrap 3 template. Privacy and Terms</p>
                </div>
              </div>
            </form>
          </section>
        </div>
      </div>
    </div>
  </body>
</html>
