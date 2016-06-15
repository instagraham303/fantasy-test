<?php


require_once( 'WDWT_front_functions.php');

class Best_magazine_frontend_functions extends WDWT_front_functions{

  public static function posted_on() {
    printf('<span class="sep date"></span><a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s">%4$s</time></a>',
      esc_url( get_permalink() ),
      esc_attr( get_the_time() ),
      esc_attr( get_the_date( 'c' ) ),
      esc_html( get_the_date() )
    );
  } 

  public static function posted_on_single() {
    printf('<span class="sep date"></span><a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s">%4$s</time></a><span class="by-author"> <span class="sep author"></span> <span class="author vcard"><a class="url fn n" href="%5$s" title="%6$s" rel="author">%7$s</a></span></span>',
      esc_url( get_permalink() ),
      esc_attr( get_the_time() ),
      esc_attr( get_the_date( 'c' ) ),
      esc_html( get_the_date() ),
      esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
      esc_attr( sprintf( __( 'View all posts by %s', "best-magazine" ), get_the_author() ) ),
      get_the_author()
    );
  }
 
  public static function entry_meta_cat() {
		$categories_list = get_the_category_list(', ' );
		echo '<div class="entry-meta-cat">';
		if ( $categories_list ) {
			echo '<span class="categories-links"><span class="sep category"></span> ' . $categories_list . '</span>';
		}
		$tag_list = get_the_tag_list( '', ' , ' );
		if ( $tag_list ) {
			echo '<span class="tags-links"><span class="sep tag"></span>' . $tag_list . '</span>';
		}
		echo '</div>';
	}




public static function entry_meta() {
  $categories_list = get_the_category_list(', ' );
  echo '<div class="entry-meta-cat">';
  if ( $categories_list ) {
    echo '<span class="categories-links"><span class="sep category"></span> ' . $categories_list . '</span>';
  }
  $tag_list = get_the_tag_list( '', ' , ' );
  if ( $tag_list ) {
    echo '<span class="tags-links"><span class="sep tag"></span>' . $tag_list . '</span>';
  }
  echo '</div>';
}

public static  function post_nav() {
    global $post;
    $previous = ( is_attachment() ) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
    $next    = get_adjacent_post( false, '', false );

    if ( ! $next && ! $previous )
      return;
    ?>
      <nav class="page-navigation">
        <?php previous_post_link( '%link', '<span class="meta-nav">&larr;</span> %title' ); ?> 
        <?php next_post_link( '%link',  '%title <span class="meta-nav">&rarr;</span>'  ); ?>
      </nav>
    <?php
  }

public static function posts_nav($wp_query) {
    
    ?>
      <nav class="page-navigation">
      <div class="nav-back" style="float:left;">
        <?php next_posts_link( _x('Older entries', '', "best-magazine" ), $wp_query->max_num_pages ); ?> 
        
      </div>
      <div class="nav-forward" style="float:right;">  
        
        <?php previous_posts_link( _x('Newer entries', '', "best-magazine" ) ); ?>
      </div>
      </nav>
    <?php
  }


  




}



