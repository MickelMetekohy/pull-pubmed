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
  <h1>All Publications</h1>
  <div class="meta-box-sortables ui-sortable">
    <form method="POST">
      <?php
      $this->publications_obj->prepare_items();
      $this->publications_obj->display(); ?>
    </form>
  </div>
</div>
