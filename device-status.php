<link rel="stylesheet" type="text/css" href="http://140.125.33.33/wp-includes/css/style.css">
<div id="all" style="position:fixed; top:0px; left:0px; bottom:0px; right:0px; width:auto; height:auto; z-index:100000; display:none;" onclick="clos()"></div>
<div id="cover" style="position:fixed; top:0px; bottom:0px; left:0px; right:0px; width:auto; height:auto; background-color:rgba(0,0,0,0.8); z-index:100001; border-radius:10px; display:none; border:rgba(0,0,0,0.3) solid 10px;">
	<label style="position:fixed; right:15px; top:20px; color:#FFF; font-size:18px; cursor:pointer; background:#CCC;"  onclick="clos()">&nbsp;X&nbsp;</label>
	<center>
	<h1 style="color:#FFF;">Device Control</h1><hr width="350">
	<div id="status_div" style="width:800px; height:auto;"><canvas id="Chart" style="z-index:100002;"></canvas></div><br>
	<ul style="display:inline;">
		<li style="display:inline;">
			<select class="tex" id="Year" style="margin: 0px 5px 0px 5px;" onchange="mon_ini()"></select>
		</li>
		<li style="display:inline;">
			<select class="tex" id="Month" onchange="day_ini()" style="margin: 0px 5px 0px 5px;"></select>
		</li>
		<li style="display:inline;">
			<select class="tex" id="Day" style="margin: 0px 5px 0px 5px;"></select>
		</li>
		<li style="display:inline;">
			<select class="tex" id="Hour" style="margin: 0px 5px 0px 5px;">
			<?
			for($h=0;$h<=23;$h++){
				?><option value="<?=$h?>"><?=$h?>時</option><?
			}
			?>
			</select>
		</li>
		<li style="display:inline;">
			<select class="tex" id="Min" style="margin: 0px 5px 0px 5px;">
			<?
                        for($m=0;$m<=59;$m++){
                                ?><option value="<?=$m?>"><?=$m?>分</option><?
                        }
                        ?>
			</select>
		</li>
		<li id="on_off" style="display:inline;">
			
		</li>
	</ul>
	</center>
</div>
<table class="table table-striped" style="width:100%;">
    <h1>Device Status</h1>
    <hr width="150" align="left">
    <thead class="thead-dark"><tr><th scope="col">Device ID</th><th scope="col">Current Update Time</th><th scope="col">Current Usage(kWh)</th><th scope="col">Status</th><th scope="col">On/Off</th></tr></thead>
	<tbody>
	<?
		$conn=mysqli_connect("140.125.33.31", "admin", "123EWQasd", "smartkeep");
		mysqli_multi_query($conn,"select _pid,_usage,Max(_time) as _time from wp_usage group by _pid asc;");
		do
		{
			if ($result=mysqli_store_result($conn))
			{
				while ($row=mysqli_fetch_row($result))
				{
					?>
					<tr>
					<th scope="row"><?=$row[0]?></th>
					<th><?=date('Y-m-d H:i:s',$row[2])?></th>
					<th><?=$row[1]?></th>
					<th>
					<?
						$tmp=$row[1]==0?0:1;
						if($tmp!=0)
						{
							?>
							<label class="switch">
							<input id="switch<?=$row[0]?>" type="checkbox" onclick="on_off(<?=$row[0]?>)" checked>
							<span class="slider round"></span>
							</label>
							<?
						}
						else
						{
							?>
							<label class="switch">
                                                        <input id="switch<?=$row[0]?>" type="checkbox" onclick="on_off(<?=$row[0]?>)">
                                                        <span class="slider round"></span>
                                                        </label>
							<?
						}
					?>
					</th>
					<th>
                                        <?
                                                $tmp=$row[1]==0?0:1;
                                                if($tmp!=0)
                                                {
                                                        ?>
                                                        <label class="switch">
                                                        <input id="sw<?=$row[0]?>" type="checkbox" onclick="turn_on_off(<?=$row[0]?>,0,1)" checked>
                                                        <span class="slider round"></span>
                                                        </label>
                                                        <?
                                                }
                                                else
                                                {
                                                        ?>
                                                        <label class="switch">
                                                        <input id="sw<?=$row[0]?>" type="checkbox" onclick="turn_on_off(<?=$row[0]?>,0,0)">
                                                        <span class="slider round"></span>
                                                        </label>
                                                        <?
                                                }
                                        ?>
					</th>
					</tr>
					<?
				}
				mysqli_free_result($result);
			}
		}while(mysqli_next_result($conn));
	?>
	</tbody>
</table>
