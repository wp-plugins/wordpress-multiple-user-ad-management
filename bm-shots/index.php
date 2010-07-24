<?php
/*
Plugin Name: BM_Shots
Plugin URI: http://www.binarymoon.co.uk/projects/bm-shots-automated-screenshots-website/
Description: A plugin to take advantage of the mshots functionality on WordPress.com
Author: Ben Gillbanks
Version: 0.8
Author URI: http://www.binarymoon.co.uk/
*/


// [browsershot url="http://link-to-website" width="foo-value"]
function bm_sc_mshot ($attributes, $content = '', $code = '') {

	extract(shortcode_atts(array(
		'url' => '',
		'width' => 250,
	), $attributes));
	
	$imageUrl = bm_mshot ($url, $width);

	if ($imageUrl == '') {
		return '';
	} else {
		$image = '<img src="' . $imageUrl . '" alt="' . $url . '" width="' . $width . '" />';
		return '<div class="browsershot mshot"><a href="' . $url . '">' . $image . '</a></div>';
	}
	
}

function bm_mshot ($url = '', $width = 250) {

	if ($url != '') {
		return 'http://s.wordpress.com/mshots/v1/' . urlencode(clean_url($url)) . '?w=' . $width;
	} else {
		return '';
	}
	
}

add_shortcode('browsershot', 'bm_sc_mshot');

?>