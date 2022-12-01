	<div class="item">
        <div class="item-img">
            <div class="maker-category">
    			<?php 
				$listtype = getDetailListingType($item["ListingType"]);
				if (!empty($listtype)) : ?>
					<p class="libre-franklin-semiBold font-s-12"><?php echo $listtype; ?></p>
				<?php endif; ?>
            </div>
            <a class="btn btn-default btn-lg <?php echo ((!empty($list_comment) && in_array($item["ID"],explode(",",$list_comment))) ? "comment" : ""); ?>" href="<?php echo site_url('listing/'.$item['ID'])?>"><img src="<?php echo $item["HeroImage"]; ?>" alt="" /></a>
            <div class="maker-like">
            	<?php if (isset($is_login)) : ?>
					<?php if (!empty($list_favorite) && in_array($item["ID"],explode(",",$list_favorite))) : ?>
                		<a href="<?php echo base_url('profile/like/?id='.$item["ID"].'&url='.urlencode($_SERVER['REQUEST_URI'])); ?>" title="Click here to remove favorite"><i class="fa fa-heart-o actived" aria-hidden="true"></i></a>
        			<?php else : ?>
        				<a href="<?php echo base_url('profile/like/?id='.$item["ID"].'&url='.urlencode($_SERVER['REQUEST_URI'])); ?>" title="Click here to add favorite"><i class="fa fa-heart-o" aria-hidden="true"></i></a>
        			<?php endif; ?>
				<?php else : ?>
					<a href="#" class="favorite" title="Please login before add favorite"><i class="fa fa-heart-o" aria-hidden="true"></i></a>
				<?php endif; ?>
            </div> 
        </div>
        <div class="item-title">
            <h2 class="georgia font-s-24 color-2b2b33"><?php echo $item["District"]; ?></h2>
        </div>
        <div class="item-address">
            <p class="verdana font-s-14 color-2b2b33"><?php echo $item["Address"]; ?><br><?php echo $item["City"]; ?>, <?php echo strtoupper(findShortName($item["State"])); ?> <?php echo $item["Zipcode"]; ?></p>
            <div class="maker-localtion"><i class="fa fa-map-marker" aria-hidden="true"></i></div>
        </div>
        <div class="item-price">
            <div class="row">
                <div class="col-md-6 text-left"><p class="item-price georgia font-s-24 color-2b2b33">$<?php echo number_format($item["Price"]); ?></p></div>
                <div class="col-md-6 text-right"><p class="days-left georgia font-s-18 color-f12a53"><?php echo $item["DayLeft"]; ?> day(s) left</p></div>
            </div>
        </div>
        <hr>
        <div class="item-description">
            <p class="verdana font-s-14 color-646568"><?php echo $item["Summary"]; ?></p>
        </div>
    </div>
