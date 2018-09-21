<?php
$G_Data = Advanced_Ads_AdSense_Data::get_instance();
$adsense_id = $G_Data->get_adsense_id();
$mapi_options = Advanced_Ads_AdSense_MAPI::get_option();
$MAPI = Advanced_Ads_AdSense_MAPI::get_instance();
$use_user_app = Advanced_Ads_AdSense_MAPI::use_user_app();
$quota = $MAPI->get_quota();
$can_connect = $use_user_app || 0 < $quota['count'];
$can_connect = true;
$ad_units = $mapi_options['accounts'][$adsense_id]['ad_units'];
?>
<div id="mapi-wrap">
	<button type="button" id="mapi-close-selector" class="notice-dismiss"></button>
	<div id="mapi-wrap-inner">
		<label class="label"><?php _e( 'AdSense Ad Unit', 'advanced-ads' ); ?><i id="mapi-get-adunits" class="dashicons dashicons-update" style="cursor:pointer;margin-left:.3em;color:#008ec2;" title="<?php echo esc_attr( __( 'Update ad units list', 'advanced-ads' ) ); ?>"></i></label>
		<div>
			<select id="mapi-adunit-select">
				<?php if ( empty( $ad_units ) ) : ?>
				
					<option value=""><?php _e( 'No ad unit found', 'advanced-ads' ); ?></option>
					
				<?php else : $sorted_adunits = Advanced_Ads_AdSense_MAPI::get_sorted_adunits( $ad_units ); ?>
					
					<option value=""><?php _e( '--select ad--', 'advanced-ads' ) ?></option>
					<?php foreach ( $sorted_adunits as $key => $value ) : ?>
					 <option value="<?php echo esc_attr( $key ); ?>"><?php echo $value; ?></option>
					<?php endforeach; ?>
					
				<?php endif; ?>
			</select>
			
			<button class="button-secondary prevent-default" disabled <?php if ( !$can_connect ) echo 'disabled="disabled"' ?> id="mapi-get-adcode"><?php _e( 'Update Details', 'advanced-ads' ); ?></button>
		</div>
		
		<p class="advads-error-message" id="remote-ad-code-error" style="display:none;"><strong><?php _e( 'Unrecognized ad code', 'advanced-ads' ); ?></strong></p>
		<p class="advads-error-message" id="remote-ad-code-msg"></p>
		<div style="display:none;" id="remote-ad-unsupported-ad-type"><p><i class="dashicons dashicons-warning"></i><b class="advads-error-message"><?php 
		    _e( 'This ad type can currently not be imported from AdSense.', 'advanced-ads' ) ?></b>&nbsp;<a href="<?php echo ADVADS_URL . 'adsense-ad-type-not-available/#utm_source=advanced-ads&utm_medium=link&utm_campaign=adsense-type-not-available'; ?>" target="_blank"><?php 
		    _e( 'Learn more and help us to enable it here.', 'advanced-ads' ) ?></a></p>
		    <?php _e( 'In the meantime, you can use AdSense with one of these methods:', 'advanced-ads' ) ?>
		    <ul>
			<li><?php _e( 'Click on <em>Insert new AdSense code</em> and copy the code from your AdSense account into it.', 'advanced-ads' ) ?></li>
			<li><?php _e( 'Create an ad on the fly. Just select the <em>Normal</em> or <em>Responsive</em> type and the size.', 'advanced-ads' ) ?></li>
			<li><?php _e( 'Choose a <em>Normal</em>, <em>Responsive</em> or <em>Link Unit</em> ad from your AdSense account.', 'advanced-ads' ) ?></li>
		    </ul>
		</div>
		<p id="mapi-quota-message"></p>
		
	</div>
</div>

<div id="mapi-loading-overlay" style="position:absolute;background-color:rgba(255,255,255,.75);top:0;right:0;bottom:0;left:0;text-align:center;display:none;">
	<img alt="..." src="<?php echo ADVADS_BASE_URL . 'admin/assets/img/loader.gif'; ?>" style="margin-top:8em;" />
</div>
<script type="text/javascript">jQuery( document ).trigger( 'mapi-selector-loaded' ); </script>