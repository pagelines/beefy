<?php
/*
	Section: Beefy Slider
	Author: Aleksander Hansson
	Author URI: http://ahansson.com
	Demo: http://beefy.ahansson.com
	Version: 1.0
	Description: Beefy Slider is a great slider to show images on your site. Beefy Slider is beautifully responsive, comes with color control and supports up to 20 images of your choice. Sounds tasty? Buy Beefy ;)
	Class Name: PageLinesBeefy
	Workswith: main
*/

/**
 * PageLines Beefy Section
 *
 * @package PageLines Framework
 * @author Aleksander Hansson
 */



class PageLinesBeefy extends PageLinesSection {

/*

function section_persistent(){

	add_filter( 'pless_vars', 'pl_counter_less');

	function pl_beefy_less( $constants ){
		
		$countdown_background_color = (ploption('countdown-background-color')) ? ploption('countdown-background-color') : '#1568AD';
		$countdown_label_color = (ploption('countdown-label-color')) ? ploption('countdown-label-color') : '#000000';
		$countdown_text_color = (ploption('countdown-text-color')) ? ploption('countdown-text-color') : '#ffffff';
	
	
		$newvars = array(
		
			'countdownbackgroundcolor' => $countdown_background_color ,
			'countdownlabelcolor' => $countdown_label_color ,
			'countdowntextcolor' => $countdown_text_color
	
		);
	
		$lessvars = array_merge($newvars, $constants);
		return $lessvars;
	}

}
*/

	var $default_limit = 4;
	
	function section_styles(){
				
		wp_enqueue_script('jquery');
		
		wp_enqueue_script('pl-beefy-script', $this->base_url.'/js/jQuery.beefSlider.js');

	}
	
	function section_head( $clone_id ) {
	
	$prefix = ($clone_id != '') ? '.clone_'.$clone_id : '';
	
	?>
		<script type="text/javascript">
			jQuery(document).ready(function($){
				jQuery('.beefSlider').beefSlider(
					function()
					{
						jQuery(this).find('div').fadeIn(100);
					},
					function()
					{
						jQuery(this).find('div').fadeOut(100);
					}
				);
			})
		</script>
	<?php
	
	}

	function section_template( $clone_id ) {
				
		$div_style = sprintf('style="height:%s;"', (ploption('beefy_img_height', $this->oset)) ? (ploption('beefy_img_height', $this->oset)) : '300px');
				
		?>
		<div class="beefSlider" <?php echo $div_style;?> >
			<div class="beefSliderInner">	
				<ul>	
					<?php
					
					$slides = (ploption('beefy_slides', $this->oset)) ? ploption('beefy_slides', $this->oset) : $this->default_limit;
					
					$output = '';
					for($i = 1; $i <= $slides; $i++){
					
						if(ploption('beefy_image_'.$i, $this->oset)){
							
							$the_text = ploption('beefy_text_'.$i, $this->tset);
			
							$img_alt = ploption('beefy_alt_'.$i,$this->tset);
							
							$img_style = sprintf('style="height:%s; width:%s;"', ploption('beefy_img_height', $this->oset) ? ploption('beefy_img_height', $this->oset) : '300px' , ploption('beefy_img_width', $this->oset) ? ploption('beefy_img_width', $this->oset) : '400px' );
											
							$div_style = sprintf('style="background-color:%s;"', ploption('beefy_color_div', $this->oset) ? ploption('beefy_color_div', $this->oset) : '');
							$span_style = sprintf('style="color:%s;"', ploption('beefy_color_span', $this->oset) ? ploption('beefy_color_span', $this->oset) : '');
									
							$text = ($the_text) ? sprintf('<div %s><span %s>%s</span></div>', $div_style, $span_style, $the_text) : '';
							
							$img = sprintf('<img src="%s" alt="%s" %s/>', ploption( 'beefy_image_'.$i, $this->tset ),$img_alt, $img_style );
							
							$slide = (ploption('beefy_link_'.$i, $this->oset)) ? sprintf('<a href="%s">%s</a>', ploption('beefy_link_'.$i, $this->oset), $img ) : $img;						
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
			</div>
		</div>
						
	<?php }
	
	function do_defaults(){
		
		printf('<li><img src="%s" style="%s" /><div style="%s"><span style="%s"><strong>%s</strong></span></div></li>', 
			$this->base_url.'/img/1.png', 
			'height:350px; width:400px;',
			'background-color:#223a5f;',
			'color:#ffffff;',
			'This is the first image'
		);
		printf('<li><img src="%s" style="%s" /><div style="%s"><span style="%s"><strong>%s</strong></span></div></li>', 
			$this->base_url.'/img/2.png', 
			'height:350px; width:400px;',
			'background-color:#223a5f;',
			'color:#ffffff;',
			'This is the second image'
		);
		printf('<li><img src="%s" style="%s" /><div style="%s"><span style="%s"><strong>%s</strong></span></div></li>', 
			$this->base_url.'/img/3.png', 
			'height:350px; width:400px;',
			'background-color:#223a5f;',
			'color:#ffffff;',
			'This is the third image'
		);
		printf('<li><img src="%s" style="%s" /><div style="%s"><span style="%s"><strong>%s</strong></span></div></li>', 
			$this->base_url.'/img/4.png', 
			'height:350px; width:400px;',
			'background-color:#223a5f;',
			'color:#ffffff;',
			'This is the fourth image'
		);
		printf('<li><img src="%s" style="%s" /><div style="%s"><span style="%s"><strong>%s</strong></span></div></li>', 
			$this->base_url.'/img/5.png', 
			'height:350px; width:400px;',
			'background-color:#223a5f;',
			'color:#ffffff;',
			'This is the fifth image'
		);
		printf('<li><img src="%s" style="%s" /><div style="%s"><span style="%s"><strong>%s</strong></span></div></li>', 
			$this->base_url.'/img/6.png', 
			'height:350px; width:400px;',
			'background-color:#223a5f;',
			'color:#ffffff;',
			'This is the sixth image'
		);
		printf('<li><img src="%s" style="%s" /><div style="%s"><span style="%s"><strong>%s</strong></span></div></li>', 
			$this->base_url.'/img/7.png', 
			'height:350px; width:400px;',
			'background-color:#223a5f;',
			'color:#ffffff;',
			'This is the seventh image'
		);
		printf('<li><img src="%s" style="%s" /><div style="%s"><span style="%s"><strong>%s</strong></span></div></li>', 
			$this->base_url.'/img/8.png', 
			'height:350px; width:400px;',
			'background-color:#223a5f;',
			'color:#ffffff;',
			'This is the eighth image'
		);
	}
	
	function section_optionator( $settings ){
		$settings = wp_parse_args( $settings, $this->optionator_default );
		
			$array = array(); 
			
			$array['beefy_slides'] = array(
				'type' 			=> 'count_select',
				'count_start'	=> 4, 
				'count_num'		=> 20,
				'default'		=> '4',
				'inputlabel' 	=> __( 'Number of Images to Configure', 'pagelines' ),
				'title' 		=> __( 'Number of images', 'pagelines' ),
				'shortexp' 		=> __( 'Enter the number of Beefy slides. <strong>Minimum is 4</strong>', 'pagelines' ),
				'exp' 			=> __( "This number will be used to generate slides and option setup.", 'pagelines' ),
		
			);
			
				$array['beefy_colors'] = array(
					'type'     => 'color_multi',
					'title'     =>  __('Styling options', 'pagelines'),
					'selectvalues'   => array(
						'beefy_color_div' => array(
							'default'          => '',
							'type'              => 'color_picker',
							'inputlabel'  =>  __('Pick text background color', 'pagelines'),
	    		    	),
	    		    	'beefy_color_span' => array(
	    		    		'default'          => '',
	    					'type'              => 'color_picker',
	    		    		'inputlabel'  =>  __('Pick text color', 'pagelines'),
	    		    	),
				    ),
				);
				
				$array['beefy_dimensions'] = array(
					'type'     => 'multi_option',
					'title'     =>  __('Styling options', 'pagelines'),
					'selectvalues'   => array(
	    		    	'beefy_img_height' =>  array(
	    		    		'default'   =>  '',
	    		    		'type'    =>  'text',
	    		    		'inputlabel'  =>  __('Choose the height for your images. For example: <strong>350px</strong>', 'pagelines'),
	    		    	),
	    		    	'beefy_img_width' =>  array(
	    		    		'default'   =>  '',
	    		    		'type'    =>  'text',
	    		    		'inputlabel'  =>  __('Choose the width for your images. For example: <strong>400px</strong>', 'pagelines'),
	    		    	),
				    ),
				);
			
			global $post_ID;
			
			$oset = array('post_id' => $post_ID, 'clone_id' => $settings['clone_id'], 'type' => $settings['type']);
			
			$slides = (ploption('beefy_slides', $oset)) ? ploption('beefy_slides', $oset) : $this->default_limit;
			
			for($i = 1; $i <= $slides; $i++){
				
				
				$array['beefy_slide_'.$i] = array(
					'type' 			=> 'multi_option',
					'selectvalues' => array(
						'beefy_image_'.$i 	=> array(
							'inputlabel' 	=> __( 'Slide Image', 'pagelines' ), 
							'type'			=> 'image_upload'
						),
						'beefy_alt_'.$i 	=> array(
							'inputlabel'	=> __( 'Image ALT tag', 'pagelines' ), 
							'type'			=> 'text'
						),	
						'beefy_link_'.$i 	=> array(
							'inputlabel'	=> __( 'Slide Link', 'pagelines' ), 
							'type'			=> 'text'
						),
						'beefy_text_'.$i 	=> array(
							'inputlabel'	=> __( 'Slide Text', 'pagelines' ), 
							'type'			=> 'text'
						),	
					),
					'title' 		=> __( 'Beefy Slide ', 'pagelines' ) . $i,
					'shortexp' 		=> __( 'Setup options for slide number ', 'pagelines' ) . $i,
					'exp'			=> __( 'For best results all images in the slider should have the same dimensions.', 'pagelines')
				);
				
			}
				
			

			$metatab_settings = array(
					'id' 		=> 'beefy_options',
					'name' 		=> __( 'Beefy', 'pagelines' ),
					'icon' 		=> $this->icon, 
					'clone_id'	=> $settings['clone_id'], 
					'active'	=> $settings['active']
				);

			register_metatab( $metatab_settings, $array );

	}

}