<div class="main-page <?php echo @$main_page;?>">
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">
			<div class="x_title">
				<h2>Quản Lý Chức Năng Hệ Thống <a class="btn btn-success create-item" href="<?php echo backend_url("companies/create");?>"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Thêm mới</a></h2>
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
						    <strong>Thêm mới thành công!</strong> Bạn có thể cập nhật dữ liệu tại đây
						</div>
					<?php endif;?>
					<?php if(@$this->input->get("edit") == "success"):?>
					    <div class="alert alert-success fade in alert-dismissable" style="margin-top:18px;">
						    <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
						    <strong>Cập nhật thành công!</strong> Bạn có thể cập nhật dữ liệu tại đây
						</div>
					<?php endif;?>
					<?php if(@$this->input->get("delete") == "success"):?>
					    <div class="alert alert-success fade in alert-dismissable" style="margin-top:18px;">
						    <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
						    <strong>Xóa thành công!</strong> 
						</div>
					<?php endif;?>
					<?php if(@$post["status"] == "error"):?>
					    <div class="alert alert-danger fade in alert-dismissable">
						    <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
						    <strong>Lỗi thêm cập nhật!</strong> Vui lòng kiểm tra dữ liệu đầu vào
						    <?php echo @$post["error"];?>
						</div>
					<?php endif;?>
					<table class="table table-striped jambo_table bulk_action">
						<thead>
							<tr class="headings">
								<th class="column-title">Stt </th>
								<th class="column-title">Tên công ty </th>
								<th class="column-title">Người tạo </th>
								<th class="column-title">Tên ngân hàng</th>
								<th class="column-title">Tên tài khoản</th>
								<th class="column-title">Mã số thuế</th>
								<th class="column-title">Địa chỉ</th>
								<th class="column-title">Ngày tạo</th>
								<th class="column-title">Ngày kết thúc</th>
								<th class="column-title">Trạng thái</th>
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
										<td><?php echo $value["CompanyName"]?></td>
										<td><?php echo $value["User_Name"]?></td>
										<td><?php echo $value["Bank"]?></td>
										<td><?php echo $value["BankAccount"]?></td>
										<td><?php echo $value["MST"]?></td>
										<td><?php echo $value["Address"]?></td>
										<td><?php echo $value["Createdat"]?></td>
										<td><?php echo $value["EndTime"]?></td>
									    <td><?php echo ($value["Status"] == "1") ? "Hoạt động" : "Ngừng hoạt động";?></td>
										<td class="last"><a href="<?php echo backend_url('companies/edit/'.$value["ID"])?>">sửa</a><?php if($value["System"] != '1'):?> | <a onclick="return confirm('Bạn thật sự muốn xóa?');" href="<?php echo backend_url('companies/delete/'.$value["ID"])?>">xóa</a> <?php endif;?></td>
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