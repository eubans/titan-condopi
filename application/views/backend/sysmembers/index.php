<div class="main-page <?php echo @$main_page;?>">
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">
			<div class="x_title">
				<h2>User Management System  <a class="btn btn-success create-item" href="<?php echo backend_url(@$base_controller."/create");?>"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add new</a></h2>
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
								<th class="column-title">Stt </th>
								<th class="column-title">Username</th>
								<th class="column-title">Email </th>
								<th class="column-title">Date created</th>
								<th class="column-title">Avatar </th>
								<th class="column-title">Authorities </th>
								<th class="column-title">Status </th>
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
											<td class=" "><?php echo $value["User_Name"]?></td>
											<td class=" "><?php echo $value["User_Email"]?></td>
											<td class=" "><?php echo $value["Createdat"]?></td>
											<td class=" "><?php echo ($value["User_Avatar"] != null) ? '<img style="max-width: 50px;" src= "'.base_url($value["User_Avatar"]).'">' : "" ;?></td>
											<td class=" "><?php if(isset($role)){
												foreach($role as $k => $v){
													if($v["ID"] == $value["Role_ID"]){
														echo $v["Role_Title"];
													}
												}
										    }?></td>
										    <td class=""><?php echo ($value["Status"] == "1") ? "Activity" : "Shut down";?></td>
											<td class=" last"><a href="<?php echo backend_url(@$base_controller.'/edit/'.$value["ID"])?>">edit</a><?php if($value["System"] != '1'):?> | <a onclick="return confirm('Do you really want to delete?');" href="<?php echo backend_url(@$base_controller.'/delete/'.$value["ID"])?>">delete</a> <?php endif;?></td>
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