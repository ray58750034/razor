<section id="main" class="column" style="height:1000px;">
<h4 class="alert_success" id='msg' style="display:none;"></h4>
<article class="module width_full">
<header><h3 class="tabs_involved"><?php echo  lang('v_rpt_vi_title')?></h3>
</header>
<table class="tablesorter" cellspacing="0">
<thead>
<tr>
<th><?php echo  lang('v_rpt_vi_appVersion')?></th>
<th><?php echo  lang('v_rpt_vi_channelName')?></th>
<th><?php echo  lang('v_rpt_vi_totalUser')?></th>
<th><?php echo  lang('v_rpt_vi_sessionCount')?></th>
</tr>
</thead>
<tbody>
<?php if(isset($versionList)&&count($versionList)>0):
    $allusers = 0;
    $allsessions = 0;
    for ($i=0;$i<count($versionList);$i++)
    {
        $row = $versionList[$i];
        $allusers+=$row['total'];
        $allsessions+=$row['session'];
        
    }
    for($i=0;$i<count($versionList);$i++)
    {
        $row = $versionList[$i];
        ?>
<tr>
<td><?php echo ($row['version']==null)?lang('t_unknow'):$row['version'];?></td>
<td><?php echo ($row['channel']==null)?lang('t_unknow'):$row['channel'];?></td>
<td><?php echo $row['total']."(".percent($row['total'], $allusers).")";?></td>
<td><?php echo $row['session']."(".percent($row['session'], $allsessions).")";?></td>
</tr>
<?php } endif;?>
</tbody>
</table>
</article>
<div style="height:400px;">
<iframe src="<?php echo site_url() ?>/report/vida/userreporthourly"  frameborder="0" scrolling="no"style="width:100%;height:100%;"></iframe>
</div>
<div style="height:400px;">
<iframe src="<?php echo site_url() ?>/report/vida/userreportdaily"  frameborder="0" scrolling="no"style="width:100%;height:100%;"></iframe>
</div>
<!--
<div style="height:400px;">
<iframe src="<?php echo site_url() ?>/report/vida/userreportmonthly"  frameborder="0" scrolling="no"style="width:100%;height:100%;"></iframe>
</div>
-->
<div class="spacer"></div>

</section>
<script type="text/javascript">
function changenew()
{
	var type =document.getElementById('111').innerHTML;
	document.getElementById('userper').innerHTML=type+"<?php echo  lang('g_percent')?>";
	document.getElementById('userper1').innerHTML=type+"<?php echo  lang('g_percent')?>";
}
function changeactive()
{
	var type =document.getElementById('222').innerHTML;
	document.getElementById('userper').innerHTML=type+"<?php echo  lang('g_percent')?>";
	document.getElementById('userper1').innerHTML=type+"<?php echo  lang('g_percent')?>";
}
</script>

<script type="text/javascript">
function changeday()
{
	var type =document.getElementById('whichday').innerHTML;
	if(type=="<?php echo  lang('v_rpt_ve_viewToday')?>")
	{
		document.getElementById('day').innerHTML="<?php echo  lang('v_rpt_ve_versionST')?>";
		document.getElementById('whichday').innerHTML="<?php echo  lang('v_rpt_ve_viewYesterday')?>";
	}
	else
	{
		document.getElementById('day').innerHTML="<?php echo  lang('v_rpt_ve_ersionSY')?>";
		document.getElementById('whichday').innerHTML="<?php echo  lang('v_rpt_ve_viewToday')?>"	;
	}
}
function changeactive()
{
	var type =document.getElementById('222').innerHTML;
	document.getElementById('userper').innerHTML=type+"<?php echo  lang('g_percent')?>";
	document.getElementById('userper1').innerHTML=type+"<?php echo  lang('g_percent')?>";
}
</script>
<script type="text/javascript">
var styleName = 'NewUser';
var version='5'
</script>

<script type="text/javascript">
var chartversion = 'default';
var time = '7day';
var fromTime='';
var toTime='';
var jsondata;
var contrast_data;
var titlename='';

//When page loads...
$(".tab_content").hide(); //Hide all content
$("ul.tabs3 li:first").addClass("active").show(); //Activate first tab
$(".tab_content:first").show(); //Show first tab content
function changeStyleName(name)
{
	styleName = name;
	getdata();
}
function selectStyletop(value)
{
    if(value=='TOP5')
    {
        version='5';
        getdata();
    }
    if(value=='TOP10')
    {
    	version='10';
        getdata();
        
    }
    if(value=='all')
    {
    	version='100';
        getdata();
    }
}
//On Click Event
$("ul.tabs3 li").click(function() {
                       $("ul.tabs3 li").removeClass("active"); //Remove any "active" class
                       $(this).addClass("active"); //Add "active" class to selected tab
                       var activeTab = $(this).find("a").attr("mt"); //Find the href attribute value to identify the active tab + content
                       $('#'+activeTab).fadeIn(); //Fade in the active ID content
                       return true;
                       });
</script>

<script type="text/javascript">
$(function() {
  $("#dpFrom1" ).datepicker();
  });
$( "#dpFrom1" ).datepicker({ dateFormat: "yy-mm-dd" });
$(function() {
  $( "#dpTo1" ).datepicker();
  });
$( "#dpTo1" ).datepicker({ dateFormat: "yy-mm-dd" });
$(function() {
  $("#dpFrom2" ).datepicker();
  });
$( "#dpFrom2" ).datepicker({ dateFormat: "yy-mm-dd" });
$(function() {
  $( "#dpTo2" ).datepicker();
  });
$( "#dpTo2" ).datepicker({ dateFormat: "yy-mm-dd" });
</script>

<script type="text/javascript">
function styleTimeButtonClicked()
{
	fromTime1 = document.getElementById('dpFrom1').value;
	toTime1 = document.getElementById('dpTo1').value;
	document.getElementById('newuserfromto1').innerHTML = "("+fromTime1 + '-' + toTime1+")";
	fromTime2 = document.getElementById('dpFrom2').value;
	toTime2 = document.getElementById('dpTo2').value;
	document.getElementById('newuserfromto2').innerHTML = "("+fromTime2 + '-' + toTime2+")";
	ft1=new Date(fromTime1);
	tot1=new Date(toTime1);
	ft2=new Date(fromTime2);
	tot2=new Date(toTime2);
	if(ft1>tot1||ft2>tot2){
        alert('<?php echo lang("g_timeError")?>');return;}
	getdata();
}

</script>
<script type="text/javascript">
function getdata()
{
	var myurl = "";
	if(styleName == 'NewUser')
	{
		myurl="<?php echo site_url()?>/report/version/getVersionContrast/"+fromTime1+"/"+toTime1+"/"+fromTime2+"/"+toTime2+"/"+version;
	}
	else
	{
        myurl="<?php echo site_url()?>/report/version/getVersionContrast/"+fromTime1+"/"+toTime1+"/"+fromTime2+"/"+toTime2+"/"+version;
	}
	
	jQuery.ajax({
                type : "post",
                url : myurl,
                success : function(msg) {
                document.getElementById('msg').innerHTML = "<?php echo  lang('v_rpt_ve_competeLoad')?>";
                document.getElementById('msg').style.display="block";
                jsonData=eval("("+msg+")");
                contrast_data = jsonData;
                
                if(document.getElementById("versinlist").value!="")
                {
				clearSel(document.getElementById("versinlist"));
                }
                
                for(j = 0;j<jsonData[1].length;j++)
                {
			    if(styleName == "NewUser")
			    {
                document.getElementById('versinlist').innerHTML+='<tr><td>'+jsonData[0][j]['version_name']+'</td><td>'+jsonData[0][j]['newuserpercent']+'</td><td>'+jsonData[1][j]['newuserpercent']+'</td></tr>';
			    }
			    if(styleName == "ActiveUser")
			    {
                document.getElementById('versinlist').innerHTML+='<tr><td>'+jsonData[0][j]['version_name']+'</td><td>'+jsonData[0][j]['startuserpercent']+'</td><td>'+jsonData[1][j]['startuserpercent']+'</td></tr>';
			    }
                }
                
                },
                error : function(XmlHttpRequest, textStatus, errorThrown) {
                document.getElementById('msg').innerHTML = "<?php echo  lang('t_error')?>";
                document.getElementById('msg').style.display="block";
                
                },
                beforeSend : function() {
                document.getElementById('msg').innerHTML = '<?php echo  lang('v_rpt_ve_waitLoad')?>';
                document.getElementById('msg').style.display="block";
                
                },
                complete : function() {
                }
                });
}
</script>
<script type="text/javascript">

function onContrastTabClicked(styleName)
{
	var jsonData = contrast_data;
	
	if(document.getElementById("versinlist").value!="")
	{
		clearSel(document.getElementById("versinlist"));
	}
    
	for(j = 0;j<jsonData[1].length;j++)
    {
	    if(styleName == "NewUser")
            document.getElementById('versinlist').innerHTML+='<tr><td>'+jsonData[0][j]['version_name']+'</td><td>'+jsonData[0][j]['newuserpercent']+'</td><td>'+jsonData[1][j]['newuserpercent']+'</td></tr>';
	    if(styleName == "ActiveUser")
            document.getElementById('versinlist').innerHTML+='<tr><td>'+jsonData[0][j]['version_name']+'</td><td>'+jsonData[0][j]['startuserpercent']+'</td><td>'+jsonData[1][j]['startuserpercent']+'</td></tr>';
	    
    }
}
</script>
<script type="text/javascript">
function setTBodyInnerHTML(tbody, html) {
    var temp = tbody.ownerDocument.createElement('div');
    temp.innerHTML = '<table><tbody id=\"content\">' + html + '</tbody></table>';
    tbody.parentNode.replaceChild(temp.firstChild.firstChild, tbody);
}       
</script>
<script type="text/javascript">
function clearSel(selectname){
    
    while(selectname.childNodes.length>0){
        selectname.removeChild(selectname.childNodes[0]);
    }
}  
</script>
