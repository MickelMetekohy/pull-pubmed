<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       http://example.com/
 * @since      1.0.0
 *
 * @package    Mkr_Pubmed
 * @subpackage Mkr_Pubmed/public/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<article id="pubmed-<?php echo $pmp->PMID; ?>" class="accordion-item">
  <div class="pm-meta-container">
    <p class="pm-journal-abbr"><b>Journal:</b>
      <abbr title="<?php echo $pmp->journal; ?>"><?php echo $pmp->journal_abbr; ?></abbr> <span class="pm-year"><b>Year:</b> <?php echo $pmp->year; ?></span>
    </p>
    <p class="pm-journal-meta">
      <span class="pm-issue"><b>Issue:</b> <?php echo $pmp->issue; ?></span>
      <span class="pm-volume"><b>Volume:</b> <?php echo $pmp->volume; ?></span>
      <span class="pm-year"><b>Page:</b> <?php echo $pmp->page; ?></span>
    </p>
  </div>
  <div class="pm-title-container">
    <h2 class="pm-title"><a target="_blank" href="<?php echo $pmp->pubmed_url; ?>"><?php echo $pmp->title; ?></a></h2>
  </div>
  <div class="pm-authors-container">
    <p class="pm-authors"><?php echo $pmp->authors; ?></p>
  </div>
  <div class="pm-abstract-container">
    <a href="javascript:void(0);" class="accordion-title pm-title"><b>Abstract</b></a>
    <p class="pm-abstract accordion-content"><?php echo $pmp->abstract; ?></p>
  </div>
</article>
