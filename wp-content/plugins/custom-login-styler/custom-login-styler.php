<?php
/**
 * Plugin Name: Custom Login Styler
 * Plugin URI: https://calparglobal.com
 * Description: Customizes the WordPress login page with configurable branding and themes
 * Version: 2.0.1
 * Author: Calpar Global
 * Author URI: https://calparglobal.com
 * License: GPL-2.0+
 * Text Domain: custom-login-styler
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

class Custom_Login_Styler {

    /**
     * Initialize the plugin
     */
    public function __construct() {
        // Add settings page
        add_action('admin_menu', array($this, 'add_settings_page'));
        add_action('admin_init', array($this, 'register_settings'));
        
        // Login page customization
        add_action('login_enqueue_scripts', array($this, 'custom_login_logo'));
        add_action('login_head', array($this, 'custom_login_page_css'));
        add_filter('login_headerurl', array($this, 'login_logo_url'));
        add_filter('login_headertext', array($this, 'login_logo_title'));
    }

    /**
     * Add settings page to admin menu
     */
    public function add_settings_page() {
        add_options_page(
            'Custom Login Styler Settings',
            'Login Styler',
            'manage_options',
            'custom-login-styler',
            array($this, 'settings_page_content')
        );
    }

    /**
     * Register plugin settings
     */
    public function register_settings() {
        register_setting('cls_settings_group', 'cls_settings', array($this, 'sanitize_settings'));

        add_settings_section(
            'cls_logo_section',
            'Logo Settings',
            array($this, 'logo_section_callback'),
            'custom-login-styler'
        );

        add_settings_section(
            'cls_style_section',
            'Style Settings',
            array($this, 'style_section_callback'),
            'custom-login-styler'
        );

        // Logo settings
        add_settings_field(
            'cls_logo_url',
            'Logo URL',
            array($this, 'logo_url_callback'),
            'custom-login-styler',
            'cls_logo_section'
        );

        add_settings_field(
            'cls_logo_width',
            'Logo Width',
            array($this, 'logo_width_callback'),
            'custom-login-styler',
            'cls_logo_section'
        );

        add_settings_field(
            'cls_logo_height',
            'Logo Height',
            array($this, 'logo_height_callback'),
            'custom-login-styler',
            'cls_logo_section'
        );

        // Style settings
        add_settings_field(
            'cls_theme',
            'Theme',
            array($this, 'theme_callback'),
            'custom-login-styler',
            'cls_style_section'
        );

        add_settings_field(
            'cls_bg_color',
            'Background Color',
            array($this, 'bg_color_callback'),
            'custom-login-styler',
            'cls_style_section'
        );

        add_settings_field(
            'cls_form_bg_color',
            'Form Background Color',
            array($this, 'form_bg_color_callback'),
            'custom-login-styler',
            'cls_style_section'
        );

        add_settings_field(
            'cls_text_color',
            'Text Color',
            array($this, 'text_color_callback'),
            'custom-login-styler',
            'cls_style_section'
        );

        add_settings_field(
            'cls_button_color',
            'Button Color',
            array($this, 'button_color_callback'),
            'custom-login-styler',
            'cls_style_section'
        );
    }

    /**
     * Sanitize settings
     */
    public function sanitize_settings($input) {
        $new_input = array();
        
        // Logo settings
        if(isset($input['logo_url']))
            $new_input['logo_url'] = esc_url_raw($input['logo_url']);
            
        if(isset($input['logo_width']))
            $new_input['logo_width'] = sanitize_text_field($input['logo_width']);
            
        if(isset($input['logo_height']))
            $new_input['logo_height'] = sanitize_text_field($input['logo_height']);
            
        // Style settings
        if(isset($input['theme']))
            $new_input['theme'] = sanitize_text_field($input['theme']);
            
        if(isset($input['bg_color']))
            $new_input['bg_color'] = sanitize_hex_color($input['bg_color']);
            
        if(isset($input['form_bg_color']))
            $new_input['form_bg_color'] = sanitize_hex_color($input['form_bg_color']);
            
        if(isset($input['text_color']))
            $new_input['text_color'] = sanitize_hex_color($input['text_color']);
            
        if(isset($input['button_color']))
            $new_input['button_color'] = sanitize_hex_color($input['button_color']);
            
        return $new_input;
    }

    /**
     * Section callbacks
     */
    public function logo_section_callback() {
        echo '<p>Configure your custom login logo</p>';
    }

    public function style_section_callback() {
        echo '<p>Configure the login page style</p>';
    }

    /**
     * Field callbacks
     */
    public function logo_url_callback() {
        $settings = get_option('cls_settings');
        $value = isset($settings['logo_url']) ? $settings['logo_url'] : '';
        ?>
        <input type="text" id="cls_logo_url" name="cls_settings[logo_url]" value="<?php echo esc_attr($value); ?>" class="regular-text">
        <button type="button" class="button cls-media-button">Select Image</button>
        <p class="description">URL to your custom logo</p>
        <?php
    }

    public function logo_width_callback() {
        $settings = get_option('cls_settings');
        $value = isset($settings['logo_width']) ? $settings['logo_width'] : '100%';
        ?>
        <input type="text" id="cls_logo_width" name="cls_settings[logo_width]" value="<?php echo esc_attr($value); ?>" class="regular-text">
        <p class="description">Width of your logo (e.g., 100% or 200px)</p>
        <?php
    }

    public function logo_height_callback() {
        $settings = get_option('cls_settings');
        $value = isset($settings['logo_height']) ? $settings['logo_height'] : '80px';
        ?>
        <input type="text" id="cls_logo_height" name="cls_settings[logo_height]" value="<?php echo esc_attr($value); ?>" class="regular-text">
        <p class="description">Height of your logo (e.g., 80px)</p>
        <?php
    }

    public function theme_callback() {
        $settings = get_option('cls_settings');
        $value = isset($settings['theme']) ? $settings['theme'] : 'dark';
        ?>
        <select id="cls_theme" name="cls_settings[theme]">
            <option value="default" <?php selected($value, 'default'); ?>>WordPress Default</option>
            <option value="dark" <?php selected($value, 'dark'); ?>>Dark</option>
            <option value="light" <?php selected($value, 'light'); ?>>Light</option>
            <option value="custom" <?php selected($value, 'custom'); ?>>Custom</option>
        </select>
        <p class="description">Choose a predefined theme or select custom to use your custom colors</p>
        <?php
    }

    public function bg_color_callback() {
        $settings = get_option('cls_settings');
        $value = isset($settings['bg_color']) ? $settings['bg_color'] : '#000000';
        ?>
        <input type="text" id="cls_bg_color" name="cls_settings[bg_color]" value="<?php echo esc_attr($value); ?>" class="cls-color-picker">
        <p class="description">Background color of the login page</p>
        <?php
    }

    public function form_bg_color_callback() {
        $settings = get_option('cls_settings');
        $value = isset($settings['form_bg_color']) ? $settings['form_bg_color'] : '#222222';
        ?>
        <input type="text" id="cls_form_bg_color" name="cls_settings[form_bg_color]" value="<?php echo esc_attr($value); ?>" class="cls-color-picker">
        <p class="description">Background color of the login form</p>
        <?php
    }

    public function text_color_callback() {
        $settings = get_option('cls_settings');
        $value = isset($settings['text_color']) ? $settings['text_color'] : '#ffffff';
        ?>
        <input type="text" id="cls_text_color" name="cls_settings[text_color]" value="<?php echo esc_attr($value); ?>" class="cls-color-picker">
        <p class="description">Color of text on the login page</p>
        <?php
    }

    public function button_color_callback() {
        $settings = get_option('cls_settings');
        $value = isset($settings['button_color']) ? $settings['button_color'] : '#333333';
        ?>
        <input type="text" id="cls_button_color" name="cls_settings[button_color]" value="<?php echo esc_attr($value); ?>" class="cls-color-picker">
        <p class="description">Color of the login button</p>
        <?php
    }

    /**
     * Settings page content
     */
    public function settings_page_content() {
        ?>
        <div class="wrap">
            <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
            <form method="post" action="options.php">
                <?php
                settings_fields('cls_settings_group');
                do_settings_sections('custom-login-styler');
                submit_button('Save Settings');
                ?>
            </form>
        </div>

        <script>
            jQuery(document).ready(function($) {
                // Initialize color pickers
                $('.cls-color-picker').wpColorPicker();
                
                // Media uploader for logo
                $('.cls-media-button').click(function(e) {
                    e.preventDefault();
                    
                    var image_frame;
                    
                    if(image_frame){
                        image_frame.open();
                    }
                    
                    // Define image_frame
                    image_frame = wp.media({
                        title: 'Select a Logo',
                        multiple : false,
                        library : {
                            type : 'image',
                        }
                    });
                    
                    image_frame.on('select', function() {
                        var attachment = image_frame.state().get('selection').first().toJSON();
                        $('#cls_logo_url').val(attachment.url);
                    });
                    
                    image_frame.open();
                });

                // Toggle custom color fields based on theme selection
                function toggleCustomColors() {
                    if ($('#cls_theme').val() === 'custom') {
                        $('.cls-color-picker').closest('tr').show();
                    } else {
                        $('.cls-color-picker').closest('tr').hide();
                    }
                }
                
                $('#cls_theme').on('change', toggleCustomColors);
                toggleCustomColors();
            });
        </script>
        <?php
    }

    /**
     * Enqueue admin scripts
     */
    public function enqueue_admin_scripts() {
        wp_enqueue_media();
        wp_enqueue_style('wp-color-picker');
        wp_enqueue_script('wp-color-picker');
    }

    /**
     * Custom login logo
     */
    public function custom_login_logo() {
        $settings = get_option('cls_settings');
        
        $logo_url = isset($settings['logo_url']) && !empty($settings['logo_url']) 
            ? $settings['logo_url'] 
            : '';
            
        if (empty($logo_url)) {
            return;
        }
        
        $logo_width = isset($settings['logo_width']) && !empty($settings['logo_width']) 
            ? $settings['logo_width'] 
            : '100%';
            
        $logo_height = isset($settings['logo_height']) && !empty($settings['logo_height']) 
            ? $settings['logo_height'] 
            : '80px';
        
        ?>
        <style type="text/css">
            body.login h1 a {
                background-image: url('<?php echo esc_url($logo_url); ?>') !important;
                background-size: contain !important;
                width: <?php echo esc_attr($logo_width); ?> !important;
                height: <?php echo esc_attr($logo_height); ?> !important;
            }
        </style>
        <?php
    }

    /**
     * Custom login page styles
     */
    public function custom_login_page_css() {
        $settings = get_option('cls_settings');
        $theme = isset($settings['theme']) ? $settings['theme'] : 'dark';
        
        // If default theme, don't apply custom styles
        if ($theme === 'default') {
            return;
        }
        
        // Preset theme styles
        if ($theme === 'dark') {
            $bg_color = '#000000';
            $form_bg_color = '#222222';
            $text_color = '#ffffff';
            $button_color = '#333333';
        } elseif ($theme === 'light') {
            $bg_color = '#f5f5f5';
            $form_bg_color = '#ffffff';
            $text_color = '#333333';
            $button_color = '#0073aa';
        } else {
            // Custom colors
            $bg_color = isset($settings['bg_color']) && !empty($settings['bg_color']) 
                ? $settings['bg_color'] 
                : '#000000';
                
            $form_bg_color = isset($settings['form_bg_color']) && !empty($settings['form_bg_color']) 
                ? $settings['form_bg_color'] 
                : '#222222';
                
            $text_color = isset($settings['text_color']) && !empty($settings['text_color']) 
                ? $settings['text_color'] 
                : '#ffffff';
                
            $button_color = isset($settings['button_color']) && !empty($settings['button_color']) 
                ? $settings['button_color'] 
                : '#333333';
        }
        
        // Calculate hover and border colors based on the button color
        $button_hover_color = $this->adjust_brightness($button_color, 20);
        $button_border_color = $this->adjust_brightness($button_color, 10);
        
        // Invert logo for dark themes
        $invert_logo = ($theme === 'dark' || $this->is_dark_color($bg_color)) ? 'filter: brightness(0) invert(1);' : '';
        
        ?>
        <style type="text/css">
            body.login {
                background-color: <?php echo esc_attr($bg_color); ?>;
            }
            
            .login h1 a {
                <?php echo $invert_logo; ?>
            }
            
            .login form {
                background-color: <?php echo esc_attr($form_bg_color); ?>;
                color: <?php echo esc_attr($text_color); ?>;
                border: 1px solid <?php echo esc_attr($this->adjust_brightness($form_bg_color, 10)); ?>;
            }
            
            .login label {
                color: <?php echo esc_attr($text_color); ?>;
            }
            
            .login .message,
            .login #login_error {
                background-color: <?php echo esc_attr($form_bg_color); ?>;
                color: <?php echo esc_attr($text_color); ?>;
                border-left: 4px solid #00a0d2;
            }
            
            .login .button-primary {
                background-color: <?php echo esc_attr($button_color); ?>;
                border-color: <?php echo esc_attr($button_border_color); ?>;
                color: <?php echo $this->is_dark_color($button_color) ? '#ffffff' : '#000000'; ?>;
            }
            
            .login .button-primary:hover,
            .login .button-primary:focus {
                background-color: <?php echo esc_attr($button_hover_color); ?>;
                border-color: <?php echo esc_attr($this->adjust_brightness($button_border_color, 10)); ?>;
            }
            
            .login #nav a, 
            .login #backtoblog a {
                color: <?php echo $this->is_dark_color($bg_color) ? '#dddddd' : '#333333'; ?> !important;
            }
            
            .login #nav a:hover, 
            .login #backtoblog a:hover {
                color: <?php echo $this->is_dark_color($bg_color) ? '#ffffff' : '#000000'; ?> !important;
            }
        </style>
        <?php
    }

    /**
     * Change login logo URL to point to the site home
     */
    public function login_logo_url() {
        return home_url();
    }

    /**
     * Change login logo title
     */
    public function login_logo_title() {
        return get_bloginfo('name');
    }

    /**
     * Utility function to adjust color brightness
     */
    private function adjust_brightness($hex, $steps) {
        // Steps should be between -255 and 255. Negative = darker, positive = lighter
        $steps = max(-255, min(255, $steps));
        
        // Format the hex color string
        $hex = str_replace('#', '', $hex);
        if (strlen($hex) == 3) {
            $hex = str_repeat(substr($hex, 0, 1), 2) . str_repeat(substr($hex, 1, 1), 2) . str_repeat(substr($hex, 2, 1), 2);
        }
        
        // Get decimal values
        $r = hexdec(substr($hex, 0, 2));
        $g = hexdec(substr($hex, 2, 2));
        $b = hexdec(substr($hex, 4, 2));
        
        // Adjust
        $r = max(0, min(255, $r + $steps));
        $g = max(0, min(255, $g + $steps));
        $b = max(0, min(255, $b + $steps));
        
        // Convert to hex
        $r_hex = str_pad(dechex($r), 2, '0', STR_PAD_LEFT);
        $g_hex = str_pad(dechex($g), 2, '0', STR_PAD_LEFT);
        $b_hex = str_pad(dechex($b), 2, '0', STR_PAD_LEFT);
        
        return '#' . $r_hex . $g_hex . $b_hex;
    }

    /**
     * Utility function to check if a color is dark
     */
    private function is_dark_color($hex) {
        $hex = str_replace('#', '', $hex);
        $r = hexdec(substr($hex, 0, 2));
        $g = hexdec(substr($hex, 2, 2));
        $b = hexdec(substr($hex, 4, 2));
        
        // Calculate brightness (YIQ equation)
        $brightness = (($r * 299) + ($g * 587) + ($b * 114)) / 1000;
        
        return $brightness < 128;
    }
}

// Initialize the plugin
function cls_init() {
    $cls = new Custom_Login_Styler();
    
    // Add action to enqueue admin scripts
    add_action('admin_enqueue_scripts', array($cls, 'enqueue_admin_scripts'));
}
add_action('plugins_loaded', 'cls_init');