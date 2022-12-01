<div class="row">
    <main id="main" class="site-main col-sm-12" role="main">
        <div class="panel panel-default">
            <div class="panel-heading">Orders</div>
            <div class="panel-body">
                <?php 
                    if($this->session->flashdata('message')){
                        echo  $this->session->flashdata('message');
                    }
                ?>
                <div class="table-responsive">
                    <table class="table ">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Location</th>
                                <th>Check in<br/>Check out</th>
                                <th class="text-right">Total</th>
                                <th>Status Customer</th>
                                <th>Paid Date Customer</th>
                                <th class="text-right">Discount</th>
                                <th>Status Admin</th>
                                <th>Paid Date Admin</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(isset($records) && $records != null): ?>
                                <?php foreach ($records as $key => $value): ?>  
                                    <tr>
                                        <td><?php echo $key+1; ?></td>
                                        <td><a target="_blank" href="<?php echo base_url(); ?>home/detail/<?php echo @$value['Slug']; ?>"><?php echo $value["Name"]?></a></td>
                                        <td><?php echo date("m/d/Y", strtotime( $value["Start_Day"])) . ' - ' . date("m/d/Y", strtotime( $value["Expires_at"])); ?></td>
                                        <td class="text-right">$<?php echo $value["Total_Order"];?></td>
                                        <td><?php
                                            if($value["Status_Order"] == 0 ) echo "Pending";
                                            elseif ( $value["Status_Order"] == 1 ) echo "Success";
                                            else  echo "Cancel";
                                        ?></td>
                                        <td><?php echo date("m/d/Y", strtotime( $value["Create_at"])); ?></td>
                                        <td class="text-right">$<?php echo $value["Total_Admin"];?></td>
                                        <td><?php
                                            if($value["Status_Owner"] == 0 ) echo "Wait";
                                            else  echo "Paid";
                                        ?></td>
                                        <td><?php echo ($value["Createdat_Owner"] == null || $value["Createdat_Owner"] == "0000-00-00 00:00:00") ? "" : date("m/d/Y", strtotime( $value["Createdat_Owner"])); ?></td>
                                        <td>
                                            <?php if ($value["Status_Order"] == 1 && $value["Status_Owner"] == 0) : ?>
                                                <a href="<?php echo $payment_url."/".$value["Order_ID"]; ?>">Payment</a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <?php echo $this->pagination->create_links();?>
                    </div>
                </div>
            </div>        
        </div> 
    </main>
</div>