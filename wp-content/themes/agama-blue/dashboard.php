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

global $wp_query; ?>

<link href="http://10.3.141.1/wp-includes/css/bootstrap/bootstrap.min.css" rel="stylesheet">
<link href="http://10.3.141.1/wp-includes/css/bootstrap/bootstrap-select.min.css" rel="stylesheet">
<script src="http://10.3.141.1/wp-includes/js/bootstrap/bootstrap.min.js"></script>
<script src="http://10.3.141.1/wp-includes/js/bootstrap/bootstrap-select.min.js"></script>
<script src="http://10.3.141.1/wp-includes/js/jquery/jquery-3.3.1.min.js"></script>
<script src="http://10.3.141.1/wp-includes/js/highchart/highstock.js"></script>
<script src="http://10.3.141.1/wp-includes/js/highchart/exporting.js"></script>
<script src="http://10.3.141.1/wp-includes/js/highchart/indicators.js"></script>
<script src="http://10.3.141.1/wp-includes/js/highchart/mfi.js"></script>
<style>
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
	width:100px;
	height:auto;
}
</style>
<script>
var energy_free = 3;
var limit_free;
$(function(){
	get_limit_free();
	this_month_free_calculate();
	current_energy_used_calculate();
	total_energy_used_calculate();
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
	var addr = "http://10.3.141.1:1880/data?sql=select * from wp_sensor_total";
	$.getJSON(addr,function(data){
		var hour_sensor_data_energy = [];
		var hour_group = new Array();
		for(var i=0;i<24;i++)
		{
			hour_group[i]=0;
		}
		data.forEach(function(point){
			if(point.start_time>=d)
			{
				var group_index = Math.floor((point.start_time-d)/3600000);
				hour_group[group_index] += point.total_used;
			}
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
	var addr = "http://10.3.141.1:1880/data?sql=select * from wp_sensor_total";
	$.getJSON(addr,function(data){
		data.forEach(function(point){
			if(point.start_time>=d)
			{
				total += point.total_used*1
			}
		});
		var free = (total/60000)*energy_free;
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
					text: '總耗電量'
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
	var a = new Date(UNIX_timestamp*1000);
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
		<div class="device_status_div">
			<span>裝置狀態</span>
		</div>
	</div>
</div>
