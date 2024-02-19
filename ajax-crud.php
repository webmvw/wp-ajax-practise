<?php
/*
Plugin Name: Ajax Crud
Plugin URI: https://webmkit.com/ajax-crud
Author: webmk
Author URI: https://webmkit.com
Description: something
Version: 1.0.0
Tags: ajax, crud, wp, php
Text Domain: mk
Language: English
*/



/* === Plugin Activation hook === */
register_activation_hook( __FILE__ , 'activate_ajax_crud');
function activate_ajax_crud(){
	global $wpdb;
	$charset_collate = $wpdb->get_charset_collate();
	if(!function_exists('dbDelta')){
		require_once(ABSPATH.'wp-admin/includes/upgrade.php');
	}

	$contact_info_query = "CREATE TABLE IF NOT EXISTS `{$wpdb->prefix}contact_info`(
		`id` int(11) NOT NULL AUTO_INCREMENT,
		`name` varchar(200) DEFAULT NULL,
		`phone` varchar(200) DEFAULT NULL,
		PRIMARY KEY (`id`)
	) $charset_collate";
	dbDelta($contact_info_query);
}


/* === Plugin Deactivation hook === */
register_deactivation_hook( __FILE__ , 'deactivate_ajax_crud' );
function deactivate_ajax_crud(){
	global $wpdb;
	$wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}contact_info");
}




/* === Plugin Menu === */
add_action('admin_menu', 'mk_crud_admin_menu');
function mk_crud_admin_menu(){
	add_menu_page( 'Ajax Crud', 'Ajax Crud', 'manage_options', 'ajax-crud', 'ajax_crud_dashborad');
	add_submenu_page( "ajax-crud", "WP List Table", "WP List Table", "manage_options", 'wp-list-table', 'ajax_crud_list_table' );
	add_submenu_page( "ajax-crud", "Product Category", "Product Category", "manage_options", 'mk-product-cateogory-list', 'mk_product_category_list' );
	add_submenu_page( "ajax-crud", "Product List", "Product List", "manage_options", 'mk-product-product-list', 'mk_product_product_list' );
}

function ajax_crud_dashborad(){
	ob_start();
	include plugin_dir_path( __FILE__ ).'/include/dashboard.php';
	$template = ob_get_contents();
	ob_end_clean();
	echo $template;
}

function ajax_crud_list_table(){
	ob_start();
	include_once plugin_dir_path( __FILE__ ).'/include/view.php';
	$template = ob_get_contents();
	ob_end_clean();
	echo $template;
}

function mk_product_category_list(){
	ob_start();
	include plugin_dir_path( __FILE__ ).'/include/product-category.php';
	$template = ob_get_contents();
	ob_end_clean();
	echo $template;
}


function mk_product_product_list(){
	ob_start();
	include plugin_dir_path( __FILE__ ).'/include/product-list.php';
	$template = ob_get_contents();
	ob_end_clean();
	echo $template;
}







add_action('wp_ajax_my_ajax_crud_action', 'my_ajax_crud_function');
add_action('wp_ajax_nopriv_my_ajax_crud_action', 'my_ajax_crud_function');
function my_ajax_crud_function(){
	global $wpdb;
	$data['name'] = isset($_POST['contact_name']) ? sanitize_text_field($_POST['contact_name']) : '';
    $data['phone'] = isset($_POST['contact_phone']) ? sanitize_textarea_field($_POST['contact_phone']) : '';
	$inserted = $wpdb->insert(
		"{$wpdb->prefix}contact_info",
		$data,
		[
			'%s','%s'
		]
	);
	if($inserted){
		echo '<span style="color:green">Data Insert Success</span>';
	}else{
		echo '<span style="color:red">Data Not Insert</span>';
	}
}


add_shortcode('mk_product_list', 'mk_product_list_callback');
function mk_product_list_callback(){
	?>
<ul class="products">
    <?php
    $args = array(
        'product_cat' => 'Accessories',
        'posts_per_page' => 6,
        'orderby' => 'rand'
    );
    $loop = new WP_Query($args);
    while ($loop->have_posts()) : $loop->the_post();
        global $product; global $post;?>
        <div class="row">
            <!-- <h2>Shampoo</h2> -->
            <li class="product">

                <a href="<?php echo get_permalink($loop->post->ID) ?>" title="<?php echo esc_attr($loop->post->post_title ? $loop->post->post_title : $loop->post->ID); ?>">

                    <?php woocommerce_show_product_sale_flash($post, $product); ?>

                    <?php if (has_post_thumbnail($loop->post->ID)) echo get_the_post_thumbnail($loop->post->ID, 'shop_catalog');
                    else echo '<img src="' . woocommerce_placeholder_img_src() . '" alt="Placeholder" width="300px" height="300px" />'; ?>

                    <h3><?php the_title(); ?></h3>

                    <span class="price"><?php echo $product->get_price_html(); ?></span>

                </a>
                <br>
                <?php woocommerce_template_loop_add_to_cart($loop->post, $product); ?>
            </li>
        </div>
    <?php endwhile; ?>
    <?php wp_reset_query(); ?>
</ul>
<!--/.products-->
	<style>
		.products{
			list-style: none;
	    display: flex;
	    flex-wrap: wrap;
	    justify-content: space-between;
		}
		.products li{
			/*float: left; */
		    margin: 15px;
		    background: purple;
		    padding: 10px;
		    text-align: center;
		    width:330px;
		}
		
	</style>
	<?php
}