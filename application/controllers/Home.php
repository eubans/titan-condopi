<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	private $is_login = false;
    private $data = array();
    private $mailchimp_api_key = "b1c44f306c6a4a2f299bb8eea629778f-us19";
    private $mailchimp_list_id = "cbe5bd92e7";
    
	public function __construct()
    {
        parent::__construct();
         
        if ($this->session->userdata('user_info')) {
            $this->data["is_login"] = true;
            $this->data['user'] = $this->session->userdata('user_info');
            $this->user_id = $this->data['user']['id'];
            $this->data['member_expiry'] = $this->Common_model->get_record('Member_Expiry',array('Member_ID' => $this->user_id));
        }
        $this->load->helper(array('url','form'));
    }
	public function homepage()
	{
        redirect("/listing");
        
		$this->load->view('frontend/block/header',$this->data);

		$useragent = $_SERVER['HTTP_USER_AGENT'];

		if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4))){
			//its mobile
			$this->load->view('frontend/home/homepage-mobile',$this->data);
			$this->load->view('frontend/block/footer-mobile',$this->data);
		}else{
			$this->load->view('frontend/home/homepage',$this->data);
			$this->load->view('frontend/block/footer',$this->data);
		}

    }
	public function index()
	{
		redirect("/listing");
		
		$this->load->view('frontend/block/header',$this->data);
		$this->load->view('frontend/home/homepage',$this->data);
		$this->load->view('frontend/block/footer',$this->data);
	}
	public function socialmediablast()
	{
		$this->load->view('frontend/block/header',$this->data);

		$useragent = $_SERVER['HTTP_USER_AGENT'];

		if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4))){
			//its mobile
			$this->load->view('frontend/home/socialmediablast-mobile',$this->data);
		}else{
			$this->load->view('frontend/home/socialmediablast',$this->data);
		}

		$this->load->view('frontend/block/footer',$this->data);
	}
	
	public function listing($home_type="") {
		if ($this->input->get('type') && $this->input->get('type') != "All") {
			$types = $this->input->get('type');
			$getListTypeRESIDENTIALCOMMERCIAL = getListTypeRESIDENTIALCOMMERCIAL("RESIDENTIAL");
			if (in_array($types, $getListTypeRESIDENTIALCOMMERCIAL)) {
				$home_type = "RESIDENTIAL";
			}
			$getListTypeRESIDENTIALCOMMERCIAL = getListTypeRESIDENTIALCOMMERCIAL("COMMERCIAL");
			if (in_array($types, $getListTypeRESIDENTIALCOMMERCIAL)) {
				$home_type = "COMMERCIAL";
			}
		}
		
		//2019-11-19
		//index_home only has view of 20 and no pagination
		//this will redirect everything to index_detail 
		//which has everything with the pagination
		//if (empty($home_type)) { // Không cần paging
			//$this->index_home();
		//} else {
			$this->index_detail($home_type);
		//}
	}
	
	private function index_home() {
		$get = $this->input->get();
		$this->data["is_show_search"] = 1;
		$whereserach = "";
		if($this->input->get('city') && $this->input->get('city') != "All"){
			$whereserach .= " AND l.City like '%".$this->input->get('city')."%'";
		}
		if($this->input->get('county') && $this->input->get('county') != "All"){
			$whereserach .= " AND (l.County like '%".$this->input->get('county')."%')";
		}
		if($this->input->get('type') && $this->input->get('type') != "All") {
			$types = explode(",",$this->input->get('type'));
			$whereserach .= " AND (";
			foreach ($types as $key => $type_item) {
				if ($key != 0) {
					$whereserach .= " OR ";
				}
				$whereserach .= " (l.Type = '".$type_item."')";
			}
			$whereserach .= ")";
		}

		if($this->input->get('listingtype') && $this->input->get('listingtype') != "All") {
			$types = explode(",",$this->input->get('listingtype'));
			$whereserach .= " AND (";
			foreach ($types as $key => $type_item) {
				if ($key != 0) {
					$whereserach .= " OR ";
				}
				$whereserach .= " (l.ListingType = '".$type_item."')";
			}
			$whereserach .= ")";
		}
		if($this->input->get('region') && $this->input->get('region') != "All"){
			$whereserach .= " AND l.Region = '".$this->input->get('region')."'";
		}
		if($this->input->get('search') && $this->input->get('search') != ""){
			$whereserach .= " AND ((l.Address LIKE '%".$this->input->get('search')."%') OR (l.City LIKE '%".$this->input->get('search')."%') OR (l.County LIKE '%".$this->input->get('search')."%') )";
		}
		if($this->input->get('price') && $this->input->get('price') != "All"){
			$prices = explode(",",$this->input->get('price'));
			$whereserach .= " AND (";
			foreach ($prices as $key => $price) {
				if ($key != 0) {
					$whereserach .= " OR ";
				}
				$arg = explode("-", $price);
				if( count($arg) == 2 ){
					$whereserach .= " (l.Price >= ".($arg[0] * 1000)." AND l.Price <= ".($arg[1]*1000).")";
				}else{
					$whereserach .= " (l.Price >= ".($arg[0]*1000).")";
				}
			}
			$whereserach .= ")";
		}
		$sql1 = "SELECT l.*, le.Extend_Date, (datediff(le.Extend_Date, now()) + 7) AS DayLeft 
            FROM Listing AS l INNER JOIN Listing_Extend AS le ON l.ID = le.Listing_ID 
            INNER JOIN Members AS m ON m.ID = l.Member_ID AND m.Status = 1
            WHERE 
                le.Status = '1' HAVING DayLeft > 0 AND (l.Type IN ('".implode("','",getListTypeRESIDENTIALCOMMERCIAL("RESIDENTIAL"))."') )
                ".$whereserach."
            ORDER BY
            	DayLeft DESC, le.Extend_Date DESC, l.Created_At DESC
		 	LIMIT 
		 		20 ";
		
		$sql2 = "SELECT l.*, le.Extend_Date, (datediff(le.Extend_Date, now()) + 7) AS DayLeft 
            FROM Listing AS l INNER JOIN Listing_Extend AS le ON l.ID = le.Listing_ID 
            INNER JOIN Members AS m ON m.ID = l.Member_ID AND m.Status = 1
            WHERE 
                le.Status = '1' HAVING DayLeft > 0 AND (l.Type IN ('".implode("','",getListTypeRESIDENTIALCOMMERCIAL("COMMERCIAL"))."') )
                ".$whereserach."
            ORDER BY
            	DayLeft DESC, le.Extend_Date DESC, l.Created_At DESC
		 	LIMIT 
		 		20 ";
		
		$request = '?1=1';
		if($this->input->get()){
            $parement = $this->input->get();
            $request = '?'. http_build_query($parement, '', "&");
        }
        
        $config_site = $this->session->userdata('config_site'); 
        $BODY_JSON = json_decode(@$config_site['Body_Json'],true);
        
        $this->data['meta_share'] =  array(
			'title' => @$BODY_JSON['Meta_Keyword'],
			'description' => @$BODY_JSON['Meta_Description'],
			'image' => base_url("skins/frontend/images/logo7day.jpg")
		);
        
        $this->data['result1'] = $this->Common_model->query_raw($sql1);
        $this->data['result2'] = $this->Common_model->query_raw($sql2);
        // Get list favorite
        $list_favorite = "";
        if (@$this->data["is_login"]) {
	        $sql = "select GROUP_CONCAT(Listing_ID) AS pid_list FROM Favorites WHERE Member_ID=".$this->data['user']["id"]." GROUP by Member_ID ORDER BY Member_ID";
			$row = $this->Common_model->query_raw_row($sql);
			$list_favorite = @$row["pid_list"];
		}
		$this->data['list_favorite'] = $list_favorite;
		// Get list comment
        $list_comment = "";
        if (@$this->data["is_login"]) {
	        $sql = "select GROUP_CONCAT(Listing_ID) AS pid_list FROM Listing_Saved_ByMember WHERE Member_ID=".$this->data['user']["id"]." GROUP by Member_ID ORDER BY Member_ID";
			$row = $this->Common_model->query_raw_row($sql);
			$list_comment = @$row["pid_list"];
		}
        $this->data['list_comment'] = $list_comment;
        $this->data['not_show_banner'] = true;
        $this->data['show_paging'] = false;
		$this->load->view('frontend/block/header',$this->data);
		$this->load->view('frontend/home/listing',$this->data);
		$this->load->view('frontend/block/footer',$this->data);
	}
	
	private function index_detail($home_type) {
		$this->load->library('mobile_Detect');
		$detect = new Mobile_Detect;
		
		$get = $this->input->get();
		if ( count($get) <= 0 && (isset($_COOKIE['type']) || isset($_COOKIE['price']) || isset($_COOKIE['listingtype'])) ) {
			redirect('/?type='.@$_COOKIE['type'].'&price='.@$_COOKIE['price'].'&listingtype='.@$_COOKIE['listingtype'].'&county='.@$_COOKIE['county'].'&region='.@$_COOKIE['region']);
			die;
		}

		//2019-11-19
		//rewrote this bad scripting
		/*if ( $detect->isMobile() ) {
			$per_page = 10;
		} else {
			$per_page = 20;
		}

		$per_page = $this->input->get('per_page') ? $this->input->get('per_page') : $per_page;
		if (!in_array($per_page, [10,20,50,100])) {
			$per_page = 20;
			if ( $detect->isMobile() ) {
				$per_page = 10;
			}
		}*/

		$per_page = $this->input->get('per_page') != null && is_numeric($this->input->get('per_page')) ? $this->input->get('per_page') : 20;
		if ( !in_array( $per_page, array( 10,20,50,100 ) ) ) {
			$per_page = 20;
		}

		if ( $detect->isMobile() ) {
			$per_page = 10;
		}

		
		$this->data["is_show_search"] = 1;

		//2019-11-19
		//not gonna use offset 
		//muyst use page numbers and do the php-mysql pagin ay correctly
		//$page = ($this->input->get('offset') != null && is_numeric($this->input->get('offset')) && $this->input->get('offset') > 0) ? $this->input->get('offset') : 0;

		$page = ($this->input->get('page') != null && is_numeric($this->input->get('page')) && $this->input->get('page') > 0) ? $this->input->get('page') : 1;

		$offset = ($page - 1) * $per_page;

		$whereserach = "";

		if($this->input->get('city') && $this->input->get('city') != "All"){
			$whereserach .= " && l.City like '%".$this->input->get('city')."%'
			";
		}

		if($this->input->get('county') && $this->input->get('county') != "All"){
			$whereserach .= " && (l.County = '".$this->input->get('county')."')
			";
		}

		if($this->input->get('type') && $this->input->get('type') != "All") {
			if( is_array($this->input->get('type')) ){
				$types = explode(",",$this->input->get('type'));
				$whereserach .= " && (l.Type in ('".implode("','",$types)."'))
				";
			}else{
				$whereserach .= " && l.Type = '".$this->input->get('type')."'
				";
			}
		}

		if($this->input->get('listingtype') && $this->input->get('listingtype') != "All") {
			$types = explode(",",$this->input->get('listingtype'));
			$whereserach .= " && (l.ListingType in ('".implode("','",$types)."'))
			";
		}
		
		if($this->input->get('search') && $this->input->get('search') != ""){
			$whereserach .= " AND ((l.Address LIKE '%".$this->input->get('search')."%') OR (l.City LIKE '%".$this->input->get('search')."%') OR (l.County LIKE '%".$this->input->get('search')."%') )";
		}

		if($this->input->get('price') && $this->input->get('price') != "All"){
			$prices = explode(",",$this->input->get('price'));
			$whereserach .= " && (
			";
			foreach ($prices as $key => $price) {
				if ($key != 0) {
					$whereserach .= " || ";
				}
				$arg = explode("-", $price);
				if( count($arg) == 2 ){
					$whereserach .= " ( l.Price >= ".($arg[0] * 1000)." && l.Price <= ".($arg[1]*1000)." )
					";
				}else{
					$whereserach .= " ( l.Price >= ".($arg[0]*1000)." )
					";
				}
			}
			$whereserach .= ")";
		}

		$sql = "
		select 
			l.*, 
			le.Extend_Date,
			(datediff(le.Extend_Date, now()) + 7) DayLeft
        from 
        	Listing l 
        inner join 
        	Listing_Extend le 
        on 
        	l.ID = le.Listing_ID 
        inner join 
        	Members m 
        on 
        	m.ID = l.Member_ID 
		where
			le.Status = '1' 
			&& (datediff(le.Extend_Date, now()) + 7) > 0 
			&& m.Status = 1 
			".$whereserach."
		order by
			le.Extend_Date desc, 
			l.Created_At desc
		LIMIT 
			$offset, $per_page 
		";

		$sql_count = "
		select 
			count(l.ID) NumberItem
        from 
        	Listing l 
        inner join 
        	Listing_Extend le 
        on 
        	l.ID = le.Listing_ID 
        inner join 
        	Members m 
        on 
        	m.ID = l.Member_ID 
		where
			le.Status = '1' 
			&& (datediff(le.Extend_Date, now()) + 7) > 0 
			&& m.Status = 1
			".$whereserach."
		";

		$count = $this->Common_model->query_raw_row($sql_count);
		$request = '?1=1';
		if($this->input->get()){
            $parement = $this->input->get();
            if(isset($parement['page'])){
                unset($parement['page']);
            }
            $request = '?'. http_build_query($parement, '', "&");
        }
        
        $config_site = $this->session->userdata('config_site'); 
        $BODY_JSON = json_decode(@$config_site['Body_Json'],true);
        
        $this->data['meta_share'] =  array(
			'title' => @$BODY_JSON['Meta_Keyword'],
			'description' => @$BODY_JSON['Meta_Description'],
			'image' => base_url("skins/frontend/images/logo7day.jpg")
		);
        
        $config['base_url'] = base_url('/listing'.$request);
        $config['total_rows'] = $count['NumberItem'];
        $config['per_page'] = $per_page;
        $config['page_query_string'] = TRUE;
        $config['use_page_numbers'] = TRUE;
        $config['segment'] = 2;
        $this->load->library('pagination');
        $this->pagination->initialize($this->_get_paging($config));
        $this->data['result'] = $this->Common_model->query_raw($sql);
        // Get list favorite
        $list_favorite = "";
        if (@$this->data["is_login"]) {
	        $sql = "select GROUP_CONCAT(Listing_ID) AS pid_list FROM Favorites WHERE Member_ID=".$this->data['user']["id"]." GROUP by Member_ID ORDER BY Member_ID";
			$row = $this->Common_model->query_raw_row($sql);
			$list_favorite = @$row["pid_list"];
		}
		$this->data['list_favorite'] = $list_favorite;
		// Get list comment
        $list_comment = "";
        if (@$this->data["is_login"]) {
	        $sql = "select GROUP_CONCAT(Listing_ID) AS pid_list FROM Listing_Saved_ByMember WHERE Member_ID=".$this->data['user']["id"]." GROUP by Member_ID ORDER BY Member_ID";
			$row = $this->Common_model->query_raw_row($sql);
			$list_comment = @$row["pid_list"];
		}
        $this->data['list_comment'] = $list_comment;
        $this->data['not_show_banner'] = true;
        $this->data['per_page'] = $per_page;
        
        $this->data['type'] = $home_type;
        
		$this->load->view('frontend/block/header',$this->data);
		$this->load->view('frontend/home/index',$this->data);
		$this->load->view('frontend/block/footer',$this->data);
	}

	public function detail($listing_type=null,$address=null,$id=null)
	{
		if ($id == null && is_numeric($listing_type)) {
			$id = $listing_type;
		}
		$sql = "SELECT l.*, le.Extend_Date, (datediff(le.Extend_Date, now()) + 7) AS DayLeft 
            FROM Listing AS l INNER JOIN Listing_Extend AS le ON l.ID = le.Listing_ID 
            	INNER JOIN Members AS m ON m.ID = l.Member_ID AND m.Status = 1
            WHERE 
                le.Status = '1' AND l.ID = ".$id."
            HAVING
            	DayLeft > 0";
		$product = $this->Common_model->query_raw_row($sql);
		
		if(!(isset($product) && $product != null)){
			redirect('/');
			die;
		}
		
		// Get similar listing with Same County
		$sql = "SELECT l.*, le.Extend_Date, (datediff(le.Extend_Date, now()) + 7) AS DayLeft 
            FROM Listing AS l INNER JOIN Listing_Extend AS le ON l.ID = le.Listing_ID 
            	INNER JOIN Members AS m ON m.ID = l.Member_ID AND m.Status = 1
            WHERE 
                le.Status = '1' AND l.County = '".$product['County']."' AND HeroImage != ''
            HAVING
            	DayLeft > 0
            ORDER BY
            	DayLeft DESC, le.Extend_Date DESC, l.Created_At DESC
		 	LIMIT 5 ";
        $this->data['similars'] = $this->Common_model->query_raw($sql);
		
		
		$this->data['favorite'] = null;
		if(@$this->data["is_login"]){
			if (isset($_GET["rep"]) && $_GET["rep"] == 'true') {
				// Send mail to admin about this 
                $email_admin = getWebSetting("Email_Receive_Buy");
		        if (empty($email_admin)) {
		        	$email_admin = "support@condopi.com";
		        }
				$content_mail = "User: ".$this->data['user']["first_name"] . ' ' . $this->data['user']["last_name"]."<br>
											Email: ".$this->data['user']["email"]."<br>
											Link: ".base_url("listing/".$id)."<br/>";
				//$email_admin = "lisatest197@gmail.com";
				sendmail($email_admin,"Report Seller",$content_mail);
				// redirect(base_url("listing/".$id));
				redirect(get_link_item($product));
			}
			
			$member_id = $this->data['user']["id"];
			$this->data['favorite'] = $this->Common_model->get_record(
				"Favorites",
				[
					"Member_ID" => $member_id ,
					"Listing_ID" => $id
				]
			);
			$this->data['listing_save'] = $this->Common_model->get_record(
				"Listing_Saved_ByMember",
				[
					"Member_ID" => $member_id,
					"Listing_ID" => $id
				]
			);
		}
		
		// Increase view
		$session_id = session_id();
		$browser_agent = $_SERVER['HTTP_USER_AGENT'];
		$browser_ip =  $_SERVER['REMOTE_ADDR'];
		$check_view = $this->Common_model->get_record('Listing_Views',array('Listing_ID' => $id,"Session_ID" => $session_id));
		if (!(isset($check_view) && $check_view != null)) {
			// insert into database
			$insert = array(
    			"Member_ID" 	=> @$this->data['user']["id"],
    			"Session_ID" 	=> $session_id,
    			"Listing_ID" 	=> $id,
    			"IP" 			=> $browser_ip,
    			"Info_Browser" 	=> $browser_agent,
    			"Created_At"	=> date("Y-m-d H:i:s")
    		);
    		$this->Common_model->add("Listing_Views",$insert);
    		// then increase 1 step
    		$this->Common_model->update("Listing",['Views' => (floatval($product['Views']) + 1)],['ID' => $id]);
		}
		
		$member  = $this->Common_model->get_record("Members",["ID" => $product["Member_ID"]]) ;
		$this->data['product']   = $product;
		$this->data['is_estate'] = @$this->data['user']['is_estate']; // BUYER
		$this->data['member'] = $member;
		$this->data['meta_share'] =  array(
			'title' => $product['Name'],
			'description' => $product['Summary'],
			'image'		=> base_url($product['HeroImage'])
		);
		$this->load->view('frontend/block/header',$this->data);
		$this->load->view('frontend/home/detail',$this->data);
		$this->load->view('frontend/block/footer',$this->data);
	}
	
	
	public function detail_old($id=null)
	{
		if ($id == null || !is_numeric($id)) {
			redirect('/');
		}
		$sql = "SELECT l.*, le.Extend_Date, (datediff(le.Extend_Date, now()) + 7) AS DayLeft 
            FROM Listing AS l INNER JOIN Listing_Extend AS le ON l.ID = le.Listing_ID 
            WHERE 
                le.Status = '1' AND l.ID = ".$id."
            HAVING
            	DayLeft > 0";
		$product = $this->Common_model->query_raw_row($sql);
		
		if (!(isset($product) && $product != null)){
			redirect('/');
			die;
		}
		redirect(get_link_item($product));
	}

	private function _get_paging($array_init) 
    {
        $config                = array();
        $config["base_url"]    = $array_init["base_url"];
        $config["total_rows"]  = $array_init["total_rows"];
        $config["per_page"]    = $array_init["per_page"];
        $config["uri_segment"] = $array_init["segment"];
        if(isset($array_init['page_query_string']) && $array_init['page_query_string']){
            $config['page_query_string'] = TRUE;
			//2019-11-19
			//configure codeigniter to use pages and not offset
            //$config['query_string_segment'] = 'offset';
            $config['query_string_segment'] = 'page';
        }
		//2019-11-19
		//configure codeigniter to use pages and not offset
        $config['use_page_numbers'] = TRUE;
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul><!--pagination-->';
        $config['first_link'] = 'Prev «';
        $config['first_tag_open'] = '<li class="prev page">';
        $config['first_tag_close'] = '</li>';
        $config['last_link'] = 'Next »';
        $config['last_tag_open'] = '<li class="next page">';
        $config['last_tag_close'] = '</li>';
        $config['next_link'] = '<span aria-hidden="true">»</span>';
        $config['next_tag_open'] = '<li class="next page">';
        $config['next_tag_close'] = '</li>';
        $config['prev_link'] = '<span aria-hidden="true">«</span>';
        $config['prev_tag_open'] = '<li class="prev page">';
        $config['prev_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li class="page">';
        $config['num_tag_close'] = '</li>';
        return $config;
    }
    
    public function payment (){
        if(@$this->data['user']["id"] == null) redirect(base_url());
        $product = $this->Common_model->get_record("Products",array( "ID" => @$this->input->post("id") ) );
    	if($product){
    		$params = array(
	    		"clientId" => "AYc6pO8bLv4FQSkmhyDkTpvXtRO0sk49TW8EJ254Uc8zrq86kgKVMIqcYKs7LUEvI44bo_ALdamEORc-",
	    		"clientSecret" => "ECh5CWC6cRxbxfO7RZtuQber6W8TUzClg05UgeS4rUPTwSHVoDljd69sQL9aBdXnvDjAynUug2EMzeNz" 
	    	);
	    	$daterange = $this->input->post("daterange");
	    	$adults = $this->input->post("adults");
	    	if (empty($daterange) || !is_numeric($adults)) {
	    		redirect(base_url());
	    	}
	    	$tmp = explode("-", $daterange);
	    	if (count($tmp) != 2) {
	    		redirect(base_url());
	    	}

	    	$date1 = new DateTime($tmp[0]);
			$date2 = new DateTime($tmp[1]);
			$diff = $date1->diff($date2);

			$percent_discount = 0;
			$config_site = $this->session->userdata('config_site');
            if ($config_site['Body_Json'] != null && $config_site['Body_Json'] != '') {
                $Body_Json = json_decode($config_site['Body_Json'], true);
                $percent_discount = isset($Body_Json['Discount']) ? $Body_Json['Discount'] : 0;
            }

			if($diff){
				$qty = ($diff->d + 1);
				$total_order = $product["Price"] * $qty;
				$total_discount = ((100-$percent_discount)*$total_order)/100;
				$total_admin = ($percent_discount*$total_order)/100;

		    	$this->load->library('Paypal',$params);
		    	$insert = array(
	    			"Member_ID" => @$this->data['user']["id"],
	    			"Status_Order"   => 0,
	    			"Total_Order" 	 => $total_order,
	    			"Total_Discount" => $total_discount,
	    			"Percent_Discount" => $percent_discount,
	    			"Total_Admin" => $total_admin,
	    			"Member_Owner_ID" => $product["Member_ID"],
	    			"Status_Owner" => 0
	    		);

	    		$orDerID = $this->Common_model->add("Orders",$insert);
		    	$return_url  = base_url("home/checkout_paypal/".$orDerID."/");
		        $cancel_url  = base_url('home/cancel_payment/'.$orDerID."/");
		        $data_paypal = $this->paypal->CreatePaymentUsingPayPal($return_url,$cancel_url,$total_order,$product); 
		    	$start_date = date_format($date1, 'Y-m-d H:i:s');
		    	$end_date = date_format($date2, 'Y-m-d H:i:s');
		    	if($data_paypal != null){ 
		    		$insert  = array(
		    			"Product_ID" => $product["ID"],
		    			"Qty"		 => $qty,
		    			"Start_Day"  => @$start_date,
		    			"Expires_at" => @$end_date,
		    			"Order_ID"   => $orDerID, 
		    			"Guest"		 => $adults,
		    		);
		    		$DtlID = $this->Common_model->add("Order_Detail",$insert);
		    		if( $DtlID ){
		    			redirect($data_paypal["approvalUrl"]);
		            	die;
		    		}
		           
		        }
			}
	    	
    	}
    }
    public function checkout_paypal($id){
    	$od = $this->Common_model->get_record("Orders",["ID" => @$id,"Status_Order" => 0]);
    	if($od != null){
    		if($this->input->get("paymentId")!= null  && $this->input->get("PayerID")!= null){
	    		$params = array(
		    		"clientId" => "AYc6pO8bLv4FQSkmhyDkTpvXtRO0sk49TW8EJ254Uc8zrq86kgKVMIqcYKs7LUEvI44bo_ALdamEORc-",
		    		"clientSecret" => "ECh5CWC6cRxbxfO7RZtuQber6W8TUzClg05UgeS4rUPTwSHVoDljd69sQL9aBdXnvDjAynUug2EMzeNz" 
		    	);
		    	$this->load->library('Paypal',$params);
		    	$data = $this->paypal->ExecutePayment($od["Total_Order"],$this->input->get("paymentId"),$this->input->get("PayerID"));
	    		if(@$data["payer"]["status"] == "VERIFIED"){
	    			$this->Common_model->update("Orders",["Status_Order" => 1],["ID" => $id]);
	    		}
	    	}
    	}
    	redirect(base_url("/profile/history_order"));
    	
    }
    public function cancel_payment($id){
    	$od = $this->Common_model->get_record("Orders",["ID" => @$id,"Status_Order" => 0]);
    	if($od != null){
    		$this->Common_model->update("Orders",["Status_Order" => 2],["ID" => $id]);
    	}
    	redirect(base_url("/profile/history_order"));
    }
    
    public function send_message(){
    	if ($this->input->post()) {
    		$property_address = '';
            if($this->input->post("Listing_ID")) {
                $r = $this->Common_model->get_record("Listing",["ID" => $this->input->post("Listing_ID")]);
                if(!$r) redirect('/home');
                $property_address = $r['Address'] . ' ' . $r['City'].', '.$r['State'].'. '.$r['Zipcode'];
            }else{
                redirect('/home');
            }
            $a = [
                "Listing_ID" => $this->input->post("Listing_ID"),
                "Message"    => $this->input->post("Message"),
                "Subject"    => $this->input->post("Subject")
            ];
            if(@$this->data["is_login"]){
            	$a["Full_Name"] = $this->data['user']["full_name"];
            	$a["Email"]     = $this->data['user']["email"];
            	$a["Member_ID"] = $this->data['user']["id"];
            }else{
            	$a["Full_Name"] = $this->input->post("Full_Name");
            	$a["Email"] = $this->input->post("Email");
            }
            $id = $this->Common_model->add("Message_Seller",$a);
            if($id){
            	$m = $this->Common_model->get_record("Members",["ID" => @$r["Member_ID"]]);
            	if ($m) {
            		$email = $m["Email"];
            		$subject = 'Inquiry: ' . $property_address . ', condopi.com';
            		$content = '<p>Condo PI has received an inquiry on your property ' . $property_address . ':</p>
            					<p>From: ' . $a["Email"] . '</p>
								<p>Subject: ' . $a["Subject"] . '</p>
								<p>' . $a["Message"] . '</p>';
            		// sendmail($email,$subject,$content);
            		
            		// Find email admin
                    $email_admin = getWebSetting("Email_Receive_Buy");
			        if (empty($email_admin)) {
			        	$email_admin = "support@condopi.com";
			        }
			        sendmail($email_admin,$subject,$content);
            	}
            }
        }
        redirect(get_link_item(@$r));
        //redirect('/listing/'.$this->input->post("Listing_ID").'/?after=1');
    }
    
    public function send_mail_renew() {
 		sendRenew();
 		die();
    }
    
    public function get_county() {
    	$v = $this->input->post('v');
    	$type = $this->input->post('type');
    	if ($type == 'search') {
    		echo '<option value="All">All</option>';
    	} else {
    		echo '<option value="">--------   Please choose one  --------</option>';
    	}
    	echo getListCounty($this->input->post('county'),false,$v);
    	die();
    }
    
    public function subscribe()
    {
        if ($this->input->post()) {
        	$errMsg = '';
        	if (!isset($_POST['g-recaptcha-response']) || empty($_POST['g-recaptcha-response'])) {
        		$errMsg = 'Please check I am not a robot';
        	} else if (!empty($_POST['g-recaptcha-response'])) {
		        $secret = '6Ld526sUAAAAACAem2GFuKk3B2a3jJdcGxfALIo3';
		        $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$_POST['g-recaptcha-response']);
		        $responseData = json_decode($verifyResponse);
        		if (!$responseData->success) {
            		$errMsg = 'Robot verification failed, please try again.';
        		}
   			}
	        $this->load->library('form_validation');
	        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
	        if ($this->form_validation->run() == false || !empty($errMsg)) {
            	$errMsg = !empty($errMsg) ? $errMsg : 'Please enter all information.';
                $this->session->set_flashdata('message', '<div class="alert alert-danger">'.$errMsg.'</div>');
            } else {
	            $record = $this->Common_model->get_record('Subscribers', array(
	                'Email' => $this->input->post('email')
	            ));
	            if (isset($record) && $record != null) {
	            	
	            } else {
                	$arr   = array(
	                    'Email' => $this->input->post('email')
	                );
	                $this->Common_model->add('Subscribers', $arr);
	            }
	            
            	$this->mailchimp_subscriber_status($this->input->post('email'),"pending");
               	$this->session->set_flashdata('message', '<div class="alert alert-success">Thank you for subscribing!</div>');
               	// Send mail to USER
            	$subject = 'Request for a Private Money Lender';
        		$content = '<p>Thank you for using condopi.com.<br/>
        					Our goal is to make your real estate transaction process as quick and easy as possible</p>
        					
							<p>Your request for a hard money loan has been sent to a lender.<br/>
							They will send you confirmation of your request and will soon contact you by email.<br/>
							We consider you a special customer. Thank you for your continued support.</p>
								
							<p>Best,<br/>
							Administrator<br/>
							condopi.com – #1 source for real estate deals</p>
							';
		        sendmail($this->input->post('email'),$subject,$content);
		        
               	// Send mail to admin
            	$subject = 'Buyer Requesting Hard Money Loan';
        		$content = '<p>
        					Name: Lender Banner Ad<br/>
        					Email: ' . $this->input->post('email') . '<br/>
							Phone: N/A<br/>
							Property: N/A</p>';
                $email_admin = getWebSetting("Email_Receive_Buy");
		        if (empty($email_admin)) {
		        	$email_admin = "support@condopi.com";
		        }
		        // sendmail($email_admin,$subject,$content);
		        
	        }
    	}
    	redirect('/');
    }
    
    function mailchimp_subscriber_status( $email, $status, $merge_fields = array('FNAME' => '','LNAME' => '') ) {
		$config_site = $this->session->userdata('config_site');
    	$group = '';
        if ($config_site['Body_Json'] != null && $config_site['Body_Json'] != '') {
            $Body_Json = json_decode($config_site['Body_Json'], true);
            $this->mailchimp_api_key = $Body_Json['Mailchimp_API'];
            $this->mailchimp_list_id = $Body_Json['Mailchimp_List_Id'];
            $group = @$Body_Json['Mailchimp_List_Group1_Id'];
        }
    	
    	$api_key = $this->mailchimp_api_key;
		$data = array(
			'apikey'        => $api_key,
	    	'email_address' => $email,
			'status'        => $status,
			'merge_fields'  => array('FNAME' => '','LNAME' => ''),
			'interests' => [$group => true]
		);
		$mch_api = curl_init(); // initialize cURL connection
	 
		curl_setopt($mch_api, CURLOPT_URL, 'https://' . substr($api_key,strpos($api_key,'-')+1) . '.api.mailchimp.com/3.0/lists/' . $this->mailchimp_list_id . '/members/' . md5(strtolower($data['email_address'])));
		curl_setopt($mch_api, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Authorization: Basic '.base64_encode( 'user:'.$api_key )));
		curl_setopt($mch_api, CURLOPT_USERAGENT, 'PHP-MCAPI/2.0');
		curl_setopt($mch_api, CURLOPT_RETURNTRANSFER, true); // return the API response
		curl_setopt($mch_api, CURLOPT_CUSTOMREQUEST, 'PUT'); // method PUT
		curl_setopt($mch_api, CURLOPT_TIMEOUT, 10);
		curl_setopt($mch_api, CURLOPT_POST, true);
		curl_setopt($mch_api, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($mch_api, CURLOPT_POSTFIELDS, json_encode($data) ); // send data in json
	 
		$result = curl_exec($mch_api);
		return $result;
	}
    
    public function error404() {
    	$this->data["is_show_search"] = 1;
    	$this->data["error404"] = TRUE;
    	$this->load->view('frontend/block/header',$this->data);
		$this->load->view('frontend/home/error404',$this->data);
		$this->load->view('frontend/block/footer',$this->data);
    }
    
    public function test() {
    	$api_key = $this->mailchimp_api_key;
    	$email= "nhan1110@gmail.com";
		$data = array(
			'apikey'        => $api_key,
	    	'email_address' => $email,
			'status'        => $status,
			'merge_fields'  => array('FNAME' => '','LNAME' => '')
		);
		$mch_api = curl_init(); // initialize cURL connection
	 
		curl_setopt($mch_api, CURLOPT_URL, 'https://' . substr($api_key,strpos($api_key,'-')+1) . '.api.mailchimp.com/3.0/lists/' . $this->mailchimp_list_id . '/members/' . md5(strtolower($data['email_address'])));
		curl_setopt($mch_api, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Authorization: Basic '.base64_encode( 'user:'.$api_key )));
		curl_setopt($mch_api, CURLOPT_USERAGENT, 'PHP-MCAPI/2.0');
		curl_setopt($mch_api, CURLOPT_RETURNTRANSFER, true); // return the API response
		curl_setopt($mch_api, CURLOPT_CUSTOMREQUEST, 'PUT'); // method PUT
		curl_setopt($mch_api, CURLOPT_TIMEOUT, 10);
		curl_setopt($mch_api, CURLOPT_POST, true);
		curl_setopt($mch_api, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($mch_api, CURLOPT_POSTFIELDS, json_encode($data) ); // send data in json
	 
		$result = curl_exec($mch_api);
		die(var_dump($result));
    }
    
}
