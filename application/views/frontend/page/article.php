<div class="container">
	<?php if(isset($article['Color']) && !empty($article['Color'])) : ?>
    	<div class="row heading-title-page">
            <div class="col-sm-12">
                <div class="page-content libre-franklin-regular" style="background:url('<?php echo skin_url(); ?>frontend/images/header-blank-transparent.png') no-repeat bottom <?php echo @$article['Color']; ?>;border:none;background-size:100%;">
                    <?php if(@$article['Name'] != null): ?>
                        <p class="category"><?php echo @$category['Name']; ?></p>
                    <?php endif; ?>
                    <h2><?php echo @$article['Name']; ?></h2>
                    <?php if(@$article['Author'] != null || @$article['Date'] != null): ?>
                        <p class="author"><?php echo @$article['Author'] . ' &nbsp;&nbsp;&nbsp; '. @$article['Date']; ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
	<?php endif; ?>
    <div class="row">
        <div class="col-sm-12">
            <div class="page-content libre-franklin-regular">
                <?php echo @$article['Content']; ?>
                <?php if(@$article['CTA'] != null): ?>
                    <p class="text-cta"><strong><?php echo @$article['CTA']; ?></strong></p>
                <?php endif; ?>
                <?php if(@$article['Button_Text'] != null): ?>
                    <p class="text-center">
                        <a href="<?php echo @$article['Button_Url']; ?>" class="btn btn-CTA"><?php echo @$article['Button_Text']; ?></a>
                    </p>
                <?php endif; ?>
                <?php if(@$article['Disclaimer'] != null): ?>
                    <div style="height: 10px;"></div>
                    <?php echo @$article['Disclaimer']; ?>
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
    	text-align: center;color: white;font-size: 36px;margin: 20px auto;
    }
    .heading-title-page .category{color: #fff;font-weight: 400;text-align: center;margin-bottom: 0;font-style: italic;font-style: 22px;}
    .heading-title-page .author{color: #fff;font-weight: 400;text-align: center;font-style: italic;font-style: 22px;}
    .heading-title-page .page-content {height:320px;}
    .btn-CTA{color: #fff !important;background-color: #f12a53;padding: 10px 25px;font-weight: 400;border-radius: 0;}
	.text-cta{font-size: 18px;color: #000;}
    @media(max-width:990px) {
		.heading-title-page h2 {
    		font-size: 24px;
    	}
    	.heading-title-page .page-content {height:200px;}
    }
</style>

<script type="text/javascript">
    $('#page-title').html('<?php echo @$article['Name']; ?>');
</script>