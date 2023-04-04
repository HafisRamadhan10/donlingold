<?php

class Cornerstone_Settings_Handler extends Cornerstone_Plugin_Component {

	public function ajax_save( $data ) {

		if ( ! current_user_can( 'manage_options' ) ) {
			return cs_send_json_error();
		}

    if ( isset( $data['permissions'] ) ) {

      $permissions = json_decode( wp_unslash($data['permissions']), true );

      if ( is_null( $permissions ) ) {
        return cs_send_json_error(array('Unable to decode permissions', $data['permissions']));
      }

      $save_permissions = $this->plugin->component('App_Permissions')->update_stored_permissions( $permissions );

      if ( is_wp_error( $save_permissions ) ) {
        return cs_send_json_error( $save_permissions );
      }

      unset($data['permissions']);

    }

		if ( is_wp_error( $data ) ) {
			return cs_send_json_error( $data );
		}

		$settings = CS()->settings();

    if ( isset( $data['custom_app_slug'] ) ) {
      $settings['custom_app_slug'] = sanitize_title_with_dashes( $data['custom_app_slug'] );
    }

		if ( isset( $data['hide_access_path'] ) ) {
			$settings['hide_access_path'] = is_bool($data['hide_access_path']) ? $data['hide_access_path'] : $data['hide_access_path'] === 'true';
		}

		update_option( 'cornerstone_settings', $settings );

		return cs_send_json_success();

	}

}
