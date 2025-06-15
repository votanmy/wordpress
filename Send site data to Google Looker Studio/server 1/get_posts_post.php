<?php 
/*
Get posts data then insert to posts_data.sql
*/

// Prevent direct access
if (php_sapi_name() !='cli') exit;

// Get posts "Post"

$feature_posts = get_posts( array(
	'post_type'   => 'post',
    'numberposts' => -1,
) );

if ( $feature_posts ) {
	$file = fopen( $posts_data_file,'a');
	fwrite($file, "TRUNCATE `editorial_featureproducts`;\n");
	fwrite($file, "TRUNCATE `post_client`;\n");
	fwrite($file, "TRUNCATE `image_relations`;\n");
    foreach ( $feature_posts as $post ) : 
        setup_postdata( $post );

        $p_id = get_the_id();
        $p_name = esc_html(get_the_title());
        $p_date = get_the_date('Y-m-d h:i:s', $p_id); 

        $related_products = get_post_meta( $p_id, 'related_products' );
        if( !empty($related_products[0]) ){
        	$products = $related_products[0];
			if ( !empty($products) ){
				foreach ($products as $prod_id) :
					if( !empty(get_the_title( $prod_id )) ){
						$pd_name = esc_html( get_the_title( $prod_id ) );
						fwrite($file, "insert into editorial_featureproducts values({$p_id},'{$p_date}','{$p_name}',{$prod_id},'{$pd_name}');\n");
					}
				endforeach;
			}
		}

		$clients = get_post_meta( $p_id, 'clients' );		

		if ( !empty($clients) ){
			foreach ($clients as $client):				
				if( !empty($client) ):
					foreach ($client as $idx => $c_id):
						fwrite($file, "insert into post_client values({$p_id},'{$p_date}',{$c_id});\n");
					endforeach;
				endif;
			endforeach;
		}

    endforeach;
    fclose($file);
    wp_reset_postdata();
}
else{
	file_put_contents('errors.log', date("d-m-Y H:i:s") . ':: "Post" not found'.PHP_EOL, FILE_APPEND);
}

