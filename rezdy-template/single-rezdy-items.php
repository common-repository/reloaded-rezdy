<?php
    get_header();
?>
    <div class="rzd_main rzd_single">
    <?php
        while(have_posts()) :
            the_post();
    ?>
        <div class="rzd_content">
            <h1>
                <?php the_title(); ?>
            </h1>
            <?php
                if(has_post_thumbnail()) {
                    the_post_thumbnail('rzd_item_detail_img');
                }
                
                the_content();
            ?>
        </div>
        <div class="rzd_links">
            <h2><?php _e("Book Class","reloaded-rezdy"); ?></h2>
            <div class="right_calender">
            <?php
                $rzd_item_link = get_post_meta($post->ID, 'rzd_item_link', true);
            ?>
                <script type="text/javascript" src="<?php echo RZD_API_LINK; ?>/pluginJs"></script>
                <iframe seamless="" frameborder="0" width="100%" height="480px" class="rezdy" src="<?php echo RZD_API_LINK; ?>calendarWidget/<?php echo $rzd_item_link; ?>?iframe=true"></iframe>
            </div>
        </div>
        <div id="rzd_cat_list1">
        <?php
            $terms = get_the_terms( $post->ID, 'rezdy-tags' );
            if($terms) {
                echo '<br><br> Tags:';
                if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
                    echo '<ul class="rzd_cat_list">';

                    foreach ( $terms as $term ) {
                        echo '<li><a href="'.get_term_link($term->slug, 'rezdy-tags').'">' . $term->name . '</a>, </li>';
                    }
                    echo '</ul>';
                }
            }
        ?>
        </div>
        
        <?php
            if(RZD_POST_CATEGORY == 'on') {
        ?>
                <div id="rzd_cat_list1">
                <?php
                    $terms = get_the_terms( $post->ID, 'rezdy-category' );
                    if($terms) {
                        echo '<br><br> Category(s):';
                        if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
                            echo '<ul class="rzd_cat_list">';

                            foreach ( $terms as $term ) {
                                echo '<li><a href="'.get_term_link($term->slug, 'rezdy-category').'">' . $term->name . '</a>, </li>';
                            }
                            echo '</ul>';
                        }
                    }
                ?>
                </div>
    <?php
            }
        endwhile;
    ?>
    </div>
<?php
    get_footer();
?>
