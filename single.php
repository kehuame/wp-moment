<?php
/**
 * 文章详情页模板
 *
 * @package Moment
 */

get_header();
?>

<div class="main" style="height: auto !important;">
    <div class="top-bar">
        <div class="crumbs">
            <a href="<?php echo esc_url(home_url('/')); ?>">首页</a>
            <?php 
            $categories = get_the_category();
            if (!empty($categories)):
                foreach ($categories as $cat):
            ?>
            <a href="<?php echo esc_url(get_category_link($cat->term_id)); ?>"><?php echo esc_html($cat->name); ?></a>
            <?php 
                endforeach;
            endif;
            ?>
            <span>本文内容</span>
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
            <div class="post-meta">
                <ul class="post-categories">
                    <?php 
                    $categories = get_the_category();
                    if (!empty($categories)):
                        foreach ($categories as $cat):
                    ?>
                    <li><a href="<?php echo esc_url(get_category_link($cat->term_id)); ?>" rel="category tag"><?php echo esc_html($cat->name); ?></a></li>
                    <?php 
                        endforeach;
                    endif;
                    ?>
                </ul>
                <?php echo get_the_date('Y-m-d'); ?>
                <?php $views = moment_get_post_views(); if ($views > 0): ?>
                <span class="post-views"><?php echo $views; ?> 次阅读</span>
                <?php endif; ?>
                <div class="tag-wrap post-header-tags">
                    <?php 
                    $tags = get_the_tags();
                    if ($tags):
                        foreach ($tags as $tag):
                    ?>
                    <a href="<?php echo esc_url(get_tag_link($tag->term_id)); ?>" rel="tag"><?php echo esc_html($tag->name); ?></a>
                    <?php 
                        endforeach;
                    endif;
                    ?>
                </div>
            </div>
        </div>

        <div class="post-content" id="post-content">
            <?php the_content(); ?>
        </div>

        <div class="post-list">
            <?php 
            $prev_post = get_previous_post();
            if ($prev_post):
                $prev_cover = moment_get_cover($prev_post->ID);
            ?>
            <div class="post-item">
                <div class="post-item-cover">
                    <a class="post-item-img" href="<?php echo get_permalink($prev_post->ID); ?>" title="<?php echo esc_attr($prev_post->post_title); ?>">
                        <?php if ($prev_cover): ?>
                            <img class="hover-scale" src="<?php echo esc_url($prev_cover); ?>" alt="<?php echo esc_attr($prev_post->post_title); ?>">
                        <?php else: ?>
                            <div style="width: 100%; height: 100%; background-color: #F6F8FF; display: flex; align-items: center; justify-content: center; color: #9DA0B3;">无图片</div>
                        <?php endif; ?>
                        <h5 class="single-prev-text"><i class="tficon icon-left"></i> 上一篇</h5>
                    </a>
                </div>
                <a href="<?php echo get_permalink($prev_post->ID); ?>" class="post-item-title" title="<?php echo esc_attr($prev_post->post_title); ?>">
                    <h3><?php echo esc_html($prev_post->post_title); ?></h3>
                </a>
            </div>
            <?php endif; ?>
            
            <?php 
            $next_post = get_next_post();
            if ($next_post):
                $next_cover = moment_get_cover($next_post->ID);
            ?>
            <div class="post-item">
                <div class="post-item-cover">
                    <a class="post-item-img" href="<?php echo get_permalink($next_post->ID); ?>" title="<?php echo esc_attr($next_post->post_title); ?>">
                        <?php if ($next_cover): ?>
                            <img class="hover-scale" src="<?php echo esc_url($next_cover); ?>" alt="<?php echo esc_attr($next_post->post_title); ?>">
                        <?php else: ?>
                            <div style="width: 100%; height: 100%; background-color: #F6F8FF; display: flex; align-items: center; justify-content: center; color: #9DA0B3;">无图片</div>
                        <?php endif; ?>
                        <h5 class="single-next-text"><i class="tficon icon-right"></i> 下一篇</h5>
                    </a>
                </div>
                <a href="<?php echo get_permalink($next_post->ID); ?>" class="post-item-title" title="<?php echo esc_attr($next_post->post_title); ?>">
                    <h3><?php echo esc_html($next_post->post_title); ?></h3>
                </a>
            </div>
            <?php endif; ?>
        </div>
    </div>
    <?php endwhile; endif; ?>
</div>

<?php get_sidebar('single'); ?>
<?php get_footer(); ?>
