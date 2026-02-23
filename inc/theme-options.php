<?php
/**
 * Moment 主题设置页面
 * 在后台左侧菜单显示
 *
 * @package Moment
 */

if (!defined('ABSPATH')) exit;

/**
 * 添加主题设置菜单到后台左侧
 */
function moment_add_admin_menu() {
    add_menu_page(
        'Moment 主题设置',
        'Moment 设置',
        'manage_options',
        'moment-settings',
        'moment_options_page',
        'dashicons-admin-customizer',
        61
    );
}
add_action('admin_menu', 'moment_add_admin_menu');

/**
 * 注册设置
 */
function moment_settings_init() {
    register_setting('moment_options_group', 'moment_options', 'moment_sanitize_options');
    
    add_settings_section(
        'moment_section_general',
        '基本设置',
        'moment_section_general_callback',
        'moment-settings'
    );
    
    add_settings_field(
        'logo_url',
        '站点 LOGO 地址',
        'moment_logo_url_callback',
        'moment-settings',
        'moment_section_general'
    );
    
    add_settings_field(
        'slider_posts',
        '首页幻灯片文章ID',
        'moment_slider_posts_callback',
        'moment-settings',
        'moment_section_general'
    );
    
    add_settings_field(
        'nav_menu',
        '左侧导航菜单',
        'moment_nav_menu_callback',
        'moment-settings',
        'moment_section_general'
    );
    
    add_settings_field(
        'footer_copyright',
        '底部版权信息',
        'moment_footer_copyright_callback',
        'moment-settings',
        'moment_section_general'
    );
    
    add_settings_section(
        'moment_section_sidebar',
        '侧边栏设置',
        'moment_section_sidebar_callback',
        'moment-settings'
    );
    
    add_settings_field(
        'sidebar_block_title',
        '首页右侧推荐板块标题',
        'moment_sidebar_block_title_callback',
        'moment-settings',
        'moment_section_sidebar'
    );
    
    add_settings_field(
        'sidebar_block_items',
        '首页右侧推荐板块内容',
        'moment_sidebar_block_items_callback',
        'moment-settings',
        'moment_section_sidebar'
    );
}
add_action('admin_init', 'moment_settings_init');

/**
 * 清理选项
 */
function moment_sanitize_options($input) {
    $sanitized = array();
    
    if (isset($input['logo_url'])) {
        $sanitized['logo_url'] = esc_url_raw($input['logo_url']);
    }
    
    if (isset($input['slider_posts'])) {
        $sanitized['slider_posts'] = sanitize_text_field($input['slider_posts']);
    }
    
    if (isset($input['nav_menu'])) {
        $sanitized['nav_menu'] = wp_kses_post($input['nav_menu']);
    }
    
    if (isset($input['footer_copyright'])) {
        $sanitized['footer_copyright'] = wp_kses_post($input['footer_copyright']);
    }
    
    if (isset($input['sidebar_block_title'])) {
        $sanitized['sidebar_block_title'] = sanitize_text_field($input['sidebar_block_title']);
    }
    
    if (isset($input['sidebar_block_items'])) {
        $sanitized['sidebar_block_items'] = wp_kses_post($input['sidebar_block_items']);
    }
    
    return $sanitized;
}

/**
 * 基本设置区域说明
 */
function moment_section_general_callback() {
    echo '<p>配置主题的基本显示选项。</p>';
}

/**
 * 侧边栏设置区域说明
 */
function moment_section_sidebar_callback() {
    echo '<p>配置首页右侧侧边栏的推荐内容。</p>';
}

/**
 * Logo URL 字段
 */
function moment_logo_url_callback() {
    $options = get_option('moment_options', array());
    $value = isset($options['logo_url']) ? $options['logo_url'] : '';
    ?>
    <input type="url" id="logo_url" name="moment_options[logo_url]" 
           value="<?php echo esc_attr($value); ?>" class="regular-text">
    <p class="description">在这里填入一个图片 URL 地址，以在网站标题前加上一个 LOGO</p>
    <?php
}

/**
 * 幻灯片文章ID字段
 */
function moment_slider_posts_callback() {
    $options = get_option('moment_options', array());
    $value = isset($options['slider_posts']) ? $options['slider_posts'] : '';
    ?>
    <input type="text" id="slider_posts" name="moment_options[slider_posts]" 
           value="<?php echo esc_attr($value); ?>" class="regular-text">
    <p class="description">填写要在首页幻灯片显示的文章ID，多个ID用英文逗号分隔，例如：1,2,3,4,5</p>
    <?php
}

/**
 * 导航菜单字段
 */
function moment_nav_menu_callback() {
    $options = get_option('moment_options', array());
    $value = isset($options['nav_menu']) ? $options['nav_menu'] : '';
    ?>
    <textarea id="nav_menu" name="moment_options[nav_menu]" 
              rows="6" class="large-text"><?php echo esc_textarea($value); ?></textarea>
    <p class="description">每行一个导航项，格式：链接文字|链接地址。<br>
    例如：首页|/ 或 关于|/about/ 或 分类|/category/travel/<br>
    留空则不显示任何菜单项。也可以使用 外观 > 菜单 来管理导航。</p>
    <?php
}

/**
 * 底部版权信息字段
 */
function moment_footer_copyright_callback() {
    $options = get_option('moment_options', array());
    $value = isset($options['footer_copyright']) ? $options['footer_copyright'] : '';
    ?>
    <textarea id="footer_copyright" name="moment_options[footer_copyright]" 
              rows="4" class="large-text"><?php echo esc_textarea($value); ?></textarea>
    <p class="description">自定义底部版权信息，支持 HTML 代码。留空则只显示默认版权信息。</p>
    <?php
}

/**
 * 推荐板块标题字段
 */
function moment_sidebar_block_title_callback() {
    $options = get_option('moment_options', array());
    $value = isset($options['sidebar_block_title']) ? $options['sidebar_block_title'] : '推荐内容';
    ?>
    <input type="text" id="sidebar_block_title" name="moment_options[sidebar_block_title]" 
           value="<?php echo esc_attr($value); ?>" class="regular-text">
    <p class="description">设置首页右侧顶部推荐板块的标题</p>
    <?php
}

/**
 * 推荐板块内容字段
 */
function moment_sidebar_block_items_callback() {
    $options = get_option('moment_options', array());
    $value = isset($options['sidebar_block_items']) ? $options['sidebar_block_items'] : '';
    ?>
    <textarea id="sidebar_block_items" name="moment_options[sidebar_block_items]" 
              rows="5" class="large-text"><?php echo esc_textarea($value); ?></textarea>
    <p class="description">每行一个推荐项，格式：标题|缩略图URL|链接地址。最多3个。<br>
    例如：<br>
    精选文章|https://example.com/image1.jpg|https://example.com/post1<br>
    热门推荐|https://example.com/image2.jpg|https://example.com/post2</p>
    <?php
}

/**
 * 设置页面内容
 */
function moment_options_page() {
    if (!current_user_can('manage_options')) {
        return;
    }
    
    if (isset($_GET['settings-updated'])) {
        add_settings_error('moment_messages', 'moment_message', '设置已保存', 'updated');
    }
    
    settings_errors('moment_messages');
    ?>
    <div class="wrap">
        <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
        
        <div style="background: #fff; padding: 20px; margin: 20px 0; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
            <h2 style="margin-top: 0;">Moment 此刻主题</h2>
            <p>这是一款三栏简约博客主题，刻画kehua.me</p>
            <p>作者：<a href="https://kehua.me" target="_blank">刻画kehua.me</a></p>
        </div>
        
        <form action="options.php" method="post">
            <?php
            settings_fields('moment_options_group');
            do_settings_sections('moment-settings');
            submit_button('保存设置');
            ?>
        </form>
        
        <div style="margin-top: 40px;">
            <h2 style="font-size: 20px; margin-bottom: 20px; padding-bottom: 10px; border-bottom: 1px solid #ddd;">更多主题推荐</h2>
            <div style="display: flex; flex-wrap: wrap; gap: 20px;">
                
                <div style="width: 280px; background: #fff; border-radius: 8px; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                    <a href="https://www.kehua.me/pengyouquan-wordpress.html" target="_blank" style="display: block;">
                        <img src="https://kehua.me/usr/uploads/2026/02/3087334282.jpg" alt="朋友圈主题" style="width: 100%; height: 160px; object-fit: cover; display: block;">
                    </a>
                    <div style="padding: 15px;">
                        <h3 style="margin: 0 0 10px 0; font-size: 16px;">Pengyouquan 朋友圈</h3>
                        <p style="color: #666; font-size: 13px; margin: 0 0 15px 0;">仿微信朋友圈风格的 WordPress 主题，支持图片、视频、评论、点赞等功能。</p>
                        <a href="https://www.kehua.me/pengyouquan-wordpress.html" target="_blank" style="display: inline-block; padding: 8px 16px; background: #364CC6; color: #fff; border-radius: 4px; text-decoration: none; font-size: 13px;">了解更多</a>
                    </div>
                </div>
                
                <div style="width: 280px; background: #fff; border-radius: 8px; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                    <a href="https://www.kehua.me/photography.html" target="_blank" style="display: block;">
                        <img src="https://kehua.me/usr/uploads/2026/02/2623458232.jpg" alt="摄影主题" style="width: 100%; height: 160px; object-fit: cover; display: block;">
                    </a>
                    <div style="padding: 15px;">
                        <h3 style="margin: 0 0 10px 0; font-size: 16px;">Photography 摄影</h3>
                        <p style="color: #666; font-size: 13px; margin: 0 0 15px 0;">摄影作品展示主题，支持瀑布流布局、幻灯片轮播、弹窗预览等功能。</p>
                        <a href="https://www.kehua.me/photography.html" target="_blank" style="display: inline-block; padding: 8px 16px; background: #364CC6; color: #fff; border-radius: 4px; text-decoration: none; font-size: 13px;">了解更多</a>
                    </div>
                </div>
                
                <div style="width: 280px; background: #fff; border-radius: 8px; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                    <a href="https://kehua.me" target="_blank" style="display: block;">
                        <img src="https://kehua.me/usr/uploads/2026/02/3842386183.jpg" alt="更多主题" style="width: 100%; height: 160px; object-fit: cover; display: block;">
                    </a>
                    <div style="padding: 15px;">
                        <h3 style="margin: 0 0 10px 0; font-size: 16px;">探索更多</h3>
                        <p style="color: #666; font-size: 13px; margin: 0 0 15px 0;">访问刻画官网，发现更多精美的 WordPress 和 Typecho 主题。</p>
                        <a href="https://kehua.me" target="_blank" style="display: inline-block; padding: 8px 16px; background: #364CC6; color: #fff; border-radius: 4px; text-decoration: none; font-size: 13px;">访问官网</a>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
    <?php
}

/**
 * 添加设置页面样式
 */
function moment_admin_styles($hook) {
    if ($hook !== 'toplevel_page_moment-settings') return;
    ?>
    <style>
        .form-table th {
            width: 200px;
            padding: 20px 10px 20px 0;
        }
        .form-table td {
            padding: 15px 10px;
        }
        .form-table textarea {
            font-family: Consolas, Monaco, monospace;
        }
        .wrap h1 {
            font-size: 24px;
            margin-bottom: 20px;
        }
        .wrap h2 {
            font-size: 18px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
        }
        .wrap h2:first-of-type {
            border-top: none;
            padding-top: 0;
        }
    </style>
    <?php
}
add_action('admin_head', 'moment_admin_styles');
