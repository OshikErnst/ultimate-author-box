<?php
/*
Plugin Name: Ultimate Author Box
Version: 1.0
Description: place styled author box in your post.
Author: Oshik Ernst
Author URI: http://wpfeed.com
Plugin URI: http://wpfeed.com
*/

function uab_author_box_display($content)
{
	
	
	$options['page'] = get_option('box_on_page');
	$options['post'] = get_option('box_on_post');
    

	if ( (is_single() && $options['post']) || (is_page() && $options['page']) )
	{
	   
       $author_image = get_the_author_meta('profile_image');
       
       if($author_image){
        $author_image = '<img alt="" src="'.get_the_author_meta('profile_image').'" class="avatar" height="80" width="80">';
        }else{
        $author_image = get_avatar( get_the_author_meta("user_email"), '80' );
       }
       
       if(get_the_author_meta( "twitter", $user_id )){
        $author_meta_twitter = '<li><a href="http://twitter.com/'.get_the_author_meta( "twitter", $user_id ).'" target="_blank"><img src="'.WP_PLUGIN_URL.'/ultimate-author-box/img/twitter.png"></a></li>';
        }else{
        $author_meta_twitter = '';
       }
       
       if(get_the_author_meta( "facebook", $user_id )){
        $author_meta_facebook = '<li><a href="'.get_the_author_meta( "facebook", $user_id ).'" target="_blank"><img src="'.WP_PLUGIN_URL.'/ultimate-author-box/img/facebook.png"></a></li>';
        }else{
        $author_meta_facebook = '';
       }
       
       if(get_the_author_meta( "linkedin", $user_id )){
        $author_meta_linkedin = '<li><a href="'.get_the_author_meta( "linkedin", $user_id ).'" target="_blank"><img src="'.WP_PLUGIN_URL.'/ultimate-author-box/img/linkedin.png"></a></li>';
        }else{
        $author_meta_linkedin = '';
       }
       
       if(get_the_author_meta( "google", $user_id )){
        $author_meta_google = '<li><a href="'.get_the_author_meta( "google", $user_id ).'" target="_blank"><img src="'.WP_PLUGIN_URL.'/ultimate-author-box/img/google.png"></a></li>';
        }else{
        $author_meta_google = '';
       }
       
		$author_box = 
		'<div id="uab_author_box">
            <div class="uab_left">
            '.$author_image.'
            <ul>
            '.$author_meta_twitter.'
            '.$author_meta_facebook.'
            '.$author_meta_linkedin.'
            '.$author_meta_google.'
            </ul>
            </div>
            
            <div class="uab_right">
			<span class="uab_author_name">'.get_the_author_meta('display_name').'</span>
			<p>'.get_the_author_meta('description').'</p>
            </div>
		</div>';
		
		return $content . $author_box;
	} else {
		return $content;
	}
}

function uab_register_head() {
    
    
    $options["uab_author_name_color"] = get_option("uab_author_name_color");
    $options["uab_border"] = get_option("uab_border");
    $options["uab_text_color"] = get_option("uab_text_color");
    
    if( get_option('uab_author_name_color') ){
        $uab_author_name_color = get_option('uab_author_name_color');
        }else{
        $uab_author_name_color = '#000';
    }
    
    if( get_option('uab_border') ){
        $uab_border = get_option('uab_border');
        }else{
        $uab_border = '#DCDCDC';
    }
    
    if( get_option('uab_text_color') ){
        $uab_text_color = get_option('uab_text_color');
        }else{
        $uab_text_color = '#000';
    }
    
    
    
    
    
    
    echo '<style type="text/css" media="screen">';
    echo '.uab_author_name{color:'.$uab_author_name_color.'}';
    echo '#uab_author_box{border: 1px solid '.$uab_border.';}';
	echo '.uab_right p{color:'.$uab_text_color.'}';
	
    echo '</style>';
}

function uab_author_box_settings()
{
	// this is where we'll display our admin options
	if ($_POST['action'] == 'update')
	{
		$_POST['show_pages'] == 'on' ? update_option('box_on_page', 'checked') : update_option('box_on_page', '');
		$_POST['show_posts'] == 'on' ? update_option('box_on_post', 'checked') : update_option('box_on_post', '');
        
        
        update_option('uab_author_name_color', $_POST['uab_author_name_color']) ;
        update_option('uab_border', $_POST['uab_border']) ;
        update_option('uab_text_color', $_POST['uab_text_color']) ;
        
		$message = '<div id="message" class="updated fade"><p><strong>Options Saved</strong></p></div>';
	}
	
	$options['page'] = get_option('box_on_page');
	$options['post'] = get_option('box_on_post');
    
    if (get_option('uab_author_name_color')){
    $options['uab_author_name_color'] = get_option('uab_author_name_color');
    }else{
    $options['uab_author_name_color'] =  "#000";  
    } 
    
    if (get_option('uab_border')){
    $options['uab_border'] = get_option('uab_border');
    }else{
    $options['uab_border'] =  "#DCDCDC";  
    } 
    
    if (get_option('uab_text_color')){
    $options['uab_text_color'] = get_option('uab_text_color');
    }else{
    $options['uab_text_color'] =  "#000";  
    } 
    
   
	
    ?> 
    <script type="text/javascript">
    $(document).ready(function() {
                $("#colorpicker1").farbtastic("#uab_author_name_color");
                $("#colorpicker2").farbtastic("#uab_border");
                $("#colorpicker3").farbtastic("#uab_text_color");});
    </script>
    <?php
    echo '
	<div class="wrap">
		'.$message.'
		<div id="icon-options-general" class="icon32"><br /></div>
		<h2>Ultimate Author Box Settings</h2>
		
        <div id="manage_uab">
		<form method="post" action="">
		<input type="hidden" name="action" value="update" />
		
		<h3>Where to Display Ultimate Author Box</h3>
		<input name="show_pages" type="checkbox" id="show_pages" '.$options['page'].' /> Pages<br />
		<input name="show_posts" type="checkbox" id="show_posts" '.$options['post'].' /> Posts<br />
		<br />

        
        <h3>Style Your Ultimate Author Box</h3> 

        Author name color: &nbsp; <input class="uab_input" type="text" name="uab_author_name_color" id="uab_author_name_color" value="' . $options['uab_author_name_color'] . '" /><div id="colorpicker1"></div>  <br />   <br />  
        Author box border color: &nbsp; <input class="uab_input" type="text" name="uab_border" id="uab_border" value="' . $options['uab_border'] . '" /><div id="colorpicker2"></div>  <br /> <br />  
        Author box text color: &nbsp; <input class="uab_input" type="text" name="uab_text_color" id="uab_text_color" value="' . $options['uab_text_color'] . '" /><div id="colorpicker3"></div>  <br /> <br />
        <br />
        
		<input class="uab_button" type="submit" class="button-primary" value="Save Changes" />
		</form>
        
        <div class="notice">
        * to update your profile information go to: <stronog>users -> your profile</strong> or click <a href=profile.php#uab_extra>here</a>.
        </div>
        
        </div>
        
	</div>';
}

function my_admin_scripts() { 
    wp_enqueue_script('media-upload'); 
    wp_enqueue_script('thickbox'); 
    wp_register_script('my-uab-upload', WP_PLUGIN_URL.'/ultimate-author-box/uab.js', array('jquery','media-upload','thickbox')); 
    wp_enqueue_script('my-uab-upload'); 
    
    }  
    
function my_admin_styles() { 
    wp_enqueue_style('thickbox');
}  

function my_admin_colors_style() {

    wp_register_style('my-uab-color-style', WP_PLUGIN_URL.'/ultimate-author-box/farbtastic/farbtastic.css');
    wp_enqueue_style('my-uab-color-style');
    
    }
    
function my_admin_colors_scripts() { 

    wp_deregister_script( 'jquery' );
    wp_register_script( 'jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js');
    wp_enqueue_script( 'jquery' );
    wp_register_script('my-uab-color-script', WP_PLUGIN_URL.'/ultimate-author-box/farbtastic/farbtastic.js',array('jquery'));  
    wp_enqueue_script('my-uab-color-script');
    
    }    
    



$current_file_name = basename($_SERVER['REQUEST_URI']); 
$profile_page = explode('.php',$current_file_name);

if (($profile_page[0] == 'profile') || ($profile_page[0] == 'user-edit')) { 
    add_action('admin_print_scripts', 'my_admin_scripts'); 
    add_action('admin_print_styles', 'my_admin_styles'); 
    } 
    
if ($_GET['page'] == 'uab.php') { 
    add_action('admin_print_scripts', 'my_admin_colors_scripts'); 
    add_action('admin_print_styles', 'my_admin_colors_style'); 
    }     

wp_register_script('my-uab-box', WP_PLUGIN_URL.'/ultimate-author-box/uab-global.js',array('jquery'),'1.0');    
wp_enqueue_script('my-uab-box');

function uab_author_box_admin_menu()
{
	// this is where we add our plugin to the admin menu
	add_options_page('Ultimate Author Box', 'Ultimate Author Box', 9, basename(__FILE__), 'uab_author_box_settings');
}

add_action('the_content', 'uab_author_box_display');
add_action('wp_head', 'uab_register_head');
add_action('admin_menu', 'uab_author_box_admin_menu');


wp_register_style('my-uab-style', WP_PLUGIN_URL.'/ultimate-author-box/uab.css');
wp_enqueue_style( 'my-uab-style');

add_action( 'show_user_profile', 'my_show_extra_profile_fields' );
add_action( 'edit_user_profile', 'my_show_extra_profile_fields' );

function my_show_extra_profile_fields( $user ) { ?>

	<h3 id="uab_extra">Extra profile information</h3>

	<table class="form-table">

		<tr>
			<th><label for="twitter">Twitter</label></th>

			<td>
				<input type="text" name="twitter" id="twitter" value="<?php echo esc_attr( get_the_author_meta( 'twitter', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description">Please enter your Twitter username.</span>
			</td>
		</tr>
        <tr>
			<th><label for="facebook">Facebook</label></th>

			<td>
				<input type="text" name="facebook" id="facebook" value="<?php echo esc_attr( get_the_author_meta( 'facebook', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description">Please enter your Facebook profile URL.</span>
			</td>
		</tr>
        <tr>
			<th><label for="linkedin">LinkedIn</label></th>

			<td>
				<input type="text" name="linkedin" id="linkedin" value="<?php echo esc_attr( get_the_author_meta( 'linkedin', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description">Please enter your LinkedIn profile URL.</span>
			</td>
		</tr>
        
        <tr>
			<th><label for="google">Google+</label></th>

			<td>
				<input type="text" name="google" id="google" value="<?php echo esc_attr( get_the_author_meta( 'google', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description">Please enter your Google+ profile URL.</span>
			</td>
		</tr>
        
        
        <tr>
			<th><label for="upload_image">Image</label></th>

			<td>
                Upload Image <label for="upload_image"> 
                    <input id="upload_image" size="36" name="upload_image" type="text" /> 
                    <input id="upload_image_button" value="Upload Image" type="button" /> 
                </label>
			</td>
		</tr>
        
        
        
        <?php 
        $the_profile_img = get_the_author_meta( 'profile_image', $user->ID );
        if($the_profile_img){ ?>
            <tr>
			 <th>Current Image</th>
            <td>
            <img src="<?php echo get_the_author_meta( 'profile_image', $user->ID ) ; ?>" width="100px" height="100px" />
            &nbsp;
            <input type="checkbox" name="del_image" id="del_image" />delete image<br />
           	</td>
		</tr>
       <?php } ?>
        
                
		
        
        

	</table>
<?php }


add_action( 'personal_options_update', 'my_save_extra_profile_fields' );
add_action( 'edit_user_profile_update', 'my_save_extra_profile_fields' );

function my_save_extra_profile_fields( $user_id ) {

	if ( !current_user_can( 'edit_user', $user_id ) )
		return false;

	
	update_usermeta( $user_id, 'twitter', $_POST['twitter'] );
    update_usermeta( $user_id, 'facebook', $_POST['facebook'] );
    update_usermeta( $user_id, 'linkedin', $_POST['linkedin'] );
    update_usermeta( $user_id, 'google', $_POST['google'] );
    if ($_POST['upload_image']){
    update_usermeta( $user_id, 'profile_image', $_POST['upload_image'] );
    }  
    if ($_POST['del_image']){
        
        update_usermeta( $user_id, 'profile_image', '' );
    }
}
?>