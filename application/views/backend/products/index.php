<div class="row">
    <main id="main" class="site-main col-sm-12" role="main">
        <div class="panel panel-default">
            <div class="panel-heading">Listings</div>
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
                                <th>Name</th>
                                <th>Image</th>
                                <th>Price</th>
                                <th>Capacity</th>
                                <th>Address</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(isset($products) && $products != null): ?>
                                <?php foreach ($products as $key => $product): ?>  
                                    <tr>
                                        <td><?php echo $key+1; ?></td>
                                        <td><?php echo $product['Name']; ?></td>
                                        <td><img width="60" src="<?php echo $product['Image']; ?>" ></td>
                                        <td><?php echo $product['Price']; ?></td>
                                        <td><?php echo @$product['Capacity']; ?></td>
                                        <td><?php echo $product['Address']; ?></td>
                                        <td>
                                            <a href="<?php echo base_url('/backend/products/edit/'.$product['ID']); ?>">Edit</a> | 
                                            <a href="<?php echo base_url('/backend/products/delete/'.$product['ID']); ?>" onclick="return confirm('Do you really want to delete?');">Delete</a>
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