</section>

<?php
if($this->uri->segment(1) == "home" || $this->uri->segment(1) == NULL || $this->uri->segment(1) == "homepage"){
	$testimonials = get_testimonial();
	if ($testimonials != null) :
?>
<section class="section section-padding-b-60 section-padding-t-20 section-about-us bg-white">
    <div class="container">
        <?php /* <h3 class="mr-b-30 text-center text-uppercase font-s-18 georgia color-2b2b33">Testimonial</h3> */ ?>
        <h1 class="text-center text-uppercase font-s-30 georgia color-2b2b33">What People say about us</h1>
        <div class="row">
            <div class="col-md-12">
                <ul class="bx-slider">
        			<?php foreach ($testimonials as $key => $item): ?>
                    <li>
                        <div class="border-box">
                            <div class="description">
                                <p class="libre-franklin-italic font-s-14 color-5d5f66"><?php echo $item['Content']; ?></p>
                                <p class="libre-franklin-medium font-s-14 mr-b-20 mr-t-30">
        							<span class="color-f12a53 text-uppercase"><?php echo $item['Name']; ?></span><br/>
                                	<?php echo $item['Position']; ?>
        						</p>
                            </div>
                        </div>
                    </li>
        			<?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</section>
<?php endif;
}else{
}
?>

<footer>
    <div class="container">
        <div class="row">
            <div class="col-md-4">
    			<?php $page = get_staticpage('about-us'); echo @$page['Summary']; ?>
            </div>
            <div class="col-md-4">
                <div class="border-l-r-02">
                    <h2 class="georgia font-s-24 text-uppercase color-646568 mr-b-20">Useful Links</h2>
                    <ul class="list-st-none padding-l-0">
                        <li class="mr-b-20"><a href="<?php echo base_url(); ?>" class="libre-franklin-regular font-s-14 color-646568"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Home</a></li>
                        <li class="mr-b-20"><a href="<?php echo base_url('profile/addlisting'); ?>" class="libre-franklin-regular font-s-14 color-646568"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Add Listings</a></li>
                        <li class="mr-b-20"><a href="<?php echo base_url('page/about-us'); ?>" class="libre-franklin-regular font-s-14 color-646568"><i class="fa fa-angle-double-right" aria-hidden="true"></i> About Us</a></li>
                        <li class="mr-b-20"><a href="<?php echo base_url('page/contact-us'); ?>" class="libre-franklin-regular font-s-14 color-646568"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Contact Us</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-4 footer-social">
                <div class="row">
                    <h2 class="georgia font-s-24 text-uppercase color-646568 mr-b-20">Follow us on:</h2>
                    <div class="col-md-5 mr-b-30"><a href="tel:626-793-6300" class="libre-franklin-medium font-s-14 color-646568"><i class="fa fa-phone" aria-hidden="true"></i> 09771228673</a></div>
                    <div class="col-md-12">
    					<div class="row">
	                        <div class="col-md-12 mr-b-30">
		    					<ul class="inline-block social-ul">
		                            <li><a href="https://www.facebook.com/condopi" target="_blank" class="facebook bg-blue"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
		                            <li><a href="https://www.instagram.com/sevendaylistings/" target="_blank" class="instagram bg-white"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
		                            <li><a href="https://twitter.com/condopi" target="_blank" class="twitter bg-white"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
									<li><a href="https://www.linkedin.com/company/condopi" target="_blank" class="linkedin bg-white"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
		                        </ul>
							</div>
						</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid copyright">
        <div class="row">
    		<div class="col-md-12 text-center mr-t-30 mr-b-20 color-646568"><p>© Condopi.com  <a class="color-646568" href="<?php echo base_url('page/term-of-user'); ?>">Terms</a>  <a class="color-646568" href="<?php echo base_url('page/privacy'); ?>">Privacy</a></p></div>
    	</div>
    </div>
</footer>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script type="text/javascript">
    var Check = false;
    var imNotARobot = function($data) {
        $("#recaptcha-value").val($data);
        $("#submit-signin").removeAttr("disabled");
    };
    function resizeReCaptcha() {
      var width = 385;// $('.g-recaptcha').parent().width();
      if (width > 302) {
          var scale = width / 302;
      } else {
          var scale = 1;
      }
      $( ".g-recaptcha" ).css('transform', 'scale(' + scale + ')');
      $( ".g-recaptcha" ).css('-webkit-transform', 'scale(' + scale + ')');
      $( ".g-recaptcha" ).css('transform-origin', '0 0');
      $( ".g-recaptcha" ).css('-webkit-transform-origin', '0 0');
      $( ".g-recaptcha" ).css("margin-bottom","30px");
    };

    $(window).resize(function() {
        resizeReCaptcha();
    });

    $(document).ready(function () {
        resizeReCaptcha();
    });
    $('#ModalSignup').on('shown.bs.modal', function (e) {
		resizeReCaptcha();
    });
</script>
<script type="text/javascript">
    $(document).ready(function(){
        var width = $(".bx-slider").width();
        var slideWidth = width >= 768 ? (width/2-40) : width;
        $('.bx-slider').bxSlider({
            slideWidth: slideWidth,
            minSlides: 1,
            maxSlides : 2,
            pager: false,
            controls: true,
            auto: false,
            infiniteLoop: true,
            autoStart: false,
            slideMargin: 50,
            oneToOneTouch:false,
            touchEnabled:false
        });
    });
</script>
<?php
if( isset($thisishomepage) ){
?>
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
<?php
}
?>
    <?php 
        $config_site = $this->session->userdata('config_site');
        if ($config_site['Body_Json'] != null && $config_site['Body_Json'] != '') {
            $Body_Json = json_decode($config_site['Body_Json'], true);
        }
    ?>
    <div class="custom-loading" style="display: none;">
        <div>
            <img width="32" src="<?php echo base_url('skins/frontend/images/loading1.gif'); ?>">
        </div>
    </div>
    <style>
    .custom-loading {
        position: fixed;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        background: rgba(0, 0, 0, 0.55);
        z-index: 99999999;
        display: none;
    }
    .custom-loading > div {
        text-align: center;
        position: absolute;
        top: 43%;
        left: 0;
        width: 100%;
    }
    </style>
</body>
    <?php if(!(isset($is_login) && $is_login)): ?>
        <?php $this->load->view('frontend/block/account'); ?>
    <?php endif; ?>
    <script type="text/javascript">
    	function is_number(str) {
    		if (str == '')
    			return 0;
		    var pattern = /^[0-9 _ ,.$]*$/;
		    return pattern.test(str);
		}
        $(document).ready(function () {
            if ($.trim($('#page-title').html()) == '') {
                $('#page-title').html('off-market ● REO ● pocket listings');
            }
            $('form').submit(function () {
                var check = true;
                $(this).find('.number').each(function () {
        			if (!is_number($(this).val()) && $(this).hasClass('required')) {
                    	$(this).addClass('border-error');
                        check = false;
                    } else {
                        $(this).removeClass('border-error');
                    }
                });
                if (!check) {
                    var top = $(this).offset().top - 120;
                    $("body,html").animate({ scrollTop: top }, 'slow');
                    return false;
                }
                $(this).find('.required').each(function () {
                    var val = $(this).val();
                    var type = $(this).attr('type');
                    type == (typeof(type) == 'undefined') ? $(this)[0].tagName : type;
                    if (type != 'checkbox' && type != 'hidden') {
                        if (val == '' || val == null) {
                            $(this).addClass('border-error');
                            check = false;
                        }
                        else {
                            if (type == 'email') {
                                var pattern = /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;
                                if (pattern.test(val)) {
                                    $(this).removeClass('border-error');
                                }
                                else {
                                    $(this).addClass('border-error');
                                    check = false;
                                }
                            } else if ($(this).hasClass('number') && !is_number(val)) {
                            	$(this).addClass('border-error');
                                check = false;
                            } else {
                                $(this).removeClass('border-error');
                            }
                        }
                    }
                });
                if (!check) {
                    var top = $(this).offset().top - 120;
                    $("body,html").animate({ scrollTop: top }, 'slow');
                }
                else{
                    $(".custom-loading").show();
                }
                return check;
            });
        });
    </script>  


    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-89162252-2"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
      gtag('config', 'UA-89162252-2');
    </script>
</html>