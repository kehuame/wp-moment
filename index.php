<?php
/**
 * 首页模板
 *
 * @package Moment
 */

get_header();
?>

<div class="main" style="height: auto !important;">
    <?php 
    if (is_front_page() || is_home()):
        $slider_post_ids = moment_get_option('slider_posts');
        if ($slider_post_ids):
            $slider_ids = explode(',', $slider_post_ids);
            $slider_ids = array_map('trim', $slider_ids);
            $slider_ids = array_filter($slider_ids);
            if (!empty($slider_ids)):
    ?>
    <div class="pic-cover-list slider-container">
        <div class="slider has-touch">
            <?php foreach ($slider_ids as $slider_id): 
                $slider_post = get_post(intval($slider_id));
                if ($slider_post && $slider_post->post_status === 'publish'):
                    $cover = moment_get_cover($slider_post->ID);
            ?>
            <a href="<?php echo get_permalink($slider_post->ID); ?>" class="pic-cover-item slider__item">
                <?php if ($cover): ?>
                    <img src="<?php echo esc_url($cover); ?>" alt="<?php echo esc_attr($slider_post->post_title); ?>" class="pic-cover-item-img" draggable="false">
                <?php else: ?>
                    <div style="width: 100%; height: 405px; background-color: #F6F8FF; display: flex; align-items: center; justify-content: center; color: #9DA0B3;">无图片</div>
                <?php endif; ?>
                <div class="slider__caption">
                    <h3 class="pic-cover-item-title"><?php echo esc_html($slider_post->post_title); ?></h3>
                </div>
            </a>
            <?php 
                endif;
            endforeach; 
            ?>
        </div>
        <div class="slider__switch slider__switch--prev" data-ikslider-dir="prev">
            <span><svg xmlns="https://www.w3.org/2000/svg" viewBox="0 0 20 20">
                <path d="M13.89 17.418c.27.272.27.71 0 .98s-.7.27-.968 0l-7.83-7.91c-.268-.27-.268-.706 0-.978l7.83-7.908c.268-.27.7-.27.97 0s.267.71 0 .98L6.75 10l7.14 7.418z"></path>
            </svg></span>
        </div>
        <div class="slider__switch slider__switch--next" data-ikslider-dir="next">
            <span><svg xmlns="https://www.w3.org/2000/svg" viewBox="0 0 20 20">
                <path d="M13.25 10L6.11 2.58c-.27-.27-.27-.707 0-.98.267-.27.7-.27.968 0l7.83 7.91c.268.27.268.708 0 .978l-7.83 7.908c-.268.27-.7.27-.97 0s-.267-.707 0-.98L13.25 10z"></path>
            </svg></span>
        </div>
    </div>
    <?php 
            endif;
        endif;
    endif;
    ?>
    
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
