<?php
//this is triggered when the ad is clicked, it goes here first CTR

ob_start();
include('index.php');
ob_end_clean();

$CI =& get_instance();
$CI->load->library('session'); //if it's not autoloaded in your CI setup

//echo '<pre>';
//echo print_r($CI->session->userdata('user_info'));
//echo '</pre>';

$memberid = '0';
if( $CI->session->userdata('user_info') ){
	$userinfo = $CI->session->userdata('user_info');

	$memberid = $userinfo['id'];
}

//echo $memberid.'<br>';

$mysqli = new mysqli("localhost", "i50wpgkm_admin7d", "7DLax5pa55", "i50wpgkm_7daylisting_trax");

//$session_token = $mysqli->real_escape_string($_GET['535510N']);
$session_token = $CI->session->userdata('manadtkn');

//echo $session_token;

if (mysqli_connect_errno()) {
	//printf("Connect failed: %s\n", mysqli_connect_error());
	exit();
}

$q = $mysqli->query("
select * from Manual_Ads_Impressions
where
	session_token = '".$session_token."'
");

if( $q->num_rows == 0 ){
	//echo 'NO TOKEN';
	$mysqli->close();
	exit;
}
$r = $q->fetch_assoc();

$a = $mysqli->query("
select * from Manual_Ads
where
	id = '".$r['Manual_Ad_ID']."'
");

if( $a->num_rows == 0 ){
	//echo 'NO AD';
	$mysqli->close();
	exit;
}
$ma = $a->fetch_assoc();
$clink = $ma['link'];

$mysqli->query("
insert into Manual_Ads_Clicks(
	Member_ID,
	Manual_Ad_ID,
	date_clicked,
	ip_address,
	session_token,
	user_agent
)values(
	'".$memberid."',
	'".$r['Manual_Ad_ID']."',
	now(),
	'".$_SERVER['REMOTE_ADDR']."',
	'".$session_token."',
	'".$_SERVER['HTTP_USER_AGENT']."'
)
");


$echo = '<meta http-equiv="refresh" content="0;url='.$clink.'">';

$mysqli->close();

echo $echo;
?>
