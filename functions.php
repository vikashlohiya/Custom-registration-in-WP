<?php

function custom_theme_setup() {
    register_nav_menus(array('primary-menu' => __('Primary Menu', 'demotheme'),));
}

add_action('after_setup_theme', 'custom_theme_setup');
//For Login
function hide_admin_bar_for_non_admins() {
    if ( ! current_user_can( 'administrator' ) ) {
        show_admin_bar( false );
    }
}
add_action( 'after_setup_theme', 'hide_admin_bar_for_non_admins' );


function hide_menu_conditional($items, $args) {
   if (is_user_logged_in()) {
           foreach ($items as $key => $item) {
                
                if ($item->title == 'Register') {                    
                    unset($items[$key]);
                   
                }
                if ($item->title == 'Login') {                    
                    unset($items[$key]);
                 
                }
            }
        }   
        return $items;
}
add_filter('wp_nav_menu_objects', 'hide_menu_conditional', 10, 2);

//End For Login
