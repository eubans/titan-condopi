<!-- Modal -->
<div class="modal fade modal-signup-login" id="ModalSignup" tabindex="-1" role="dialog" aria-labelledby="ModalSignup">
    <div class="modal-dialog" role="document"  style="max-width:450px;">
        <form id="form-signup" action="<?php echo base_url(); ?>account/signup" method="post">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <?php 
                        if ($this->session->flashdata('message_signup') && $this->session->flashdata('message_signup_status')) :
                            echo $this->session->flashdata('message_signup');
                        else :
                    ?>
	                    <div class="group-before">
	                        <div class="row">
		                        <div class="col-sm-6">
		                            <a href="<?php echo base_url('social/facebook'); ?>" class="btn btn-block btn-lg  btn-icon btn-facebook user-signup-facebook"><span><i class="fa fa-facebook" aria-hidden="true"></i></span>Facebook</a>
		                        </div>
		                        <div class="col-sm-6">
		                            <a href="<?php echo base_url('social/google'); ?>" class="btn btn-block btn-lg  btn-icon btn-google user-signup-google"><span><img alt="google" src="<?php echo skin_url('frontend/images/ic_google.png') ?>"></span>Google</a>
		                        </div>
		                    </div>
	                    </div>
	                    <div class="label-divider"><span>or</span></div>

	                    <?php 
	                        if ($this->session->flashdata('message_signup')) {
	                            echo $this->session->flashdata('message_signup');
	                        }
	                    ?>
	                    <div class="form-group">
	                        <div class="row">
	                            <div class="col-sm-6">
	                                <input type="text" class="form-control" value="<?php echo $this->input->post('first_name')?>" name="first_name" placeholder="First name" required>
	                            </div>
	                            <div class="col-sm-6">
	                                <input type="text" class="form-control" value="<?php echo $this->input->post('last_name')?>" name="last_name" placeholder="Last name" required>
	                            </div>
	                        </div>
	                    </div>
	                    <div class="form-group">
	                        <input type="text" class="form-control" value="<?php echo $this->input->post('phone')?>" name="phone" placeholder="Cell Phone Number" required maxlength="20">
	                    </div>
	                    <div class="form-group">
	                        <input type="email" class="form-control" value="<?php echo $this->input->post('email')?>"  name="email" placeholder="Email address" required>
	                    </div>
	                    <div class="form-group">
	                        <input type="password" class="form-control" name="pwd" placeholder="Create a Password" required>
	                    </div>
	                    <!--/.row-->
	                    
	                    <div class="hide">
		                    <div class="space-05"></div>
		                    <div class="checkbox checkbox-primary">
		                        <input id="estate-license" value="on" class="styled" type="checkbox" name="is_estate_license">
		                        <label for="estate-license">
		                            I have a Real Estate License
		                        </label>
		                    </div>
		                    <div class="form-group hide" id="box-estate-license">
		                    	<label>Please enter license number (numerical values only):</label>
		                        <input type="text" class="form-control number" name="estate_license" placeholder="Real Estate License Number">
		                    </div>
		                    <div class="space-05"></div>
		                    <div class="checkbox checkbox-primary">
		                        <input id="receive-agree" class="styled" type="checkbox" checked="" name="is_receive">
		                        <label for="receive-agree">
		                            I'd like to receive important text
		                        </label>
		                    </div>
		                </div>
		                	
	                    <div class="form-group">
	                    	<label>How did you hear about us:</label>
	                        <select name="hear_about_us" class="form-control" required>
                                <option value="" selected="">--------   Referral Type  --------</option>
                                <?php echo getHearAboutUs(); ?>
                            </select>
	                    </div>
                        <div class="form-group">
                            <div class="g-recaptcha" data-callback="imNotARobot" data-sitekey="6LcurrQZAAAAACDnuZrxtL67MX0IxKj873Cz068J"></div>
                            <input type="hidden" name="recaptcha" value="" id="recaptcha-value" required>
                        </div>
	                    <div class="form-group">
	                    	<button type="submit" id="submit-signin" disabled="" class="btn btn-block btn-lg btn-secondary">Sign up</button>
	                    </div>
		                <hr>
		                <div class="row">
		                    <div class="col-sm-9">
		                        <div class="text-question">Already have an account?</div>
		                    </div>
		                    <div class="col-sm-3 text-right">
		                        <button class="btn btn-secondary-o btn-login">Log in</button>
		                    </div>
		                </div>
                    <?php endif; ?>
	        	</div>
            </div>
        </form>
    </div>
</div>

<div class="modal fade modal-signup-login" id="ModalLogin" tabindex="-1" role="dialog" aria-labelledby="ModalLogin">
    <div class="modal-dialog" role="document" style="max-width:450px;">
        <form action="<?php echo base_url() ?>account/signin" method="post">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <div class="row">
                        <div class="col-sm-6">
                            <a href="<?php echo base_url(); ?>social/facebook" class="btn btn-block btn-lg  btn-icon btn-facebook user-signup-facebook"><span><i class="fa fa-facebook" aria-hidden="true"></i></span>Facebook</a>
                        </div>
                        <div class="col-sm-6">
                            <a href="<?php echo base_url(); ?>social/google" class="btn btn-block btn-lg  btn-icon btn-google user-signup-google"><span><img src="<?php echo skin_url() ?>frontend/images/ic_google.png"></span>Google</a>
                        </div>
                    </div>
                    <div class="label-divider"><span>or</span></div>
                        <?php 
                            if($this->session->flashdata('message')){
                                echo  $this->session->flashdata('message');
                            }
                        ?>
                        <div class="form-group">
                            <input class="form-control input-lg"value="<?php echo $this->input->post('email')?>"  type="email" name="email" placeholder="Email Address">
                        </div>
                        <div class="form-group">
                            <input class="form-control input-lg" value="<?php echo $this->input->post('pwd')?>" type="password" name="pwd" placeholder="Password">
                        </div>
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="checkbox checkbox-primary">
                                    <input id="remember-me" class="styled" name="remember" value="1" type="checkbox" checked="">
                                    <label for="remember-me">
                                        Remember me
                                    </label>
                                </div>
                            </div>
                            <div class="col-xs-6 text-right">
                                <div class="space-10"></div>
                                <a href="#" class="btn-forgot">Forgot password?</a>
                            </div>
	                        <div class="form-group">
                                <input type="hidden" name="redirect" id="redirect">
		                    	<button type="submit" class="btn btn-block btn-lg btn-secondary">Login</button>
		                    </div>
	                    </div>
	                    <hr>
	                    <div class="row">
	                        <div class="col-sm-8">
	                            <div class="text-question">Don’t have an account?</div>
	                        </div>
	                        <div class="col-sm-4 text-right">
	                            <button class="btn btn-secondary-o btn-sign-up">Sign Up</button>
	                        </div>
	                    </div>
	            	</div>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal fade modal-forgot" id="ModalForgot" tabindex="-1" role="dialog" aria-labelledby="ModalLogin">
    <div class="modal-dialog" role="document" style="max-width:450px;">
        <form action="<?php echo base_url() ?>account/forgot" method="post">
            <div class="modal-content">
                <div class="modal-body">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <div class="alert alert-success" style="display:none;"></div>
                        <div class="alert alert-danger" style="display:none;"></div>
                        <div class="form-group">
                            <h3>Forgot Password</h3>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Your Email:</label>
                            <input class="form-control input-lg" type="email" name="email" required placeholder="Please enter your email">
                        </div>
                        <div class="form-group">
	                    	<button type="submit" class="btn btn-block btn-secondary">Send Mail</button>
	                    </div>
	            	</div>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="modal fade modal-reset" id="ModalReset" tabindex="-1" role="dialog" aria-labelledby="ModalLogin">
    <div class="modal-dialog" role="document" style="max-width:450px;">
        <form action="<?php echo base_url() ?>account/reset" method="post">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <div class="alert alert-success" style="display:none;"></div>
                        <div class="alert alert-danger" style="display:none;"></div>
                        <div class="form-group">
                            <h3>Reset Password</h3>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Password:</label>
                            <input type="password" class="form-control input-lg" name="password" required placeholder="Please enter your password">
                        </div>
                        <div class="form-group">
                            <label class="control-label">Confirm Password:</label>
                            <input type="password" class="form-control input-lg" name="confirm_password" required placeholder="Please enter your confirm password">
                        </div>
                        <div class="form-group">
                            <input type="hidden" name="email" value="<?php echo @$_GET['email']; ?>">
                            <input type="hidden" name="token" value="<?php echo @$_GET['token']; ?>">
                            <button type="submit" class="btn btn-block btn-secondary">Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        <?php if(isset($_GET['login']) && $_GET['login'] == 'true'): ?>
            $("#ModalLogin").modal('show');
        <?php endif; ?>

        <?php if(isset($_GET['signup']) && $_GET['signup'] == 'true'): ?>
            $("#ModalSignup").modal('show');
        <?php endif; ?>

        <?php if(isset($_GET['reset']) && $_GET['reset'] == 'reset' && isset($_GET['email']) && $_GET['email'] != null && isset($_GET['token']) && $_GET['token'] != null): ?>
            $("#ModalReset").modal('show');
        <?php endif; ?>

        $("#ModalLogin .btn-sign-up").click(function(){
        	$("#ModalLogin").modal('toggle');
        	setTimeout(function(){
        		$("#ModalSignup").modal('show');
        	},500);
        	return false;
        });

        $("#ModalLogin .btn-forgot").click(function(){
        	$("#ModalLogin").modal('toggle');
        	setTimeout(function(){
        		$("#ModalForgot").modal('show');
        	},500);
        	return false;
        });

        $("#ModalSignup .btn-login").click(function(){
        	$("#ModalSignup").modal('toggle');
        	setTimeout(function(){
        		$("#ModalLogin").modal('show');
        	},500);
        	return false;
        });
        
        $("input[name=is_estate_license]").click(function () {
        	if ($(this).is(':checkbox')) {
        		$('#box-estate-license').removeClass('hide');
        		$("input[name=estate_license]").addClass('required');
        	} else {
        		$('#box-estate-license').addClass('hide');
        		$("input[name=estate_license]").val('');
        		$("input[name=estate_license]").removeClass('required');
        	}
        });
        
        $("#ModalForgot form").submit(function(){
        	var form = $(this);
            var data = $(this).serialize();
            $(".custom-loading").show();
            form.find(".alert").hide();
            $.ajax({
                "url": form.attr("action"),
                "type":"post",
                "dataType":"json",
                "data":data,
                success:function(data){
                    console.log(data);
                    if(data["status"] == "success"){
                        form.find(".alert-success").html("Sent mail successfully.").show();
                    }
                    else if(data["status"] == "fail"){
                        form.find(".alert-danger").html(data["message"]).show();
                    }
                },
                error: function(data){
                    console.log(data['responseText']);
                },
                complete: function(){
                    $(".custom-loading").hide();
                }
            });
        	return false;
        });

        $("#ModalReset form").submit(function(){
            var form = $(this);
            var data = $(this).serialize();
            $(".custom-loading").show();
            form.find(".alert").hide();
            $.ajax({
                "url": form.attr("action"),
                "type":"post",
                "dataType":"json",
                "data":data,
                success:function(data){
                    console.log(data);
                    if(data["status"] == "success"){
                        form.find(".alert-success").html("Save successfully. Please login.").show();
                        setTimeout(function(){
                           location.href = "<?php echo base_url(); ?>?login=true";
                        },500);
                    }
                    else if(data["status"] == "fail"){
                        form.find(".alert-danger").html(data["message"]).show();
                    }
                },
                error: function(data){
                    console.log(data['responseText']);
                },
                complete: function(){
                    $(".custom-loading").hide();
                }
            });
            return false;
        });
    }); 
</script>