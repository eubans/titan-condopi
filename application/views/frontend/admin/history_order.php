<?php $this->load->view('frontend/admin/nav'); ?>
<div class="container page-container">
    <div id="primary" class="content-area row">
        <aside id="aside" class="site-aside col-sm-3">
            <?php $this->load->view('frontend/admin/sidebar'); ?>
        </aside>
        <div class="col-sm-9">
            <div class="panel panel-default">
                <div class="panel-heading">My orders</div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table ">
                            <thead>
                                <tr>
                                    <th>Location</th>
                                    <th>Check in - Check out</th>
                                    <th class="text-right">Price</th>
                                    <th>Status</th>
                                    <th>Created at</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php if(isset($records)):?>
                                <?php foreach ($records as $key => $value):?>
                                    <tr> 
                                        <td><a target="_blank" href="<?php echo base_url(); ?>home/detail/<?php echo @$value['Slug']; ?>"><?php echo $value["Name"]?></a></td>
                                        <td><?php echo date("m/d/Y", strtotime( $value["Start_Day"])) . ' - ' . date("m/d/Y", strtotime( $value["Expires_at"])); ?></td>
                                        <td class="text-right">$<?php echo $value["Total_Order"];?></td>
                                        <td><?php
                                            if($value["Status_Order"] == 0 ) echo "Pending";
                                            elseif ( $value["Status_Order"] == 1 ) echo "Success";
                                            else  echo "Cancel";
                                        ?></td>
                                        <td><?php echo date("m/d/Y", strtotime( $value["Create_at"])); ?></td>
                                    </tr>
                                <?php endforeach;?>
                            <?php endif;?>
                            </tbody>
                        </table>
                    </div>        
                </div>          
            </div>
            <div class="row">
                <div class="col-sm-12 text-center">
                    <?php echo $this->pagination->create_links();?>
                </div>
            </div>
        </div>
    </div>
</div>