<?php

/**
 * class-jijianyun-api.php
 * Created on 22/5/27
 * Created by mexingchi
 */
class Jijianyun_Api {

	private static $base_url = 'https://developer.jijyun.cn/api/sdk/';
	private $corp_id;
	private $secret;
	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $jijianyun The ID of this plugin.
	 */
	private $jijianyun;
	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $version The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @param string $jijianyun The name of this plugin.
	 * @param string $version The version of this plugin.
	 *
	 * @since    1.0.0
	 */
	public function __construct( $jijianyun, $version ) {

		$this->jijianyun = $jijianyun;
		$this->version   = $version;
		$this->corp_id = get_option('jijianyun_corp_id', '');
		$this->secret = get_option('jijianyun_api_secret', '');

	}

	public static function createCompany($params) {
		$url            = self::$base_url . 'create_company';
		$current_time   = time();
		$params['timestamp'] = $current_time;
		$params['corp_id'] = get_option('jijianyun_corp_id', '');
		$params['corp_token'] = self::getToken();
		$sign           = self::getSortParams( $params );
		$params['sign'] = $sign;
		$response = wp_remote_post( $url, array(
			'body'    => $params,
			'headers' => array(
				'"Content-Type' => 'application/json'
			),
		) );
		$response = json_decode( $response, true );
		//var_dump($params);die;
		if ( $response['code'] == 0 ) {
			return true;
		} else {
			return $response;
		}
	}

	public static function getToken() {
		$corp_token_json = file_get_contents( plugin_dir_path( __FILE__ ) . 'corp_token.json' );
		if ( $corp_token_json ) {
			$corp_token_array = json_decode( $corp_token_json, true );
			if ( $corp_token_array['corp_token'] && $corp_token_array['expires_time'] > time() - 5 * 60 ) {
				return $corp_token_array['corp_token'];
			}
		}
		$url          = self::$base_url . 'corp_token';
		$current_time = time();
		$params       = [
			'timestamp' => $current_time,
			/*'secret'    => self::$secret,*/
			'corp_id'   => get_option('jijianyun_corp_id', ''),
		];
		$sign         = self::getSortParams( $params );
		$params['sign'] = $sign;
		$response = wp_remote_post( $url, array(
			'body'    => $params,
			'headers' => array(
				'"Content-Type' => 'application/json'
			),
		) );
		$response = json_decode( $response['data'], true );
		if ( $response['code'] == 0 ) {
			file_put_contents( plugin_dir_path( __FILE__ ) . 'corp_token.json',
			                   json_encode( [
				                                'corp_token'   => $response['data']['corp_token'],
				                                'expires_time' => time() + $response['data']['expires_in'] - 5 * 60,
			                                ] ) );

			return $response['data']['corp_token'];
		} else {
			return false;
		}
	}

	/**
	 * 参数排序
	 *
	 * @param array $param
	 *
	 * @return string
	 */
	private static function getSortParams( $param = [] ) {
		unset( $param['sign'] );
		unset( $param['secret'] );
		ksort( $param );
		$signstr = '';
		if ( is_array( $param ) ) {
			foreach ( $param as $key => $value ) {
				if ( $value == '' ) {
					continue;
				}
				if ( is_array( $value ) ) {
					$value = json_encode( $value );
				}
				$signstr .= $key . '=' . $value . '&';
			}
			$signstr = rtrim( $signstr, '&' );
		}

		return md5( get_option('jijianyun_api_secret', '') . $signstr );
	}
}