<div class="wrap">
	<h1 class="wp-heading-inline">Woocommerce product cateory list</h1>
	<hr class="wp-header-end">

	<?php

	  $taxonomy     = 'product_cat';
	  $orderby      = 'name';  
	  $show_count   = 1;      // 1 for yes, 0 for no
	  $pad_counts   = 0;      // 1 for yes, 0 for no
	  $hierarchical = 1;      // 1 for yes, 0 for no  
	  $title        = '';  
	  $empty        = 0;

	  $args = array(
	         'taxonomy'     => $taxonomy,
	         'orderby'      => $orderby,
	         'show_count'   => $show_count,
	         'pad_counts'   => $pad_counts,
	         'hierarchical' => $hierarchical,
	         'title_li'     => $title,
	         'hide_empty'   => $empty
	  );
	 $all_categories = get_categories( $args );
	 foreach ($all_categories as $cat) {
	    if($cat->category_parent == 0) {
	        $category_id = $cat->term_id;       
	        echo '<a href="'. get_term_link($cat->slug, 'product_cat') .'" style="background:#cccfe2;padding:5px 25px;margin-bottom:1px;display:block">'. $cat->name . ' - ' . $cat->count .'</a>';

	        $args2 = array(
	                'taxonomy'     => $taxonomy,
	                'child_of'     => 0,
	                'parent'       => $category_id,
	                'orderby'      => $orderby,
	                'show_count'   => $show_count,
	                'pad_counts'   => $pad_counts,
	                'hierarchical' => $hierarchical,
	                'title_li'     => $title,
	                'hide_empty'   => $empty
	        );
	        $sub_cats = get_categories( $args2 );
	        if($sub_cats) {
	        	echo "<hr>";
	            foreach($sub_cats as $sub_category) {
	                echo  "&nbsp;&#8658;&nbsp;<a href='".get_term_link($sub_category->slug, 'product_cat')."'>".$sub_category->name. " - " . $sub_category->count ."</a>";
	                echo "<br>";
	            } 
	            echo "<hr>";  
	        }
	    }       
	}
	?>

</div>