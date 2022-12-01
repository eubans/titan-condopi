
    <div class="container content_page_receipt">
        <div class="row">
            <div class="col-sm-12">
                
                <div class="page-content libre-franklin-regular">
                    <h4>THANK YOU.</h4>
                    <h4>YOUR PAYMENT HAS BEEN PROCESSED.</h4>
                    <h4>A COPY OF YOUR RECEIPT HAS BEEN EMAILED TO YOU</h4>
                    <div class="payment_receipt">
                        <h2>RECEIPT</h2>
                        <div class="header_receipt">
                            <div class="wp_header">
                                <div class="left_wp_header">condopi.com</div>
                            </div>
                            <div class="wp_header">
                                <div class="left_wp_header">704 Mira Monte Place, Suite200</div>
                                <div class="right_wp_header">Tel: (626) 360-1699</div>
                            </div>
                            <div class="wp_header">
                                <div class="left_wp_header">Pasadena, Ca. 91101</div>
                                <div class="right_wp_header">Email: admin@condopi.com</div>
                            </div>
                        </div>
                        <div class="content_receipt" style="border-bottom: solid 8px #B9CCE5;">
                            <div class="wp_header ">
                                <div class="left_wp_header_ct">RECEIPT NO:</div>
                                <div class="right_wp_header_ct"><?php echo $orderID_receipt ?>-<?php echo $user_info['id'];?></div>
                            </div>
                            <div class="wp_header">
                                <div class="left_wp_header_ct">RECEIPT DATE:</div>
                                <div class="right_wp_header_ct"><?php echo date("m-d-Y",strtotime($created_at)); ?></div>
                            </div>
                            <div class="wp_header title_detail">
                                <div class="left_wp_header_ct">CLIENT SUMMARY:</div>
                            </div>
                            <div class="wp_header">
                                <div class="left_wp_header_ct padding_left">Name:</div>
                                <div class="right_wp_header_ct"><?php echo $user_info['full_name'];?></div>
                            </div>
                            <div class="wp_header">
                                <div class="left_wp_header_ct padding_left">Email:</div>
                                <div class="right_wp_header_ct"><a href="mailto:<?php echo $user_info['email'];?>"><?php echo $user_info['email'];?></a></div>
                            </div>
                            <div class="wp_header title_detail">
                                <div class="left_wp_header_ct">BIILLING SUMMARY:</div>
                            </div>
                            <div class="wp_header ">
                                <div class="left_wp_header_ct padding_left">Address:</div>
                                <div class="right_wp_header_ct cart_detail">&nbsp;
                                    <?php echo $member_card['Address'] ?> 
                                    <?php echo $member_card['City'] ?>
                                    <?php echo $member_card['State'] ?> <?php echo $member_card['Zip_Code'] ?>
                                </div>
                                <div class="left_wp_header_ct padding_left">Date:</div>
                                <div class="right_wp_header_ct cart_detail">
                                    <?php echo date("m-d-Y",strtotime($created_at)); ?>&nbsp;
                                </div>
                                <div class="left_wp_header_ct padding_left">Payment Method:</div>
                                <div class="right_wp_header_ct cart_detail">
                                    <?php echo $member_card['Card_Type'] ?> ********<?php echo $member_card['Card_Number'] ?>
                                </div>
                                <div class="left_wp_header_ct padding_left">Amount:</div>
                                <div class="right_wp_header_ct cart_detail">
                                    <?php echo displayPrice($receipt_payment['amount'], 2,'$','before'); ?>&nbsp;
                                </div>
                                <div class="left_wp_header_ct padding_left">Transaction Type:</div>
                                <div class="right_wp_header_ct cart_detail">
                                    <?php echo $receipt_payment['transaction_type'] ?>&nbsp;
                                </div>
                            </div>
                            <div class="wp_header title_detail">
                                <div class="left_wp_header_ct">ORDER DETAIL:</div>
                            </div>
                            <table class="table_receipt">
                                <tr>
                                    <th>Listings</th>
                                    <th colspan="3"><div class="text-center">Blast PRO</div>
                                        <div class="row">
                                            <div class="col-md-4">x1 ($99)</div>
                                            <div class="col-md-4">x2 ($199)</div>
                                            <div class="col-md-4">x3 ($349)</div>
                                        </div>
                                    </th>
                                    <th style="text-align: right;">Subtotal</th>
                                </tr>
                                <?php $total = 0; 
                                foreach($listtings as $listting){ ?>
                                <tr>
                                    <td><?php echo $listting['Name']; ?></td>
                                    <td style="width: 100px;"><?php if($listting['blast_number_one']) echo $listting['blast_number_one']; ?>&nbsp;</td>
                                    <td style="width: 100px;"><?php if($listting['blast_number_two']) echo $listting['blast_number_two']; ?>&nbsp;</td>
                                    <td style="width: 100px;"><?php if($listting['blast_number_three']) echo $listting['blast_number_three']; ?>&nbsp;</td>
                                    <td style="width: 140px;text-align: right;"><?php echo displayPrice($listting['total_money'], 2,'$','before'); ?></td>
                                </tr>
                                <?php 
                                $total = $total + $listting['total_money'];
                                } ?>
                                
                            </table>
                            <div class="row" style="width: 160px;float: right; margin-top: 10px; font-size: 16px; border-top: dashed;padding-top: 5px;">
                                <div style="float: left;width: 40%;">Total:</div>
                                <div style="float: right;width: 60%;"><?php echo displayPrice($total, 2,'$','before'); ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>