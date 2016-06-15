<?php

class WDWT_front_functions{

  public function __construct(){

  }

 /**
  *   @return url of first image in the post content, or empty string if has no image
  */

  public static function post_image_url(){

    $thumb_url = self::catch_that_image();
    if(isset( $thumb_url['image_catched'])){
      if(!$thumb_url['image_catched']){
      $thumb_url='';
      }
      else{
        $thumb_url=$thumb_url['src'];
      }
    }
     
    return $thumb_url;

  }

  public static function first_image($width, $height,$url_or_img=0){
    $image_parametr = self::catch_that_image();
    $thumb = $image_parametr['src'];
    $class='';
    if(!$image_parametr['image_catched'])
      $class='class="no_image"';
      if ($thumb) {
          $str = "<img src=\"";
          $str .= $thumb;
          $str .= '"';
          $str .= 'alt="'.get_the_title().'" width="'.$width.'" height="'.$height.'" '.$class.' border="0" style="width:'.$width.'; height:'. $height.';" data-s="" />';
          return $str;
      }
  }

  /**
  * returns image tag with image
  * for containers of fixed size
  * image fitted, cropped, centered
  */

  public static function fixed_thumbnail($width, $height, $grab_image = true){
   
    $tumb_id = get_post_thumbnail_id( get_the_ID() );
    $thumb_url = wp_get_attachment_image_src($tumb_id,array($width,$height));
    $thumb_url = $thumb_url[0];
    if($grab_image) {
      if( !$thumb_url ) {
      $thumb_url = self::catch_that_image();
      $thumb_url = $thumb_url['src'];
      }
    }
    if($thumb_url){
      list($w, $h) = getimagesize($thumb_url);
      if($w == 0){
        $w=10;
      }
      if($h == 0){
        $h=10;
      }
      if($h/$w > $height/$width){
        $scale = $width / $w;
        $style_img = 'width:100%; height:auto; max-width:none; left:0; top:'. ( $height/2 - $h/2 * $scale) .'px;';
      }
      else {
        $scale = $height/ $h;
        $style_img = 'height:100%; width:auto; max-width:none; left:'. ( $width/2 -$w/2 * $scale) .'px;';
      } 
      return '<img class="wp-post-image" src="'.$thumb_url.'" alt="'.esc_attr(get_the_title()).'" style="'.$style_img.'" />';
    }
    else {
      return '';
    }
  }

  /**
  * returns image tag with image
  * fits width of container
  * height auto
  */

  public static function auto_thumbnail($grab_image = true){
    $tumb_id = get_post_thumbnail_id( get_the_ID() );
    $thumb_url = wp_get_attachment_image_src($tumb_id,'full');
    $thumb_url = $thumb_url[0];
    if($grab_image) {
      if( !$thumb_url ) {
      $thumb_url = self::catch_that_image();
      $thumb_url = $thumb_url['src'];
      }
    }
    if($thumb_url){
      return '<img class="wp-post-image" src="'.$thumb_url.'" alt="'.esc_attr(get_the_title()).'" style="width:100%;" />';
    }
    else {
      return '';
    }
  }

    /**
   *
   *  Generate image for post thumbnail
   * 
   */
  public static function display_thumbnail($width, $height){

    if (has_post_thumbnail()) {
      the_post_thumbnail(array($width, $height));
    }
    elseif (self::is_empty_thumb()) {
      return self::first_image($width, $height); /*first image or no image placeholder*/
    } else {
      return '';
    }
  }


  /**
   *  GET POST FRSTIMAGE FOR WHUMBNAIL
   */

  public static function  catch_that_image(){
      global $post, $posts;
    $first_img = array('src'=>'','image_catched'=>true);
      $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
    if(isset($matches [1] [0])){  
        $first_img['src'] = $matches [1] [0];
    }
      if (empty($first_img['src'])) {
          $first_img['src'] = WDWT_IMG.'default.jpg'; 
      $first_img['image_catched']=false;
      }
      return $first_img;
  }



  public static function thumbnail($width, $height){
    if ( has_post_thumbnail()){
      the_post_thumbnail(array($width, $height));
    }
    elseif (self::is_empty_thumb()) {
      return '';
    }
  }


  public static function is_empty_thumb(){
    $thumb = get_post_custom_values("Image");
    return empty($thumb);
}


    public static function the_title_max_charlength($charlength, $title=false) {
    
      if($title){
      }
      else{
        $title = the_title($before = '', $after = '', FALSE);
      }
      
      $title_length = mb_strlen($title);
      if($title_length <= $charlength){
        echo $title;
      }
      else{
        $limited_title = mb_substr($title, 0, $charlength);
        echo $limited_title . "...";
      }
    
  }


  public static function the_excerpt_max_charlength($charlength,$content=false) {
    
    if($content){
      $excerpt=strip_shortcodes($content);
    }
    else{
      $excerpt = get_the_excerpt();
    }
    $excerpt = strip_tags($excerpt); 
    $charlength++;
    
    if ( mb_strlen( $excerpt ) > $charlength ) {
      $subex = mb_substr( $excerpt, 0, $charlength - 5 );
      $exwords = explode( ' ', $subex );
      $excut = - ( mb_strlen( $exwords[ count( $exwords ) - 1 ] ) );
      if ( $excut < 0 ) {
        echo mb_substr( $subex, 0, $excut ).'...';
      } else {
        echo $subex.'...';
      }
    } 
    else {
      echo str_replace('[&hellip;]','',$excerpt);
    }
  }


  public static function remove_last_comma($string=''){

    if(substr($string,-1)==',')
      return substr($string, 0, -1);
    else
      return $string;
  
  }


  public static function wpb_set_post_views($postID) {
    $count_key = 'wpb_post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    

    if($count==''){
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    } else{
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}



public static function excerpt_more( $more ) {
  return '...';
}




public static function remove_more_jump_link($link){
    $offset = strpos($link, '#more-');
    if ($offset) {
        $end = strpos($link, '"', $offset);
    }
    if ($end) {
        $link = substr_replace($link, '', $offset, $end - $offset);
    }
    return $link;
}



/*WooCommerce support */
public static function wdwt_wrapper_start(){ ?>
  </header>
  <div class="container">
  <?php if ( is_active_sidebar( 'sidebar-1' ) ) { ?>
        <aside id="sidebar1" >
            <div class="sidebar-container">     
        <?php  dynamic_sidebar( 'sidebar-1' );  ?>
        <div class="clear"></div>
            </div>
        </aside>
  <?php } ?>
  <div id="content"><?php
}

public static function wdwt_wrapper_end(){
  ?></div>
  <?php if ( is_active_sidebar( 'sidebar-2' ) ) { ?>
    <aside id="sidebar2">
      <div class="sidebar-container">
        <?php  dynamic_sidebar( 'sidebar-2' );  ?>
        <div class="clear"></div>
      </div>
    </aside>
  <?php } ?>
    <div class="clear"></div>
  </div><?php
}

}