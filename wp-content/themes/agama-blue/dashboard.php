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

<?php get_header()?>

<style>
.div_container
{
	width:100%;
	max-height:600px;
	position:absolute; left:0px;
}
.div_left
{
	width:49%;
	height:400px;
	float:left;
	background:#ccc;
	position:relative; top:0px;
}
.div_right
{
	width:49%;
	height:400px;
	float:right;
	background:#ACC;
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
	height:200px;
}
.current_energy_used_div
{
	width:100%;
	height:180px;
	padding-top:10px;
}
.today_energy_used_div
{
	width:100%;
	height:250px;
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
<div class="div_container">
	<div class="div_left">
		<div class="this_month_free_div">
			<span>當月電費</span>
		</div>
		<div class="current_energy_used_div">
			<span>近24小時用電量/當前用電量</span>
		</div>
	</div>

	<div class="div_right">
		<div class="today_energy_used_div">
			<span>今日耗電量</span>
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
