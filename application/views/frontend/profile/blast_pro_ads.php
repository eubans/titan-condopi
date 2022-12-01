<?php $this->load->view('frontend/profile/nav'); ?>
<div class="container page-container">
    <div id="primary" class="content-area row">
        <aside id="aside" class="site-aside col-sm-3">
            <?php $this->load->view('frontend/profile/sidebar'); ?>
        </aside>
        <main id="main" class="site-main col-sm-9" role="main">
            <?php 
                if($this->session->flashdata('message')){
                    echo  $this->session->flashdata('message');
                }
            ?>
            <div class="panel panel-default">
                <div class="panel-heading">Social Media Blast:</div>
                <div class="panel-body">
                    <div class="row blast_pro_ads">
                        <div class="col-md-2 account_balance form-group">
                            <!--<label class="col-sm-6 col-form-label no-padding-right">Account Balance:</label>
                            <div class="col-sm-6 no-padding-left"><input readonly="true" class="form-control" type="text" value="<?php echo displayPrice(0, 2,'$','before'); ?>" /></div>-->
                        </div>
                        <div class="col-md-5 form-group">
                            <label class="col-sm-4 col-form-label no-padding-right">Ads Spend:</label>
                            <div class="col-sm-6 no-padding-left"><input readonly="true" class="form-control ads_spend" type="text" value="<?php echo displayPrice(0, 2,'$','before'); ?>" /></div>
                        </div>
                        <div class="col-md-2 button_buy_ads"><a href="<?php echo base_url(); ?>billing" class="bnt-ads">Buy Ads</a></div>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">Active Listings:</div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table ">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Address</th>
                                    <th>Image</th>
                                    <th colspan="3"><div class="text-center">Social Media Blast</div>
                                        <div class="row">
                                            <div class="col-md-4">S ($199)</div>
                                            <div class="col-md-4">G ($349)</div>
                                            <div class="col-md-4">P ($495)</div>
                                        </div>
                                    </th>
                                    <th>Total</th>
                                </tr>

                            </thead>

                            <tbody>
                            <?php
                            $listing_sessions = $this->session->userdata('listing_sessions');
                            ?>
                            <?php if (isset($listing_sessions) && $listing_sessions != null) : ?>
                                <?php foreach ($listing_sessions as $key => $item): ?>  
                                <tr <?php if( $item['DayLeft'] < 1 ){ echo 'style="opacity: 0.5;"'; } ?> >
                                    <td><?php echo $key+1; ?></td>
                                    <td>
                                    	<?php echo $item['Name']; ?>
                                    	<br>
                                    	<?php if( $item['DayLeft'] < 1 ){ echo '<span style="color: red;">Inactive</span>'; } ?>
                                    </td>
                                    <td><img width="70px" src="<?php echo $item['HeroImage']; ?>" /></td>
                                    <td><select <?php if( $item['DayLeft'] < 1 ){ echo 'disabled'; } ?> onchange="blast_number_one($(this),<?php echo $key; ?>,199,'blast_number_one')" class="form-control input_number_ads">
                                        <?php for($i=0;$i<=9;$i++){?>
                                        <option <?php if($item["blast_number_one"] == $i){echo 'selected="true"';} ?> value="<?php echo $i;?>"><?php echo $i;?></option>
                                        <?php } ?>
                                    </select></td>
                                    <td><select <?php if( $item['DayLeft'] < 1 ){ echo 'disabled'; } ?> onchange="blast_number_one($(this),<?php echo $key; ?>,349,'blast_number_two')" class="form-control input_number_ads">
                                        <?php for($i=0;$i<=9;$i++){?>
                                        <option <?php if($item["blast_number_two"] == $i){echo 'selected="true"';} ?> value="<?php echo $i;?>"><?php echo $i;?></option>
                                        
                                        <?php } ?>
                                    </select></td>
                                    <td><select <?php if( $item['DayLeft'] < 1 ){ echo 'disabled'; } ?> onchange="blast_number_one($(this),<?php echo $key; ?>,495,'blast_number_three')" class="form-control input_number_ads">
                                        <?php for($i=0;$i<=9;$i++){?>
                                        <option <?php if($item["blast_number_three"] == $i){echo 'selected="true"';} ?> value="<?php echo $i;?>"><?php echo $i;?></option>
                                        <?php } ?>
                                    </select></td>
                                    <td><input readonly="true" class="form-control input_number_ads_total" type="text" value="<?php echo displayPrice($item["total_money"], 2,'$','before'); ?>" /></td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
        </main>
    </div>
</div>

<script type="text/javascript">
$(document).ready(function(){
    $('.remove-item-gallery').click(function(){
        $(this).parent().remove();
        return false;
    });
});
function preview_image() {
    var total_file = document.getElementById("upload_file").files.length;
    $('#image_preview').html('');
    for(var i = 0; i < total_file; i++){
        $('#image_preview').append("<img style='float:left;height:100px;width:auto;margin-right:10px;margin-top:10px;' src='" + URL.createObjectURL(event.target.files[i]) + "'>");
    }
}
function hero_preview_image() {
    var total_file = document.getElementById("heroimage").files.length;
    for(var i = 0; i < total_file; i++){
        $('.hereimage-review').html("<img style='height:100px;width:auto;margin-right:10px;margin-top:10px;' src='" + URL.createObjectURL(event.target.files[i]) + "'>");
    }
}

function blast_number_one(o,key,value,field){
    var select = o.val();
    var money_select = parseFloat(o.parent().parent().find(".input_number_ads_total").val());
    var ads_spend = parseFloat($(".ads_spend").val());
    $.ajax({
            url:  "<?php echo base_url('profile/update_session')?>",
            data: {
                'key' : key,
                'field' : field,
                'value' : value,
                'select' : select
            },
            type: 'POST',
            dataType:'json',
            cache : false,
            success: function (response) {
                o.parent().parent().find(".input_number_ads_total").val(number_format(response.total_money_row,2));
                $(".ads_spend").val(number_format(response.total_money_all,2));
            },
            error: function (data) {
                alert("There was an error, please try again!");
            }
        });
    
    //if(select == 1){
//        money_select = money_select + value*select;
//        ads_spend = ads_spend + value*select;
//    }else if(select == 0){
//        money_select = money_select - value*select;
//        ads_spend = ads_spend - value*select;
//    }
//    alert(money_select);
//    money_select = number_format(money_select,2);
//    o.parent().parent().find(".input_number_ads_total").val(money_select);
//    ads_spend = number_format(ads_spend,2);
//    $(".ads_spend").val(ads_spend);
}
function number_format(number,decimals,dec_point,thousands_sep) {
    number  = number*1;//makes sure `number` is numeric value
    var str = number.toFixed(decimals?decimals:0).toString().split('.');
    var parts = [];
    for ( var i=str[0].length; i>0; i-=3 ) {
        parts.unshift(str[0].substring(Math.max(0,i-3),i));
    }
    str[0] = parts.join(thousands_sep?thousands_sep:',');
    return '$' + str.join(dec_point?dec_point:'.');
}
</script>