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
use ElasticPress\Feature\RulesBuilder\RegistrationInterface;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

define( 'EP_RULE_POST_TYPE', 'ep-rule' );

/**
 * Rules Builder feature.
 */
class RulesBuilder extends Feature {
	/**
	 * Holds support objects.
	 *
	 * @since 0.1.0
	 *
	 * @var array
	 */
	protected $support = [];

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
		add_action( 'init', [ $this, 'init' ], 20 );
		add_action( 'admin_init', [ $this, 'init_admin' ], 20 );
	}

	/**
	 * Runs on init WP lifecycle hook.
	 *
	 * @since 0.1.0
	 *
	 * @return void
	 */
	public function init() {
		// Supporting classes for the plugin that should be registered on the init hook.
		$this->support = [
			'ep_rule_post_type' => new PostType\RulePostType(),
			'search_support'    => new Search\SearchSupport(),
		];

		// Register objects.
		$this->register_objects( $this->support );
	}

	/**
	 * Initializes admin support.
	 *
	 * @since 0.1.0
	 *
	 * @return void
	 */
	public function init_admin() {
		$this->admin_support = [
			'general_meta_box'  => new Admin\MetaBox\GeneralDetailsMetaBox(),
			'triggers_meta_box' => new Admin\MetaBox\TriggersMetaBox(),
			'actions_meta_box'  => new Admin\MetaBox\ActionsMetaBox(),
		];

		// Register objects.
		$this->register_objects( $this->admin_support );
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

	/**
	 * Registers an array of objects.
	 *
	 * @since 0.1.0
	 *
	 * @param array $objects The array of objects to register.
	 * @return void
	 */
	protected function register_objects( array $objects ) {
		array_map( [ $this, 'register_object' ], $objects );
	}

	/**
	 * Registers a single object.
	 *
	 * @since 0.1.0
	 *
	 * @param object $object The object to register.
	 * @return void
	 */
	protected function register_object( $object ) {
		// Bail early if there are no registration methods.
		if ( ! ( $object instanceof RegistrationInterface ) ) {
			return;
		}

		// Bail early if the object cannot be registered.
		if ( ! $object->can_register() ) {
			return;
		}

		// Register the object.
		$object->register();
	}
}

