<?php
/*
Plugin Name: Dynamic Age Restriction Plugin
Plugin URI: https://digiluxo.com/
Description: Restricts access to the site for users under 18 years old with dynamic customization options, including translations and styling.
Version: 1.0.0
Author: Abdur Rahim
Author URI: https://fb.com/Rahim72446
License: GPL2
Text Domain: age-restriction-plugin
*/

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Enqueue styles and scripts for the popup
function age_restriction_enqueue_scripts() {
    wp_enqueue_style('age-restriction-style', plugins_url('assets/css/style.css', __FILE__));
    wp_enqueue_script('age-restriction-script', plugins_url('assets/js/script.js', __FILE__), array('jquery'), false, true);
}
add_action('wp_enqueue_scripts', 'age_restriction_enqueue_scripts');

// Register settings in the WordPress Customizer
function age_restriction_customize_register($wp_customize) {
    // Section for the Age Restriction Popup
    $wp_customize->add_section('age_restriction_section', array(
        'title' => __('Age Restriction Settings', 'age-restriction-plugin'),
        'priority' => 30,
    ));

    // Logo setting
    $wp_customize->add_setting('age_restriction_logo', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'age_restriction_logo', array(
        'label' => __('Popup Logo', 'age-restriction-plugin'),
        'section' => 'age_restriction_section',
        'settings' => 'age_restriction_logo',
    )));

    // Maximum Width for the Logo
    $wp_customize->add_setting('age_restriction_logo_max_width', array(
        'default' => '100%',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('age_restriction_logo_max_width', array(
        'label' => __('Max Width for Logo', 'age-restriction-plugin'),
        'section' => 'age_restriction_section',
        'type' => 'text',
    ));

    // Maximum Height for the Logo
    $wp_customize->add_setting('age_restriction_logo_max_height', array(
        'default' => '200px',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('age_restriction_logo_max_height', array(
        'label' => __('Max Height for Logo', 'age-restriction-plugin'),
        'section' => 'age_restriction_section',
        'type' => 'text',
    ));

    // Title text
    $wp_customize->add_setting('age_restriction_title', array(
        'default' => __('Are You over 18?', 'age-restriction-plugin'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('age_restriction_title', array(
        'label' => __('Popup Title', 'age-restriction-plugin'),
        'section' => 'age_restriction_section',
        'type' => 'text',
    ));

    // Message text setting
    $wp_customize->add_setting('age_restriction_message', array(
        'default' => __('You must be 18 years or older to access this site. Please confirm your age:', 'age-restriction-plugin'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('age_restriction_message', array(
        'label' => __('Popup Message', 'age-restriction-plugin'),
        'section' => 'age_restriction_section',
        'type' => 'text',
    ));

    // Deny Title text
    $wp_customize->add_setting('age_restriction_deny_title', array(
        'default' => __('Access Forbidden', 'age-restriction-plugin'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('age_restriction_deny_title', array(
        'label' => __('Denied Popup Title', 'age-restriction-plugin'),
        'section' => 'age_restriction_section',
        'type' => 'text',
    ));

    // Deny Message text setting
    $wp_customize->add_setting('age_restriction_deny_message', array(
        'default' => __('Your access is restricted because of your age.', 'age-restriction-plugin'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('age_restriction_deny_message', array(
        'label' => __('Denied Popup Message', 'age-restriction-plugin'),
        'section' => 'age_restriction_section',
        'type' => 'text',
    ));

    // Confirm button text
    $wp_customize->add_setting('age_restriction_confirm_text', array(
        'default' => __('I am 18 or older', 'age-restriction-plugin'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('age_restriction_confirm_text', array(
        'label' => __('Confirm Button Text', 'age-restriction-plugin'),
        'section' => 'age_restriction_section',
        'type' => 'text',
    ));

    // Deny button text
    $wp_customize->add_setting('age_restriction_deny_text', array(
        'default' => __('I am under 18', 'age-restriction-plugin'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('age_restriction_deny_text', array(
        'label' => __('Deny Button Text', 'age-restriction-plugin'),
        'section' => 'age_restriction_section',
        'type' => 'text',
    ));

    // Confirm button background color
    $wp_customize->add_setting('age_restriction_confirm_bg_color', array(
        'default' => '#28a745',
        'sanitize_callback' => 'sanitize_hex_color',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'age_restriction_confirm_bg_color', array(
        'label' => __('Confirm Button Background Color', 'age-restriction-plugin'),
        'section' => 'age_restriction_section',
        'settings' => 'age_restriction_confirm_bg_color',
    )));

    // Confirm button text color
    $wp_customize->add_setting('age_restriction_confirm_text_color', array(
        'default' => '#ffffff',
        'sanitize_callback' => 'sanitize_hex_color',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'age_restriction_confirm_text_color', array(
        'label' => __('Confirm Button Text Color', 'age-restriction-plugin'),
        'section' => 'age_restriction_section',
        'settings' => 'age_restriction_confirm_text_color',
    )));

    // Deny button background color
    $wp_customize->add_setting('age_restriction_deny_bg_color', array(
        'default' => '#dc3545',
        'sanitize_callback' => 'sanitize_hex_color',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'age_restriction_deny_bg_color', array(
        'label' => __('Deny Button Background Color', 'age-restriction-plugin'),
        'section' => 'age_restriction_section',
        'settings' => 'age_restriction_deny_bg_color',
    )));

    // Deny button text color
    $wp_customize->add_setting('age_restriction_deny_text_color', array(
        'default' => '#ffffff',
        'sanitize_callback' => 'sanitize_hex_color',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'age_restriction_deny_text_color', array(
        'label' => __('Deny Button Text Color', 'age-restriction-plugin'),
        'section' => 'age_restriction_section',
        'settings' => 'age_restriction_deny_text_color',
    )));
}
add_action('customize_register', 'age_restriction_customize_register');

// Display the age verification popup
function age_restriction_popup() {
    if (!isset($_COOKIE['age_verified'])) {  
        ?>
        <div id="age-verification-overlay" style="display: flex;">
            <div id="age-popup-content" data-deny-title="<?php echo esc_attr(get_theme_mod('age_restriction_deny_title', 'Access Forbidden')); ?>"
                 data-deny-message="<?php echo esc_attr(get_theme_mod('age_restriction_deny_message', 'Your access is restricted because of your age.')); ?>">
                <?php 
                // Get dynamic settings
                $logo_url = get_theme_mod('age_restriction_logo');
                $max_width = get_theme_mod('age_restriction_logo_max_width', '100%');
                $max_height = get_theme_mod('age_restriction_logo_max_height', '200px');
                $title = get_theme_mod('age_restriction_title', __('Are You over 18?', 'age-restriction-plugin'));
                $message = get_theme_mod('age_restriction_message', __('You must be 18 years or older to access this site. Please confirm your age:', 'age-restriction-plugin'));
                $confirm_text = get_theme_mod('age_restriction_confirm_text', __('I am 18 or older', 'age-restriction-plugin'));
                $deny_text = get_theme_mod('age_restriction_deny_text', __('I am under 18', 'age-restriction-plugin'));
                $confirm_bg_color = get_theme_mod('age_restriction_confirm_bg_color', '#28a745');
                $confirm_text_color = get_theme_mod('age_restriction_confirm_text_color', '#ffffff');
                $deny_bg_color = get_theme_mod('age_restriction_deny_bg_color', '#dc3545');
                $deny_text_color = get_theme_mod('age_restriction_deny_text_color', '#ffffff');

                if ($logo_url): ?>
                    <img src="<?php echo esc_url($logo_url); ?>" alt="Site Logo" style="max-width: <?php echo esc_attr($max_width); ?>; max-height: <?php echo esc_attr($max_height); ?>; margin-bottom: 10px;">
                <?php endif; ?>
                <h2><?php echo esc_html($title); ?></h2>
                <p style="font-size: 18px; margin-bottom: 20px;"><?php echo esc_html($message); ?></p>
                <button id="confirm-age"><?php echo esc_html($confirm_text); ?></button>
                <button id="deny-age"><?php echo esc_html($deny_text); ?></button>
            </div>
        </div>

        <script>
            // Add dynamic styles for button colors
            document.documentElement.style.setProperty('--confirm-bg-color', '<?php echo esc_attr($confirm_bg_color); ?>');
            document.documentElement.style.setProperty('--confirm-text-color', '<?php echo esc_attr($confirm_text_color); ?>');
            document.documentElement.style.setProperty('--deny-bg-color', '<?php echo esc_attr($deny_bg_color); ?>');
            document.documentElement.style.setProperty('--deny-text-color', '<?php echo esc_attr($deny_text_color); ?>');
        </script>
        <?php
    }
}

add_action('wp_footer', 'age_restriction_popup');
