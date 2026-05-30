<?php
/**
 * Admin section builder for OneUp Sections.
 *
 * @package OneUpMotion
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

//───────────────────────────────────────
// Section field definitions
//───────────────────────────────────────
function oum_section_field_definitions() {
	return array(
		'hero'          => array(
			'eyebrow'                => array( 'label' => __( 'Eyebrow / label', 'oneup-motion' ), 'type' => 'text' ),
			'heading'                => array( 'label' => __( 'Heading', 'oneup-motion' ), 'type' => 'text' ),
			'highlighted_word'       => array( 'label' => __( 'Highlighted word', 'oneup-motion' ), 'type' => 'text' ),
			'text'                   => array( 'label' => __( 'Text', 'oneup-motion' ), 'type' => 'textarea' ),
			'primary_button_label'   => array( 'label' => __( 'Primary button label', 'oneup-motion' ), 'type' => 'text' ),
			'primary_button_url'     => array( 'label' => __( 'Primary button URL', 'oneup-motion' ), 'type' => 'url' ),
			'secondary_button_label' => array( 'label' => __( 'Secondary button label', 'oneup-motion' ), 'type' => 'text' ),
			'secondary_button_url'   => array( 'label' => __( 'Secondary button URL', 'oneup-motion' ), 'type' => 'url' ),
			'visual_style'           => array( 'label' => __( 'Visual style', 'oneup-motion' ), 'type' => 'select', 'choices' => array( 'geometric' => __( 'Geometric', 'oneup-motion' ), 'simple' => __( 'Simple', 'oneup-motion' ), 'none' => __( 'None', 'oneup-motion' ) ) ),
		),
		'text'          => array(
			'eyebrow'   => array( 'label' => __( 'Eyebrow', 'oneup-motion' ), 'type' => 'text' ),
			'heading'   => array( 'label' => __( 'Heading', 'oneup-motion' ), 'type' => 'text' ),
			'text'      => array( 'label' => __( 'Text', 'oneup-motion' ), 'type' => 'textarea' ),
			'alignment' => array( 'label' => __( 'Alignment', 'oneup-motion' ), 'type' => 'select', 'choices' => array( 'left' => __( 'Left', 'oneup-motion' ), 'center' => __( 'Center', 'oneup-motion' ), 'right' => __( 'Right', 'oneup-motion' ) ) ),
		),
		'text_image'    => array(
			'eyebrow'        => array( 'label' => __( 'Eyebrow', 'oneup-motion' ), 'type' => 'text' ),
			'heading'        => array( 'label' => __( 'Heading', 'oneup-motion' ), 'type' => 'text' ),
			'text'           => array( 'label' => __( 'Text', 'oneup-motion' ), 'type' => 'textarea' ),
			'image_id'       => array( 'label' => __( 'Image upload', 'oneup-motion' ), 'type' => 'media' ),
			'image_position' => array( 'label' => __( 'Image position', 'oneup-motion' ), 'type' => 'select', 'choices' => array( 'left' => __( 'Left', 'oneup-motion' ), 'right' => __( 'Right', 'oneup-motion' ) ) ),
			'button_label'   => array( 'label' => __( 'Button label', 'oneup-motion' ), 'type' => 'text' ),
			'button_url'     => array( 'label' => __( 'Button URL', 'oneup-motion' ), 'type' => 'url' ),
		),
		'cards'         => array(
			'eyebrow' => array( 'label' => __( 'Eyebrow', 'oneup-motion' ), 'type' => 'text' ),
			'heading' => array( 'label' => __( 'Heading', 'oneup-motion' ), 'type' => 'text' ),
			'text'    => array( 'label' => __( 'Text', 'oneup-motion' ), 'type' => 'textarea' ),
			'layout'  => array( 'label' => __( 'Layout', 'oneup-motion' ), 'type' => 'select', 'choices' => array( '2' => __( '2 columns', 'oneup-motion' ), '3' => __( '3 columns', 'oneup-motion' ), '4' => __( '4 columns', 'oneup-motion' ) ) ),
			'cards'   => array( 'label' => __( 'Cards', 'oneup-motion' ), 'type' => 'repeater', 'fields' => array( 'icon' => __( 'Icon label or simple icon text', 'oneup-motion' ), 'title' => __( 'Card title', 'oneup-motion' ), 'text' => __( 'Card text', 'oneup-motion' ), 'button_label' => __( 'Button label', 'oneup-motion' ), 'button_url' => __( 'Button URL', 'oneup-motion' ) ) ),
		),
		'tools_preview' => array(
			'eyebrow'      => array( 'label' => __( 'Eyebrow', 'oneup-motion' ), 'type' => 'text' ),
			'heading'      => array( 'label' => __( 'Heading', 'oneup-motion' ), 'type' => 'text' ),
			'text'         => array( 'label' => __( 'Text', 'oneup-motion' ), 'type' => 'textarea' ),
			'show_qr'      => array( 'label' => __( 'Show QR Generator', 'oneup-motion' ), 'type' => 'checkbox' ),
			'show_utm'     => array( 'label' => __( 'Show UTM Builder', 'oneup-motion' ), 'type' => 'checkbox' ),
			'show_image'   => array( 'label' => __( 'Show Image Tools', 'oneup-motion' ), 'type' => 'checkbox' ),
			'button_label' => array( 'label' => __( 'Button label', 'oneup-motion' ), 'type' => 'text' ),
			'button_url'   => array( 'label' => __( 'Button URL', 'oneup-motion' ), 'type' => 'url' ),
		),
		'services'      => array(
			'eyebrow'  => array( 'label' => __( 'Eyebrow', 'oneup-motion' ), 'type' => 'text' ),
			'heading'  => array( 'label' => __( 'Heading', 'oneup-motion' ), 'type' => 'text' ),
			'text'     => array( 'label' => __( 'Text', 'oneup-motion' ), 'type' => 'textarea' ),
			'services' => array( 'label' => __( 'Service cards', 'oneup-motion' ), 'type' => 'repeater', 'fields' => array( 'title' => __( 'Title', 'oneup-motion' ), 'text' => __( 'Text', 'oneup-motion' ), 'icon' => __( 'Icon label', 'oneup-motion' ), 'url' => __( 'URL', 'oneup-motion' ) ) ),
		),
		'cta'           => array(
			'heading'      => array( 'label' => __( 'Heading', 'oneup-motion' ), 'type' => 'text' ),
			'text'         => array( 'label' => __( 'Text', 'oneup-motion' ), 'type' => 'textarea' ),
			'button_label' => array( 'label' => __( 'Button label', 'oneup-motion' ), 'type' => 'text' ),
			'button_url'   => array( 'label' => __( 'Button URL', 'oneup-motion' ), 'type' => 'url' ),
			'style'        => array( 'label' => __( 'Style', 'oneup-motion' ), 'type' => 'select', 'choices' => array( 'normal' => __( 'Normal', 'oneup-motion' ), 'highlighted' => __( 'Highlighted', 'oneup-motion' ), 'compact' => __( 'Compact', 'oneup-motion' ) ) ),
		),
		'faq'           => array(
			'eyebrow' => array( 'label' => __( 'Eyebrow', 'oneup-motion' ), 'type' => 'text' ),
			'heading' => array( 'label' => __( 'Heading', 'oneup-motion' ), 'type' => 'text' ),
			'faqs'    => array( 'label' => __( 'FAQ items', 'oneup-motion' ), 'type' => 'repeater', 'fields' => array( 'question' => __( 'Question', 'oneup-motion' ), 'answer' => __( 'Answer', 'oneup-motion' ) ) ),
		),
		'contact'       => array(
			'eyebrow'      => array( 'label' => __( 'Eyebrow', 'oneup-motion' ), 'type' => 'text' ),
			'heading'      => array( 'label' => __( 'Heading', 'oneup-motion' ), 'type' => 'text' ),
			'text'         => array( 'label' => __( 'Text', 'oneup-motion' ), 'type' => 'textarea' ),
			'email'        => array( 'label' => __( 'Email', 'oneup-motion' ), 'type' => 'text' ),
			'phone'        => array( 'label' => __( 'Phone', 'oneup-motion' ), 'type' => 'text' ),
			'button_label' => array( 'label' => __( 'Button label', 'oneup-motion' ), 'type' => 'text' ),
			'button_url'   => array( 'label' => __( 'Button URL', 'oneup-motion' ), 'type' => 'url' ),
		),
		'qr_generator'  => array(
			'eyebrow'               => array( 'label' => __( 'Eyebrow / label', 'oneup-motion' ), 'type' => 'text' ),
			'heading'               => array( 'label' => __( 'Heading', 'oneup-motion' ), 'type' => 'text' ),
			'text'                  => array( 'label' => __( 'Text', 'oneup-motion' ), 'type' => 'textarea' ),
			'tool_intro_text'       => array( 'label' => __( 'Tool intro text', 'oneup-motion' ), 'type' => 'textarea' ),
			'show_surrounding_card' => array( 'label' => __( 'Show surrounding card/panel', 'oneup-motion' ), 'type' => 'checkbox', 'default' => '1' ),
			'layout'                => array( 'label' => __( 'Layout', 'oneup-motion' ), 'type' => 'select', 'choices' => array( 'centered' => __( 'Centered', 'oneup-motion' ), 'two-column' => __( 'Two-column', 'oneup-motion' ), 'full-width' => __( 'Full-width', 'oneup-motion' ) ) ),
			'background_style'      => array( 'label' => __( 'Background style', 'oneup-motion' ), 'type' => 'select', 'choices' => array( 'default' => __( 'Default', 'oneup-motion' ), 'glass' => __( 'Glass', 'oneup-motion' ), 'highlighted' => __( 'Highlighted', 'oneup-motion' ), 'minimal' => __( 'Minimal', 'oneup-motion' ) ) ),
		),
	);
}

//───────────────────────────────────────
// Use OneUp Sections editor
//───────────────────────────────────────
function oum_uses_sections_editor_for_type( $post_type ) {
	if ( 'page' === $post_type ) {
		return '1' === oum_get_theme_option( 'use_sections_for_pages', '1' );
	}

	if ( 'post' === $post_type ) {
		return '1' === oum_get_theme_option( 'enable_post_sections', '0' ) && '1' === oum_get_theme_option( 'replace_post_editor_with_sections', '0' );
	}

	return false;
}

//───────────────────────────────────────
// Disable block editor when sections replace content
//───────────────────────────────────────
function oum_filter_block_editor_for_sections( $use_block_editor, $post_type ) {
	return oum_uses_sections_editor_for_type( $post_type ) ? false : $use_block_editor;
}
add_filter( 'use_block_editor_for_post_type', 'oum_filter_block_editor_for_sections', 10, 2 );

//───────────────────────────────────────
// Hide default content editor
//───────────────────────────────────────
function oum_maybe_remove_default_editor_support() {
	if ( '1' === oum_get_theme_option( 'use_sections_for_pages', '1' ) && '1' === oum_get_theme_option( 'hide_page_content_editor', '1' ) ) {
		remove_post_type_support( 'page', 'editor' );
	}

	if ( oum_uses_sections_editor_for_type( 'post' ) ) {
		remove_post_type_support( 'post', 'editor' );
	}
}
add_action( 'init', 'oum_maybe_remove_default_editor_support', 20 );
add_action( 'admin_init', 'oum_maybe_remove_default_editor_support', 20 );

//───────────────────────────────────────
// Editor notice
//───────────────────────────────────────
function oum_sections_editor_admin_notice() {
	$screen = get_current_screen();

	if ( ! $screen || 'page' !== $screen->post_type || ! oum_uses_sections_editor_for_type( 'page' ) ) {
		return;
	}

	echo '<div class="notice notice-info oum-sections-mode-notice"><p>' . esc_html__( 'OneUp Sections is active for pages. The normal block editor is disabled so this page can be managed with predefined sections.', 'oneup-motion' ) . '</p></div>';
}
add_action( 'admin_notices', 'oum_sections_editor_admin_notice' );

//───────────────────────────────────────
// Register meta boxes
//───────────────────────────────────────
function oum_register_section_metaboxes() {
	if ( '1' === oum_get_theme_option( 'use_sections_for_pages', '1' ) ) {
		add_meta_box( 'oum_page_sections', __( 'OneUp Page Sections', 'oneup-motion' ), 'oum_render_sections_metabox', 'page', 'normal', 'high' );
	}

	if ( '1' === oum_get_theme_option( 'enable_post_sections', '0' ) ) {
		add_meta_box( 'oum_page_sections', __( 'OneUp Post Sections', 'oneup-motion' ), 'oum_render_sections_metabox', 'post', 'normal', 'high' );
	}
}
add_action( 'add_meta_boxes', 'oum_register_section_metaboxes' );

//───────────────────────────────────────
// Admin assets
//───────────────────────────────────────
function oum_enqueue_section_builder_assets( $hook ) {
	if ( ! in_array( $hook, array( 'post.php', 'post-new.php' ), true ) ) {
		return;
	}

	wp_enqueue_media();
	wp_enqueue_style( 'oum-admin', get_template_directory_uri() . '/assets/css/admin.css', array(), oum_asset_version( 'assets/css/admin.css' ) );
	wp_enqueue_script( 'oum-admin-sections', get_template_directory_uri() . '/assets/js/admin-sections.js', array(), oum_asset_version( 'assets/js/admin-sections.js' ), true );
	wp_localize_script( 'oum-admin-sections', 'oumSectionBuilder', array(
		'types'  => oum_section_types(),
		'fields' => oum_section_field_definitions(),
		'i18n'   => array(
			'newSection' => __( 'New Section', 'oneup-motion' ),
			'addItem'    => __( 'Add item', 'oneup-motion' ),
			'remove'     => __( 'Remove', 'oneup-motion' ),
			'chooseImage'=> __( 'Choose image', 'oneup-motion' ),
			'empty'      => __( 'No sections yet. Add your first section to start building this page.', 'oneup-motion' ),
		),
	) );
}
add_action( 'admin_enqueue_scripts', 'oum_enqueue_section_builder_assets' );

//───────────────────────────────────────
// Render meta box
//───────────────────────────────────────
function oum_render_sections_metabox( $post ) {
	wp_nonce_field( 'oum_save_sections', 'oum_sections_nonce' );
	$sections = oum_get_sections( $post->ID );
	?>
	<div class="oum-sections-builder" data-oum-sections-builder>
		<div class="oum-sections-builder__intro">
			<h2><?php echo esc_html__( 'Build with OneUp Sections', 'oneup-motion' ); ?></h2>
			<p><?php echo esc_html__( 'Build this page by adding, reordering and editing predefined sections.', 'oneup-motion' ); ?></p>
		</div>
		<div class="oum-sections-toolbar">
			<select data-oum-section-type>
				<?php foreach ( oum_section_types() as $type => $label ) : ?>
					<option value="<?php echo esc_attr( $type ); ?>"><?php echo esc_html( $label ); ?></option>
				<?php endforeach; ?>
			</select>
			<button type="button" class="button button-primary button-hero" data-oum-add-section><?php echo esc_html__( 'Add Section', 'oneup-motion' ); ?></button>
		</div>
		<p class="oum-sections-empty" data-oum-empty-state <?php echo empty( $sections ) ? '' : 'hidden'; ?>><?php echo esc_html__( 'No sections yet. Add your first section to start building this page.', 'oneup-motion' ); ?></p>
		<div class="oum-sections-list" data-oum-sections-list>
			<?php foreach ( $sections as $index => $section ) : ?>
				<?php oum_render_admin_section_panel( $index, $section ); ?>
			<?php endforeach; ?>
		</div>
	</div>
	<?php
}

//───────────────────────────────────────
// Render admin section
//───────────────────────────────────────
function oum_render_admin_section_panel( $index, $section ) {
	$type    = $section['type'] ?? 'text';
	$fields  = oum_section_field_definitions()[ $type ] ?? array();
	$title   = oum_section_types()[ $type ] ?? __( 'Section', 'oneup-motion' );
	$id      = $section['id'] ?? uniqid( 'oum_', true );
	$summary = '';

	foreach ( array( 'heading', 'title', 'eyebrow' ) as $summary_key ) {
		if ( ! empty( $section[ $summary_key ] ) ) {
			$summary = wp_trim_words( wp_strip_all_tags( $section[ $summary_key ] ), 12 );
			break;
		}
	}
	?>
	<div class="oum-section-panel" data-oum-section>
		<div class="oum-section-panel__header">
			<div class="oum-section-panel__title">
				<strong><?php echo esc_html( $title ); ?></strong>
				<span data-oum-section-summary><?php echo $summary ? esc_html( $summary ) : esc_html__( 'No heading yet', 'oneup-motion' ); ?></span>
			</div>
			<div class="oum-section-panel__controls">
				<button type="button" class="button" data-oum-move-up><?php echo esc_html__( 'Move Up', 'oneup-motion' ); ?></button>
				<button type="button" class="button" data-oum-move-down><?php echo esc_html__( 'Move Down', 'oneup-motion' ); ?></button>
				<button type="button" class="button" data-oum-toggle><?php echo esc_html__( 'Collapse', 'oneup-motion' ); ?></button>
				<button type="button" class="button-link-delete" data-oum-remove><?php echo esc_html__( 'Remove', 'oneup-motion' ); ?></button>
			</div>
		</div>
		<div class="oum-section-panel__body">
			<input type="hidden" name="oum_sections[<?php echo esc_attr( $index ); ?>][type]" value="<?php echo esc_attr( $type ); ?>">
			<input type="hidden" name="oum_sections[<?php echo esc_attr( $index ); ?>][id]" value="<?php echo esc_attr( $id ); ?>">
			<?php foreach ( $fields as $key => $field ) : ?>
				<?php oum_render_admin_section_field( $index, $key, $field, $section[ $key ] ?? '' ); ?>
			<?php endforeach; ?>
		</div>
	</div>
	<?php
}

//───────────────────────────────────────
// Render admin field
//───────────────────────────────────────
function oum_render_admin_section_field( $index, $key, $field, $value ) {
	$name = 'oum_sections[' . esc_attr( $index ) . '][' . esc_attr( $key ) . ']';
	$type = $field['type'] ?? 'text';
	?>
	<div class="oum-section-field oum-section-field--<?php echo esc_attr( $type ); ?>">
		<label>
			<span><?php echo esc_html( $field['label'] ?? $key ); ?></span>
			<?php if ( 'textarea' === $type ) : ?>
				<textarea name="<?php echo esc_attr( $name ); ?>" rows="4"><?php echo esc_textarea( $value ); ?></textarea>
			<?php elseif ( 'select' === $type ) : ?>
				<select name="<?php echo esc_attr( $name ); ?>">
					<?php foreach ( $field['choices'] ?? array() as $choice_value => $choice_label ) : ?>
						<option value="<?php echo esc_attr( $choice_value ); ?>" <?php selected( $value, $choice_value ); ?>><?php echo esc_html( $choice_label ); ?></option>
					<?php endforeach; ?>
				</select>
			<?php elseif ( 'checkbox' === $type ) : ?>
				<?php $checked_value = '' === $value && isset( $field['default'] ) ? $field['default'] : $value; ?>
				<input type="checkbox" name="<?php echo esc_attr( $name ); ?>" value="1" <?php checked( $checked_value, '1' ); ?>>
			<?php elseif ( 'media' === $type ) : ?>
				<input type="hidden" name="<?php echo esc_attr( $name ); ?>" value="<?php echo esc_attr( absint( $value ) ); ?>" data-oum-media-input>
				<button type="button" class="button" data-oum-media-button><?php echo esc_html__( 'Choose image', 'oneup-motion' ); ?></button>
				<button type="button" class="button-link" data-oum-media-clear><?php echo esc_html__( 'Remove', 'oneup-motion' ); ?></button>
				<span class="oum-media-preview" data-oum-media-preview><?php echo $value ? wp_get_attachment_image( absint( $value ), 'thumbnail' ) : ''; ?></span>
			<?php elseif ( 'repeater' === $type ) : ?>
				<?php oum_render_admin_repeater( $index, $key, $field, is_array( $value ) ? $value : array() ); ?>
			<?php else : ?>
				<input type="<?php echo esc_attr( 'url' === $type ? 'url' : 'text' ); ?>" name="<?php echo esc_attr( $name ); ?>" value="<?php echo esc_attr( $value ); ?>">
			<?php endif; ?>
		</label>
	</div>
	<?php
}

//───────────────────────────────────────
// Render admin repeater
//───────────────────────────────────────
function oum_render_admin_repeater( $section_index, $key, $field, $items ) {
	?>
	<div class="oum-repeater" data-oum-repeater="<?php echo esc_attr( $key ); ?>" data-oum-repeater-fields="<?php echo esc_attr( rawurlencode( wp_json_encode( $field['fields'] ?? array() ) ) ); ?>">
		<div class="oum-repeater__items" data-oum-repeater-items>
			<?php foreach ( $items as $item_index => $item ) : ?>
				<div class="oum-repeater__item" data-oum-repeater-item>
					<button type="button" class="button-link-delete" data-oum-repeater-remove><?php echo esc_html__( 'Remove item', 'oneup-motion' ); ?></button>
					<?php foreach ( $field['fields'] as $item_key => $item_label ) : ?>
						<label>
							<span><?php echo esc_html( $item_label ); ?></span>
							<textarea name="oum_sections[<?php echo esc_attr( $section_index ); ?>][<?php echo esc_attr( $key ); ?>][<?php echo esc_attr( $item_index ); ?>][<?php echo esc_attr( $item_key ); ?>]" rows="2"><?php echo esc_textarea( $item[ $item_key ] ?? '' ); ?></textarea>
						</label>
					<?php endforeach; ?>
				</div>
			<?php endforeach; ?>
		</div>
		<button type="button" class="button" data-oum-repeater-add><?php echo esc_html__( 'Add item', 'oneup-motion' ); ?></button>
	</div>
	<?php
}

//───────────────────────────────────────
// Save sections
//───────────────────────────────────────
function oum_save_sections( $post_id ) {
	if ( ! isset( $_POST['oum_sections_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['oum_sections_nonce'] ) ), 'oum_save_sections' ) ) {
		return;
	}

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	$post_type = get_post_type( $post_id );
	if ( 'post' === $post_type && '1' !== oum_get_theme_option( 'enable_post_sections', '0' ) ) {
		return;
	}

	if ( ! isset( $_POST['oum_sections'] ) || ! is_array( $_POST['oum_sections'] ) ) {
		delete_post_meta( $post_id, '_oum_sections' );
		return;
	}

	$raw      = wp_unslash( $_POST['oum_sections'] );
	$sections = oum_sanitize_sections( $raw );

	if ( empty( $sections ) ) {
		delete_post_meta( $post_id, '_oum_sections' );
		return;
	}

	update_post_meta( $post_id, '_oum_sections', $sections );
}
add_action( 'save_post', 'oum_save_sections' );

//───────────────────────────────────────
// Sanitize sections
//───────────────────────────────────────
function oum_sanitize_sections( $raw_sections ) {
	$definitions = oum_section_field_definitions();
	$sections    = array();

	foreach ( $raw_sections as $raw_section ) {
		if ( ! is_array( $raw_section ) ) {
			continue;
		}

		$type = isset( $raw_section['type'] ) ? sanitize_key( $raw_section['type'] ) : '';
		if ( ! isset( $definitions[ $type ] ) ) {
			continue;
		}

		$section = array(
			'type' => $type,
			'id'   => isset( $raw_section['id'] ) ? sanitize_key( $raw_section['id'] ) : uniqid( 'oum_', true ),
		);

		foreach ( $definitions[ $type ] as $key => $field ) {
			$value           = $raw_section[ $key ] ?? '';
			$section[ $key ] = oum_sanitize_section_field( $value, $field );
		}

		$sections[] = $section;
	}

	return $sections;
}

//───────────────────────────────────────
// Sanitize section field
//───────────────────────────────────────
function oum_sanitize_section_field( $value, $field ) {
	$type = $field['type'] ?? 'text';

	if ( 'textarea' === $type ) {
		return wp_kses_post( $value );
	}

	if ( 'url' === $type ) {
		return esc_url_raw( $value );
	}

	if ( 'media' === $type ) {
		return absint( $value );
	}

	if ( 'checkbox' === $type ) {
		return ! empty( $value ) ? '1' : '0';
	}

	if ( 'select' === $type ) {
		$value   = sanitize_key( $value );
		$choices = $field['choices'] ?? array( '' => '' );
		$keys    = array_keys( $choices );
		return array_key_exists( $value, $choices ) ? $value : ( $keys[0] ?? '' );
	}

	if ( 'repeater' === $type ) {
		return oum_sanitize_section_repeater( $value, $field['fields'] ?? array() );
	}

	return sanitize_text_field( $value );
}

//───────────────────────────────────────
// Sanitize repeater
//───────────────────────────────────────
function oum_sanitize_section_repeater( $items, $fields ) {
	if ( ! is_array( $items ) ) {
		return array();
	}

	$clean = array();
	foreach ( $items as $item ) {
		if ( ! is_array( $item ) ) {
			continue;
		}

		$clean_item = array();
		foreach ( $fields as $key => $label ) {
			$value              = $item[ $key ] ?? '';
			$clean_item[ $key ] = false !== strpos( $key, 'url' ) ? esc_url_raw( $value ) : wp_kses_post( $value );
		}
		$clean[] = $clean_item;
	}

	return $clean;
}
