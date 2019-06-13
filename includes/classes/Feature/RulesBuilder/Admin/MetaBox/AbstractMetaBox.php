<?php // @codingStandardsIgnoreLine
/**
 * Base class for meta boxes.
 *
 * @package ElasticPress Rules Builder
 */

namespace ElasticPress\Feature\RulesBuilder\Admin\MetaBox;

use ElasticPress\Feature\RulesBuilder\RegistrationInterface;

/**
 * Abstract class for metabox classes to extend.
 */
abstract class AbstractMetaBox implements RegistrationInterface {
	/**
	 * Determines if the metabox should be registered.
	 *
	 * @since 0.1.0
	 *
	 * @return bool True if the metabox should be registered, false otherwise.
	 */
	public function can_register() {
		return true;
	}

	/**
	 * Register hooks for the metabox.
	 *
	 * @since 0.1.0
	 *
	 * @return bool
	 */
	abstract public function register();

	/**
	 * Initializes the metabox.
	 *
	 * @since 0.1.0
	 *
	 * @return void
	 */
	abstract public function get_metabox();

	/**
	 * Get numeric operator.
	 *
	 * @since 0.1.0
	 *
	 * @return array  Operator options.
	 */
	protected function get_numeric_operator_options() {
		return [
			'equals'                 => esc_html__( 'Equals', 'elasticpress' ),
			'does_not_equal'         => esc_html__( 'Does not equal', 'elasticpress' ),
			'equals_or_greater_than' => esc_html__( 'Equals or greater than', 'elasticpress' ),
			'equals_or_less_than'    => esc_html__( 'Equals or less than', 'elasticpress' ),
			'greater_than'           => esc_html__( 'Greater than', 'elasticpress' ),
			'less_than'              => esc_html__( 'Less than', 'elasticpress' ),
		];
	}

	/**
	 * Get string operators.
	 *
	 * @since 0.1.0
	 *
	 * @return array  Operator options.
	 */
	protected function get_string_operator_options() {
		return [
			'contains'         => esc_html__( 'Contains', 'elasticpress' ),
			'does_not_contain' => esc_html__( 'Does not contain', 'elasticpress' ),
			'is'               => esc_html__( 'Is', 'elasticpress' ),
			'is_not'           => esc_html__( 'Is not', 'elasticpress' ),
			'is_in'            => esc_html__( 'Is in', 'elasticpress' ),
			'is_not_in'        => esc_html__( 'Is not in', 'elasticpress' ),
		];
	}
}
