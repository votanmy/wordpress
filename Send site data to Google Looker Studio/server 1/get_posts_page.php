<?php 
/*
Get posts data then insert to posts_data.sql
*/

// Prevent direct access
if (php_sapi_name() !='cli') exit;

// Get pages

$posts = get_posts( array(
	'post_type'   => 'page',
    'numberposts' => -1,
) );

if ( $posts ) {
	$file = fopen( $posts_data_file,'a');
	fwrite($file, "TRUNCATE `page_client`;\n");
    foreach ( $posts as $post ) : 
        setup_postdata( $post );

        $p_id = get_the_id();
        $p_date = get_the_date('Y-m-d h:i:s', $p_id);

		$clients = get_post_meta( $p_id, 'clients' );	

		if ( !empty($clients) ){
			foreach ($clients as $client):
				if( !empty($client) ):				
					foreach ($client as $idx => $c_id):
						fwrite($file, "insert into page_client values({$p_id},'{$p_date}',{$c_id});\n");
					endforeach;
				endif;
			endforeach;
		}

    endforeach;
    fclose($file);
    wp_reset_postdata();
}
else{
	file_put_contents('errors.log', date("d-m-Y H:i:s") . ':: "Page" not found'.PHP_EOL, FILE_APPEND);
}

