<?php 
/**
 * Add fields for Clipworthy to attachments
 */

namespace ClipworthyWP;


define (__NAMESPACE__ . '\PRE_APPROVAL_TAXONOMY', 'pre_approve_media_licensing');


/**
 * Register taxonomy for media that is pre-approved for use in Clipworthy
 */
function register_pre_approval_taxonomy () {

    // register the taxonomy
    $args = array(
		'labels'            => array ('name' => 'Pre-approve media licensing'),
		'public'			=> false,
		'hierarchical'      => false,
		'show_in_rest'		=> true,
		'show_admin_column' => true,
		'rewrite'			=> false,
        'default_term'      => array ('name' => '0', 'slug' => '0')
	);

    \register_taxonomy (PRE_APPROVAL_TAXONOMY, 'attachment', $args);
}
add_action( 'init', __NAMESPACE__ . '\register_pre_approval_taxonomy' );


/**
 * Add a checkbox to media items 
 */
function add_attachment_pre_approval_checkbox ( $form_fields, $post ) {
    
    $checked = get_media_pre_approval ($post->ID) ? 'checked' : '';

    $form_fields['pre_approval'] = array(
        'value' => '1',
        'label' => esc_html__( 'Pre-approve for licensing', 'clipworthy-wp' ),
        'helps' => esc_html__( 'Automatically allow editorial licensing of this media by outside entities via Clipworthy', 'clipworthy-wp' ),
        'input' => 'html',
        'html'  => sprintf ('<input type="checkbox" id="attachments-%s-pre_approval" name="attachments[%s][pre_approval] value="1" %s />', $post->ID, $post->ID, $checked)
    );

    return $form_fields;
}
add_filter( 'attachment_fields_to_edit', __NAMESPACE__ . '\add_attachment_pre_approval_checkbox', 5, 2 );

/**
 * Save the pre-approval field to the taxonomy
 */
function save_pre_approval_field ( $attachment_id ) {
    $pre_approve =  isset($_REQUEST['attachments'][ $attachment_id ]['pre_approval']) && ! empty( trim( $_REQUEST['attachments'][ $attachment_id ]['pre_approval'] ) );
    
    set_media_pre_approval ($attachment_id, $pre_approve);
}
add_action( 'edit_attachment', __NAMESPACE__ . '\save_pre_approval_field' );


/**
 * Set media pre-approval status
 */
function set_media_pre_approval ($attachment_id, $pre_approved) {
    $approval_slug = $pre_approved ? '1' : '0';

    \wp_set_object_terms ($attachment_id, $approval_slug, PRE_APPROVAL_TAXONOMY, false);
}

/**
 * Get media pre-approval status
 * 
 * @return bool  Whether the media is pre-approved
 */
function get_media_pre_approval ($attachment_id) {
    $terms = \wp_get_object_terms ($attachment_id, PRE_APPROVAL_TAXONOMY, array ('fields' => 'slugs'));

    // something went wrong - there should only be one pre-approval taxonomy term since it's a boolean value (approved or not approved)
    if (count ($terms) > 1) {
        error_log (__('A media item should never have more than one pre-approval status.', 'clipworthy-wp'));
    }

    // if there's just one term (as there should be) return the bool val of its slug (which should be "0" or "1")
    if (count ($terms) == 1) {
        return boolval( trim ( $terms[0] ) );
    }

    return false;
}