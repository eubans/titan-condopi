<?php $this->load->view('frontend/profile/nav'); ?>
<div class="container page-container">
    <div id="primary" class="content-area row">
        <aside id="aside" class="site-aside col-sm-3">
            <?php $this->load->view('frontend/profile/sidebar'); ?>
        </aside>
        <div class="col-sm-9">
            <div class="panel panel-default">
                <div class="panel-heading">Admin Payment</div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table ">
                            <thead>
                                <tr>
                                    <th>Location</th>
                                    <th class="text-right">Price</th>
                                    <th>Status</th>
                                    <th>Paid Date</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php if(isset($records)):?>
                                <?php foreach ($records as $key => $value):?>
                                    <tr> 
                                        <td><a target="_blank" href="<?php echo base_url(); ?>home/detail/<?php echo @$value['Slug']; ?>"><?php echo $value["Name"]?></a></td>
                                        <td class="text-right">$<?php echo $value["Total_Discount"];?></td>
                                        <td><?php
                                            if ($value["Status_Order"] == 0 ) echo "Waiting";
                                            else  echo "Paid";
                                        ?></td>
                                        <td><?php echo $value["Createdat_Owner"]; ?></td>
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