<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>
<body>

                <div style="width: 100%;">
                    <h4>THANK YOU.</h4>
                    <h4>YOUR PAYMENT HAS BEEN PROCESSED.</h4>
                    <h4>A COPY OF YOUR RECEIPT HAS BEEN EMAILED TO YOU</h4>
                    <div style="width: 100%;">
                        <h2 style="text-align: center;">RECEIPT</h2>
                        <div style="width: 100%;">
<table style="border-bottom: 20px #B9CCE5;border-top: 20px #B9CCE5;">
    <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td>condopi.com</td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td>704 Mira Monte Place, Suite200</td>
        <td>Tel: (626) 360-1699</td>
    </tr>
    <tr>
        <td>Pasadena, Ca. 91101</td>
        <td>Email: admin@condopi.com<br /></td>
    </tr>
</table>
<table>
    <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td>RECEIPT NO:</td>
        <td><?php echo $orderID_receipt ?>-<?php echo $user_info['id'];?></td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td>RECEIPT DATE:</td>
        <td><?php echo date("m-d-Y",strtotime($created_at)); ?></td>
        <td>&nbsp;</td>
    </tr>
</table>
<p>CLIENT SUMMARY:</p>
<table>
    <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Name:</td>
        <td><?php echo $user_info['full_name'];?></td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Email:</td>
        <td><a href="mailto:<?php echo $user_info['email'];?>"><?php echo $user_info['email'];?></a></td>
        <td>&nbsp;</td>
    </tr>
</table>
<p>BIILLING SUMMARY:</p>
<table>
    <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Address:</td>
        <td><?php echo $member_card['Address'] ?> 
            <?php echo $member_card['City'] ?>
            <?php echo $member_card['State'] ?> <?php echo $member_card['Zip_Code'] ?></td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Date:</td>
        <td><?php echo date("m-d-Y",strtotime($created_at)); ?></td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Payment Method:</td>
        <td><?php echo $member_card['Card_Type'] ?> ********<?php echo $member_card['Card_Number'] ?></td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Amount:</td>
        <td><?php echo displayPrice($receipt_payment['amount'], 2,'$','before'); ?></td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Transaction Type:</td>
        <td><?php echo $receipt_payment['transaction_type'] ?></td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
</table>


<div class="left_wp_header_ct">ORDER DETAIL:</div>

              
                         
                            <table class="table_receipt" style="border-bottom: 20px #B9CCE5;width: 100%;">
                                <tr style="width: 100%;">
                                    <td style="width: 40%;">&nbsp;</td>
                                    <td style="width: 15%">&nbsp;</td>
                                    <td style="width: 15%">Blast PRO</td>
                                    <td style="width: 15%">&nbsp;</td>
                                    <td style="width: 15%">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td style="text-align: center;">Listings</td>
                                    <td>x1 ($99)</td>
                                    <td>x2 ($199)</td>
                                    <td>x3 ($349)</td>
                                    <td style="text-align: right;">Subtotal</td>
                                </tr>
                                <tr>
                                    <td >&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                                <?php 
                                $total = 0;
                                foreach($listtings as $listting){ ?>
                                <tr>
                                    <td style=";"><?php echo $listting['Name']; ?></td>
                                    <td style="text-align: center;"><?php if($listting['blast_number_one']) echo $listting['blast_number_one']; ?></td>
                                    <td style="text-align: center;"><?php if($listting['blast_number_two']) echo $listting['blast_number_two']; ?></td>
                                    <td style="text-align: center;"><?php if($listting['blast_number_three']) echo $listting['blast_number_three']; ?></td>
                                    <td style="text-align: right;"><?php echo displayPrice($listting['total_money'], 2,'$','before'); ?></td>
                                </tr>
                                <?php 
                                $total = $total + $listting['total_money'];
                                } ?>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td style="text-align: right;">-----------</td>
                                </tr>
                                <tr>
                                    <td style="">&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td style="text-align: right;">Total:</td>
                                    <td style="text-align: right;"><?php echo displayPrice($total, 2,'$','before'); ?></td>
                                </tr>
                                <tr>
                                    <td style="">&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            
</body>