<section class="section_maeginstyle"  id="highchart"
<?php if(!isset($delete)) {?>
style="background: url(<?php echo base_url(); ?>assets/images/sidebar_shadow.png) repeat-y left top;"<?php }?>>	
	<article class="module width_full">
	<header>
		<div style="float:left;margin-left:2%;margin-top: 5px;">
	  </div>
	<h3 class="h3_fontstyle">		
	<?php  echo lang('v_rpt_mk_timeSegmentAnalysis') ?></h3>
			<ul class="tabs2">
				<li><a id='newuser'
					href="javascript:chooseType('newuser')"><?php echo lang('t_newUsers') ?></a></li>
				<li><a id='activeuser'
					href="javascript:chooseType('activeuser')"><?php echo lang('t_activeUsers') ?></a></li>
				</ul>
		</header>
		<div class="module_content">
			<div id="container" class="module_content" style="height: 300px"></div>
		</div>
	</article>
</section>
<script type="text/javascript">
//When page loads...
$(".tab_content").hide(); //Hide all content
$("ul.tabs2 li:first").addClass("active").show(); //Activate first tab 
$(".tab_content:first").show(); //Show first tab content

//On Click Event
$("ul.tabs2 li").click(function() {
	$("ul.tabs2 li").removeClass("active"); //Remove any "active" class
	$(this).addClass("active"); //Add "active" class to selected tab
	var activeTab = $(this).find("a").attr("id"); //Find the href attribute value to identify the active tab + content
	$(activeTab).fadeIn(); //Fade in the active ID content
	return true;
});
</script>

<script type="text/javascript">
var chart;
var options;
var type="newuser";
var optionsLength=0;
var markEventIndex=[];//save all markevent series index
var  allusers= new Array();
var category=[];
var tooltipmarkevent=[];
var tooltipdata=new Array(new Array(),new Array());
var tooltipname=[];
var colors=['#4572A7', '#AA4643', '#89A54E', '#80699B', '#3D96AE', '#DB843D', '#92A8CD', 
             '#A47D7C', '#B5CA92','#4572A7', '#AA4643', '#89A54E', '#80699B', '#3D96AE', 
             '#DB843D', '#92A8CD', '#A47D7C', '#B5CA92'];
$(document).ready(function() {	
	options = {
		            chart: {
		                renderTo: 'container',
		                type: 'spline'
		            },
		            title: {
		                text: ''
		            },
		            subtitle: {
		                text: '<?php echo $reportTitle['timePase']; ?>'
		            },
		            xAxis: {
		                labels:{rotation:300,y:40,x:0}
		            },
		            yAxis: {
		                title: {
		                    text: ''
		                },
		                min:0,
		                labels: {
		                    formatter: function() {
		                        return Highcharts.numberFormat(this.value, 0);
		                    }
		                }
		            },
			        credits:{
						enabled:false
				        },
				    tooltip: {
				        crosshairs: true,
				        shared:false,
				        formatter: function() {
					        var content=this.x+'<br>';
					        var m=0;					       
					        for(var i=0;i<category.length;i++){
						        if(category[i]==this.x){
							        m=i;
							        break;
						        }
						    }
					        if(this.series.name=='<?php echo lang('m_dateevents');?>'){
		                           content=tooltipmarkevent[m];
		                    }else{
			                    for(var j=0;j<tooltipname.length;j++){
				                    content=content+'<span style="color:'+colors[j]+'">'+tooltipname[j]+'</span>:'+tooltipdata[j][m]+'<br>';
				                }
		                    }
					        return content;
				        }
				    },
		            plotOptions: {
			            column: {
	                    showInLegend:false
	                	},
		                spline: {
		                    marker: {
		                        radius: 1,
		                        lineColor: '#666666',
		                        lineWidth: 1
		                    }
		                },series:{
		                	cursor:'pointer',
		                	events:{
		        				click:function(e){
		        					if(!markEventIndex.content(e.point.series.index)){
		        						sendBack(e);
		        						return;
		        						}
		    						var rights=e.point.rights==1?'<?php echo lang('m_public')?>':'<?php echo lang('m_private')?>';
		        					var content='<div><?php echo lang('m_marktime')?>:'+e.point.date+'</div>';
		        					content+='<div><?php echo lang('m_user')?>:'+e.point.username+'</div>';
		        					content+='<div><?php echo lang('m_title')?>:'+e.point.title+'</div>';
		        					content+='<div><?php echo lang('m_description')?>:'+e.point.description+'</div>';
		        					content+='<div><?php echo lang('m_rights')?>:'+rights+'</div>';
		        					 hs.htmlExpand(null, {
		                                 pageOrigin: {
		                                     x: e.pageX,
		                                     y: e.pageY
		                                 },
		                                 headingText: '<?php echo lang('m_eventsDetail')?>',
		                                 maincontentText:content,
		                                 width: 200
		                             });	
		        					}
		                        }
			                }
		            },
		            legend:{
		                labelFormatter: function() {
		                	return this.name
		                }
		             },
		            series: [
		        
		            ]
		        };
	var myurl="<?php echo site_url();?>/channel/active/getMarketData/"+type+"/<?php echo $key?>";	
	renderCharts(myurl);	
});
</script>
<script type="text/javascript">     
    function renderCharts(myurl)
    {
    	
      	 var chart_canvas = $('#container');
      	    var loading_img = $("<img src='<?php echo base_url();?>/assets/images/loader.gif'/>");
      		    
      	    chart_canvas.block({
      	        message: loading_img,
      	        css:{
      	            width:'32px',
      	            border:'none',
      	            background: 'none'
      	        },
      	        overlayCSS:{
      	            backgroundColor: '#FFF',
      	            opacity: 0.8
      	        },
      	        baseZ:997
      	    });
      	    
      	 	jQuery.getJSON(myurl, null, function(data) { 
          	 	      		
          		var data_array =[];
          		for(var key in data.dataList.content)
              	{
              		data_array.push(key);              		
          		}
          		for(var j=0;j<data_array.length;j++)
          	    {    
         			     		
          			var reportData=[];    
          			var reportTitle;      			
          		    var marketData = data_array[j];          		   
          		    var eachmarketdata = data.dataList.content[marketData];            		            		   
          		    var categories = [];
          		    for(var i=0;i<eachmarketdata.length;i++)
          		    {
          		    	       
              		           var eachdata = eachmarketdata[i];                 		    
                		    	 if(type=='newuser')
                   		    	{
                		    		 reportData.push(parseFloat(eachdata.newusers,10)); 
                		    		 reportTitle="<?php echo $reportTitle['newUser'] ?>";     
                   		    	}

                   		    	if(type=='activeuser')
                   		    	{
                      		    	 reportData.push(parseFloat(eachdata.activeusers,10));
                       		    	 reportTitle="<?php echo $reportTitle['activeUser'] ?>";       
                   		    	}                 		    	
                   			
                   		    categories.push(eachdata.datevalue.substr(0,10));  
          		    }
            		category=categories;            		
            		options.series[j]={};
           			if(marketData=="")
           				{
           				options.series[j].name="<?php echo lang('t_unknow');?>";
           				}
           			else
           				{
           				  options.series[j].name=marketData;
           				}  
	       				if(type=="weekrate"||type=="monthrate") 
	       				{           				
	       					options.yAxis.max=100;
	           			}
	           			else
		           		{
		           			options.yAxis.max=null;
	           			}
       				 	 tooltipdata[j]= reportData;	 
       				 	 tooltipname[j]= options.series[j].name;
           				 options.series[j].data = reportData;
           				 options.title.text = reportTitle;
            			 options.xAxis.labels.step = parseInt(categories.length/10);
                  		 options.xAxis.categories = categories;
                   		 optionsLength=(j+1); 
                   		     			   		         			  		   
          	    }
        		 //content markevent
         		 var marklist=data.marklist;
          		 if(marklist!=null)
          		 {
           			var defdate=data.defdate;
    			    var markevents=data.markevents;
    			    if(marklist.length>=1){
    			    	$.each(marklist,function(index,item){
    				    	markEventIndex[index]=optionsLength;
    				    	options.series[optionsLength]={};
    				    	options.series[optionsLength].type='column';
    				    	options.series[optionsLength].name="<?php echo lang('m_dateevents');?>";
    				    	options.colors=[];
    				    	options.colors[optionsLength]="#DB9D00";
    				    	var contentdata=[];
    				    	for(var j=0;j<defdate.length;j++){
    							var markevent=null;
    				    		$.each(markevents,function(i,o){
    				    			if(item.userid==o.userid){
    									if(defdate[j]==o.marktime){
    										markevent=o;
    									}	
    								}
    					    	});
    							if(markevent!=null){
    								tooltipmarkevent[j]=markevent.title;
    								contentdata.push(markevent);
    							}else{
    								contentdata.push(null);
    								}	
    						}
    				    	options.series[optionsLength].data=prepare(contentdata,options,index);
    					    });
    				    }
                 }
			//end content   
          	    chart = new Highcharts.Chart(options);
          		chart_canvas.unblock();
          		});  
    }
  	    
</script>
<script type="text/javascript">

    function chooseType(typename)
    {     
        type=typename;    	
    	myurl="<?php echo site_url();?>/report/market/getMarketData/"+type+"/<?php echo $key?>";    	
    	renderCharts(myurl);
    	 
    }
</script>

<?php include 'application/views/manage/pointmark_base.php';?>