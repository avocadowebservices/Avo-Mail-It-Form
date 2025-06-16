<?php
/*
Plugin Name: AvoMailForm
Plugin URI: https://avocadoweb.net
Description: A fully custom contact form plugin for AvocadoWeb Services with settings for Brevo SMTP, reCAPTCHA, and Akismet.
Version: 2.2
Author: Joseph Brzezowski / AvocadoWeb Services LLC
Author URI: https://avocadoweb.net
License: GPL2
*/

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// ✅ Register the Admin Menu for Settings Page
function avocadoweb_create_menu() {
    add_menu_page(
        'AvoMailForm', // Page Title
        'AvoMailForm', // Menu Title in Admin Sidebar
        'manage_options', // Capability (Only Admins Can See It)
        'avocadoweb-settings', // Menu Slug (Must Match URL Slug)
        'avocadoweb_settings_page', // Function to Display Page
        'dashicons-email', // Icon
        20 // Menu Position
    );
}
add_action('admin_menu', 'avocadoweb_create_menu');

// ✅ Register Plugin Settings
function avocadoweb_register_settings() {
    register_setting('avocadoweb-settings-group', 'avocadoweb_smtp_host');
    register_setting('avocadoweb-settings-group', 'avocadoweb_smtp_port');
    register_setting('avocadoweb-settings-group', 'avocadoweb_smtp_username');
    register_setting('avocadoweb-settings-group', 'avocadoweb_smtp_password');
    register_setting('avocadoweb-settings-group', 'avocadoweb_recaptcha_type');
    register_setting('avocadoweb-settings-group', 'avocadoweb_recaptcha_v2_site_key');
    register_setting('avocadoweb-settings-group', 'avocadoweb_recaptcha_v2_secret_key');
    register_setting('avocadoweb-settings-group', 'avocadoweb_recaptcha_v3_site_key');
    register_setting('avocadoweb-settings-group', 'avocadoweb_recaptcha_v3_secret_key');
    register_setting('avocadoweb-settings-group', 'avocadoweb_akismet_api_key');
    register_setting('avocadoweb-settings-group', 'avocadoweb_email_recipient');
}
add_action('admin_init', 'avocadoweb_register_settings');

// ✅ Render the Settings Page
function avocadoweb_settings_page() {
    ?>
    <style>
        .avocado-settings-box {
            background: #f9f9f9;
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 500px;
        }
    </style>
    <div class="wrap">
        <h1>Send It Form Settings</h1>
        <p>This is the settings page where you can provide information to ensure that the contact form will function with Brevo SMTP, reCAPTCHA, and Akismet.</p>

        <h2>How to Use the Contact Form</h2>
        <p>To display the contact form on any page or post, use the following shortcode:</p>
        <code>[send_it_contact_form]</code>

        <br><br><br>

        <form method="post" action="options.php">
            <?php settings_fields('avocadoweb-settings-group'); do_settings_sections('avocadoweb-settings-group'); ?>
            
            <div class="avocado-settings-box">
                <h2>Brevo SMTP Settings</h2>
                <label>SMTP Host</label>
                <input type="text" name="avocadoweb_smtp_host" value="<?php echo esc_attr(get_option('avocadoweb_smtp_host')); ?>">
                <br><br>
                <label>SMTP Port</label>
                <input type="text" name="avocadoweb_smtp_port" value="<?php echo esc_attr(get_option('avocadoweb_smtp_port')); ?>">
                <br><br>
                <label>SMTP Username</label>
                <input type="text" name="avocadoweb_smtp_username" value="<?php echo esc_attr(get_option('avocadoweb_smtp_username')); ?>">
                <br><br>
                <label>SMTP Password</label>
                <input type="password" name="avocadoweb_smtp_password" value="<?php echo esc_attr(get_option('avocadoweb_smtp_password')); ?>">
            </div>

            <div class="avocado-settings-box">
                <h2>reCAPTCHA Settings</h2>
                <label>reCAPTCHA Type</label>
                <select name="avocadoweb_recaptcha_type">
                    <option value="v2" <?php selected(get_option('avocadoweb_recaptcha_type'), 'v2'); ?>>reCAPTCHA v2</option>
                    <option value="v3" <?php selected(get_option('avocadoweb_recaptcha_type'), 'v3'); ?>>reCAPTCHA v3</option>
                </select>
                <br><br>
                <label>reCAPTCHA v2 Site Key</label>
                <input type="text" name="avocadoweb_recaptcha_v2_site_key" value="<?php echo esc_attr(get_option('avocadoweb_recaptcha_v2_site_key')); ?>">
                <br><br>
                <label>reCAPTCHA v2 Secret Key</label>
                <input type="text" name="avocadoweb_recaptcha_v2_secret_key" value="<?php echo esc_attr(get_option('avocadoweb_recaptcha_v2_secret_key')); ?>">
                <br><br>
                <label>reCAPTCHA v3 Site Key</label>
                <input type="text" name="avocadoweb_recaptcha_v3_site_key" value="<?php echo esc_attr(get_option('avocadoweb_recaptcha_v3_site_key')); ?>">
                <br><br>
                <label>reCAPTCHA v3 Secret Key</label>
                <input type="text" name="avocadoweb_recaptcha_v3_secret_key" value="<?php echo esc_attr(get_option('avocadoweb_recaptcha_v3_secret_key')); ?>">
            </div>

            <div class="avocado-settings-box">
                <h2>Akismet Spam Protection</h2>
                <label>Akismet API Key</label>
                <input type="text" name="avocadoweb_akismet_api_key" value="<?php echo esc_attr(get_option('avocadoweb_akismet_api_key')); ?>">
            </div>

            <div class="avocado-settings-box">
                <h2>Email Recipient</h2>
                <label>Email Address for Form Submissions</label>
                <input type="text" name="avocadoweb_email_recipient" value="<?php echo esc_attr(get_option('avocadoweb_email_recipient', 'info@avocadowebservices.com')); ?>" required>
            </div>
            
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

// Enqueue frontend script
function avocadoweb_enqueue_scripts() {
    wp_enqueue_script(
        'send-it-ajax',
        plugins_url('send-it-ajax.js', __FILE__),
        array('jquery'),
        '1.0',
        true
    );

    wp_localize_script('send-it-ajax', 'sendItAjax', array(
        'ajaxurl'  => admin_url('admin-ajax.php'),
        'security' => wp_create_nonce('send_it_form_nonce'),
    ));
}
add_action('wp_enqueue_scripts', 'avocadoweb_enqueue_scripts');

// Configure PHPMailer to use SMTP settings from options
function avocadoweb_configure_phpmailer($phpmailer) {
    $host     = get_option('avocadoweb_smtp_host');
    $port     = get_option('avocadoweb_smtp_port');
    $username = get_option('avocadoweb_smtp_username');
    $password = get_option('avocadoweb_smtp_password');

    if ($host && $port && $username && $password) {
        $phpmailer->isSMTP();
        $phpmailer->Host       = $host;
        $phpmailer->Port       = (int) $port;
        $phpmailer->SMTPAuth   = true;
        $phpmailer->Username   = $username;
        $phpmailer->Password   = $password;
    }
}
add_action('phpmailer_init', 'avocadoweb_configure_phpmailer');

// Shortcode output
function avocadoweb_contact_form_shortcode() {
    ob_start();
    ?>
    <form id="send-it-form">
        <?php wp_nonce_field('send_it_form_action', 'send_it_form_nonce_field'); ?>
        <p>
            <label for="send-it-name">Name</label><br>
            <input type="text" id="send-it-name" name="name" required>
        </p>
        <p>
            <label for="send-it-email">Email</label><br>
            <input type="email" id="send-it-email" name="email" required>
        </p>
        <p>
            <label for="send-it-message">Message</label><br>
            <textarea id="send-it-message" name="message" required></textarea>
        </p>
        <p>
            <button type="submit">Send</button>
        </p>
        <div id="send-it-response"></div>
    </form>
    <?php
    return ob_get_clean();
}
add_shortcode('send_it_contact_form', 'avocadoweb_contact_form_shortcode');

// AJAX handler for form submission
function avocadoweb_handle_form_submit() {
    check_ajax_referer('send_it_form_nonce', 'security');

    $name    = sanitize_text_field($_POST['name']);
    $email   = sanitize_email($_POST['email']);
    $message = sanitize_textarea_field($_POST['message']);

    $to      = get_option('avocadoweb_email_recipient');
    $subject = 'New Contact Form Submission';
    $body    = "Name: $name\nEmail: $email\n\n$message";

    $sent = wp_mail($to, $subject, $body);

    if ($sent) {
        wp_send_json_success('Message sent successfully.');
    } else {
        wp_send_json_error('Failed to send message.');
    }
}
add_action('wp_ajax_send_it_form_submit', 'avocadoweb_handle_form_submit');
add_action('wp_ajax_nopriv_send_it_form_submit', 'avocadoweb_handle_form_submit');

