<?php // @codingStandardsIgnoreLine
/**
 * Class to create the actions metabox.
 *
 * @package ElasticPress
 */

namespace ElasticPress\Feature\RulesBuilder\Admin\MetaBox;

/**
 * Creates the actions metabox.
 */
class ActionsMetaBox extends AbstractMetaBox {
	/**
	 * Determines if the metabox should be registered.
	 *
	 * @since 0.1.0
	 *
	 * @return bool True if the metabox should be registered, false otherwise.
	 */
	public function can_register() {
		return class_exists( '\Fieldmanager_Group' );
	}

	/**
	 * Register hooks for the metabox.
	 *
	 * @since 0.1.0
	 *
	 * @return void
	 */
	public function register() {
		// Register the agenda metabox for all allowed post types.
		foreach ( $this->get_post_types() as $post_type ) {
			add_action( "fm_post_{$post_type}", [ $this, 'get_metabox' ] );
		}
	}

	/**
	 * Returns the post types this metabox should be registered to.
	 *
	 * @since 0.1.0
	 *
	 * @return array The post types to register the metabox to.
	 */
	protected function get_post_types() {
		return [
			EP_RULE_POST_TYPE,
		];
	}

	/**
	 * Get the name for the metabox.
	 *
	 * @since 0.1.0
	 *
	 * @return string The name for the base metabox.
	 */
	protected function get_metabox_name() {
		return EP_RULES_BUILDER_METABOX_PREFIX . 'actions';
	}

	/**
	 * Initializes the metabox.
	 *
	 * @since 0.1.0
	 *
	 * @return void
	 */
	public function get_metabox() {
		$fm = new \Fieldmanager_Group(
			[
				'name'     => $this->get_metabox_name(),
				'children' => [
					'actions' => $this->get_actions_metabox(),
				],
			]
		);

		// Add the metabox.
		$fm->add_meta_box( esc_html__( 'Actions', 'elasticpress' ), $this->get_post_types() );
	}

	/**
	 * Returns the actions metabox group.
	 *
	 * @since 0.1.0
	 *
	 * @return \Fieldmanager_Group The actions metabox group.
	 */
	protected function get_actions_metabox() {
		return new \Fieldmanager_Group(
			[
				'label'          => esc_html__( 'Actions', 'elasticpress' ),
				'label_macro'    => array( 'Action: %s', 'title' ),
				'add_more_label' => esc_html__( 'Add Another Action', 'elasticpress' ),
				'limit'          => 0,
				'sortable'       => true,
				'collapsible'    => true,
				'extra_elements' => 0,
				'children'       => [

					'title'    => new \Fieldmanager_Textfield(
						[
							'label'            => esc_html__( 'Title', 'elasticpress' ),
							'description'      => esc_html__( 'Optional title for the action.', 'elasticpress' ),
							'field_class'      => 'text',
							'validation_rules' => [
								'required' => false,
							],
							'attributes'       => [
								'maxlength' => 80,
								'size'      => 60,
							],
						]
					),

					'type'     => new \Fieldmanager_Select(
						[
							'label'   => esc_html__( 'Type', 'elasticpress' ),
							'options' => [
								'boost' => esc_html__( 'Boost', 'elasticpress' ),
								'bury'  => esc_html__( 'Bury', 'elasticpress' ),
								'hide'  => esc_html__( 'Hide', 'elasticpress' ),
							],
						]
					),

					'boost'    => new \Fieldmanager_Textfield(
						[
							'label'            => esc_html__( 'Boost', 'elasticpress' ),
							'field_class'      => 'text',
							'input_type'       => 'number',
							'validation_rules' => [
								'required' => false,
							],
							'attributes'       => [
								'maxlength' => 80,
								'size'      => 60,
							],
							'display_if'       => [
								'src'   => 'type',
								'value' => 'boost',
							],
						]
					),

					'bury'     => new \Fieldmanager_Textfield(
						[
							'label'            => esc_html__( 'Bury', 'elasticpress' ),
							'field_class'      => 'text',
							'input_type'       => 'number',
							'validation_rules' => [
								'required' => false,
							],
							'attributes'       => [
								'maxlength' => 80,
								'size'      => 60,
							],
							'display_if'       => [
								'src'   => 'type',
								'value' => 'bury',
							],
						]
					),

					'hide'     => new \Fieldmanager_Textfield(
						[
							'label'            => esc_html__( 'Hide', 'elasticpress' ),
							'field_class'      => 'text',
							'validation_rules' => [
								'required' => false,
							],
							'attributes'       => [
								'maxlength' => 80,
								'size'      => 60,
							],
							'display_if'       => [
								'src'   => 'type',
								'value' => 'hide',
							],
						]
					),

					'field'    => new \Fieldmanager_Select(
						[
							'label'      => esc_html__( 'Field', 'elasticpress' ),
							'options'    => $this->get_action_field_options(),
							'display_if' => [
								'src'   => 'type',
								'value' => 'boost,bury',
							],
						]
					),

					'operator' => new \Fieldmanager_Select(
						[
							'label'      => esc_html__( 'Operator', 'elasticpress' ),
							'options'    => $this->get_string_operator_options(),
							'display_if' => [
								'src'   => 'type',
								'value' => 'boost,bury',
							],
						]
					),

					'text'     => new \Fieldmanager_Textfield(
						[
							'label'            => esc_html__( 'Text', 'elasticpress' ),
							'field_class'      => 'text',
							'validation_rules' => [
								'required' => false,
							],
							'attributes'       => [
								'maxlength' => 80,
								'size'      => 60,
							],
							'display_if'       => [
								'src'   => 'type',
								'value' => 'boost,bury',
							],
						]
					),

				],
			]
		);
	}

	/**
	 * Gets a list of action field options.
	 *
	 * @return array Action field options.
	 */
	protected function get_action_field_options() {
		return [
			'post_title'   => esc_html__( 'Title', 'ep-rules-builder' ),
			'post_content' => esc_html__( 'Content', 'ep-rules-builder' ),
			'post_excerpt' => esc_html__( 'Excerpt', 'ep-rules-builder' ),
			'post_name'    => esc_html__( 'Slug', 'ep-rules-builder' ),
		];
	}
}
