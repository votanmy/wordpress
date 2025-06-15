<?php
/*
Get data from the file posts_data.sql sent by live site. Import it to database
*/
// header( 'Cache-Control: max-age=0,no-store');

if (php_sapi_name() !='cli') exit;


/* File: posts_data.txt */
$sql = mysqli_connect('localhost', 'uv6qlo93btxeh', 'swvaivkjeuu0', 'dbjpqd1dwdpxms');

if( mysqli_connect_errno() ) {
    file_put_contents('errors.log', date("d-m-Y H:i:s") . ':: Failed to connect(1) to MySQL: '.mysqli_connect_error().PHP_EOL, FILE_APPEND);
    exit;
}

$sqlSource = file_get_contents('https://example.com/sftp-to-report-server/posts_data.txt');

if( !empty($sqlSource) ){

	$success = mysqli_multi_query( $sql, $sqlSource);
	
	if( !$success ){
		file_put_contents('errors.log', date("d-m-Y H:i:s") . ':: Import error'.PHP_EOL, FILE_APPEND);
	}
}
else{
	file_put_contents('errors.log', date("d-m-Y H:i:s") . ':: File posts_data.txt does not exist or empty'.PHP_EOL, FILE_APPEND);
}

mysqli_close($sql);

/* File: products_data.txt */
$sql = mysqli_connect('localhost', 'uv6qlo93btxeh', 'swvaivkjeuu0', 'dbjpqd1dwdpxms');

if( mysqli_connect_errno() ) {
    file_put_contents('errors.log', date("d-m-Y H:i:s") . ':: Failed to connect(2) to MySQL: '.mysqli_connect_error().PHP_EOL, FILE_APPEND);
    exit;
}
$sqlSource = file_get_contents('https://example.com/sftp-to-report-server/products_data.txt');

if( !empty($sqlSource) ){

	$success = mysqli_multi_query( $sql, $sqlSource);
	
	if( !$success ){
		file_put_contents('errors.log', date("d-m-Y H:i:s") . ':: Import error'.PHP_EOL, FILE_APPEND);
	}
}
else{
	file_put_contents('errors.log', date("d-m-Y H:i:s") . ':: File products_data.txt does not exist or empty'.PHP_EOL, FILE_APPEND);
}

mysqli_close($sql);

/* File: relations_data.txt */
$sql = mysqli_connect('localhost', 'uv6qlo93btxeh', 'swvaivkjeuu0', 'dbjpqd1dwdpxms');

if( mysqli_connect_errno() ) {
    file_put_contents('errors.log', date("d-m-Y H:i:s") . ':: Failed to connect(3) to MySQL: '.mysqli_connect_error().PHP_EOL, FILE_APPEND);
    exit;
}

$sqlSource = file_get_contents('https://example.com/sftp-to-report-server/relations_data.txt');

if( !empty($sqlSource) ){

	$success = mysqli_multi_query( $sql, $sqlSource);
	
	if( !$success ){
		file_put_contents('errors.log', date("d-m-Y H:i:s") . ':: Import error'.PHP_EOL, FILE_APPEND);
	}
}
else{
	file_put_contents('errors.log', date("d-m-Y H:i:s") . ':: File relations_data.txt does not exist or empty'.PHP_EOL, FILE_APPEND);
}

mysqli_close($sql);

/* File: space_data.txt */
$sql = mysqli_connect('localhost', 'uv6qlo93btxeh', 'swvaivkjeuu0', 'dbjpqd1dwdpxms');

if( mysqli_connect_errno() ) {
    file_put_contents('errors.log', date("d-m-Y H:i:s") . ':: Failed to connect(4) to MySQL: '.mysqli_connect_error().PHP_EOL, FILE_APPEND);
    exit;
}

$sqlSource = file_get_contents('https://example.com/sftp-to-report-server/space_data.txt');

if( !empty($sqlSource) ){

	$success = mysqli_multi_query( $sql, $sqlSource);
	
	if( !$success ){
		file_put_contents('errors.log', date("d-m-Y H:i:s") . ':: Import error'.PHP_EOL, FILE_APPEND);
	}
}
else{
	file_put_contents('errors.log', date("d-m-Y H:i:s") . ':: File space_data.txt does not exist or empty'.PHP_EOL, FILE_APPEND);
}

mysqli_close($sql);


/* File: mapping_data.txt */
$sql = mysqli_connect('localhost', 'uv6qlo93btxeh', 'swvaivkjeuu0', 'dbjpqd1dwdpxms');

if( mysqli_connect_errno() ) {
    file_put_contents('errors.log', date("d-m-Y H:i:s") . ':: Failed to connect(5) to MySQL: '.mysqli_connect_error().PHP_EOL, FILE_APPEND);
    exit;
}

$sqlSource = file_get_contents('https://example.com/sftp-to-report-server/mapping_data.txt');

if( !empty($sqlSource) ){

	$success = mysqli_multi_query( $sql, $sqlSource);
	
	if( !$success ){
		file_put_contents('errors.log', date("d-m-Y H:i:s") . ':: Import error'.PHP_EOL, FILE_APPEND);
	}
}
else{
	file_put_contents('errors.log', date("d-m-Y H:i:s") . ':: File mapping_data.txt does not exist or empty'.PHP_EOL, FILE_APPEND);
}

mysqli_close($sql);

