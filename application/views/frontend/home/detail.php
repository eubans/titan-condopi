<?php
$commission_label = '';
$offered = 0;
$commission_type = '';
$fee     = 0;
$deposit = 0;
$total   = 0;
if(!empty($product['Price'])):
    $commission_type = $product['Commission_Type'];
    $commission = $product['Commission'];
    if ($commission_type == 'Percent' && (!is_numeric($commission) || $commission > 100 || $commission < 0)) {
        $commission = 0;
    }
    $commission_label = '';
    $offered = 0;
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
$listing_type = getDetailListingTypeSEO($product['ListingType']);
$disable_buynow = strtolower($listing_type) == 'auction' ? true : false;
?> 
<div class="detail-page <?php echo $listing_type; ?>">
<section class="section section-padding-b-30">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_box">
                    <div class="dispaly-table w-100 vertical-middle">
                        <div class="vertical-middle dispaly-table-cell w-100 top-info-listing">
                            <div class="row">
                                <div class="col-md-3 border-right">
                                    <p class="libre-franklin-regular font-s-14 color-2b2b33">Listing Price:</p> 
                                    <h1 class="libre-franklin-semiBold font-s-30 color-2b2b33 mr-t-0">₱<?php echo number_format($product['Price']); ?></h1>
                                </div>
    							<div class="col-md-3" style="padding-left:30px;">
                                    <p class="libre-franklin-regular font-s-14 color-f12a53">Google Map <a target="_blank" href="https://www.google.com/maps/place/<?php echo strtolower($product['Address'] . ',' . $product['County']);?>"><i class="fa fa-map-marker" aria-hidden="true"></i></a></p>
    								<div class="row">
    									<div class="col-xs-12 libre-franklin-regular font-s-14 color-2b2b33 mr-t-0"><b><?php echo ucfirst(strtolower($product["Address"])); ?></b></div>
    								</div>
                                </div>
    							<div class="col-md-3 border-left">
    								<p class="libre-franklin-regular font-s-14 color-2b2b33">&nbsp;</p>
    								<?php if (!empty($product['APN'])) : ?>
    								<div class="row">
    									<div class="col-xs-4 libre-franklin-regular font-s-14 color-2b2b33 mr-t-0">APN:</div>
    									<div class="col-xs-8 libre-franklin-regular font-s-14 color-2b2b33 mr-t-0"><b><?php echo $product['APN']; ?></b></div>
    								</div>
									<?php endif; ?>
									<div class="row">
    									<div class="col-xs-4 libre-franklin-regular font-s-14 color-2b2b33 mr-t-0">City:</div>
    									<div class="col-xs-8 libre-franklin-regular font-s-14 color-2b2b33 mr-t-0"><b><?php echo $product['County']; ?></b></div>
    								</div>
    								<?php if (!empty($product['City']) && $product['City'] != "None") : ?>
									<div class="row">
    									<div class="col-xs-4 libre-franklin-regular font-s-14 color-2b2b33 mr-t-0">District:</div>
    									<div class="col-xs-8 libre-franklin-regular font-s-14 color-2b2b33 mr-t-0"><b><?php echo $product['City']; ?></b></div>
    								</div>
    								<?php endif; ?>
                                </div>
                                <div class="col-md-3 col-xs-12">
                                    <div class="vertical-middle dispaly-table w-100">
                                        <div class="vertical-middle dispaly-table-cell w-100 h-90" id="payment_block">
											<?php if ((isset($is_login) && $is_login) || $disable_buynow): ?>
					                            <div class="sx-w-100 w-50 bnt-right" style="float:right;"><a class="btn bg-2b2b33 w-100 not-radius color-fff text-uppercase libre-franklin-bold font-s-16 bnt-payment <?php echo strtolower($listing_type); ?>" href ="javascript:;" data-href="/payment/index/<?php echo $product["ID"]; ?>/?type=offer">Offer</a></div>
					                        <?php else :?>
					                            <div class="sx-w-100 w-50 bnt-right" style="float:right;"><a class="btn bg-2b2b33 w-100 not-radius color-fff text-uppercase libre-franklin-bold font-s-16"  href="#" onclick="javascript: $('#ModalLogin #redirect').val('/payment/index/<?php echo $product["ID"]; ?>?type=offer'); $('#ModalLogin').modal('show'); return false;">Offer</a></div>
					                        <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php 
	$str_main_slide = '';
	$str_main_thumb_slide = '';
	if(!empty($product['SlideImage'])) {
    	$slider = json_decode($product['SlideImage']);
        if (is_array($slider) && count($slider) > 0) {
        	foreach($slider as $key => $slide) {
        		if (file_exists($_SERVER['DOCUMENT_ROOT'].$slide)) {
        			$str_main_thumb_slide .= '<a class="slide" href="javascript:;" data-slide-index="'.$key.'"><img src="'.$slide.'" alt=""></a>';
					list ($width, $height, $type, $attr) = getimagesize($_SERVER['DOCUMENT_ROOT'].$slide);
					if ($height >= $width) {
						$str_main_slide .= '<li><a class="fancybox-thumb" rel="fancybox-thumb" href ="'.$slide.'" class="bg-main-slider-image"><img src="'.$slide.'" alt=""></a></li>';
					} else {
						$str_main_slide .= '<li><a class="fancybox-thumb" rel="fancybox-thumb" href ="'.$slide.'" class="bg-main-slider-image"><img style="width:100%;object-fit:contain;"  src="'.$slide.'" alt=""></a></li>';
					}
        		}
        	}
        }
	}
	if(!empty($product['Videos'])) {
		$video = $product['Videos'];
		if (strpos($video,"https://www.youtube.com/watch") !== FALSE) {
			$arr = explode("watch?v=",$video);
			$video = "https://www.youtube.com/embed/".@$arr[1];
		}
		$str_main_slide .= '<li><a class="fancybox-thumb fancybox.iframe" href ="'.$video.'" class="bg-main-slider-image"><img style="width:100%;object-fit:contain;"  src="'.base_url("skins/frontend/images/youtube.png").'" alt=""></a></li>';
	}
	if (!empty($str_main_slide)) :
?>

<section class="section section-padding-b-30 section-slider">
    <div class="container">
        <div class="row">
            <div class="col-md-10 padding-r-0">
                <div class="listing-bx">
                	<?php
					$listtype = getDetailListingType($product["ListingType"]);
					if (!empty($listtype)) : ?>
					<div class="maker-category">
						<p class="libre-franklin-semiBold font-s-12"><?php echo $listtype; ?></p>
					</div>
					<?php endif; ?>
                    <ul class="bx-slider2">
                        <?php echo $str_main_slide; ?>
                    </ul>
    				<?php if (isset($is_login)) : ?>
						<?php if (!empty($favorite)) : ?>
		            		<div class="bg-maker-like"><a class="maker-like actived" href="<?php echo base_url('profile/like/?id='.$product["ID"].'&url='.urlencode($_SERVER['REQUEST_URI'])); ?>" title="Click here to remove favorite"><i class="fa fa-heart-o" aria-hidden="true"></i></a></div>
		    			<?php else : ?>
		    				<div class="bg-maker-like"><a class="maker-like" href="<?php echo base_url('profile/like/?id='.$product["ID"].'&url='.urlencode($_SERVER['REQUEST_URI'])); ?>" title="Click here to add favorite"><i class="fa fa-heart-o" aria-hidden="true"></i></a></div>
		    			<?php endif; ?>
					<?php else : ?>
						<div class="bg-maker-like"><a href="#" class="maker-like favorite" title="Please login before add favorite"><i class="fa fa-heart-o" aria-hidden="true"></i></a></div>
					<?php endif; ?>
                </div>
            </div>
            <div class="col-md-2 padding-l-0">
                <div class="pager-bx">
                    <div class="bx-slider3">
						<?php echo $str_main_thumb_slide; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<section class="section section-padding-b-30 section-contact listing-detail">
    <div class="container">
        <div class="row">
            <div class="col-container">
                <div class="col-md-4 col">
                    <div class="panel_box">
                        <h2 class="libre-franklin-semiBold font-s-18 color-2b2b33 mr-t-0">Summary</h2>
                        <div class="line"></div>
                        <div class="panel_box_body">
                            <div class="panel_box_body_group">
                                <p class="libre-franklin-regular font-s-14 color-f12a53 mr-b-15">Google Map <a target="_blank" href="https://www.google.com/maps/place/<?php echo strtolower($product['Address'] . ',' . $product['County']);?>"><i class="fa fa-map-marker" aria-hidden="true"></i></a></p>
                            </div>
                            <div class="panel_box_body_group">
                            	<p class="libre-franklin-regular font-s-14 color-2b2b33 mr-b-15"><?php echo $product["Address"]; ?></p>
                            </div>
                            <div class="panel_box_body_group">
    							<?php if (!empty($product['APN'])) : ?>
								<div class="row">
									<div class="col-xs-4 libre-franklin-regular font-s-14 color-2b2b33 mr-t-0">APN:</div>
									<div class="col-xs-8 libre-franklin-regular font-s-14 color-2b2b33 mr-t-0"><b><?php echo $product['APN']; ?></b></div>
								</div>
								<?php endif; ?>
								<div class="row mr-b-15">
									<div class="col-xs-4 libre-franklin-regular font-s-14 color-2b2b33 mr-t-0">City:</div>
									<div class="col-xs-8 libre-franklin-regular font-s-14 color-2b2b33 mr-t-0"><b><?php echo $product['County']; ?></b></div>
								</div>
								<?php if (!empty($product['City']) && $product['City'] != "None") : ?>
								<div class="row mr-b-15">
									<div class="col-xs-4 libre-franklin-regular font-s-14 color-2b2b33 mr-t-0">District:</div>
									<div class="col-xs-8 libre-franklin-regular font-s-14 color-2b2b33 mr-t-0"><b><?php echo $product['City']; ?></b></div>
								</div>
								<?php endif; ?>
                                <p class="libre-franklin-regular font-s-14 color-2b2b33"><?php echo $product["Summary"]; ?></p>
                            </div>
        					<?php if(!empty($product['Detail'])):?>
                            <div class="line"></div>
                            <div class="panel_box_body_group">
                                <p class="libre-franklin-semiBold font-s-14 color-2b2b33">Property Details</p>
                                <div class="panel_box_body_details">
                                    <p class="libre-franklin-regular font-s-14 color-2b2b33">
    									<?php
    										$text = nl2br(@$product['Detail']);
    										$reg_exUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";
											if (preg_match($reg_exUrl, $text, $url)) {
												// make the urls hyper links
												echo preg_replace($reg_exUrl, "<a target=\"_blank\" href=\"{$url[0]}\">{$url[0]}</a>", $text);
											} else {
												// if no urls in the text just return the text
												echo $text;
											}
    									?>
                                    </p>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="panel_box">
    					<h2 class="libre-franklin-semiBold font-s-18 color-2b2b33 mr-t-0">My Research</h2>
                        <div class="line"></div>
                        <div class="panel_box_body">
                            <div class="panel_box_body_group">
        						<form method="post" id="form-favorites" action="<?php echo base_url("profile/add_favorite")?>">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <p class="libre-franklin-semiBold font-s-14 color-2b2b33">My Favorites</p>
        									<input type="hidden" name="Listing_ID" value="<?php echo $product['ID'];?>">
    			                            <input type="hidden" name="ID" value="<?php echo @$favorite['ID'];?>">
    			                        	<input type="hidden" name="ID_SAVE_LISTING" value="<?php echo @$listing_save['ID'];?>">
                                        </div>
                                        <div class="col-md-7">
                                            <div class="checkbox checkbox-primary">
        										<input type="checkbox" class="styled" name="is_save" <?php echo (@$favorite) ? "checked" : "";?>/><label class="libre-franklin-regular font-s-14 color-2b2b33" for="remember-Favorites">(check to add)</label>
                                            </div>
                                        </div>
                                    </div>
                                </div> 
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <p class="libre-franklin-semiBold font-s-14 color-2b2b33">My Value</p>
                                        </div>
                                        <div class="col-md-7">
        									<input class="form-control number not-radius bg-f2f2f2" style="width: 100%;" type="text" step="1" min="0" value="<?php echo (!isset($listing_save["Price"]) || empty($listing_save["Price"]) || $listing_save["Price"] <= 0 ? "" : "₱".number_format($listing_save["Price"]) )?>" placeholder="₱" name="Price" />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <p class="libre-franklin-semiBold font-s-14 color-2b2b33">My Comments</p>
        							<textarea name="Comment" id="favorites-comment" class="form-control not-radius bg-f2f2f2 min-height-100px" rows="5" maxlength="500"><?php echo (@$listing_save["Comment"])?></textarea>
                                </div> 
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-7">
                                        	<?php if (!isset($is_login)) : ?>
												<button id="favorites-save" type="button" class="btn bg-6e7681 w-100 not-radius color-fff text-uppercase libre-franklin-semiBold font-s-16" onclick="javascript: $('#ModalSignup').modal('show'); return false;">SAVE</button>
											<?php else : ?>
					    						<button id="favorites-save" type="submit" class="btn bg-6e7681 w-100 not-radius color-fff text-uppercase libre-franklin-semiBold font-s-16">SAVE</button>
					    					<?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col">
                    <div class="panel_box">
    					<div class="row">
        					<div class="col-xs-10">
                        		<h2 class="libre-franklin-semiBold font-s-18 color-2b2b33 mr-t-0">Terms</h2>
        					</div>
                        	<div class="col-xs-2 text-right">
    		                    <?php if (isset($is_login)) : ?>
    								<?php if (!empty($favorite)) : ?>
    				            		<div><a class="maker-like actived" href="<?php echo base_url('profile/like/?id='.$product["ID"].'&url='.urlencode($_SERVER['REQUEST_URI'])); ?>" title="Click here to remove favorite"><i class="fa fa-heart-o" aria-hidden="true"></i></a></div>
    				    			<?php else : ?>
    				    				<div><a class="maker-like" href="<?php echo base_url('profile/like/?id='.$product["ID"].'&url='.urlencode($_SERVER['REQUEST_URI'])); ?>" title="Click here to add favorite"><i class="fa fa-heart-o" aria-hidden="true"></i></a></div>
    				    			<?php endif; ?>
    							<?php else : ?>
    								<div><a class="maker-like" href="#" class="favorite" title="Please login before add favorite"><i class="fa fa-heart-o" aria-hidden="true"></i></a></div>
    							<?php endif; ?>
                        	</div>
    					</div>
                        <div class="line"></div>
                        <div class="panel_box_body">
                            <?php if (@$is_estate == 1 && $offered > 0) : ?>
    						<div class="panel_box_body_group relative">
    							<p class="libre-franklin-regular font-s-14 color-2b2b33">Listing Price:</p>
                                <p class="libre-franklin-regular font-s-14 color-2b2b33 mr-b-15">₱<?php echo number_format($product['Price']); ?></p>
                                <p class="libre-franklin-regular font-s-14 color-2b2b33">Commission Offered: (added to listing price)</p>
                                <p class="libre-franklin-regular font-s-14 color-2b2b33 mr-b-15">₱<?php echo number_format(@$offered); ?> <?php echo @$commission_label; ?></p>
        					</div>
    						<div class="panel_box_body_group relative">
                                <p class="libre-franklin-regular font-s-14 color-2b2b33">Final Price:</p>
                                <p class="libre-franklin-semiBold font-s-24 color-2b2b33 mr-t-0">₱<?php echo number_format($total); ?></p>
                                <p class="libre-franklin-semiBold font-s-14 color-f12a53 days-left"><?php echo $product["DayLeft"]; ?> day(s) left</p>
                            </div>
    						<?php else : ?>
    						<div class="panel_box_body_group relative">
                                <p class="libre-franklin-regular font-s-14 color-2b2b33">Listing Price:</p>
                                <p class="libre-franklin-semiBold font-s-24 color-2b2b33 mr-t-0">₱<?php echo number_format($product['Price']); ?></p>
                                <p class="libre-franklin-semiBold font-s-14 color-f12a53 days-left"><?php echo $product["DayLeft"]; ?> day(s) left</p>
                            </div>
                            <?php endif; ?>
                            <div class="line"></div>
                            <div class="panel_box_body_group">
                                <p class="libre-franklin-regular font-s-14 color-2b2b33">Showing Instructions:</p>
                                <p class="libre-franklin-semiBold font-s-14 color-2b2b33 mr-t-0 mr-b-15"><?php echo @$product['Showing_Instructions']; ?></p>
                            </div>
                            <div class="line"></div>
                            <div class="panel_box_body_group">
                                <p class="libre-franklin-regular font-s-14 color-f12a53"><a class="color-f12a53" target="_blank" href="<?php echo base_url('page/terms-and-conditions'); ?>">Terms and condition</a></p>
        							<?php
    			                        if(@$is_estate == 1){
    			                            echo '<p class="libre-franklin-italic font-s-14 color-2b2b33"><i>“If your property is currently listed with a Realtor, please disregard this notice. It is not our intention to solicit the offerings of other Brokers.”</i></p>';
    			                            echo '<p class="libre-franklin-italic font-s-14 color-2b2b33"><i>“Do not contact me with unsolicited offers or services”</i></p>';
    			                        }else{
    			                            echo '<p class="libre-franklin-italic font-s-14 color-2b2b33">“Do not contact me with unsolicited services or offers”</i></p>';
    			                        }
    			                    ?>
                            </div>
                            <div class="panel_box_body_group">
                                <div class="row">
                                	<?php if ((isset($is_login) && $is_login) || $disable_buynow): ?>
    		                            <div class="col-md-12 mr-b-20"><a class="btn bg-2b2b33 w-100 not-radius color-fff text-uppercase libre-franklin-semiBold font-s-16 bnt-payment <?php echo strtolower($listing_type); ?>" href ="javascript:;" data-href="/payment/index/<?php echo $product["ID"]; ?>/?type=offer">Offer</a></div>
    		                        <?php else :?>
    		                            <div class="col-md-12 mr-b-20"><a class="btn bg-2b2b33 w-100 not-radius color-fff text-uppercase libre-franklin-semiBold font-s-16"  href="#" onclick="javascript: $('#ModalLogin #redirect').val('/payment/index/<?php echo $product["ID"]; ?>?type=offer'); $('#ModalLogin').modal('show'); return false;">Offer</a></div>
    		                        <?php endif; ?>
                                </div>
                                <div class="checkbox checkbox-primary" style="display:none;">
                            		<input type="checkbox" class="styled" id="Allow_Commission" <?php if ($product["Allow_Commission"] == 0 OR TRUE) {  ?> value="0" <?php } else { ?> value="1" checked <?php } ?> >
                                    <label class="libre-franklin-regular font-s-14 color-2b2b33" for="Allow_Commission">
                                        I would like to hire a real estate agent to
                                        help me through my transaction for a
                                        minimal fee.
                                    </label>
                                </div>
                                <script type="text/javascript">
		                        	<?php if ($disable_buynow) : ?>
		                        	$(".bnt-payment").click(function(){
		                                return false;
		                            });
		                        	<?php else : ?>
		                            $(".bnt-payment").click(function(){
		                                var allow = 0;
		                                if($(".panel_box_body_group #Allow_Commission").is(":checked")){
		                                    allow = 1;
		                                }
		                                var url = $(this).attr("data-href") + "&allow="+allow;
		                                location.href = url;
		                                return false;
		                            });
		                            <?php endif; ?>
		                        </script>
                            </div>
                            <div class="panel_box_body_group">
                                <p class="libre-franklin-italic font-s-14 color-2b2b33">
                                    <b>OFFER</b> - Buyer can make a offer indicating his desired price and terms. The seller will receive this offer and can counter or accept the buyers offer. This property will continue to be listed for sale until the seller accepts the buyers offer, or accepts an offer from another buyer.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col">
                    <div class="panel_box">
                    	<div style="margin-top:-20px;padding-top: 12px;">
    	                    <h2 class="libre-franklin-semiBold font-s-18 color-2b2b33 mr-t-0" style="margin-bottom: 17px;">
    	                    	<img class="radius-100 left circle-image w-40px h-40px" src="<?php echo (!empty($member["Avatar"]) && @$member["Is_Estate_License"] == 1) ? $member["Avatar"] : skin_url("frontend/images/user_default.png")?>"><span class="mr-l-10">Agent Details</span>
    						</h2>
    					</div>
                        <div class="line"></div>
                        <div class="panel_box_body">
                            <div class="panel_box_body_group">
                            	<?php if (@$member["Is_Estate_License"] == 1) : ?>
    		                	<p class="libre-franklin-regular font-s-14 color-2b2b33">
    		                		<?php echo @$member["First_Name"] . " " . @$member["Last_Name"]; ?><br/>
    								Lic. No. <?php echo @$member["Estate_License"]; ?><br/>
    								Member Since <?php echo date("m/d/Y", strtotime(@$member["Create_At"])); ?>
    							</p>
    							<?php else : ?>
    							<p class="libre-franklin-regular font-s-14 color-2b2b33">Private Seller<br/>
    							<?php // echo @$member["First_Name"] . " " . @$member["Last_Name"] . "<br/>"; ?>
    							Member Since <?php echo date("m/d/Y", strtotime(@$member["Create_At"])); ?></p>
    							<?php endif; ?>
                            </div>
                            <div class="panel_box_body_group">
                                <p class="libre-franklin-semiBold font-s-14 color-2b2b33">Message Seller:</p>
                                <form method="post" id="form-favorites" action="<?php echo base_url("home/send_message"); ?>">
                                	<input type="hidden" name="Listing_ID" value="<?php echo @$product['ID']; ?>">
                                	<?php if (!@$is_login): ?>
                                    <div class="form-group">
                                        <input type="text" class="form-control not-radius bg-f2f2f2 required" value="" name="Full_Name" placeholder="Full Name">
                                    </div>
                                    <div class="form-group"><input type="email" class="form-control not-radius bg-f2f2f2 required" name="Email" placeholder="Your Email"></div>
                                    <?php endif; ?>
                                    <div class="form-group"><input type="text" class="form-control not-radius bg-f2f2f2 required" name="Subject" placeholder="Subject"></div>
                                    <div class="form-group"><textarea class="panel_box_body_textarea form-control not-radius bg-f2f2f2 required" maxlength="500" name="Message" placeholder="Message"></textarea></div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-7">
                                        		<?php if (!isset($is_login)) : ?>
													<button type="button" class="btn bg-6e7681 w-100 not-radius color-fff text-uppercase libre-franklin-semiBold font-s-16" onclick="javascript: $('#ModalSignup').modal('show'); return false;">SEND</button>
												<?php else : ?>
                                                	<button class="btn bg-6e7681 w-100 not-radius color-fff text-uppercase libre-franklin-semiBold font-s-16" type="submit">SEND</button>
                                        		<?php endif; ?>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="dispaly-table w-100 vertical-middle-bottom" style=" height: 54px;">
                                                    <p class="dispaly-table-cell w-100 vertical-middle-bottom libre-franklin-medium font-s-14 color-f12a53">
                                        				<?php if (!@$is_login): ?>
    							                    	<a href ="javascript:;" class="color-f12a53" data-href="#" onclick="javascript: $('#ModalLogin').modal('show'); return false;">Report Seller</a>
    							                    <?php else : ?>
    							                    	<a href="?rep=true" class="color-f12a53" onclick="return confirm('Are you sure you want to report this seller?');">Report Seller</a>
    							                    <?php endif; ?>
                                        			</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="panel_box">
                        <h2 class="libre-franklin-semiBold font-s-18 color-2b2b33 mr-t-0">Contact Us</h2>
                        <div class="panel_box_body">
                            <div class="panel_box_body_group">
                                <p class="libre-franklin-regular font-s-14 color-2b2b33">We are constantly working to raise the bar on our services. If you have any questions or concerns about your experience, please let us know. Our support concierges are available <b>24/7</b>.</p>
                            </div>
                            <div class="panel_box_body_group">
                                <p><img style="max-width:80%" src="<?php echo skin_url("/frontend/images/logo.png")?>" alt="Condo PI"></p>
                                <p class="libre-franklin-medium font-s-14 color-f12a53"><a class="color-f12a53" href="tel:<?php echo getWebSetting("Contact")?>"><?php echo getWebSetting("Contact")?></a></p>
                                <p class="libre-franklin-medium font-s-14 color-f12a53"><a class="color-f12a53" href="mailto:support@condopi.com">support@condopi.com</a></p>
                                <p><img class="w-100" alt="skyline" src="<?php echo skin_url("/frontend/images/contact-photo.png")?>"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php $this->load->view("frontend/home/subscribe"); ?>
<?php if ($similars != null) : ?>
<section class="section listing-section similar-listing" id="listing">
    <div class="container">
        <h2 class="georgia font-s-30 color-2b2b33 text-uppercase text-center mr-t-20 mr-b-50">Similar Listings</h2>
        <div class="row bx-slider1" style="margin-left:1px;">
			<?php foreach ($similars as $key => $item) : ?>
				<div class="col-sm-3 col-xs-6">
					<?php $this->load->view("frontend/home/item",['item' => $item]); ?>
				</div>
			<?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>
</div>
<style>
	.detail-page .panel_box #payment_block .w-50 {margin-top:10px;}
	.detail-page .panel_box #payment_block .btn {}
	.detail-page .panel_box #payment_block .btn.auction, .panel_box .btn.auction {background: #E5E5E5!important;cursor: not-allowed;}
	.detail-page.Auction .panel_box #payment_block .bnt-payment {cursor: not-allowed;}
	.detail-page .similar-listing .item .item-img .maker-category {left:0px;}
	.detail-page .similar-listing .item .maker-category:before {display:none;}
	.Auction .panel_box .bnt-payment {cursor: not-allowed;}
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
        
        if ($(".bx-slider1").length > 0) {
	        var width = $(".bx-slider1").innerWidth();
            var number = 4 ;
            var padding = 60;
            var magrin = 5;
            if(width < 769) {
                number = 2;
                padding = 42;
                magrin = 0;
            }
            if(width < 429) {
                number = 1;
                padding = 0;
                magrin = 0;
            }
	        $('.bx-slider1').bxSlider({
	            slideWidth: (width / number),
	            minSlides: number,
	            maxSlides : number,
	            pager: false,
	            controls: true,
	            auto: false,
	            infiniteLoop: true,
	            autoStart: false,
	            slideMargin: 0,
	            oneToOneTouch:false,
	            touchEnabled:false,
	            onSliderLoad:function(){
                    if(width > 768)
	                //$(".bx-slider1").css("padding","0 "+padding+"px");
                    $(".bx-slider1").css('margin-left',magrin+'px');
	            },
	            onSlideBefore:function(){
	                $(".bx-slider1").css('margin-left',magrin+'px');
	            }
	        });
        }
        if ($(".bx-slider2").length > 0) {
	        var slider2 = $('.bx-slider2').bxSlider({
	            minSlides: 1,
	            maxSlides : 1,
	            pager: false,
	            controls: true,
	            auto: false,
	            infiniteLoop: true,
	            autoStart: false,
	            oneToOneTouch:false,
	            touchEnabled:false,
	            pagerCustom: '.bx-slider3'
	        });
        }
        if ($(".bx-slider3").length > 0) {
            if(width < 769){
                number = 5;
                if(width < 769) {
                    number = 4;
                    padding = 42;
                    magrin = 0;
                }
                if(width < 429) {
                    number = 4;
                    padding = 0;
                    magrin = 0;
                }
                var w = $(".bx-slider3").width();
                $('.bx-slider3').bxSlider({
                    mode: 'horizontal',
                    slideWidth : w/number,
                    minSlides: number,
                    maxSlides : number,
                    auto:false,
                    moveSlides:1,
                    controls:true,
                    pager:false,
                    slideMargin :3,
                    oneToOneTouch:false,
                    touchEnabled:false
                });
            }else{
                $('.bx-slider3').bxSlider({
                    mode: 'vertical',
                    slideHeight:540,
                    minSlides: 4,
                    auto:false,
                    moveSlides:1,
                    controls:true,
                    pager:false,
                    slideMargin :3,
                    oneToOneTouch:false,
                    touchEnabled:false,
                    infiniteLoop:false
                });
            }
	        
	        $(document).on("click",'.bx-slider3 a.slide',function(){
	            var index = $(this).attr("data-slide-index");
	            slider2.goToSlide(index);
	            return false;
	        });
	    }
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
    var H = 40;
    $(window).load(function(){
        var windowW = $(window).width();
        if(windowW > 768){
            var AQH = 0;
            var e0 = e1 = e2 = 0
            $.each($(".col-container .col"),function($key,$value){
                if(AQH < $(this).height()){
                    AQH = $(this).height();
                }
                if($key == 0 ) e0 = $(this).height();
                if($key == 1 ) e1 = $(this).height();
                if($key == 2 ) e2 = $(this).height();
                
            }); 
            var l1 = AQH - e0;
            var l2 = AQH - e1;
            var l3 = AQH - e2;
            var p = 166;
            var t = 96;
            $(".panel_box_body_group .panel_box_body_details").css("height",( p + l1) +"px");
            $(".panel_box_body_group .panel_box_body_textarea").css("height",( t + l3 ) +"px");
            $(".col-container .col:eq(1) .panel_box").css("height",(AQH - 15) +"px");//.css("min-height",(AQH - H) + "px");
        }
    }) ; 
</script>