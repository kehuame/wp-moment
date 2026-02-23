<?php
/**
 * Moment 主题功能文件
 * 从 Typecho 移植到 WordPress
 *
 * @package Moment
 * @author kehua.me
 * @version 1.0.0
 */

if (!defined('ABSPATH')) exit;

/**
 * 主题设置
 */
function moment_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo', array(
        'height'      => 72,
        'width'       => 72,
        'flex-height' => true,
        'flex-width'  => true,
    ));
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));
    
    register_nav_menus(array(
        'primary' => __('左侧导航菜单', 'moment'),
    ));
}
add_action('after_setup_theme', 'moment_setup');

/**
 * 加载样式和脚本
 */
function moment_scripts() {
    wp_enqueue_style('moment-main-style', get_template_directory_uri() . '/css/style.css', array(), '1.0.0');
    wp_enqueue_style('moment-slider-style', get_template_directory_uri() . '/css/slider.css', array(), '1.0.0');
    
    wp_enqueue_script('jquery');
    wp_enqueue_script('moment-slider', get_template_directory_uri() . '/js/kehua_slider.js', array('jquery'), '1.0.0', true);
}
add_action('wp_enqueue_scripts', 'moment_scripts');

/**
 * 获取文章缩略图 URL（使用 WordPress 特色图片）
 */
function moment_get_cover($post_id = null) {
    if (!$post_id) $post_id = get_the_ID();
    
    if (has_post_thumbnail($post_id)) {
        return moment_ensure_https(get_the_post_thumbnail_url($post_id, 'large'));
    }
    
    return '';
}

/**
 * 将HTTP图片URL转换为HTTPS
 */
function moment_ensure_https($url) {
    if (empty($url)) return $url;
    
    if (preg_match('/^http:\/\//i', $url)) {
        $url = preg_replace('/^http:\/\//i', 'https://', $url);
    }
    
    return $url;
}

/**
 * 阅读统计
 */
function moment_get_post_views($post_id = null) {
    if (!$post_id) $post_id = get_the_ID();
    
    $views = get_post_meta($post_id, 'moment_views', true);
    return $views ? intval($views) : 0;
}

function moment_set_post_views($post_id = null) {
    if (!$post_id) $post_id = get_the_ID();
    
    if (!is_singular('post')) return;
    
    $cookie_name = 'moment_viewed_' . $post_id;
    if (isset($_COOKIE[$cookie_name])) return;
    
    $views = get_post_meta($post_id, 'moment_views', true);
    $views = $views ? intval($views) + 1 : 1;
    update_post_meta($post_id, 'moment_views', $views);
    
    setcookie($cookie_name, '1', time() + 86400, '/');
}
add_action('wp_head', 'moment_set_post_views');

/**
 * 获取主题选项
 */
function moment_get_option($key, $default = '') {
    $options = get_option('moment_options', array());
    return isset($options[$key]) ? $options[$key] : $default;
}

/**
 * 引入主题设置页面
 */
require_once get_template_directory() . '/inc/theme-options.php';

/**
 * 注册侧边栏
 */
function moment_widgets_init() {
    register_sidebar(array(
        'name'          => '首页侧边栏',
        'id'            => 'sidebar-home',
        'description'   => '首页右侧侧边栏',
        'before_widget' => '<div class="aside-block">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="block-title">',
        'after_title'   => '</h2>',
    ));
    
    register_sidebar(array(
        'name'          => '文章页侧边栏',
        'id'            => 'sidebar-single',
        'description'   => '文章页右侧侧边栏',
        'before_widget' => '<div class="aside-block block-wrap">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="block-title">',
        'after_title'   => '</h2>',
    ));
}
add_action('widgets_init', 'moment_widgets_init');

/**
 * 自定义摘要长度
 */
function moment_excerpt_length($length) {
    return 100;
}
add_filter('excerpt_length', 'moment_excerpt_length');

/**
 * 自定义摘要结尾
 */
function moment_excerpt_more($more) {
    return '...';
}
add_filter('excerpt_more', 'moment_excerpt_more');

/**
 * 分页导航
 */
function moment_pagination() {
    global $wp_query;
    
    $big = 999999999;
    $pages = paginate_links(array(
        'base'      => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
        'format'    => '?paged=%#%',
        'current'   => max(1, get_query_var('paged')),
        'total'     => $wp_query->max_num_pages,
        'type'      => 'array',
        'prev_text' => '&laquo;',
        'next_text' => '&raquo;',
        'mid_size'  => 2,
    ));
    
    if (is_array($pages)) {
        echo '<ul class="pagination">';
        foreach ($pages as $page) {
            $active = strpos($page, 'current') !== false ? ' class="active"' : '';
            echo '<li' . $active . '>' . $page . '</li>';
        }
        echo '</ul>';
    }
}

/**
 * 获取热门文章
 */
function moment_get_hot_posts($limit = 5, $category_id = null) {
    $args = array(
        'post_type'      => 'post',
        'post_status'    => 'publish',
        'posts_per_page' => $limit,
        'meta_key'       => 'moment_views',
        'orderby'        => 'meta_value_num',
        'order'          => 'DESC',
    );
    
    if ($category_id) {
        $args['cat'] = $category_id;
    }
    
    $query = new WP_Query($args);
    
    if (!$query->have_posts()) {
        $args['orderby'] = 'date';
        unset($args['meta_key']);
        $query = new WP_Query($args);
    }
    
    return $query;
}

/**
 * 获取相关文章
 */
function moment_get_related_posts($post_id, $limit = 4) {
    $categories = get_the_category($post_id);
    if (empty($categories)) return new WP_Query();
    
    $cat_ids = array();
    foreach ($categories as $cat) {
        $cat_ids[] = $cat->term_id;
    }
    
    $args = array(
        'post_type'      => 'post',
        'post_status'    => 'publish',
        'posts_per_page' => $limit,
        'category__in'   => $cat_ids,
        'post__not_in'   => array($post_id),
        'orderby'        => 'rand',
    );
    
    return new WP_Query($args);
}

/**
 * Body 类
 */
function moment_body_classes($classes) {
    if (is_front_page() || is_home()) {
        $classes[] = 'home';
        $classes[] = 'blog';
    }
    if (is_single()) {
        $classes[] = 'post-template-default';
        $classes[] = 'single';
        $classes[] = 'single-post';
    }
    if (is_archive()) {
        $classes[] = 'archive';
    }
    if (is_category()) {
        $classes[] = 'category';
    }
    return $classes;
}
add_filter('body_class', 'moment_body_classes');

/**
 * 幻灯片初始化脚本
 */
function moment_slider_init() {
    if (is_front_page() || is_home()) {
        $slider_posts = moment_get_option('slider_posts');
        if ($slider_posts) {
            ?>
            <script type="text/javascript">
            jQuery(document).ready(function($) {
                $(".slider-container").ikSlider({
                    speed: 500,
                    delay: 3000,
                    infinite: true
                });
            });
            </script>
            <?php
        }
    }
}
add_action('wp_footer', 'moment_slider_init');
