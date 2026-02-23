<?php
/**
 * 首页/归档页侧边栏
 *
 * @package Moment
 */
?>

<div class="aside" style="height: auto !important;">
    <?php if (is_category()): 
        $current_cat_id = get_queried_object_id();
        $hot_posts = moment_get_hot_posts(5, $current_cat_id);
        if ($hot_posts->have_posts()):
    ?>
    <div class="aside-block">
        <h2 class="block-title">
            <i class="tficon icon-fire-line"></i> 本栏目热门文章
        </h2>
        <div class="sidebar-post-list">
            <?php while ($hot_posts->have_posts()): $hot_posts->the_post(); 
                $cover = moment_get_cover();
            ?>
            <div class="sider-post-item">
                <a class="sider-post-item-img" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                    <?php if ($cover): ?>
                        <img class="hover-scale" src="<?php echo esc_url($cover); ?>" alt="<?php the_title_attribute(); ?>">
                    <?php else: ?>
                        <div style="width: 128px; height: 104px; background-color: #F6F8FF; display: flex; align-items: center; justify-content: center; color: #9DA0B3; font-size: 12px; border-radius: 16px;">无图片</div>
                    <?php endif; ?>
                </a>
                <a class="sider-post-item-title" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                    <h3><?php the_title(); ?></h3>
                </a>
            </div>
            <?php endwhile; wp_reset_postdata(); ?>
        </div>
    </div>
    <?php 
        endif;
    else: 
    ?>
    
    <?php if (!is_search()): ?>
    <div class="aside-block">
        <div class="top-bar">
            <form class="search-form" method="get" action="<?php echo esc_url(home_url('/')); ?>">
                <button class="tficon icon-search" type="submit"></button>
                <input type="text" name="s" class="search-input" placeholder="输入关键词，回车搜索" value="<?php echo esc_attr(get_search_query()); ?>">
            </form>
        </div>
        
        <?php 
        $sidebar_block_title = moment_get_option('sidebar_block_title', '推荐内容');
        $sidebar_block_items = moment_get_option('sidebar_block_items');
        
        if ($sidebar_block_items):
            $items = explode("\n", trim($sidebar_block_items));
            $items = array_filter(array_map('trim', $items));
            $items = array_slice($items, 0, 3);
            
            if (!empty($items)):
        ?>
        <div class="block-wrap">
            <h2 class="block-title"><?php echo esc_html($sidebar_block_title); ?></h2>
            <div class="photo-list">
                <?php 
                foreach ($items as $item):
                    $parts = explode('|', $item);
                    if (count($parts) >= 3):
                        $item_title = trim($parts[0]);
                        $item_image = trim($parts[1]);
                        $item_link = trim($parts[2]);
                ?>
                <a href="<?php echo esc_url($item_link); ?>" title="<?php echo esc_attr($item_title); ?>" class="photo-item" target="_blank">
                    <?php if ($item_image): ?>
                        <img src="<?php echo esc_url(moment_ensure_https($item_image)); ?>" alt="<?php echo esc_attr($item_title); ?>" class="photo-item-img hover-scale">
                    <?php else: ?>
                        <div style="width: 100%; height: 100%; background-color: #F6F8FF; display: flex; align-items: center; justify-content: center; color: #9DA0B3; font-size: 12px;">无图片</div>
                    <?php endif; ?>
                    <div class="photo-item-inner">
                        <h3 class="photo-item-title"><?php echo esc_html($item_title); ?></h3>
                    </div>
                </a>
                <?php 
                    endif;
                endforeach; 
                ?>
            </div>
        </div>
        <?php 
            endif;
        endif; 
        ?>
    </div>
    <?php endif; ?>
    
    <?php 
    $hot_posts = moment_get_hot_posts(5);
    if ($hot_posts->have_posts()):
    ?>
    <div class="aside-block block-wrap">
        <h2 class="block-title">
            <a href="<?php echo esc_url(home_url('/')); ?>">热门文章<i class="tficon icon-right"></i></a>
        </h2>
        <div class="sidebar-post-list">
            <?php while ($hot_posts->have_posts()): $hot_posts->the_post(); 
                $cover = moment_get_cover();
            ?>
            <div class="sider-post-item">
                <a class="sider-post-item-img" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                    <?php if ($cover): ?>
                        <img class="hover-scale" src="<?php echo esc_url($cover); ?>" alt="<?php the_title_attribute(); ?>">
                    <?php else: ?>
                        <div style="width: 128px; height: 104px; background-color: #F6F8FF; display: flex; align-items: center; justify-content: center; color: #9DA0B3; font-size: 12px; border-radius: 16px;">无图片</div>
                    <?php endif; ?>
                </a>
                <a class="sider-post-item-title" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                    <h3><?php the_title(); ?></h3>
                </a>
            </div>
            <?php endwhile; wp_reset_postdata(); ?>
        </div>
    </div>
    <?php endif; ?>
    <?php endif; ?>
</div>
