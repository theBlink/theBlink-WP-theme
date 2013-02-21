<?php

// Enqueue Flexslider Files

	function blink_slider_scripts() {
		wp_enqueue_script( 'jquery' );
	
		wp_enqueue_style( 'flex-style', get_template_directory_uri() . '/inc/slider/css/flexslider.css' );
	
		wp_enqueue_script( 'flex-script', get_template_directory_uri() .  '/inc/slider/js/jquery.flexslider-min.js', array( 'jquery' ), true );
	}
	add_action( 'wp_enqueue_scripts', 'blink_slider_scripts' );


// Initialize Slider
	
	function blink_slider_initialize() { ?>
		<script type="text/javascript" charset="utf-8">
			jQuery(window).load(function() {
			  jQuery('.flexslider').flexslider({
			    animation: "fade",
			    direction: "horizontal",
			    slideshow: true,
		    	slideshowSpeed: 7000,
		    	animationSpeed: 600,
		    	// Primary Controls
					controlNav: true,          //Boolean: Create navigation for paging control of each clide? Note: Leave true for manualControls usage
					directionNav: true,        //Boolean: Create navigation for previous/next navigation? (true/false)
					prevText: "Previous",      //String: Set the text for the "previous" directionNav item
					nextText: "Next",
					useCSS: true,              //{NEW} Boolean: Slider will use CSS3 transitions if available
					touch: true
			  });
			});
		</script>
	<?php }
	add_action( 'wp_head', 'blink_slider_initialize' );
	
	
// Create Slider
	
	function blink_slider_template() {
		
		// Query Arguments
		$args = array(
					'post_type' => 'slides',
					'posts_per_page'	=> 5
				);	
		
		// The Query
		$the_query = new WP_Query( $args );
		
		// Check if the Query returns any posts
		if ( $the_query->have_posts() ) {
		
		// Start the Slider ?>
		<div class="flexslider">
			<ul class="slides">
			
				<?php		
				// The Loop
				$counter=1;
				while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
					<li style="width: 100%; float: left; margin-right: -100%; position: relative;">
					
						<?php // Check if there's a Slide URL given and if so let's a link to it
						if ( get_post_meta( get_the_id(), 'blink_slideurl', true) != '' ) { ?>
							<a href="<?php echo esc_url( get_post_meta( get_the_id(), 'blink_slideurl', true ) ); ?>">
						<?php }
											
						// The Slide's Image
						echo the_post_thumbnail('slider');
						   
						// Close off the Slide's Link if there is one
						if ( get_post_meta( get_the_id(), 'blink_slideurl', true) != '' ) { ?>
							</a>
						<?php } ?>
						<?php // Check if there's a Caption given and if so let's a link to it
						//$caption = get_post_meta(get_the_id(), 'blink_slidecaption', true);
						// check if the custum field has a value
						//if($caption != '') {
						//  echo '<div class="caption">' . $caption . '</div>';
						//} ?>
						
							<?php // Insert the content from the Slider CPT ?>
							<div class="slider-content slide-<?php echo $counter; ?>">
								<div class="slider-content-inner">
									<h2 class="titolo-slide"><?php the_title();?></h2>
									<div class="contenuto-slide"><?php the_content(); ?></div>
								</div>
							</div> <!-- end .slider-content -->
					
				  </li>
				<?php $counter++; ?>
				<?php endwhile; ?>
				
		
			</ul><!-- .slides -->
		</div><!-- .flexslider -->
		
		<?php }
		
		// Reset Post Data
		wp_reset_postdata();
	}

// Slider Shortcode

	function blink_slider_shortcode() {
		ob_start();
		blink_slider_template();
		$slider = ob_get_clean();
		return $slider;
	}
	add_shortcode( 'slider', 'blink_slider_shortcode' );