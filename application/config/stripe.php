<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
/* 
| ------------------------------------------------------------------- 
|  Stripe API Configuration 
| ------------------------------------------------------------------- 
| 
| You will get the API keys from Developers panel of the Stripe account 
| Login to Stripe account (https://dashboard.stripe.com/) 
| and navigate to the Developers >> API keys page 
| 
|  stripe_api_key            string   Your Stripe API Secret key. 
|  stripe_publishable_key    string   Your Stripe API Publishable key. 
|  stripe_currency           string   Currency code. 
*/ 
$config['stripe_api_key']         = 'sk_live_ZKEqTI5Xjh8RjPztpDf5ORXx00vBIcnLj7';// 'sk_test_ZjuWGxzo1iFW1pPjGju2f0Ng'; 
$config['stripe_publishable_key'] = 'pk_live_80sbdw4uxtXox7ViYphHawqg00FckOjSVx';// 'pk_test_W1l23Sqcodf5JahHuqfmxlcD'; 
$config['stripe_currency']        = 'usd';