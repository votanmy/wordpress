<?php 
/*
Get posts data then insert to posts_data.sql
*/

// Prevent direct access
if (php_sapi_name() !='cli') exit;

// Get products

$products = wc_get_products(array('status' => 'publish','limit' => -1));

if ( $products ) {

	$relations_file = fopen( 'relations_data.txt', 'a' );
    $products_file = fopen( 'products_data.txt', 'a' );
    $mapping_file = fopen( 'mapping_data.txt', 'a' );
	fwrite($relations_file, "TRUNCATE `est_relations`;\nINSERT INTO `est_relations` (`product_id`,`product_name`,`brand_id`,`brand_name`,`retailer_id`,`retailer_name`,`client_id`,`client_name`) VALUES\n");
    fwrite($products_file, "TRUNCATE `est_products`;\nINSERT INTO `est_products` (`product_id`,`product`,`path`,`views`) VALUES\n");
    fwrite( $mapping_file, "TRUNCATE `est_mapping`;\nINSERT INTO `est_mapping` (`product_id`,`product`,`product_path`,`category_id`,`category`,`category_path`,`category_level`) VALUES\n");
    
    $n = 1;

    foreach ( $products as $product ) :
        
        // brand
    	$b_id = 'NULL';
        $b_name = ''; 

        // retailer
        $r_id = 'NULL';
        $r_name = ''; 
        
        // client
        $c_id = 'NULL';
    	$c_name = '';

        // product
    	$p_id = $product->get_id();
    	$p_name = esc_html($product->get_name());

        // for est_products table
        $p_path = "/". basename(untrailingslashit( get_permalink( $p_id ) )) . "/";
        $p_views = get_post_meta( $p_id, '_total_views_count', TRUE )? get_post_meta( $p_id, '_total_views_count', TRUE ) : 0;

        // for est_mapping table
        $p_mt = YoastSEO()->meta->for_post( $p_id )->breadcrumbs;
        $p_catarr = array_slice($p_mt, -2, 1);
        $p_catid    = 'NULL';
        $p_catname  = '';
        $p_catpath  = '';
        $p_catlevel = 'Level 0';
        if( array_key_exists('taxonomy', $p_catarr[0]) && 'product_cat' == $p_catarr[0]['taxonomy']){
            $p_catid    = $p_catarr[0]['term_id'];
            $p_catname  = esc_html($p_catarr[0]['text']);
            $p_catpath  = '/' . basename($p_catarr[0]['url']) . '/';
            $p_catlevel = 'Level ' . count(get_ancestors($p_catid,'product_cat','taxonomy')) + 1;
        }

        $brand_id = get_post_meta( $p_id, 'brand', true );
        $retailer_id = get_post_meta( $p_id, 'retailer', true );
        $client_id = get_post_meta( $p_id, 'client', true );

        if (!empty($brand_id)){
            $b_id = $brand_id;
    		$b_name = esc_html(get_the_title($b_id));
        }
    	if (!empty($retailer_id)){
            $r_id = $retailer_id;
    		$r_name = esc_html(get_the_title($r_id));    
    	}
    	if(!empty($client_id)){
            $c_id = $client_id;
    		$c_name = esc_html(get_the_title($c_id));
    	}

        if( $n == count($products) ){
            $endline = ';';
        }else{
            $endline = ',';
        }

    	fwrite($relations_file, "({$p_id},'{$p_name}',{$b_id},'{$b_name}',{$r_id},'{$r_name}',{$c_id},'{$c_name}')".$endline."\n");
        fwrite($products_file, "({$p_id},'{$p_name}','{$p_path}',{$p_views})".$endline."\n");
        fwrite($mapping_file, "({$p_id},'{$p_name}','{$p_path}',{$p_catid},'{$p_catname}','{$p_catpath}','{$p_catlevel}')".$endline."\n");

        $n++;

    endforeach;

    fclose($relations_file);
    fclose($products_file);
    fclose($mapping_file);
}
else{
	file_put_contents('errors.log', date("d-m-Y H:i:s") . ':: "Products" not found'.PHP_EOL, FILE_APPEND);
}