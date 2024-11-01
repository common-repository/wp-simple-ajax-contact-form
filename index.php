<?php
/**
* Plugin Name: wp simple ajax contact form
* Plugin URI: http://picor.ir
* Description: This plugin will add fixed contact icon in left side of your wordpress theme, also support shortcode.
* Version: 3.0
* Author: Arash Heidari
* Author URI: http://picor.ir
*License: GPLv2 or later
*License URI: http://www.gnu.org/licenses/gpl-2.0.html
 */
 
 include_once "contact_menu_setup.php";
 
 
 load_plugin_textdomain('wp-simple-ajax-contact-form', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/');
define('wp_simple_ajax_contact_form', WP_PLUGIN_URL . '/' . plugin_basename( dirname(__FILE__) ) . '/' );

function wp_simple_ajax_contact_form_scripts($hook) {
   
	wp_enqueue_style( 'wp_simple_ajax_contact_form_style', wp_simple_ajax_contact_form.'css/style.css' );	
    wp_enqueue_script( 'jquery');	
    wp_enqueue_script( 'fixed-icon.js', plugins_url( '/js/fixed-icon.js', __FILE__ ));	
    wp_enqueue_script( 'wp_simple_ajax_contact_form', wp_simple_ajax_contact_form.'js/contact-form.js', array( 'jquery' ) );
    wp_localize_script( 'wp_simple_ajax_contact_form', 'wp_simple_ajax_contact_form_ajax', array( 'wp_simple_ajax_contact_form_ajaxurl' => admin_url( 'admin-ajax.php')));


		
}
add_action('wp_enqueue_scripts', 'wp_simple_ajax_contact_form_scripts'); 

add_filter('wp_footer' , 'contact');
function contact()
{
	echo  
	' 
	
 <div class="slide-out-div">
    <a class="handle"></a>

	  		<div id="wp-simple-ajax-contact-form">
			<form name="myform" id="myform" method="POST">  
            	
                <table align="center">
                	<tr>
                    	<td width="20%"> <label for="name" id="name_label">' . __('Name:', 'wp-simple-ajax-contact-form') . '</label></td>
                		<td><input type="text" name="wp_simple_ajax_contact_form_name" id="wp-simple-ajax-contact-form-name" placeholder="' . __('Your Name:', 'wp-simple-ajax-contact-form') . '" value=""/><br>
                			<span class="wp-simple-ajax-contact-form"></span>
                   		</td>
                	</tr>

                 <tr>
                 	<td width="20%"><label for="email" id="email_label">' . __('Email:', 'wp-simple-ajax-contact-form') . '</label></td> 
                    <td><input type="text" name="wp_simple_ajax_contact_form_email" id="wp-simple-ajax-contact-form-email" placeholder="' . __('Your Email:', 'wp-simple-ajax-contact-form') . '" value=""/><br> 
                    <span class="wp-simple-ajax-contact-form-email-valid"></span> <span class="wp-simple-ajax-contact-form-email-empty"></span></td>
             	</tr>
                                        
                <tr>
                	<td width="20%" align="right"><label for="email" id="mgs_label">' . __('Message:', 'wp-simple-ajax-contact-form') . '</label></td>
                    <td><textarea type="text" name="wp_simple_ajax_contact_form_mgs" id="wp-simple-ajax-contact-form-mgs" placeholder="' . __('Write Your Message', 'wp-simple-ajax-contact-form') . '"  value=""></textarea> <br><span class="wp-simple-ajax-contact-form-mgs-valid"></span> </td>
                </tr>

                <tr>
                	<td class="submit" colspan="2"><div id="wp-simple-ajax-contact-form-submit" name="submit"><div class="sending" ></div>' . __('Send', 'wp-simple-ajax-contact-form') . '</div></td>
                </tr>
            </table> 

                                    </form>
           
                                    <div id="wp-simple-ajax-contact-form-submit-success">
                                    
                                    </div>
                                </div>	
	  <div class="wp">
	
	

</div>
	</div>


	';
}


add_shortcode('wp_simple_ajax_contact_form', 'wp_simple_ajax_contact_form');
	function wp_simple_ajax_contact_form() {	?>
		<div id="wp-simple-ajax-contact-form">
			<form name="myform" id="myform" method="POST">  
                <table align="center">
                	<tr>
                    	<td width="25%"> <label for="name" id="name_label"><?php _e('Name', 'wp-simple-ajax-contact-form') ?></label></td>
                		<td><input type="text" name="wp_simple_ajax_contact_form_name" id="wp-simple-ajax-contact-form-name" placeholder="Your Name" value=""/><br>
                			<span class="wp-simple-ajax-contact-form-name-valid"></span>
                   		</td>
                	</tr>
                 <tr>
                 	<td width="25%"><label for="email" id="email_label"><?php _e('Email', 'wp-simple-ajax-contact-form') ?></label></td> 
                    <td><input type="text" name="wp_simple_ajax_contact_form_email" id="wp-simple-ajax-contact-form-email" placeholder="Your Email" value=""/><br> 
                    <span class="wp-simple-ajax-contact-form-email-valid"></span> <span class="wp-simple-ajax-contact-form-email-empty"></span></td>
             	</tr>
                                        
                <tr>
                	<td width="25%" align="right"><label for="email" id="mgs_label"><?php _e('Message', 'wp-simple-ajax-contact-form') ?></label></td>
                    <td><textarea type="text" name="wp_simple_ajax_contact_form_mgs" id="wp-simple-ajax-contact-form-mgs" placeholder="Write your message"  value=""></textarea> <br><span class="wp-simple-ajax-contact-form-mgs-valid"></span> </td>
                </tr>
                   
                <tr>
                	<td class="submit" colspan="2"><div id="wp-simple-ajax-contact-form-submit" name="submit"><div class="sending" ></div><?php _e('Send', 'wp-simple-ajax-contact-form') ?></div></td>
                </tr>
            </table> 
                                    </form>
                     
                                    <div id="wp-simple-ajax-contact-form-submit-success">
                              
                                    </div>
                                </div>	


<?php 
 }
 
 
 function wp_simple_ajax_contact_form_send(){
	$name = sanitize_text_field($_POST['name']);
	$email = sanitize_email($_POST['email']);
	$mgs = sanitize_text_field($_POST['mgs']);	
	$to = get_option('admin_email');

			if (mail($to, "Name:". $name, $mgs, "From:". $email )){
				
				print "<span style='color:green; font-weight: bold;'>" . _e('Your message sent successfully.', 'wp-simple-ajax-contact-form') . "</span><span id='mail-sent-success' success='1'></span>" ;
			} else {
				print "<span style='color:red; font-weight: bold;'>" . __('Sorry! Please try again. ', 'wp-simple-ajax-contact-form') . "</span>";	
			}
	
	
	die(); 
	
 }

add_action('wp_ajax_wp_simple_ajax_contact_form_send', 'wp_simple_ajax_contact_form_send');
add_action('wp_ajax_nopriv_wp_simple_ajax_contact_form_send', 'wp_simple_ajax_contact_form_send');?>