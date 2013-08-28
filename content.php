<?php
/**
 * The default template for displaying content. Used for both single and index/archive/search.
 *
 * @package WordPress
 * @subpackage Binary_Bootstrap
 * @since Binary Bootstrap 1.0
 */


	# processing everything needed for this view

	$author_name = get_the_author_meta( "display_name" ); 
	$author_url = get_the_author_meta( "user_url" );
	if ( !empty( $author_url ) ) {
		$author_name = '<a href="'.$author_url.'" target="_blank">'.$author_name.'</a>';
	}

	$user_email = get_the_author_meta( 'user_email' );

	$tag_list = get_the_tag_list( '', __( ', ', 'binarybootstrap' ) );
	if ( $tag_list ) {
		$tag_list = '<div class="tags-links">' . $tag_list . '</div>';
	}
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php if ( has_post_thumbnail() && ! post_password_required() ) : ?>
		<div class="entry-thumbnail">
			<?php the_post_thumbnail(); ?>
		</div>
		<?php endif; ?>

		<?php if ( is_single() ) : ?>
		<h1 class="entry-title"><?php the_title(); ?></h1>
		<?php else : ?>
		<h1 class="entry-title">
			<a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
		</h1>
		<?php endif; // is_single() ?>

		<div class="entry-meta">
			<?php binarybootstrap_entry_meta(); ?>
			<?php edit_post_link( __( 'Edit', 'binarybootstrap' ), '<span class="edit-link">', '</span>' ); ?>
		</div><!-- .entry-meta -->
	</header><!-- .entry-header -->

	<div class="row" >
		<div class="col-md-9">
			<?php if ( is_search() ) : // Only display Excerpts for Search ?>
			<div class="entry-summary">
				<?php the_excerpt(); ?>
			</div><!-- .entry-summary -->
			<?php else : ?>
			<div class="entry-content">
				<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'binarybootstrap' ) ); ?>	
				<?php wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'binarybootstrap' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) ); ?>
			</div><!-- .entry-content -->
			<?php endif; ?>
		</div>
		<div class="col-md-3 entry-meta">
			<div class="row author">
				<div class="col-md-2 avatar">
					<?php echo get_avatar( $user_email, "46" ); ?> 
				</div>
				<div class="col-md-10 name">
					<?php echo $author_name; ?>
				</div>
			</div>
			<div class="row">
					<?php echo $tag_list; ?>
			</div>
		</div>
	</div>

	<footer class="entry-meta">
		<?php if ( comments_open() && ! is_single() ) : ?>
			<div class="comments-link">
				<?php comments_popup_link( '<span class="glyphicon glyphicon-comment"></span><span class="leave-reply">' . __( 'Leave a comment', 'binarybootstrap' ) . '</span>', __( 'One comment so far', 'binarybootstrap' ), __( 'View all % comments', 'binarybootstrap' ) ); ?>
			</div><!-- .comments-link -->
		<?php endif; // comments_open() ?>

		<?php if ( is_single() && get_the_author_meta( 'description' ) && is_multi_author() ) : ?>
			<?php get_template_part( 'author-bio' ); ?>
		<?php endif; ?>
	</footer><!-- .entry-meta -->
</article><!-- #post -->
