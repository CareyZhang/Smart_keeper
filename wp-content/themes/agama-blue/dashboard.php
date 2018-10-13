<?php 
/**
 * Template Name:Dashboard
 *
 * A custom page template without sidebar.
 *
 * The main template file
 *
 * @package Theme-Vision
 * @subpackage Agama Blue
 * @since 1.0
 */

// Do not allow direct access to the file.
if( ! defined( 'ABSPATH' ) ) {
    exit;
} 

global $wp_query;
?>

<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<!--Bootstrap's css-->
<link href="http://10.3.141.1/wp-includes/css/bootstrap/bootstrap.min.css" rel="stylesheet">
<link href="http://10.3.141.1/wp-includes/css/bootstrap/bootstrap-select.min.css" rel=stylesheet">
<!--Datetimepicker's css-->
<link href="http://10.3.141.1/wp-includes/css/datetimepicker/datetimepicker.min.css" rel="stylesheet">
<!--JQuery-->
<script src="http://10.3.141.1/wp-includes/js/jquery/jquery-3.3.1.min.js"></script>
<!--Socket.IO js-->
<script src="http://10.3.141.1/wp-includes/js/socketio/socket.io.js"></script>
<!--Bootstrap's js-->
<script src="http://10.3.141.1/wp-includes/js/bootstrap/bootstrap.min.js"></script>
<script src="http://10.3.141.1/wp-includes/js/bootstrap/bootstrap-select.min.js"></script>
<!--Datetimepicker's js-->
<script src="http://10.3.141.1/wp-includes/js/moment.js"></script>
<script src="http://10.3.141.1/wp-includes/js/datetimepicker/datetimepicker.min.js"></script>
<!--HighChart's js-->
<script src="http://10.3.141.1/wp-includes/js/highchart/highstock.js"></script>
<script src="http://10.3.141.1/wp-includes/js/highchart/exporting.js"></script>
<script src="http://10.3.141.1/wp-includes/js/highchart/indicators.js"></script>
<script src="http://10.3.141.1/wp-includes/js/highchart/mfi.js"></script>
<style>
.cover
{
	z-index:9999;
}
#cover
{
	width:100%;
	height:auto;
	position:fixed; top:0px; right:0px; bottom:0px; left:0px;
	background:rgba(255,255,255,0.8);
	display:none;
}
#clo
{
	width:50px;
	height:50px;
	border-radius:50px;
	position:fixed; top:0px; right:0px;
	background:rgba(0,0,0,0.9);
	font-size:36px;
	text-align:center;
	line-height:50px;
	cursor:pointer;
}
#dev_content
{
	width:80%;
	height:auto;
	color:#000;
	padding-top:50px;
	font-size:36px;
}
#dev_name
{
	width:100%;
	height:50px;
}
#dev_status_chart
{
	width:100%;
	padding-top:50px;
	height:450px;
}
#dev_switch
{
	width:100%;
	height:100px;
}
.div_container
{
	width:100%;
	max-height:800px;
	position:absolute; left:0px;
}
.div_left
{
	width:49%;
	height:600px;
	float:left;
	background:#fff;
	position:relative; top:0px;
}
.div_right
{
	width:49%;
	height:600px;
	float:right;
	position:relative; top:0px;
}
.div_bottom
{
	width:100%;
	height:300px;
	float:left;
	background:#FCC;
	overflow-y:scroll;
}
.this_month_free_div
{
	width:100%;
	height:300px;
	padding-top:30px;
}
.current_energy_used_div
{
	width:100%;
	height:280px;
	padding-top:10px;
}
.total_used_div
{
	width:100%;
	height:450px;
}
.next_event_div
{
	width:100%;
	height:130px;
	padding-top:10px;
}
.device_status_div
{
	width:100%;
	height:auto;
}
</style>
<script>
var energy_free = 3;
var limit_free;
var socket = io.connect('http://10.3.141.1:9090');
$(function(){
	get_limit_free();
	this_month_free_calculate();
	current_energy_used_calculate();
	total_energy_used_calculate();
	get_device_status();
});

function get_limit_free()
{
	var lim;
	$.ajaxSettings.async = false;
	$.getJSON("http://10.3.141.1:1880/data?sql=select * from wp_limit_free limit 1",function(data){
		data.forEach(function(point){
			limit_free = point._limit;
		});
	});
	$.ajaxSettings.async = true;
}

function current_energy_used_calculate()
{
	var total = 0;
	var d=get_this_date_unix_stamp();
	var addr = "http://10.3.141.1:1880/data?sql=select * from wp_sensor_total where start_time>=".concat(d);
	$.getJSON(addr,function(data){
		var hour_sensor_data_energy = [];
		var hour_group = new Array();
		for(var i=0;i<24;i++)
		{
			hour_group[i]=0;
		}
		data.forEach(function(point){
			var group_index = Math.floor((point.start_time-d)/3600000);
			hour_group[group_index] += point.total_used;
		});
		for(var i=0;i<24;i++)
		{
			var hour_start_unix_stamp = d + i*3600000;
			var dd = unix_stamp_to_hour(hour_start_unix_stamp);
			hour_sensor_data_energy.push([dd+"點",hour_group[i]]);
		}
		Highcharts.chart('current_energy_used_container',{
			chart:{
				plotBackgroundColor:null,
				plotBorderWidth:null,
				plotShadow:false,
				type:'pie'
			},
			title:{
				text:'近24小時用電量'
			},
			tooltip:{
				pointFormat:'{point.x}點:{point.y}'
			},
			plotOptions:{
				pie:{
					allowPointSelect:true,
					cursor:'pointer',
					dataLabels:{
						enabled:true,
						format:'{point.x}點:{point.percentage:.1f}%'
					}
				}
			},
			series:[{
				type:'pie',
				id:'used',
				name:'用量',
				colorByPoint:true,
				data:hour_sensor_data_energy
			}]
			
		});
	});
}

function this_month_free_calculate()
{
	var total = 0;
	var d = get_this_month_unix_stamp();
	var addr = "http://10.3.141.1:1880/data?sql=select * from wp_sensor_total where start_time>=".concat(d);
	$.getJSON(addr,function(data){
		data.forEach(function(point){
			total += point.total_used*1
		});
		var free = (total/1000)*energy_free;
		var proportion;
		var tmp;
		if(free<=limit_free)	//in limit
		{
			proportion = free/limit_free;
			$("#proportion_div1").width(proportion*99+"%");
			$("#proportion_div1").height(50);
			$("#proportion_div1").css({"background":"rgb(0,128,0)"});
			$("#proportion_div2").height(60);
			$("#proportion_div2").css({"background":"rgb(200,200,200)"});
			$("#proportion_div2").css({"padding-top":"80px"});
			$("#proportion_div2").css({"font-size":"24px"});
			$("#proportion_div2").html(free+"$");
			$("#proportion_div3").width((1-proportion)*99+"%");
			$("#proportion_div3").height(50);
			$("#proportion_div3").css({"background":"rgb(0,255,0)"});
			$("#proportion_div4").height(60);
			$("#proportion_div4").css({"background":"rgb(200,200,200)"});
			$("#proportion_div4").css({"padding-top":"80px"});
			$("#proportion_div4").css({"font-size":"24px"});
			$("#proportion_div4").html(limit_free+"$");
		}
		else	//over limit
		{
			proportion = limit_free/free;
			$("#proportion_div1").width(proportion*99+"%");
			$("#proportion_div1").height(50);
			$("#proportion_div1").css({"background":"rgb(255,0,0)"});
			$("#proportion_div2").height(60);
			$("#proportion_div2").css({"background":"rgb(200,200,200)"});
			$("#proportion_div2").css({"padding-top":"80px"});
			$("#proportion_div2").css({"font-size":"24px"});
			$("#proportion_div2").html(limit_free+"$");
			$("#proportion_div3").width((1-proportion)*99+"%");
			$("#proportion_div3").height(50);
			$("#proportion_div3").css({"background":"rgb(128,0,0)"});
			$("#proportion_div4").height(60);
			$("#proportion_div4").css({"background":"rgb(200,200,200)"});
			$("#proportion_div4").css({"padding-top":"80px"});
			$("#proportion_div4").css({"font-size":"24px"});
			$("#proportion_div4").html(free+"%");
		}
	});
}

function total_energy_used_calculate()
{
	$.getJSON('http://10.3.141.1:1880/data?sql=select * from wp_sensor_total',function(data){
		var sensor_data_energy = [];
		function tonum(num)
		{
			if(num)
				return parseFloat(num);
			else
				return null;
		}
		var d = new Date();
		var n = d.getTimezoneOffset()*60*1000;
		data.forEach(function (point){
			sensor_data_energy.push([
				point.start_time-n,
				point.total_used*1
			]);
		});
		Highcharts.stockChart('total_used_container',{
			rangeSelector:{
				selected: 1
			},
			title:{
				text: '裝置總用電量'
			},
			yAxis:[{
				labels:{
					align: 'left',
				},
				title:{
					text: '總耗電量(Whr)'
				},
				height: '100%',
				lineWidth: 2
			}],
			tooltip:{
				split: true,
				valueDecimals: 2,
			},
			series:[{
				type: 'line',
				id: 'energy',
				name: '用量',
				data: sensor_data_energy,
				marker:{
					enabled: false
				},
				params:{
					period:14
				}
			}]
		});
	});
}

function get_device_status()
{
	var dev = [];
	$.getJSON("http://10.3.141.1:1880/data?sql=select * from wp_sensor_data inner join wp_dev on wp_sensor_data._dev_id=wp_dev._id group by _dev_id having max(_time) and _type=0 order by _id",function(data){
		data.forEach(function(point){
			$("#device_table_append").append("<tr><th scope='row'>"+point._id+"</th><td id='dev_name"+point._id+"'>"+point._name+"</td><td id='dev_status"+point._id+"'>"+(point._status==0?"Off":"On")+"</td><td id='dev_current_used"+point._id+"'>"+(point._status==0?0:point._data)+"W</td><td id='operate_time"+point._id+"'>"+(point._stauts==0?unix_stamp_to_date(point._current_disconnect_time*1):unix_stamp_to_date(point._current_connect_time*1))+"</td><td id='used_time"+point._id+"'>"+(point._status!=0?get_used_time(Date.now()-point._current_connect_time*1):"-")+"</td><td id='dev_switch"+point._id+"'><a style='cursor:pointer;' onclick='dev_switch("+point._id+","+point._status+")'>"+(point._status==0?"開啟裝置":"關閉裝置")+"</a></td><td><a style='cursor:pointer;' onclick='device_management("+point._id+")'>Click here...</a></td></tr>");
		});
	});
}

function dev_switch(_id,dev_status)
{
	var signal=(dev_status==0?1:0);
	var message = {
		_dev_id: _id,
		_signal: signal
	};
	socket.emit('remote_device',message);
}

function device_management(_id)
{
	var name = $("#dev_name"+_id).text();
	$("#dev_name").html("<a style='cursor:pointer;' onclick='dev_rename("+_id+")'>"+name+"</a>");
	show_device_status_chart(_id);
	var timer_html=`<div class="col-sm-6">
				<div class="form-group">
					<div class="input-group date" id="datetimepicker" data-target-input="nearest">
						<input type="text" class="form-control datetimepicker-input" data-target="#datetimepicker">
						<div class="input-group-append" data-target="#datetimepicker" data-toggle="datetimepicker">
							<div class="input-group-text">
								<i class="fa fa-calendar"></i>
							</div>
						</div>
					</div>
				</div>
			</div>`;
	$("#dev_switch").html(timer_html);
	$(function(){
		$("#datetimepicker").datetimepicker();
	});
	$("#cover").fadeIn(1000);
}

function dev_rename(_id)
{
	var name = $("#dev_name"+_id).text();
	var name_html = `<div class="input-group mb-3">
				<div class="input-group-prepend">
					<span class="input-group-text">裝置名稱</span>
				</div>
				<input type="text" class="form-control" id="rename" value="`+name+`" placeholder="請輸入裝置名稱">
				<div class="input-group-append">
				<span class="input-group-text btn btn-default" onclick="confirm_rename(`+_id+`)">更改</span>
				</div>
			</div>`;
	$("#dev_name").html(name_html);
}

function confirm_rename(_id)
{
	var name = $("#rename").val()
		$.getJSON("http://10.3.141.1:1880/data?sql=update wp_dev set _name='"+name+"' where _id="+_id+"");
	$("#dev_name").html("<a style='cursor:pointer;' onclick='dev_rename("+_id+")'>"+name+"</a>");
	$("#dev_name"+_id).text(name);
}

function show_device_status_chart(_id)
{
	$.getJSON("http://10.3.141.1:1880/data?sql=select * from wp_sensor_data where _type=0 and _dev_id="+_id,function(data){
		var sensor_data_energy = [];
		function tonum(num)
		{
			if(num)
				return parseFloat(num);
			else
				return null;
		}
		var d = new Date();
		var n = d.getTimezoneOffset()*60*1000;
		data.forEach(function(point){
			sensor_data_energy.push([point._time-n,point._data*1]);
		});
		Highcharts.stockChart('dev_status_chart',{
			rangeSelector:{
				selected:1
			},
			title:{
				text:'用電狀態'
			},
			yAxis:[{
				labels:{
					align:'left'
				},
				title:{
					text:'裝置耗電量'
				},
				height: '100%',
				lineWidth:2
			}],
			tooltip:{
				split:true,
				valueDecimals:2
			},
			series:[{
				type:'line',
				id:'energy',
				name:'用量',
				data:sensor_data_energy,
				marker:{
					enabled:false
				},
				params:{
					period:14
				}
			}]
		});
	});
}

function clos()
{
	$("#cover").fadeOut(1000);
	var wait=setInterval(function(){
		if(!$("#cover").is("animated"))
		{
			clearInterval(wait);
			$("#dev_name").html("");
			$("#dev_status_chart").html("");
			$("#dev_switch").html("");
		}
	},1000);
}

function get_used_time(UNIX_timestamp)
{
	UNIX_timestamp/=1000;
	var days = Math.floor(UNIX_timestamp/86400);
	var hours = Math.floor((UNIX_timestamp-days*86400)/3600);
	var minutes = Math.floor((UNIX_timestamp-days*86400-hours*3600)/60);
	var time="";
	if(UNIX_timestamp<60)
	{
		return "Without 1 minute."
	}
	if(days>1)
	{
		time=time.concat(days," days ");
	}
	else if(days==1)
	{
		time=time.concat(days," day ");
	}
	if(hours>1)
	{
		time=time.concat(hours," hours ");
	}
	else if(hours==1)
	{
		time=time.concat(hours," hour ");
	}
	if(minutes>1)
	{
		time=time.concat(minutes," minutes");
	}
	else if(minutes==1)
	{
		time=time.concat(minutes," minute");
	}
	return time;
}

function unix_stamp_to_hour(UNIX_timestamp)
{
	var a = new Date(UNIX_timestamp)
	var months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
	var year = a.getFullYear();
	var month = months[a.getMonth()];
	var date = a.getDate();
	var hour = a.getHours();
	var time = (a.getMonth()+1)+'/'+date+' '+hour;
	return time;
}

function unix_stamp_to_date(UNIX_timestamp)
{
	var a = new Date(UNIX_timestamp);
	var months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
	var year = a.getFullYear();
	var month = months[a.getMonth()];
	var date = a.getDate();
	var hour = a.getHours();
	var min = a.getMinutes();
	var sec = a.getSeconds();
	var time = (a.getMonth()+1)+'/'+date+' '+hour+':'+min;
	return time;
}

function get_this_month_unix_stamp()
{
	var d = new Date();
	var a = new Date(d.getFullYear(),d.getMonth(),1).getTime();
	return a;
}

function get_this_date_unix_stamp()
{
	var d = new Date();
	var a = new Date(d.getFullYear(),d.getMonth(),d.getDate()).getTime();
	return a;
}
</script>

<?php get_header(); ?>
<div class="cover" id="cover" align="center">
	<div class="cover" id="clo" onclick="clos()">X</div>
	<div class="cover" id="dev_content">
		<div class="cover" id="dev_name"></div>
		<div class="cover" id="dev_status_chart"></div>
		<div class="cover" id="dev_switch"></div>
	</div>
</div>
<div class="div_container">
	<div class="div_left">
		<div class="this_month_free_div">
			<center>
				<span style="font-size:24px;">本月電費</span>
				<div id="this_month_free" style="margin:20px 0px;">
					<div id="free_proportion_div" style="width:80%; height:50px;">
						<div id="proportion_div1" style="float:left;"></div>
						<div id="proportion_div2" style="float:left; width:0.5%;"></div>
						<div id="proportion_div3" style="float:left;"></div>
						<div id="proportion_div4" style="float:left; width:0.5%;"></div>
					</div>
				</div>
			</center>
		</div>
		<div class="current_energy_used_div">
			<div id="current_energy_used_container" style="width:100%; height:290px;"></div>
		</div>
	</div>

	<div class="div_right">
		<div class="total_used_div">
			<div id="total_used_container" style="width:100%; height:420px;"></div>
		</div>
		<div class="next_event_div">
			<span>下個定時開關事件</span>
		</div>
	</div>

	<div class="div_bottom">
		<center>
			<div class="device_status_div" style="padding:20px 0px;">
				<span style="font-size:24px;">所有裝置狀態</span>
				<div id="device_status_container" style="width:100%; height:auto;">
					<table class="table" style="width:100%; height:auto; margin-top:20px;" align="center">
						<thead>
							<tr>
								<th scope="col">裝置代號</th>
								<th scope="col">裝置名稱</th>
								<th scope="col">裝置狀態(On/Off)</th>
								<th scope="col">目前耗電量</th>
								<th scope="col">開啟/關閉時間</th>
								<th scope="col">用電時長</th>
								<th scope="col">開關裝置</th>
								<th scope="col">管理設備</th>
							</tr>
						</thead>
						<tbody id="device_table_append">
						</tbody>
					</table>
				</div>
			</div>
		</center>
	</div>
</div>
