<?php
if(!empty($product['Price'])):
    $commission_type = $product['Commission_Type'];
    $commission = $product['Commission'];
    if ($commission_type == 'Percent' && (!is_numeric($commission) || $commission > 100 || $commission < 0)) {
        $commission = 0;
    }
    $commission_label = '';
    if ($commission_type == 'Percent') {
    	$offered = $product['Price'] * $commission/100;
    	$commission_label = '(' . $commission . '%)';
    } else {
    	$offered = $commission;
    }
    $fee     = $product['Price'] * 0.25/100;
    $deposit = $product['Price'] * 3/100;
    $total   = $product['Price'] + $offered;
endif;
?> 
<div class="container">
    <div class="site-content">
        <?php if(!empty($product['SlideImage'])):?>
            <?php 
                $slider = json_decode($product['SlideImage']);
                if (is_array($slider) && count($slider) > 0) :
            ?>
                <ul id="bxslider" class="bxslider listing-slider">
                    <?php 
                        foreach($slider as $slide){
                            echo '<li><a class="fancybox-thumb" rel="fancybox-thumb" href ="'.$slide.'" class="bg-main-slider-image"><img src="'.$slide.'"></a></li>';
                        }
                    ?>
                </ul>           
            <?php endif; ?> 
        <?php endif; ?>
        <div class="listing-detail" id="listing">
            <div class="row">
                <div class="col-sm-4">
                    <div class="row">
                        <div class="col-sm-12"><h4>Summary</h4></div>
                    </div>
                   	<div class="row">
                        <div class="col-sm-8">
                            <?php if(!empty($product['Address'] || $product['City'] || $product['State'] || $product['Zipcode'])):?>
                                <p class="meta-main address">
                                    <?php echo strtolower($product['Address'] . '<br/>' . $product['City'].' '.$product['State'].' '.$product['Zipcode']); ?>
                                </p>
                            <?php endif; ?> 
                        	<p class="meta-main address">
                            <?php if(!empty($product['APN'])){?>
                            	APN: <?php echo $product['APN'];?>
                            <?php } ?>
                            <?php if(!empty($product['County'])){?>
                                <br/>County: <?php echo getListCounty($product['County'],true,$product['Region']); ?>
                            <?php } ?>
                            </p>
                        </div>
                        <div class="col-sm-4 text-right">
                            <p class="meta-main address">
                               <a target="_blank" href="https://www.google.com/maps/place/<?php echo strtolower($product['Address'] . ',' . $product['City'].' '.$product['State'].' '.$product['Zipcode']);?>">Google Map</a>  
                            </p>
                        </div>
                    </div>
                     <?php if(!empty($product['Summary'])):?>
                        <div class="meta-sumary">
                            <?php echo @$product['Summary']; ?>
                        </div>
                    <?php endif; ?> 
                    
                    <?php if(!empty($product['Detail'])):?>
                    <h4 style="font-size: 10pt;font-weight: bold;">Property Details</h4>
                        <div class="meta-details" style="text-align: justify;">
                            <?php echo @$product['Detail']; ?>
                        </div>
                    <?php endif; ?>
                    <?php // if(@$is_login):?>
                    <form method="post" id="form-favorites" action="<?php echo base_url("profile/add_favorite")?>">
                        <div class="row">
                            <input type="hidden" name="Listing_ID" value="<?php echo $product['ID'];?>">
                            <input type="hidden" name="ID" value="<?php echo @$favorite['ID'];?>">
                        	<input type="hidden" name="ID_SAVE_LISTING" value="<?php echo @$listing_save['ID'];?>">
                            <div class="col-md-4"><label style="font-size: 10pt;font-weight: bold;">My Favorites</label></div>
                            <div class="col-md-8">
                                <label>
                                    <input type="checkbox" name="is_save" <?php echo (@$favorite) ? "checked" : "";?>/><span style="margin-left: 10px;margin-top: 0px;float: right;">(check to add)</span>
                                </label>
                            </div>  
                        </div>   
                        <div class="row">
                            <div class="col-md-4"><label style="font-size: 10pt;font-weight: bold;">My Value</label></div>
                            <div class="col-md-8"><input class="form-control number" style="width: 100%;" type="text"  step="1" min="0" value="<?php echo (!isset($listing_save["Price"]) || empty($listing_save["Price"]) || $listing_save["Price"] <= 0 ? "" : "$".number_format($listing_save["Price"]) )?>" placeholder="$" name="Price" /></div>
                        </div> 
                        <div class="row">
                            <div class="col-md-12"><label style="font-size: 10pt;font-weight: bold;">My Comments</label></div>
                            <div class="col-md-12">
                                <textarea name="Comment" id="favorites-comment" class="form-control" rows="5" maxlength="500"><?php echo (@$listing_save["Comment"])?></textarea>
                            </div> 
                        </div> 
                        <div class="row">
                            <div class="col-md-12 item"><button id="favorites-save" class="btn btn-default btn-lg" type="submit">Save</button></div>
                        </div>
                    </form>
                    <?php //endif; ?> 
                </div>
                <div class="col-sm-5">
                    <h4>Terms</h4>
                    <?php if(!empty($product['Price'])):?>
                        <p class="meta-price">
                            Listing Price:<br>
                            <strong>$<?php echo number_format($product['Price']); ?></strong>
                        </p>
                        <?php if (@$is_estate == 1) : ?>
                        	
                            <p class="meta-price">
                                Commission Offered: (added to listing price)<br>
                                <strong>$<?php echo number_format($offered); ?> <?php echo $commission_label; ?></strong>
                            </p>
                            <p class="meta-price">
                                Final Price:<br>
                                <strong>$<?php echo number_format($total); ?></strong>
                            </p>
                        <?php endif?>
                        <p class="meta-price">
                            Earnest Money Deposit:<br>
                            <strong>$<?php echo number_format($deposit); ?> (3%)</strong>
                        </p>
                        <p class="meta-price">
                            Title Company:<br>
                            <strong><?php 
                                echo getDetailWebSetting('Title',@$product['Insurance_Company']);
                            ?></strong>
                        </p>
                        <p class="meta-price">
                            Escrow Company:<br>
                            <strong><?php 
                                echo getDetailWebSetting('Escrow',@$product['Escrow_Company']);
                            ?></strong>
                        </p>
                        <p class="meta-price">
                            Showing Instructions:<br>
                            <strong><?php 
                                echo @$product['Showing_Instructions']
                            ?></strong>
                        </p>
                       
                    <?php endif; ?>  
                    <p><a href="<?php echo base_url('page/term-of-user'); ?>"><i>Terms and condition</i></a></p>
                    <?php
                        if(@$is_estate == 1){
                            echo '<p><i>“If your property is currently listed with a Realtor, please disregard this notice. It is not our intention to solicit the offerings of other Brokers.”</i></p>';
                            echo '<p><i>“Do not contact me with unsolicited offers or services”</i></p>';
                        }else{
                            echo "<i>“Do not contact me with unsolicited services or offers”</i>";
                        }
                    ?>
                    <div class="btn-holder" id="payment_block" style="margin-top: 30px;">
                        <?php if (isset($is_login) && $is_login): ?>
                            <a class="btn btn-primary btn-lg btn-largest bnt-payment" href ="javascript:;" data-href="/payment/index/<?php echo $product["ID"]; ?>?type=buynow" style="margin-right:30px;">Buy Now</a>
                            <a class="btn btn-primary btn-lg btn-largest bnt-payment" href ="javascript:;" data-href="/payment/index/<?php echo $product["ID"]; ?>/?type=offer">Offer</a>
                        <?php else :?>
                            <a class="btn btn-primary btn-lg btn-largest" href ="javascript:;" data-href="#" onclick="javascript: $('#ModalLogin #redirect').val('/payment/index/<?php echo $product["ID"]; ?>?type=buynow'); $('#ModalLogin').modal('show'); return false;" style="margin-right:30px;">Buy Now</a> <a class="btn btn-primary btn-lg btn-largest"  href="#" onclick="javascript: $('#ModalLogin #redirect').val('/payment/index/<?php echo $product["ID"]; ?>?type=offer'); $('#ModalLogin').modal('show'); return false;">Offer</a>
                        <?php endif; ?>
                        <p style="margin-top: 20px;"><label class="label-control" style="font-size: 10pt;font-weight: bold; text-align: justify;"><input type="checkbox" id="Allow_Commission" <?php if ($product["Allow_Commission"] == 0 OR TRUE) {  ?> value="0" <?php } else { ?> value="1" checked <?php } ?>  > I would like to hire a real estate agent to help me through my transaction for a minimal fee.</label></p>
                        <script type="text/javascript">
                            $("#payment_block .btn-largest.bnt-payment").click(function(){
                                var allow = 0;
                                if($("#payment_block #Allow_Commission").is(":checked")){
                                    allow = 1;
                                }
                                var url = $(this).attr("data-href") + "&allow="+allow;
                                location.href = url;
                                return false;
                            })
                        </script>
                        <p style="font-size: 10pt; text-align: justify;"><i>BUY NOW - Buyer locks in a property, no negotiations necessary.  Buyer agrees to purchase the property at the price and terms as listed.  This listing will be considered sold and removed from our site. </i></p> 
                        <p style="font-size: 10pt;text-align: justify;"><i>OFFER - Buyer can make a offer indicating his desired price and terms.  The seller will receive this offer and can counter or accept the buyers offer.  This property will continue to be listed for sale until the seller accepts the buyers offer, or accepts an offer from another buyer.</i></p> 
                    </div>
                </div>
                <div class="col-sm-3">
                	<h4>Seller Details:</h4>
                	<?php if (@$member["Is_Estate_License"] == 1) : ?>
                	<p>
                		Real Estate Licensee<br>
						Lic. No. <?php echo @$member["Estate_License"]; ?><br/>
						Member Since <?php echo date("m/d/Y", strtotime(@$member["Create_At"])); ?>
					</p>
					<?php else : ?>
					<p>Private Seller</p>
					<p>Member Since <?php echo date("m/d/Y", strtotime(@$member["Create_At"])); ?></p>
					<?php endif; ?>
                	<br/>
                    <p><b>Message Seller</b>:</p>
                    <form method="post" id="form-favorites" action="<?php echo base_url("home/send_message")?>">
                        <?php if (!@$is_login): ?>
                            <div class="row">
                                <div class="col-md-12"><label style="font-size: 10pt;font-weight: bold;">Your Name</label></div>
                                <div class="col-md-12"><input type="text" class="form-control required" value="" name="Full_Name"></div>
                            </div>
                            <div class="row">
                                <div class="col-md-12"><label style="font-size: 10pt;font-weight: bold;">Your Email</label></div>
                                <div class="col-md-12"><input type="email" class="form-control required" value="" name="Email"></div>
                            </div>
                            <?php endif;?>
                        <div class="row">
                            <input type="hidden" name="Listing_ID" value="<?php echo $product['ID'];?>">
                            <div class="col-md-12"><label style="font-size: 10pt;font-weight: bold;">Subject</label></div>
                            <div class="col-md-12">
                                <input type="text" name="Subject" class="form-control" required="true"> 
                            </div>  
                        </div>   
                        <div class="row">
                            <div class="col-md-12"><label style="font-size: 10pt;font-weight: bold;">Message</label></div>
                            <div class="col-md-12">
                                <textarea name="Message" id="favorites-comment" class="form-control" rows="5" maxlength="500" required="true"></textarea>
                            </div>  
                        </div> 
                        <div class="row text-right">
                            <div class="col-md-12 item"><button id="favorites-save" class="btn btn-default btn-lg" type="submit">Send</button></div>
                        </div>
                    </form>
                    <?php if (!@$is_login): ?>
                    	<p align="right"><a href ="javascript:;" data-href="#" onclick="javascript: $('#ModalLogin #redirect').val('/listing/<?php echo $product["ID"]; ?>'); $('#ModalLogin').modal('show'); return false;">Report Seller</a></p>
                    <?php else : ?>
                    	<p align="right"><a href="?rep=true" onclick="return confirm('Are you sure you want to report this seller?');">Report Seller</a></p>
                    <?php endif; ?>
                    
                    <?php $this->load->view('frontend/profile/contact-info'); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<style type="text/css">
    .address{
        text-transform: capitalize;
    }
    .listing-detail p ,.meta-details{
        font-size: 10pt !important;
    }
    .bx-wrapper{margin : 10px auto !important;}
    #bxslider li{
        display: inline-block;
        width: 25%;
        padding: 0.5%
    }
    #bxslider li img{
        max-width: 100%;
        height: 280px;
        object-fit: cover;

    }
    @media screen and (max-width: 768px){
    	#bxslider li{
	        display: inline-block;
	        width: 50%;
	        padding: 0.5%
	    }
    }
    @media screen and (max-width: 420px){
    	#bxslider li{
	        display: inline-block;
	        width: 100%;
	        padding: 0.5%
	    }
	    #bxslider li img{
	        max-width: 100%;
	        height: auto;
	        object-fit: cover;

	    }
    }
</style>
<script type="text/javascript" src="<?php echo skin_url("js/fancybox/jquery.mousewheel.pack.js");?>"></script>
<link rel="stylesheet" type="text/css" href="<?php echo skin_url("js/fancybox/jquery.fancybox.css")?>">
<script type="text/javascript" src="<?php echo skin_url("js/fancybox/jquery.fancybox.pack.js")?>"></script>
<!-- Optionally add helpers - button, thumbnail and/or media -->
<link rel="stylesheet" href="<?php echo skin_url("js/fancybox/helpers/jquery.fancybox-buttons.css?v=1.0.5");?>" type="text/css" media="screen" />
<script type="text/javascript" src="<?php echo skin_url("js/fancybox/helpers/jquery.fancybox-buttons.js?v=1.0.5");?>"></script>
<script type="text/javascript" src="<?php echo skin_url("js/fancybox/helpers/jquery.fancybox-media.js?v=1.0.6");?>"></script>
<link rel="stylesheet" href="<?php echo skin_url("js/fancybox/helpers/jquery.fancybox-thumbs.css?v=1.0.7");?>" type="text/css" media="screen" />
<script type="text/javascript" src="<?php echo skin_url("js/fancybox/helpers/jquery.fancybox-thumbs.js?v=1.0.7");?>"></script>
<script type="text/javascript">
    $(document).ready(function() {
		<?php if (!@$is_login): ?>
			$('.listing-detail input[type="submit"],.listing-detail button[type="submit"]').attr('disabled','disabled');
			$('.listing-detail input[type="submit"],.listing-detail button[type="submit"]').click(function () {
				return false;
			});
			$('.listing-detail input,.listing-detail textarea').focus(function () {
				$("#ModalLogin #redirect").val(window.location.href);
				$("#ModalLogin").modal('show');
				return false;
			});
		<?php endif; ?>
    	
    	<?php if (isset($_GET["after"])) : ?>
    		alert('Your message has been sent to the Seller.\rPlease check your email for any response.');
    	<?php endif; ?>
        function cover_main_image(){
            $('.bg-main-slider-image').stop().each(function(){
                var current_width = $(this).outerWidth();
                var height = (current_width*3)/4;
                $(this).height(height);
            });
        }
        //cover_main_image();
        $(window).resize(function(){
           // cover_main_image();
        });
        $(".fancybox-thumb").fancybox({
            prevEffect  : 'none',
            nextEffect  : 'none',
            helpers : {
                title   : {
                    type: 'outside'
                },
                thumbs  : {
                    width   : 100,
                    height  : 100
                }
            }
        });
    });
    
    $('input[name="Price"]').blur(function () {
		var val = $(this).val();
		val = get_only_number(val);
		if (val != "" && !is_number(val)) {
			$(this).addClass('border-error');
			return false;
		}
		if (is_number(val)) {
			$(this).val(format_currency(val));
		}
	});
</script>