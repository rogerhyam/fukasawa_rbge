<?php get_header(); ?>

<div class="content thin">
											        
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		
		<div id="post-<?php the_ID(); ?>" <?php post_class('single'); ?>>
		
			<?php $post_format = get_post_format(); ?>
			
			<?php if ( $post_format == 'video' ) : ?>
			
				<?php if ($pos=strpos($post->post_content, '<!--more-->')): ?>
		
					<div class="featured-media">
					
						<?php
								
							// Fetch post content
							$content = get_post_field( 'post_content', get_the_ID() );
							
							// Get content parts
							$content_parts = get_extended( $content );
							
							// oEmbed part before <!--more--> tag
							$embed_code = wp_oembed_get($content_parts['main']); 
							
							echo $embed_code;
						
						?>
					
					</div> <!-- /featured-media -->
				
				<?php endif; ?>
				
			<?php elseif ( $post_format == 'gallery' ) : ?>
			
				<div class="featured-media">	
	
					<?php fukasawa_flexslider('post-image'); ?>
					
					<div class="clear"></div>
					
				</div> <!-- /featured-media -->
							
			<?php else: ?>
				<div class="featured-media rbge-cat-brand">
				    <?php
				    
				    // RDH - remove big header image from single posts
                    // the_post_thumbnail('post-image');
				    
				    // add in brandable components
				    
				    foreach(get_the_category() as $cat){
				        echo '<div class="category-'.$cat->slug.'">';
				        echo '<a href="/archives/category/'.$cat->slug.'" >';
				        echo "<h3>$cat->name</h3>";
				        echo "<p>$cat->description</p>";
				        echo '</a>';
				        echo '</div>';
				    }

				    ?>
				    
					<?php 
					    
					?>
				</div> <!-- /featured-media -->
					
			<?php endif; ?>
			
			<div class="post-inner">
				
				<div class="post-header">
													
					<h1 class="post-title"><?php the_title(); ?></h1>
															
				</div> <!-- /post-header -->
				    
			    <div class="post-content">
			    
			    	<?php 
						if ($post_format == 'video') { 
							$content = $content_parts['extended'];
							$content = apply_filters('the_content', $content);
							echo $content;
						} else {
							the_content();
						}
					?>
			    
			    </div> <!-- /post-content -->
			    
			    <div class="clear"></div>
				
				<div class="post-meta-bottom">
				
					<?php 
				    	$args = array(
							'before'           => '<div class="clear"></div><p class="page-links"><span class="title">' . __( 'Pages:','fukasawa' ) . '</span>',
							'after'            => '</p>',
							'link_before'      => '<span>',
							'link_after'       => '</span>',
							'separator'        => '',
							'pagelink'         => '%',
							'echo'             => 1
						);
			    	
			    		wp_link_pages($args); 
					?>
				
					<ul>
						<li class="post-date">Posted by <?php the_author_posts_link(); ?> on <?php the_date(get_option('date_format')); ?></li>
						<?php if (has_category()) : ?>
							<li class="post-categories"><?php _e('Categories:','fukasawa'); ?> <?php the_category(', '); ?></li>
						<?php endif; ?>
						<?php if (has_tag()) : ?>
							<li class="post-tags">Tags: <?php the_tags('', ' '); ?></li>
						<?php endif; ?>
						<?php edit_post_link('Edit post', '<li>', '</li>'); ?>
					</ul>
					
					<div class="clear"></div>
					
				</div> <!-- /post-meta-bottom -->
			
			</div> <!-- /post-inner -->
			
			<?php
				$prev_post = get_previous_post();
				$next_post = get_next_post();
			?>
			
			<div class="post-navigation">
			
				<?php
				if (!empty( $prev_post )): ?>
				
					<a class="post-nav-prev" title="<?php _e('Previous post', 'fukasawa'); echo ': ' . esc_attr( get_the_title($prev_post) ); ?>" href="<?php echo get_permalink( $prev_post->ID ); ?>">
						<p>&larr; <?php _e('Previous post', 'fukasawa'); ?></p>
					</a>
				<?php endif; ?>
				
				<?php
				if (!empty( $next_post )): ?>
					
					<a class="post-nav-next" title="<?php _e('Next post', 'fukasawa'); echo ': ' . esc_attr( get_the_title($next_post) ); ?>" href="<?php echo get_permalink( $next_post->ID ); ?>">					
						<p><?php _e('Next post', 'fukasawa'); ?> &rarr;</p>
					</a>
			
				<?php endif; ?>
				
				<div class="clear"></div>
			
			</div> <!-- /post-navigation -->
								
			<?php comments_template( '', true ); ?>
		
		</div> <!-- /post -->
									                        
   	<?php endwhile; else: ?>

		<p><?php _e("We couldn't find any posts that matched your query. Please try again.", "fukasawa"); ?></p>
	
	<?php endif; ?>    

</div> <!-- /content -->
		
<?php get_footer(); ?>