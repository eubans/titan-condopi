<div class="main-page <?php echo @$main_page;?>">
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">
			<div class="x_title">
				<h2>MANAGEMENT ROLE SYSTEM  <a class="btn btn-success create-item" href="<?php echo backend_url(@$base_controller."/create");?>"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add new</a></h2>
				<ul class="nav navbar-right panel_toolbox">
					<li style="float: right;"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
				</ul>
				<div class="clearfix"></div>
			</div>
			<div class="x_content">
				<div class="table-responsive">
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
					<table class="table table-striped jambo_table bulk_action">
						<thead>
							<tr class="headings">
								<th class="column-title"># </th>
								<th class="column-title">Role Name</th>
								<th class="column-title">Description</th>
								<th class="column-title">Date created</th>
								<th class="column-title no-link last"><span class="nobr">Actions</span> </th>
							</tr>
						</thead>
						<tbody>
						    <?php
						        if(isset($table_data)){
						        	$i = 1;
						        	foreach ($table_data as $key => $value) {?>
							    		<tr class="even pointer">
											<td class="a-center "> <?php echo $i++;?> </td>
											<td class=" "><?php echo $value["Role_Title"]?></td>
											<td class=" "><?php echo $value["Role_Description"]?></td>
											<td class=" "><?php echo $value["Createdat"]?></td>
											<td class=" last"><a href="<?php echo backend_url(@$base_controller.'/edit/'.$value["ID"])?>">edit</a><?php if($value["System"] != '1'):?> | <a onclick="return confirm('Do you really want to delete?');" href="<?php echo backend_url(@$base_controller.'/delete/'.$value["ID"])?>">delete</a> | <a href="<?php echo backend_url(@$base_controller.'/details/'.$value["ID"])?>">right to use</a> <?php endif;?></td>
										</tr>
							    	<?php }
						        }
						    	
						    ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>