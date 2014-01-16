<?php

$post_type = 'ffw_faqs';

    // Get all the taxonomies for this post type
    $taxonomies = get_object_taxonomies( (object) array( 'post_type' => $post_type ) );

    foreach( $taxonomies as $taxonomy ) { 

        // Gets every "category" (term) in this taxonomy to get the respective posts
        $terms = get_terms( $taxonomy );

        foreach( $terms as $term ) { 

            $args = array(
                'taxonomy'  => $taxonomy,
                'term'      => $term->slug,
                'orderby'   => 'title',
                'order'     => 'ASC'
                );
            $faqs = new WP_Query( "taxonomy=$taxonomy&term=$term->slug" );
            
            if( $faqs->have_posts() ) : ?>
                <h3><?php echo $term->name; ?></h3>
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

    }