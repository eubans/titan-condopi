<?php
//this is triggered when the ad BECOMES VISIBLE IN THE SCREEN
//use jQuery to make sure that element opf ad becomes visible on the screen and then
//make post call to this file

if( !isset($_POST['manualAdID']) ){
	exit;
}

ob_start();
include('index.php');
ob_end_clean();

$CI =& get_instance();
$CI->load->library('session'); //if it's not autoloaded in your CI setup

echo '<pre>';
echo print_r($CI->session->userdata('user_info'));
echo '</pre>';

$memberid = '0';
if( $CI->session->userdata('user_info') ){
	$userinfo = $CI->session->userdata('user_info');

	$memberid = $userinfo['id'];
}

echo $memberid.'<br>';

$mysqli = new mysqli("localhost", "i50wpgkm_admin7d", "7DLax5pa55", "i50wpgkm_7daylisting_trax");

//$manualAdID = '0';
$manualAdID = $mysqli->real_escape_string($_POST['manualAdID']);

if (mysqli_connect_errno()) {
	printf("Connect failed: %s\n", mysqli_connect_error());
	exit();
}

$query_ad = "
select * from 
Manual_Ads
where
id = '".$manualAdID."'
";
$result = $mysqli->query($query_ad);
if($result->num_rows == 0){
	$mysqli->close();
	exit;
}

$mysqli->query("
insert into Manual_Ads_Impressions(
	Member_ID,
	Manual_Ad_ID,
	date_viewed,
	ip_address,
	session_token,
	user_agent
)values(
	'".$memberid."',
	'".$manualAdID."',
	now(),
	'".$_SERVER['REMOTE_ADDR']."',
	'',
	'".$_SERVER['HTTP_USER_AGENT']."'
)
");

$insertid = $mysqli->insert_id;

$CI->session->set_userdata( 'manadtkn', md5( $insertid ) );
$sessiontoken = $CI->session->userdata('manadtkn');

$mysqli->query("
update Manual_Ads_Impressions
	set session_token = '".$sessiontoken."'
where
	id = '".$insertid."'
");

echo $sessiontoken;

$mysqli->close();
?>
