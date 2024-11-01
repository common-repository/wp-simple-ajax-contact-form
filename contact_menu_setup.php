<?php 

add_action( 'admin_menu', 'contact_setMenu' );


		
function contact_setMenu(  )

{

	add_menu_page('<span style="color:#f18500">باگ های امنیتی</span>', '<span style="color:#f18500">باگ های امنیتی</span>', 'activate_plugins', "wp_simple_ajax_contact_form", 'load_contact_bugs'); 
	add_submenu_page("wp_simple_ajax_contact_form", "پکیج های آموزشی", "پکیج های آموزشی", 'activate_plugins', "wp_simple_ajax_contact_form_packages", "load_contact_packages");
	add_submenu_page("wp_simple_ajax_contact_form", "افزونه و قالب ها", "افزونه و قالب ها", 'activate_plugins', "wp_simple_ajax_contact_form_plugins_themes", "load_contact_plugins_themes");	

}



function load_contact_packages(  )
{
	include dirname(__file__)."/contact_packages.php";
}

function load_contact_plugins_themes(  )
{
	include dirname(__file__)."/contact_pluginsthemes.php";
}


function load_contact_bugs(  )
{
	include dirname(__file__)."/contact_bugs.php";
}