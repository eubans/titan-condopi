<div class="main-page <?php echo @$main_page;?>">
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">
			<div class="x_title">
				<h2>Thêm mới Công ty</h2>
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
				<form class="form-horizontal form-label-left" method="post">
					<div class="item form-group"> 
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="CompanyName">Tên công ty <span class="required">*</span></label>
						<div class="col-md-6 col-sm-6 col-xs-12"> <input id="CompanyName" class="form-control col-md-7 col-xs-12" name="CompanyName" placeholder="Tên công ty" required="required" type="text"> </div>
					</div>
					<div class="item form-group"> 
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="User_ID">Chủ sở hữu<span class="required">*</span></label>
						<div class="col-md-6 col-sm-6 col-xs-12"> 
							<select id="User_ID" class="form-control col-md-7 col-xs-12" name="User_ID" required="required">
								<?php echo create_select(@$all_member,"ID","User_Name")?>
							</select>
						</div>
					</div>
					<div class="item form-group"> 
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="Bank">Tên ngân hàng</label>
						<div class="col-md-6 col-sm-6 col-xs-12"> <input id="Bank" class="form-control col-md-7 col-xs-12" name="Bank" placeholder="Tên ngân hàng" type="text"> </div>
					</div>
					<div class="item form-group"> 
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="BankAccount">Tên tài khoản</label>
						<div class="col-md-6 col-sm-6 col-xs-12"> <input id="BankAccount" class="form-control col-md-7 col-xs-12" name="BankAccount" placeholder="Tên tài khoản" type="text"> </div>
					</div>
					<div class="item form-group"> 
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="MST">Mã số thuế</label>
						<div class="col-md-6 col-sm-6 col-xs-12"> <input id="MST" class="form-control col-md-7 col-xs-12" name="MST" placeholder="Mã số thuế"  type="text"> </div>
					</div>
					<div class="item form-group"> 
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="Adress">Địa chỉ<span class="required">*</span></label>
						<div class="col-md-6 col-sm-6 col-xs-12"> <input id="Adress" class="form-control col-md-7 col-xs-12" name="Adress" placeholder="Địa chỉ" required="required" type="text"> </div>
					</div>
					<div class="item form-group"> 
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="EndTime">Ngày kết thúc</label>
						<div class="col-md-6 col-sm-6 col-xs-12"> <input id="EndTime" class="form-control col-md-7 col-xs-12" name="EndTime" placeholder="Ngày kết thúc" type="number"> </div>
					</div>	
					<div class="item form-group"> 
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="Status">Trạng thái<span class="required">*</span></label>
						<div class="col-md-6 col-sm-6 col-xs-12"> 
							<select id="Status" class="form-control col-md-7 col-xs-12" name="Status">   
						    	<option value="1">Hoạt động</option>
							    <option value="0">Ngưng hoạt động</option>
							</select>
						</div>
					</div>
					<div class="ln_solid"></div>
					<div class="form-group">
						<div class="col-md-6 col-md-offset-3"><a href="<?php echo backend_url("sysmodules");?>" class="btn btn-primary">Trở lại</a><button id="send" type="submit" class="btn btn-success">Thêm mới</button> </div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).on("click",".list-box-icon .fa-hover a",function(){
		var text = $(this).find("i").attr("class");
		$("input[name='Icon']").val(text);
		return false;
	});
</script>