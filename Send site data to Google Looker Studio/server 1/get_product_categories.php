<?php 
/*
Get product categories data then print them into products_data.txt
*/

// Prevent direct access
if (php_sapi_name() !='cli') exit;

// Get product categories data

$terms = get_terms( ['taxonomy' => 'product_cat', 'hide_empty' => true] );

if ( $terms ) {

	$products_file = fopen( 'products_data.txt', 'a' );
	fwrite($products_file, "TRUNCATE `est_categories`;\nINSERT INTO `est_categories` (`level_1_cat_id`,`level_1_category`,`level_2_cat_id`,`level_2_category`,`level_3_cat_id`,`level_3_category`,`level_4_cat_id`,`level_4_category`,`path`,`views`) VALUES\n");

    $n = 1;

    foreach ($terms as $term) {

        $current_termID = $term->term_id;

        $term_names = untrailingslashit(get_term_parents_list($current_termID, 'product_cat', array('link' => false)));
        $term_names_arr = explode('/', $term_names);

        $term_ids_arr = array_reverse(get_ancestors($current_termID,'product_cat','taxonomy'));
        $term_ids_arr[] = $current_termID;

        $terms_arr = array();
        for ($i=0; $i < 4; $i++) {
            $termID         = array_key_exists($i, $term_ids_arr)? $term_ids_arr[$i] : 'NULL';
            $term_name      = array_key_exists($i, $term_names_arr)? $term_names_arr[$i] : '';
            $terms_arr[]    = $termID . ",'" . esc_html($term_name) . "'";
        }

        $term_path = ",'/". basename(get_term_link($current_termID,'product_cat')) . "/'";

        $views = get_term_meta( $current_termID, '_total_views_count', TRUE );
        $total_views = $views? $views : 0;

        $term_detail = implode(',',$terms_arr);

        if( $n == count($terms) ){
            $endline = ';';
        }else{
            $endline = ',';
        }

        $query = '('. implode(',',$terms_arr) . $term_path . ',' . $total_views . ')' . $endline;

        fwrite($products_file, "{$query}\n");

        $n++;        
    }

    fclose($products_file);
}
else{
	file_put_contents('errors.log', date("d-m-Y H:i:s") . ':: "Terms" not found'.PHP_EOL, FILE_APPEND);
}