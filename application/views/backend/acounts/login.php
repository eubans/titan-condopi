<!DOCTYPE html>

<html lang="en">



<head>

  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

  <!-- Meta, title, CSS, favicons, etc. -->

  <meta charset="utf-8">

  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <meta name="viewport" content="width=device-width, initial-scale=1">

  <meta name="google-signin-client_id" content="34899387470-psp04agnf18jf0gsdn3dd8r9goircija.apps.googleusercontent.com">

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

  <link href="<?php echo skin_url('backend/css/login.css');?>" rel="stylesheet">

  <script src="<?php echo skin_url('backend/vendors/jquery/dist/jquery.min.js');?>"></script>
</head>
<body class="login" style="background: #fff;">
  <div>
    <a class="hiddenanchor" id="signin"></a>
    <a class="hiddenanchor" id="forgot"></a>
    <div class="login_wrapper">
      <div class="animate form login_form">
        <section class="login_content">
          <form method="post" action="<?php echo backend_url("acounts/login")?>">

            <h2 class="title-form">Login dashboard</h2>

            <?php ($this->input->get("messenger") == "reset_success") ? $messenger[] = "Password successfully updated. Please sign in" : $abc = null ;?>

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

            <div class="row">
              <div class="col-md-12">
                <div> <input type="text" name="email" class="form-control" placeholder="Email login" required="" /> </div>
                <div> <input type="password" name="password" class="form-control" placeholder="Login password" required="" /> </div>
                <div> <button type="submit" class="btn btn-default submit" href="index.html">Login</button> <a href="#forgot" class="to_register"> Forgot password </a> </div>
                <div class="clearfix"></div>
                 <div class="separator">                  
                  <div class="clearfix"></div>
                </div>
              </div>
            </div>
          </form>
        </section>
      </div>
      <div id="lost_password" class="animate form forgot_form">

        <section class="login_content">

          <form method="post" action="<?php echo backend_url("acounts/lost_password");?>">

            <h2 class="title-form">Forgot password</h2>

            <div class="row">

              <div class="col-md-12">

                <div>

                  <input name="email" type="email" class="form-control" placeholder="Please enter your login email" required="" />

                </div>
                <div>
                  <button type="submit" class="btn btn-default submit">Send require</button> 
                </div>
                <div class="clearfix"></div>
                <div class="separator">                  
                  <div class="clearfix"></div>
                </div>
                <p class="change_link">Already a member or not ?
                    <a href="#signin" class="to_register"> Login </a>
                  </p>
              </div>
            </div>

          </form>

        </section>
      </div>
    </div>
  </div>
  <style type="text/css">

    .messenger ul {

      padding-left: 15px;

      text-align: left;

    }

    .messenger ul li {

      display: list-item;

    }

    body .login {

        background: #ffffff;

    }
    body .login_wrapper{max-width: 420px}
  </style>

</body>

</html>