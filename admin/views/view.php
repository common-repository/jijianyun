<?php
/**
 * 保存处理
 */
$formSubmit  = sanitize_text_field( $_POST['formSubmit'] );
$formSubmit1 = sanitize_text_field( $_POST['formSubmit1'] );
$clear       = sanitize_text_field( $_POST['clear'] );

if ( isset( $clear ) && $clear != '' ) {
	delete_option( 'jijianyun_company_name' );
	delete_option( 'jijianyun_company_identification' );
	delete_option( 'jijianyun_user_name' );
	delete_option( 'jijianyun_user_identify' );
	delete_option( 'jijianyun_email' );
	delete_option( 'jijianyun_mobile' );

} else {
	$company_name = get_option( 'jijianyun_company_name', '' );

	$user_name = get_option( 'jijianyun_user_name', '' );

	$email  = get_option( 'jijianyun_email', '' );
	$mobile = get_option( 'jijianyun_mobile', '' );
	if ( $company_name ) {
		$readOnly = true;
	} else {
		$readOnly = false;
	}
}

if ( isset( $formSubmit1 ) && $formSubmit1 != '' ) {
	if ( check_admin_referer( 'jijianyun_save_nonce1' ) && current_user_can( 'manage_options' ) ) {

		$secret                 = sanitize_text_field( $_POST['secret'] );
		$corp_id                = sanitize_text_field( $_POST['corp_id'] );
		$user_identify          = sanitize_text_field( $_POST['user_identify'] );
		$company_identification = sanitize_text_field( $_POST['company_identification'] );
		$cfg_id                 = sanitize_text_field( $_POST['cfg_id'] );

		update_option( 'jijianyun_api_secret', $secret );
		update_option( 'jijianyun_corp_id', $corp_id );
		update_option( 'jijianyun_company_identification', $company_identification );
		update_option( 'jijianyun_user_identify', $user_identify );
		update_option( 'jijianyun_cfg_id', $cfg_id );

		echo '<div id="message" class="updated fade"><p>保存成功</p></div>';

	}
} else {
	$secret                 = get_option( 'jijianyun_api_secret', '' );
	$corp_id                = get_option( 'jijianyun_corp_id', '' );
	$company_identification = get_option( 'jijianyun_company_identification', '' );
	$user_identify          = get_option( 'jijianyun_user_identify', '' );
	$cfg_id                 = get_option( 'jijianyun_cfg_id', '' );
}
?>
<?php
$page = sanitize_text_field($_GET['page']);
if ( $page == 'jijianyun' ) {
	?>
    <div class="wrap">
        <h2>集简云嵌入方案设置</h2>
        <div class="publish-config-box">
            <h3>基本信息设置</h3>
            <div>
                <form id="configForm" method="post" action="admin.php?page=jijianyun">
                    <table width="100%" class="config-table">
                        <tr>
                            <td>corp_id:</td>
                            <td><input type="text" name="corp_id" class="config-input" value="<?php
								echo esc_textarea( $corp_id ); ?>"/>
                            </td>
                        </tr>
                        <tr>
                            <td>secret:</td>
                            <td><input type="text" name="secret" class="config-input" value="<?php
								echo esc_textarea( $secret ); ?>"/>（密钥）
                            </td>
                        </tr>
                        <tr>
                            <td>company_identification:</td>
                            <td><input type="text" name="company_identification" class="config-input" value="<?php
								echo esc_textarea( $company_identification ); ?>"/>（客户（嵌入方的）身份唯一标识）
                            </td>
                        </tr>
                        <tr>
                            <td>user_identify:</td>
                            <td><input type="text" name="user_identify" class="config-input" value="<?php
								echo esc_textarea( $user_identify ); ?>"/>（用户唯一识别ID）
                            </td>
                        </tr>
                        <tr>
                            <td>cfg_id:</td>
                            <td><input type="text" name="cfg_id" class="config-input" value="<?php
								echo esc_textarea( $cfg_id ); ?>"/>（页面配置ID）
                            </td>
                        </tr>

                        <tr>
                            <td><input type="submit" name="formSubmit1" value="保存更改" class="button-primary"/></td>
                        </tr>
                    </table>
					<?php
					wp_nonce_field( 'jijianyun_save_nonce1' );
					?>
                </form>
            </div>
        </div>
        <div class="publish-config-box" style="display:none;">
            <h3>申请企业</h3>
            <div>
                <form id="configForm" method="post" action="admin.php?page=jijianyun">
                    <table width="100%" class="config-table">
                        <tr>
                            <td width="15%">company_name：</td>
                            <td><input type="text" name="company_name" class="config-input" <?php
								echo $readOnly == true ? 'readonly' : ''; ?> value="<?php
								echo esc_textarea( $company_name ); ?>"/>（客户（嵌入方的）名称）
                            </td>
                        </tr>
                        <tr>
                            <td>user_name:</td>
                            <td><input type="text" name="user_name" class="config-input" <?php
								echo $readOnly == true ? 'readonly' : ''; ?> value="<?php
								echo esc_textarea( $user_name ); ?>"/>（客户（嵌入方的）身份唯一标识）
                            </td>
                        </tr>
                        <tr>
                            <td>email:</td>
                            <td><input type="text" name="email" class="config-input" <?php
								echo $readOnly == true ? 'readonly' : ''; ?> value="<?php
								echo esc_textarea( $email ); ?>"/>（用户邮箱）
                            </td>
                        </tr>
                        <tr>
                            <td>mobile:</td>
                            <td><input type="text" name="mobile" class="config-input" <?php
								echo $readOnly == true ? 'readonly' : ''; ?> value="<?php
								echo esc_textarea( $mobile ); ?>"/>（用户手机号）
                            </td>
                        </tr>
                        <tr>
                            <td><input type="submit" name="formSubmit" value="提交" class="button-primary" <?php
								echo $readOnly == true ? 'disabled' : ''; ?> /></td>
                            <td><input type="submit" name="clear" style="display: none;" value="清空"
                                       class="button-default" <?php
								echo $readOnly == true ? 'disabled' : ''; ?> /></td>
                        </tr>
                    </table>
					<?php
					wp_nonce_field( 'jijianyun_save_nonce' );
					?>
                </form>
            </div>
        </div>
        <div class="info-box">
            <h3>简介和使用教程</h3>
            <div>
                <table width="100%" class="config-table">
                    <tr>
                        <td width="15%">产品功能介绍</td>
                        <td>
                            <div class="feature">集简云WordPress
                                SDK集成插件可以在WordPress产品内设置自动化业务流程，连接您的WordPress数据与其他数百款应用系统，构建自动化的业务流程。
                            </div>
                            <div class="feature">在使用集简云WordPress SDK集成插件前，您需要在集简云官网（<a href="https://jijyun.cn"
                                                                                       target="_blank">https://jijyun.cn</a>）注册账号并开通开发者权限后方可正常使用此插件。
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>联系我们</td>
                        <td>
                            <div class="feature">您可以扫码下方二维码与我们联系：</div>
                            <div class="feature"><img width="237px" height="auto"
                                                      src="https://download.jijyun.cn/wordpress-chat.png"></div>
                        </td>
                    </tr>
                    <tr>
                        <td>SDK插件设置</td>
                        <td>
                            <div class="feature">以下为信息需要联系我们的工作人员开通开发者权限后获取：</div>
                            <div class="feature">CropID</div>
                            <div class="feature">APISecrect</div>
                            <div class="feature">UserID</div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
	<?php
} else {
	$frame = str_replace( 'jijianyun_', '', $page );
	?>
    <div id="jijyun_file" style="width: 99%;height: 800px;padding-top: 20px;"></div>
    <script>
        const {jijyunConnect} = window.JijyunJSSDK;
        jijyunConnect({
            secret: '<?php echo esc_attr(get_option( 'jijianyun_api_secret', '' ));?>',//从集简云开发者平台获取
            corp_id: '<?php echo esc_attr(get_option( 'jijianyun_corp_id', '' ));?>',//从集简云开发者平台获取
            company_identification: '<?php echo esc_attr(get_option( 'jijianyun_company_identification', '' ));?>',
            user_identify: '<?php echo esc_attr(get_option( 'jijianyun_user_identify', '' ));?>',//用户唯一识别码ID
            cfg_id: '<?php echo esc_attr(get_option( 'jijianyun_cfg_id', '' ));?>',//页面配置
            src: 'https://local.windeal.cn:8443/',
            pageType: '<?php echo esc_attr($frame); ?>',//pipeline-template（流程模板）、data-pipeline（数据流程）、data-log（流程日志）、app-manage（应用管理）
            container: document.querySelector('#jijyun_file') // iframe 挂载的目标容器元素
        }).then((jijyunSDK) => {
            // ...
        })
    </script>
	<?php
}
?>
<style>
    .publish-config-box h3 {
        font-size: 16px;
        padding: 10px 10px;
        margin: 0;
        line-height: 1;
    }

    .config-table {
        background-color: #FFFFFF;
        font-size: 14px;
        padding: 15px 20px;
    }

    .config-table td {
        height: 35px;
        padding-left: 10px;
    }

    .config-input {
        width: 320px;
    }

    .info-box h3 {
        font-size: 15px;
        padding: 10px 10px;
        margin: 0;
        line-height: 1;
    }

    .feature {
        padding-top: 5px;
    }
</style>


