<?php
/**
 * ElasticPress Rules Builder feature.
 *
 * @since  2.4
 * @package elasticpress
 */

namespace ElasticPress\Feature\RulesBuilder;

use ElasticPress\Utils as Utils;
use ElasticPress\Feature as Feature;
use ElasticPress\Features as Features;
use ElasticPress\FeatureRequirementsStatus as FeatureRequirementsStatus;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Rules Builder feature.
 */
class RulesBuilder extends Feature {

	/**
	 * Initialize feature setting it's config
	 *
	 * @since  3.0
	 */
	public function __construct() {
		$this->slug  = 'rules_builder';
		$this->title = esc_html__( 'Rules Builder', 'elasticpress' );

		parent::__construct();
	}

	/**
	 * Setup all feature filters
	 *
	 * @since  2.4
	 */
	public function setup() {

	}

	/**
	 * Output feature box summary
	 *
	 * @since 2.4
	 */
	public function output_feature_box_summary() {
		?>
		<p><?php esc_html_e( 'Rules Builder for ElasticPress.', 'elasticpress' ); ?></p>
		<?php
	}

	/**
	 * Output feature box long
	 *
	 * @since 2.4
	 */
	public function output_feature_box_long() {
		?>
		<p><?php echo wp_kses_post( __( 'Rules Builder for ElasticPress.', 'elasticpress' ) ); ?></p>
		<?php
	}


	/**
	 * Determine feature reqs status
	 *
	 * @since  2.4
	 * @return FeatureRequirementsStatus
	 */
	public function requirements_status() {
		$status = new FeatureRequirementsStatus( 0 );

		/**
		 * @todo Check here for dynamic scripting
		 */
		if ( ! Utils\is_epio() ) {
			$status->code    = 1;
			$status->message = __( "You aren't using <a href='https://elasticpress.io'>ElasticPress.io</a> so we can't be sure your Elasticsearch instance is secure.", 'elasticpress' );
		}

		return $status;
	}
}

