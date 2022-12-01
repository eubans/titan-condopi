<?php $this->load->view('frontend/profile/nav'); ?>
<div class="container page-container">
    <div id="primary" class="content-area row">
        <aside id="aside" class="site-aside col-sm-3">
            <?php $this->load->view('frontend/profile/sidebar'); ?>
        </aside>
        <main id="main" class="site-main col-sm-9" role="main">
            <form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
                <div class="panel panel-default">
                    <div class="panel-heading">Profile</div>
                    <div class="panel-body">
                        <?php 
                            if($this->session->flashdata('message')){
                                echo  $this->session->flashdata('message');
                            }
                        ?>
                        <div class="form-group">
                            <label for="user_first_name" class="col-sm-3 control-label">Membership Type</label>
                            <div class="col-sm-9">
                                <input type="text" readonly="true" class="form-control" value="<?php if($member_expiry['Expiry_Date'] > date("Y-m-d")){ echo 'Prime';}else{echo 'Basic';} ?>" />
                                <?php if($member_expiry['Expiry_Date'] > date("Y-m-d")){
                                    
                                }else{?>
                                <?php } ?>
                                
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="user_first_name" class="col-sm-3 control-label">First Name <a><i class="fa fa-lock" aria-hidden="true"></i></a></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control required" value="<?php echo @$user['First_Name']; ?>" id="user_first_name" name="first_name">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="user_last_name" class="col-sm-3 control-label">Last Name <a><i class="fa fa-lock" aria-hidden="true"></i></a></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control required" value="<?php echo @$user['Last_Name']; ?>" id="user_last_name" name="last_name">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="user_email" class="col-sm-3 control-label">Email Address <a><i class="fa fa-lock" aria-hidden="true"></i></a></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control required" value="<?php echo @$user['Email']; ?>" id="email" name="user_email" placeholder="Email Address" readonly>
                            </div>
                        </div>
                        <hr/>
                        <div class="form-group">
                            <label for="user_first_name" class="col-sm-3 control-label">Password <a><i class="fa fa-lock" aria-hidden="true"></i></a></label>
                            <div class="col-sm-9">
                                <input type="password" class="form-control" placeholder="Leave blank if you don't want to change it"  name="password">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="user_last_name" class="col-sm-3 control-label">Confirm Password <a><i class="fa fa-lock" aria-hidden="true"></i></a></label>
                            <div class="col-sm-9">
                                <input type="password" class="form-control" placeholder="Leave blank if you don't want to change it"  name="confirm_password">
                            </div>
                        </div>
                        <hr/>
                        <div class="form-group">
                            <label for="user_phone" class="col-sm-3 control-label">Phone Number <i class="fa fa-lock" aria-hidden="true"></i></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" value="<?php echo @$user['Phone']; ?>" id="user_phone" name="phone" required >
                            </div>
                        </div>
                        	
                        <div class="form-group">
                            <label for="user_phone" class="col-sm-3 control-label"></label>
                            <div class="col-sm-9">
                                <input id="estate-license" onclick="$('.group_licensed').toggle();" value="on" <?php echo ($user['Is_Estate_License'] == 1) ? 'checked' : ''; ?> type="checkbox" name="is_estate_license">
	                        	<label for="estate-license">
	                            	I am a licensed Realtor
	                        	</label>
                            </div>
                        </div>
	                    
	                    <div class="group_licensed" style="display:<?php echo ($user['Is_Estate_License'] == 1) ? '' : 'none'; ?>">
	                        <div class="form-group">
	                            <label for="user_phone" class="col-sm-3 control-label">License Number</label>
	                            <div class="col-sm-9">
	                                <input type="text" class="form-control number" value="<?php echo @$user['Estate_License']; ?>" id="estate_license" name="estate_license">
	                            </div>
	                        </div>
	                        <div class="form-group">
	                            <label for="real_estate_office" class="col-sm-3 control-label">Real Estate Office</label>
	                            <div class="col-sm-9">
	                                <input type="text" class="form-control" value="<?php echo @$user['Real_Estate_Office']; ?>" id="real_estate_office" name="real_estate_office" >
	                            </div>
	                        </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="address" class="col-sm-3 control-label">Address Line 1<a><i class="fa fa-lock" aria-hidden="true"></i></a></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control required" value="<?php echo @$user['Address']; ?>" id="address" name="address">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="address2" class="col-sm-3 control-label">Address Line 2</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" value="<?php echo @$user['Address2']; ?>" id="address" name="address2">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="City" class="col-sm-3 control-label">City</label>
                            <div class="col-sm-9">
                            	<select class="form-control" data-value="<?php echo @$product['City']; ?>" name="city" id="city">
	                            	<option value="">--------   Please choose one  --------</option>
	                            	<?php echo getListCounty(@$user['City']); ?>
	                            </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="address2" class="col-sm-3 control-label"> Location Default</label>
                            <div class="col-sm-9">
                                <select class="form-control" name="Location_Default">
                                    <option value="">--------   Please choose one  --------</option>
                                    <?php echo getListRegion(@$user['Location_Default']); ?>
                                </select>
                            </div>  
                        </div>
                        <div class="form-group">
                            <label for="address2" class="col-sm-3 control-label"> What best represents you</label>
                            <div class="col-sm-9">
                                <select class="form-control" name="Best_Represents">
                                    <option value="">--------   Please choose one  --------</option>
                                    <?php echo getBestRepresents(@$user['Best_Represents']); ?>
                                </select>
                            </div>  
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-sm-3 control-label">Profile Photo</label>
                                <div class="col-sm-9">
                                    <input type="file" id="heroimage" onchange="hero_preview_image();" name="heroimage" accept="images/*">
                                    <div class="hereimage-review">
                                        <?php if(isset($user['Avatar']) && $user['Avatar'] != null): ?>
                                            <img src="<?php echo base_url($user['Avatar']); ?>" style="height:100px;width:auto;margin-top:10px;margin-right:10px;">
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div> 
                        </div>
                        <!--/.form-group-->
                        <div class="form-group">
                        	<div class="row">
                        		<div class="col-sm-3 control-label"></div>
	                            <label class="col-sm-9 label-control"><input type="checkbox" name="Is_Send_Email" value="1" <?php if($user['Is_Send_Email']  == 1) echo "checked";?>/> Please send me emails for any new listings posted on Condo PI</label>
	                        </div>
                        </div>
                        <div class="form-group">
                        	<div class="row">
                        		<div class="col-sm-3 control-label"></div>
	                            <label class="col-sm-9 label-control"><input type="checkbox" name="Is_Send_Text" value="1" <?php if($user['Is_Send_Text']  == 1) echo "checked";?>/> Please send me text for any new listings posted on Condo PI</label>
	                        </div>
                        </div>
                        
                        <div class="form-group">
                        	<div class="row">
                        		<div class="col-sm-3 control-label"></div>
	                            <label class="col-sm-9 label-control"><input type="checkbox" name="Is_Receive" value="1" <?php if($user['Is_Receive']  == 1) echo "checked";?>/> I'd like to receive important text</label>
	                        </div>
                        </div>
                        	
                        <div class="form-group">
                            <label for="address2" class="col-sm-3 control-label"> Referral Type:</label>
                            <div class="col-sm-9">
                                <select name="Hear_About_Us" class="form-control" required>
	                                <option value="" selected="">--------   Referral Type  --------</option>
	                                <?php echo getHearAboutUs((empty($user['Hear_About_Us']) ? "Call from our team member" : $user['Hear_About_Us'])); ?>
	                            </select>
                            </div>  
                        </div>
                        
                        	
                        <div class="form-group">
                        	<div class="row">
                        		<div class="col-sm-3 "></div>
	                            <div class="col-sm-9 text-right">By clicking <span class="color-f12a53">SUBMIT</span> you agree to <a href="<?php echo base_url('page/terms-and-conditions'); ?>" target="_blank">Condo PI' terms and conditions.</a>&nbsp;&nbsp;&nbsp;</div>
	                        </div>
                        </div>
                        	
                        <div class="form-group text-right">
                            <div class="col-sm-12">
                                <button type="submit" class="btn btn-md btn-secondary">SUBMIT</button> 
                            </div>
                        </div>
                    </div>
                </div>
                
            </form>
        </main>
    </div>
</div>

<script type="text/javascript">
    function preview_image() {
        var total_file = document.getElementById("upload_file").files.length;
        $('#image_preview').html('');
        for(var i = 0; i < total_file; i++){
            $('#image_preview').append("<img style='float:left;height:100px;width:auto;margin-right:10px;margin-top:10px;' src='" + URL.createObjectURL(event.target.files[i]) + "'>");
        }
    }
    function hero_preview_image() {
        var total_file = document.getElementById("heroimage").files.length;
        for(var i = 0; i < total_file; i++){
            $('.hereimage-review').html("<img style='height:100px;width:auto;margin-right:10px;margin-top:10px;' src='" + URL.createObjectURL(event.target.files[i]) + "'>");
        }
    }
    $(document).ready(function(){
        $('.remove-item-gallery').click(function(){
            $(this).parent().remove();
            return false;
        });
    });
</script>