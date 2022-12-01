<?php $this->load->view('frontend/profile/nav'); ?>
<div class="container page-container">
    <div id="primary" class="content-area row">
        <aside id="aside" class="site-aside col-sm-3">
            <?php $this->load->view('frontend/profile/sidebar'); ?>
        </aside>
        <main id="main" class="site-main col-sm-9" role="main">
            <form method="post" action="" enctype="multipart/form-data">
                <div class="panel panel-default">
                    <div class="panel-heading">Edit Listing</div>
                    <div class="panel-body">
                        <?php 
                            if($this->session->flashdata('message')){
                                echo  $this->session->flashdata('message');
                            }
                        ?>
                        <div class="form-group">
                            <label class="control-label">Type</label>
                            <select name="Type" class="form-control">
                                <option value="" selected="">--------   Please choose one  --------</option>
                                <?php echo getListType(@$product['Type']); ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label">City</label>
                            <select class="form-control" data-value="<?php echo @$product['City']; ?>" name="City">
                            	<option value="">--------   Please choose one  --------</option>
                            	<?php echo getListCounty(@$product['City']); ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label">District</label>
                            <select class="form-control" data-value="<?php echo @$product['County']; ?>" name="County">
                            	<option value="">--------   Please choose one  --------</option>
                            	<?php echo getListCity(@$product['County']); ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Property Address</label>
                            <input type="text" class="form-control required" value="<?php echo @$product['Address']; ?>" name="Address">
                        </div>
                        <div class="form-group">
                            <label  class="control-label">Price will be in Pesos ₱ (Please only enter numerical value and no decimals)</label>
                            <input type="number" class="form-control required number" step="1" min="0" value="<?php echo @$product['Price']; ?>" name="Price">
                        </div>
                        <div class="form-group">
                            <label class="control-label">Listing Type</label>
                            <select name="ListingType" class="form-control required">
                                <option value="" selected="">--------   Please choose one  --------</option>
                                <?php echo getListListingType(@$product['ListingType']); ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label  class="control-label">Listing Summary (140 Characters)<br/><i>Enter a brief summary of your listing including necessary information (ie. Beds, Baths, Sqft, Lot Size).</i></label>
                            <textarea name="Summary" rows="5" maxlength="140" class="form-control"><?php echo @$product['Summary']; ?></textarea>
                        </div>
                        <div class="form-group">
                            <label  class="control-label">Property Details<br><i>Enter a comprehensive description of the property.</i></label>
                            <textarea name="Detail" rows="10" class="form-control"><?php echo @$product['Detail']; ?></textarea>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Showing Instructions</label>
                            <textarea name="Showing_Instructions" rows="3" class="form-control"><?php echo @$product['Showing_Instructions']; ?></textarea>
                        </div>
                        <div class="form-group">
                            <label  class="control-label">Image</label>
                            <input type="file" id="heroimage" onchange="hero_preview_image();" name="heroimage" accept="images/*">
                            <div class="hereimage-review">
                                <?php if(isset($product['HeroImage']) && $product['HeroImage'] != null): ?>
                                    <img src="<?php echo $product['HeroImage']; ?>" style="height:100px;width:auto;margin-top:10px;margin-right:10px;">
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Gallery</label>
                            <input type="file" id="upload_file" name="upload_file[]" accept="images/*" onchange="preview_image();" multiple/>
                            <div class="row" style="margin:0;">
                                <?php $gallery = json_decode(@$product['SlideImage'],true); ?>
                                <?php if(isset($gallery) && $gallery != null): ?>
                                    <?php foreach ($gallery as $key => $item): ?>
                                        <div style="float:left;position: relative;">
                                            <a href="#" class="remove-item-gallery" style="position: absolute;color: #ff0000;right: 15px;top: 10px;"><i class="fa fa-times" aria-hidden="true"></i></a>
                                            <img src="<?php echo $item; ?>" style="height:100px;width:auto;margin-top:10px;margin-right:10px;">
                                            <input type="hidden" name="gallery[]" value="<?php echo $item; ?>">
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                                <div id="image_preview"></div>
                            </div>
                        </div>
                        <?php if($member_expiry['Expiry_Date'] >= date("Y-m-d")) : ?>
                        <div class="form-group">
                            <label class="control-label">Video (for Prime Members)</label>
                            <input type="file" id="video" name="video" accept=".mp4,.avi,.wmv,.mov"><br />
                            <div class="row">
                            	<div class="col-sm-6">
		                            <select class="form-control" name="Videos">
		                            	<option value="">Delete this video</option>
		                            	<option value="no">No</option>
		                            	<option value="yes">Yes</option>
		                            </select>
		                    	</div>
		                    	<div class="col-sm-6">
		                            Video: <a target="_blank" href="<?php echo @$product['Videos']; ?>">View detail</a>
		                    	</div>
		                    </div>
                        </div>
                        <?php endif; ?>
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

<script src="<?php echo skin_url(); ?>/frontend/js/tinymce/js/tinymce/tinymce.min.js"></script>
<script type="text/javascript">
    function preview_image() {
        var total_file = document.getElementById("upload_file").files.length;
        $('#image_preview').html('');
        for(var i = 0; i < total_file; i++){
            $('#image_preview').append("<img style='float:left;height:100px;width:auto;margin-right:10px;margin-top:10px;' src='" + URL.createObjectURL(event.target.files[i]) + "'>");
        }
    }
    function hero_preview_image() {
        var total_file = document.getElementById("heroimage").files.length;
        for(var i = 0; i < total_file; i++){
            $('.hereimage-review').html("<img style='height:100px;width:auto;margin-right:10px;margin-top:10px;' src='" + URL.createObjectURL(event.target.files[i]) + "'>");
        }
    }
    $(document).ready(function(){
    	//$('select[name="state"]').val($('select[name="state"]').attr('data-value'));
        $('.remove-item-gallery').click(function(){
            $(this).parent().remove();
            return false;
        });
    });
</script>
<script type="text/javascript">
    // tinymce.init({ selector:'textarea' });
    $('#page-title').html('Edit Listing');
</script>
<script type="text/javascript">
$(document).ready(function() {
	$('select[name="commission_type"]').change(function () {
		if ($(this).val() == '') {
			$('input[name="commission"]').val('');
		}
	});
	
    $('input[type="text"]').attr('autocomplete','off');
    $('input[type="password"]').attr('autocomplete','off');
    $.fn.maxlength = function() {
        $('textarea[maxlength]').keypress(function(event) {
            var key = event.which;
            //all keys including return.
            if (key >= 33 || key == 13) {
                var maxLength = $(this).attr('maxlength');
                var length = this.value.length;
                if (length >= maxLength) {
                    event.preventDefault();
                }
            }
        });
    };
})
</script>