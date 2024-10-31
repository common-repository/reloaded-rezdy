<?php
    /*
    Template Name: Rezdy Items
    */
    get_header();
?>
    <div class="rzd_main">
    	<h1><?php echo RZD_PAGE_TITLE; ?></h1>
        
        <div class="rzd_options_list">
            <?php echo rzd_get_terms(); ?>
            <div class="rzd_grid_list">
                <span class="rzd_grid_btn">
                    <img src="<?php echo WP_REZDY_URL; ?>rezdy-template/rzd-grid-icon.png" alt="" title="Grid View" />
                </span>
                <span class="rzd_list_btn">
                    <img src="<?php echo WP_REZDY_URL; ?>rezdy-template/rzd-list-icon.png" alt="" title="List view" />
                </span>
            </div>
        </div>
        
        <div class="items_body">        	
        <?php	
            if (get_query_var('page')) {
                $rzd_paged = get_query_var('page');
            } else {
                $rzd_paged = 1;
            }

            $rzd_posts_per_page = get_option('posts_per_page');
            $rzd_post_name_slug = get_option('rzd_post_name_slug');

            $rzd_post_args = array(
                                'post_type'         => $rzd_post_name_slug,
                                'posts_per_page'    => $rzd_posts_per_page,
                                'order'             => 'DESC',
                                'paged'             => $rzd_paged
                            );
            $rzd_post_qry = new WP_Query($rzd_post_args);

            while($rzd_post_qry->have_posts()) :
                $rzd_post_qry->the_post();
        ?>            
            	<div class="items_grid">
                    <a href="<?php the_permalink(); ?>" class="rzd_post_thumbnail">
                    <?php
                        if(has_post_thumbnail()) {
                            the_post_thumbnail('rzd_item_list_img');
                        }
                    ?>
                    </a>
                    
                    <?php
                        if(has_post_thumbnail()) {
                            $rzd_content = '';	
                        } else {
                            $rzd_content = 'rzd_content_full';	
                        }
                    ?>
                    <div class="rzd_listing_content <?php echo $rzd_content ?>">
                        <h2>
                            <a href="<?php the_permalink(); ?>">
                                <?php the_title(); ?>
                            </a>
                        </h2>
                        <p><?php echo rzd_excerpt(); ?></p>
                        
                        <a class="rzd_read_more" href="<?php the_permalink(); ?>">
                            <?php _e("Info &amp; Bookings","reloaded-rezdy") ?>
                        </a>
                    </div>
                </div>
      	<?php
            endwhile;
			
            rzd_pagination();
	?>
     	</div>
    </div>
<?php
    get_footer();
?>