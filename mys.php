<?php

/*
Plugin Name: My Settings
Author: Victor4g, vishaljp
Author URI: http://just4u.x10.bz
Plugin URI: http://vishaljp.wordpress.com
Version: 1.0
Description: Plugin Allows you to change default email settings, login url, redirect url after login, hide plugin and theme editor from sub menu, highlight all the tags and post specific tags in the post and page descriptions using apply your custom html, add custom footer text which is shown through wp_footer(), hide the admin tool bar for all users at front side.

This file is part of My Settings.

My Settings is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License.

My Settings is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with My Settings. If not, see .

*/

function mys_admin_bar(){

		echo "<link rel='stylesheet' href='".WP_PLUGIN_URL."/My-settings/mys.css' type='text/css' media='all' />";

		if(get_option('mys_hide_bar') == 'hide')
		show_admin_bar(false);
}

function mys_global_custom_options()
{
	// Add sub-menu
	add_menu_page('My Settings', 'My Settings','administrator', 'mys', '', plugins_url('My-settings/download.png'), '4');
	add_submenu_page( 'mys', 'Manage', 'Manage', 'administrator', 'mys', 'global_custom_options' );
}

function mys_email_from(){
	return get_option('mys_email_from');
}

function mys_email_from_name(){
	return get_option('mys_email_sender');
}

function mys_footer() {
	echo '<div class="mys_footer">'.get_option('mys_footer').'</div>';
}

function mys_remove_menu_elements()
{
	if(get_option('mys_hide_theme_edt') == 'hide')
	remove_submenu_page( 'themes.php', 'theme-editor.php' );

	if(get_option('mys_hide_plugin_edt') == 'hide')
	remove_submenu_page( 'plugins.php', 'plugin-editor.php' );

}

function mys_remove_menu_items( $menu_order ){
	global $menu, $wp_roles;
	// check using the new capability with current_user_can
	foreach ( $menu as $mkey => $m ) {
	
	$keyA = array_search( 'admin.php?page=mys', $m );
	$keyB = array_search( 'edit.php', $m );
	
	if ( $keyA || $keyB)
	unset( $menu[$mkey] );
	}
	return $menu_order;
}

function global_custom_options(){

?>
	<div id="profile-page" class="wrap" >
	<h2>My Settings</h2>
	<div >
	<h3>Email Settings</h3>

	<form method="post" action="options.php">
	<?php wp_nonce_field('update-options');?>

	<table class="form-table" width="100%">
	<tbody>
	<tr>
	<td class="left" width="27%">From Email:</td>
	<td class="left"><input type="text" name="mys_email_from" size="45" value="<?php echo get_option('mys_email_from'); ?>" /></td>
	<td class="left"></td>
	</tr>
	<tr>
	<td class="left">Sender Name:</td>
	<td class="left"><input type="text" name="mys_email_sender" size="45" value="<?php echo get_option('mys_email_sender'); ?>" /></td>
	<td class="left"></td>
	</tr>
	<tr>
	<td class="left"></td>
	<td class="left" colspan="2"><span class="description"> Default Email address is (wordpress@yourdomainname.com) and Sender name is WordPress.</span></td>
	</tr>
	</tbody>
	</table>
	<h3>Login Settings</h3>
	<table class="form-table" width="100%">
	<tbody>
	<tr>
	<td class="left" width="27%">New Login URL:</td>
	<td class="left"><input type="text" name="mys_login_url" size="45" value="<?php echo get_option('mys_login_url'); ?>" /></td>
	<td class="left"></td>
	</tr>
	<tr>
	<td class="left">Login Redirect URL:</td>
	<td class="left"><input type="text" name="mys_login_rurl" size="45" value="<?php echo get_option('mys_login_rurl'); ?>" /></td>
	<td class="left"></td>
	</tr>
	<tr>
	<td class="left">Logout Redirect URL:</td>
	<td class="left"><input type="text" name="mys_logout_url" size="45" value="<?php echo get_option('mys_logout_url'); ?>" /></td>
	<td class="left"></td>
	</tr>
	<tr>
	<td class="left"></td>
	<td class="left" colspan="2"><span class="description"> Change Login URL for custom login page and Redirect URL for redirect after login and logout.</span></td>
	</tr>
	</tbody>
	</table>
	<h3>Admin Editor Settings</h3>
	<table class="form-table" width="100%">
	<tbody>
	<tr>
	<td class="left" width="27%">Hide Theme Editor Submenu:</td>
	<td class="left"><input type="checkbox" name="mys_hide_theme_edt" value="hide" <?php if(get_option('mys_hide_theme_edt') == 'hide') echo 'checked' ;?>/></td>
	<td class="left"></td>
	</tr>
	<tr>
	<td class="left">Hide Plugin Editor Submenu:</td>
	<td class="left"><input type="checkbox" name="mys_hide_plugin_edt" value="hide" <?php if(get_option('mys_hide_plugin_edt') == 'hide') echo 'checked' ;?>/></td>
	<td class="left"></td>
	</tr>
	<tr>
	<td class="left"></td>
	<td class="left" colspan="2"><span class="description"> This will for all Users.</span></td>
	</tr>
	</tbody>
	</table>
	<h3>Tag Settings</h3>
	<table class="form-table" width="100%">
	<tbody>
	<tr>
	<td class="left" width="27%">Highlight Tags in Display:</td>
	<td class="left" colspan="2"><input type="checkbox" name="mys_show_tag" value="show" <?php if(get_option('mys_show_tag') == 'show') echo 'checked' ;?>/><span class="description"> Post specific</span></td>
	</tr>
	<tr>
	<td class="left">Highlight All Posts Tags in Display:</td>
	<td class="left"><input type="checkbox" name="mys_show_tag_all" value="show" <?php if(get_option('mys_show_tag_all') == 'show') echo 'checked' ;?>/></td>
	<td class="left"></td>
	</tr>
	<tr>
	<td class="left">Apply to Pages:</td>
	<td class="left"><input type="checkbox" name="mys_show_tag_page" value="show" <?php if(get_option('mys_show_tag_page') == 'show') echo 'checked' ;?>/><br><span class="description">Work if above All Posts Tags check box is checked</span></td>
	<td class="left"></td>
	</tr>
	<tr>
	<td class="left"></td>
	<td class="left">HTML Before Tag :
	<input type="text" name="mys_before_tag" size="45" value="<?php echo get_option('mys_before_tag'); ?>" /></td>
	<td class="left">HTML After Tag :
	<input type="text" name="mys_after_tag" size="45" value="<?php echo get_option('mys_after_tag'); ?>" /></td>
	</tr>
	<tr>
	<td class="left"></td>
	<td class="left" colspan="2"><span class="description"> This should work only for the_content() and the_excerpt().</span></td>
	</tr>
	</tbody>
	</table>
	<h3>Other Settings</h3>
	<table class="form-table" width="100%">
	<tbody>
	<tr>
	<td class="left" width="27%">Show This Plugin to Admin Only :</td>
	<td class="left"><input type="checkbox" name="mys_show_to_admin" value="show" <?php if(get_option('mys_show_to_admin') == 'show') echo 'checked' ;?>/></td>
	<td class="left"></td>
	</tr>
	<tr>
	<td class="left">Hide Toolbar for all Users:</td>
	<td class="left"><input type="checkbox" name="mys_hide_bar" id="mys_abar" value="hide" <?php if(get_option('mys_hide_bar') == 'hide') echo 'checked' ;?>/></td>
	<td class="left"></td>
	</tr>
	<tr>
	<td class="left">Footer Text:</td>
	<td class="left" colspan="2"><input type="text" name="mys_footer" size="45" value="<?php echo get_option('mys_footer'); ?>" /><span class="description"> This will display text through wp_footer()</span></td>
	</tr>

	<tr>
	<th class="left"></th>
	<td align="left"><input type="hidden" name="action" value="update" /> 
					<input type="hidden" name="page_options" value="mys_email_from, mys_email_sender, mys_login_url, mys_login_rurl, mys_hide_theme_edt, mys_hide_plugin_edt, mys_show_tag, mys_show_tag_all, mys_before_tag, mys_after_tag, mys_show_to_admin, mys_hide_bar, mys_footer, mys_show_tag_page,mys_logout_url" /></td>
	<td align="left"><input class="save_all button-primary" type="submit" name="Submit" value="Save Options"/></td>
	</tr>
	</tbody>
	</table>
	</div >
	</div >
	<br style="clear: both;" />

<?php
}

function mys_replace_custom_word($test){
	global $post;
if ( 'page' == get_post_type() && get_option('mys_show_tag_page') != 'show'){
	return $test;
}

if(get_option('mys_show_tag_all')=='show'){
	$ptags = get_tags();
}else if(get_option('mys_show_tag')=='show'){
	$ptags = get_the_tags();
}
	$test = get_the_content(); 

		if(get_option('mys_before_tag')!='' && get_option('mys_after_tag')!='' && is_array($ptags)){
			foreach($ptags as $k => $v){
				$test = str_ireplace($v->name, get_option("mys_before_tag").$v->name.get_option("mys_after_tag"), $test);		
			} 
		}
	return $test;
}

function mys_login_url( $force_reauth, $redirect ){

	if(get_option('mys_login_url')!='')
		$login_url = get_option('mys_login_url');
	else
		$login_url = site_url('wp-login.php', 'login');
	
	if ( $force_reauth )
		$login_url = add_query_arg( 'reauth', '1', $login_url ) ;
	
	if(get_option('mys_login_rurl')!=''){
		$redirect = get_option('mys_login_rurl');
		$login_url = add_query_arg( 'redirect_to', urlencode( $redirect ), $login_url );
	}

	return $login_url ;
}

function mys_logout_redirect(){
 	wp_safe_redirect( get_option('mys_logout_url') );
    die();
}

	if(get_option('mys_logout_url') != '')
	add_action( 'wp_logout', 'mys_logout_redirect', 10 );
		
	if(get_option('mys_show_tag') == 'show' || get_option('mys_show_tag_all') == 'show'){
		add_filter('the_content', 'mys_replace_custom_word');
		add_filter('the_excerpt', 'mys_replace_custom_word');
	}

	if(get_option('mys_show_to_admin') != 'show')
	add_filter('menu_order', 'mys_remove_menu_items' );
	add_action('admin_init', 'mys_remove_menu_elements', 102);
	add_action('wp_head', 'mys_admin_bar');
	add_action('wp_footer', 'mys_footer', 22);
	add_filter('wp_mail_from','mys_email_from');
	add_filter('wp_mail_from_name','mys_email_from_name');
	add_action('admin_menu', 'mys_global_custom_options');
	add_filter( 'login_url', 'mys_login_url', 10, 2);

?>