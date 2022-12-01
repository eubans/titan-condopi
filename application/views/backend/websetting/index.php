<div class="main-page <?php echo @$main_page;?>">
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">
			<div class="x_title">
				<h2>Edit
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
                        <label>Title</label>
                        <?php $data = array('name' => 'Title', 'value' => isset($record)?$record['Title']:'', 'class'=>'form-control','id' => 'Title','placeholder'=> 'Title');
                        echo form_input($data); ?>
                    </div>
                    <?php 
                    	if ($record['Body_Json'] != null && $record['Body_Json'] != '') {
                    		$Body_Json = json_decode($record['Body_Json'], true);
                    	}
                    ?>
                    <div class="form-group">
                        <label>Email's Name</label>
                        <input type="textbox" class="form-control" required name="Body_Json[Email_Name]" value="<?php echo @$Body_Json['Email_Name']; ?>" />
                    </div>
                    <div class="form-group">
                        <label>Email's Address</label>
                        <input type="textbox" class="form-control" required name="Body_Json[Email_Address]" value="<?php echo @$Body_Json['Email_Address']; ?>" />
                    </div>
                    <div class="form-group">
                        <label>Copyright</label>
                        <textarea rows="10" class="form-control" required name="Body_Json[Copyright]"><?php echo @$Body_Json['Copyright']; ?></textarea>
                    </div>
                    <div class="form-group">
                        <label>Social</label>
                    	<textarea rows="10" class="form-control" required name="Body_Json[Social]"><?php echo @$Body_Json['Social']; ?></textarea>
                    </div>
                    
                    <div class="row">
                        <div class="col-lg-12">
                        <?php $data = array('name' => 'Submit','id' => 'Submit','value' =>'Save','class' => 'btn btn-primary');
                            echo form_submit($data); ?>
                        </div>
                    </div>
				</form>
			</div>
		</div>
	</div>
</div>