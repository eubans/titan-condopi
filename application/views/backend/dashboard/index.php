<!-- page content -->
<div class="main-page <?php echo @$main_page;?>">
  
    <!-- top tiles -->
    <div class="row tile_count">
      <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
        <span class="count_top"><i class="fa fa-user"></i> Total Users</span>
        <div class="count">2,500</div>
      </div>
       <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
        <span class="count_top"><i class="fa fa-user"></i> Total New Users</span>
        <div class="count">200</div>
      </div>
      <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
        <span class="count_top"><i class="fa fa-clock-o"></i> Total Products</span>
        <div class="count">11,230</div>
      </div>
      <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
        <span class="count_top"><i class="fa fa-user"></i> Total Orders</span>
        <div class="count green">2,500</div>
      </div>
    </div>
    <!-- /top tiles -->
    
    
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
									<th class="column-title">Fullname</th>
									<th class="column-title">Gender</th>
									<th class="column-title">Email</th>
									<th class="column-title">Phone number</th>
									<th class="column-title">Created at</th>
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
												<td class=" "><?php echo $value["First_Name"] . " ". $value["Last_Name"]?></td>
												<td class=" "><?php echo $value["Gender"]?></td>
												<td class=" "><?php echo $value["Email"]?></td>
												<td class=" "><?php echo $value["Phone"]?></td>
												<td class=" "><?php echo $value["Create_At"]?></td>
												<td class=" last"><a href="<?php echo backend_url(@$controller.'/edit/'.$value["ID"])?>">edit</a> | <a onclick="return confirm('Do you really want to delete?');" href="<?php echo backend_url(@$controller.'/delete/'.$value["ID"])?>">delete</a></td>
											</tr>
								    	<?php }
							        }
							    	
							    ?>
							</tbody>
						</table>
				</div>
				<?php echo $this->pagination->create_links();?>
			</div>
    
  </div>
<!-- /page content -->