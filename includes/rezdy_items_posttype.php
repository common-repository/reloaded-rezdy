<?php
//========== Post-Type: Reazdy Itmes

// Register Posttype
add_action('init', 'create_rzd_items');
function create_rzd_items() {
    
    $rezdy_post_slug = 'rezdy-items';
    $rezdy_post_slug = get_option('rzd_post_name_slug');
	
	$rezdy_labels = array(
        'name'                  => 	__('Rezdy Reloaded', 'reloaded-rezdy'),
        'all_items'             => 	__('Items', 'reloaded-rezdy'),
        'singular_name'         => 	__('Item', 'reloaded-rezdy'),
        'add_new'               => 	__('Add Item', 'reloaded-rezdy'),
        'add_new_item'          => 	__('Add New Item', 'reloaded-rezdy'),
        'edit_item'             => 	__('Edit Item', 'reloaded-rezdy'),
        'new_item'              => 	__('New Item', 'reloaded-rezdy'),
        'view_item'             => 	__('View Item', 'reloaded-rezdy'),
        'search_items'          => 	__('Search Item', 'reloaded-rezdy'),
        'not_found'             => 	__('Nothing found', 'reloaded-rezdy'),
        'not_found_in_trash'    => 	__('Nothing found in Trash', 'reloaded-rezdy'),
        'parent_item_colon'     => 	''
    );
    
    $rzd_rewrite = array(
        'slug'        	=> 	$rezdy_post_slug,
        'with_front'    => 	true,
        'pages'         => 	false,
        'feeds'         => 	true,
    );
    
    $rezdy_args = array(
        'labels'                => 	$rezdy_labels,
        'public'                => 	true,
        'publicly_queryable'    => 	true,
        'show_ui'               => 	true,
        'query_var'             => 	true,
        'menu_icon'             => 	WP_REZDY_URL.'includes/images/rezdy-icon.png',
        'capability_type'       => 	'post',
        'hierarchical'          => 	false,
        'supports'              => 	array('title','editor','thumbnail','revisions','excerpt'),
        'rewrite'               => 	$rzd_rewrite,
        'show_in_menu'          => 	true,
        'show_in_nav_menus'     => 	true,
        'show_in_admin_bar'     => 	true,
        'can_export'            => 	true,
        'has_archive'           => 	true,
        'exclude_from_search'   => 	true
    );
 
    register_post_type( $rezdy_post_slug , $rezdy_args );
}

// Register Tags
add_action( 'init', 'create_rezdy_category', 0 );
function create_rezdy_category() {
	
    $rezdy_post_slug = 'rezdy-items';
    $rezdy_post_slug = get_option('rzd_post_name_slug');
	
    $rezdy_cat_labels = array(
                            'name'              => 	__( 'Category', 'kbe'),
                            'singular_name'     => 	__( 'Category', 'kbe' ),
                            'search_items'      => 	__( 'Search Category', 'kbe' ),
                            'all_items'         => 	__( 'All Categories', 'kbe' ),
                            'parent_item'       => 	__( 'Parent Category', 'kbe' ),
                            'parent_item_colon' => 	__( 'Parent Category:', 'kbe' ),
                            'edit_item'         => 	__( 'Edit Category', 'kbe' ),
                            'update_item'       => 	__( 'Update Category', 'kbe' ),
                            'add_new_item'      => 	__( 'Add New Category', 'kbe' ),
                            'new_item_name'     => 	__( 'New Category', 'kbe' ),
                            'menu_name'         => 	__( 'Categories', 'kbe' )
                        );
    
    register_taxonomy( 'rezdy-category',
                        array($rezdy_post_slug),
                            array(
                                'hierarchical'  =>  true,
                                'labels'        =>  $rezdy_cat_labels,
                                'show_ui'       =>  true,
                                'query_var'     =>  true,
                                'rewrite'       =>  array('slug' => 'rezdy-category', 'with_front' => true),
                            )
                        );
					
    register_taxonomy_for_object_type( 'rezdy-items-category', $rezdy_post_slug );
}

// Register Tags
add_action( 'init', 'create_rezdy_tags', 0 );
function create_rezdy_tags() {
	
    $rezdy_post_slug = 'rezdy-items';
    $rezdy_post_slug = get_option('rzd_post_name_slug');
	
    $rezdy_tags_labels = array(
                            'name'              =>  __( 'Tags', 'reloaded-rezdy' ),
                            'singular_name' 	=>  __( 'Tag', 'rzd' ),
                            'search_items' 	=>  __( 'Search Tags', 'reloaded-rezdy' ),
                            'all_items' 	=>  __( 'All Tags', 'reloaded-rezdy' ),
                            'edit_item' 	=>  __( 'Edit Tag', 'reloaded-rezdy' ),
                            'update_item' 	=>  __( 'Update Tag', 'reloaded-rezdy' ),
                            'add_new_item' 	=>  __( 'Add New Tag', 'reloaded-rezdy' ),
                            'new_item_name' 	=>  __( 'New Tag Name', 'reloaded-rezdy' ),
                            'menu_name' 	=>  __( 'Tags', 'rzd' )
                        );
    
    register_taxonomy( 'rezdy-tags',
                        array($rezdy_post_slug),
                            array(
                                'hierarchical'  =>  false,
                                'labels'        =>  $rezdy_tags_labels,
                                'show_ui'       =>  true,
                                'query_var'     =>  true,
                                'rewrite'       =>  array('slug' => 'rezdy-tags', 'with_front' => true),
                            )
                        );
					
    register_taxonomy_for_object_type( 'rezdy-items-tags', $rezdy_post_slug );
}

// Custom Meta Box
function rezdy_meta_box($post) {
    $rezdy_post_slug = 'rezdy-items';
    $rezdy_post_slug = get_option('rzd_post_name_slug');
	
    add_meta_box('rezdy_meta_id', 'Rezdy Product Code', 'crt_rezdy_meta', $rezdy_post_slug, 'normal', 'high');
}
add_action('add_meta_boxes','rezdy_meta_box');

function crt_rezdy_meta($post) {
    $rzd_item_link = get_post_meta($post->ID, 'rzd_item_link', true);
?>
    <table width="100%" border="0" cellspacing="2" cellpadding="2">
        <tr>
                <td width="21%">
                <strong><?php _e('Product Code','reloaded-rezdy'); ?></strong>
            </td>
                <td width="79%">
                <input type="text" name="rzd_item_link" value="<?php echo $rzd_item_link ?>" style="width: 30%;" />
            </td>
        </tr>
    </table>
    <span style="display: inline-block">
        <em>
        <?php
        _e('Find this number in your Rezdy product link. Eg For https://yourcompany.rezdy.com/63061/product-name you would enter "63061"','reloaded-rezdy');
        ?>
        </em>
    </span>
<?php
}

// Save Custom Meta Fields Values
add_action("save_post","save_rezdy_item_link");
function save_rezdy_item_link() {
    global $post;

    if(isset($_POST['rzd_item_link'])) {
        $rzd_item_link = $_POST['rzd_item_link'];

        update_post_meta($post->ID, 'rzd_item_link', $rzd_item_link);
    }
}
?>