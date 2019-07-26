<?php
/**
 * @package PesaPal For WooCommerce
 * @subpackage Plugin Menus
 * @author Mauko Maunde < hi@mauko.co.ke >
 * @since 0.18.01
 */

// Add admin menus for plugin actions
add_action('admin_menu', 'pesapal_transactions_menu');
function pesapal_transactions_menu()
{
    add_submenu_page(
        'edit.php?post_type=pesapal_ipn', 
        'About this Plugin', 
        'About Plugin', 
        'manage_options',
        'pesapal_about', 
        'pesapal_transactions_menu_about' 
   );

    // add_submenu_page(
    //     'pesapal', 
    //     'PesaPal Payments Analytics', 
    //     'Analytics', 
    //     'manage_options',
    //     'pesapal_analytics', 
    //     'pesapal_transactions_menu_analytics' 
    //);

    add_submenu_page(
        'edit.php?post_type=pesapal_ipn', 
        'PesaPal Preferences', 
        'Configure Options', 
        'manage_options',
        'pesapal_preferences', 
        'pesapal_transactions_menu_pref' 
   );
}

// About plugin
function pesapal_transactions_menu_about()
{ ?>
    <div class="wrap">
        <h1>About PesaPal for WooCommerce</h1>

        <img src="<?php echo apply_filters('woocommerce_mpesa_icon', plugins_url('PesaPal.png', __FILE__)); ?>" width="200px">

        <h3>The Plugin</h3>
        <article>
            <p>This plugin builds on ..</p>
        </article>

        <h3>Integration</h3>
        <article>
            <p>
                While we have made all efforts to ensure this plugin works out of the box - with minimum configuration required ..
            </p>
        </article>

        <h3>Contact</h3>
        <h4>Get in touch with me (<a href="https://mauko.co.ke/">Mauko</a>) either via email (<a href="mail-to:hi@mauko.co.ke">hi@mauko.co.ke</a>) or via phone(<a href="tel:+254204404993">+254204404993</a>)</h4>
        </div><?php
    }

// Redirect to plugin configuration page
    function pesapal_transactions_menu_pref()
    {
        wp_redirect(admin_url('admin.php?page=wc-settings&tab=checkout&section=pesapal'));
    }
