<?php $this->load->view('frontend/admin/nav'); ?>
<div class="container page-container">
    <div id="primary" class="content-area row">
        <aside id="aside" class="site-aside col-sm-3">
            <?php $this->load->view('frontend/admin/sidebar'); ?>
        </aside>
        <main id="main" class="site-main col-sm-9" role="main">
            <form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
                <div class="panel panel-default">
                    <div class="panel-heading">New Profile</div>
                    <div class="panel-body">
                        <?php 
                            if($this->session->flashdata('message')){
                                echo  $this->session->flashdata('message');
                            }
                        ?>
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
                                <input type="text" class="form-control required" value="<?php echo @$user['Email']; ?>" id="email" name="email" placeholder="Email Address">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="user_first_name" class="col-sm-3 control-label">Password <a><i class="fa fa-lock" aria-hidden="true"></i></a></label>
                            <div class="col-sm-9">
                                <input type="text" value="condopi" class="form-control" name="pwd" autocomplete="false">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="user_phone" class="col-sm-3 control-label">Phone Number <i class="fa fa-lock" aria-hidden="true"></i></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" value="<?php echo @$user['Phone']; ?>" id="phone" name="phone" required >
                            </div>
                        </div>
                        	
                        <div class="form-group">
                            <label for="is_estate_license" class="col-sm-3 control-label">Real Estate Licensee?</label>
                            <div class="col-sm-9">
                                <input id="is_estate_license" onclick="$('#box-estate-license').toggle();" value="on" class="styled" type="checkbox" name="is_estate_license">
                            </div>
                        </div>
                        
                        <div class="form-group" id="box-estate-license" style="display:none;">
	                    	<label class="col-sm-3 control-label">License Number:</label>
	                        <div class="col-sm-9"><input type="text" class="form-control number" name="estate_license" placeholder="Real Estate License Number"></div>
	                    </div>
                        
                        <div class="form-group">
                            <label for="is_receive" class="col-sm-3 control-label">User Receive Text?</label>
                            <div class="col-sm-9">
                                <input id="is_receive" class="styled" type="checkbox" name="is_receive">
                            </div>
                        </div>
                        	
                        <div class="form-group">
                            <label for="user_phone" class="col-sm-3 control-label">How did you hear about us</label>
                            <div class="col-sm-9">
                                <select name="hear_about_us" class="form-control" required>
	                                <option value="" selected="">--------   Referral Type  --------</option>
	                                <?php echo getHearAboutUs("Call from our team member"); ?>
	                            </select>
                            </div>
                        </div>
                        	
                        <div class="item form-group"> 
							<label class="col-sm-3 control-label">Status</label>
							<div class="col-sm-9">
								<select id="Status" class="form-control col-md-7 col-xs-12" name="Status" required="">
							    	<?php
                                            $status = [
                                                '1' => 'Actived',
                                                '0' => 'Wait Activating OR Inactive'
                                            ];
                                        ?>
                                        <?php foreach ($status as $key => $value) {
                                            if(trim($user['Status']) == trim($key))
                                                echo '<option value="'.$key.'" selected>'.$value.'</option>';
                                            else
                                                echo '<option value="'.$key.'">'.$value.'</option>' ;
                                        }?>
								</select>
							</div>
						</div>
                        <div class="form-group text-right">
                            <div class="col-sm-12">
                                <button type="submit" class="btn btn-md btn-secondary">Save</button> 
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