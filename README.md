#PULL pubmed

Wordpress-plugin
Plugin Name:       PULL PUBMED  
Description:       This wordpress plugin grabs data related to a PMID from Pubmed.  
Version:           1.0.0  
Author:            Mickel Metekohy  
License:           GPL-2.0+  
License URI:       http://www.gnu.org/licenses/gpl-2.0.txt  
Text Domain:       mkr-pubmed  
Domain Path:       /languages  

## Description

This wordpress plugin is based on the wordpress plugin boilerplate at http://wppb.me

Plugin creates an extra table in the database to store the publications.

The plugin grabs data related to a PMID from Pubmed one at a time.
Data is printed through a short code, with a preconfigured template.
There is no post type created, all publications are printed on one page in the
order that they where published on pubmed.

Publications are displayed in the the backend with an extension of the WP_List_Table class.
