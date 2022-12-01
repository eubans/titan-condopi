<div class="row">
<div class="main-page <?php echo @$main_page;?>">
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">
			<div class="x_title">
				<div class="row">
					<div class="col-md-5">
				    	<h2>Management Notification <a class="btn btn-success create-item" href="<?php echo backend_url(@$base_controller."/create");?>"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add new</a></h2>
				    </div>
					<div class="col-md-4">
			            <div class="input-group" id="adv-search">
			                <input type="text" id="search-lable-name" value="<?php echo @$this->input->get("keyword");?>" class="form-control" placeholder="Keyword" />
			                <div class="input-group-btn">
			                    <div class="btn-group" role="group">
			                        <div class="dropdown dropdown-lg">
			                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><span class="caret"></span></button>
			                            <div class="dropdown-menu dropdown-menu-right" role="menu">
			                                <form class="form-horizontal" id="search-form" role="form">
			                                  <input type="hidden" id="search-value-name" class="form-control" name="keyword" />
			                                  <button style="float: right;" type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
			                                </form>
			                            </div>
			                        </div>
			                        <button onclick="$('#search-form').submit();" type="button" class="btn btn-primary"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
			                    </div>
			                </div>
			                <script type="text/javascript">
			                	$(document).on("submit","#adv-search #search-form",function(){
			                		var name = $("#adv-search #search-lable-name").val();
			                		$(this).find("#search-value-name").val(name);
			                	});
			                </script>
			            </div>
			        </div>
			        <ul class="nav navbar-right panel_toolbox">
						<li style="float: right;"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
					</ul>
				</div>
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
									<th class="column-title">Title</th>
									<th class="column-title">Created At</th>
									<th class="column-title no-link last"><span class="nobr">Actions</span> </th>
								</tr>
							</thead>
							<tbody>
							    <?php
							        if (isset($table_data)) {
							        	$i = 1;
							        	foreach ($table_data as $key => $value) {?>
								    		<tr class="even pointer">
												<td class="a-center "> <?php echo $i++;?> </td>
												<td class=" "><?php echo $value["Title"]; ?></td>
												<td class=" "><?php echo $value["Created_at"]; ?></td>
												<td class=" last"><a href="<?php echo backend_url(@$base_controller.'/edit/'.$value["ID"])?>">edit</a> | <a onclick="return confirm('Do you really want to delete?');" href="<?php echo backend_url(@$base_controller.'/delete/'.$value["ID"])?>">delete</a></td>
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
	</div>
</div>
</div>