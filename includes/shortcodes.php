<?php
/**
 * Shortcodes
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

function ffw_faqs_list_shortcode( $atts, $content=null){

    global $post;

    extract( shortcode_atts( array(
        'topic_orderby' => 'title',
        'topic_order'   => 'ASC',
        'orderby'       => 'date',
        'order'         => 'ASC',
        'topic'         => ''
    // ...etc
    ), $atts ) );

        
    // Gets every "category" (term) in this taxonomy to get the respective posts
    $term_args = array(
            'orderby'   => $topic_orderby,
            'order'     => $topic_order
            );


    $terms = get_terms( 'faq_topics', $term_args );
    

    foreach( $terms as $term ) { 

        $args = array(
            'taxonomy'  => 'faq_topics',
            'term'      => $term->slug,
            'orderby'   => $orderby,
            'order'     => $order
            );
        $faqs = new WP_Query( $args );
        
        if( $faqs->have_posts() ) : ?>
            <h3><?php echo $term->name; ?></h3>
            
            <?php ob_start(); ?>
            
            <div class="ffw-faqs-accordion">

            <?php while( $faqs->have_posts() ) : $faqs->the_post(); ?>
        
                    
                <h3 class="ffw-faqs-accordion-trigger"><a href="#"><?php the_title(); ?></a></h3>
                <div>
                <?php 

                if( ffw_faqs_is_excerpt_set() ) {
                    the_excerpt();
                ?>
                <div class="ffw_faqs_wrap">
                    <a href="<?php the_permalink(); ?>">Read More</a>
                </div>
                <?php
                } else{
                    the_content(); 
                 }
                ?>
                </div>

        
            <?php endwhile; ?>
            </div>
        <?php endif;

    }

    $faq_list = ob_get_clean();

    return $faq_list;
}
add_shortcode('faq_list', 'ffw_faqs_list_shortcode');

