<div class="main-page <?php echo @$main_page;?>">
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">
			<div class="x_title">
				<h2>Update your profile</h2>
				<ul class="nav navbar-right panel_toolbox">
					<li style="float: right;"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
				</ul>
				<div class="clearfix"></div>
			</div>
			<div class="x_content">
			    <?php if(@$this->input->get("create") == "success"):?>
				    <div class="alert alert-success fade in alert-dismissable" style="margin-top:18px;">
					    <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
					    <strong>Add new successful!</strong> You can update the data here
					</div>
				<?php endif;?>
				<?php if(@$this->input->get("edit") == "success"):?>
				    <div class="alert alert-success fade in alert-dismissable" style="margin-top:18px;">
					    <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
					    <strong>Update successful!</strong> You can update the data here
					</div>
				<?php endif;?>
				<?php if(@$this->input->get("delete") == "success"):?>
				    <div class="alert alert-success fade in alert-dismissable" style="margin-top:18px;">
					    <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
					    <strong>Delete successful!</strong>
					</div>
				<?php endif;?>
				<?php if(@$post["status"] == "error"):?>
				    <div class="alert alert-danger fade in alert-dismissable">
					    <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
					    <strong>Error updates!</strong> Please check the input data
					    <?php echo @$post["error"];?>
					</div>
				<?php endif;?>
				<form class="form-horizontal form-label-left" method="post" enctype="multipart/form-data">
					<div class="item form-group"> 
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="User_Name">Username<span class="required">*</span></label>
						<div class="col-md-6 col-sm-6 col-xs-12"> <input id="User_Name" class="form-control col-md-7 col-xs-12" value="<?php echo @$record["User_Name"];?>" name="User_Name" placeholder="Username" required="required" type="text"> </div>
					</div>
					<div class="item form-group"> 
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="User_Email">Email<span class="required">*</span></label>
						<div class="col-md-6 col-sm-6 col-xs-12"> <input id="User_Email" class="form-control col-md-7 col-xs-12" value="<?php echo @$record["User_Email"];?>" placeholder="Email" type="email" required="required" readonly> </div>
					</div>
					<div class="item form-group"> 
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="User_Pwd">New password<span class="required">*</span></label>
						<div class="col-md-6 col-sm-6 col-xs-12"> <input id="User_Pwd" minlength = "6" class="form-control col-md-7 col-xs-12" value="" name="User_Pwd" placeholder="If you do not want to change your password please leave it blank" type="password" autocomplete="false"> </div>
					</div>
					<div class="item form-group"> 
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="User_Avatar">Avatar</label>
						<div class="col-md-6 col-sm-6 col-xs-12"> 
						    <?php if($record["User_Avatar"] != null && $record["User_Avatar"] != ""):?>
						    	<div class="row">
						    		<div class="col-md-4 col-xs-12"><img style="max-width: 100%;" src="<?php echo base_url($record["User_Avatar"])?>"></div>
									<div class="col-md-8 col-xs-12"><input id="User_Avatar" class="form-control" name="User_Avatar" placeholder="Avatar" type="file" accept="image/*"></div> 
								</div>
							<?php else :?>
								<input id="User_Avatar" class="form-control col-md-7 col-xs-12" name="User_Avatar" placeholder="Avatar" type="file" accept="image/*">
							<?php endif; ?>
						</div>
					</div>
					<div class="ln_solid"></div>
					<div class="form-group">
						<button id="send" type="submit" class="btn btn-success">Update</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>