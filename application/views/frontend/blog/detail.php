<div class="container">
    <div style="height:30px;"></div>
    <div class="row">
        <div class="col-sm-9">
            <div class="post-detail">
                <h3><?php echo @$post['Name']; ?></h3>
                <p>
                    <?php if(isset($post_category) && $post_category != null): ?>
                        Category: <a href="<?php echo base_url(); ?>category/<?php echo $post_category['Slug']; ?>"><?php echo $post_category['Name']; ?></a> - 
                    <?php endif; ?>
                    Post date: <?php echo date('m/d/Y',strtotime(@$post['Created_At'])); ?>
                </p>
                <div style="height:20px;"></div>
                <?php if(@$post['Media'] != null): ?>
                    <p><img src="<?php echo @$post['Media']; ?>" class="img-responsive"></p>
                <?php endif; ?>
                <div class="content">
                    <?php echo @$post['Content']; ?>
                    <div style="height:30px;"></div>
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
