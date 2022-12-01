<div class="site-content-top subnav-outer">
    <div class="container">
        <a class="btn-collapse hidden-sm hidden-md hidden-lg" role="button" data-toggle="collapse" href="#subnav-list" aria-expanded="false" aria-controls="subnav-list">Profile</a>
        <ul id="subnav-list" class="subnav-list collapse">
            <li>
                <a href="<?php echo base_url('/profile/'); ?>" aria-selected="true" class="subnav-item" id="user-profile-item">Profile</a>
            </li>
            <li>
                <a href="<?php echo base_url('profile/product/'); ?>" class="subnav-item" id="user-product">Listings</a>
            </li>
            <li>
                <a href="<?php echo base_url('profile/history_order/'); ?>" class="subnav-item" id="user-product">Orders</a>
            </li>
            <li>
                <a href="<?php echo base_url('profile/owner_order/'); ?>" class="subnav-item" id="user-product">Admin Payment</a>
            </li>
        </ul>
    </div>
</div>
<script type="text/javascript">
    var current_url = window.location.href;
    var url;
    $.each ($(".site-content-top #subnav-list li a"),function(){
        url = $(this).attr("href");
        if(current_url == url){
            $(this).attr("aria-selected","true");
        }else{
            $(this).attr("aria-selected","false");
        }
    });
</script>