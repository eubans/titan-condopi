<style type="text/css">
.in_page_action_button_red {
	padding: 10px;
	border: solid 1px #f12a53;	
	background: rgba(255, 255, 255, 0.5);
	text-align: center;
	color: #f12a53;
	text-decoration: none;
	font-size: 12pt;
}
.in_page_action_button_red:hover {
	background: #f12a53;
	color: #fff;
	text-decoration: none;
}
</style>

<section>
        <div class="times_new_roman" style="font-size: 15pt; text-align: center;">
	        	Investor's <span style="color: #f12a53; font-weight: bold;">#1</span> source for off-market properties
        </div>
        <img src="/skins/frontend/images/background.png">

		<div style="text-align: center; margin: 20px 0px;">
			<a href="/listing" class="in_page_action_button_red libre-franklin-regular">
				Search Listings Now
			</a>
		</div>
</section>

<div style="text-align: center; margin: 10px auto;">
	Trusted by over 1000+ Agents, Teams, and Brokerages!<br>
	<img src="/skins/frontend/images/other-co.png" style="width: 100%;">
</div>

<section>
        <div>
            <div>
                <div><img style="width: 100%;" src="<?php echo skin_url(); ?>frontend/images/image_1.jpg" /></div>
                <div>
                    <div style="margin: 10px;">
                        <h2 class="georgia color-646568" style="font-size: 15pt;">
										<span style="color: #f12a53;">
											Realtors:
										</span><br>
										Post your pre-MLS listing and we'll showcase it to thousands of cash buyers!
                        </h2>
                        <p class="libre-franklin-regular color-646568">
										We have thousands of registered buyers looking daily for the latest listings. Our members include local cash buyers, international investors, and institutional iBuyers.
                        </p>
									<div style="text-align: center; margin: 20px 0px;">
										<?php if (isset($is_login) && $is_login){ ?>
											<a class="in_page_action_button_red libre-franklin-regular" href="/profile/addlisting">Add a Listing Now</a>
										<?php }else{ ?>
											<a class="in_page_action_button_red libre-franklin-regular" href="#" data-toggle="modal" data-target="#ModalSignup">Join Now to Add a Listing</a> 
										<?php } ?>
									</div>
                    </div>
                </div>
            </div>
            <div>                
                <div><img style="width: 100%;" src="<?php echo skin_url(); ?>frontend/images/image_2.jpg" /></div>
                <div>
                    <div style="margin: 10px;">
                        <h2 class="georgia color-646568" style="font-size: 15pt;">
			                        <span style="color: #f12a53;">
		    	                    	Buyers:
		    	                    </span><br>
	        	                    Be the first to see a property before it hits the market! 
                        </h2>
                        <p class="libre-franklin-regular color-646568">
									We offer "first to market" properties that are exclusively listed on our site before anywhere else. Properties are only listed for 7 days, so our listings are always up-to-date.
                        </p>

						<div style="text-align: center; margin: 20px 0px;">
									<a class="in_page_action_button_red libre-franklin-regular" href="/listing">Search Listings Now</a>
						</div>
                    </div>
                </div>
            </div>
            <div>
                <div><img style="width: 100%;" src="<?php echo skin_url(); ?>frontend/images/image_3.jpg" /></div>
                <div>
                    <div style="margin: 10px;">
                        <h2 class="georgia color-646568" style="font-size: 15pt;">
    	                        Our <span style="color: #f12a53;">Free</span> Member benefits:
                        </h2>
                        <p class="libre-franklin-regular color-646568">
							&bull; Free to post pre-MLS and off-market properties.
							<br>&bull; Free email to thousands of registered members.
							<br>&bull; Free lead generation from your listing.
							<br>&bull; Free to make and receive offers through our site.
							<br>&bull; Free property reports.
							<br>&bull; We offer Realtors 
							<?php if (isset($is_login) && $is_login){ ?>
								<a style="color: #e41142;" href="/profile/blast_ads">Social Media Blast</a> 
							<?php }else{ ?>
								<a style="color: #e41142;" href="/home/socialmediablast">Social Media Blast</a> 
							<?php } ?> 
							to help you acquire leads and grow your business.
							<br>&bull; Members get significant discounts from our escrow, title, and real estate service affiliates.
                        </p>
                        <div>
    						<?php if (!isset($is_login)): ?>
								<div style="text-align: center; margin: 20px 0px;">
									<a class="in_page_action_button_red libre-franklin-regular" href="#" data-toggle="modal" data-target="#ModalSignup">Join Now</a>
								</div>
    						<?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
</section>


<!-- 1. Add latest jQuery and fancybox files -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.4.1/dist/jquery.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />
<script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('.video-deck a').fancybox({
	        
	    });
	});
</script>