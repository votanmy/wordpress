<?php 
/*
Get posts data then insert to posts_data.sql
*/

// Prevent direct access
if (php_sapi_name() !='cli') exit;

// Get posts "Space"

$space_posts = get_posts( array(
	'post_type'   => 'space',
    'numberposts' => -1,
) );

if ( $space_posts ) {
	$space_file = fopen( 'space_data.txt','a');
	fwrite($space_file, "TRUNCATE `spaces_thelookproducts`;\n");
    foreach ( $space_posts as $post ) : 
        setup_postdata( $post );

        $sp_id = get_the_id();
        $sp_name = esc_html(get_the_title());
        $sp_date = get_the_date('Y-m-d h:i:s', $sp_id);

        $related_products = get_post_meta( get_the_id(), 'related_products' );
        $products = $related_products[0];

		if ( !empty($products) ){
			foreach ($products as $prod_id) :
				if( !empty(get_the_title( $prod_id )) ){
					$pd_name = esc_html( get_the_title( $prod_id ) );
					fwrite($space_file, "insert into spaces_thelookproducts values({$sp_id},'{$sp_date}','{$sp_name}',{$prod_id},'{$pd_name}');\n");
				}
			endforeach;
		}

		// Image links to products
		$images = get_field('space_images', $sp_id);

		if ($images) :
			foreach ($images as $image):

				if( have_rows('product_links', $image['id']) ):

					while( have_rows('product_links', $image['id']) ): the_row();

						$image_url = '';
						if( array_key_exists('header', $image['sizes']) ){ 
							$image_url = $image['sizes']['header'];
						}

						$p_obj = get_sub_field('product');

				    	$product = wc_get_product( intval($p_obj->ID) );

				    	// brand, retailer, client
				        $b_name = ''; 
				        $r_name = ''; 
				    	$c_name = '';

				    	// product
				    	if( !empty($product) ){
				    		$p_id = $product->get_id();
				    		$p_name = esc_html($product->get_name());
				    	}

				    	$b_id = get_post_meta( $p_id, 'brand', true );
        				$r_id = get_post_meta( $p_id, 'retailer', true );

				        if (!empty($b_id)):
			        		$b_name = esc_html(get_the_title($b_id));
				        endif;
				    	if (!empty($r_id)):
			        		$r_name = esc_html(get_the_title($r_id));    
				    	endif;

				    	$c_id = get_post_meta( $p_id, 'client', true );

				    	if(!empty($c_id)){
				    		$c_name = esc_html(get_the_title($c_id));
				    	}

				    	fwrite($space_file, "insert into image_relations values('{$image_url}',{$p_id},'{$p_name}','{$c_name}','{$r_name}','{$b_name}');\n");

					endwhile;

				endif;

			endforeach;

		endif;		

    endforeach;
    fclose($space_file);
    wp_reset_postdata();
}
else{
	file_put_contents('errors.log', date("d-m-Y H:i:s") . ':: "Space" not found'.PHP_EOL, FILE_APPEND);
}

