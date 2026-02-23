<?php
/**
 * 404 页面模板
 *
 * @package Moment
 */

get_header();
?>

<div class="main" style="height: auto !important;">
    <div class="top-bar">
        <div class="crumbs">
            <a href="<?php echo esc_url(home_url('/')); ?>">首页</a>
            <span>404 页面不存在</span>
        </div>
        <form class="search-form" method="get" action="<?php echo esc_url(home_url('/')); ?>">
            <button class="tficon icon-search" type="submit"></button>
            <input type="text" name="s" class="search-input" placeholder="输入关键词，回车搜索" value="">
        </form>
    </div>

    <div class="post-wrap" style="text-align: center; padding: 100px 0;">
        <h1 style="font-size: 120px; color: #364CC6; margin-bottom: 20px;">404</h1>
        <h2 style="font-size: 24px; color: #3E4252; margin-bottom: 20px;">页面不存在</h2>
        <p style="color: #9DA0B3; margin-bottom: 30px;">您访问的页面可能已被删除或不存在</p>
        <a href="<?php echo esc_url(home_url('/')); ?>" style="display: inline-block; padding: 12px 30px; background: #364CC6; color: #fff; border-radius: 25px; text-decoration: none;">返回首页</a>
    </div>
</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
