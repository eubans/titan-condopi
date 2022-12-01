<div class="main-page <?php echo @$main_page;?>">
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">
			<div class="x_title">
				<h2>Management Function System <a class="btn btn-success create-item" href="<?php echo backend_url(@$base_controller."/create");?>"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add new</a></h2>
				<ul class="nav navbar-right panel_toolbox">
					<li style="float: right;"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
				</ul>
				<div class="clearfix"></div>
			</div>
			<div class="x_content">
				<form method="post">
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
									<th class="column-title">Name System </th>
									<th class="column-title">Path</th>
									<th class="column-title">Order </th>
									<th class="column-title">Status </th>
									<th class="column-title no-link last"><span class="nobr">Status</span> </th>
								</tr>
							</thead>
							<tbody>
							   <?php echo (isset($html_modules)) ? $html_modules : "";?>
							</tbody>
						</table>
					</div>
					<div class="text-right"><button id="send" type="submit" class="btn btn-success">Update order</button></div>
				</form>
			</div>
		</div>
	</div>
</div>