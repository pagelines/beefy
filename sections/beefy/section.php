<?php
/*
	Section: Beefy Slider
	Author: Aleksander Hansson
	Author URI: http://ahansson.com
	Demo: http://beefy.ahansson.com
	Description: Beefy Slider is a great slider to show images on your site. Beefy Slider is beautifully responsive, comes with color control and supports up to 20 images of your choice. Sounds tasty? Buy Beefy ;)
	Class Name: Beefy
	Workswith: templates, main
	Cloning:true
	Filter: slider, gallery
*/

class Beefy extends PageLinesSection {

	var $default_limit = 4;

	function section_styles(){

		wp_enqueue_script('jquery');

		wp_enqueue_script('beefy', $this->base_url.'/js/jquery.carouFredSel-6.2.1-packed.js');

		wp_enqueue_script('jquery-mousewheel', $this->base_url.'/js/jquery.mousewheel.min.js');
		wp_enqueue_script('jquery-touchswipe', $this->base_url.'/js/jquery.touchSwipe.min.js');
		wp_enqueue_script('jquery-transit', $this->base_url.'/js/jquery.transit.min.js');
		wp_enqueue_script('jquery-ba-throttle-debounce', $this->base_url.'/js/jquery.ba-throttle-debounce.min.js');

	}

	function section_head() {

		$clone_id = $this->get_the_id();

		$prefix = ($clone_id != '') ? 'Clone_'.$clone_id : '';

		$speed = ($this->opt('beefy_speed')) ? ($this->opt('beefy_speed')) : '50000';

		if ( $this->opt( 'beefy_direction' ) == 'backwards') {
			$direction = 'left';
		} else {
			$direction = 'right';
		}

		if ( $this->opt( 'beefy_hover' ) == 'n') {
			$hover = '';
		} else {
			$hover = ', pauseOnHover    : "immediate"';
		}

		$height = ($this->opt('beefy_img_height')) ? ($this->opt('beefy_img_height')) : '350px';

		?>
			<script type="text/javascript">
				jQuery(document).ready(function () {

					jQuery("#scroller<?php echo $prefix; ?> ul").carouFredSel({
						auto : {
							easing: "linear",
							duration: <?php echo $speed; ?>,
							timeoutDuration : 0
							<?php echo $hover; ?>
						},
						width: "100%",
						items 	: {
							visible: 4,
							height: "<?php echo $height; ?>"
						},
						direction : "<?php echo $direction; ?>"

					});

				});
			</script>
		<?php

	}

	function section_template( ) {



		$clone_id = $this->get_the_id();

		$prefix = ($clone_id != '') ? 'Clone_'.$clone_id : '';

		$height = ($this->opt('beefy_img_height')) ? ($this->opt('beefy_img_height')) : '350px';

		$width = ($this->opt('beefy_img_width')) ? ($this->opt('beefy_img_width')) : 'auto';

		$beefy_array = $this->opt('beefy_array');

		$format_upgrade_mapping = array(
			'text'	=> 'beefy_text_%s',
			'alt'	=> 'beefy_alt_%s',
			'link'	=> 'beefy_link_%s',
			'image'	=> 'beefy_image_%s',
		);

		$beefy_array = $this->upgrade_to_array_format( 'beefy_array', $beefy_array, $format_upgrade_mapping, $this->opt('beefy_slides'));

		if( !$beefy_array || $beefy_array == 'false' || !is_array($beefy_array) ){
			$beefy_array = array( array(), array(), array(), array() );
		}


		if( is_array($beefy_array) ){
			
			$slides = count( $beefy_array );

			foreach( $beefy_array as $slide ){

				if(pl_array_get( 'image', $slide )){

					$the_text = pl_array_get( 'text', $slide );;

					$img_alt = pl_array_get( 'alt', $slide );;

					$div_style = sprintf('style="background-color:%s;"', pl_hashify($this->opt('beefy_color_div')) ? pl_hashify($this->opt('beefy_color_div')) : '#223a5f');

					$span_style = sprintf('style="color:%s;"', pl_hashify($this->opt('beefy_color_span')) ? pl_hashify($this->opt('beefy_color_span')) : '#ffffff');

					$text = ($the_text) ? sprintf('<div %s><span data-sync="beefy_text_%s" %s>%s</span></div>', $div_style, $i, $span_style, $the_text) : '';

					$img = sprintf('<img data-sync="beefy_image_%s" src="%s" alt="%s" style="height:%s; width:%s;"/>', $i, pl_array_get( 'image', $slide ), $img_alt, $height, $width );

					$slide = (pl_array_get( 'link', $slide )) ? sprintf('<a href="%s">%s</a>', pl_array_get( 'link', $slide ), $img ) : $img;
					
					$output .= sprintf('<li>%s %s</li>',$slide, $text);
				}
			}
		}

		if ( $output ) {
			
			?>

				<div id="scroller<?php echo $prefix; ?>" class="scroller">
					<ul>
						<?php
								
							echo $output;
						
						?>
					</ul>
					<div class="beefy-fix"></div>
				</div>

		<?php

		} else {
			$this->do_defaults();
		}
	}

	function do_defaults(){

		echo setup_section_notify($this, __('Not enough images setup in slider. You need a minimum of 5 slides.', 'beefy'));

	}

	function section_opts() {

		$options = array();

		$how_to_use = __( '
		<strong>Read the instructions below before asking for additional help:</strong>
		</br></br>
		<strong>1.</strong> In Drag&Drop, drag the Beefy Slider section to a template of your choice.
		</br></br>
		<strong>2.</strong> Edit settings.
		</br></br>
		<strong>3.</strong> Setup each slide.
		</br></br>
		<strong>4.</strong> Hit "Publish" to see changes.
		</br></br>
		<strong>5.</strong> If the slider is stuck, then you do not have enough images setup. You need a minimum of 5 images.
		</br></br>
		<div class="row zmb">
				<div class="span6 tac zmb">
					<a class="btn btn-info" href="http://forum.accordy-slider.com/71-products-by-aleksander-hansson/" target="_blank" style="padding:4px 0 4px;width:100%"><i class="icon-ambulance"></i>          Forum</a>
				</div>
				<div class="span6 tac zmb">
					<a class="btn btn-info" href="http://betterdms.com" target="_blank" style="padding:4px 0 4px;width:100%"><i class="icon-align-justify"></i>          Better DMS</a>
				</div>
			</div>
			<div class="row zmb" style="margin-top:4px;">
				<div class="span12 tac zmb">
					<a class="btn btn-success" href="http://shop.ahansson.com" target="_blank" style="padding:4px 0 4px;width:100%"><i class="icon-shopping-cart" ></i>          My Shop</a>
				</div>
			</div>
		', 'beefy' );

		$options[] = array(
			'key' => 'beefy_help',
			'type'     => 'template',
			'template'      => do_shortcode( $how_to_use ),
			'title' =>__( 'How to use:', 'beefy' ) ,
		);

		$options[] = array(
			'key' => 'beefy_settings',
			'title' => __( 'Settings', 'beefy' ),
			'type'	=> 'multi',
			'opts'	=> array(

		        array(
		        	'key' => 'beefy_speed',
					'label' => __('Scrolling speed? (1 is fast, 10 is slow)', 'beefy'),
					'type' => 'select',
					'default' => '50000',
					'opts' => array(
						'10000'   => array( 'name' => __('1'	, 'beefy' )),
						'20000'   => array( 'name' => __('2'	, 'beefy' )),
						'30000'   => array( 'name' => __('3'	, 'beefy' )),
						'40000'   => array( 'name' => __('4'	, 'beefy' )),
						'50000'   => array( 'name' => __('5'	, 'beefy' )),
						'60000'   => array( 'name' => __('6'	, 'beefy' )),
						'70000'   => array( 'name' => __('7'	, 'beefy' )),
						'80000'   => array( 'name' => __('8'	, 'beefy' )),
						'90000'   => array( 'name' => __('9'	, 'beefy' )),
						'100000'   => array( 'name' => __('10'	, 'beefy' )),
					),
				),

				array(

					'key' => 'beefy_hover',
					'label' => __('Pause on hover? (Default: Yes)', 'beefy'),
					'type' => 'select',
					'default' => 'y',
					'opts' => array(
						'y'   => array( 'name' => __('Yes'	, 'beefy' )),
						'n'   => array( 'name' => __('No'	, 'beefy' )),
					),
				),

				array(
					'key' => 'beefy_direction',
					'label' => __('Direction?', 'beefy'),
					'type' => 'select',
					'opts' => array(
						'forward'   => array( 'name' => __('Right'	, 'beefy' )),
						'backwards'   => array( 'name' => __('Left'	, 'beefy' )),
					),
				),
				array(
					'key' => 'beefy_color_div',
					'type'     => 'color',
					'default' => '#076A95',
					'label'  =>  __('Pick text background color', 'beefy'),
	    	   	),
	    	   	array(
	    	   		'key' =>	'beefy_color_span',
	    			'type'              => 'color',
	    			'default' => '#ffffff',
	    	   		'label'  =>  __('Pick text color', 'beefy'),
	    	   	),
	    	   	array(
	    	   		'key' => 'beefy_img_height',
	    	    	'type'    =>  'text',
	    	    	'label'  =>  __('Choose the height for your images. For example: <strong>350px</strong>', 'beefy'),
	    	    ),
	    	    array(
	    	    	'key' => 'beefy_img_width',
	    	    	'type'    =>  'text',
	    	    	'label'  =>  __('Choose the width for your images. For example: <strong>400px</strong>', 'beefy'),
	    	    ),
		    )
		);

		$options[] = array(
			'key'		=> 'beefy_array',
	    	'type'		=> 'accordion',
			'title'		=> __('Slide Setup', 'beefy'),
			'post_type'	=> __('Slide', 'beefy'),
			'opts'	=> array(
				array(
					'key' 	=> 'image',
					'label' => __( 'Slide Image', 'beefy' ),
					'type'	=> 'image_upload'
				),
				array(
					'key' 	=> 'alt',
					'label'	=> __( 'Image ALT tag', 'beefy' ),
					'type'	=> 'text'
				),
				array(
					'key' 	=> 'link',
					'label'	=> __( 'Slide Link', 'beefy' ),
					'type'	=> 'text'
				),
				array(
					'key' 	=> 'text',
					'label'	=> __( 'Slide Text', 'beefy' ),
					'type'	=> 'text'
				),

			)
	    );

		return $options;
	}

}