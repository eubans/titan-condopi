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
                        <?php if(isset($collections) && $collections != null): ?>
                            <h3><?php echo $collections[0]['Title']; ?></h3>
                            <h5><?php echo $collections[0]['Created_at']; ?></h5>
                            <?php echo $collections[0]['Content']; ?>
                        <?php endif; ?>
                    </div>
                </div>        
            </div> 
        </main>
    </div>
</div>