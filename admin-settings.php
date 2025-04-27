<?php
// Add plugin settings page in WordPress Dashboard
function bvn_plugin_menu()
{
    add_options_page(
        'BVN Validation Settings',
        'BVN Validation',
        'manage_options',
        'bvn-validation-plugin',
        'bvn_plugin_settings_page'
    );
}
add_action('admin_menu', 'bvn_plugin_menu');

// Plugin settings page HTML
function bvn_plugin_settings_page()
{
?>
    <div class="wrap">
        <h1>BVN Validation Settings</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('bvn_settings_group');
            do_settings_sections('bvn-validation-plugin');
            ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">Enable API Verification</th>
                    <td>
                        <input type="checkbox" name="enable_api_verification" value="1" <?php checked(get_option('enable_api_verification'), 1); ?> />
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">API Key</th>
                    <td>
                        <input type="text" name="bvn_api_key" value="<?php echo esc_attr(get_option('bvn_api_key')); ?>" />
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">Select API Provider</th>
                    <td>
                        <select name="bvn_api_provider">
                            <option value="paystack" <?php selected(get_option('bvn_api_provider'), 'paystack'); ?>>Paystack</option>
                            <option value="flutterwave" <?php selected(get_option('bvn_api_provider'), 'flutterwave'); ?>>Flutterwave</option>
                            <option value="monnify" <?php selected(get_option('bvn_api_provider'), 'monnify'); ?>>Monnify</option>
                        </select>
                    </td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
<?php
}

// Register plugin settings
function bvn_plugin_settings()
{
    register_setting('bvn_settings_group', 'enable_api_verification');
    register_setting('bvn_settings_group', 'bvn_api_key');
    register_setting('bvn_settings_group', 'bvn_api_provider');
}
add_action('admin_init', 'bvn_plugin_settings');
