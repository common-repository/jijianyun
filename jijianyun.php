<?php

/**
 * 集简云sdk嵌入插件文件
 *
 * @link              https://www.jijyun.cn/
 * @since             1.0.0
 * @package           jijianyun
 *
 * @wordpress-plugin
 * Plugin Name:       集简云（SDK嵌入）
 * Version:           19.1
 * Plugin URI:        https://www.jijyun.cn/
 * Description:       集简云无代码软件集成平台，通过无代码集成方式连接数百款软件无需API接口开发即可建立企业自动化业务流程。包括抖音，企业微信，钉钉，用友YonSuite系统，金蝶云星空，企业数据库，企业API接口等大型企业系统等实现数据互通。

 * Author:            集简云
 * Author URI:        https://www.jijyun.cn/
 * Text Domain:     wordpress-jijianyun
 * Domain Path:       /languages
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.html
 * Requires PHP: 5.6.20

 */


// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'JIJIANYUN_VERSION', '19.1.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-jijianyun-activator.php
 */
function activate_jijianyun() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-jijianyun-activator.php';
	Jijianyun_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-jijianyun-deactivator.php
 */
function deactivate_jijianyun() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-jijianyun-deactivator.php';
	Jijianyun_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_jijianyun' );
register_deactivation_hook( __FILE__, 'deactivate_jijianyun' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-jijianyun.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_jijianyun() {

	$plugin = new Jijianyun();
	$plugin->run();

}
run_jijianyun();
