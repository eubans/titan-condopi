<div class="main-page <?php echo @$main_page;?>">
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">
			<div class="x_title">
				<h2>Edit
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
                        <label>Name</label>
                        <input type="text" name="Name" class="form-control" value="<?php echo $record["Name"]?>">
                    </div>
                     
                    <div class="form-group">
                        <label>Content</label>
                        <textarea rows="10" name="Content" class="form-control"><?php echo $record["Content"]?></textarea>
                    </div>
                    <div class="form-group">
                        <label>Sort</label>
                        <input type="number" name="Sort" class="form-control" value="<?php echo $record["Sort"]?>">
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