<?php

function tt_page_admin() { // Our function (as seen above) that runs when the page is accessed
    $tt_hidden_field_name = 'tt_submit_hidden';
	
	 if (get_option('tt_style_name')) {} else { add_option('tt_style_name', 'classic'); }
	$tt_style_field = 'tt_style_field';
	$tt_style_option = 'tt_style_name';
	$tt_style_value = get_option($tt_style_option); // Read in existing option value from database
	
	$tt_fpw_field = 'tt_fpw_field';
	$tt_fpw_option = 'tt_fpw_name';
	$tt_fpw_value = get_option($tt_fpw_option);
	$tt_fpw = "s3gv4h";
	
	$tt_footer_field = 'tt_footer_field';
	$tt_footer_option = 'tt_footer_opt';
	$tt_footer_value = get_option($tt_footer_option);
	
	// twitter
	$tt_twitter_field = 'tt_twitter_field';
	$tt_twitter_option = 'tt_twitter_name';
	
	// twitter get value
	$tt_twitter_value = get_option($tt_twitter_option); // Read in existing option value from database
	
	
	// layout field names
	$tt_logo_field = 'tt_logo_field';
	$tt_header_field = 'tt_header_field';
	$tt_header_page_field = 'tt_header_page_field';
	$tt_header_title_field = 'tt_header_title_field';
	$tt_header_para_field = 'tt_header_para_field';
	
	// layout
	$tt_logo_opt = 'tt_logo_opt';
	$tt_header_opt = 'tt_header_opt';
	$tt_header_page_opt = 'tt_header_page_opt';
	$tt_header_title_opt = 'tt_header_title_opt';
	$tt_header_para_opt = 'tt_header_para_opt';
	
	// layout values 
	$tt_logo_value = get_option($tt_logo_opt);
	$tt_header_value = get_option($tt_header_opt);
	$tt_header_page_value = get_option($tt_header_page_opt);
	$tt_header_title_value = get_option($tt_header_title_opt);
	$tt_header_para_value = get_option($tt_header_para_opt);
	
    if( $_POST[ $tt_hidden_field_name ] == 'yes' ) { // If form has been sumbitted
		//twitter
        $tt_twitter_value = $_POST[ $tt_twitter_field ]; 
        update_option($tt_twitter_option, $tt_twitter_value);
		
		$tt_style_value = $_POST[ $tt_style_field ];
        update_option($tt_style_option, $tt_style_value);
		
		//layout
		$tt_logo_value = $_POST[ $tt_logo_field ]; 
		update_option($tt_logo_opt, $tt_logo_value);
		
		$tt_header_value = $_POST[ $tt_header_field ]; 
		update_option($tt_header_opt, $tt_header_value);
		
		$tt_header_page_value = $_POST[ $tt_header_page_field ]; 
		update_option($tt_header_page_opt, $tt_header_page_value);
		
		$tt_header_title_value = $_POST[ $tt_header_title_field ]; 
		update_option($tt_header_title_opt, $tt_header_title_value);
		
		$tt_header_para_value = $_POST[ $tt_header_para_field ]; 
		update_option($tt_header_para_opt, $tt_header_para_value);
		
		
		$tt_footer_value = $_POST[ $tt_footer_field ]; // Read value from post
        update_option($tt_footer_option, $tt_footer_value); // Save value in database
		
		$tt_fpw_entered = $_POST[ $tt_fpw_field ];
		if (get_option('tt_fpw_name') == 'unlocked') {} else {
		if ($tt_fpw_entered == $tt_fpw) {
			$currenturl = get_bloginfo(url) . '/wp-admin/themes.php?page=tt_admin';
        	update_option($tt_fpw_option, 'unlocked');
			?>
            <script type="text/JavaScript">
			<!--
			function timedRefresh(timeoutPeriod) {
				setTimeout("location.reload(true);",timeoutPeriod);
			}
			timedRefresh(1000);
			//   -->
			</script>
            <?php
			echo '<div class="updated"><p><h3>The license PIN you entered is correct. You will be re-directed in a moment. If not, <a href="' . $currenturl . '">click here.</a></h3></p></div>';
		}
		}

?>
<div class="updated"><p><strong><?php _e('Your options have been saved.', 'mt_trans_domain' ); ?></strong></p></div>
<?php

    }
	// Main screen:
    echo '<div class="wrap">';
	screen_icon();
    echo "<h2>" . __( 'Edit Skin - Thesis Themes', 'mt_trans_domain' ) . "</h2>"; // header
    
    ?>

<form name="form1" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
<input type="hidden" name="<?php echo $tt_hidden_field_name; ?>" value="yes">



<div style="background: #f1f1f1; padding: 10px; border: 1px solid #dadada; -moz-border-radius: 3px; -webkit-border-radius: 3px; margin-top: 10px; max-width: 650px;">
<h3 style="font-size: 1.5em; text-align: center; margin-top: .2em;">User Info</h3>

<table class="form-table">
<tr valign="top">
<th><strong><?php _e("Twitter Username:", 'mt_trans_domain' ); ?></strong></th><td>
<input type="text" name="<?php echo $tt_twitter_field; ?>" value="<?php echo $tt_twitter_value; ?>" size="30" style="padding: 5px; margin-left: 5px;">
</td>
</tr>
</table>
</div>

<?php 

include("tt_styles.php"); 

?>

<div style="background: #f1f1f1; padding: 10px; border: 1px solid #dadada; -moz-border-radius: 3px; -webkit-border-radius: 3px; margin-top: 10px; max-width: 650px;">
<h3 style="font-size: 1.5em; text-align: center; margin-top: .2em;">Layout Options</h3>

<table class="form-table">
<tr valign="top">
<th><strong><?php _e("Use an image for the main header/logo?", 'mt_trans_domain' ); ?></strong></th>
<td>
  <label>
    <input type="radio" name="<?php echo $tt_logo_field; ?>" value="true" <?php if ($tt_logo_value == 'true') { echo 'checked="checked"'; }?>  />
    Yes</label>
  <br />
  <label>
    <input type="radio" name="<?php echo $tt_logo_field; ?>" <?php if ($tt_logo_value == 'false') { echo 'checked="checked"'; }?> value="false"/>
    No</label>
</td>
</tr>
<tr>
<th><strong><?php _e("Use the Fresh Company header?", 'mt_trans_domain' ); ?></strong></th>
<td>
  <label>
    <input type="radio" name="<?php echo $tt_header_field; ?>" value="true" <?php if ($tt_header_value == 'true') { echo 'checked="checked"'; }?>  />
    Yes</label>
  <br />
  <label>
    <input type="radio" name="<?php echo $tt_header_field; ?>" <?php if ($tt_header_value == 'false') { echo 'checked="checked"'; }?> value="false"/>
    No</label>
</td>
</tr>
<tr valign="top"><th>
<strong><?php _e("Where do you want the header to show?", 'mt_trans_domain' ); ?></p></strong></th>
<td>
  <label>
    <input type="radio" name="<?php echo $tt_header_page_field; ?>" value="true" <?php if ($tt_header_page_value == 'true') { echo 'checked="checked"'; }?>  />
    Every Page</label>
  <br />
  <label>
    <input type="radio" name="<?php echo $tt_header_page_field; ?>" <?php if ($tt_header_page_value == 'false') { echo 'checked="checked"'; }?> value="false"/>
    Only the Home Page</label>
</td>
</tr>
</table>

<table class="form-table">
<tr valign="top">
<th><strong><?php _e("Title:", 'mt_trans_domain' ); ?></strong></th>
<td>
<input type="text" name="<?php echo $tt_header_title_field; ?>" value="<?php echo stripslashes($tt_header_title_value); ?>" size="30" style="padding: 5px; margin-left: 5px;">
</td>
</tr>
<tr valign="top"><th>
<strong><?php _e("Paragraph:", 'mt_trans_domain' ); ?></p></strong></th><td>
<textarea class="large-text" cols="50" rows="10" style="padding: 5px; margin-left: 5px;" name="<?php echo $tt_header_para_field; ?>"/><?php echo stripslashes($tt_header_para_value); ?></textarea>
</td>
</tr>
</table>

<p>If you want to use and image for the logo, but use a different image. Just replace logo.png, or edit the css (custom.css).</p>
<p>If you want to go further and change the image used in the header, either edit the CSS in custom.css or just replace the rising_icon.png file located in the skins image folder.</p>

</div>

<div style="background: #f1f1f1; padding: 10px; border: 1px solid #dadada; -moz-border-radius: 3px; -webkit-border-radius: 3px; margin-top: 10px; max-width: 650px;">
<h3 style="font-size: 1.5em; text-align: center;">License</h3>

<table class="form-table">
<tr valign="top">
<?php if ($tt_fpw_value == 'unlocked') { 
?>
<p>You are free to remove the footer attribution.</p>
<th><strong><?php _e("Remove Footer Attribution?", 'mt_trans_domain' ); ?></strong></th>
<td>
  <label>
    <input type="radio" name="<?php echo $tt_footer_field; ?>" value="true" <?php if ($tt_footer_value == 'true') { echo 'checked="checked"'; }?>  />
    Yes</label>
  <br />
  <label>
    <input type="radio" name="<?php echo $tt_footer_field; ?>" <?php if ($tt_footer_value == 'false') { echo 'checked="checked"'; }?> value="false"/>
    No</label>
</td>

<?php } else { ?>
<p>This theme is free for personal non-commercial use as long as the footer information remains intact. If you would like to use our skins for commercial reasons or remove / modify the footer you will need to purchase a license: You can do this through the <a href="http://thesisthemes.com/member/member.php">members area on our site.</a> Once you receive your pin, enter it below.</p>
<th><strong><?php _e("Footer Removal PIN:", 'mt_trans_domain' ); ?></strong></th><td>
<input type="text" name="<?php echo $tt_fpw_field; ?>" value="" size="30" style="padding: 5px; margin-left: 5px;">
</td>
<?php } ?>
</tr>
</table>
</div>

<div style="background: #f1f1f1; padding: 10px; border: 1px solid #dadada; -moz-border-radius: 3px; -webkit-border-radius: 3px; margin-top: 10px; max-width: 650px;">
<h3 style="font-size: 1.5em; text-align: center; margin-top: .2em;">Skin Info</h3>
<p><strong>Name: </strong><a href="http://thesisthemes.com/free-thesis-skins/fresh-company/">Fresh Company</a></p>
<p><strong>Version:</strong> 1.5<br/><br/>
<strong>Skin directory:</strong> <?php echo get_bloginfo(template_directory); ?>/custom/skins/freshcompany/</p>
</div>
<div style="background: #f1f1f1; padding: 10px; border: 1px solid #dadada; -moz-border-radius: 3px; -webkit-border-radius: 3px; margin-top: 10px; max-width: 650px; text-align: center;">
<p class="submit">
<input class="button-primary" type="submit" name="Submit" value="<?php _e('Update Skin Options', 'mt_trans_domain' ) ?>" />
</p>
</div>
<p style="background: #e4f2fd; padding: 10px; border: 1px solid #c6d9e9; -moz-border-radius: 3px; -webkit-border-radius: 3px; max-width: 650px; text-align: center"><em>Need some help? Have any suggestions? Want more free Thesis skins? Hit us up at <a href="http://www.thesisthemes.com">ThesisThemes.com</a>!</em></p>

</form>
</div>

<?php

}