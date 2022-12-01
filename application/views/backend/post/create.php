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
						<label class="control-label col-md-2 col-sm-2 col-xs-12" for="Name">Name <span class="required">*</span></label>
						<div class="col-md-9 col-sm-10 col-xs-12"> <input value="<?php echo @$this->input->post("Name");?>" id="Name" class="form-control col-md-7 col-xs-12" name="Name" placeholder="Name " required="required" type="text"> </div>
					</div>

					<div class="item form-group"> 
						<label class="control-label col-md-2 col-sm-2 col-xs-12" for="Meta_Tags">Meta Tags</label>
						<div class="col-md-9 col-sm-10 col-xs-12">
							<input value="<?php echo @$this->input->post("Meta_Tags"); ?>" id="Meta_Tags" class="form-control col-md-7 col-xs-12" name="Meta_Tags" placeholder="Meta Tags" type="text">
						</div>
					</div>

					<div class="item form-group"> 
						<label class="control-label col-md-2 col-sm-2 col-xs-12" for="Meta_Descriptions">Meta Description</label>
						<div class="col-md-9 col-sm-10 col-xs-12">
							<input value="<?php echo @$this->input->post("Meta_Description"); ?>" id="Meta_Description" class="form-control col-md-7 col-xs-12" name="Meta_Description" placeholder="Meta Description" type="text">
						</div>
					</div>

					<div class="item form-group"> 
						<label class="control-label col-md-2 col-sm-2 col-xs-12" for="Content">Content <span class="required">*</span></label>
						<div class="col-md-9 col-sm-10 col-xs-12"> 
							<?php echo $this->ckeditor->editor('Content',@$this->input->post("Content"));?>
						</div>
					</div>

					<div class="item form-group"> 
						<label class="control-label col-md-2 col-sm-2 col-xs-12" for="Disclaimer">Disclaimer</label>
						<div class="col-md-9 col-sm-10 col-xs-12"> 
							<?php echo $this->ckeditor->editor('Disclaimer',$this->input->post("Disclaimer"));?>
						</div>
					</div>

					<div class="item form-group"> 
						<label class="control-label col-md-2 col-sm-2 col-xs-12" for="Category_ID">Category</label>
						<div class="col-md-9 col-sm-10 col-xs-12"> 
						    <select id="Category_ID" class="form-control col-md-7 col-xs-12" name="Category_ID">   
						    	<option value="0">Category</option>
						    	<?php echo @$listcat;?>
							</select> 
						</div>
					</div>

					<div class="item form-group"> 
						<label class="control-label col-md-2 col-sm-2 col-xs-12" for="Date">Date</label>
						<div class="col-md-9 col-sm-10 col-xs-12"> 
							<input value="<?php echo @$this->input->post("Date");?>" id="Date" class="form-control col-md-7 col-xs-12" name="Date" placeholder="Date" type="text">
						</div>
					</div>

					<div class="item form-group"> 
						<label class="control-label col-md-2 col-sm-2 col-xs-12" for="Author">Author</label>
						<div class="col-md-9 col-sm-10 col-xs-12"> 
							<input value="<?php echo @$this->input->post("Author");?>" id="Author" class="form-control col-md-7 col-xs-12" name="Author" placeholder="Author" type="text">
						</div>
					</div>

					<div class="item form-group"> 
						<label class="control-label col-md-2 col-sm-2 col-xs-12" for="CTA">CTA</label>
						<div class="col-md-9 col-sm-10 col-xs-12"> 
							<input value="<?php echo @$this->input->post("CTA");?>" id="CTA" class="form-control col-md-7 col-xs-12" name="CTA" placeholder="CTA" type="text">
						</div>
					</div>

					<div class="item form-group"> 
						<label class="control-label col-md-2 col-sm-2 col-xs-12" for="Button_Text">Button Text</label>
						<div class="col-md-9 col-sm-10 col-xs-12"> 
							<input value="<?php echo @$this->input->post("Button_Text");?>" id="Button_Text" class="form-control col-md-7 col-xs-12" name="Button_Text" placeholder="Button_Text" type="text">
						</div>
					</div>

					<div class="item form-group"> 
						<label class="control-label col-md-2 col-sm-2 col-xs-12" for="Button_Url">Button Link</label>
						<div class="col-md-9 col-sm-10 col-xs-12"> 
							<input value="<?php echo $this->input->post("Button_Url");?>" id="Button_Url" class="form-control col-md-7 col-xs-12" name="Button_Url" placeholder="Button_Url" type="text">
						</div>
					</div>

					<div class="item form-group"> 
						<label class="control-label col-md-2 col-sm-2 col-xs-12" for="Color">Color</label>
						<div class="col-md-9 col-sm-10 col-xs-12"> 
							<input value="<?php echo $this->input->post("Color");?>" id="Color" class="form-control col-md-7 col-xs-12" name="Color" placeholder="Color" type="text">
						</div>
					</div>

					<div class="item form-group"> 
						<label class="control-label col-md-2 col-sm-2 col-xs-12" for="Images">Images</label>
						<div class="col-md-9 col-sm-10 col-xs-12"> 
						    <div class="featured-image <?php echo $this->input->post('Media') != null ? 'active' : ''; ?>">
		                        <span class="remove-featured-image" onclick="ClearFileCustom(this);" title="Remove">
		                            <i class="fa fa-times" aria-hidden="true"></i>
		                        </span>
		                        <a href="#" onclick="BrowseServerCustom(this);return false;">
		                            <i class="fa fa-plus" title="Choose Image"></i>
		                        </a>
		                        <img src="<?php echo $this->input->post('Media'); ?>">
		                        <input id="xImagePath" name="Media" value="<?php echo $this->input->post('Media'); ?>" type="text" size="60" class="form-control xImagePath" style="display: none;" />
		                    </div>
						</div>
					</div>
					<div class="ln_solid"></div>
					<div class="form-group">
						<div class="col-md-6 col-md-offset-3"><a href="<?php echo backend_url(@$base_controller) . "?post_type=".$post_type;?>" class="btn btn-primary">Back</a><button id="send" type="submit" class="btn btn-success">Add new</button> </div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<style type="text/css">
	.featured-image {
	    width: 150px;
	    height: 150px;
	    border: 1px dotted #ccc;
	    position: relative;
	    text-align: center;
	}
	.featured-image img {
	    display: none;
	    width: 100%;
    	height: auto;
	}
	.featured-image.active > a {
	    display: none;
	}
	.featured-image .remove-featured-image i {
	    color: red !important;
	}
	.featured-image > a i {
	    font-size: 30px;
	    line-height: 150px;
	}
	.featured-image .remove-featured-image {
	    position: absolute;
	    right: 5px;
	    top: 0px;
	    cursor: pointer;
	    display: none;
	}
	.featured-image.active .remove-featured-image {
	    display: block;
	}
	.featured-image.active {
	    height: auto;
	    border: none;
	}
	.featured-image.active img {
	    display: block;
	    width: 100%;
	    height: auto;
	}
</style>
<script type="text/javascript">
	$(document).on("click",".list-box-icon .fa-hover a",function(){
		var text = $(this).find("i").attr("class");
		$("input[name='Icon']").val(text);
		return false;
	});
</script>
<script type="text/javascript" src="<?php echo skin_url('js/ckfinder/ckfinder_v1.js'); ?>"></script>
<script type="text/javascript">
	var element_current;
    function BrowseServerCustom(element) {
    	element_current = element;
    	var finder = new CKFinder() ;
	    finder.BasePath = '<?php echo skin_url('js/ckfinder/'); ?>';
	    finder.SelectFunction = SetFileField ;
	    //finder.SelectFunctionData = inputId ;
	    finder.Popup();
    }

    function SetFileField( fileUrl, data ){
	    $(element_current).parents('.featured-image').find('.xImagePath').val(fileUrl);
        $(element_current).parents('.featured-image').find('img').attr('src',fileUrl);
        $(element_current).parents('.featured-image').addClass('active');
        $('.overlay-ckfinder').hide();
	}

    function ClearFileCustom(element){
        $(element).parents('.featured-image').find('.xImagePath').val('');
        $(element).parents('.featured-image').removeClass('active');
    }
</script>