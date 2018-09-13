<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( $max_total && (( $max_total * 90 )/ 100 ) <= $total_count  ) {
	$class = " class='difp-font-red'";
} else {
	$class = "";
}

?>



