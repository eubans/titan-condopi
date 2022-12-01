	<div class="item">
        <div class="item-img">
			<?php
			$img_video = '';
			if(!empty($item['Videos'])) {
				$img_video = '<img style="width:100%;object-fit:contain;position:absolute;z-index:10;left:0px;"  src="'.base_url("skins/frontend/images/youtube.png").'" alt="">';
			}
			$listtype = getDetailListingType($item["ListingType"]);
			if (!empty($listtype)) : ?>
				<div class="maker-category <?php echo slugify($listtype); ?>">
					<p class="libre-franklin-semiBold font-s-12"><?php echo $listtype; ?></p>
				</div>
			<?php endif; ?>
            <a class="placeholderimg" style="position:relative;" href="<?php echo get_link_item($item); ?>"><img src="/thumb.php?src=<?php echo base_url($item["HeroImage"]); ?>&size=263x270" alt="" /><?php echo $img_video; ?></a>
            
        	<?php if (isset($is_login)) : ?>
				<?php if (!empty($list_favorite) && in_array($item["ID"],explode(",",$list_favorite))) : ?>
            		<div class="bg-maker-like"><a class="maker-like actived" href="<?php echo base_url('profile/like/?id='.$item["ID"].'&url='.urlencode($_SERVER['REQUEST_URI'])); ?>" title="Click here to remove favorite"><i class="fa fa-heart-o" aria-hidden="true"></i></a></div>
    			<?php else : ?>
    				<div class="bg-maker-like"><a class="maker-like" href="<?php echo base_url('profile/like/?id='.$item["ID"].'&url='.urlencode($_SERVER['REQUEST_URI'])); ?>" title="Click here to add favorite"><i class="fa fa-heart-o" aria-hidden="true"></i></a></div>
    			<?php endif; ?>
			<?php else : ?>
				<div class="bg-maker-like"><a href="#" class="maker-like favorite" title="Please login before add favorite"><i class="fa fa-heart-o" aria-hidden="true"></i></a></div>
			<?php endif; ?>
			 <?php echo ((!empty($list_comment) && in_array($item["ID"],explode(",",$list_comment))) ? '<div class="maker-comment"><i class="fa fa-comment" aria-hidden="true"></i></div>' : ""); ?>
        </div>
        <div class="item-title">
            <a href="<?php echo get_link_item($item); ?>"><h2 class="georgia font-s-20 color-2b2b33"><?php echo $item["County"] ; ?></h2></a>
        </div>
        <div class="item-address">
            <a href="<?php echo get_link_item($item); ?>"><p class="verdana font-s-14 color-2b2b33"><?php echo ucfirst(strtolower($item["Address"])); ?><br><?php echo ucfirst(strtolower($item["County"])); ?>, <?php echo ucfirst(strtolower($item["City"])); ?></p></a>
            <div class="maker-localtion"><a target="_blank" href="https://www.google.com/maps/place/<?php echo strtolower($item['Address'] . ',' . $item['County'].', '.$item['City']);?>"><i class="fa fa-map-marker" aria-hidden="true"></i></a></div>
        </div>
        <div class="item-price">
            <div class="row">
                <div class="col-xs-6 text-left"><a href="<?php echo get_link_item($item); ?>"><p class="item-price georgia font-s-20 color-2b2b33">₱<?php echo number_format($item["Price"]); ?></p></a></div>
                <div class="col-xs-6 text-right"><a href="<?php echo get_link_item($item); ?>"><p class="days-left georgia font-s-16 color-f12a53 line-height-2"><?php echo $item["DayLeft"]; ?> day(s) left</p></a></div>
            </div>
        </div>
        <hr>
        <div class="item-description">
            <a href="<?php echo get_link_item($item); ?>"><p class="verdana font-s-14 color-646568 ellipsis"><?php echo $item["Summary"]; ?></p></a>
        </div>
    </div>
