<?php $this->load->view('frontend/admin/nav'); ?>
<div class="container page-container">
    <div id="primary" class="content-area row">
        <aside id="aside" class="site-aside col-sm-3">
            <?php $this->load->view('frontend/admin/sidebar'); ?>
        </aside>
        <main id="main" class="site-main col-sm-9" role="main">
            <form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
                <div class="panel panel-default">
                    <div class="panel-heading">Edit member</div>
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
                                <input type="text" class="form-control required" value="<?php echo @$user['Email']; ?>" id="email" name="user_email" placeholder="Email Address" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="user_first_name" class="col-sm-3 control-label">Password <a><i class="fa fa-lock" aria-hidden="true"></i></a></label>
                            <div class="col-sm-9">
                                <input type="password" value="" class="form-control" name="password" autocomplete="false">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="user_phone" class="col-sm-3 control-label">Phone Number <i class="fa fa-lock" aria-hidden="true"></i></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" value="<?php echo @$user['Phone']; ?>" id="user_phone" name="phone" required >
                            </div>
                        </div>
                        
                        
                        <div class="form-group">
                            <label for="is_estate_license" class="col-sm-3 control-label">Real Estate Licensee?</label>
                            <div class="col-sm-9">
                                <input id="is_estate_license" onclick="$('#box-estate-license').toggle();" value="on" <?php echo ($user['Is_Estate_License'] == 1 ? "checked" : ""); ?> class="styled" type="checkbox" name="is_estate_license">
                            </div>
                        </div>
                        
                        <div class="form-group" id="box-estate-license" style="display:<?php echo ($user['Is_Estate_License'] == 1 ? "" : "none"); ?>;">
	                    	<label class="col-sm-3 control-label">License Number:</label>
	                        <div class="col-sm-9"><input type="text" class="form-control number" name="estate_license" value="<?php echo @$user['Estate_License']; ?>" placeholder="Real Estate License Number"></div>
	                    </div>
                        
                        <div class="form-group">
                            <label for="is_receive" class="col-sm-3 control-label">User Receive Text?</label>
                            <div class="col-sm-9">
                                <input id="is_receive" class="styled" type="checkbox" <?php echo ($user['Is_Receive'] == 1 ? "checked" : ""); ?> name="is_receive">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="real_estate_office" class="col-sm-3 control-label">Real Estate Office</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" value="<?php echo @$user['Real_Estate_Office']; ?>" id="real_estate_office" name="real_estate_office" >
                            </div>
                        </div>
                        	
                        <div class="form-group">
                            <label for="address" class="col-sm-3 control-label">Address Line 1</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" value="<?php echo @$user['Address']; ?>" id="address" name="address">
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
                                <input type="text" class="form-control" value="<?php echo @$user['City']; ?>" id="city" name="city">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="State" class="col-sm-3 control-label">State</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" value="<?php echo @$user['State']; ?>" id="state" name="state">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="Zipcode" class="col-sm-3 control-label">Zipcode</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" value="<?php echo @$user['Zipcode']; ?>" id="zipcode" name="zipcode">
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
                            <label for="address2" class="col-sm-3 control-label"> What best represents you:</label>
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