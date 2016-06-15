<?php get_header(); 
global $wdwt_front,$wdwt_options;
$wdwt_front =  new best_magazine_front($wdwt_options);
//show_on_front ->latest posts
if( 'posts' == get_option( 'show_on_front' ) )
	$wdwt_front->top_posts();	

 ?>
</header>
<div class="container">
	<?php if ( is_active_sidebar( 'sidebar-1' ) ) { ?>
		<aside id="sidebar1" >
			<div class="sidebar-container">			
				<?php  dynamic_sidebar( 'sidebar-1' ); 	?>
				<div class="clear"></div>
			</div>
		</aside>
	<?php } ?>
	<div id="content">
		<?php
	//show_on_front ->latest posts
		if( 'posts' == get_option( 'show_on_front' ) ){
			$wdwt_front->category_tab();
			$wdwt_front->home_video_post();
			$wdwt_front->content_posts();
		}				
		elseif('page' == get_option( 'show_on_front' )){
		
			$wdwt_front->content_posts_for_home(); 
			}
		?>
		</div>
		<?php
	if ( is_active_sidebar( 'sidebar-2' ) ) { ?>
		<aside id="sidebar2">
			<div class="sidebar-container">
			  <?php  dynamic_sidebar( 'sidebar-2' ); 	?>
			  <div class="clear"></div>
			</div>
		</aside>
	<?php } ?>
	<div class="clear"></div>
</div>
<?php get_footer(); ?>

					
					