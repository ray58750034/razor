<section id="main" class="column">
<div style="height:420px;">
		<iframe src="<?php echo site_url() ?>/channel/active/viewgraph/<?php echo $key?>"  frameborder="0" scrolling="no"style="width:100%;height:100%;"></iframe>		
	</div>
	<article class="module width_full">
		<header>
			<h3 class="tabs_involved"><?php echo lang('v_rpt_mk_channelList') ?></h3>		
		</header>
		<table class="tablesorter" cellspacing="0">
			<thead>
				<tr>
					<th><?php echo lang('v_man_au_channelName') ?></th>
					<th><?php echo lang('v_rpt_mk_newToday') ?></th>
					<th><?php echo lang('v_rpt_mk_newYesterday') ?></th>
					<th><?php echo lang('v_rpt_mk_activeToday') ?></th>
					<th><?php echo lang('v_rpt_mk_activeYesterday') ?></th>
					<th><?php echo lang('t_accumulatedUsers') ?></th>
					<th><?php echo lang('t_activeRateWeekly') ?></th>
					<th><?php echo lang('t_activeRateMonthly') ?></th>
					<!--  th>时段内新增（%）</th>-->

				</tr>
			</thead>
			<tbody>

		<tr>
					<td><?php echo $todaydata['channel_name']?></td>
					<td><?php echo $todaydata['newusers']
	?></td>
					<td><?php echo $yestodaydata['newusers']?></td>
					<td><?php echo $todaydata['startusers']?></td>
					<td><?php echo $yestodaydata['startusers']?></td>
					<td><?php echo $todaydata['allusers']?></td>
					<td><?php if(empty($sevendayactive['percent'])){echo '0.0%';}
					else{ echo round($sevendayactive['percent']*100,1).'%';}?></td>
					<td><?php if(empty($thirtydayactive['percent'])){echo '0.0%';}
					else{ echo round($thirtydayactive['percent']*100,1).'%';}?></td>
					<!--  td><?php // echo ($new_user_time_phase[$i]*100)."%" ; ?></td>-->
				</tr>
	</tbody>
		</table>
	</article>	
</section>