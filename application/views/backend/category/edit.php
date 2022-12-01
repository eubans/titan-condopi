<div class="main-page <?php echo @$main_page;?>">
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">
			<div class="x_title">
				<h2>Update user
					<a class="btn btn-success create-item" href="<?php echo backend_url(@$base_controller."/create/?post_type=".$post_type);?>"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add new</a>
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
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="Name">Name <span class="required">*</span></label>
						<div class="col-md-6 col-sm-6 col-xs-12"> <input value="<?php echo @$record["Name"];?>" id="Name" class="form-control col-md-7 col-xs-12" name="Name" placeholder="Name " required="required" type="text"> </div>
					</div>
					<div class="item form-group"> 
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="Parent_ID">Parent</label>
						<div class="col-md-6 col-sm-6 col-xs-12"> 
						    <select id="Parent_ID" class="form-control col-md-7 col-xs-12" name="Parent_ID">   
						    	<option value="0">---Choose Parent_ID---</option>
						    	<?php echo @$listcat;?>
							</select> 
						</div>
					</div>
					<div class="ln_solid"></div>
					<div class="form-group">
						<div class="col-md-6 col-md-offset-3"><a href="<?php echo backend_url(@$base_controller) . "?post_type=".$post_type;?>" class="btn btn-primary">Back</a><button id="send" type="submit" class="btn btn-success">Update</button> </div>
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