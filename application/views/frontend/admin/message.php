<?php $this->load->view('frontend/admin/nav'); ?>
<div class="container page-container">
    <div id="primary" class="content-area row">
        <aside id="aside" class="site-aside col-sm-3">
            <?php $this->load->view('frontend/admin/sidebar'); ?>
        </aside>
        <main id="main" class="site-main col-sm-9" role="main">
            <div class="panel panel-default">
                <div class="panel-heading">Message</div>
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
                                    <th>Title</th>
                                    <th>Created_at</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(isset($collections) && $collections != null): ?>
                                    <?php foreach ($collections as $key => $item): ?>  
                                        <tr>
                                            <td><?php echo $key+1; ?></td>
                                            <td><?php echo $item['Title']; ?></td>
                                            <td><?php echo $item['Created_at']; ?></td>
                                            <td>
                                                <a href="<?php echo base_url('/profile/viewmsg/'.$item['ID']); ?>">Detail</a> | 
                                                <a href="<?php echo base_url('/product/delmsg/'.$item['ID']); ?>" onclick="return confirm('Do you really want to delete?');">Delete</a>
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