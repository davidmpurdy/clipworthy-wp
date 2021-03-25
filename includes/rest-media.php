<?php 
/**
 * Modify REST API media endpoint
 */

namespace ClipworthyWP;

define (__NAMESPACE__ . '\PRE_APPROVAL_REST_FIELD', 'clipworthy_approved');

/**
 * Add a 'pre-approved' field to the media endpoing
 */
function pre_approved_rest_field () {
    \register_rest_field ('attachment', PRE_APPROVAL_REST_FIELD, array ('get_callback' => __NAMESPACE__ . '\pre_approved_field_callback'));
}
\add_action( 'rest_api_init', __NAMESPACE__ . '\pre_approved_rest_field' );


/**
 * Callback for pre-approval media field
 */
function pre_approved_field_callback ($post, $attr, $request) {
    error_log ('post: ' . print_r ($post, true));
    if ( empty ($post) || !is_array ($post) || empty ($post['id'])) {
        return false;
    }
    return get_media_pre_approval ($post['id']);
}