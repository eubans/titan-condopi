<div class="main-page <?php echo @$main_page;?>">
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">
			<div class="x_title">
				<h2>Quản Lý Người Dùng Hệ Thống  <a class="btn btn-success create-item" href="<?php echo backend_url("sysmembers/create");?>"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Thêm mới</a></h2>
				<ul class="nav navbar-right panel_toolbox">
					<li style="float: right;"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
				</ul>
				<div class="clearfix"></div>
			</div>
			<div class="x_content">
				<div class="table-responsive">
					<table class="table table-striped jambo_table bulk_action">
						<thead>
							<tr class="headings">
								<th class="column-title">Stt </th>
								<th class="column-title">Tên người dùng </th>
								<th class="column-title">Email </th>
								<th class="column-title">Ngày tạo </th>
								<th class="column-title">Avatar </th>
								<th class="column-title">Quyền </th>
								<th class="column-title">Trạng thái </th>
								<th class="column-title no-link last"><span class="nobr">Hành động</span> </th>
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
										    <td class=""><?php echo ($value["Status"] == "1") ? "Hoạt động" : "Ngừng hoạt động";?></td>
											<td class=" last"><a href="<?php echo backend_url('sysmembers/edit/'.$value["ID"])?>">sửa</a><?php if($value["System"] != '1'):?> | <a onclick="return confirm('Bạn thật sự muốn xóa?');" href="<?php echo backend_url('sysmembers/delete/'.$value["ID"])?>">xóa</a> <?php endif;?></td>
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