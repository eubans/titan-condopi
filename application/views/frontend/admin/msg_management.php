<?php $this->load->view('frontend/admin/nav'); ?>
<div class="container page-container">
    <div id="primary" class="content-area row">
        <aside id="aside" class="site-aside col-sm-3">
            <?php $this->load->view('frontend/admin/sidebar'); ?>
        </aside>
        <main id="main" class="site-main col-sm-9" role="main">
            <div class="panel panel-default">
                <div class="panel-heading">Msg Management</div>
                <div class="panel-body">
                    <?php 
                        if($this->session->flashdata('message')){
                            echo $this->session->flashdata('message');
                        }
                    ?>
	                							
                    <div class="table-responsive">
                        <table class="table table-striped jambo_table bulk_action">
							<thead>
								<tr class="headings">
									<th class="column-title"># </th>
									<th class="column-title">Date</th>
									<th class="column-title">From - To</th>
									<th class="column-title">Subject</th>
									<th class="column-title">Body</th>
									<th class="column-title no-link last"><span class="nobr">Send/Del</span> </th>
								</tr>
							</thead>
							<tbody>
							    <?php
							        if(isset($collections)){
							        	$i = 1;
							        	foreach ($collections as $key => $value) {?>
								    		<tr class="even pointer">
												<td class="a-center "> <?php echo $i++;?> </td>
												<td class=" "><?php echo date("m/d/Y", strtotime(@$value["Created_At"])); ?></td>
												<td class=" ">From: <?php echo $value["Email"]; ?><br/>To: <?php echo $value["EmailTo"]; ?></td>
												<td class=" "><?php echo read_more($value["Subject"],2); ?></td>
												<td class=" "><?php echo read_more($value["Message"],5); ?></td>
												<td class=" last">
													<?php if ($value["Is_Send"] == 1) : ?>
													<a class="disabled" style="color:grey;">send</a> | 
													<?php else :?>
													<a onclick="return confirm('Do you really want to send message to seller?');" href="<?php echo base_url('/admin/profile/send_msg/'.$value['ID']); ?>">send</a> | 
													<?php endif; ?>
													<a onclick="return confirm('Do you really want to delete?');" href="<?php echo base_url('/admin/profile/del_msg/'.$value['ID']); ?>">del</a>
												</td>
											</tr>
								    	<?php }
							        }
							    	
							    ?>
							</tbody>
						</table>
                    </div>
                    <div class="row">
                        <div class="col-sm-4 text-left">
                            
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
