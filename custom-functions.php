<?php

if ( !function_exists( 'binarybootstrap_entry_date' ) ) :

  /**
   * Prints HTML with date information for current post.
   *
   * Create your own binarybootstrap_entry_date() to override in a child theme.
   *
   * @since Binary Bootstrap 1.0
   *
   * @param boolean $echo Whether to echo the date. Default true.
   * @return string The HTML-formatted post date.
   */
  function binarybootstrap_entry_date($echo = true) {
    if ( has_post_format( array('chat', 'status') ) )
      $format_prefix = _x( '%1$s on %2$s', '1: post format name. 2: date', 'binarybootstrap' );
    else
      $format_prefix = '%2$s';

    $date = sprintf( '<span class="date"><time class="entry-date" datetime="%1$s">%2$s</time></span>', esc_attr( get_the_date( 'c' ) ), esc_html( sprintf( $format_prefix, get_post_format_string( get_post_format() ), get_the_date() ) ) );

    if ( $echo )
      echo $date;

    return $date;
  }

endif;


if ( !function_exists( 'binarybootstrap_entry_meta' ) ) :

  /**
   * Prints HTML with meta information for current post: categories, tags, permalink, author, and date.
   *
   * Create your own binarybootstrap_entry_meta() to override in a child theme.
   *
   * @since Binary Bootstrap 1.0
   *
   * @return void
   */
  function binarybootstrap_entry_meta() {
    if ( is_sticky() && is_home() && !is_paged() )
      echo '<span class="glyphicon glyphicon-fire"></span><span class="featured-post">' . __( 'Sticky', 'binarybootstrap' ) . '</span>';

    if ( !has_post_format( 'link' ) && 'post' == get_post_type() )
      binarybootstrap_entry_date();

    // Translators: used between list items, there is a space after the comma.
    $categories_list = get_the_category_list( __( ', ', 'binarybootstrap' ) );
    if ( $categories_list ) {
      echo '<span class="categories-links">' . $categories_list . '</span>';
    }

  }

endif;


wp_enqueue_style( 'custom-style', get_template_directory_uri() . '/custom-style.css', array('binarybootstrap'), null );


add_filter('get_avatar','change_avatar_css');

function change_avatar_css($class) {
  $class = str_replace("class='avatar", "class='avatar img-circle", $class) ;
  return $class;
}


