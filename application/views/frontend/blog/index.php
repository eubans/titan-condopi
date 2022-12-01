<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <h2 class="page-title"><?php echo @$title; ?></h2>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-9">
            <div class="list-post">
                <?php if(isset($blog) && $blog != null): ?>
                   <?php foreach ($blog as $key => $item): ?>
                        <article class="post-item">
                            <div class="row">
                                <div class="col-sm-4 block-content">
                                    <div class="bg-product" style="background-image:url('<?php echo $item['Media']; ?>');max-height:150px;margin-bottom:10px;"></div>
                                </div>
                                <div class="col-sm-8">
                                    <h3><a href="<?php echo base_url(); ?>blog/<?php echo $item['Slug']; ?>"><?php echo $item['Name']; ?></a></h3>
                                    <div class="description" style="margin-bottom:10px;"><?php echo $item['Summary']; ?></div>
                                    <p><a style="display: inline-block;color: #fff;" href="<?php echo base_url(); ?>blog/<?php echo $item['Slug']; ?>" class="btn btn-primary">Read More</a></p>
                                </div>
                            </div>
                        </article>
                   <?php endforeach; ?>
                <?php endif;?>
            </div>
            <div class="row">
                <div class="col-sm-12 text-center">
                    <?php echo $this->pagination->create_links();?>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="sidebar">
                <h3>Category</h3>
                <ul>
                    <?php if(isset($category) && $category != null): ?>
                        <?php foreach ($category as $key => $item): ?>
                            <li><i class="fa fa-angle-double-right" aria-hidden="true"></i>&nbsp;&nbsp; <a href="<?php echo base_url(); ?>category/<?php echo $item['Slug']; ?>"><?php echo @$item['Name']; ?></a></li>
                        <?php endforeach; ?>
                    <?php endif;?>
                </ul>
                <h3>Last Post</h3>
                <ul>
                    <?php if(isset($last_post) && $last_post != null): ?>
                        <?php foreach ($last_post as $key => $item): ?>
                            <li><i class="fa fa-angle-right" aria-hidden="true"></i>&nbsp;&nbsp; <a href="<?php echo base_url(); ?>blog/<?php echo $item['Slug']; ?>"><?php echo @$item['Name']; ?></a></li>
                        <?php endforeach; ?>
                    <?php endif;?>
                </ul>
            </div>
        </div>
    </div>
</div>
