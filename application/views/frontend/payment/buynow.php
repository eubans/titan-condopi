<div class="container">
    <div class="row">
        <div class="col-sm-4">
            <h2>Listing Information</h2>

            <?php if(!empty($product['Name'] || $product['City'] || $product['State'] || $product['Zipcode'])):?>
                <p class="meta-main address" style="text-transform:capitalize;">
                    Property: <br> <?php echo strtolower($product['Address'] . '<br/>' . $product['City'].' '.$product['State'].' '.$product['Zipcode']); ?>
                </p>
            <?php endif; ?> 

            <?php
                $btnLabel = "Buy Now Price";
                $readonly = "readonly";
            	$listing_price = "₱".number_format($listing_price);
            	$offered = "₱".number_format($offered);
            	$final_price = "₱".number_format($final_price);
            	$deposit = "₱".number_format($deposit);
            ?>
                <p class="meta-price">
                    Listing Price:<br>
                    <strong><?php echo $listing_price; ?></strong>
                </p>
                <?php if ($commission > 0 && $is_estate == 1) : ?>
                <p class="meta-price">
                    Commision Price:<br>
                    <strong><?php echo $offered; ?></strong>
                </p>
                <p class="meta-price">
                    Final Price:<br>
                    <strong><?php echo $final_price; ?></strong>
                </p>
               	<?php endif; ?>
                <p class="meta-price">
                    Showing Instructions:<br>
                    <strong><?php 
                        echo @$product['Showing_Instructions']
                    ?></strong>
                </p>
            
        </div>
        <div class="col-sm-6">
                <?php 
                    if ($this->session->flashdata('status')) : 
                        echo "
                        <p><i>SUCCESS!</i></p>
                        <p><i>Your offer and terms have been submitted.  We will prepare the contract for you to endorse and send it to you by email.</i></p>
                        <p><i>Please read these terms and conditions for more information on your purchase.</i></p>
                        <p><i>Please contact escrow and coordinate with them regarding you security deposit.</i></p>
                        <p><i>You have completed your transaction.  Thank you for using condopi.  We appreciate your business.</i></p>
                        ";
                        echo '<p><a href="/">go back to Listing Page</a></p>';
                    else : 
                        if($this->session->flashdata('message')){
                            echo  $this->session->flashdata('message');
                        }
                        if ($type != "buynow") {
                        	$readonly = "";
		                	$listing_price = "";
		                	$offered = "0";
		                	$final_price = "0";
		                	$btnLabel = "Offer Price";
		                }
                ?>
                <div class="row">
                    <div class="col-sm-12">
                        <form action="<?php echo "/payment/index/".$product["ID"]."?type=".$type; ?>" method="POST">
                        <div class="form-group">
                            <label class="label-control">Name:</label>
                            <div class="row">
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" name="first_name" readonly="readonly" value="<?php echo $user["first_name"]; ?>" placeholder="First Name">
                                </div>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" name="last_name" readonly="readonly" value="<?php echo $user["last_name"]; ?>" placeholder="Last Name">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="label-control">Email:</label>
                            <input type="email" class="form-control" name="email" value="<?php echo $user["email"]; ?>" readonly="readonly">
                        </div>
                    	<div class="form-group">
                            <label class="label-control"><?php echo $btnLabel; ?>:</label>
                            <input type="text" class="form-control number" maxlength="20" name="offer" <?php echo $readonly; ?> value="<?php echo $listing_price; ?>" required placeholder="₱">
                        </div>
		                <div class="form-group <?php echo $is_estate ? "" : "hide"; ?>">
                            <label class="label-control">Commission:</label>
                            <input type="text" class="form-control number" maxlength="20" name="commission" <?php echo $readonly; ?> value="<?php echo $offered; ?>" required placeholder="₱">
                        </div>
		            	<div class="form-group <?php echo $is_estate ? "" : "hide"; ?>">
                            <label class="label-control">Final Price:</label>
                            <input type="text" class="form-control number" maxlength="20" name="final_price" readonly value="<?php echo $final_price; ?>" required placeholder="₱">
                        </div>
                    	<div class="form-group">
                            <label class="label-control">Financing Terms:</label>
                            <div>
                                <label><input type="checkbox" name="financing[]" value="All Cash"> All Cash</label>
                            </div>
                            <div>
                                <label><input type="checkbox" name="financing[]" value="Hard Money"> Hard Money (see below for available options from our sponsors)</label>
                            </div>
                    		<div>
                                <label><input type="checkbox" name="financing[]" value="Loan"> Other Loan</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="label-control">Notes to Seller:</label>
                            <textarea rows="5" class="form-control" name="message" maxlength="140" required></textarea>
                        </div>
                    	<div class="form-group">
                            <label class="label-control">Available Services from our Affiliates:</label>
                        </div>
                        <div class="form-group" style="display:none;">
                            <label class="label-control"><input type="checkbox" name="Allow_Commission" value="1" <?php if($this->input->get("allow") == 1) echo "checked";?>> I would like to hire a real estate agent to help me through my transaction for a minimal fee.</label>
                        </div>
                    	<div class="form-group">
                            <label class="label-control"><input type="checkbox" name="Is_Hard_Money" value="1" /> I am interested in more information on asset-based private money loan</label>
                        </div> 
                    	<?php /*<div class="form-group">
                            <div style="height:auto;padding:10px;border:1px solid #ccc" class="form-control" readonly name="Hard_Money_Note">No qualifying, 10% interest, Interest only, 12 month term, 2 points No-prepayment penalty, will loan up to 70% of purchase price.</div>
                        </div> */ ?>
                    	<div class="form-group text-right">
                            By clicking <span style="color: #f12a53; font-weight: bold;">SUBMIT</span> you agree to Condo PI' <a href="<?php echo base_url("page/terms-and-conditions"); ?>" target="_blank">terms and conditions</a>.
                        </div>
                        <div class="form-group text-right">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                        
                        </form>
                    </div>
                </div>
                <?php endif; ?>
        </div>
        <div class="col-sm-2">
            <?php $this->load->view('frontend/profile/contact-info'); ?>
        </div>
    </div>
</div>

<script type="text/javascript">
function final_price() {
	var listing_price = $('input[name="offer"]').val();
	var commission = $('input[name="commission"]').val();
	listing_price = get_only_number(listing_price);
	commission = get_only_number(commission);
	listing_price = !is_number(listing_price) ? 0 : listing_price;
	commission = !is_number(commission) ? 0 : commission;
	finalprice = parseFloat(listing_price) + parseFloat(commission);
	
	return format_currency(finalprice);
}

$('input[name="offer"]').blur(function () {
	var val = $(this).val();
	val = get_only_number(val);
	if (!is_number(val)) {
		$(this).addClass('border-error');
		return false;
	}
	$(this).val(format_currency(val));
	$('input[name="final_price"]').val(final_price());
});

$('input[name="commission"]').blur(function () {
	var val = $(this).val();
	val = get_only_number(val);
	if (!is_number(val)) {
		$(this).addClass('border-error');
		return false;
	}
	$(this).val(format_currency(val));
	$('input[name="final_price"]').val(final_price());
});
</script>