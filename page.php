<?php
/**
 * 单页模板
 *
 * @package Moment
 */

get_header();
?>

<div class="main" style="height: auto !important;">
    <div class="top-bar">
        <div class="crumbs">
            <a href="<?php echo esc_url(home_url('/')); ?>">首页</a>
            <span><?php the_title(); ?></span>
        </div>
        <form class="search-form" method="get" action="<?php echo esc_url(home_url('/')); ?>">
            <button class="tficon icon-search" type="submit"></button>
            <input type="text" name="s" class="search-input" placeholder="输入关键词，回车搜索" value="">
        </form>
    </div>

    <?php if (have_posts()): while (have_posts()): the_post(); ?>
    <div class="post-wrap" id="post-wrap" style="height: auto !important;">
        <div class="post-header">
            <h1 class="post-title"><?php the_title(); ?></h1>
        </div>

        <div class="post-content" id="post-content">
            <?php the_content(); ?>
        </div>
    </div>
    <?php endwhile; endif; ?>
</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
