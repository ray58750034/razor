<?php
    /**
     * Cobub Razor
     *
     * An open source analytics for mobile applications
     *
     * @package		Cobub Razor
     * @author		WBTECH Dev Team
     * @copyright	Copyright (c) 2011 - 2012, NanJing Western Bridge Co.,Ltd.
     * @license		http://www.cobub.com/products/cobub-razor/license
     * @link		http://www.cobub.com/products/cobub-razor/
     * @since		Version 1.0
     * @filesource
     */
    class vidaactiveusermodel extends CI_Model {
        
        function __construct() {
            $this->load->database ();
        }
        
        //get basic info
        function getChannelData($productId,$date)
        {
            $vidadb = $this->load->database ( 'vida', TRUE );
            
            $sql = "select hu.channel, hu.version, hu.totaluser, hu.totalsession from ".$vidadb->dbprefix('report_hourly_user')." hu where hu.period='$date' and hu.product_id=$productId order by hu.totaluser desc";
                        
            $query = $vidadb->query ( $sql );
            $basicRet = $query->result();
            $ret = array();
            $totalusers = 0;
            $activeUsers = 0;
            if($basicRet!=null && count($basicRet)>0)
            {
                
                for($i=0;$i<count($basicRet);$i++)
                {
                    $record = array();
                    $record["version"] = $basicRet[$i]->version;
                    $record["channel"] = $basicRet[$i]->channel;
                    $record["total"] = $basicRet[$i]->totaluser;
                    $record["session"] = $basicRet[$i]->totalsession;
                    
                    array_push($ret, $record);
                }
            }
            return $ret;
        }
        
        function getChannelHourlyData($productId, $fromdate, $todate){
            $vidadb = $this->load->database ( 'vida', TRUE );
            
            $sql = "select hu.channel, hu.version, hu.activeuser, hu.updateuser, hu.period from ".$vidadb->dbprefix('report_hourly_user')." hu where hu.period>'$fromdate' and hu.period<'$todate' and hu.product_id=$productId";
            
            $query = $vidadb->query ( $sql );
            
            $ret=array();
            
            if ($query != null && $query->num_rows > 0) {
                
                $arr = $query->result_array ();
                
                $content_arr = array ();
                for($i = 0; $i < count ( $arr ); $i ++) {
                    $row = $arr [$i];
                    $versionname = $row['channel'].' '.$row ['version'];
                    $allkey = array_keys ( $content_arr );
                    if (! in_array ( $versionname, $allkey ))
                        $content_arr [$versionname] = array ();
                    $tmp = array ();
                    
                    $tmp ['startusers'] = $row ['updateuser'];
                    $tmp ['datevalue'] = substr($row['period'],0,13);
                    $tmp ['newusers'] = $row ['activeuser'];
                    $tmp ['version_name'] = $versionname;
                    array_push ( $content_arr [$versionname], $tmp );
                    
                }
                $ret['content'] = $content_arr;
                
            }
                        
            return $ret;
        }
        
        function getChannelDailyData($productId, $fromdate, $todate){
            $vidadb = $this->load->database ( 'vida', TRUE );
            
            $sql = "select hu.channel, hu.version, hu.activeuser, hu.updateuser, hu.period from ".$vidadb->dbprefix('report_daily_user')." hu where hu.period>'$fromdate' and hu.period<'$todate' and hu.product_id=$productId";
            
            $query = $vidadb->query ( $sql );
            
            $ret=array();
            
            if ($query != null && $query->num_rows > 0) {
                
                $arr = $query->result_array ();
                
                $content_arr = array ();
                for($i = 0; $i < count ( $arr ); $i ++) {
                    $row = $arr [$i];
                    $versionname = $row['channel'].' '.$row ['version'];
                    $allkey = array_keys ( $content_arr );
                    if (! in_array ( $versionname, $allkey ))
                        $content_arr [$versionname] = array ();
                    $tmp = array ();
                    
                    $tmp ['startusers'] = $row ['updateuser'];
                    $tmp ['datevalue'] = substr($row['period'],0,10);
                    $tmp ['newusers'] = $row ['activeuser'];
                    $tmp ['version_name'] = $versionname;
                    array_push ( $content_arr [$versionname], $tmp );
                    
                }
                $ret['content'] = $content_arr;
                
            }
            
            return $ret;
        }

        function getChannelMonthlyData($productId, $fromdate, $todate){
            $vidadb = $this->load->database ( 'vida', TRUE );
            
            $sql = "select hu.channel, hu.version, hu.activeuser, hu.updateuser, hu.period from ".$vidadb->dbprefix('report_monthly_user')." hu where hu.period>'$fromdate' and hu.period<'$todate' and hu.product_id=$productId";
            
            $query = $vidadb->query ( $sql );
            
            $query = $vidadb->query ( $sql );
            
            $ret=array();
            
            if ($query != null && $query->num_rows > 0) {
                
                $arr = $query->result_array ();
                
                $content_arr = array ();
                for($i = 0; $i < count ( $arr ); $i ++) {
                    $row = $arr [$i];
                    $versionname = $row['channel'].' '.$row ['version'];
                    $allkey = array_keys ( $content_arr );
                    if (! in_array ( $versionname, $allkey ))
                        $content_arr [$versionname] = array ();
                    $tmp = array ();
                    
                    $tmp ['startusers'] = $row ['updateuser'];
                    $tmp ['datevalue'] = substr($row['period'],0,10);
                    $tmp ['newusers'] = $row ['activeuser'];
                    $tmp ['version_name'] = $versionname;
                    array_push ( $content_arr [$versionname], $tmp );
                    
                }
                $ret['content'] = $content_arr;
                
            }
                        
            return $ret;
        }

                
    }
    
    ?>