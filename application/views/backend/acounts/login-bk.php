<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Gentelella Alela! | </title>

    <!-- Bootstrap -->
    <link href="<?php echo skin_url('backend/vendors/bootstrap/dist/css/bootstrap.min.css');?>" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="<?php echo skin_url('backend/vendors/font-awesome/css/font-awesome.min.css');?>" rel="stylesheet">
    <!-- NProgress -->
    <link href="<?php echo skin_url('backend/vendors/nprogress/nprogress.css');?>" rel="stylesheet">
    <!-- Animate.css -->
    <link href="<?php echo skin_url('backend/vendors/animate.css/animate.min.css');?>" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="<?php echo skin_url('backend/build/css/custom.min.css');?>" rel="stylesheet">
  </head>

  <body class="login">
    <div>
      <a class="hiddenanchor" id="signup"></a>
      <a class="hiddenanchor" id="signin"></a>
      <div class="login_wrapper">
        <div class="animate form login_form">
          <section class="login_content">
            <form method="post" action="<?php echo backend_url("acounts/login")?>">
              <h1>Login Form</h1>
              <?php ($this->input->get("messenger") == "reset_success") ? $messenger[] = "Password updated successfully. Please log in" : $abc = null ;?>
              <?php 
                if(isset($messenger)){
                  echo '<div class="messenger">';
                  echo '<ul>';
                  foreach ($messenger as $key => $value) {
                    echo '<li><p>'. $value.'</p></li>';
                  }
                  echo '</ul>';
                  echo '</div>';
                }
              ?>
              <div>
                <input type="text" name="email" class="form-control" placeholder="Email" required="" />
              </div>
              <div>
                <input type="password" name="password" class="form-control" placeholder="Password" required="" />
              </div>
              <div>
                <button type="submit" class="btn btn-default submit" href="index.html">Log in</button> 
                <a href="#signup" class="to_register"> Lost your password? </a> 
              </div>
              <div class="clearfix"></div>
              <div class="separator">
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
        <div id="register" class="animate form registration_form">
          <section class="login_content">
            <form method="post" action="<?php echo backend_url("acounts/lost_password");?>">
              <h1>Lost your password</h1>
              <div>
                <input name="email" type="email" class="form-control" placeholder="Email" required="" />
              </div>
              <div>
                <button type="submit" class="btn btn-default submit">Forgot</button> 
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
    <style type="text/css">
      .messenger ul{padding-left: 15px; text-align: left;}
      .messenger ul li{display: list-item;}
    </style>
  </body>
</html>
