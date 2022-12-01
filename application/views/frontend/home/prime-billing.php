<div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="page-content libre-franklin-regular">
                    <p class="card-errors"></p>
                    <form action="<?php echo base_url(); ?>submit-billing" id="paymentFrm" method="POST">
                        <div class="form-group row">
                            <label for="" class="col-sm-4 col-form-label">&nbsp;</label>
                                <div class="col-sm-4">
                                    <img class="img-fluid" src="<?php echo skin_url(); ?>/frontend/images/billing.jpg" />
                                    <?php if(isset($Member_Card)){ ?>
                                    <input type="checkbox" name="checkbox_billing" id="checkbox_billing" />
                                    <label class="checkbox_billing_style" for="checkbox_billing">
                                    xxxxxxxxxx<?php echo $Member_Card['Card_Number']; ?><br />
                                    <?php echo $Member_Card['Address']; ?> <br />
                                    <?php echo $Member_Card['Address_2']; ?><br />
                                    <?php echo $Member_Card['State']; ?> <?php echo $Member_Card['City']; ?> <?php echo $Member_Card['Zip_Code']; ?> 
                                    </label>
                                    <?php }?>
                                </div>
                                <?php if(isset($Member_Card)){ ?>
                                    <div class="button_edit col-sm-4">
                                        <a class="" href="#">edit</a>
                                    </div>
                                <?php }?>
                            </div>
                        <div class="style_list_form form-group row">
                            <label for="amount" class="col-sm-4 col-form-label">Amount:</label>
                            <div class="col-sm-4">
                                <input type="text" name="amount" value="$50.00" readonly="true" class="form-control" id="amount" />
                            </div>
                            <div class="col-sm-4">
                                recurring monthly payment
                            </div>
                        </div>
                        <div class="style_list_form form-group row">
                            <label for="card_type" class="col-sm-4 col-form-label">Card Type:</label>
                            <div class="col-sm-4">
                                <select name="card_type" id="card_type" class="form-control" >
                                    <option value="select">Select</option>
                                    <option value="Visa">Visa</option>
                                    <option value="Mastercard">Mastercard</option>
                                    <option value="American Express">American Express</option>
                                    <option value="Discover">Discover</option>
                                </select>
                            </div>
                        </div>
                        <div class="style_list_form form-group row">
                            <label for="card_number" class="col-sm-4 col-form-label">Card Number:</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="card_number" id="card_number" />
                            </div>
                        </div>
                        <div class="style_list_form form-group row">
                            <label for="cardholder_name" class="col-sm-4 col-form-label">Cardholder Name:</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="cardholder_name" id="cardholder_name"   />
                            </div>
                        </div>
                        <div class="style_list_form form-group row">
                            <label for="card_exp_month" class="col-sm-4 col-form-label">Expiration Date:</label>
                            <div class="col-sm-2">
                                <input type="text" name="card_exp_month" class="form-control" placeholder="MM" id="card_exp_month" />
                            </div>
                            <div class="col-sm-2">
                                <input type="text" name="card_exp_year" class="form-control" id="card_exp_year" placeholder="YYYY"  />
                            </div>
                        </div>
                        <div class="style_list_form form-group row">
                            <label for="card_cvc" class="col-sm-4 col-form-label">CVC:</label>
                            <div class="col-sm-4">
                                <input type="text" name="card_cvc" class="form-control" id="card_cvc"  />
                            </div>
                        </div>
                        <div class="style_list_form form-group row">
                            <label for="address" class="col-sm-4 col-form-label">Billing Address:</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="address" id="address" />
                            </div>
                            <div class="col-sm-4">address line 1</div>
                        </div>
                        <div class="style_list_form form-group row">
                            <label for="address_2" class="col-sm-4 col-form-label"></label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="address_2" id="address_2" />
                            </div>
                            <div class="col-sm-4">address line 2</div>
                        </div>
                        <div class="style_list_form form-group row">
                            <label for="city" class="col-sm-4 col-form-label"></label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="city" id="city" />
                            </div>
                            <div class="col-sm-4">city</div>
                        </div>
                        <div class="style_list_form form-group row">
                            <label for="state" class="col-sm-4 col-form-label"></label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="state" id="state" />
                            </div>
                            <div class="col-sm-4">state</div>
                        </div>
                        <div class="style_list_form form-group row">
                            <label for="zip_code" class="col-sm-4 col-form-label"></label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="zip_code" id="zip_code" />
                            </div>
                            <div class="col-sm-4">zip code</div>
                        </div>
                        <div class="style_list_form form-group row">
                            <div class="col-sm-4"></div>
                            <div class="col-sm-4">
                                <input type="checkbox" name="save_credit_info" id="save_credit_info" />
                                <label for="save_credit_info" class="col-form-label"> Save credit card information</label>
                            </div>
                        </div>
                        <div class="style_list_form form-group row">
                            <label for="promo_code" class="col-sm-4 col-form-label">Promo Code:</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="promo_code" id="promo_code" />
                            </div>
                        </div>
                        <div class="style_list_form form-group row">
                            <label for="promo_code" class="col-sm-4 col-form-label"></label>
                            <div class="col-sm-4 style_submit">
                                <button type="submit" id="payBtn" class="style_submit_detail btn btn-danger">SUBMIT</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<script src="https://js.stripe.com/v2/"></script>
<script>
// Set your publishable key
Stripe.setPublishableKey('<?php echo $this->config->item('stripe_publishable_key'); ?>');
// Callback to handle the response from stripe
function stripeResponseHandler(status, response) {
    if (response.error) {
        // Enable the submit button
        $('#payBtn').removeAttr("disabled");
        // Display the errors on the form
        $(".card-errors").html('<p>'+response.error.message+'</p>');
        $(".custom-loading").css('display','none');
    } else {
        var form$ = $("#paymentFrm");
        // Get token id
        var token = response.id;
        // Insert the token into the form
        form$.append("<input type='hidden' name='stripeToken' value='" + token + "' />");
        // Submit form to the server
        form$.get(0).submit();
    }
}

$(document).ready(function() {
    // On form submit
    $("#paymentFrm").submit(function() {
        
        if($("#checkbox_billing").prop("checked") == true){
            $("#paymentFrm").attr('action','<?php echo base_url(); ?>submit-billing-auto');
                // Disable the submit button to prevent repeated clicks
                $('#payBtn').attr("disabled", "disabled");
        		
                
                //Stripe.createToken({
//                    number: $('#card_number').val(),
//                    exp_month: $('#card_exp_month').val(),
//                    exp_year: $('#card_exp_year').val(),
//                    cvc: $('#card_cvc').val()
//                }, stripeResponseHandler);
//        		
//                return false;
        }else{
            if($("#card_type").val() == 'select'){
                $(".card-errors").html('<p>Select Card Type</p>');
                setTimeout(function(){
                    $(".custom-loading").css('display','none');
                }, 1000);
                
                return false;
            }else{
                $("#paymentFrm").attr('action','<?php echo base_url(); ?>submit-billing');
                // Disable the submit button to prevent repeated clicks
                $('#payBtn').attr("disabled", "disabled");
        		
                // Create single-use token to charge the user
                Stripe.createToken({
                    number: $('#card_number').val(),
                    exp_month: $('#card_exp_month').val(),
                    exp_year: $('#card_exp_year').val(),
                    cvc: $('#card_cvc').val()
                }, stripeResponseHandler);
        		
                // Submit from callback
                return false;
            }
            
        }
    });
    
});
</script>