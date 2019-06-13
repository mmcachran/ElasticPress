<?php // @codingStandardsIgnoreLine
/**
 * Class to create the general metabox.
 *
 * @package ElasticPress
 */

namespace ElasticPress\Feature\RulesBuilder\Admin\MetaBox;

/**
 * Creates the general metabox.
 */
class GeneralDetailsMetaBox extends AbstractMetaBox {
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
		return EP_RULES_BUILDER_METABOX_PREFIX . 'general';
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

					'description' => new \Fieldmanager_Textfield(
						[
							'label'            => esc_html__( 'Description', 'elasticpress' ),
							'description'      => esc_html__( 'Description for the rule (only used for reference).', 'elasticpress' ),
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

					'start_date'  => new \Fieldmanager_Datepicker(
						[
							'label'       => esc_html__( 'Start Date', 'elasticpress' ),
							'description' => esc_html__( 'Date for the rule to start.', 'elasticpress' ),
						]
					),

					'end_date'    => new \Fieldmanager_Datepicker(
						[
							'label'       => esc_html__( 'End Date', 'elasticpress' ),
							'description' => esc_html__( 'Date for the rule to end.', 'elasticpress' ),
						]
					),
				],
			]
		);

		// Add the metabox.
		$fm->add_meta_box( esc_html__( 'General Settings', 'ep-rules-builder' ), $this->get_post_types() );
	}
}
