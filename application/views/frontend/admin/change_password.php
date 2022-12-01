<?php $this->load->view('frontend/admin/nav'); ?>
<div class="container page-container">
    <div id="primary" class="content-area row">
        <aside id="aside" class="site-aside col-sm-3">
            <?php $this->load->view('frontend/admin/sidebar'); ?>
        </aside>
        <main id="main" class="site-main col-sm-9" role="main">
            <form class="form-horizontal" method="post" action="">
                <div class="panel panel-default">
                    <div class="panel-heading">Change Password</div>
                    <div class="panel-body">
                        <?php 
                            if($this->session->flashdata('message')){
                                echo  $this->session->flashdata('message');
                            }
                        ?>
                        <div class="form-group">
                            <label for="user_first_name" class="col-sm-3 control-label">Password <a><i class="fa fa-lock" aria-hidden="true"></i></a></label>
                            <div class="col-sm-9">
                                <input type="password" class="form-control required"  name="password">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="user_last_name" class="col-sm-3 control-label">Confirm Password <a><i class="fa fa-lock" aria-hidden="true"></i></a></label>
                            <div class="col-sm-9">
                                <input type="password" class="form-control required"   name="confirm_password">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12 text-right">
                                <button type="submit" class="btn btn-md btn-secondary">Save</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </main>
    </div>
</div>