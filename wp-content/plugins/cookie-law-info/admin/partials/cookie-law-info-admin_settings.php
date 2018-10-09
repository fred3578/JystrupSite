<?php
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}
$cli_admin_view_path=plugin_dir_path(CLI_PLUGIN_FILENAME).'admin/views/';
$cli_img_path=CLI_PLUGIN_URL . 'images/';
$plugin_name = 'wtgdprcookieconsent';
$cli_activation_status=get_option($plugin_name.'_activation_status');
?>
<script type="text/javascript">
    var cli_settings_success_message='<?php echo __('Settings updated.', 'cookie-law-info');?>';
    var cli_settings_error_message='<?php echo __('Unable to update Settings.', 'cookie-law-info');?>';
    var cli_reset_settings_success_message='<?php echo __('Settings reset to defaults.', 'cookie-law-info');?>';
    var cli_reset_settings_error_message='<?php echo __('Unable to reset settings.', 'cookie-law-info');?>';
</script>
<div class="wrap">
    <h2 class="wp-heading-inline"><?php _e('Cookie Law Settings', 'cookie-law-info'); ?></h2>
    
    <table class="cli_notify_table cli_bar_state">
        <tr valign="middle" class="cli_bar_on" style="<?php echo $the_options['is_on'] == true ? '' : 'display:none;';?>">
            <th scope="row" style="padding-left:15px;">
                <label><img id="cli-plugin-status-icon" src="<?php echo $cli_img_path;?>tick.png" /></label>
            </th>
            <td style="padding-left: 10px;">
                <?php _e('Your Cookie Law Info bar is switched on', 'cookie-law-info'); ?>
            </td>
        </tr>
        <tr valign="middle" class="cli_bar_off" style="<?php echo $the_options['is_on'] == true ? 'display:none;' : '';?>">
            <th scope="row" style="padding-left:15px;">
                <label><img id="cli-plugin-status-icon" src="<?php echo $cli_img_path;?>cross.png" /></label>
            </th>
            <td style="padding-left: 10px;">
                <?php _e('Your Cookie Law Info bar is switched off', 'cookie-law-info'); ?>
            </td>
        </tr>
    </table>


    <div class="cli_settings_left">
        <div class="nav-tab-wrapper wp-clearfix cookie-law-info-tab-head">
            <a class="nav-tab" href="#cookie-law-info-general"><?php _e('General', 'cookie-law-info'); ?></a>
            <a class="nav-tab" href="#cookie-law-info-message-bar"><?php _e('Customise Cookie Bar', 'cookie-law-info'); ?></a>
            <a class="nav-tab" href="#cookie-law-info-buttons"><?php _e('Customise Buttons', 'cookie-law-info'); ?></a>
            <a class="nav-tab" href="#cookie-law-info-advanced"><?php _e('Advanced', 'cookie-law-info'); ?></a>
            <a class="nav-tab" href="#cookie-law-info-help"><?php _e('Help Guide', 'cookie-law-info'); ?></a>
        </div>
        <div class="cookie-law-info-tab-container">
            <form method="post" action="<?php echo esc_url($_SERVER["REQUEST_URI"]);?>" id="cli_settings_form">
                <input type="hidden" name="cli_update_action" value="" id="cli_update_action" />
                <?php
                // Set nonce:
                if (function_exists('wp_nonce_field'))
                {
                    wp_nonce_field('cookielawinfo-update-' . CLI_SETTINGS_FIELD);
                }
                $setting_views_a=array(
                    'admin-settings-general.php',
                    'admin-settings-messagebar.php',
                    'admin-settings-buttons.php',                      
                    'admin-settings-advanced.php',          
                );
                $setting_views_b=array(           
                    'admin-settings-help.php',           
                );
                foreach ($setting_views_a as $value) 
                {
                    $settings_view=$cli_admin_view_path.$value;
                    if(file_exists($settings_view))
                    {
                        include $settings_view;
                    }
                }
                ?>            
            </form>
            <?php
            foreach ($setting_views_b as $value) 
            {
                $settings_view=$cli_admin_view_path.$value;
                if(file_exists($settings_view))
                {
                    include $settings_view;
                }
            }
            ?>
        </div>
    </div>
    <div class="cli_settings_right">
     <?php include $cli_admin_view_path."goto-pro.php"; ?>   
    </div>

</div>