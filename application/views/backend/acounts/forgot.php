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

  <body class="login" style="background-color: #ffffff;">
    <div>
      <a class="hiddenanchor" id="signup"></a>
      <a class="hiddenanchor" id="signin"></a>
      <div class="login_wrapper">
        <div class="animate form login_form">
          <section class="login_content">
            <form method="post" action="<?php echo backend_url('acounts/reset_password');?>">
              <h2 class="title-form">Đặt lại mật khẩu</h2>
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
                <input type="hidden" value="<?php echo @$this->input->get('token');?><?php echo @$this->input->post('token');?>" name="token"/>
                <input type="email" value="<?php echo @$this->input->get('email');?><?php echo @$this->input->post('email');?>" name="email" class="form-control" placeholder="Email" required="" readonly/>
              </div>
              <div>
                <input type="password" value="<?php echo @$this->input->post('password');?>" name="password" class="form-control" placeholder="Mật khẩu mới" required="" />
              </div>
              <div>
                <input type="password" name="password_confirm" class="form-control" placeholder="Xác nhận mật khẩu mới" required="" />
              </div>
              <div>
                <button type="submit" class="btn btn-default submit" href="index.html">Cập nhật mật khẩu</button> 
              </div>
              <div class="clearfix"></div>
              <div class="separator">
                <div class="clearfix"></div>
                <br />
              </div>
            </form>
          </section>
        </div>
      </div>
    </div>
    <style type="text/css">
      .messenger ul{padding-left: 15px; text-align: left;}
      .messenger ul li{display: list-item;}
      .title-form{font-size: 35px; margin-bottom: 50px; text-transform: uppercase;}
      .left-form {border-right: 1px solid #ccc; padding-right: 50px;}
    </style>
  </body>
</html>
