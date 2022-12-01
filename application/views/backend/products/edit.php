<div class="main-page <?php echo @$main_page;?>">
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">
			<div class="x_title">
				<h2>Update
					<a class="btn btn-success create-item" href="<?php echo backend_url(@$base_controller."/create");?>"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add new</a>
				</h2>
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
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="First_Name">First Name <span class="required">*</span></label>
						<div class="col-md-6 col-sm-6 col-xs-12"> <input id="First_Name" value="<?php echo $record["First_Name"]?>" class="form-control col-md-7 col-xs-12" name="First_Name" placeholder="First Name" required="required" type="text"> </div>
					</div>
					<div class="item form-group"> 
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="Last_Name">Last Name<span class="required">*</span></label>
						<div class="col-md-6 col-sm-6 col-xs-12"> <input id="Last_Name" value="<?php echo $record["Last_Name"]?>" class="form-control col-md-7 col-xs-12" name="Last_Name" placeholder="Last Name" required="required" type="text"> </div>
					</div>
					<div class="item form-group"> 
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="Email">Email<span class="required">*</span></label>
						<div class="col-md-6 col-sm-6 col-xs-12"> <input id="Email" value="<?php echo $record["Email"]?>" class="form-control col-md-7 col-xs-12" name="Email" placeholder="Email" required="required" type="email" readonly> </div>
					</div>
					<div class="item form-group"> 
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="Sex">Sex <span class="required">*</span></label>
						<div class="col-md-6 col-sm-6 col-xs-12"> 
							<select id="Sex" class="form-control col-md-7 col-xs-12" name="Sex" required="required">
							    <option value="0">&mdash; &mdash; Sex &mdash; &mdash;</option>
								<option value="Male" <?php echo ($record["Sex"] == "Male")? "selected" :"" ?> >Male</option>
								<option value="Female" <?php echo ($record["Sex"] == "Female")? "selected" :"" ?> >Female</option>
								<option value="Other" <?php echo ($record["Sex"] == "Other")? "selected" :"" ?>>Other</option>
							</select>
						</div>
					</div>
					<div class="item form-group"> 
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="Birth_Date">Birth Date <span class="required">*</span></label>
						<div class="col-md-6 col-sm-6 col-xs-12">
						    <input type="date" class="form-control" name="Birth_Date" value="<?php echo $record["Birth_Date"];?>" placeholder="Birth Date" required="required" autocomplete="false">
						</div>
					</div>	
					<div class="item form-group"> 
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="Password">Password</label>
						<div class="col-md-6 col-sm-6 col-xs-12"> <input id="Password" class="form-control col-md-7 col-xs-12" name="Password" placeholder="Password" type="password"></div>
					</div>
					<div class="item form-group"> 
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="Adress">Adress</label>
						<div class="col-md-6 col-sm-6 col-xs-12"> <input id="Adress" class="form-control col-md-7 col-xs-12" value="<?php echo $record["Adress"]?>" name="Adress" placeholder="Adress" type="text"> </div>
					</div>
					<div class="item form-group"> 
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="Phone">Phone</label>
						<div class="col-md-6 col-sm-6 col-xs-12"> <input id="Phone" class="form-control col-md-7 col-xs-12" value="<?php echo $record["Phone"]?>" name="Phone" placeholder="Phone" type="text"> </div>
					</div>
					<div class="item form-group"> 
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="Avatar">Avatar</label>
						<div class="col-md-6 col-sm-6 col-xs-12"> 
						    <?php if($record["Avatar"] != null && $record["Avatar"] != ""):?>
						    	<div class="row">
						    		<div class="col-md-4 col-xs-12"><img style="max-width: 100%;" src="<?php echo base_url($record["Avatar"])?>"></div>
									<div class="col-md-8 col-xs-12"><input id="Avatar" class="form-control" name="Avatar" placeholder="Avatar" type="file" accept="image/*"></div> 
								</div>
							<?php else :?>
								<input id="Avatar" class="form-control col-md-7 col-xs-12" name="Avatar" placeholder="Avatar" type="file" accept="image/*">
							<?php endif; ?>
						</div>
					</div>
					<div class="item form-group"> 
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="Description">Description</label>
						<div class="col-md-6 col-sm-6 col-xs-12"> 
							<textarea id="Description" class="form-control col-md-7 col-xs-12" value="<?php echo $record["Description"]?>" name="Description" placeholder="Description"> </textarea> 
						</div>
					</div>
					<div class="item form-group"> 
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="Status">Status<span class="required">*</span></label>
						<div class="col-md-6 col-sm-6 col-xs-12"> 
							<select id="Status" class="form-control col-md-7 col-xs-12" name="Status">   
						    	<?php 
						    		if($record["Status"] == "1"){?>
						    			<option selected value="1">Activity</option>
							    		<option value="0">Shut down</option>
						    		<?php }else{?>
						    			<option value="1">Activity</option>
							    		<option selected value="0">Shut down</option>
						    		<?php }
						    	?>	
							</select>
						</div>
					</div>
					<div class="ln_solid"></div>
					<div class="form-group">
						<div class="col-md-6 col-md-offset-3"><a href="<?php echo backend_url(@$base_controller);?>" class="btn btn-primary">Back</a><button id="send" type="submit" class="btn btn-success">Update</button> </div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).on("click",".list-box-icon .fa-hover a",function(){
		var text = $(this).find("i").attr("class");
		$("input[name='Icon']").val(text);
		return false;
	});
</script>