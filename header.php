<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=<?php bloginfo('charset'); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="Cache-Control" content="no-siteapp">
    <meta name="renderer" content="webkit">
    <meta name="format-detection" content="telephone=no">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div class="box-wrap" style="height: auto !important;">

    <div class="header">
        <div class="logo-wrap">
            <a href="<?php echo esc_url(home_url('/')); ?>" title="<?php bloginfo('name'); ?>" class="logo-img-wrap">
                <?php 
                $logo_url = moment_get_option('logo_url');
                if ($logo_url): 
                ?>
                    <img src="<?php echo esc_url(moment_ensure_https($logo_url)); ?>" alt="<?php bloginfo('name'); ?> LOGO" class="logo">
                <?php elseif (has_custom_logo()): 
                    $custom_logo_id = get_theme_mod('custom_logo');
                    $logo_image = wp_get_attachment_image_src($custom_logo_id, 'full');
                    if ($logo_image):
                ?>
                    <img src="<?php echo esc_url($logo_image[0]); ?>" alt="<?php bloginfo('name'); ?> LOGO" class="logo">
                <?php 
                    endif;
                endif; 
                ?>
                <h1><?php bloginfo('name'); ?></h1>
            </a>
            <div class="sub-title"><?php bloginfo('description'); ?></div>
        </div>

        <div class="menu-header-container">
            <?php
            $nav_menu = moment_get_option('nav_menu');
            if (!empty($nav_menu)):
            ?>
            <ul id="menu-header" class="menu">
                <?php
                $menu_items = explode("\n", $nav_menu);
                foreach ($menu_items as $item):
                    $item = trim($item);
                    if (!empty($item)):
                        $parts = explode('|', $item, 2);
                        $text = isset($parts[0]) ? trim($parts[0]) : '';
                        $url = isset($parts[1]) ? trim($parts[1]) : '/';
                        if (!empty($text)):
                            if (!preg_match('/^(https?:\/\/|\/)/', $url)) {
                                $url = home_url('/') . $url;
                            } elseif (strpos($url, '/') === 0 && strpos($url, '//') !== 0) {
                                $url = home_url($url);
                            }
                            
                            $is_current = false;
                            $current_url = $_SERVER['REQUEST_URI'];
                            $menu_path = parse_url($url, PHP_URL_PATH);
                            $current_path = parse_url($current_url, PHP_URL_PATH);
                            
                            $menu_path = rtrim($menu_path ?: '/', '/');
                            $current_path = rtrim($current_path ?: '/', '/');
                            
                            if (is_front_page() || is_home()) {
                                if ($menu_path == '' || $menu_path == '/' || $url == home_url('/') || $url == rtrim(home_url('/'), '/') . '/') {
                                    $is_current = true;
                                }
                            } else {
                                if ($menu_path && $current_path && $menu_path === $current_path) {
                                    $is_current = true;
                                }
                            }
                ?>
                <li class="menu-item<?php if ($is_current): ?> current-menu-item<?php endif; ?>">
                    <a href="<?php echo esc_url($url); ?>" title="<?php echo esc_attr($text); ?>"><?php echo esc_html($text); ?></a>
                </li>
                <?php
                        endif;
                    endif;
                endforeach;
                ?>
            </ul>
            <?php elseif (has_nav_menu('primary')): ?>
            <?php 
            wp_nav_menu(array(
                'theme_location' => 'primary',
                'menu_id'        => 'menu-header',
                'menu_class'     => 'menu',
                'container'      => false,
            )); 
            ?>
            <?php endif; ?>
        </div>
    </div>
