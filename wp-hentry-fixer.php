<?php
/*
Plugin Name: WP Hentry Fixer
Plugin URI: https://github.com/michaeldoye/wp-hentry-fixer
Description: Fixes missing hentry errors for single posts and archive pages.
Author: Web SEO Online (PTY) LTD
Author URI: https://webseo.co.za
Version: 0.0.1

	Copyright: © 2016 Web SEO Online (PTY) LTD (email : michael@webseo.co.za)
	License: GNU General Public License v3.0
	License URI: http://www.gnu.org/licenses/gpl-3.0.html
*/

/**
 * Make sure class doesn't already exist
 */
	
if ( ! class_exists( 'HentryFixer' ) ) {
	
	/**
	 * Localisation
	 **/
	load_plugin_textdomain( 'HentryFixer', false, dirname( plugin_basename( __FILE__ ) ) . '/' );

	class HentryFixer {

	    /**
	     * constructor
	     */
		public function __construct() {
			add_filter( 'the_content', array( $this, 'hatom_data_in_content'), 100 );	            			
		}

		/**
		 * hatom_data_in_content
		 * Checks post type and injects hatom data.
		 * @param string $content - html post content
		 * @return string 
		 **/
		public function hatom_data_in_content( $content ) {
			if ( is_single() || is_archive() || is_home() ) $content .= $this->get_hatom_data();
			return $content;
		}
		 
		/**
		 * get_hatom_data
		 * Contstructs hatom/hentry markup for post content
		 * @return string 
		 **/
		private function get_hatom_data() {
		    $html  = '<div class="hatom-extra" style="display:none;visibility:hidden;">';
		    $html .= '<span class="entry-title">'.get_the_title().'</span>';
		    $html .= '<span class="updated"> '.get_the_modified_time('F jS, Y').'</span>';
		    $html .= '<span class="author vcard"><span class="fn">'.get_the_author().'</span></span></div>';
		    return $html;
		}
	}
	
	// finally instantiate our plugin class and add it to the set of globals
	$GLOBALS['HentryFixer'] = new HentryFixer();
}

