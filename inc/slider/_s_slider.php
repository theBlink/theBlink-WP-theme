<?php

// Enqueue Flexslider Files

	// function blink_slider_scripts() {
	// 	wp_enqueue_script( 'jquery' );
	
	// 	wp_enqueue_style( 'flex-style', get_template_directory_uri() . '/inc/slider/css/flexslider.css' );
	
	// 	wp_enqueue_script( 'flex-script', get_template_directory_uri() .  '/inc/slider/js/jquery.flexslider-min.js', array( 'jquery' ), true );
	// }
	
	// add_action( 'wp_enqueue_scripts', 'blink_slider_scripts' );

	/**
	 * Custom Image Sizes
	 */
	
	add_image_size( 'slider', 1300, 500, true );

// Initialize Slider
	
	function blink_slider_initialize() { ?>
		<script type="text/javascript" charset="utf-8">
			jQuery(window).load(function() {
			  jQuery('#header-slideshow .flexslider').flexslider({
			    animation: "fade",
			    direction: "horizontal",
			    slideshow: true,
		    	slideshowSpeed: 7000,
		    	animationSpeed: 600,
		    	// Primary Controls
					controlNav: true,          //Boolean: Create navigation for paging control of each slide? Note: Leave true for manualControls usage
					directionNav: true,        //Boolean: Create navigation for previous/next navigation? (true/false)
					prevText: "Previous",      //String: Set the text for the "previous" directionNav item
					nextText: "Next",
					useCSS: true,              //{NEW} Boolean: Slider will use CSS3 transitions if available
					touch: true
			  });
			});
		</script>
		<script type="text/javascript" charset="utf-8">
			jQuery(window).load(function() {
			  jQuery('#portfolio-slider').flexslider({
			    animation: "fade",
			    direction: "horizontal",
			    slideshow: true,
		    	slideshowSpeed: 7000,
		    	animationSpeed: 600,
		    	// Primary Controls
					controlNav: false,          //Boolean: Create navigation for paging control of each clide? Note: Leave true for manualControls usage
					directionNav: true,        //Boolean: Create navigation for previous/next navigation? (true/false)
					prevText: "Previous",      //String: Set the text for the "previous" directionNav item
					nextText: "Next",
					useCSS: true,              //{NEW} Boolean: Slider will use CSS3 transitions if available
					touch: false
			  });
			});
		</script>
	<?php }	

	add_action( 'wp_head', 'blink_slider_initialize' );

// Create Slider - "Homepage"
	
	function blink_slider_template_homepage() {
		
		// Query Arguments
		$args = array(
					'post_type' => 'slider',
					'posts_per_page'	=> 5,
					'position' => 'homepage'
				);	
		
		// The Query
		$the_query = new WP_Query( $args );
		
		// Check if the Query returns any posts
		if ( $the_query->have_posts() ) {
		
		// Start the Slider ?>
		<div id="main-slider" class="flexslider">
			<ul class="slides">
			
				<?php		
				// The Loop
				$counter=1;
				while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
					<li>
					
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

// Create Slider - "Portfolio"
	
	function blink_slider_template_portfolio() {
		
		// Query Arguments
		$args = array(
					'post_type' => 'slider',
					'posts_per_page'	=> 5,
					'position' => 'portfolio'
				);	
		
		// The Query
		$the_query = new WP_Query( $args );
		
		// Check if the Query returns any posts
		if ( $the_query->have_posts() ) {
		
		// Start the Slider ?>
		<div id="portfolio-slider" class="flexslider">
			<ul class="slides">
			
				<?php		
				// The Loop
				$counter=1;
				while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
					<li>
					
						<?php // Check if there's a Slide URL given and if so let's a link to it
						if ( get_post_meta( get_the_id(), 'blink_slideurl', true) != '' ) { ?>
							<a href="<?php echo esc_url( get_post_meta( get_the_id(), 'blink_slideurl', true ) ); ?>">
						<?php }
											
						// The Slide's Image
						echo the_post_thumbnail('slider-portfolio');
						   
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