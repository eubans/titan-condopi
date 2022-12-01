<div class="main-page <?php echo @$main_page;?>">
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">
			<div class="x_title">
				<h2>Create
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
					<div class="form-group">
                        <label>Type Page</label>
                        <?php 
                        $options = array(
                            'page'   => 'Page',
                            'block'  => 'Block',
                        );
                        echo form_dropdown('Type_Page', $options, isset($record)?$record['Type_Page']:'', 'class="form-control" id="Type_Page"'); 
                        ?>
                    </div>
                    <div class="form-group">
                        <label>Key Identify</label>
                        <?php $data = array('name' => 'Key_Identify', 'value' => isset($record)?$record['Key_Identify']:'', 'class'=>'form-control','id' => 'Key_Identify', 'placeholder'=> 'Key Identify');
                        echo form_input($data); ?>
                    </div>
                    <div class="form-group">
                        <label>Title</label>
                        <?php $data = array('name' => 'Title', 'value' => isset($record)?$record['Title']:'', 'class'=>'form-control','id' => 'Title','placeholder'=> 'Title');
                        echo form_input($data); ?>
                    </div>
                    <div class="form-group">
                        <label>Meta Tags</label>
                        <?php $data = array('name' => 'Meta_Tags', 'value' => isset($record)?$record['Meta_Tags']:'', 'class'=>'form-control','id' => 'Meta_Tags','placeholder'=> 'Meta Tags');
                        echo form_input($data); ?>
                    </div>
                    <div class="form-group">
                        <label>Meta Description</label>
                        <?php $data = array('name' => 'Meta_Description', 'value' => isset($record)?$record['Meta_Description']:'', 'class'=>'form-control','id' => 'Meta_Description','placeholder'=> 'Meta Description');
                        echo form_input($data); ?>
                    </div>
                    <div class="form-group">
                        <label>Summary</label>
                        <?php echo $this->ckeditor->editor('Summary',@$record['Summary']);?>
                    </div>
                    <div class="form-group">
                        <label>Content</label>
                        <?php echo $this->ckeditor->editor('Content',@$record['Content']);?>
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <?php 
                        $options = array(
                            'yes'   => 'Display',
                            'no'  => 'Draft',
                        );
                        echo form_dropdown('Status', $options, @$record['Status'], 'class="form-control" id="Status"'); 
                        ?>
                    </div>
                    <div class="form-group">
                        <label>Media</label>
                        <input id="xImagePath" name="Media" value="<?php echo @$record['Media']; ?>" type="text" size="60" class="form-control" />
                        <input type="button" value="Browse Server" onclick="BrowseServer( 'xImagePath' );" />
                        <input type="button" value="Remove File" onclick="ClearFile( 'xImagePath' );" />
                    </div>
                    <div class="form-group">
                        <label>Background Color</label>
                        <?php 
                        $options = array(
                        	'' => 'Select',
                            '#64d39e'   => 'Coming Soon - Blue',
                            '#b5df7b'   => 'Off-Market - Green',
                            '#fbae82'   => 'REO - Orange',
                            '#ea7884'   => 'Buyers Resource - Pink',
                        );
                        echo form_dropdown('Bgcolor', $options, @$record['Bgcolor'], 'class="form-control" id="Bgcolor"'); 
                        ?>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                        <?php $data = array('name' => 'Submit','id' => 'Submit','value' =>'Save','class' => 'btn btn-primary');
                            echo form_submit($data); ?>
                        <?php $data = array('name' => 'Cancel','id' => 'Cancel','value' =>'Close','class' => 'btn btn-close');
                            echo form_button($data, 'Close', 'onClick="document.location.href=\''.backend_url(@$base_controller).'\';"'); ?>
                        </div>
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
<script type="text/javascript" src="<?php echo skin_url('js/ckfinder/ckfinder_v1.js'); ?>"></script>
<script type="text/javascript">
function BrowseServer( inputId )
{
    var finder = new CKFinder() ;
    finder.BasePath = '<?php echo skin_url('js/ckfinder/'); ?>';
    finder.SelectFunction = SetFileField ;
    finder.SelectFunctionData = inputId ;
    finder.Popup() ;
}

function ClearFile( inputId )
{
    document.getElementById( inputId ).value = '' ;
}

function SetFileField( fileUrl, data )
{
    document.getElementById( data["selectActionData"] ).value = fileUrl ;
}
</script>