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
	V3: true
*/

/**
 * PageLines Beefy Section
 *
 * @package PageLines Framework
 * @author Aleksander Hansson
 */

class Beefy extends PageLinesSection {

	var $default_limit = 4;

	function section_styles(){

		wp_enqueue_script('jquery');

		wp_enqueue_script('pl-beefy-script', $this->base_url.'/js/jquery.simplyscroll.js');

	}


	function section_head() {

		$clone_id = $this->get_the_id();

		$prefix = ($clone_id != '') ? 'Clone_'.$clone_id : '';

		$speed = ($this->opt('beefy_speed', $this->oset)) ? ($this->opt('beefy_speed', $this->oset)) : '1';

		if ( $this->opt( 'beefy_direction', $this->oset ) == 'backwards') {
			$direction = 'backwards';
		} else {
			$direction = 'forwards';
		}

		if ( $this->opt( 'beefy_hover', $this->oset ) == 'n') {
			$hover = 'false';
		} else {
			$hover = 'true';
		}

		?>
			<script type="text/javascript">
				jQuery(document).ready(function($){
					$("#scroller<?php echo $prefix; ?>").simplyScroll({
						direction: '<?php echo $direction; ?>',
						speed: <?php echo $speed; ?>,
						pauseOnHover: <?php echo $hover; ?>
					});
				});
			</script>
		<?php

	}

	function section_template( ) {

		$clone_id = $this->get_the_id();

		$prefix = ($clone_id != '') ? 'Clone_'.$clone_id : '';

		$height = ($this->opt('beefy_img_height', $this->oset)) ? ($this->opt('beefy_img_height', $this->oset)) : '200px';

		$width = ($this->opt('beefy_img_width', $this->oset)) ? ($this->opt('beefy_img_width', $this->oset)) : 'auto';

		?>

				<ul id="scroller<?php echo $prefix; ?>" class="scroller" style="height:<?php echo $height; ?>;">

					<?php

						$slides = ($this->opt('beefy_slides', $this->oset)) ? $this->opt('beefy_slides', $this->oset) : $this->default_limit;

						$output = '';
						for($i = 1; $i <= $slides; $i++){

							if($this->opt('beefy_image_'.$i, $this->oset)){

								$the_text = $this->opt('beefy_text_'.$i, $this->tset);

								$img_alt = $this->opt('beefy_alt_'.$i,$this->tset);

								$div_style = sprintf('style="background-color:%s;"', $this->opt('beefy_color_div', $this->oset) ? $this->opt('beefy_color_div', $this->oset) : '#223a5f');

								$span_style = sprintf('style="color:%s;"', $this->opt('beefy_color_span', $this->oset) ? $this->opt('beefy_color_span', $this->oset) : '#ffffff');

								$text = ($the_text) ? sprintf('<div %s><span data-sync="beefy_text_%s" %s>%s</span></div>', $div_style, $i, $span_style, $the_text) : '';

								$img = sprintf('<img data-sync="beefy_image_%s" src="%s" alt="%s" style="height:%s; width:%s;"/>', $i, $this->opt( 'beefy_image_'.$i, $this->tset ),$img_alt, $height, $width );

								$slide = ($this->opt('beefy_link_'.$i, $this->oset)) ? sprintf('<a href="%s">%s</a>', $this->opt('beefy_link_'.$i, $this->oset), $img ) : $img;
								$output .= sprintf('<li>%s %s</li>',$slide, $text);
							}
						}

						if($output == ''){
							$this->do_defaults();
						} else {
							echo $output;
						}

					?>

				</ul>

		<?php
	}

	function do_defaults(){

		$color = ( $this->opt( 'beefy_color_span', $this->oset ) ? $this->opt( 'beefy_color_span', $this->oset ) : '#ffffff');

		$backgroundcolor = ( $this->opt('beefy_color_div', $this->oset ) ? $this->opt( 'beefy_color_div', $this->oset ) : '#223a5f');

		printf('<li><img src="%s" style="%s" /><div style="%s"><span style="%s"><strong>%s</strong></span></div></li>',
			$this->base_url.'/img/1.png',
			'height:200px; width:290px;',
			sprintf('background-color:%s;', $backgroundcolor),
			sprintf('color:%s;', $color),
			'This is the first image'
		);
		printf('<li><img src="%s" style="%s" /><div style="%s"><span style="%s"><strong>%s</strong></span></div></li>',
			$this->base_url.'/img/2.png',
			'height:200px; width:290px;',
			sprintf('background-color:%s;', $backgroundcolor),
			sprintf('color:%s;', $color),
			'This is the second image'
		);
		printf('<li><img src="%s" style="%s" /><div style="%s"><span style="%s"><strong>%s</strong></span></div></li>',
			$this->base_url.'/img/3.png',
			'height:200px; width:290px;',
			sprintf('background-color:%s;', $backgroundcolor),
			sprintf('color:%s;', $color),
			'This is the third image'
		);
		printf('<li><img src="%s" style="%s" /><div style="%s"><span style="%s"><strong>%s</strong></span></div></li>',
			$this->base_url.'/img/4.png',
			'height:200px; width:290px;',
			sprintf('background-color:%s;', $backgroundcolor),
			sprintf('color:%s;', $color),
			'This is the fourth image'
		);
		printf('<li><img src="%s" style="%s" /><div style="%s"><span style="%s"><strong>%s</strong></span></div></li>',
			$this->base_url.'/img/5.png',
			'height:200px; width:290px;',
			sprintf('background-color:%s;', $backgroundcolor),
			sprintf('color:%s;', $color),
			'This is the fifth image'
		);
		printf('<li><img src="%s" style="%s" /><div style="%s"><span style="%s"><strong>%s</strong></span></div></li>',
			$this->base_url.'/img/6.png',
			'height:200px; width:290px;',
			sprintf('background-color:%s;', $backgroundcolor),
			sprintf('color:%s;', $color),
			'This is the sixth image'
		);
		printf('<li><img src="%s" style="%s" /><div style="%s"><span style="%s"><strong>%s</strong></span></div></li>',
			$this->base_url.'/img/7.png',
			'height:200px; width:290px;',
			sprintf('background-color:%s;', $backgroundcolor),
			sprintf('color:%s;', $color),
			'This is the seventh image'
		);
		printf('<li><img src="%s" style="%s" /><div style="%s"><span style="%s"><strong>%s</strong></span></div></li>',
			$this->base_url.'/img/8.png',
			'height:200px; width:290px;',
			sprintf('background-color:%s;', $backgroundcolor),
			sprintf('color:%s;', $color),
			'This is the eighth image'
		);
	}

	function section_opts() {

		$options = array();

		$options[] = array(

			'title' => __( 'Settings', 'beefy' ),
			'type'	=> 'multi',
			'opts'	=> array(
				array(
		            'key'           => 'beefy_slides',
		            'type'          => 'count_select',
		            'label'			=> __( 'Number of Images to configure', 'beefy' ),
		            'count_start'   => 4,               // Starting Count Number
		            'count_number'  => 20,            // Ending Count Number
		            'help'			=> __('This number will be used to generate slides and option setup. (default is 4)', 'beefy' ),
		        ),

		        array(
		        	'key' => 'beefy_speed',
					'label' => __('Scrolling speed? (1 is slow, 5 is fast)', 'beefy'),
					'type' => 'select',
					'default' => '1',
					'selectvalues' => array(
						'1'   => array( 'name' => __('1'	, 'beefy' )),
						'2'   => array( 'name' => __('2'	, 'beefy' )),
						'3'   => array( 'name' => __('3'	, 'beefy' )),
						'4'   => array( 'name' => __('4'	, 'beefy' )),
						'5'   => array( 'name' => __('5'	, 'beefy' )),
					),
				),

				array(

					'key' => 'beefy_hover',
					'label' => __('Pause on hover? (Default: Yes)', 'beefy'),
					'type' => 'select',
					'selectvalues' => array(
						'y'   => array( 'name' => __('Yes'	, 'beefy' )),
						'n'   => array( 'name' => __('No'	, 'beefy' )),
					),
				),

				array(
					'key' => 'beefy_direction',
					'label' => __('Direction?', 'beefy'),
					'type' => 'select',
					'selectvalues' => array(
						'forward'   => array( 'name' => __('Forward'	, 'beefy' )),
						'backwards'   => array( 'name' => __('Backwards'	, 'beefy' )),
					),
				),
		    )
		);

		$options[] = array(
			'type'     => 'multi',
			'title'     =>  __('Styling options', 'beefy'),
			'opts'   => array(
				array(
					'key' => 'beefy_color_div',
					'type'              => 'color',
					'label'  =>  __('Pick text background color', 'beefy'),
	    	   	),
	    	   	array(
	    	   		'key' =>	'beefy_color_span',
	    			'type'              => 'color',
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
			),
		);

		$beefs = ( $this->opt( 'beefy_slides', $this->oset ) ) ? $this->opt( 'beefy_slides', $this->oset ) : '4' ;

		for ( $i = 1; $i <= $beefs; $i++ ) {

			$options[] = array(
					'type' 			=> 'multi',
					'opts' => array(
						array(
							'key' => 'beefy_image_'.$i,
							'label' 	=> __( 'Slide Image', 'beefy' ),
							'type'			=> 'image_upload'
						),
						array(
							'key' => 'beefy_alt_'.$i,
							'label'	=> __( 'Image ALT tag', 'beefy' ),
							'type'			=> 'text'
						),
						array(
							'key' => 'beefy_link_'.$i,
							'label'	=> __( 'Slide Link', 'beefy' ),
							'type'			=> 'text'
						),
						array(
							'key' => 'beefy_text_'.$i,
							'label'	=> __( 'Slide Text', 'beefy' ),
							'type'			=> 'text'
						),
					),
					'title' 		=> __( 'Beefy Slide ', 'beefy' ) . $i,
				);

		}

		return $options;
	}

	function section_optionator( $settings ){
		$settings = wp_parse_args( $settings, $this->optionator_default );

			$array = array();

			$array['beefy_settings']  = array(
				'title'   => __( 'Settings', 'beefy' ),
				'inputlabel' => __('How fast should Beefy scroll through images? (1 is slow, 5 is fast)', 'beefy'),
				'type' => 'multi_option',
				'selectvalues' => array(

					'beefy_slides' => array(
						'type' 			=> 'count_select',
						'count_start'	=> 4,
						'count_number'	=> 20,
						'default'		=> '4',
						'inputlabel' 	=> __( 'Number of Images to Configure', 'beefy' ),
						'exp' 			=> __( "This number will be used to generate slides and option setup. (default is 4)", 'beefy' ),

					),

					'beefy_speed'  => array(
						'inputlabel' => __('Scrolling speed? (1 is slow, 5 is fast)', 'beefy'),
						'type' => 'select',
						'default' => '1',
						'selectvalues' => array(
							'1'   => array( 'name' => __('1'	, 'beefy' )),
							'2'   => array( 'name' => __('2'	, 'beefy' )),
							'3'   => array( 'name' => __('3'	, 'beefy' )),
							'4'   => array( 'name' => __('4'	, 'beefy' )),
							'5'   => array( 'name' => __('5'	, 'beefy' )),
						),
					),

					'beefy_hover'  => array(
						'inputlabel' => __('Pause on hover? (Default: Yes)', 'beefy'),
						'type' => 'select',
						'selectvalues' => array(
							'y'   => array( 'name' => __('Yes'	, 'beefy' )),
							'n'   => array( 'name' => __('No'	, 'beefy' )),
						),
					),

					'beefy_direction'  => array(
						'inputlabel' => __('Direction?', 'beefy'),
						'type' => 'select',
						'selectvalues' => array(
							'forward'   => array( 'name' => __('Forward'	, 'beefy' )),
							'backwards'   => array( 'name' => __('Backwards'	, 'beefy' )),
						),
					),
				),
			);

			$array['beefy_colors'] = array(
				'type'     => 'multi_option',
				'title'     =>  __('Styling options', 'beefy'),
				'selectvalues'   => array(
					'beefy_color_div' => array(
						'type'              => 'colorpicker',
						'inputlabel'  =>  __('Pick text background color', 'beefy'),
	    		   	),
	    		   	'beefy_color_span' => array(
	    				'type'              => 'colorpicker',
	    		   		'inputlabel'  =>  __('Pick text color', 'beefy'),
	    		   	),
	    		   	'beefy_img_height' =>  array(
	    		    	'type'    =>  'text',
	    		    	'inputlabel'  =>  __('Choose the height for your images. For example: <strong>350px</strong>', 'beefy'),
	    		    ),
	    		    'beefy_img_width' =>  array(
	    		    	'type'    =>  'text',
	    		    	'inputlabel'  =>  __('Choose the width for your images. For example: <strong>400px</strong>', 'beefy'),
	    		    ),
				),
			);

			global $post_ID;

			$oset = array('post_id' => $post_ID, 'clone_id' => $settings['clone_id'], 'type' => $settings['type']);

			$slides = ($this->opt('beefy_slides', $oset)) ? $this->opt('beefy_slides', $oset) : $this->default_limit;

			for($i = 1; $i <= $slides; $i++){

				$array['beefy_slide_'.$i] = array(
					'type' 			=> 'multi_option',
					'selectvalues' => array(
						'beefy_image_'.$i 	=> array(
							'inputlabel' 	=> __( 'Slide Image', 'beefy' ),
							'type'			=> 'image_upload'
						),
						'beefy_alt_'.$i 	=> array(
							'inputlabel'	=> __( 'Image ALT tag', 'beefy' ),
							'type'			=> 'text'
						),
						'beefy_link_'.$i 	=> array(
							'inputlabel'	=> __( 'Slide Link', 'beefy' ),
							'type'			=> 'text'
						),
						'beefy_text_'.$i 	=> array(
							'inputlabel'	=> __( 'Slide Text', 'beefy' ),
							'type'			=> 'text'
						),
					),
					'title' 		=> __( 'Beefy Slide ', 'beefy' ) . $i,
				);

			}

			$metatab_settings = array(
				'id' 		=> 'beefy_options',
				'name' 		=> 'beefy',
				'icon' 		=> $this->icon,
				'clone_id'	=> $settings['clone_id'],
				'active'	=> $settings['active']
			);

			register_metatab( $metatab_settings, $array );

	}

}