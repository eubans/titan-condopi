<?php $this->load->view('frontend/profile/nav'); ?>
<div class="container page-container">
    <div id="primary" class="content-area row">
        <aside id="aside" class="site-aside col-sm-3">
            <?php $this->load->view('frontend/product/sidebar'); ?>
        </aside>
        <main id="main" class="site-main col-sm-9" role="main">
            <form method="post" action="" enctype="multipart/form-data">
                <div class="panel panel-default">
                    <div class="panel-heading"><?php echo @$title; ?></div>
                    <div class="panel-body">
                        <?php 
                            if($this->session->flashdata('message')){
                                echo  $this->session->flashdata('message');
                            }
                        ?>
                        <div class="form-group">
                            <label  class="control-label">Name</label>
                            <input type="text" class="form-control required" value="<?php echo @$product['Name']; ?>" name="name">
                        </div>
                        <div class="form-group">
                            <label  class="control-label">Content</label>
                            <textarea name="content" rows="10" class="form-control"><?php echo @$product['Description']; ?></textarea>
                        </div>
                        <div class="form-group">
                            <label  class="control-label">Image</label>
                            <input type="file" name="picture" accept="images/*">
                        </div>
                        <div class="form-group">
                        	<label class="control-label">Gallery</label>
                        	<input type="file" id="upload_file" name="upload_file[]" onchange="preview_image();" multiple/>
                        	<div id="image_preview"></div>
                        </div>
                        <div class="form-group">
                            <label  class="control-label">Price</label>
                            <input type="number" class="form-control required" step="0.01" min="0" value="<?php echo @$product['Price']; ?>" name="price">
                        </div>
                        <div class="form-group">
                            <label  class="control-label">Amenities</label>
                            <select class="form-control required" name="attribute[]" id="attribute" multiple="multiple">
                                <?php if(isset($attribute) && $attribute != null): ?>
                                   <?php foreach ($attribute as $key => $item): ?>
                                       <?php 
                                            $select = '';
                                            if(isset($attribute_product) && $attribute_product != null){
                                                foreach ($attribute_product as $key => $item1) {
                                                    if($item1['Attribute_ID'] == $item['ID'])
                                                    {
                                                        $select = 'selected';
                                                        break;
                                                    }
                                                }
                                            }
                                       ?>
                                       <option value="<?php echo $item['ID']; ?>" <?php echo $select; ?>><?php echo $item['Name']; ?></option>
                                   <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                        <!--
                        <div class="form-group">
                            <label  class="control-label">Category</label>
                            <select class="form-control required" name="category[]" id="category" multiple="multiple">
                                <?php //if(isset($category) && $category != null): ?>
                                   <?php //foreach ($category as $key => $item): ?>
                                       <?php 
                                            //$select = '';
                                            /*if(isset($category_product) && $category_product != null){
                                                foreach ($category_product as $key => $item1) {
                                                    if($item1['Category_ID'] == $item['ID'])
                                                    {
                                                        $select = 'selected';
                                                        break;
                                                    }
                                                }
                                            }*/
                                       ?>
                                       <option value="<?php //echo $item['ID']; ?>" <?php //echo $select; ?>><?php //echo $item['Name']; ?></option>
                                   <?php //endforeach; ?>
                                <?php //endif; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label  class="control-label">Unit</label>
                            <select class="form-control required" name="unit">
                                <option value="0">Day</option>
                                <option value="1" <?php echo @$product['Product_Unit'] == 1 ? 'selected' : ''; ?>>Hour</option>
                            </select>
                        </div>-->
                        <div class="form-group">
                            <label  class="control-label">Capacity</label>
                            <input type="number" class="form-control required" min="0" name="capacity" value="<?php echo @$product['Capacity']; ?>">
                        </div>
                        <div class="form-group">
                            <label class="control-label">Address</label>
                            <input type="text" class="form-control required" onblur="checkLatLng()" id="address-from" value="<?php echo @$product['Address']; ?>" name="address">
                            <input type="hidden" id="city" name="city" value="<?php echo @$city['Name'] ?>">
                            <input type="hidden" id="city_code" name="city_code" value="<?php echo @$city['Code'] ?>">
                            <input type="hidden" id="longitude" name="longitude" value="<?php echo @$product['Longitude']; ?>">
                            <input type="hidden" id="latitude" name="latitude" value="<?php echo @$product['Latitude']; ?>">
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-md btn-secondary">Save</button>
            </form>
        </main>
    </div>
</div>
<link href="<?php echo skin_url(); ?>/frontend/css/bootstrap-multiselect.css" rel="stylesheet">
<script src="<?php echo skin_url(); ?>/frontend/js/tinymce/js/tinymce/tinymce.min.js"></script>
<script src="<?php echo skin_url(); ?>/frontend/js/bootstrap-multiselect.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#category').multiselect();
        $('#attribute').multiselect();
        $("form").submit(function(){
        	$(".custom-loading").show();
        	return false;
        });
    });
</script>
<script type="text/javascript">
	function preview_image() {
		var total_file=document.getElementById("upload_file").files.length;
		for(var i = 0; i < total_file; i++){
		    $('#image_preview').append("<img src='" + URL.createObjectURL(event.target.files[i]) + "'><br>");
		}
	}
</script>
<script type="text/javascript">
    //google sugget api address
    var placeSearch, autocomplete;
    var address_val = $("#address-from").val();
    function initAutocomplete() {
         var options = {
              types: ['geocode'],
              componentRestrictions: {country: "us"}
         };
         autocomplete = new google.maps.places.Autocomplete((document.getElementById('address-from')),options);
         google.maps.event.addListener(autocomplete, 'place_changed', function () {
            var place = autocomplete.getPlace();
            //console.log(place);
            $("#latitude").val(place.geometry.location.lat());
            $("#longitude").val(place.geometry.location.lng());
            $("#city_code").val(place.address_components[0].short_name);
            $("#city").val(place.address_components[0].long_name);
        });
    }
    function checkLatLng(){
        var place = autocomplete.getPlace();
        var val = $("#address-from").val();
        if(typeof place == 'undefined'){
            if(address_val != val && val != ''){
                $("#address-from").val('');
                $("#latitude").val('');
                $("#longitude").val('');
            }
        }
    }
    // Bias the autocomplete object to the user's geographical location,
    // as supplied by the browser's 'navigator.geolocation' object.
    function geolocate() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                var geolocation = {
                  lat: position.coords.latitude,
                  lng: position.coords.longitude
                };
                var circle = new google.maps.Circle({
                  center: geolocation,
                  radius: position.coords.accuracy
                });
                autocomplete.setBounds(circle.getBounds());
           });
        }
    }
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyChZuQoIe7J47ya4cJSa1gXMLYEJT56jrk&libraries=places&callback=initAutocomplete" async defer></script>
<script type="text/javascript">
    tinymce.init({ selector:'textarea' });
</script>