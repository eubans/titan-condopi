<?php $this->load->view('frontend/admin/nav'); ?>
<div class="container page-container">
    <div id="primary" class="content-area row">
        <aside id="aside" class="site-aside col-sm-3">
            <?php $this->load->view('frontend/admin/sidebar'); ?>
        </aside>
        <main id="main" class="site-main col-sm-9" role="main">
            <form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
                <div class="panel panel-default">
                    <div class="panel-heading">Send mail to client</div>
                    <div class="panel-body">
                        <?php 
                            if($this->session->flashdata('message')){
                                echo  $this->session->flashdata('message');
                            }
                        ?>
                        <div class="form-group row">
                            <div class="col-md-12"><label style="font-size: 10pt;font-weight: bold;">To Email</label></div>
                            <div class="col-md-12"><input type="email" class="form-control required" value="" name="email"></div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12"><label style="font-size: 10pt;font-weight: bold;">Subject</label></div>
                            <div class="col-md-12">
                                <input type="text" name="subject" class="form-control" required="true"> 
                            </div>  
                        </div>   
                        <div class="form-group row">
                            <div class="col-md-12"><label style="font-size: 10pt;font-weight: bold;">Message</label></div>
                            <div class="col-md-12">
                                <textarea name="message" class="form-control" rows="5" required="true"></textarea>
                            </div>  
                        </div> 
                        <div class="form-group text-right">
                            <div class="col-sm-12">
                                <button type="submit" class="btn btn-md btn-secondary">Send</button> 
                            </div>
                        </div>
                    </div>
                </div>
                
            </form>
        </main>
    </div>
</div>
