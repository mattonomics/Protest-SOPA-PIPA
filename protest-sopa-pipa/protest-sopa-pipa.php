<?php
/*
Plugin Name: Protest SOPA/PIPA
Author: Matt Gross
Description: This plugin displays a SOPA/PIPA protest message on 1/18/12 from 8am-8pm EST. After that time the message will no longer display and the plugin will automatically deactivate itself.
License: GPLv2
Version: 1.0
*/

/*  Copyright 2012  Matt Gross  (email : mattonomics@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

// I give you the gift of protest.

new protest_sopa_pipa;

class protest_sopa_pipa {
	public $start = "2012-01-18 08:00:00 -05:00"; // 1/18/2012 8am EST
	public $end = "2012-01-18 20:00:00 -05:00"; // 1/18/2012 8pm EST

	public function __construct() {
		$time = time();	
		$start = strtotime($this->start);
		$end = strtotime($this->end);
		
		if ( ( $time > $start ) && ( $time < $end ) )
			$this->on();
		elseif ( $time > $end )
			$this->off();
	}
	
	public function on() {
		add_action( 'init', array( &$this, 'hooks' ) );
	}
	
	public function hooks() {
		add_action( 'wp_footer', array( &$this, 'html' ), 100 );
		add_action( 'wp_footer', array( &$this, 'onPageScript' ), 100 );
		add_action( 'wp_enqueue_scripts', array( &$this, 'scripts' ) );
	}
	
	public function html() {
		$site = defined( 'WP_ALLOW_MULTISITE' ) && WP_ALLOW_MULTISITE ? network_site_url() : site_url();
		$site = untrailingslashit( $site );
		?><div id="protest-sopa-pipa-background">
			<div id="protest-sopa-pipa-container">
				<div class="protest-sopa-pipa-font" id="protest-sopa-pipa-header"><?php _e( 'STOP SOPA', 'protest-sopa-pipa' ); ?></div>
				<div id="protest-sopa-pipa-content">
					<h2 id="protest-sopa-pipa-warning" class="protest-sopa-pipa-font"><?php _e( 'CENSORED', 'protest-sopa-pipa' ); ?></h2>
					<p><?php esc_html_e( 'The United States Congress has proposed legislation that has the potential to destroy the free and open internet as we know it. This legislation, called SOPA in the House and PIPA in the Senate, is the epitome of special interests over the greater public good.', 'protest-sopa-pipa' ); ?></p>
					<p><?php esc_html_e( 'It is of the utmost importance that all citizens who value their constitutional right to the freedom of speech and who believe in the free exchange of ideas, take a stand against SOPA/PIPA. No longer can we stand by as our elected leaders cave to the whims of the few as the many are forced into bondage and suffering.', 'protest-sopa-pipa' ); ?></p>
					<p><?php esc_html_e( "It is for this reason that ", 'protest-sopa-pipa' ); echo "<strong>$site</strong>"; esc_html_e( " will be participating in the Internet Blackout today, January 18th, from 8am-8pm EST. We have chosen to stand in solidarity against the forces who wish to censor and otherwise control the flow of information on the internet.", 'protest-sopa-pipa' ) ?></p>
					<p><?php esc_html_e( "Additionally, we encourage you to inform yourself about the damaging consequences of passing such dangerous legislation. We also encourage you to call, email or write your congressperson and inform them that you will not sit idly by while they undermine the free internet.", 'protest-sopa-pipa' ); ?></p>
					<p><?php esc_html_e( 'Below, you will find resources that will help you understand the devastating consequences of SOPA/PIPA. You will also find information on how to contact your elected leaders.', 'protest-sopa-pipa' ); ?></p>
					<p><?php esc_html_e( 'If we stand in solidarity against SOPA/PIPA, we can defeat it and in doing so alter the course of human history. Please, take action now.', 'protest-sopa-pipa' ); ?></p>
					<ol>
						<li><a href="http://projects.propublica.org/sopa/"> <?php esc_html_e( 'Click here to find out where your member of Congress stands on this issue.', 'protest-sopa-pipa' ); ?></a></li>
						<li><a href="http://www.house.gov/representatives/"><?php esc_html_e( 'Click here for a list of Representatives and their contact number. Call them and express your concern about SOPA and PIPA.', 'protest-sopa-pipa' ); ?></a></li>
						<li><p><?php esc_html_e( 'Find out what others have to say about SOPA/PIPA:', 'protest-sopa-pipa' ); ?></p>
							<ul>
								<li><a href="http://www.cdt.org/report/growing-chorus-opposition-stop-online-piracy-act"><?php esc_html_e( 'A comprehensive list of opinions about SOPA/PIPA from sources such as the inventors of the internet, The Heritage Foundation, the ACLU and many others.', 'protest-sopa-pipa' ); ?></a></li>
								<li><a href="http://wordpress.org/news/2012/01/help-stop-sopa-pipa/"><?php esc_html_e( 'A great write up from WordPress, along with a video that makes SOPA/PIPA easy to understand.', 'protest-sopa-pipa' ); ?></a></li>
								<li><a href="http://boingboing.net/2011/12/02/stephen-colbert-explains-sopa.html"><?php esc_html_e( 'A very hilarious video from Stephen Colbert that satirizes the utter insanity of SOPA/PIPA.', 'protest-sopa-pipa' ); ?></a></li>
							<ul>
						</li>
					</ol>
				</div>
			</div>
		</div><?php
	}
	
	public function onPageScript() {
		?><script type="text/javascript">
			jQuery(document).ready(function(){
				var docHeight = jQuery(document).height();
				var contentHeight = jQuery('#protest-sopa-pipa-content').height();
				var cssHeight = docHeight > contentHeight ? docHeight : contentHeight;
				jQuery('#protest-sopa-pipa-background').css({
					'height' : cssHeight + 'px'
					// keeping this space for more, just in case :)
				});
			});
		</script><?php
	}
	
	public function scripts() {
		wp_register_style( 'protest-sopa-pipa', plugins_url( 'protest-sopa-pipa.css', __FILE__ ) );
		wp_enqueue_style( 'protest-sopa-pipa' );
		wp_enqueue_script( 'jquery' );
	}
	
	public function off() {
		add_action( 'admin_init', array( &$this, 'turnOff' ) );
	}
	
	public function turnOff() {
		deactivate_plugins( basename( dirname( __FILE__ ) ) . "/" . basename( __FILE__ ) );
	}
}

?>