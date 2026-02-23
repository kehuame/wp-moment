</div><!-- end .box-wrap -->

<div class="footer">
    <?php 
    $footer_copyright = moment_get_option('footer_copyright');
    if ($footer_copyright): 
    ?>
        <?php echo wp_kses_post($footer_copyright); ?>
        &nbsp;|&nbsp;
    <?php endif; ?>
    Theme by <a href="https://kehua.me">kehua</a>
</div>

<?php wp_footer(); ?>
</body>
</html>
