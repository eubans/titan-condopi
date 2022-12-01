<div class="container">
	<div class="row">
    	<div class="col-sm-10 col-sm-offset-1">
		    <div class="row">
		    	<div class="col-sm-8">
		    		<form method="post" action="">
		    			<div class="panel panel-default">
		                    <div class="panel-heading">Contact Us</div>
		                    <div class="panel-body">
		                        <?php 
		                            if ($this->session->flashdata('message')) {
		                                echo  $this->session->flashdata('message');
		                            }
		                        ?>
		                        <div class="form-group">
		                            <label class="control-label">Your Name</label>
		                            <input type="text" class="form-control not-radius bg-f2f2f2 required" value="<?php echo @$_POST['full_name']; ?>" name="full_name" placeholder="Your Name">
		                        </div>
		                        <div class="form-group">
		                            <label class="control-label">Your Email</label>
		                            <input type="email" class="form-control not-radius bg-f2f2f2 required" value="<?php echo @$_POST['email']; ?>" name="email" placeholder="Your Email">
		                        </div>
		                        <div class="form-group">
		                            <label class="control-label">Subject</label>
		                            <input type="text" class="form-control not-radius bg-f2f2f2 required" value="<?php echo @$_POST['subject']; ?>" name="subject" placeholder="Subject">
		                        </div>
		                        <div class="form-group">
		                            <label  class="control-label">Message</label>
		                            <textarea name="message" rows="5" maxlength="140" placeholder="Message" class="form-control not-radius bg-f2f2f2 required"><?php echo @$_POST['message']; ?></textarea>
		                        </div>
		                    </div>
		                </div>
		                <button type="submit" class="btn btn-md btn-secondary">Save</button>
		    		</form>
		    	</div>
		        <div class="col-sm-4">
		        	<div class="panel_box">
		            	<?php $this->load->view('frontend/profile/contact-info'); ?>
		            </div>
		        </div>
			</div>
		</div>
    </div>
</div>
<style type="text/css">
    .page-title{position: relative;margin-bottom: 20px;}
    .page-content{padding-bottom: 30px;}
    button.btn-secondary {
        width: 25%;
        background: #f12a53;
        border: none;
        height: 41px;
        text-transform: uppercase;
        color: #fff;
        border-radius: 0;
    }
    .form-control{
        border-radius: 0;
    }
    body div {
        font-family: 'Libre Franklin' !important;
    }
</style>

<script type="text/javascript">
    $('#page-title').html('<?php echo @$page['Title']; ?>');
</script>