<section class="section section-padding-b-30 section-contact">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
						<div  style="z-index: 1; position: absolute; margin-top: -5px; margin-right: 20px; right: 20px;"><img style="width: 30px;" src="/skins/frontend/images/ribbon.png"></div>
                <div class="bg-white-001">
					<?php
                    $old_ad = '<div class="bg-gray-001">
                        <div class="bg-white-001">
                            <div class="row">
                                <div class="col-md-7">
    								<h1 class="text-uppercase georgia font-s-30 color-2b2b33"><span class="color-f12a53">FAST</span> HARD MONEY, <span class="color-f12a53">EASY</span> QUALIFY</h1>
    								<div style="position:relative;">
    									<p><img style="padding-top:0px;width:80%" class="w-100" src="'.base_url("skins/frontend/images/contact-photo.jpg").'"></p>
                                    	<div style="position:absolute; right:50px; top: 0px;" class="libre-franklin-regular color-2b2b33 font-s-16">
    										<div style="padding-left:10px;">NO INCOME</div>
										    <div style="padding-left:40px;">NO DOCUMENTS</div>
										    <div style="padding-left:70px;">ALL CREDIT OKAY</div>
    									</div>
    								</div>
    								<p class="libre-franklin-regular color-2b2b33 font-s-16"><span class="color-f12a53">7.99%</span> Fixed Rate, <span class="color-f12a53">80%</span> LTV, Lender Fees at <span class="color-f12a53">2 pts</span></p>
    							</div>
                                <div class="col-md-5">
                    ';
			                            if($this->session->flashdata('message')){
			                                $old_ad.= $this->session->flashdata('message');
			                            } else {
			                            	$old_ad.= '<p class="libre-franklin-regular color-2b2b33 font-s-16" style="margin-top:20px;"><span class="color-f12a53">Sign up</span> now to get <u>pre-approved in 24 hours!!!</u></p>';
			                            }
			        $old_ad.= '
                                    <form class="listing-section-form" action="'.base_url('home/subscribe').'" method="POST">
                                    	<div class="row">
                                    		<div class="col-md-11">
		                                      	<div class="form-group">
		                                        	<input type="text" required class="form-control libre-franklin-regular font-s-14" value="';

		            $user_info = $this->session->userdata('user_info'); 

		            $old_ad.= $user_info["email"].'" placeholder="Enter your email address" name="email">
		                                      	</div>
		                                      	<div class="form-group">
						                            <div class="g-recaptcha" data-callback="imNotARobot" data-sitekey="6Ld526sUAAAAAA9Z-ek3-V_B6_DPyTrgMVIKVDuf"></div>
						                            <input type="hidden" name="recaptcha" value="" id="recaptcha-value" required>
						                        </div>
						                		<div class="form-group text-right">
		                                      		<button type="submit" class="btn btn-md btn-secondary">Subscribe</button>
		                                        </div>
		                                	</div>
		                                </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>';
					?>

					<?php
					$ads = array(
						array(
							'1',
							'ad-bell-properties.jpg'
						),
						array(
							'2',
							'ad-top-escrow.jpg'
						),
						array(
							'3',
							'ad-rent-disclosures.jpg'
						),
						array(
							'old_ad',
							$old_ad
						)
					);
					$key = array_rand($ads,1);
					?>

					<?php
					if( $ads[$key][0] == 'old_ad' ){
						echo $old_ad;
					}else{
					?>
						<a target="_new_tab" href="/535510N-G0.php"><img id="ad_banner_1" style="width: 100%;" src="/skins/frontend/images/<?php echo $ads[$key][1]; ?>"></a>
	                	<script>
						var observer = new IntersectionObserver(function(entries) {
							if(entries[0].isIntersecting === true){
								$.post(
									"/535510N.php", 
									{
										manualAdID: <?php echo $ads[$key][0]; ?>
									}, 
									function(result){
									}
								);
							}
						}, { threshold: [1] });

						observer.observe(document.querySelector("#ad_banner_1"));
		                </script>
		            <?php
		            }
		            ?>
                </div>
            </div>
        </div>
    </div>
</section>