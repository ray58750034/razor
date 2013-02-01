<?php

class active extends CI_Controller{
	private $data = array();
	
	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load	->library('form_validation');
		$this->load->Model('common');
		//$this->load->model('channelmodel','channel');
		$this->load->model('product/productmodel','product');
		$this->load->model('product/newusermodel','newusermodel');
	}
	
	function view($key='')
	{
		$channel_id = 0;
		if($key == 'M4o6cd1vJrp1mm9r'){
			$channel_id = '9';
		}

		if($channel_id>0){
			$productId = 1;//$product->id;
			$today = date ( 'Y-m-d', time () );
			$count7=date("w")+7;
			$yestodayTime = date ( "Y-m-d", strtotime ( "-1 day" ) );
			$seven_day = date ( "Y-m-d", strtotime ("-".$count7." day") );
			$thirty_day = date ( "Y-m-d", strtotime ( "-1 month" ) );
			$thirty_day = substr($thirty_day,0,8).'01';
			
			$todayData = $this->product->getAnalyzeDataByDateAndProductID($today,$productId);
	    	$yestodayData = $this->product->getAnalyzeDataByDateAndProductID($yestodayTime,$productId);
	    	$sevendayactive=$this->product->getActiveDays($seven_day,0,$productId);
			$thirtydayactive=$this->product->getActiveDays($thirty_day,1,$productId);
			
			$count = $todayData->num_rows();
			
			$todaydatas = $todayData->result_array();
			$yestodaydatas = $yestodayData->result_array();
			$sevendayDatas = $sevendayactive->result_array();
			$thirtydayDatas = $thirtydayactive->result_array();
			
			
			$data['key'] = $key;
			for($i=0; $i<$count; $i++){
				if($todaydatas[$i]['channel_id'] == $channel_id){
					$data['sevendayactive'] = $sevendayDatas[$i];
					$data['thirtydayactive'] = $thirtydayDatas[$i];
					$data['todaydata'] = $todaydatas[$i];
					$data['yestodaydata'] = $yestodaydatas[$i];
					break;
				}
			}
			
			$this->common->loadHeader();
			$this->load->view('channel/view',$data);
		}
	}
	
	//load channel market report
	function viewgraph($key='')

	{
		$fromTime = $this->common->getFromTime ();

		$toTime = $this->common->getToTime ();

		$data['reportTitle'] = array(

				'timePase' => getTimePhaseStr($fromTime, $toTime),

				'newUser'=>  getReportTitle(lang("v_rpt_mk_newUserStatistics")." ".null , $fromTime, $toTime),

				'activeUser'=> getReportTitle(lang("v_rpt_mk_activeuserS")." ".null , $fromTime, $toTime),

		);
		$data['key'] = $key;
		
		$this->load->view ('layout/reportheader');
		$this->load->view('channel/channelmarket',$data);
	}
	
	function getMarketData($type='',$key='')
	{
		$productId = 1;
		$channelId = 0;
		if($key == 'M4o6cd1vJrp1mm9r'){
			$channelId = '9';
		}
		
		if($channelId>0){
			$fromTime = $this->common->getFromTime ();
			$toTime = $this->common->getToTime ();
			$data = $this->product->getChanneldata($productId, $channelId,$fromTime,$toTime);
				
			$result = array();
			$result['dataList']=$data;		
			
			echo  json_encode($result);
		}
	}
}

?>