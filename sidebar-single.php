<?php
/**
 * 文章页侧边栏
 *
 * @package Moment
 */

global $post;
$current_post_id = $post->ID;
$related_posts = moment_get_related_posts($current_post_id, 4);
?>

<div class="aside" id="single-sidebar" style="height: auto !important;">
    <?php if ($related_posts->have_posts()): ?>
    <div class="aside-block block-wrap">
        <div class="single-relative">
            <h2 class="block-title">更多相关文章</h2>
            <div class="aside-post-list">
                <?php while ($related_posts->have_posts()): $related_posts->the_post(); 
                    $cover = moment_get_cover();
                    $categories = get_the_category();
                    $tags = get_the_tags();
                ?>
                <div class="post-item">
                    <div class="post-item-cover">
                        <a class="post-item-img" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                            <?php if ($cover): ?>
                                <img class="hover-scale" src="<?php echo esc_url($cover); ?>" alt="<?php the_title_attribute(); ?>">
                            <?php else: ?>
                                <div style="width: 100%; height: 100%; background-color: #F6F8FF; display: flex; align-items: center; justify-content: center; color: #9DA0B3;">无图片</div>
                            <?php endif; ?>
                        </a>
                        <ul class="post-categories">
                            <?php 
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
                            if ($tags):
                                $tag_count = 0;
                                foreach ($tags as $tag):
                                    if ($tag_count >= 5) break;
                            ?>
                            <a href="<?php echo esc_url(get_tag_link($tag->term_id)); ?>" rel="tag"><?php echo esc_html($tag->name); ?></a>
                            <?php 
                                    $tag_count++;
                                endforeach;
                            endif;
                            ?>
                        </div>
                        <div class="post-item-meta"><?php echo get_the_date('Y-m-d'); ?></div>
                    </div>
                    <p class="post-item-summary"><?php echo wp_trim_words(get_the_excerpt(), 100, '...'); ?></p>
                </div>
                <?php endwhile; wp_reset_postdata(); ?>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>
