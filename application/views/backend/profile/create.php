<div class="main-page <?php echo @$main_page;?>">
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">
			<div class="x_title">
				<h2>Thêm mới Người Dùng Hệ Thống</h2>
				<ul class="nav navbar-right panel_toolbox">
					<li style="float: right;"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
				</ul>
				<div class="clearfix"></div>
			</div>
			<div class="x_content">
			    <?php if(@$post["status"] == "error"):?>
				    <div class="alert alert-danger fade in alert-dismissable">
					    <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
					    <strong>Lỗi thêm mới!</strong> Vui lòng kiểm tra dữ liệu đầu vào
					    <?php echo @$post["error"];?>
					</div>
				<?php endif;?>
				<form class="form-horizontal form-label-left" method="post" enctype="multipart/form-data">
					<div class="item form-group"> 
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="User_Name">Tên người dùng<span class="required">*</span></label>
						<div class="col-md-6 col-sm-6 col-xs-12"> <input id="User_Name" class="form-control col-md-7 col-xs-12" value="<?php echo @$post["User_Name"];?>" name="User_Name" placeholder="Tên người dùng" required="required" type="text"> </div>
					</div>
					<div class="item form-group"> 
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="User_Email">Email người dùng<span class="required">*</span></label>
						<div class="col-md-6 col-sm-6 col-xs-12"> <input id="User_Email" class="form-control col-md-7 col-xs-12" value="<?php echo @$post["User_Email"];?>" name="User_Email" placeholder="Nhập email đăng nhập" type="email" required="required"> </div>
					</div>
					<div class="item form-group"> 
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="User_Pwd">Mật khẩu<span class="required">*</span></label>
						<div class="col-md-6 col-sm-6 col-xs-12"> <input id="User_Pwd" minlength = "6" class="form-control col-md-7 col-xs-12" value="<?php echo @$post["User_Pwd"];?>" name="User_Pwd" placeholder="Nhập mật khẩu đăng nhập" type="password" required="required"> </div>
					</div>
					<div class="item form-group"> 
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="User_Avatar">Ảnh đại diện</label>
						<div class="col-md-6 col-sm-6 col-xs-12"> <input id="User_Avatar" class="form-control col-md-7 col-xs-12" value="<?php echo @$post["User_Avatar"];?>" name="User_Avatar" placeholder="Ảnh đại diện" type="file" accept="image/*"> </div>
					</div>
					<div class="item form-group"> 
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="Role_ID">Quyền sử dụng hệ thống<span class="required">*</span></label>
						<div class="col-md-6 col-sm-6 col-xs-12"> 
							<select id="Role_ID" class="form-control col-md-7 col-xs-12" name="Role_ID" required="required">   
						    	<?php if(isset($role)){
						    		foreach ($role as $key => $value) {
						    			echo '<option value="'.$value["ID"].'">'.$value["Role_Title"].'</option>';
						    		}
						    	}?>
							</select>
						</div>
					</div>
					<div class="item form-group"> 
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="Status">Trạng thái<span class="required">*</span></label>
						<div class="col-md-6 col-sm-6 col-xs-12"> 
							<select id="Status" class="form-control col-md-7 col-xs-12" name="Status" required="required">   
						    	<option value="1">Hoạt động</option>
							    <option value="0">Ngưng hoạt động</option>
							</select>
						</div>
					</div>
					<div class="ln_solid"></div>
					<div class="form-group">
						<div class="col-md-6 col-md-offset-3"><a href="<?php echo backend_url("sysmembers");?>" class="btn btn-primary">Trở lại</a><button id="send" type="submit" class="btn btn-success">Thêm mới</button> </div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>