<!DOCTYPE html>
<html <?php language_attributes(); ?> class="tco-ui-theme-<?php echo $data['theme'];?>">
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php echo $data['title']; ?></title>
<?php
  wp_enqueue_scripts();
  wp_print_styles();
  wp_print_head_scripts();
?>
</head>
<body <?php echo $data['body_classes']; ?>>
  <div class="tco-loader-canvas is-fixed is-active">
    <div class="tco-loader is-absolute is-mega is-active">&hellip;</div>
  </div>
  <?php
    wp_print_footer_scripts();
    wp_admin_bar_render();
    wp_auth_check_html();

    if ( function_exists( 'wp_underscore_playlist_templates' ) && function_exists( 'wp_print_media_templates' ) ) {
      wp_underscore_playlist_templates();
      wp_print_media_templates();
    }
  ?>
</body>
</html>
