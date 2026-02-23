<?php
/**
 * 归档页模板（分类、标签、搜索等）
 *
 * @package Moment
 */

get_header();
?>

<div class="main" style="height: auto !important;">
    <div class="top-bar">
        <div class="crumbs">
            <a href="<?php echo esc_url(home_url('/')); ?>">首页</a>
            <h2><?php 
            if (is_category()) {
                single_cat_title();
            } elseif (is_tag()) {
                printf(__('标签 %s 下的文章', 'moment'), single_tag_title('', false));
            } elseif (is_author()) {
                printf(__('%s 发布的文章', 'moment'), get_the_author());
            } elseif (is_search()) {
                printf(__('包含关键字 %s 的文章', 'moment'), get_search_query());
            } elseif (is_date()) {
                if (is_day()) {
                    echo get_the_date();
                } elseif (is_month()) {
                    echo get_the_date('Y年n月');
                } elseif (is_year()) {
                    echo get_the_date('Y年');
                }
            } else {
                the_archive_title();
            }
            ?></h2>
        </div>
        <form class="search-form" method="get" action="<?php echo esc_url(home_url('/')); ?>">
            <button class="tficon icon-search" type="submit"></button>
            <input type="text" name="s" class="search-input" placeholder="输入关键词，回车搜索" value="<?php echo esc_attr(get_search_query()); ?>">
        </form>
    </div>

    <?php if (is_category()): ?>
        <ul id="menu-web" class="cat-tab-wrap">
            <li class="menu-item current-menu-item">
                <a href="<?php echo esc_url(get_category_link(get_queried_object_id())); ?>"><?php single_cat_title(); ?></a>
            </li>
        </ul>
    <?php endif; ?>

    <div class="post-list">
        <?php if (have_posts()): ?>
            <?php while (have_posts()): the_post(); ?>
                <?php $thumbnail_url = moment_get_cover(); ?>
                <div class="post-item">
                    <div class="post-item-cover">
                        <a class="post-item-img" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                        <?php if ($thumbnail_url): ?>
                            <img class="hover-scale" src="<?php echo esc_url($thumbnail_url); ?>" alt="<?php the_title_attribute(); ?>">
                        <?php else: ?>
                            <div style="width: 100%; height: 100%; background-color: #F6F8FF; display: flex; align-items: center; justify-content: center; color: #9DA0B3;">无图片</div>
                        <?php endif; ?>
                        </a>
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
                    </div>
                    <a href="<?php the_permalink(); ?>" class="post-item-title" title="<?php the_title_attribute(); ?>">
                        <h3><?php the_title(); ?></h3>
                    </a>
                    <div class="post-item-footer">
                        <div class="tag-wrap">
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
                        <div class="post-item-meta"><?php echo get_the_date('Y-m-d'); ?></div>
                    </div>
                    <p class="post-item-summary"><?php echo wp_trim_words(get_the_excerpt(), 100, '...'); ?></p>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="post-item">
                <p>没有找到内容</p>
            </div>
        <?php endif; ?>
    </div>

    <?php moment_pagination(); ?>
</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
