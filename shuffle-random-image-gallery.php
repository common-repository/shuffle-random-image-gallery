<?php
/*
Plugin Name: Shuffle Random Image Gallery
Description: The Shuffle Random Image Gallery plugin dynamically displays random images from specified posts or media IDs, using shortcodes. Ideal for galleries and portfolios, it keeps your site visually engaging. Simple to integrate, it refreshes your website's look effortlessly, making it appealing for any dynamic content-focused web space.
Version: 1.1
Author: Wilfred Chong
Author URI: https://divrender.com/
License: GPL v2 or later
*/

if ( ! defined( 'ABSPATH' ) ) exit;

function shuffle_image_gallery_shortcode($atts) {
    // Extract attributes with default values
    $a = shortcode_atts(array(
        'post_ids' => '',  // Expected as a comma-separated list
        'size' => '100%',  // Default size
    ), $atts);

    // Convert the 'post_ids' attribute into an array and shuffle it
    $post_ids = explode(',', $a['post_ids']);
    shuffle($post_ids);

    // Get only the first post ID after shuffling
    $random_post_id = trim($post_ids[0]);

    // Retrieve permalink and featured image URL
    $post_link = get_permalink($random_post_id);
    $image_url = get_the_post_thumbnail_url($random_post_id, 'full'); // Or choose another image size as needed

    // Start building the output HTML
    $output = '<div class="shuffled-featured-image">';

    // If an image URL was found, include it in the output
    if ($image_url) {
        $output .= '<a target="_blank" href="' . esc_url($post_link) . '">';
        // Use the provided size or default to 100%
        $output .= '<img style="width:' . esc_attr($a['size']) . ';" src="' . esc_url($image_url) . '" alt="Featured image for post ' . esc_attr($random_post_id) . '">';
        $output .= '</a>';
    }

    $output .= '</div>';

    return $output;
}

// Register the [shuffle_featured_images] shortcode
add_shortcode('shuffle_featured_images', 'shuffle_image_gallery_shortcode');


function shuffle_image_media_shortcode($atts) {
    // Extract attributes with default values
    $a = shortcode_atts(array(
        'media_ids' => '',  // Expected as a comma-separated list
        'size' => '100%',   // Default size
    ), $atts);

    // Convert the 'media_ids' attribute into an array and shuffle it
    $media_ids = explode(',', $a['media_ids']);
    shuffle($media_ids);

    // Get only the first media ID after shuffling
    $random_media_id = trim($media_ids[0]);

    // Retrieve the URL of the shuffled image
    $image_url = wp_get_attachment_image_url($random_media_id, 'full'); // Or choose another image size as needed

    // Start building the output HTML
    $output = '<div class="shuffled-image">';

    // If an image URL was found, include it in the output
    if ($image_url) {
        // Use the provided size or default to 100%
        $output .= '<img style="width:' . esc_attr($a['size']) . ';" src="' . esc_url($image_url) . '" alt="Shuffled image">';
    }

    $output .= '</div>';

    return $output;
}

// Register the [shuffle_images] shortcode
add_shortcode('shuffle_images', 'shuffle_image_media_shortcode');

?>
