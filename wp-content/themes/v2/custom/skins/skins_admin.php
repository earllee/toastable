<?php 
if (is_admin()) { add_action('init', 'skins_admin_options'); } # Admin Options - Head
add_action('admin_menu', 'skins_add_admin'); # Add The Menu

function skins_add_admin() { 
	add_submenu_page('thesis-options', "Manage Skins", "Manage Skins", 'edit_themes', basename(__FILE__), 'skins_admin'); 
	}

function skins_admin_options() {
	define("SKINSPATH", TEMPLATEPATH."/custom/skins/");
	
	if ($_GET[status] == "activate") { # If skin is activated
		$thesis_skin_path = SKINSPATH.$_GET[skin].'/functions.php';
		$thesis_skin_url = get_bloginfo('template_url').'/custom/skins/'.$_GET[skin].'/';
		update_option('thesis_skin_path', $thesis_skin_path);	
		update_option('thesis_skin_url', $thesis_skin_url);	
		wp_redirect($_SERVER['PHP_SELF'] . '?page=skins_admin.php&updated=true'); 
	}
	elseif ($_GET[status] == "deactivate") { # If skin is deactivated
		update_option('thesis_skin_path', "");
		wp_redirect($_SERVER['PHP_SELF'] . '?page=skins_admin.php&updated=true'); 
	}
	elseif ($_GET['skin_import']) { # If skin options are imported	
		global $all_options;
		$file = SKINSPATH.$_GET['skin'].'/thesis-all-options.dat';
		if (is_file($file)) { # Failsafe
			$raw_options = file_get_contents($file);
			$all_options = unserialize($raw_options);
			$site_options = new thesis_site_options;
			$design_options = new thesis_design_options;
			$page_options = new thesis_page_options;
			$site_options = $all_options['site_options'];
			$design_options = $all_options['design_options'];
			$page_options = $all_options['page_options'];

			if (is_object($site_options)) update_option('thesis_options', $site_options); #wp
			if (is_object($design_options)) update_option('thesis_design_options', $design_options); #wp
			if (is_object($page_options)) update_option('thesis_pages', $page_options); #wp

			thesis_generate_css();
			wp_redirect($_SERVER['PHP_SELF'] . '?page=skins_admin.php&skin_imported=true');
		}
		else { 
			wp_redirect($_SERVER['PHP_SELF'] . '?page=skins_admin.php&error=badimport');
		} 	
	}
}

function skins_admin() { 
	require_once(ABSPATH.'wp-admin/admin.php');
	$title = __('Manage Skins'); 
	define("SKINSPATH", TEMPLATEPATH."/custom/skins/");
	?>
    <div class="wrap">
        <div id="icon-themes" class="icon32">
            <br />
        </div>
        <h2><?php echo esc_html( $title ); ?></h2>
    <?php 
	
	if (thesis_version() < 1.7) { ?>
    <div class="error fade"><p><strong>The skin manager only works with Thesis 1.7+. Please ensure you have the <a href="http://www.diythemes.com">latest version.</a></strong></p></div>
    <?php 
	}  elseif (get_bloginfo('version') < 2.9) { ?>
    <div class="error fade"><p><strong>The skin manager only works with Wordpress 2.9+. Please ensure you have the <a href="http://www.wordpress.org">latest version.</a></strong></p></div>
    <?php } else {

		function getFileList($dir) {
		# array to hold return value
		$retval = array();
	
		# add trailing slash if missing
		if(substr($dir, -1) != "/") $dir .= "/";
	
		# open pointer to directory and read list of files
		$d = @dir($dir) or die("getFileList: Failed opening directory $dir for reading");
		while(false !== ($entry = $d->read())) {
		  # skip some files
		  if($entry[0] == "." || $entry == 'skins_admin.php') continue;
		  if(is_dir("$dir$entry")) { // Only directories.
			$retval[] = array(
			  "name" => "$entry/",
			  "type" => filetype("$dir$entry"),
			  "size" => 0,
			);
		  }
		}
		$d->close();
	return $retval;
  	} 
	$thesis_skin_path = get_option('thesis_skin_path');

	if ($_GET[error] == 'badimport') { ?>
		<div class="error fade"><p><strong>The file either doesn't exist or is invalid. If you have the file, try importing it through the <a href="?page=options-manager">Thesis Options Manager</a></strong></p></div>
	<?php }
	elseif ($_GET[updated] == 'true' ) { ?>
        <div class="updated fade"><p><strong>Your options have been saved. <a href="<?php bloginfo('url'); ?>">Check out your site!</a></strong></p></div>
    <?php }
    elseif ($_GET[skin_imported] == 'true' ) { ?>
    <div class="updated fade"><p><strong>The skin options have successfully been imported. <a href="<?php bloginfo('url'); ?>">Check out your site!</a></strong></p></div>
    <?php } ?>
    
	<?php if ($thesis_skin_path == "") { echo '<div class="error fade"><p><strong>No skin activated.</strong></p></div>'; } elseif (!$_POST[ $thesis_skin_field ] and !is_file($thesis_skin_path)) { echo '<div class="error fade"><p><strong>Could not locate active skin file. Please check your files, activate another skin, or <a class="button" href="?page=skins_admin.php&status=deactivate">Deactivate</a> current skin.</strong></p></div>'; }
	
    ?>
    
        <div class="clear"></div>       
        <p style="font-size: 10px;">To install a skin, click the button labeled <strong>1: Activate Skin</strong>. If the skin also has options that can be imported, another button will be available labeled <strong>2: Import Options</strong>. By clicking this button, your Thesis Design and Site options will be overwritten with the skin's default options, providing you with the skin's preset look. <a href="http://thesisthemes.com/thesis-skin-manager/">More documentation here</a>.</p>
        <h3><?php _e('Available Skins'); ?></h3>
        <div class="clear"></div>   
        
        <table id="availablethemes" cellspacing="0" cellpadding="0" style="border-width: 1px 1px 0; border-style: solid; background: #fff;" >
        	<tbody>
            	<tr>
					<?php
                     $skins_dir = getFileList(SKINSPATH);
                     $i = 0;
                     foreach($skins_dir as $key => $skins_folder){
                        $skin_file = SKINSPATH.$skins_folder["name"].'base.css';
                        $skin_functions = SKINSPATH.$skins_folder["name"].'functions.php';
                        if (is_file(SKINSPATH.$skins_folder["name"].'screenshot.png')) { $skin_screen = get_bloginfo('template_url').'/custom/skins/'.$skins_folder["name"].'screenshot.png'; } else { $skin_screen = false; }
						$skin_dat = SKINSPATH.$skins_folder["name"].'thesis-all-options.dat';
                        $skin_value = str_replace('/','', $skins_folder["name"]); 
                        
                        if (file_exists($skin_file) && file_exists($skin_functions)) {
							$default_headers = array( 
								'Name' => 'Skin Name', 
								'URI' => 'Skin URI', 
								'Description' => 'Description', 
								'Author' => 'Author', 
								'AuthorURI' => 'Author URI',
								'Version' => 'Version', 
								);
							$skin_data = get_file_data($skin_file, $default_headers, 'theme' );
							$skin_data['Name'] = $skin_data['Title'] = wp_kses( $skin_data['Name'], $themes_allowed_tags );
							$skin_data['URI'] = esc_url( $skin_data['URI'] );
							$skin_data['Description'] = wptexturize( wp_kses( $skin_data['Description'], $themes_allowed_tags ) );
							$skin_data['AuthorURI'] = esc_url( $skin_data['AuthorURI'] );
							$skin_data['Template'] = wp_kses( $skin_data['Template'], $themes_allowed_tags );
							$skin_data['Version'] = wp_kses( $skin_data['Version'], $themes_allowed_tags );
							if ( $skin_data['Author'] == '' ) { $skin_data['Author'] = __('Anonymous'); }
							if ( $skin_data['Name'] == '' ) { $skin_data['Name'] = __('Unknown'); }
							?>
							
							<td <?php if ($skin_functions == $thesis_skin_path) { echo 'style="background:#EDFBD8;"'; } ?> class="available-theme<?php if ($i == 0) { echo " left"; } elseif ($i == 2) { echo " right"; } ?>">
							<a class="screenshot" alt="" href="?page=skins_admin.php&status=activate&skin=<?php echo $skin_value; ?>">
								<?php if ($skin_screen) { ?> <img src="<?php echo $skin_screen; ?>" alt="Screen Shot" /> <?php } ?>
							</a>
							<h3><a href="<?php echo $skin_data['URI']; ?>"><?php echo $skin_data['Name']; ?> <?php echo $skin_data['Version']; ?></a> by <a href="<?php echo $skin_data['AuthorURI']; ?>"><?php echo $skin_data['Author']; ?></a></h3>
							<p class="description">
							<?php echo $skin_data['Description']; ?>
							</p>
							<?php if ($skin_functions == $thesis_skin_path) { ?><p><strong style="color: #508600;">This skin is active!</strong></p>
							<p class="action-links"><a class="button" href="?page=skins_admin.php&status=deactivate&skin=<?php echo $skin_value; ?>">Deactivate Skin</a> <?php } else { ?>
							<p class="action-links"><a class="button" href="?page=skins_admin.php&status=activate&skin=<?php echo $skin_value; ?>">1: Activate Skin</a> <?php } ?> 
                            <?php if (is_file($skin_dat)) { ?><a class="button" href="?page=skins_admin.php&skin_import=true&skin=<?php echo $skin_value; ?>" onClick="return confirm('Doing this will overwrite ALL Thesis Options. Unless you have made a backup there is no going back. Are you sure you want to import all options for this skin?')">2: Import Options</a> <?php } ?></p>
							<p>All of this skin's files are located in <code>skins/<?php echo $skins_folder["name"]; ?></code> <br/></p>
							</td>
							<?php if ($i == 2) { echo "</tr><tr>"; $i = -1; } $i++;
                          }
                       } 
					   if ($i == 1) { echo '<td class="available-theme"></td><td class="right available-theme"></td></tr>'; }
					   elseif ($i == 2) { echo '<td class="right available-theme"></td></tr>'; }
					   ?> 
                    </tr>
                 </tbody>
            </table>
            <p class="description">Thesis Skin Manager 1.0 | Developed by <a href="http://www.thesisthemes.com/">ThesisThemes</a> | <a href="http://thesisthemes.com/thesis-skin-manager/">Use the Skin Manager with your skin</a></p>
	</div>
</div>
<?php } 
}

$thesis_skin_path = get_option('thesis_skin_path');
$thesis_skin_url = get_option('thesis_skin_url');

define("SKINURL", $thesis_skin_url);

if ($thesis_skin_path != "" && is_file($thesis_skin_path)) { require_once($thesis_skin_path); } // Grab our skin's function file.