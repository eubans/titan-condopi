<div class="main-page <?php echo @$main_page;?>">
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">
			<div class="x_title">
				<h2 style="">Post <a class="btn btn-success create-item" href="<?php echo backend_url(@$base_controller."/create/?post_type=".$post_type);?>"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add new</a></h2>
				<ul class="nav navbar-right panel_toolbox">
					<li style="float: right;"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
				</ul>
				<div class="clearfix"></div>
			</div>
			<div class="x_content">
				<div class="table-responsive">
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
						<table class="table table-striped jambo_table bulk_action">
							<thead>
								<tr class="headings">
									<th class="column-title"># </th>
									<th class="column-title"></th>
									<th class="column-title">Name</th>
									<th class="column-title">Slug</th>
									<th class="column-title">Date created</th>
									<th class="column-title no-link last"><span class="nobr">Actions</span> </th>
								</tr>
							</thead>
							<tbody>
							    <?php if(isset($table_data) && $table_data != null): ?>
							    	<?php foreach ($table_data as $key => $item): ?>
							    		<tr>
								    		<td><?php echo ($key+1); ?></td>
											<td>
												<?php if(@$item['Media'] != null): ?>
													<img height="40" width="40" style="max-width:none;" src="<?php echo @$item['Media']; ?>">
												<?php endif; ?>
											</td>
											<td><?php echo @$item['Name']; ?></td>
											<td><?php echo @$item['Slug']; ?></td>
											<td><?php echo @$item['Created_At']; ?></td>
											<td>
												<a href = "<?php echo backend_url($base_controller.'/edit/'. $item['ID'] . '/?post_type='.$post_type); ?>" title = "Edit" style = "margin-right:5px;"> edit </a> | 
												<a title="delete" href="<?php echo backend_url($base_controller.'/delete/'. $item['ID'] . '/?post_type='.$post_type); ?>" onclick="return confirm('Do you really want to delete ?');"> delete </a>
											</td>
							    		</tr>
							    	<?php endforeach; ?>
							    <?php endif; ?>
							</tbody>
						</table>
					</div>
			</div>
		</div>
	</div>
</div>