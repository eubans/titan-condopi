<div class="main-page <?php echo @$main_page;?>">
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">
			<div class="x_title">
				<h2>Add new</h2>
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
						<div class="col-md-6 col-sm-6 col-xs-12"> <input id="First_Name" class="form-control col-md-7 col-xs-12" name="First_Name" placeholder="First Name " required="required" type="text"> </div>
					</div>
					<div class="item form-group"> 
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="Last_Name">Last Name<span class="required">*</span></label>
						<div class="col-md-6 col-sm-6 col-xs-12"> <input id="Last_Name" class="form-control col-md-7 col-xs-12" name="Last_Name" placeholder="Last Name" required="required" type="text"> </div>
					</div>
					<div class="item form-group"> 
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="Email">Email<span class="required">*</span></label>
						<div class="col-md-6 col-sm-6 col-xs-12"> <input id="Email" class="form-control col-md-7 col-xs-12" name="Email" placeholder="Email" required="required" type="email"> </div>
					</div>
					<div class="item form-group"> 
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="Sex">Sex <span class="required">*</span></label>
						<div class="col-md-6 col-sm-6 col-xs-12"> 
							<select id="Sex" class="form-control col-md-7 col-xs-12" name="Sex" required="required">
							    <option value="0">&mdash; &mdash; Sex &mdash; &mdash;</option>
								<option value="Male">Male</option>
								<option value="Female">Female</option>
								<option value="Other">Other</option>
							</select>
						</div>
					</div>
					<div class="item form-group"> 
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="Birth_Date">Birth Date <span class="required">*</span></label>
						<div class="col-md-6 col-sm-6 col-xs-12">
						    <input type="date" class="form-control" name="Birth_Date" value="" placeholder="Birth Date" required="required" autocomplete="false">
						</div>
					</div>	
					<div class="item form-group"> 
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="Password">Password <span class="required">*</span></label>
						<div class="col-md-6 col-sm-6 col-xs-12"> <input id="Password" class="form-control col-md-7 col-xs-12" name="Password" placeholder="Password" type="password" required="required"></div>
					</div>
					<div class="item form-group"> 
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="Adress">Adress</label>
						<div class="col-md-6 col-sm-6 col-xs-12"> <input id="Adress" class="form-control col-md-7 col-xs-12" name="Adress" placeholder="Adress" type="text"> </div>
					</div>
					<div class="item form-group"> 
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="Phone">Phone</label>
						<div class="col-md-6 col-sm-6 col-xs-12"> <input id="Phone" class="form-control col-md-7 col-xs-12" name="Phone" placeholder="Phone" type="text"> </div>
					</div>
					<div class="item form-group"> 
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="Avatar">Avatar</label>
						<div class="col-md-6 col-sm-6 col-xs-12"> <input id="Avatar" class="form-control col-md-7 col-xs-12" value="" name="Avatar" placeholder="Avatar" type="file" accept="image/*"> </div>
					</div>
					<div class="item form-group"> 
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="Description">Description</label>
						<div class="col-md-6 col-sm-6 col-xs-12"> 
							<textarea id="Description" class="form-control col-md-7 col-xs-12" value="" name="Description" placeholder="Description"> </textarea> 
						</div>
					</div>
					<div class="item form-group"> 
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="Status">Status<span class="required">*</span></label>
						<div class="col-md-6 col-sm-6 col-xs-12"> 
							<select id="Status" class="form-control col-md-7 col-xs-12" name="Status">   
						    	<option value="1">Activity</option>
							    <option value="0">Shut down</option>
							</select>
						</div>
					</div>
					<div class="ln_solid"></div>
					<div class="form-group">
						<div class="col-md-6 col-md-offset-3"><a href="<?php echo backend_url(@$base_controller);?>" class="btn btn-primary">Back</a><button id="send" type="submit" class="btn btn-success">Add new</button> </div>
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