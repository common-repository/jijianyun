<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Jijianyun
 * @subpackage Jijianyun/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Jijianyun
 * @subpackage Jijianyun/admin
 * @author     Your Name <email@example.com>
 */
class Jijianyun_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $jijianyun    The ID of this plugin.
	 */
	private $jijianyun;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $jijianyun       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $jijianyun, $version ) {

		$this->jijianyun = $jijianyun;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Jijianyun_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Jijianyun_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->jijianyun, plugin_dir_url( __FILE__ ) . 'css/jijianyun-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Jijianyun_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Jijianyun_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->jijianyun, 'https://cdn.jijyun.cn/t/site316/index-sdk.js', array(), $this->version, false );
		wp_enqueue_script( $this->jijianyun, plugin_dir_url( __FILE__ ) . 'js/jijianyun-admin.js', array( 'jquery' ), $this->version, false );

    }

	public function jijianyun_options_page() {
		$tmpl = plugin_dir_path(__FILE__) . 'views\view.php';
		add_menu_page(
			'集简云',
			'集简云',
			'manage_options',
			'jijianyun',
			array( 'Jijianyun_Admin' ,'jijianyun_options_page_html'),
			null,
			'dashicons-admin-settings', //或者使用 plugin_dir_url(__FILE__) . 'images/icon_jijianyun.png'
			20
		);
		add_submenu_page(
			'jijianyun',
			'流程模板',
			'流程模板',
			'manage_options',
			'jijianyun_pipeline-template',
			array( 'Jijianyun_Admin' ,'jijianyun_options_page_html')
		);
		add_submenu_page(
			'jijianyun',
			'数据流程',
			'数据流程',
			'manage_options',
			'jijianyun_data-pipeline',
			array( 'Jijianyun_Admin' ,'jijianyun_options_page_html')
		);
		add_submenu_page(
			'jijianyun',
			'流程日志',
			'流程日志',
			'manage_options',
			'jijianyun_data-log',
			array( 'Jijianyun_Admin' ,'jijianyun_options_page_html')
		);
		add_submenu_page(
			'jijianyun',
			'应用管理',
			'应用管理',
			'manage_options',
			'jijianyun_app-manage',
			array( 'Jijianyun_Admin' ,'jijianyun_options_page_html')
		);
	}

	function jijianyun_options_page_html(){
		Jijianyun_Admin::view( 'view');
	}

	public static function view( $name, array $args = array() ) {

		$args = apply_filters( 'view_arguments', $args, $name );

		foreach ( $args AS $key => $val ) {
			$$key = $val;
		}

		$file = plugin_dir_path(__FILE__) . 'views/'. $name . '.php';

		include( $file );
	}

	function jijianyun_settings_init() {
		// register a new setting for jijianyun page
		register_setting( 'jijianyun', 'jijianyun_options' );

		// register a new section in the jijianyun page
		add_settings_section(
			'jijianyun_section_developers',
			__( 'The Matrix has you.', 'jijianyun' ),
			['Jijianyun_Admin','jijianyun_section_developers_cb'],
			'jijianyun'
		);

		// register a new field in the jijianyun_section_developers section, inside the jijianyun page
		add_settings_field(
			'jijianyun_field_pill', // as of WP 4.6 this value is used only internally
			// use $args' label_for to populate the id inside the callback
			__( 'Pill', 'jijianyun' ),
			['Jijianyun_Admin','jijianyun_field_pill_cb'],
			'jijianyun',
			'jijianyun_section_developers',
			[
				'label_for'         => 'jijianyun_field_pill',
				'class'             => 'jijianyun_row',
				'jijianyun_custom_data' => 'custom',
			]
		);
	}

	function jijianyun_section_developers_cb( $args ) {
		?>
		<p id=<?php echo esc_attr( $args[ 'id' ] ); ?>><?php esc_html_e( 'Follow the white rabbit.', 'jijianyun' ); ?></p>
		<?php
	}
	function jijianyun_field_pill_cb( $args ) {
		// get the value of the setting we've registered with register_setting()
		$options = get_option( 'jijianyun_options' );
		// output the field
		?>
		<select id=<?php echo esc_attr( $args[ 'label_for' ] ); ?>
		        data-custom=<?php echo esc_attr( $args[ 'jijianyun_custom_data' ] ); ?>
		        name=jijianyun_options[<?php echo esc_attr( $args[ 'label_for' ] ); ?>]
		>
			<option value=red <?php echo isset( $options[ $args[ 'label_for' ] ] ) ? ( selected( $options[ $args[ 'label_for' ] ], 'red', false ) ) : ( '' ); ?>>
				<?php esc_html_e( 'red pill', 'jijianyun' ); ?>
			</option>
			<option value=blue <?php echo isset( $options[ $args[ 'label_for' ] ] ) ? ( selected( $options[ $args[ 'label_for' ] ], 'blue', false ) ) : ( '' ); ?>>
				<?php esc_html_e( 'blue pill', 'jijianyun' ); ?>
			</option>
		</select>
		<p class=description>
			<?php esc_html_e( 'You take the blue pill and the story ends. You wake in your bed and you believe whatever you want to believe.', 'jijianyun' ); ?>
		</p>
		<p class=description>
			<?php esc_html_e( 'You take the red pill and you stay in Wonderland and I show you how deep the rabbit-hole goes.', 'jijianyun' ); ?>
		</p>
		<?php
	}
}
