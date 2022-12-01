<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if ( ! function_exists('slugify'))
{
    function slugify($text)
    { 
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        return strtolower(preg_replace('/[^A-Za-z0-9-]+/', '-', $text));
    }
}
if ( ! function_exists('rename_file')){
    function rename_file($src,$folder,$name){
        $filePath     = $src;
        $fileObj      = new SplFileObject($filePath);
        $name_flie    = explode("/",$name);
        $RandomNum    = uniqid();
        $ImageName    = str_replace(' ', '-', strtolower($name_flie[(count($name_flie)-1)]));
        $ImageType    = explode(".",$name_flie[(count($name_flie)-1)]);
        $ImageType    = $ImageType[(count($ImageType)-1)];
        $ImageExt     = substr($ImageName, strrpos($ImageName, '.'));
        $ImageExt     = str_replace('.', '', $ImageExt);
        $ImageName    = str_replace("." . $ImageExt, "", $ImageName);
        $ImageName    = preg_replace("/.[[.s]{3,4}$/", "", $ImageName);
        $NewImageName = md5($ImageName).'_'.$RandomNum.'.'.$ImageExt;
        rename($filePath,FCPATH.$folder.$NewImageName);
        return $NewImageName;
    }
}
if ( ! function_exists('crop_image')){
    function crop_image($image,$type,$folder){
        $data=array("status"=>"error",'name'=>'');
        //$folder="/images/avatars/";
        if(isset($_POST['x']) && isset($_POST['y'])){
            $x=intval($_POST['x']);
            $y=intval($_POST['y']);
            $w=intval($_POST['w']);
            $h=intval($_POST['h']);
            $image_w=intval($_POST['image_w']);
            $image_h=intval($_POST['image_h']);
            if($w>0 && $h>0 && $image_w>0 && $image_h>0){
                    $src=".".$folder.$image;
                    $size = getimagesize($src);

                    $w_current = $size[0];
                    $h_current = $size[1];

                    $x *= ($w_current/$image_w);
                    $w *= ($w_current/$image_w);

                    $y *= ($h_current/$image_h);
                    $h *= ($h_current/$image_h);

                    $path = $folder. $image;
                    $dstImg = imagecreatetruecolor($w, $h);
                    $dat = file_get_contents($src);
                    $vImg = imagecreatefromstring($dat);
                    if($type=='png'){                        
                        imagealphablending($dstImg, false);
                        imagesavealpha($dstImg, true);
                        $transparent  = imagecolorallocatealpha($dstImg, 255, 255, 255, 127);
                        imagefilledrectangle($dstImg, 0, 0, $w, $h, $transparent);
                        //imagecolortransparent($dstImg, $transparent);
                        imagecopyresampled($dstImg, $vImg, 0, 0, $x, $y, $w, $h, $w, $h);
                        imagepng($dstImg, $src);
                    }
                    else{
                        imagecopyresampled($dstImg, $vImg, 0, 0, $x, $y, $w, $h, $w, $h);
                        imagejpeg($dstImg, $src);
                    }
                    imagedestroy($dstImg);
                    
                    $src=FCPATH .$folder.$image;
                    $name=rename_file($src,$folder,$image);
                    $data['name']=$name;
                    $data["status"]="success";
            }
        }
        return $data;  
    }
}
if (!function_exists('upload_flie')){
    function upload_flie($upload_path,$allowed_types,$file,$resize = null,$creathumb = null,$max_size = "auto",$max_width="auto",$max_height="auto")
    {
        $CI = get_instance();
        $data["status"] = "error";
        //config;
        $config['upload_path'] = $upload_path;
        $config['allowed_types'] = $allowed_types;
        if($max_size !="auto"){$config['max_size'] = $max_size;}
        if($max_width !="auto"){$config['max_width'] = $max_width;}
        if($max_height !="auto"){$config['max_height'] = $max_height;}
        $type = explode(".", $file['name']);
        $name = $type[0]."_".uniqid().".".$type[1];
        $name = gen_slug_st($name);
        $_FILES['file']['name']     = $name ;
        $_FILES['file']['type']     = $file['type'];
        $_FILES['file']['tmp_name'] = $file['tmp_name'];
        $_FILES['file']['error']    = $file['error'];
        $_FILES['file']['size']     = $file['size'];
        $CI->load->library('upload');
        $CI->upload->initialize($config);
        if (!$CI->upload->do_upload('file'))
        {
            $data["message"] = "Upload process an error please check back";
        }
        else
        {   
            $data["status"] ="success";
            $data["reponse"] = $CI->upload->data();
            if($resize != null){
                $config['image_library']  = 'gd2';
                $config['source_image']   = $data["reponse"]["full_path"];
                $config['maintain_ratio'] = TRUE;
                $config['width']          = @$resize["width"];
                $config['height']         = @$resize["height"];
                $CI->load->library('image_lib', $config);
                $CI->image_lib->clear();
                $CI->image_lib->resize();
            }
            if($creathumb != null){
                $config['source_image']   = $data["reponse"]["full_path"];
                $config['new_image']      = $data["reponse"]["file_path"]."thumbs_".$name;
                $config['maintain_ratio'] = FALSE;
                $config['width']          = $creathumb["width"];
                $config['height']         = $creathumb['height'];
                $config['quality']        = 100;
                $CI->load->library('image_lib', $config);
                $CI->image_lib->clear();
                $CI->image_lib->initialize($config);
                $CI->image_lib->resize();
                $data["reponse"]['name_thumb'] = "thumbs_".$name;
            }
            
        }
        return $data;

    }
}
if (!function_exists('gen_slug_st')){
    function gen_slug_st($str){
        $a = array('À','Á','Â','Ã','Ä','Å','Æ','Ç','È','É','Ê','Ë','Ì','Í','Î','Ï','Ð','Ñ','Ò','Ó','Ô','Õ','Ö','Ø','Ù','Ú','Û','Ü','Ý','ß','à','á','â','ã','ä','å','æ','ç','è','é','ê','ë','ì','í','î','ï','ñ','ò','ó','ô','õ','ö','ø','ù','ú','û','ü','ý','ÿ','A','a','A','a','A','a','C','c','C','c','C','c','C','c','D','d','Ð','d','E','e','E','e','E','e','E','e','E','e','G','g','G','g','G','g','G','g','H','h','H','h','I','i','I','i','I','i','I','i','I','i','?','?','J','j','K','k','L','l','L','l','L','l','?','?','L','l','N','n','N','n','N','n','?','O','o','O','o','O','o','Œ','œ','R','r','R','r','R','r','S','s','S','s','S','s','Š','š','T','t','T','t','T','t','U','u','U','u','U','u','U','u','U','u','U','u','W','w','Y','y','Ÿ','Z','z','Z','z','Ž','ž','?','ƒ','O','o','U','u','A','a','I','i','O','o','U','u','U','u','U','u','U','u','U','u','?','?','?','?','?','?');
        $b = array('A','A','A','A','A','A','AE','C','E','E','E','E','I','I','I','I','D','N','O','O','O','O','O','O','U','U','U','U','Y','s','a','a','a','a','a','a','ae','c','e','e','e','e','i','i','i','i','n','o','o','o','o','o','o','u','u','u','u','y','y','A','a','A','a','A','a','C','c','C','c','C','c','C','c','D','d','D','d','E','e','E','e','E','e','E','e','E','e','G','g','G','g','G','g','G','g','H','h','H','h','I','i','I','i','I','i','I','i','I','i','IJ','ij','J','j','K','k','L','l','L','l','L','l','L','l','l','l','N','n','N','n','N','n','n','O','o','O','o','O','o','OE','oe','R','r','R','r','R','r','S','s','S','s','S','s','S','s','T','t','T','t','T','t','U','u','U','u','U','u','U','u','U','u','U','u','W','w','Y','y','Y','Z','z','Z','z','Z','z','s','f','O','o','U','u','A','a','I','i','O','o','U','u','U','u','U','u','U','u','U','u','A','a','AE','ae','O','o');
        return strtolower(preg_replace(array('/[^a-zA-Z0-9,. -]/','/[ -]+/','/^-|-$/'),array('','-',''),str_replace($a,$b,$str)));
    }
}
if (!function_exists('ratio_image')){
   function ratio_image($original_width, $original_height, $new_width = 0, $new_heigh = 0) {
        $size['width'] = $new_width;
        $size['height'] = $new_heigh;
        if ($new_heigh != 0) {
            $size['width'] = intval(($original_wdith / $original_height) * $new_height);
        }
        if ($new_width != 0) {
            $size['height'] = intval(($original_height / $original_width) * $new_width);
        }

        return $size;
    }
}
if (!function_exists('breadcrumb')){
    function breadcrumb(){
        $CI  = get_instance();
        $url =  "{$_SERVER['REQUEST_URI']}";
        $url = explode("?", $url);
        $url = $url[0];
        $url = str_replace("index.php/", "", $url);
        $escaped_url = htmlspecialchars( $url, ENT_QUOTES, 'UTF-8' );
        $before = strlen($escaped_url) - 1 ;
        $after  = $before + 1;
        if(substr( $escaped_url,$before,$after)=="/"){
            $escaped_url = substr($escaped_url, 0, -1);
        }
        $escaped_url = explode( '/', $escaped_url );
        $html  = "";
        $url_mother = base_url();
        if(is_array($escaped_url)&& count($escaped_url)>2){
            $html = "<ol class='breadcrumb'>";
            for($i=0; $i<count($escaped_url) ;$i++){
                if($i>0){
                    $url_mother .= $escaped_url[$i]."/";
                    $title = str_replace("-"," ",$escaped_url[$i]);
                    $title = str_replace("_","/",$title);
                    $data_model = $CI->Common_model->get_record("Sys_Modules",array("Module_Key" =>$title));
                    if($data_model != null){
                        $title = $data_model["Module_Name"];
                        // If the function is category or post then find detail the function
                        if (($data_model["Module_Key"] == "post" || $data_model["Module_Key"] == "category") && isset($_GET["post_type"])) {
                            $data_model = $CI->Common_model->get_record("Sys_Modules",array("Module_Url" => "/".$data_model["Module_Key"]."/?post_type=" . $_GET["post_type"]));
                            if ($data_model != null) {
                                $url_mother .= $data_model["Module_Url"];
                                $title = $data_model["Module_Name"];
                            }
                        }
                    } else {
                        if($title == "backend"){
                            $title ="Dashboard";
                        }
                        if($title == "dashboard"){
                            $title = "";
                        }
                      
                        if($title == "profile"){
                            $title = 'Your profile';
                        }
                    }
                    if(is_numeric($title)){
                        $title = "";
                    }
                    $title = ucwords($title);
                    if($title != ""){
                        $content = "";
                        if($i == (count($escaped_url)-1)){
                            $content = $title;
                            $content = $content == 'Inspiration' ? 'Projects' : $content;
                        }else{
                            $content = "<a href='".$url_mother."'>".$title."</a>";
                        }
                        $html .= "<li>".$content."</li>";
                    }
                    
                   
                }
            }    
            $html .="</ol>";
        }
        return $html;    
    }
}
if (!function_exists('sendmail')) {
    function sendmail($to, $subject, $content, $other = null) {
        $from = getWebSetting("Email");
        $config['protocol'] = 'sendmail';
        $config['mailpath'] = '/usr/sbin/sendmail';
        $config['mailtype'] = 'html';
        $config['charset'] = 'utf-8';
        $config['wordwrap'] = TRUE;
        $config['newline'] = "\r\n";
        $CI = & get_instance();
        $CI->load->library('email');
        $CI->email->set_mailtype("html");
        $CI->email->from($from, 'condopi');
        $test_mail = getWebSetting("Email_Test");
        if (!empty($test_mail)) {
        	$CI->email->to($test_mail);
        } else {
        	$CI->email->to($to);
        }
        if ($other != null && $other != '') {
            $CI->email->cc($other);
        } 
        $CI->email->subject($subject);
        $CI->email->message($content);
        $CI->email->send();
        return true;
    }
}

if (!function_exists('sendmail_from')) {
    function sendmail_from($from, $from_name="", $to, $subject, $content, $other = null) {
        $config['protocol'] = 'sendmail';
        $config['mailpath'] = '/usr/sbin/sendmail';
        $config['mailtype'] = 'html';
        $config['charset'] = 'utf-8';
        $config['wordwrap'] = TRUE;
        $config['newline'] = "\r\n";
        $CI = & get_instance();
        $CI->load->library('email');
        $CI->email->set_mailtype("html");
        $CI->email->from($from, $from_name);
        $test_mail = getWebSetting("Email_Test");
        if (!empty($test_mail)) {
        	$CI->email->to($test_mail);
        } else {
     		$CI->email->to($to);
       	}
        if ($other != null && $other != '') {
            $CI->email->cc($other);
        } 
        $CI->email->subject($subject);
        $CI->email->message($content);
        $CI->email->send();
        return true;
    }
}


if (!function_exists('create_select')) {
    function create_select ($arg,$key="ID",$value="Name",$active = false){
        $html = '<option value="">-- Vui lòng chọn --</option>';
        foreach ($arg as $key_arg => $value_arg) {
            if($active == $value_arg[$key])
                $html .='<option value="'.$value_arg[$key].'" selected>'.$value_arg[$value].'</option>';
            else
                $html .='<option value="'.$value_arg[$key].'">'.$value_arg[$value].'</option>';
            
        }
        return $html;
    }
}
function get_lat_long($address)
{
    $url = 'http://maps.googleapis.com/maps/api/geocode/json?address='.urlencode($address).'&sensor=false';
    $ch  = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
    $data = curl_exec($ch);
    curl_close($ch);
    $locations = array('lat' => 0, 'lng' => 0);
    $geo = json_decode($data, true);
    if ($geo['status'] == 'OK') {
        $locations['lat'] = $geo['results'][0]['geometry']['location']['lat'];
        $locations['lng'] = $geo['results'][0]['geometry']['location']['lng'];
    }
    return $locations;
}

function sendRenew() {
    $CI   = get_instance();
    $sql = "SELECT m.*,l.*,l.ID,le.Listing_ID, le.Extend_Date, (datediff(le.Extend_Date, now()) + 7) AS DayLeft  
    FROM Listing AS l 
    INNER JOIN (
        SELECT * FROM Listing_Extend 
        WHERE Listing_Extend.Status = '1'
        GROUP BY Listing_Extend.Listing_ID
        ORDER BY Listing_Extend.Extend_Date DESC
    )
    AS le ON l.ID = le.Listing_ID 
    INNER JOIN Members AS m ON m.ID = l.Member_ID 
    WHERE le.SendNotification = 0
    GROUP BY l.ID
    HAVING DayLeft < 1
    ORDER BY l.ID DESC";
    $result = $CI->Common_model->query_raw($sql);
    if ($result) {
       foreach ($result as $key => $value) {
            $to = $value["Email"];
            $address = $value["Address"]. " " .$value["City"] . " " . $value["State"] . " " . $value["Zipcode"];
            $content = 'Thank you for using condopi.com. <br><br>
            			Your listing on '.$address.' has expired.<br>
						Please <a href="'.base_url('profile/listing').'"><u>renew</u></a> your listing for free. <br><br>
						We consider you a special customer. Thank you for your continued support.<br><br>
						Best,<br>
						Administrator<br>
						condopi.com – #1 source for real estate deals';
            if (sendmail($to,"Expired: ". $address.", condopi.com",$content)) {
            	// sendmail("admin@condopi.com",$address." expiration Condo PI",$content);
                $CI->Common_model->update("Listing_Extend",["SendNotification" => 1],["Listing_ID" => $value["Listing_ID"]]);
            }
        }
    }
    return true;
}

function send_new_post_listing($listing_id) {
	return false;
	/*
    $CI   = get_instance();
    $record = $CI->Common_model->get_record("Listing", array('ID' => $listing_id));
    if (!(isset($record) && $record != null)) {
    	$address = $record["Address"]. " " .$record["City"] . " " . $record["State"] . " " . $record["Zipcode"];
    	$content = 'New listing post <br> '.$address;
    	if ($record["HeroImage"] != null) {
    		$content .= '<br/><br/><img src="'.base_url($record["HeroImage"]).'" width="200px" ><br/><br/>';
    	}
	    $sql = "SELECT * Members WHERE (Is_Send_Email=1) AND Status=1";
	    $result = $CI->Common_model->query_raw($sql);
	    if ($result) {
	       foreach ($result as $key => $value) {
	            sendmail($value["Email"],"New listing post",$content);
	        }
	    }
    }
    return true;*/
}


function getWebSetting($key) {
    $CI   = get_instance();
    $r    = $CI->Common_model->get_record("Web_Setting",["IKEY" => $key]);
    return @$r["Body_Json"];
}

function getDetailWebSetting($field, $field_compare=null) {
	if ($field_compare == '')
		return '';
	$values = getWebSetting($field);
    if ($values) {
        $values = preg_split('/\r\n|[\r\n]/',$values);
    }
    if (is_array($values)) {
	    foreach ($values as $key => $value) {
	        if ($field_compare == $key)
	        	return $value;
	    }
    }
    return '';
}

function getListEscrowInsurance($field, $field_compare=null) {
	$values = getWebSetting($field);
	
    if ($values) {
        $values = preg_split('/\r\n|[\r\n]/',$values);
    }
    $return = '';
    if (is_array($values)) {
	    foreach ($values as $key => $value) {
			if ($field_compare != null && strtolower($field_compare) == trim($key))
	            $return .= '<option value="'.$key.'" selected>'.$value.'</option>';
	        else
	            $return .= '<option value="'.$key.'">'.$value.'</option>' ;
	    }
    }
    return $return;
}

function getCommissionType($default=null,$value=false) {
    $list = ['Percent', 'Currency'];
    return getListOptions($list,$default,$value);
}

function findShortName($name) {
	$list = [
			"al" => "Alabama", 
			"ak" => "Alaska", 
			"az" => "Arizona", 
			"ar" => "Arkansas", 
			"ca" => "California", 
			"co" => "Colorado", 
			"ct" => "Connecticut", 
			"de" => "Delaware", 
			"dc" => "District of Columbia", 
			"fl" => "Florida", 
			"ga" => "Georgia", 
			"hi" => "Hawaii", 
			"id" => "Idaho", 
			"il" => "Illinois", 
			"in" => "Indiana", 
			"ia" => "Iowa", 
			"ks" => "Kansas", 
			"ky" => "Kentucky", 
			"la" => "Louisiana", 
			"me" => "Maine", 
			"md" => "Maryland", 
			"ma" => "Massachusetts", 
			"mi" => "Michigan", 
			"mn" => "Minnesota", 
			"ms" => "Mississippi", 
			"mo" => "Missouri", 
			"mt" => "Montana", 
			"ne" => "Nebraska", 
			"nv" => "Nevada", 
			"nh" => "New Hampshire", 
			"nj" => "New Jersey", 
			"nm" => "New Mexico", 
			"ny" => "New York", 
			"nc" => "North Carolina", 
			"nd" => "North Dakota", 
			"oh" => "Ohio", 
			"ok" => "Oklahoma", 
			"or" => "Oregon", 
			"pa" => "Pennsylvania", 
			"ri" => "Rhode Island", 
			"sc" => "South Carolina", 
			"sd" => "South Dakota", 
			"tn" => "Tennessee", 
			"tx" => "Texas", 
			"ut" => "Utah", 
			"vt" => "Vermont", 
			"va" => "Virginia", 
			"wa" => "Washington", 
			"wv" => "West Virginia", 
			"wi" => "Wisconsin", 
			"wy" => "Wyoming"
			];
	
    foreach ($list as $key => $value) {
		if ($value == $name)
            return $key;
    }
    return '';
}

function getListState($default=null,$value=false) {
	$list = [
			"al" => "Alabama", 
			"ak" => "Alaska", 
			"az" => "Arizona", 
			"ar" => "Arkansas", 
			"ca" => "California", 
			"co" => "Colorado", 
			"ct" => "Connecticut", 
			"de" => "Delaware", 
			"dc" => "District of Columbia", 
			"fl" => "Florida", 
			"ga" => "Georgia", 
			"hi" => "Hawaii", 
			"id" => "Idaho", 
			"il" => "Illinois", 
			"in" => "Indiana", 
			"ia" => "Iowa", 
			"ks" => "Kansas", 
			"ky" => "Kentucky", 
			"la" => "Louisiana", 
			"me" => "Maine", 
			"md" => "Maryland", 
			"ma" => "Massachusetts", 
			"mi" => "Michigan", 
			"mn" => "Minnesota", 
			"ms" => "Mississippi", 
			"mo" => "Missouri", 
			"mt" => "Montana", 
			"ne" => "Nebraska", 
			"nv" => "Nevada", 
			"nh" => "New Hampshire", 
			"nj" => "New Jersey", 
			"nm" => "New Mexico", 
			"ny" => "New York", 
			"nc" => "North Carolina", 
			"nd" => "North Dakota", 
			"oh" => "Ohio", 
			"ok" => "Oklahoma", 
			"or" => "Oregon", 
			"pa" => "Pennsylvania", 
			"ri" => "Rhode Island", 
			"sc" => "South Carolina", 
			"sd" => "South Dakota", 
			"tn" => "Tennessee", 
			"tx" => "Texas", 
			"ut" => "Utah", 
			"vt" => "Vermont", 
			"va" => "Virginia", 
			"wa" => "Washington", 
			"wv" => "West Virginia", 
			"wi" => "Wisconsin", 
			"wy" => "Wyoming"
			];
	
	$list = ['ca' => 'California'];
	
	$return = '';
    foreach ($list as $key => $value) {
		if ($default != null && strtolower($default) == trim($key))
            $return .= '<option value="'.$value.'" selected>'.$value.'</option>';

       else
            $return .= '<option value="'.$value.'">'.$value.'</option>' ;
    }
    return $return;
}

function getBestRepresents($default=null,$value=false) {
    $list = ['Investor – flipping', 'Investor – buy and hold', 'Realtor – rep mainly buyers', 'Realtor – rep mainly sellers', 'Buying for myself', 'Selling for sale by owner','Commercial Realtor', 'Commercial Lease Realtor', 'Other'];
    return getListOptions($list,$default,$value);
}

function getHearAboutUs($default=null,$value=false) {
    $list = ['On-line search', 'Realtor referral', 'Social Media', 'Trade show', 'Word of mouth', 'Call from our team member', 'Other'];
    return getListOptions($list,$default,$value);
}

function getListTypeBackup($default=null,$value=false) {
    $list = ['Single Family', 'Condominium', 'Vacant Land', 'Multi-Unit', 'Commercial', 'New Development', 'Other'];
    return getListOptions($list,$default,$value);
}

function getListType($default=null,$value=false,$state="") {
	$list = ['Condominimum', 'Home', 'Land'];
    return getListOptions($list,$default,$value);
	
	if ((empty($state) || $state == 'All') && !$value) {
		$list1 = ['Single Family', 'Condominium', '1-4 Units', 'Vacant Land – Residential', 'Other – Residential'];
		$list2 = ['Apartments - 5 units or more', 'Commercial', 'New Development', 'Vacant Land – Commercial', 'Lease – Commercial', 'Other - Commercial'];
	    $return = '';
		$return .= '<optgroup label="RESIDENTIAL">'.getListOptions($list1,$default,$value).'</optgroup>';
		$return .= '<optgroup label="COMMERCIAL">'.getListOptions($list2,$default,$value).'</optgroup>';
		return $return;
	}
	
	$list = [];
	if ($state == "RESIDENTIAL")
    	$list = ['Imperial', 'Kern', 'Los Angeles', 'Orange', 'Riverside', 'San Bernardino', 'San Diego','San Luis Obispo', 'Santa Barbara', 'Ventura', 'Other'];
    elseif ($state == "COMMERCIAL") 
    	$list = ['Alameda', 'Contra Costa', 'Marin', 'Napa', 'Sacramento', 'San Francisco', 'San Joaquin','San Mateo', 'Santa Clara', 'Santa Cruz', 'Solano', 'Sonoma', 'Other'];
    return getListOptions($list,$default,$value);
}

function getListTypeRESIDENTIALCOMMERCIAL($type="") {
	if ($type == "RESIDENTIAL") {
		return ['Single Family', 'Condominium', '1-4 Units', 'Vacant Land – Residential', 'Other – Residential'];
	}
	
	return ['Apartments - 5 units or more', 'Commercial', 'New Development', 'Vacant Land – Commercial', 'Lease – Commercial', 'Other - Commercial'];
}


function getListListingType($default=null,$value=false) {
    //$list = ['FSBO', 'REO (for Lenders only)', 'Corporate Owned', 'Pocket Listing (for Licensed Agents only)', 'Probate', 'Auction (for Auctions only)', 'Commercial', 'Reduced', 'All', 'Other'];
    //$list_short = ['FSBO', 'REO', 'Corporate Owned', 'Pocket Listing', 'Probate', 'Auction', 'Commercial', 'Reduced', 'All', 'Other'];
    
    /*$list = ['Auction', 'All', 'Corporate Owned', 'For Sale', 'Probate', 'Just Reduced', 'For Rent', 'Pocket Listings', 'Probate', 'REO', 'Other'];
    $list_short = ['Auction', 'All', 'Corporate Owned', 'For Sale', 'Probate', 'Just Reduced', 'For Rent', 'Pocket Listings', 'Probate', 'REO', ''];*/
    $list = ['All', 'For Sale', 'For Rent', 'Other'];
    $list_short = ['All', 'For Sale', 'For Rent', 'Other'];
   
    $return = '';
    foreach ($list as $key => $value) {
    	if (is_array($default) && in_array(trim($value),$default)) {
    		$return .= '<option value="'.$value.'" selected>'.$list_short[$key].'</option>';
    	} else {
			if ($default == trim($value)) {
	            $return .= '<option value="'.$value.'" selected>'.$list_short[$key].'</option>';
	            if ($getvalue)
	            	return $value;
	        }
	        else
	            $return .= '<option value="'.$value.'">'.$list_short[$key].'</option>' ;
        }
    } 
    return $return;
}

function getListListingTypeView($default=null,$value=false) {
    //$list = ['FSBO', 'REO (for Lenders only)', 'Corporate Owned', 'Pocket Listing (for Licensed Agents only)', 'Probate', 'Auction (for Auctions only)', 'Commercial', 'Reduced', 'All', 'Other'];
    //$list_short = ['FSBO', 'REO', 'Corporate Owned', 'Pocket Listing', 'Probate', 'Auction', 'Commercial', 'Reduced', 'All', 'Other'];
    
    /*$list = ['Auction', 'All', 'Corporate Owned', 'For Sale', 'Probate', 'Just Reduced', 'For Rent', 'Pocket Listings', 'Probate', 'REO', 'Other'];
    $list_short = ['Auction', 'All', 'Corporate Owned', 'For Sale', 'Probate', 'Just Reduced', 'For Rent', 'Pocket Listings', 'Probate', 'REO', ''];*/
    $list = ['For Sale', 'For Rent', 'Other'];
    $list_short = ['For Sale', 'For Rent', 'Other'];
   
    $return = '';
    foreach ($list as $key => $value) {
    	if (is_array($default) && in_array(trim($value),$default)) {
    		$return .= '<option value="'.$value.'" selected>'.$list_short[$key].'</option>';
    	} else {
			if ($default == trim($value)) {
	            $return .= '<option value="'.$value.'" selected>'.$list_short[$key].'</option>';
	            if ($getvalue)
	            	return $value;
	        }
	        else
	            $return .= '<option value="'.$value.'">'.$list_short[$key].'</option>' ;
        }
    } 
    return $return;
}

function getDetailListingType($value="") {
	
	//$list = ['FSBO', 'REO (for Lenders only)', 'Corporate Owned', 'Pocket Listing (for Licensed Agents only)', 'Probate', 'Auction (for Auctions only)', 'Commercial', 'All', 'Other'];
    //$list_show = ['FSBO', 'REO', 'Corporate Owned', 'Pocket Listing', 'Probate', 'Auction', 'Commercial', 'All', ''];
    
   /*$list = ['Auction', 'All', 'Corporate Owned', 'For Sale', 'Probate', 'Just Reduced', 'For Rent', 'Pocket Listings', 'Pocket Listings', 'Probate', 'REO', 'Other'];
    $list_short = ['Auction', 'All', 'Corporate Owned', 'For Sale', 'Probate', 'Just Reduced', 'For Rent', 'Pocket Listings', 'Pocket Listings', 'Probate', 'REO' , ''];*/
    $list = ['All', 'For Sale', 'For Rent', 'Other'];
    $list_short = ['All', 'For Sale', 'For Rent', 'Other'];
    
    $t = -1;
    foreach ($list as $index => $item) {
    	if ($value == $item) {
    		$t = $index;
    		break;
    	}
    }
    
    if ($t == -1)
    	return '';
    
    return $list_short[$t];
}


function getDetailListingTypeSEO($value="") {
    //$list = ['Off-Market (for Principals only)', 'REO (for Lenders only)', 'Pocket Listing (for Licensed Agents only)', 'Auction (for Auctions only)', 'Commercial', 'All', 'Other'];
    //$list_show = ['For Rent', 'REO', 'Pocket Listing', 'Auction', 'Commercial', 'All', 'Other'];
    /*$list = ['Auction', 'All', 'Corporate Owned', 'For Sale', 'Probate', 'Just Reduced', 'For Rent', 'Pocket Listings', 'Pocket Listings', 'Probate', 'REO', 'Other'];
    $list_short = ['Auction', 'All', 'Corporate Owned', 'For Sale', 'Probate', 'Just Reduced', 'For Rent', 'Pocket Listings', 'Pocket Listings', 'Probate', 'REO' , ''];*/
    $list = ['All', 'For Sale', 'For Rent', 'Other'];
    $list_short = ['All', 'For Sale', 'For Rent', 'Other'];
   
    $t = -1;
    foreach ($list as $index => $item) {
    	if ($value == $item) {
    		$t = $index;
    		break;
    	}
    }
    
    if ($t == -1)
    	return '';
    
    return slugify($list_short[$t]);
}

function getListCounty($default=null,$value=false,$state="") {
	// $list = ['Bonifacio Global City', 'Makati: Legaspi', 'Makati: Salcedo', 'Makati: Other', 'Ortigas', 'Pasay: MOA', 'Quezon City', 'Rockwell', 'Taguig: Arca South', 'Taguig: Other', 'Other'];
	$list = ['Quezon City', 'Caloocan City', 'Las Pinas City', 'Makati City', 'Malabon City', 'Mandaluyong', 'Marikina City', 'Muntinlupa City', 'Paranaque City', 'Pasay City', 'Pasig City', 'San Juan City', 'Taguig City', 'Valenzuela City', 'Manila City', 'Other'];
    return getListOptions($list,$default,$value);
}

function getListCity($default=null,$value=false) {
    $list = ['EDSA', 'Salcedo Village', 'Legespi Village', 'Rockwell Center', 'Bonifacio Global City', 'McKinley Hill', 'Ortigas Center', 'Newport City', 'None'];
    return getListOptions($list,$default,$value);
}

function getListRegion($default=null,$value=false) {
    $list = ['Manila', 'Other'];
    return getListOptions($list,$default,$value);
}

function getListOptions($list,$default,$getvalue=false) {
    $return = '';
    foreach ($list as $key => $value) {
    	if (is_array($default) && in_array(trim($value),$default)) {
    		$return .= '<option value="'.$value.'" selected>'.$value.'</option>';
    	} else {
			if ($default == trim($value)) {
	            $return .= '<option value="'.$value.'" selected>'.$value.'</option>';
	            if ($getvalue)
	            	return $value;
	        }
	        else
	            $return .= '<option value="'.$value.'">'.$value.'</option>' ;
        }
    }
    return $return;
}

function resize_image($file,$maxDimW=800,$maxDimH=600) {
	list($width, $height, $type, $attr) = getimagesize( $file['tmp_name'] );
	if ( $width > $maxDimW || $height > $maxDimH ) {
		$target_filename = $file['tmp_name'];
		$fn = $file['tmp_name'];
		$size = getimagesize( $fn );
		$ratio = $size[0]/$size[1]; // width/height
		if	($ratio > 1) {
			$width = $maxDimW;
			$height = $width/$ratio;// $maxDimH/$ratio;
		} else {
			$height = $maxDimH;
			$width = $height*$ratio;//$maxDimW*$ratio;
		}
		$src = imagecreatefromstring(file_get_contents($fn));
		$dst = imagecreatetruecolor( $width, $height );
		imagecopyresampled($dst, $src, 0, 0, 0, 0, $width, $height, $size[0], $size[1] );
	
		if ($file['type'] == 'image/jpeg' || $file['type'] == 'image/jpg') {
			imagejpeg($dst, $target_filename);
		} else if ($file['type'] == 'image/gif') {
			imagegif($dst, $target_filename);
		} else {
			imagepng($dst, $target_filename);
		}
	}
}

function get_link_item($item) {
	$listing_type = getDetailListingTypeSEO($item['ListingType']);
	$listing_type = empty($listing_type) ? 'other' : $listing_type;
	$address = slugify($item["Address"] . ' ' . $item["City"] . ' ' . findShortName($item["State"]) . ' ' . $item["Zipcode"]);
	return site_url('listing/'.$listing_type.'/'.$address.'/'.$item['ID']);
}


function get_testimonial() {
    $CI   = get_instance();
    $sql = "SELECT * FROM Testimonial WHERE Status='yes' ORDER BY Sort DESC";
    $result = $CI->Common_model->query_raw($sql);
    
    return $result;
}

function get_staticpage($slug='') {
	if ($slug != '') {
		$CI   = get_instance();
		$page = $CI->Common_model->get_record('Page',array('Key_Identify' => $slug));
		return $page;
	}
    return null;
}

function read_more($string, $number) {
	if (empty($string))
		return '';
	
	$arr = explode(" ",$string);
	if ($number >= count($arr))
		return $string;
	
	// 'abc def tkb gkh';
	$quid = uniqid();
	$str = '<input type="checkbox" class="read-more-state" id="post-'.$quid.'" /><p class="read-more-wrap">';
	foreach ($arr as $key => $item) {
		if ($key == $number) {
			$str .= '<span class="read-more-target">';
		}
		$str .= ' ' . $item;
	}
	$str .= '</span><label for="post-'.$quid.'" class="read-more-trigger"></label></p>';
	
	return trim($str);
}

function displayPrice($price = 0, $numberDecimal = 2, $currency = '$', $position = 'after'){
	if($position == 'before'){
		return $currency . '' . number_format($price, $numberDecimal, ',', '.');
	} else {
		return number_format($price, $numberDecimal, ',', '.') . '' . $currency;
	}
}
