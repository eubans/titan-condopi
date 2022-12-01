<?php $this->load->view('frontend/admin/nav'); ?>
<script type="text/javascript">
    var E = null;
    function UploadPDF (A){
        E = A;
        $("#UploadPDF").trigger("click");
        return false;
    }
    function Upload(_this){
        var file = _this.files[0];
        var formData = new FormData();
        formData.append('file',file);
        formData.append('id',E.attr("data-id"));
        $.ajax({
            url:  "<?php echo base_url('admin/listings/uploadpdf')?>",
            data: formData,
            type: 'POST',
            dataType: "json",
            contentType: false,
            processData: false,
            success: function (e) {
                if(e.status == "status") window.location.reload();
                else alert('There was an error, please try again!')
            },
            error: function (data) {
                alert("There was an error, please try again!");
            }
        });
        var input = $("#UploadPDF");
        input.replaceWith(input.val('').clone(true));
        return false;
    }
</script>
<div class="container page-container">
    <div id="primary" class="content-area row">
        <main id="main" class="site-main col-sm-12" role="main">
            <div class="panel panel-default">
                <div class="panel-heading">All Listings</div>
                <div class="panel-body">
                    <?php 
                        if($this->session->flashdata('message')){
                            echo  $this->session->flashdata('message');
                        }
                    ?>
                    
                    <div class="row">
                    <form method="get" id="frmsearch" class="form">
	                    <div class="col-md-10">
	                        <div class="row">
	        					<div class="col-md-3">
	                                <div class="form-group row">
	                                    <div class="col-md-12">
	                                        <input type="text" class="form-control" placeholder="Keyword" name="keyword" value="<?php echo $this->input->get("keyword"); ?>" />
	                                    </div>
	                                </div>
	                            </div>
	                            <div class="col-md-3">
	                                <div class="form-group row">
	                                    <div class="col-md-12">
                    						<select name="field_sort" class="form-control">
                    							<option value=""> -- Sort Field -- </option>
	                                        	<?php
		                                            $field_sort = [
		                								'Name' => 'Address',
		                                                'Price' => 'Price',
		                    							'DayLeft' => 'DayLeft',
		                								'Created_At' => 'List Date',
		            									'Favorites' => 'Favorites',
		            									'Comments' => 'Comments',
		            									'Views' => 'Views'
		                                            ];
		                                        ?>
	                                            <?php foreach ($field_sort as $key => $value) {
	                                                if(trim($this->input->get("field_sort")) == trim($key))
	                                                    echo '<option value="'.$key.'" selected>'.$value.'</option>';
	                                                else
	                                                    echo '<option value="'.$key.'">'.$value.'</option>' ;
	                                            }?>
	                                        </select>
	                                    </div>
	                                </div>
	                            </div>
	                            <div class="col-md-3">
	                                <div class="form-group row">
	                                    <div class="col-md-12">
	                                        <select name="type_sort" class="form-control">
	                                        	<option value=""> -- Sort Type -- </option>
	                                        	<?php
		                                            $field_sort = [
		                    							'ASC' => 'Ascending',
		                                                'DESC' => 'Descending'
		                                            ];
		                                        ?>
	                                            <?php foreach ($field_sort as $key => $value) {
	                                                if(trim($this->input->get("type_sort")) == trim($key))
	                                                    echo '<option value="'.$key.'" selected>'.$value.'</option>';
	                                                else
	                                                    echo '<option value="'.$key.'">'.$value.'</option>' ;
	                                            }?>
	                                        </select>
	                                    </div>
	                                </div>
	                            </div>
	                            <div class="col-md-3">
	                                <div class="form-group row">
	                                    <div class="col-md-12">
	                                        <select name="status" class="form-control">
	                                        	<?php
		                                            $status = [
		                    							'All' => 'All',
		                                                '1' => 'Active',
		                                                '0' => 'Expired',
		                                        		'2' => 'Deleted'
		                                            ];
		                                        ?>
	                                            <?php foreach ($status as $key => $value) {
	                                                if(trim($this->input->get("status")) == trim($key))
	                                                    echo '<option value="'.$key.'" selected>'.$value.'</option>';
	                                                else
	                                                    echo '<option value="'.$key.'">'.$value.'</option>' ;
	                                            }?>
	                                        </select>
	                                    </div>
	                                </div>
	                            </div>  
	                        </div>
	                    </div>
	                    <div class="col-md-2">
	                    	<input type="hidden" name="perpage" id="perpage" value="<?php echo $perpage; ?>" />
	                        <button type="submit" class="btn btn-primary mb-2">Search</button>
	                    </div>
	                </form>
	                </div>
                    
                    <div class="table-responsive">
                        <table class="table ">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Address</th>
                        			<th>Seller</th>
                                    <th align="right">Price</th>
                                    <th>#Days</th>
                                    <th>List Date</th>
                        			<th>Fav</th>
                                    <th>Cmt</th>
                        			<th>#V(all)</th>
                        			<th>#V(act)</th>
                                    <th>Renew</th>
                        			<th>Report</th>
                                    <th>Edit/Del</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (isset($collections) && $collections != null) : ?>
                                    <?php foreach ($collections as $key => $item): ?>  
                                        <tr class="<?php echo ($item['Status'] == 2) ? 'deleted' : ''; ?>">
                                            <td><?php echo $item["ID"]; ?><?php //echo $key+1; ?></td>
                                            <td><?php echo $item['Name']; ?></td>
                        					<td><a data-name="<?php echo $item["Full_Name"]; ?>" data-email="<?php echo $item["Email"]; ?>" class="listing" href="#" data-href="<?php echo base_url('admin/listings/getlisting/'.$item["Member_ID"])?>"><?php echo $item['Full_Name']; ?></a></td>
                                            <td align="right">$<?php echo number_format($item['Price']); ?></td>
                                            <td><?php echo $item['DayLeft']; ?></td>
                        					<td><?php echo date('m/d/Y', strtotime($item['Created_At'])); ?></td>
                        					<td><?php echo $item['Favorites']; ?></td>
                        					<td><a class="comment" href="#" data-href="<?php echo base_url("/admin/listings/getinfo/comment/".$item['ID']); ?>"><?php echo $item['Comments']; ?></a></td>
                        					<td><a class="comment" href="#" data-href="<?php echo base_url("/admin/listings/getinfo/view_current/".$item['ID']); ?>"><?php echo $item['Views']; ?></a></td>
                        					<td><?php echo $item['CViews']; ?></td>
                                            <td>
                                            <?php 
                        						if ($item['ListingType'] == "Pre-MLS") {
	                        						echo "";
	                    						} else {
	                                                if (intval($item['DayLeft']) <= 0) {
	                                                    ?><a href="<?php echo base_url('/admin/listings/extendlisting/'.$item['ID']); ?>" onclick="return confirm('Are you sure you want to renew?');">Renew</a><?php
	                                                } else {
	                                                    echo '<a href="#" style="color:#999;cursor:normal;">Renew</a>';
	                                                }
	                                            }
                                                ?>
                                            </td>
                                            <td>
                                            	<?php if (!empty($item['PDF'])) : ?>
                                            		<a href="<?php echo $item['PDF']; ?>" target="_blank"><i class="fa fa-eye"></i></a> |   
                                                <?php endif;?>
                                                <a href="javascript:;" onclick="UploadPDF($(this))" data-id="<?php echo $item['ID'];?>"><i class="fa fa-cloud-upload"></i></a>
                                            </td>
                                            <td>
                                                <a href="<?php echo base_url('/admin/listings/editlisting/'.$item['ID']); ?>">Edit</a> | 
                                                <a href="<?php echo base_url('/admin/listings/dellisting/'.$item['ID']); ?>" onclick="return confirm('Do you really want to delete?');">Del</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                    	<div class="col-sm-4 text-left">
                            <select class="form-control required" onchange="$('#perpage').val($(this).val());$('#frmsearch').submit();" style="margin:20px 0px;">
                                <?php
                                    $itemperpage = [
                                        '20' => '20',
                                        '50' => '50',
                                		'100' => '100',
                                		'all' => 'All'
                                    ];
                                ?>
                                <?php foreach ($itemperpage as $key => $value) {
                                    if ($perpage == trim($key) || ($key == "all" && $perpage == 9999999999))
                                        echo '<option value="'.$key.'" selected>View: '.$value.' items</option>';
                                    else
                                        echo '<option value="'.$key.'">View: '.$value.' items</option>' ;
                                }?>
                            </select>
                        </div>
                        <div class="col-sm-8 text-right">
                            <?php echo $this->pagination->create_links();?>
                        </div>
                    </div>
                </div>
            </div> 
        </main>
    </div>
</div>
<!-- Modal -->
<div id="ModalComment" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title"></h4>
			</div>
			<div class="modal-body">
				
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
<input type="file" onchange="return Upload(this)" name="file" id="UploadPDF" accept="application/pdf,application/vnd.ms-excel,application/vnd.ms-word" style="display:none;">
<script type="text/javascript">
    
    $(document).ready(function(){
    	$("body a.comment").click(function(){
    		var href = $(this).attr('data-href');
            $.ajax({
                url : href,
                type: "get",
                success : function (data) {
                    var myObj = JSON.parse(data);
					if (myObj.status == 'success') {
						$('#ModalComment .modal-title').html(myObj.title);
						$('#ModalComment .modal-body').html(myObj.body);
						$('#ModalComment').modal('show');
					} else {
						alert("Could not load data. Please try again.");
					}
                },
                error : function () {
                	alert("Could not load data. Please try again.");
                }
            });
    	});
    	
        $("body a#renew-listing").click(function(){
            var c = confirm('Are you sure you want to renew?');
            if (c) {
                var url = $(this).attr("data-href");
                $.ajax({
                    url : url,
                    type:"get",
                    success : function (){
                        location.reload();
                    }
                });
            }
            return false;
        });
        
        $("body a.listing").click(function(){
    		var href = $(this).attr('data-href');
    		var name = $(this).attr('data-name');
    		var email = $(this).attr('data-email');
            $.ajax({
                url : href,
                type: "get",
                success : function (data) {
                    var myObj = JSON.parse(data);
					if (myObj.status == 'success') {
						$('#ModalComment .modal-title').html(name + '(' + email + ')');
						$('#ModalComment .modal-body').html(myObj.body);
						$('#ModalComment').modal('show');
					} else {
						alert("Could not load data. Please try again.");
					}
                },
                error : function () {
                	alert("Could not load data. Please try again.");
                }
            });
    	});
    })
</script>