<?php $this->load->view('frontend/admin/nav'); ?>
<div class="container page-container">
    <div id="primary" class="content-area row">
       
        <main id="main" class="site-main col-sm-9" role="main">
            <form method="post" action="" enctype="multipart/form-data">
                <div class="panel panel-default">
                    <div class="panel-heading">Add New Listing</div>
                    <div class="panel-body">
                        <?php 
                            if ($this->session->flashdata('message')) {
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
                            <label  class="control-label">Main Photo</label>
                            <input type="file" id="heroimage" onchange="hero_preview_image();" name="heroimage" accept=".png,.jpg,.jpeg,.gif">
                            <div class="hereimage-review"></div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Photo Gallery <br><i>Holding down the CTRL key or the Shift key as you click a file, allows you to select more than one</i></label>
                            <input type="file" id="upload_file" name="upload_file[]" accept="images/*" onchange="preview_image();" multiple/>
                            <div id="image_preview" class="row" style="margin:0;"></div>
                        </div>
                        <?php if($member_expiry['Expiry_Date'] >= date("Y-m-d")) : ?>
                        <div class="form-group">
                            <label class="control-label">Video (for Prime Members)</label>
                            <input type="file" id="video" name="video" accept=".mp4,.avi,.wmv,.mov"><br />
                        </div>
                        
                        <div class="form-group">
                            <label class="control-label">Status: </label>
                            <select class="form-control required" name="Status">
                                <?php
                                    $status = [
                                        '1' => 'Actived',
                                        '0' => 'Inactive',
                                		'2' => 'Deleted'
                                    ];
                                ?>
                                <?php foreach ($status as $key => $value) {
                                    if(trim($this->input->get("status")) == trim($key))
                                        echo '<option value="'.$key.'" selected>'.$value.'</option>';
                                    else
                                        echo '<option value="'.$key.'">'.$value.'</option>' ;
                                }?>
                            </select>
                        </div>
                        
                        <div class="form-group" style="display:none;">
                            <label class="control-label">Youtube</label>
                            <input type="text" class="form-control" value="<?php echo @$product['Videos']; ?>" name="Videos_BK">
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
        <aside id="aside2" class="site-aside col-sm-3">
            <?php $this->load->view('frontend/profile/contact-info'); ?>
        </aside>
    </div>
</div>

<script src="<?php echo skin_url(); ?>/frontend/js/tinymce/js/tinymce/tinymce.min.js"></script>
<script type="text/javascript">
    function preview_image() {
        var total_file=document.getElementById("upload_file").files.length;
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
</script>
<script type="text/javascript">
    // tinymce.init({ selector:'textarea' });
    $('#page-title').html('Add New Listing');
</script>
<script type="text/javascript">
$(document).ready(function() {
	$('select[name="commission_type"]').change(function () {
		if ($(this).val() == '') {
			$('input[name="commission"]').val('');
		}
	});
	//$('select[name="state"]').val($('select[name="state"]').attr('data-value'));
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