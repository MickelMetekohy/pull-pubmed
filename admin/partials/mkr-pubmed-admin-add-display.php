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

<?php
if( isset($_POST['mkr-pubmed-add-publication']) ) {
  $this->mkr_pubmed_add_publication();
}
?>


<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<div class="wrap">
  <h1>Add Publications</h1>
  <?php // settings_errors(); ?>
  <form method="POST" action="">
    <?php settings_fields( 'mkr-pubmed-add-group' ); ?>
    <?php do_settings_sections ( 'publications-add' ); ?>
    <?php submit_button( 'Add Publication' ); ?>
  </form>

  <h2>Last added publication</h2>
  <?php if($last_added = $this->mkr_pubmed_get_latest_publication()) : ?>
    <p><strong>PMID:</strong> <?php echo $last_added->PMID; ?></p>
    <p><strong>Journal:</strong> <?php echo $last_added->journal; ?><br>
    <strong>Journal Abbreviation:</strong> <?php echo $last_added->journal_abbr; ?></p>
    <p><strong>Volume:</strong> <?php echo $last_added->volume; ?><br>
    <strong>Issue:</strong> <?php echo $last_added->issue; ?><br>
    <strong>Page:</strong> <?php echo $last_added->page; ?><br>
    <strong>Year:</strong> <?php echo $last_added->year; ?></p>
    <p><strong>Authors:</strong> <?php echo $last_added->authors; ?></p>
    <p><strong>Url:</strong><a href="<?php echo $last_added->pubmed_url; ?>" target="_blank"> <?php echo $last_added->pubmed_url; ?></a></p>
    <p><strong>Title:</strong> <?php echo $last_added->title; ?></p>
    <p><strong>Abstract:</strong> <?php echo $last_added->abstract; ?></p>
  <?php endif; ?>
</div>
