<?php
/**
 * Shortcodes
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

function ffw_faqs_list_shortcode( $post ){

    global $post;

    $post_type = 'ffw_faqs';

    // Get all the taxonomies for this post type
    $taxonomies = get_object_taxonomies( (object) array( 'post_type' => $post_type ) );
    ob_start(); 
    foreach( $taxonomies as $taxonomy ) { 

        // Gets every "category" (term) in this taxonomy to get the respective posts
        $terms = get_terms( $taxonomy );

        foreach( $terms as $term ) { 

            $posts = new WP_Query( "taxonomy=$taxonomy&term=$term->slug" );
            
            if( $posts->have_posts() ) : ?>
                <h3><?php echo $term->name; ?></h3>
                <div class="ffw-faqs-accordion">

                <?php while( $posts->have_posts() ) : $posts->the_post(); ?>
            
                        
                    <h3 class="ffw-faqs-accordion-trigger"><a href="#"><?php the_title(); ?></a></h3>
                    <div>
                    <?php the_content(); ?>
                    </div>

            
                <?php endwhile; ?>
                </div>
            <?php endif;

        }

    }
    return ob_get_clean();
}
add_shortcode('faq_list', 'ffw_faqs_list_shortcode');


