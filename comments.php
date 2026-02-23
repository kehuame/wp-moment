<?php
/**
 * 评论模板
 *
 * @package Moment
 */

if (post_password_required()) {
    return;
}
?>

<div id="comments" class="comments-area" style="margin-top: 30px; padding-top: 30px; border-top: 1px solid #F6F8FF;">
    
    <?php if (have_comments()): ?>
        <h2 class="comments-title" style="font-size: 22px; margin-bottom: 20px;">
            <?php
            $comment_count = get_comments_number();
            printf(
                _n('%s 条评论', '%s 条评论', $comment_count, 'moment'),
                number_format_i18n($comment_count)
            );
            ?>
        </h2>

        <ol class="comment-list" style="list-style: none; padding: 0; margin: 0;">
            <?php
            wp_list_comments(array(
                'style'       => 'ol',
                'short_ping'  => true,
                'avatar_size' => 50,
            ));
            ?>
        </ol>

        <?php the_comments_navigation(); ?>
        
        <?php if (!comments_open()): ?>
            <p class="no-comments" style="color: #9DA0B3; margin-top: 20px;">评论已关闭。</p>
        <?php endif; ?>
        
    <?php endif; ?>

    <?php
    comment_form(array(
        'title_reply'          => '发表评论',
        'title_reply_to'       => '回复 %s',
        'cancel_reply_link'    => '取消回复',
        'label_submit'         => '提交评论',
        'comment_notes_before' => '',
        'comment_notes_after'  => '',
    ));
    ?>

</div>
