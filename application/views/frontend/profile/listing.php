<?php $this->load->view('frontend/profile/nav'); ?>
<div class="container page-container">
    <div id="primary" class="content-area row">
        <aside id="aside" class="site-aside col-sm-3">
            <?php $this->load->view('frontend/profile/sidebar'); ?>
        </aside>
        <main id="main" class="site-main col-sm-9" role="main">
            <div class="panel panel-default">
                <div class="panel-heading">Your Listing</div>
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
                                    <th>Address</th>
                                    <th>Image</th>
                                    <th>Price</th>
                                    <th>Day(s) left</th>
                                    <th>Renew</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (isset($collections) && $collections != null) : ?>
                                    <?php foreach ($collections as $key => $item): ?>  
                                        <tr>
                                            <td><?php echo $key+1; ?></td>
                                            <td><?php echo $item['Name']; ?></td>
                                            <td><img width="60" src="<?php echo $item['HeroImage']; ?>" ></td>
                                            <td><?php echo $item['Price']; ?></td>
                                            <td>
                                                <?php  
                                                if( $item['DayLeft'] < 1 ){
                                                	echo '<span style="color: red;">';
                                                }
                                                echo $item['DayLeft'] . ' day(s) left'; 
                                                if( $item['DayLeft'] < 1 ){
                                                	echo '</span>';
                                                }
                                                ?>
                                            </td>
                                            <td>
                                            <?php 
	                        					if ($item['ListingType'] == "Pre-MLS") {
	                        						echo "";
	                    						} else {
	                                                if (intval($item['DayLeft']) <= 0) {
	                                                    ?><a href="<?php echo base_url('/profile/extendlisting/'.$item['ID']); ?>" onclick="return confirm('Are you sure you want to renew?');">Renew</a><?php
	                                                } else {
	                                                    echo '<a href="#" style="color:#999;cursor:normal;">Renew</a>';
	                                                }
	                                            }
                                            ?>
                                            </td>
                                            <td>
                                                <a href="<?php echo base_url('/profile/editlisting/'.$item['ID']); ?>">Edit</a> | 
                                                <a href="<?php echo base_url('/profile/dellisting/'.$item['ID']); ?>" onclick="return confirm('Do you really want to delete?');">Delete</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 text-center">
                            <?php echo $this->pagination->create_links();?>
                        </div>
                    </div>
                </div>        
            </div> 
        </main>
    </div>
</div>