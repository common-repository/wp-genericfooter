<?php
/*
Plugin Name: WP-GenericFooter
Version: 0.2
Plugin URI: http://nothing.golddave.com/wp-genericfooter-plugin/
Description: Allows the blog admin to designate a footer that will appear in all posts for all blog members.
Author: David Goldstein
Author URI: http://nothing.golddave.com/
*/

/*
Change Log

0.2
  * Added fade effect on ‘Options saved.’ message.


0.1
  * First public test release.
  
*/

$current_footer = get_option('generic_footer_options');

function generic_footer($data) {
	global $current_footer;
	$data=stripslashes($data.'<p><i>'.$current_footer["footer_text"].'</i></p>');
	return $data;
}

// Create the options page
function generic_footer_options_page() { 
	$current_footer = get_option('generic_footer_options');
	if ($_POST['action']){ ?>
		<div id="message" class="updated fade"><p><strong>Options saved.</strong></p></div>
	<?php } ?>
	<div class="wrap" id="generic-footer-options">
		<h2>WP-GenericFooter Options</h2>
		<p>This is where you specify the text you'd like to use as your footer.</p>

		<form method="post" action="<?php echo $_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING']; ?>">
			<fieldset>
				<legend>Options:</legend>
				<input type="hidden" name="action" value="save_options" />
				<table width="100%" cellspacing="2" cellpadding="5" class="editform">
					<tr>
						<th valign="top" scope="row"><label for="footer_text">Footer text:</label></th>
						<td><textarea type="text" name="footer_text" rows="3" cols="60" /><?php echo stripslashes($current_footer["footer_text"]); ?></textarea></td>
					</tr>
				</table>
			</fieldset>
			<p class="submit">
				<input type="submit" name="Submit" value="Update Options &raquo;" />
			</p>
		</form>
	</div>
<?php 
}

function generic_footer_add_options_page() {
	// Add a new menu under Options:
	add_options_page('WP-GenericFooter', 'WP-GenericFooter', 10, __FILE__, 'generic_footer_options_page');
}

function generic_footer_save_options() {
	// create array
	$generic_footer_options["footer_text"] = $_POST["footer_text"];
	
	update_option('generic_footer_options', $generic_footer_options);
	$options_saved = true;
}

add_filter('the_content', 'generic_footer', 1);
add_action('admin_menu', 'generic_footer_add_options_page');

if (!get_option('generic_footer_options')){
	// create default options
	$generic_footer_options["footer_text"] = 'This is a sample footer.  This text can be customized from the options page.  Good luck.';
	
	update_option('generic_footer_options', $generic_footer_options);
}

if ($_POST['action'] == 'save_options'){
	generic_footer_save_options();
}

?>