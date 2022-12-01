<?php $this->load->view('frontend/admin/nav'); ?>
<div class="container page-container">
    <div id="primary" class="content-area row">
        <aside id="aside" class="site-aside col-sm-3">
            <?php $this->load->view('frontend/admin/sidebar'); ?>
        </aside>
        <main id="main" class="site-main col-sm-9" role="main">
            <div class="panel panel-default">
                <div class="panel-heading">Your Members</div>
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
		                								'First_Name' => 'Name',
		                                                'Email' => 'Email',
		                    							'Create_At' => 'Member Since',
		                								'Last_Login' => 'Last Login',
		            									'Estate_License' => 'License',
		            									'QtyListing' => '#Listing'
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
		                                                '1' => 'Actived',
		                                                '0' => 'Wait Activating OR Inactive'
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
                        <table class="table table-striped jambo_table bulk_action">
							<thead>
								<tr class="headings">
									<th class="column-title"># </th>
									<th class="column-title">Name</th>
									<th class="column-title">Email</th>
									<th class="column-title">Member Since</th>
									<th class="column-title">Last Login</th>
									<th class="column-title">License</th>
									<th class="column-title">Active</th>
									<th class="column-title">#L</th>
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
												<td class=" "><?php echo $value["Email"]?></td>
												<td class=" "><?php echo date("m/d/Y", strtotime(@$value["Create_At"])); ?></td>
												<td class=" "><?php echo ($value["Last_Login"] == null || $value["Last_Login"] == '0000-00-00 00:00:00') ? '' :	 date("m/d/Y", strtotime(@$value["Last_Login"])); ?></td>
												<td class=" "><?php echo $value["Estate_License"]?></td>
												<td class=" "><?php echo ($value["Status"] == 1 ? "Yes" : "")?></td>
												<td class=" "><a data-name="<?php echo $value["First_Name"] . " ". $value["Last_Name"]?>" class="listing" href="#" data-href="<?php echo base_url('admin/listings/getlisting/'.$value["ID"])?>"><?php echo $value["QtyListing"]?></a></td>
												<td class=" last"><a href="<?php echo base_url('admin/members/edit/'.$value["ID"])?>">edit</a> | <a onclick="return confirm('Do you really want to delete?');" href="<?php echo base_url('admin/members/delete/'.$value["ID"])?>">delete</a></td>
											</tr>
								    	<?php }
							        }
							    	
							    ?>
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

<script type="text/javascript">
    $(document).ready(function(){
    	$("body a.listing").click(function(){
    		var href = $(this).attr('data-href');
    		var name = $(this).attr('data-name');
            $.ajax({
                url : href,
                type: "get",
                success : function (data) {
                    var myObj = JSON.parse(data);
					if (myObj.status == 'success') {
						$('#ModalComment .modal-title').html(name);
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