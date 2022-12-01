<div class="container">
	<?php if ( isset($page['Bgcolor']) && !empty($page['Bgcolor']) ) : ?>
	<div class="row heading-title-page">
        <div class="col-sm-12">
            <div class="page-content libre-franklin-regular" style="background:url('<?php echo skin_url(); ?>frontend/images/header-blank-transparent.png') no-repeat bottom <?php echo $page['Bgcolor']; ?>;border:none;background-size:100%;">
                <h2><?php echo @$page['Title']; ?></h2>
            </div>
        </div>
    </div>
	<?php endif; ?>
    <div class="row">
        <div class="col-sm-12">
            <div class="page-content libre-franklin-regular">
                <?php if(isset($categories) && $categories != null): ?>
                    <?php foreach ($categories as $key => $category): ?>
                        <?php if(@$category['articles'] != null): ?>
                            <p><?php echo @$category['Name']; ?></p>
                            <?php foreach ($category['articles'] as $key1 => $article): ?>
                                <p style="margin-left: 40px;">
                                    <a href="<?php echo base_url('/article/'.$article['Slug']); ?>">
                                        <u><?php echo $article['Name']; ?></u>
                                    </a>
                                </p>
                            <?php endforeach; ?>
                            <p>&nbsp;</p>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<p>&nbsp;</p>
<style type="text/css">
    .page-title{position: relative;margin-bottom: 20px;}
    .page-content{padding-bottom: 30px;border-bottom:0px;margin:0px;font-size:16px;}
    .page-content p, .page-content a {font-size:16px;font-family:'Libre Franklin',verdana;}
    .page-content p.dislaimer {font-size:12px;}
    .page-content .border-box ul {margin: 0px;padding: 0px 5px 0px 25px;}
    .page-content .border-box ul li {font-family:Georgia!important;margin-bottom:10px;}
    .page .section-body .heading-title2{
        font-family:Georgia!important;
    }
    .aboutus .border-box h3 {
        font-weight: 100!important;
    }
    .aboutus .border-box ul li {
        margin-bottom: 10px;
        font-family: 'Libre Franklin' !important;
        font-style: italic;
    }
    .aboutus .border-box{
        border-color: rgb(204, 207, 211) !important;
    }
    .aboutus .border-box:hover{
        border-color: #f12a53!important;
    }
    .heading-title-page {
    	margin-top:-50px;
    }
    .heading-title-page h2 {
    	text-align: center;color: white;font-size: 36px;margin: 30px auto 0px;
    }
    .heading-title-page .page-content {height:320px;}
	@media(max-width:990px) {
		.heading-title-page h2 {
    		font-size: 24px;
    	}
    	.heading-title-page .page-content {height:200px;}
    }
</style>

<script type="text/javascript">
    $('#page-title').html('<?php echo @$page['Title']; ?>');
</script>