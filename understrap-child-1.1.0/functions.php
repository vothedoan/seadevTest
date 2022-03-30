<?php
/**
 * Understrap Child Theme functions and definitions
 *
 * @package UnderstrapChild
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

function create_post_type_entries() {
  $labels = array(
    'name'               => _x( 'Entries', 'post type general name' ),
    'singular_name'      => _x( 'Entries', 'post type singular name' ),
    'add_new'            => _x( 'Add New', 'entries' ),
    'add_new_item'       => __( 'Add New Entries' ),
    'edit_item'          => __( 'Edit Entries' ),
    'new_item'           => __( 'New Entries' ),
    'all_items'          => __( 'All Entries' ),
    'view_item'          => __( 'View Entries' ),
    'search_items'       => __( 'Search Entries' ),
    'not_found'          => __( 'No Entries found' ),
    'not_found_in_trash' => __( 'No Entries found in the Trash' ),
    'parent_item_colon'  => '',
    'menu_name'          => 'Entries'
);

$args = array(
    'labels'        => $labels,
    'description'   => 'Entries',
    'public'        => true,
    'show_ui'        => true,
    'capability_type'  => 'post',
    'menu_position' => 5,
    'supports'      => array( 'title' , 'thumbnail', 'editor', 'page-attributes'),
    'has_archive'   => true,
);

register_post_type( 'entries', $args );
}
add_action( 'init', 'create_post_type_entries' );

add_action( 'gform_after_submission_1', 'insert_post_entries_after_submit_form', 10, 2 );
function insert_post_entries_after_submit_form( $entry, $form ) {

    $id = wp_insert_post(array(
      'post_title'=>'entries'.$entry["id"],
      'post_type'=>'entries',
      'post_content'=>'',
      'post_status' => 'publish'
    ));
    foreach ( $form['fields'] as $field ) {
        $inputs = rgar( $entry, (string) $field->id );
        if($field->id == 1 ){
            update_post_meta($id,"name",$inputs);
        }
        if($field->id == 3 ){
            update_post_meta($id,"address",$inputs);
        }
        if($field->id == 4 ){
            update_post_meta($id,"contact_content",$inputs);
        }
    }

}
