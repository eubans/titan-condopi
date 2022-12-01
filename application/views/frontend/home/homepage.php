<?php
$thisishomepage = 'yes';
?>

<style type="text/css">
body .section-body{
    padding-top: 90px;
    background: #fff;
}
.in_page_action_button_red {
	padding: 20px;
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
<section class="homepage-image" style="">
    <div class="container content-image-header">
		<div style="width: 800px; margin: 0px auto; margin-top: 13%;">
	        <h1 class="times_new_roman">
	        	Investor's <span style="color: #f12a53; font-weight: bold;">#1</span> source for off-market properties
	        </h1>

			<div style="margin-left: 80px; margin-top: 150px;">
			<a href="/listing" class="in_page_action_button_red libre-franklin-regular" style="margin-top: 100px;">
				Search Listings Now
			</a>
			</div>
		</div>
    </div>
</section>

<div style="text-align: center; margin: 20px auto; max-width: 900px;">
	Trusted by over 1000+ Agents, Teams, and Brokerages!<br>
	<img src="/skins/frontend/images/other-co.png" style="width: 100%;">
</div>

<section class="homepage">
    <div class="container">
        <div class="row">
            <div class="col-md-12 mr-b-50">
            	<div style="display: table; width: 100%;">
            		<div style="display: table-row;">
            			<div style="display: table-cell; width: 50%; vertical-align: middle;">
							<img style="width: 100%;" src="<?php echo skin_url(); ?>frontend/images/image_1.jpg" />
            			</div>

            			<div style="display: table-cell; width: 50%; vertical-align: middle;">
							<div style="margin-left: 50px; margin-right: 50px;">
									<h2 class="georgia color-646568">
										<span style="color: #f12a53;">
											Realtors:
										</span><br>
										Post your pre-MLS listing and we'll showcase it to thousands of cash buyers!
									</h2>
									<div style="height: 30px;">&nbsp;</div>
									<p class="libre-franklin-regular font-s-20 color-646568">
										We have thousands of registered buyers looking daily for the latest listings. Our members include local cash buyers, international investors, and institutional iBuyers.
									</p>
									<div style="height: 60px;">&nbsp;</div>
									<div style="text-align: center;">
										<?php if (isset($is_login) && $is_login){ ?>
											<a class="in_page_action_button_red libre-franklin-regular" href="/profile/addlisting">Add a Listing Now</a>
										<?php }else{ ?>
											<a class="in_page_action_button_red libre-franklin-regular" href="#" data-toggle="modal" data-target="#ModalSignup">Join Now to Add a Listing</a> 
										<?php } ?>
									</div>
							</div>
            			</div>
            		</div>
            	</div>
            </div>
            <div class="col-md-12 mr-b-50">                
            	<div style="display: table; width: 100%;">
            		<div style="display: table-row;">
            			<div style="display: table-cell; width: 50%; vertical-align: middle;">
							<div style="margin-left: 50px; margin-right: 50px;">
								<h2 class="georgia color-646568">
			                        <span style="color: #f12a53;">
		    	                    	Buyers:
		    	                    </span><br>
	        	                    Be the first to see a property before it hits the market! 
	        	                </h2>
									<div style="height: 30px;">&nbsp;</div>
								<p class="libre-franklin-regular font-s-20 color-646568">
									We offer "first to market" properties that are exclusively listed on our site before anywhere else. Properties are only listed for 7 days, so our listings are always up-to-date.
								</p>

									<div style="height: 60px;">&nbsp;</div>
								<div style="text-align: center;">
									<a class="in_page_action_button_red libre-franklin-regular" href="/listing">Search Listings Now</a>
								</div>
							</div>
            			</div>

            			<div style="display: table-cell; width: 50%; vertical-align: middle;">
            				<img style="width: 100%;" src="<?php echo skin_url(); ?>frontend/images/image_2.jpg" />
            			</div>
            		</div>
            	</div>
            </div>
            <div class="col-md-12 mr-b-50 sec-join-now">
            	<div style="display: table; width: 100%;">
            		<div style="display: table-row;">
            			<div style="display: table-cell; width: 50%; vertical-align: middle;">
            				<img style="width: 100%;" src="<?php echo skin_url(); ?>frontend/images/image_3.jpg" />
						</div>

            			<div style="display: table-cell; width: 50%; vertical-align: middle;">
							<div style="margin-left: 50px; margin-right: 50px;">
	                        <h2 class="georgia color-646568">
    	                        Our <span style="color: #f12a53;">Free</span> Member benefits:
    	                    </h2>
									<div style="height: 30px;">&nbsp;</div>
    	                    <ul class="libre-franklin-regular listing-rs color-646568">
        	                    <li>Free to post pre-MLS and off-market properties.</li>
        	                    <li>Free email to thousands of registered members.</li>
        	                    <li>Free lead generation from your listing.</li>
        	                    <li>Free to make and receive offers through our site.</li>
        	                    <li>Free property reports.</li>
        	                    <li>We offer Realtors 
				                    <?php if (isset($is_login) && $is_login){ ?>
					                	<a style="color: #e41142;" href="/profile/blast_ads">Social Media Blast</a> 
				                    <?php }else{ ?>
					                	<a style="color: #e41142;" href="/home/socialmediablast">Social Media Blast</a> 
				                    <?php } ?> 
        	                    	to help you acquire leads and grow your business.</li>
        	                    <li>Members get significant discounts from our escrow, title, and real estate service affiliates.</li>
        	                </ul>

        						<?php if (!isset($is_login)): ?>
									<div style="height: 60px;">&nbsp;</div>
								<div style="text-align: center;">
									<a class="in_page_action_button_red libre-franklin-regular" href="#" data-toggle="modal" data-target="#ModalSignup">Join Now</a>
								</div>
    							<?php endif; ?>
							</div>
						</div>
					</div>
				</div>
            </div>
            
        </div>
    </div>
</section>
