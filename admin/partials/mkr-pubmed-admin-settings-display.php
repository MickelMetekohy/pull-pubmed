<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://example.com/
 * @since      1.0.0
 *
 * @package    Mkr_Pubmed
 * @subpackage Mkr_Pubmed/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="wrap">
  <h1>Publications Settings</h1>
  <?php settings_errors(); ?>
  <form method="POST" action="options.php">
    <?php settings_fields( 'mkr-pubmed-settings-group' ); ?>
    <?php do_settings_sections ( 'publications-settings' ); ?>
    <?php submit_button(); ?>
  </form>
</div>
