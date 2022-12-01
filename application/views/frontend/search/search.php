<div class="container-fluid page-container">
    <div class="home-search" style="margin:0;margin-top: -25px;">
         <form action="<?php echo base_url(); ?>home/search" method="get">
            <div class="row row-eq-height-sm">
                <div class="col-sm-4 form-group-outer">
                    <div class="form-group form-group-location">
                        <label for="location">Location</label>
                        <input type="text" class="form-control" value="<?php echo @$_GET['location']; ?>" name="location" id="location" placeholder="Destination, city, address">
                    </div>
                </div>
                <div class="col-sm-4 form-group-outer">
                    <div class="form-group">
                        <label for="time">Anytime (Check in - Check out)</label>
                        <div class="form-group">
                            <input type="text" class="form-control" name="daterange" value="" required="required" />
                        </div>
                    </div>
                </div>
                <div class="col-sm-2 form-group-outer">
                    <div class="form-group form-group-location">
                        <label for="location">Guests</label>
                        <select class="form-control" name="adults">
                            <?php for ($i = 1; $i <= 10; $i++): ?>
                                <option <?php if(@$_GET['adults'] == $i) echo 'selected'; ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                </div>
                <div class="col-sm-2 form-group-outer">
                    <div style="height:10px;"></div>
                    <div class="form-group form-group-number">
                        <button id="home-search-sumbit" class="btn btn-secondary" type="submit">Search</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="row">
        <main id="main" class="site-main col-md-7" role="main">
            <div class="list-listing">
                <div class="row">
                    <?php $location = ''; ?>
                    <?php if(isset($result) && $result != null): ?>
                        <?php foreach ($result as $key => $product): ?>
                            <?php $location .= "['".addslashes($product['Name'])."','".$product['Slug']."','".$product['Latitude']."','".$product['Longitude']."'],"; ?>
                            <div class="col-sm-6">
                                <div class="block-content">
                                    <div class="block-content-img">
                                        <a href="<?php echo base_url(); ?>home/detail/<?php echo @$product['Slug']; ?>">
                                            <div class="bg-product" style="background-image:url('<?php echo @$product['Thumb']; ?>');"></div>
                                        </a>
                                    </div>
                                    <div class="block-content-text">
                                        <h3><a href="<?php echo base_url(); ?>home/detail/<?php echo @$product['Slug']; ?>"><?php echo @$product['Name']; ?></a></h3>
                                        <strong><span><?php echo @$product['Price']; ?> USD / <?php echo @$product['Product_Unit'] == 0 ? 'Day' : 'Hour'; ?></span></strong> 
                                        <br> <?php echo @$product['Address']; ?>
                                        <div class="rating">
                                            <?php $rating = @$product['Average_Rating']; ?>
                                            <?php for($i = 1;$i <= 5; $i++): ?>
                                                <?php if($i <= $rating): ?>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                <?php else: ?>
                                                    <i class="fa fa-star-o" aria-hidden="true"></i>
                                                <?php endif; ?>
                                            <?php endfor; ?>
                                            <?php echo @$product['Total_Rating']; ?> reviews
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php if( ($key+1)%2 == 0 ): ?>
                                </div><div class="row">
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <h3 style="padding-left:20px;">Not Found.</h3>
                    <?php endif; ?>
                </div>
            </div>
            <nav class="text-right nav-pagination">
               <?php echo $this->pagination->create_links(); ?>
            </nav>
        </main>
        <aside class="map-area col-md-5">
            <div id="map"></div>
        </aside>
    </div>
</div>

<script type="text/javascript">
    var locations = [
        <?php echo @$location; ?>
    ];
    var center_lat = 43.253205;
    var center_lng = -80.480347;
    if(locations.length > 0){
        center_lat = locations[0][2];
        center_lng = locations[0][3];
    }
    var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 3,
        center: new google.maps.LatLng(center_lat,center_lng),
        mapTypeId: google.maps.MapTypeId.ROADMAP
    });

    var infowindow = new google.maps.InfoWindow();
    var geocoder = new google.maps.Geocoder();

    var marker, i;

    for (i = 0; i < locations.length; i++) {
         var html = '<a href="'+base_url+'home/detail/'+locations[i][1]+'">' + locations[i][0] + '</a>';
         createMarker(locations[i][2],locations[i][3],html);
    }

    function createMarker(lat,lng,html){
        var myLatlng = new google.maps.LatLng(lat,lng);
        var marker = new google.maps.Marker({
            position: myLatlng,
            map: map
        }); 
        google.maps.event.addListener(marker, 'click', function() {
            map.setOptions({draggable: true});
            infowindow.setContent(html);
            infowindow.open(map, marker);
        });
    }
</script>
<script>
    $(document).ready(function(){
        $('.site-main > .page-container').addClass('page-search-results');
    });
</script>
<style type="text/css">
    .site-footer{display: none;}
</style>