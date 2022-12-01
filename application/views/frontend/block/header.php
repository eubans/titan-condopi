<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

	<?php if(isset($meta_share) && $meta_share != null){ ?>
	    <title><?php echo @$meta_share['title']; ?></title>
		<meta content="<?php echo @$meta_share['description']; ?>" name="description" />
	<?php }else{ ?>
	    <title><?php $config_site = $this->session->userdata('config_site'); $BODY_JSON = json_decode(@$config_site['Body_Json'],true); ?><?php echo @$BODY_JSON['Meta_Title']; ?></title>
		<meta content="<?php echo @$BODY_JSON['Meta_Keyword']; ?>" name="keywords" />
		<meta content="<?php echo @$BODY_JSON['Meta_Description']; ?>" name="description" />
	<?php } ?>

    <?php if(isset($meta_share) && $meta_share != null): ?>
    	<meta property="og:url"                content="<?php echo current_url(); ?>" />
		<meta property="og:title"              content="<?php echo @$meta_share['title']; ?>" />
		<meta property="og:description"        content="<?php echo @$meta_share['description']; ?>" />
		<meta property="og:image"              content="<?php echo @$meta_share['image']; ?>" />
    <?php endif; ?>

    <!-- Bootstrap -->
    <link href="<?php echo skin_url(); ?>frontend/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,300i,400,700" rel="stylesheet">
    <link href="<?php echo skin_url(); ?>frontend/fonts/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="<?php echo skin_url(); ?>frontend/css/awesome-bootstrap-checkbox.css" rel="stylesheet">
    <link href="<?php echo skin_url(); ?>frontend/css/bootstrap-grid-custom.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap/3/css/bootstrap.css" />
    <link href="<?php echo skin_url(); ?>frontend/css/jquery.bxslider.min.css" rel="stylesheet">
    <link href="<?php echo skin_url(); ?>frontend/css/style.css" rel="stylesheet">
    <link href="<?php echo skin_url(); ?>frontend/css/new_style.css" rel="stylesheet">
	<link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url("skins/frontend/images/logo.ico")?>">
	<link rel="apple-touch-icon" href="<?php echo base_url("skins/frontend/images/logo.ico")?>"/>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!--<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>-->
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="<?php echo skin_url(); ?>frontend/js/bootstrap.min.js"></script>
    <script src="<?php echo skin_url(); ?>frontend/js/main.js"></script>
    <script src="<?php echo skin_url(); ?>frontend/js/jquery.easing.1.3.js"></script>
    <script src="<?php echo skin_url(); ?>frontend/js/scrolling-nav.js"></script>
    <script src="<?php echo skin_url(); ?>frontend/js/jquery.bxslider.js"></script>

    <script type="text/javascript">
        var base_url = "<?php echo base_url(); ?>";
    </script>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    
    <!-- Include Required Prerequisites -->
    <script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    	
	<script type='application/ld+json'> 
		{
			"@context": "http://www.schema.org",
			"@type": "WebSite",
			"name": "Condo PI",
			"alternateName": "sevendaylistings",
			"url": "https://www.condopi.com/"
		}
	</script>

    <?php echo @$BODY_JSON['Google_Analyse']; ?>
    <?php if(@$is_show_search == 1) : ?>
    	<script>type_search = 'search';</script>
    <?php endif; ?>
</head>

<?php
    $user_info = $this->session->userdata('user_info');
	$reqtype = $this->input->get('type');
	$reqprice = $this->input->get('price');
	$reqlistingtype = $this->input->get('listingtype');
	
	$arrtype = array();
	$arrprice = array();
	$arrlistingtype = array();
	$is_show_filter = false;
	if (!empty($reqtype)) {
		$arrtype = explode(",",$reqtype);
	}
	if (!empty($reqprice)) {
		$arrprice = explode(",",$reqprice);
	}
	if (!empty($reqlistingtype)) {
		$arrlistingtype = explode(",",$reqlistingtype);
	}
	if (count($arrtype) > 1 || count($arrprice) > 1 || count($arrlistingtype) > 1) {
		$is_show_filter = true;
	}
?>
<body id="page-top" data-spy="scroll" class="<?php echo ($_SERVER['REQUEST_URI'] == "/" || strpos("/home/",$_SERVER['REQUEST_URI']) !== false) ? "home" : "page"; ?>" data-target=".navbar-fixed-top">
	<div class="top-bar">
		<div class="container">
			<ul>
                <li>
                    <a class="phone" href="tel:09771228673"><i class="fa fa-phone"></i> 09771228673</a>
                </li>
                <li>
                    <a class="email" href="mailto:support@condopi.com"><i class="fa fa-envelope"></i> support@condopi.com</a>
                </li>
    		</ul>
		</div>
	</div>
    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
        <div class="container">
            <div class="navbar-header page-scroll">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand page-scroll logo" href="<?php echo base_url(); ?>"><img alt="condopi" src="<?php echo base_url("skins/frontend/images/logo.png"); ?>"></a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse navbar-ex1-collapse" style="float: left;">
                <ul class="nav navbar-nav">
                    <!-- Hidden li included to remove active class from about link when scrolled up past about section -->
                    <li class="hidden">
                        <a class="page-scroll" href="<?php echo base_url(); ?>"></a>
                    </li>
                    <li>
                        <a class="page-scroll" href="/">Home</a>
                    </li>
                    <?php if (isset($is_login) && $is_login): ?>
	                <?php else: ?>
	                    <script type="text/javascript">
	                    	$(document).ready(function(){
	                    		$(".menu-add-listing").click(function(){
	                    			$("#ModalLogin #redirect").val('/profile/addlisting');
	                    			$("#ModalLogin").modal('show');
	                    			return false;
	                    		});	
	                    		$(".favorite").click(function(){
	                    			$("#ModalLogin #redirect").val('/');
	                    			$("#ModalLogin").modal('show');
	                    			return false;
	                    		});
	                    	});
	                    </script>
	                <?php endif; ?>

                    <li>
                        <a class="page-scroll" href="<?php echo base_url('page/about-us'); ?>">About Us</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="<?php echo base_url('page/resources'); ?>"> Resources</a>
                    </li>

                    <li>
                        <a class="page-scroll" href="<?php echo base_url('page/contact-us'); ?>">Contact Us</a>
                    </li>
                    <?php if (isset($is_login) && $is_login): ?>
	                    <?php if(@$user_info["is_admin"] == 0):?>
	                        <li class="avatar-item hidden-lg hidden-md">
	                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" style="display: inline-block;">Hello <?php echo isset($user['First_Name']) ? $user['First_Name'] : $user['first_name'] ; ?> <b class="caret"></b></a>
	                            <ul class="dropdown-menu message">
	                                <li><a href="<?php echo base_url(); ?>profile/">Edit Profile</a></li>
	                                <li><a href="<?php echo base_url(); ?>profile/listing">Your Listings</a></li>
	                                <li><a href="<?php echo base_url(); ?>profile/addlisting">Add Listing</a></li>
	                                <li><a href="<?php echo base_url(); ?>profile/favorites">Your Favorites</a></li>
	                                <li><a href="<?php echo base_url(); ?>profile/change_password">Change Password</a></li>
	                                <li><a href="<?php echo base_url(); ?>profile/logout">Log Out</a></li>
	                            </ul>
	                        </li>
	                    <?php else : ?>
	                        <li class="avatar-item hidden-lg hidden-md">
	                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" style="display: inline-block;">Hello Admin <b class="caret"></b></a>
	                            <ul class="dropdown-menu message">
	                                <li><a href="<?php echo base_url(); ?>profile/">Edit Profile</a></li>
	                				<li><a href="<?php echo base_url(); ?>admin/members">All Profiles</a></li>
	                				<li><a href="<?php echo base_url(); ?>admin/members/add">New Profile</a></li>
	                                <li><a href="<?php echo base_url(); ?>admin/listings">All Listings</a></li>
	                                <li><a href="<?php echo base_url(); ?>admin/listings/addlisting">New Listing</a></li>
	                        		<li><a href="<?php echo base_url(); ?>admin/profile/msg_management">Msg Management</a></li>
	                                <li><a href="<?php echo base_url(); ?>admin/profile/websetting">Web Setting</a></li>
	                                <li><a href="<?php echo base_url(); ?>admin/profile/change_password">Change Password</a></li>
	                                <li><a href="<?php echo base_url(); ?>admin/profile/logout">Log Out</a></li>
	                            </ul>
	                        </li>
	                    <?php endif; ?>
                    <?php else : ?>
	                    <li class="hidden-lg hidden-md"><a id="toggleclickwhentrue" href="#" data-toggle="modal" data-target="#ModalLogin">Log In</a></li>
	                    <li class="hidden-lg hidden-md"><a href="#" data-toggle="modal" data-target="#ModalSignup">Sign Up</a></li>
                    <?php endif; ?>
                </ul>
            </div>

            <!-- /.navbar-collapse -->
            <div class="collapse navbar-collapse" id="main-nav" style="float: right;">
                <ul class="nav navbar-nav navbar-right hidden-sm hidden-xs">
                    <?php if (isset($is_login) && $is_login): ?>
	                    <?php if(@$user_info["is_admin"] == 0):?>
	                        <li class="avatar-item">
	                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" style="display: inline-block;">Hello <?php echo isset($user['First_Name']) ? $user['First_Name'] : $user['first_name'] ; ?> <b class="caret"></b></a>
	                            <ul class="dropdown-menu message">
	                                <li><a href="<?php echo base_url(); ?>profile/">Edit Profile</a></li>
	                                <li><a href="<?php echo base_url(); ?>profile/listing">Your Listings</a></li>
	                                <li><a href="<?php echo base_url(); ?>profile/addlisting">Add Listing</a></li>
	                                <li><a href="<?php echo base_url(); ?>profile/favorites">Your Favorites</a></li>
	                                <li><a href="<?php echo base_url(); ?>profile/change_password">Change Password</a></li>
	                                <li><a href="<?php echo base_url(); ?>profile/logout">Log Out</a></li>
	                            </ul>
	                        </li>
	                    <?php else : ?>
	                        <li class="avatar-item">
	                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" style="display: inline-block;">Hello Admin <b class="caret"></b></a>
	                            <ul class="dropdown-menu message">
	                                <li><a href="<?php echo base_url(); ?>profile/">Edit Profile</a></li>
	                				<li><a href="<?php echo base_url(); ?>admin/members">All Profiles</a></li>
	            					<li><a href="<?php echo base_url(); ?>admin/members/add">New Profile</a></li>
	                                <li><a href="<?php echo base_url(); ?>admin/listings">All Listings</a></li>
	                                <li><a href="<?php echo base_url(); ?>admin/listings/addlisting">New Listing</a></li>
	            					<li><a href="<?php echo base_url(); ?>admin/profile/msg_management">Msg Management</a></li>
	            					<li><a href="<?php echo base_url(); ?>admin/profile/send_mail_client">Send mail to client</a></li>
	                                <li><a href="<?php echo base_url(); ?>admin/profile/websetting">Web Setting</a></li>
	                                <li><a href="<?php echo base_url(); ?>admin/profile/change_password">Change Password</a></li>
	                                <li><a href="<?php echo base_url(); ?>admin/profile/logout">Log Out</a></li>
	                            </ul>
	                        </li>
	                    <?php endif; ?>
                    <?php else : ?>
	                    <li><a href="#" class="color-f12a53 verdana font-s-14" data-toggle="modal" data-target="#ModalLogin">Log In</a></li>
	                    <li><a href="#" class="color-f12a53 verdana font-s-14" data-toggle="modal" data-target="#ModalSignup">Sign Up</a></li>
                    <?php endif; ?>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>
    
    <?php if (@$is_show_search != null) : ?>
    	<script type="text/javascript" src="<?php echo skin_url(); ?>frontend/images/jquery.multiple.select.js"></script>
		<link href="<?php echo skin_url(); ?>frontend/images/multiple-select.css" rel="stylesheet" type="text/css" media="all" />
		<!--[if IE]>
		<link type="text/css" href="<?php echo skin_url(); ?>frontend/images/ie-multiple-select.css" />
		<![endif]-->
		<script>
			function getSelectedDropDown(obj) {
				var instNames = $('#' + obj + ' option:selected');
			    var arrInstName = [];
			    $(instNames).each(function(index, item) {
			        arrInstName.push([$(this).val()]);
			    }); 
			    
			    if (arrInstName.Length <= 0) {
			    	return '';
			    }
			    
			    var tmp = arrInstName.join(",");
			    tmp = tmp.replace("%27s","&#39;");
				tmp = tmp.replace("'","&#39;");
				
				return tmp;
			}
			
			function onFilter() {
			    var city = $('select[name="city"').val();
			    var county = $('select[name="county"').val();
			    var type = getSelectedDropDown("type");
			    var price = getSelectedDropDown("price");
			    var listingtype = getSelectedDropDown("listingtype");
			    document.location.href="?city="+city+"&county="+county+"&type="+type+"&price="+price+"&listingtype="+listingtype;
			}
			
			function saveFilter() {
				var city = $('select[name="city"').val();
			    var county = $('select[name="county"').val();
			    var type = getSelectedDropDown("type");
			    var price = getSelectedDropDown("price");
			    var listingtype = getSelectedDropDown("listingtype");
			    
			    setCookie("city", city, 7);
			    setCookie("county", county, 7);
			    setCookie("type", type, 7);
			    setCookie("price", price, 7);
			    setCookie("listingtype", listingtype, 7);
			    
			    alert('Saved successfully!');
			}
			
			function resetFilter() {
				setCookie("city", "", -1);
			    setCookie("county", "", -1);
			    setCookie("type", "", -1);
			    setCookie("price", "", -1);
			    setCookie("listingtype", "", -1);
			    alert('Cleared successfully!');
			    document.location.href="/";
			}

			$(function() {
				$('.buyer-seller .btn').click(function () {
					if ($(this).hasClass('active')) {
						$(this).removeClass('active');
						$(".buyer-seller .fivecolumns").hide();
						return false;
					}
					var index = $(this).attr("data-index");
					$('.buyer-seller .btn').removeClass('active');
					$(this).addClass('active');
					$(".buyer-seller .fivecolumns").hide();
					$(".buyer-seller .fivecolumns:eq("+index+")").show();
					
				});
				
				$('.btn-search').click(function () {
					onFilter();
				});
				
			    //config mutil combox
			    if ($('[id=listingtype]').length > 0) {
				    $('[id=price]').multipleSelect({
				        width: '100%',
				        "placeholder": "All",
				        selectAll: true,
				        minimumCountSelected: 2,
				        selectAllText: 'All',
				        selectAllDelimiter: ['', '']
				    });
				    $('[id=listingtype]').multipleSelect({
				        width: '100%',
				        "placeholder": "All",
				        selectAll: true,
				        minimumCountSelected: 2,
				        selectAllText: 'All',
				        selectAllDelimiter: ['', '']
				    });
				}
    		});
		</script>
		
		<section class="homepage-image" style="">
		    <div class="container content-image-header">
		        <h1 class="times_new_roman">
		        	<!--The <span style="color: #f12a53; font-weight: bold;">#1</span> source for condominiums in the Philippines-->
		        	<img src="<?php echo skin_url(); ?>frontend/images/slogan.png" title="The #1 source for condominiums in the Philippines" />
		        </h1>
				<div style="margin-left: 0px; margin-top: 50px;">
					<a href="#" data-toggle="modal" data-target="#ModalSignup" class="in_page_action_button_red libre-franklin-regular" style="margin-top: 100px;">
						<img src="<?php echo skin_url(); ?>frontend/images/join-now.png" title="Join Now" />
					</a>
				</div>
		    </div>
		</section>
		
		<section class="section section-padding-b-40 search-mutiple-section">
		    <div class="blok-search-mutiple">
		        <div class="container">
		        	<?php if ($is_show_filter) : ?>
		        	<div class="row">
		        		<div class="col-md-12">
		        			<a onclick="$('.saveFilterBar').toggle();" style="text-decoration:underline;cursor:pointer;">Saved Filters</a>
			        		<span class="saveFilterBar" style="display:none;padding-left:20px;">
			        			<button type="button" onclick="saveFilter()" class="btn btn-primary mb-2">Save</button>
			        			<button type="button" onclick="resetFilter()" class="btn btn-default mb-2">Clear</button>
			        		</span>
			       		</div>
		        	</div>
		        	<?php endif; ?>
		            <div class="row">
		    			<div class="col-md-12">
			                <form method="get" class="form search-form">
			            		<ul>
			                        <li>
			                            <label class="libre-franklin-regular font-s-14">City:</label>
			                            <select name="city" class="search-bar libre-franklin-medium font-s-15">
			                                <option value="All">All</option>
			                                <?php echo getListCounty($this->input->get("city")); ?>
			                            </select>
			                        </li>
			                        <li>
			                            <label class="libre-franklin-regular font-s-14">District:</label>
			                            <select name="county" class="search-bar libre-franklin-medium font-s-15">
			                                <option value="All">All</option>
			    							<?php echo getListCity($this->input->get("county"),false,""); ?>
			                            </select>
			                        </li>
			                        <li>
			                            <label class="libre-franklin-regular font-s-14">Type:</label>
			                            <select class="search-bar libre-franklin-medium font-s-15" name="type" id="type">
											<option value="All">All</option>
			                                <?php echo getListType($arrtype); ?>
			                            </select>
			                        </li>
			                        <li>
			                            <label class="libre-franklin-regular font-s-14">Price:</label>
			                            <?php
				                            $Price = [
				                                '0-5000000'     => '< P5m',
				                                '5000000-10000000'  => 'P5m - P10m',
				                                '10000000-20000000'  =>'P10m - P20m',
				                                '20000000-50000000'  => 'P20m - P50m',
				                                '50000000'     => '> P50m'
				                            ];
				                        ?>
				                        <select name="price" id="price" class="search-bar libre-franklin-medium font-s-15" multiple="multiple">
				                            <?php foreach ($Price as $key => $value) {
				                            	if (is_array($arrprice) && in_array(trim($key),$arrprice))
				                                    echo '<option value="'.$key.'" selected>'.$value.'</option>';
				                                else
				                                    echo '<option value="'.$key.'">'.$value.'</option>' ;
				                            }?>
				                        </select>
			                        </li>
			                        <li>
			                            <label class="libre-franklin-regular font-s-14">Listing:</label>
			                            <select class="search-bar libre-franklin-medium font-s-15" name="listingtype" id="listingtype" multiple="multiple">
			                                <?php echo getListListingTypeView($arrlistingtype); ?>
			                            </select>
			                        </li>
			                        <li>
			                           <a class="btn-search libre-franklin-semiBold">Filter Results</a>
			                        </li>
			                    </ul>
			                </form>
		                </div>
		            </div>
		        </div>
			</div>
		</section>
    <?php endif;?>

	<div class="section section-body<?php echo (@$not_show_banner != null) ? ' not-banner' :'';?>">