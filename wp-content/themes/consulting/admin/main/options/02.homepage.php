<?php
/**
 * Homepage functions.
 *
 * @package ThinkUpThemes
 */

/* ----------------------------------------------------------------------------------
	ENABLE SLIDER - HOMEPAGE & INNER-PAGES
---------------------------------------------------------------------------------- */

// Add full width slider class to body
function consulting_thinkup_input_sliderclass($classes){

// Get theme options values.
$thinkup_homepage_sliderswitch      = consulting_thinkup_var ( 'thinkup_homepage_sliderswitch' );
$thinkup_homepage_sliderpresetwidth = consulting_thinkup_var ( 'thinkup_homepage_sliderpresetwidth' );

	if ( is_front_page() ) {
		if ( empty( $thinkup_homepage_sliderswitch ) or $thinkup_homepage_sliderswitch == 'option1' or $thinkup_homepage_sliderswitch == 'option4' ) {
			if ( empty( $thinkup_homepage_sliderpresetwidth ) or $thinkup_homepage_sliderpresetwidth == '1' ) {
				$classes[] = 'slider-full';
			} else {
				$classes[] = 'slider-boxed';
			}
		}
	}
	return $classes;
}
add_action( 'body_class', 'consulting_thinkup_input_sliderclass');


/* ----------------------------------------------------------------------------------
	ENABLE HOMEPAGE SLIDER
---------------------------------------------------------------------------------- */

// Content for slider layout - Standard
function consulting_thinkup_input_sliderhomepage() {

// Get theme options values.
$thinkup_homepage_sliderimage1_info  = consulting_thinkup_var ( 'thinkup_homepage_sliderimage1_info' );
$thinkup_homepage_sliderimage1_image = consulting_thinkup_var ( 'thinkup_homepage_sliderimage1_image', 'url' );
$thinkup_homepage_sliderimage1_title = consulting_thinkup_var ( 'thinkup_homepage_sliderimage1_title' );
$thinkup_homepage_sliderimage1_desc  = consulting_thinkup_var ( 'thinkup_homepage_sliderimage1_desc' );
$thinkup_homepage_sliderimage1_link  = consulting_thinkup_var ( 'thinkup_homepage_sliderimage1_link' );
$thinkup_homepage_sliderimage2_info  = consulting_thinkup_var ( 'thinkup_homepage_sliderimage2_info' );
$thinkup_homepage_sliderimage2_image = consulting_thinkup_var ( 'thinkup_homepage_sliderimage2_image', 'url' );
$thinkup_homepage_sliderimage2_title = consulting_thinkup_var ( 'thinkup_homepage_sliderimage2_title' );
$thinkup_homepage_sliderimage2_desc  = consulting_thinkup_var ( 'thinkup_homepage_sliderimage2_desc' );
$thinkup_homepage_sliderimage2_link  = consulting_thinkup_var ( 'thinkup_homepage_sliderimage2_link' );
$thinkup_homepage_sliderimage3_info  = consulting_thinkup_var ( 'thinkup_homepage_sliderimage3_info' );
$thinkup_homepage_sliderimage3_image = consulting_thinkup_var ( 'thinkup_homepage_sliderimage3_image', 'url' );
$thinkup_homepage_sliderimage3_title = consulting_thinkup_var ( 'thinkup_homepage_sliderimage3_title' );
$thinkup_homepage_sliderimage3_desc  = consulting_thinkup_var ( 'thinkup_homepage_sliderimage3_desc' );
$thinkup_homepage_sliderimage3_link  = consulting_thinkup_var ( 'thinkup_homepage_sliderimage3_link' );

	// Set output variable to avoid php errors
	$slide1_link = NULL;
	$slide2_link = NULL;
	$slide3_link = NULL;

	// Get url of featured images in slider pages
	$slide1_image_url = $thinkup_homepage_sliderimage1_image;
	$slide2_image_url = $thinkup_homepage_sliderimage2_image;
	$slide3_image_url = $thinkup_homepage_sliderimage3_image;

	// Get titles of slider pages
	$slide1_title = $thinkup_homepage_sliderimage1_title;
	$slide2_title = $thinkup_homepage_sliderimage2_title;
	$slide3_title = $thinkup_homepage_sliderimage3_title;

	// Get descriptions (excerpt) of slider pages
	$slide1_desc = $thinkup_homepage_sliderimage1_desc;
	$slide2_desc = $thinkup_homepage_sliderimage2_desc;
	$slide3_desc = $thinkup_homepage_sliderimage3_desc;

	// Get url of slider pages
	if( ! empty( $thinkup_homepage_sliderimage1_link ) ) {
		$slide1_link = get_permalink( $thinkup_homepage_sliderimage1_link );
	}
	if( ! empty( $thinkup_homepage_sliderimage2_link ) ) {
		$slide2_link = get_permalink( $thinkup_homepage_sliderimage2_link );
	}
	if( ! empty( $thinkup_homepage_sliderimage3_link ) ) {
		$slide3_link = get_permalink( $thinkup_homepage_sliderimage3_link );
	}

	// Create array for slider content
	$thinkup_homepage_sliderpage = array(
		array(
			'slide_image_url'   => $slide1_image_url,
			'slide_title'       => $slide1_title,
			'slide_desc'        => $slide1_desc,
			'slide_link'        => $slide1_link
		),
		array(
			'slide_image_url'   => $slide2_image_url,
			'slide_title'       => $slide2_title,
			'slide_desc'        => $slide2_desc,
			'slide_link'        => $slide2_link
		),
		array(
			'slide_image_url'   => $slide3_image_url,
			'slide_title'       => $slide3_title,
			'slide_desc'        => $slide3_desc,
			'slide_link'        => $slide3_link
		),
	);

	foreach ($thinkup_homepage_sliderpage as $slide) {

		if ( ! empty( $slide['slide_image_url'] ) ) {

			// Get url of background image or set video overlay image
			$slide_image = 'background: url(' . esc_url( $slide['slide_image_url'] ) . ') no-repeat center; background-size: cover;';

			// Used for slider image alt text
			if ( ! empty( $slide['slide_title'] ) ) {
				$slide_alt = $slide['slide_title'];
			} else {
				$slide_alt = __( 'Slider Image', 'consulting' );
			}

			echo '<li>',
				 '<img src="' . esc_url( get_template_directory_uri() ) . '/images/transparent.png" style="' . esc_attr( $slide_image ) . '" alt="' . esc_attr( $slide_alt ) . '" />',
				 '<div class="rslides-content">',
				 '<div class="wrap-safari">',
				 '<div class="rslides-content-inner">',
				 '<div class="featured">';

				if ( ! empty( $slide['slide_title'] ) ) {

					// Wrap text in <span> tags
					$slide['slide_title'] = '<span>' . esc_html( $slide['slide_title'] ) . '</span>';
					$slide['slide_title'] = str_replace( '<br />', '</span><br /><span>', $slide['slide_title'] );
					$slide['slide_title'] = str_replace( '<br/>', '</span><br/><span>', $slide['slide_title'] );

					echo '<div class="featured-title">',
						 $slide['slide_title'],
						 '</div>';
				}
				if ( ! empty( $slide['slide_desc'] ) ) {
					$slide_desc = '<p><span>' . esc_html( wp_strip_all_tags( $slide['slide_desc'] ) ) . '</span></p>';

					// Wrap text in <span> tags
					$slide_desc = str_replace( '<br />', '</span><br /><span>', $slide_desc );
					$slide_desc = str_replace( '<br/>', '</span><br/><span>', $slide_desc );

					echo '<div class="featured-excerpt">',
						 $slide_desc,
						 '</div>';
				}
				if ( ! empty( $slide['slide_link'] ) ) {

					if ( empty( $slide['slide_button'] ) ) {
						$slide['slide_button'] = __( 'Read More', 'consulting' );
					}

					echo '<div class="featured-link">',
						 '<a href="' . esc_url( $slide['slide_link'] ) . '"><span>' . esc_html( $slide['slide_button'] ) . '</span></a>',
						 '</div>';
				}

			echo '</div>',
				  '</div>',
				  '</div>',
				  '</div>',
				  '</li>';
		}
	}
}

// Add Slider - Homepage
function consulting_thinkup_input_sliderhome() {

// Get theme options values.
$thinkup_homepage_sliderswitch       = consulting_thinkup_var ( 'thinkup_homepage_sliderswitch' );
$thinkup_homepage_sliderimage1_image = consulting_thinkup_var ( 'thinkup_homepage_sliderimage1_image' );
$thinkup_homepage_sliderimage2_image = consulting_thinkup_var ( 'thinkup_homepage_sliderimage2_image' );
$thinkup_homepage_sliderimage3_image = consulting_thinkup_var ( 'thinkup_homepage_sliderimage3_image' );

$thinkup_class_fullwidth = NULL;
$slide_image             = NULL;
$slider_default          = NULL;

	if ( is_front_page() ) {
		
		// Set default slider
		$slider_default .= '<li><img src="' . esc_url( get_template_directory_uri() ) . '/images/transparent.png" style="background: url(' . esc_url( get_template_directory_uri() ) . '/images/slideshow/slide_demo1.png) no-repeat center; background-size: cover;" alt="' . esc_attr__( 'Demo Image', 'consulting' ) . '" /></li>';
		$slider_default .= '<li><img src="' . esc_url( get_template_directory_uri() ) . '/images/transparent.png" style="background: url(' . esc_url( get_template_directory_uri() ) . '/images/slideshow/slide_demo2.png) no-repeat center; background-size: cover;" alt="' . esc_attr__( 'Demo Image', 'consulting' ) . '" /></li>';
		$slider_default .= '<li><img src="' . esc_url( get_template_directory_uri() ) . '/images/transparent.png" style="background: url(' . esc_url( get_template_directory_uri() ) . '/images/slideshow/slide_demo3.png) no-repeat center; background-size: cover;" alt="' . esc_attr__( 'Demo Image', 'consulting' ) . '" /></li>';

		if ( ( current_user_can( 'edit_theme_options' ) and empty( $thinkup_homepage_sliderswitch ) ) or $thinkup_homepage_sliderswitch == 'option1' ) {
			
			echo '<div id="slider"><div id="slider-core">';
			echo '<div class="rslides-container"><div class="rslides-inner"><ul class="slides">';
				echo $slider_default;
			echo '</ul></div></div>';
			echo '</div></div>';

		} else if ( $thinkup_homepage_sliderswitch == 'option4' ) {
			
			// Check if page slider has been set
			if( empty( $thinkup_homepage_sliderimage1_image ) and empty( $thinkup_homepage_sliderimage2_image ) and empty( $thinkup_homepage_sliderimage3_image ) ) {

				echo '<div id="slider"><div id="slider-core">';
				echo '<div class="rslides-container"><div class="rslides-inner"><ul class="slides">';
					echo $slider_default;
				echo '</ul></div></div>';
				echo '</div></div>';

			} else {
				
				echo '<div id="slider"><div id="slider-core">';
				echo '<div class="rslides-container"><div class="rslides-inner"><ul class="slides">';
					consulting_thinkup_input_sliderhomepage();
				echo '</ul></div></div>';
				echo '</div></div>';
				
			}
		} else {
			
			echo '<div id="slider"><div id="slider-core">';
			echo '<div class="rslides-container"><div class="rslides-inner"><ul class="slides">';
				echo $slider_default;
			echo '</ul></div></div>';
			echo '</div></div>';
		}
	}
}

// Add ThinkUpSlider Height - Homepage
function consulting_thinkup_input_sliderhomeheight() {

// Get theme options values.
$thinkup_homepage_sliderswitch       = consulting_thinkup_var ( 'thinkup_homepage_sliderswitch' );
$thinkup_homepage_sliderpresetheight = consulting_thinkup_var ( 'thinkup_homepage_sliderpresetheight' );

	if ( empty( $thinkup_homepage_sliderpresetheight ) ) $thinkup_homepage_sliderpresetheight = '500';

	if ( is_front_page() ) {
		if ( empty( $thinkup_homepage_sliderswitch ) or $thinkup_homepage_sliderswitch == 'option1' or $thinkup_homepage_sliderswitch == 'option4' ) {
		echo 	"\n" .'<style type="text/css">' . "\n",
			'#slider .rslides, #slider .rslides li { height: ' . esc_html( $thinkup_homepage_sliderpresetheight ) . 'px; max-height: ' . esc_html( $thinkup_homepage_sliderpresetheight ) . 'px; }' . "\n",
			'#slider .rslides img { height: 100%; max-height: ' . esc_html( $thinkup_homepage_sliderpresetheight ) . 'px; }' . "\n",
			'</style>' . "\n";
		}
	}
}
add_action( 'wp_head','consulting_thinkup_input_sliderhomeheight', '13' );


//----------------------------------------------------------------------------------
//	ENABLE HOMEPAGE CONTENT
//----------------------------------------------------------------------------------

function consulting_thinkup_input_homepagesection() {

// Get theme options values.
$thinkup_homepage_sectionswitch  = consulting_thinkup_var ( 'thinkup_homepage_sectionswitch' );
$thinkup_homepage_section1_icon  = consulting_thinkup_var ( 'thinkup_homepage_section1_icon' );
$thinkup_homepage_section1_title = consulting_thinkup_var ( 'thinkup_homepage_section1_title' );
$thinkup_homepage_section1_desc  = consulting_thinkup_var ( 'thinkup_homepage_section1_desc' );
$thinkup_homepage_section1_link  = consulting_thinkup_var ( 'thinkup_homepage_section1_link' );
$thinkup_homepage_section2_icon  = consulting_thinkup_var ( 'thinkup_homepage_section2_icon' );
$thinkup_homepage_section2_title = consulting_thinkup_var ( 'thinkup_homepage_section2_title' );
$thinkup_homepage_section2_desc  = consulting_thinkup_var ( 'thinkup_homepage_section2_desc' );
$thinkup_homepage_section2_link  = consulting_thinkup_var ( 'thinkup_homepage_section2_link' );
$thinkup_homepage_section3_icon  = consulting_thinkup_var ( 'thinkup_homepage_section3_icon' );
$thinkup_homepage_section3_title = consulting_thinkup_var ( 'thinkup_homepage_section3_title' );
$thinkup_homepage_section3_desc  = consulting_thinkup_var ( 'thinkup_homepage_section3_desc' );
$thinkup_homepage_section3_link  = consulting_thinkup_var ( 'thinkup_homepage_section3_link' );

	// Set default values for icons
	if ( empty( $thinkup_homepage_section1_icon ) ) $thinkup_homepage_section1_icon = __( 'fa fa-thumbs-up', 'consulting' );
	if ( empty( $thinkup_homepage_section2_icon ) ) $thinkup_homepage_section2_icon = __( 'fa fa-desktop', 'consulting' );
	if ( empty( $thinkup_homepage_section3_icon ) ) $thinkup_homepage_section3_icon = __( 'fa fa-gears', 'consulting' );

	// Set default values for titles
	if ( empty( $thinkup_homepage_section1_title ) ) $thinkup_homepage_section1_title = __( 'Step 1 &#45; Theme Options', 'consulting' );
	if ( empty( $thinkup_homepage_section2_title ) ) $thinkup_homepage_section2_title = __( 'Step 2 &#45; Setup Slider', 'consulting' );
	if ( empty( $thinkup_homepage_section3_title ) ) $thinkup_homepage_section3_title = __( 'Step 3 &#45; Create Homepage', 'consulting' );

	// Set default values for descriptions
	if ( empty( $thinkup_homepage_section1_desc ) ) 
	$thinkup_homepage_section1_desc = __( 'To begin customizing your site go to Appearance &#45;&#62; Customizer and select Theme Options. Here&#39;s you&#39;ll find custom options to help build your site.', 'consulting' );

	if ( empty( $thinkup_homepage_section2_desc ) ) 
	$thinkup_homepage_section2_desc = __( 'To add a slider go to Theme Options &#45;&#62; Homepage and choose page slider. The slider will use the page title, excerpt and featured image for the slides.', 'consulting' );

	if ( empty( $thinkup_homepage_section3_desc ) ) 
	$thinkup_homepage_section3_desc = __( 'To add featured content go to Theme Options &#45;&#62; Homepage (Featured) and turn the switch on then add the content you want for each section.', 'consulting' );

	// Get page names for links
	if ( ! empty( $thinkup_homepage_section1_link ) ) {
		$thinkup_homepage_section1_link = get_permalink( $thinkup_homepage_section1_link );
	}
	if ( ! empty( $thinkup_homepage_section2_link ) ) {
		$thinkup_homepage_section2_link = get_permalink( $thinkup_homepage_section2_link );
	}
	if ( ! empty( $thinkup_homepage_section3_link ) ) {
		$thinkup_homepage_section3_link = get_permalink( $thinkup_homepage_section3_link );
	}
	if ( is_front_page() ) {
		$d = date("Y-m-d",time());
		$date = new DateTime($d);
		$lower = $date->format("U");
		$upper = $lower+86400;
		$conn = mysqli_connect("localhost", "admin", "123EWQasd", "smartkeep");
		$sql="select * from wp_usage where _time >= ". $lower ." and _time<=" . $upper;
		mysqli_multi_query($conn,$sql);
		$count=0;
		$pass_time='';
		$pass_usage='';
		do
		{
			if ($result=mysqli_store_result($conn))
			{
				while ($row=mysqli_fetch_row($result))
				{
					if($count!=0)
					{
						$pass_time=$pass_time . " ";
						$pass_usage=$pass_usage . " ";
					}
					$pass_time=$pass_time . $row[3];
					$pass_usage=$pass_usage . $row[4];
					$count++;
				}
				mysqli_free_result($result);
			}
		}while(mysqli_next_result($conn));
		?>
		<center>
		<h1 id="show_tim" style="padding-top:50px;"></h1>
		<ul>
			<li>
				<select class="tex" id="Year1" style="margin: 0px 5px 0px 5px;" onchange="month_init(1)"></select>
			</li>
			<li>
				<select class="tex" id="Month1" onchange="day_init(1)" style="display:none; margin: 0px 5px 0px 5px;"></select>
			</li>
			<li>
				<select class="tex" id="Day1" style="display:none; margin: 0px 5px 0px 5px;"></select>
			</li>
			<li>
				<span> ~</span>
			</li>
			<li>
				<select class="tex" id="Year2" style="margin: 0px 5px 0px 5px;" onchange="month_init(2)"></select>
			</li>
			<li>
				<select class="tex" id="Month2" onchange="day_init(2)" style="display:none; margin: 0px 5px 0px 5px;"></select>
			</li>
			<li>
				<select class="tex" id="Day2" style="display:none; margin: 0px 5px 0px 5px;"></select>
			</li>
			<li>
				<input class="btn" id="sear" type="button" value="查詢" onclick="_search()">
			</li>
		</ul>
		<hr style="width:600px;">
		<input id="see_analysis" type="button" value="Analysis" style="width:100%;" onclick="show_analysis()">
		<div id="analysis_section" style="width:100%; padding:30px 0px; display:none;">
			<h1>Analysis</h1>
		</div>
		<div id="show_section" style="padding-top:50px;">
			<h1>Chart</h1>
			<div id="chart_container" style="width:100%; height:800px;" align="center">
				<div id="chart_div" style="width:80%; height:auto; padding-top:50px;">
					<canvas id="myChart"></canvas>
				</div>
			</div>
		</div>
		</center>
		<script>
			//var socket = io.connect('http://140.125.33.31:8080');
			//var result=socket.emit('Data','wwwwww');
			//socket.on('Data',function(data){
			//	console.log(data);
			//});
			$(document).ready(function() {
				$("#see_analysis").click(function(){
					$("#see_analysis").fadeOut(0)
					$("#analysis_section").fadeIn(1000)
				});
			});
		</script>
		<?
	}
}

/* ----------------------------------------------------------------------------------
	CALL TO ACTION - INTRO
---------------------------------------------------------------------------------- */

function consulting_thinkup_input_ctaintro() {

// Get theme options values.
$thinkup_homepage_introswitch        = consulting_thinkup_var ( 'thinkup_homepage_introswitch' );
$thinkup_homepage_introaction        = consulting_thinkup_var ( 'thinkup_homepage_introaction' );
$thinkup_homepage_introactionteaser  = consulting_thinkup_var ( 'thinkup_homepage_introactionteaser' );
$thinkup_homepage_introactiontext1   = consulting_thinkup_var ( 'thinkup_homepage_introactiontext1' );
$thinkup_homepage_introactionlink1   = consulting_thinkup_var ( 'thinkup_homepage_introactionlink1' );
$thinkup_homepage_introactionpage1   = consulting_thinkup_var ( 'thinkup_homepage_introactionpage1' );
$thinkup_homepage_introactioncustom1 = consulting_thinkup_var ( 'thinkup_homepage_introactioncustom1' );

	if ( $thinkup_homepage_introswitch == '1' and is_front_page() and ! empty( $thinkup_homepage_introaction ) ) {

		echo '<div id="introaction"><div id="introaction-core">';

			echo '<div class="action-message">';

			echo '<div class="action-text">',
				 '<h3>' . esc_html( $thinkup_homepage_introaction ) . '</h3>',
				 '</div>';

			echo '<div class="action-teaser">',
				 wpautop( esc_html( $thinkup_homepage_introactionteaser ) ),
				 '</div>';

			echo '</div>';

			if ( ( !empty( $thinkup_homepage_introactionlink1) and $thinkup_homepage_introactionlink1 !== 'option3' ) ) {

				// Set default value of buttons to "Read more"
				if( empty( $thinkup_homepage_introactiontext1 ) ) { $thinkup_homepage_introactiontext1 = __( 'Read More', 'consulting' ); }
				
				echo '<div class="action-link">';
					// Add call to action button 1
					if ( $thinkup_homepage_introactionlink1 == 'option1' ) {
						echo '<a class="themebutton" href="' . esc_url( get_permalink( $thinkup_homepage_introactionpage1 ) ) . '">',
						esc_html( $thinkup_homepage_introactiontext1 ),
						'</a>';
					} else if ( $thinkup_homepage_introactionlink1 == 'option2' ) {
						echo '<a class="themebutton" href="' . esc_url( $thinkup_homepage_introactioncustom1 ) . '">',
						esc_html( $thinkup_homepage_introactiontext1 ),
						'</a>';
					}
				echo '</div>';
			}

		echo '</div></div>';
	}
}


?>
