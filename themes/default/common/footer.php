    <footer role="contentinfo">
        <div class="container footer-container">
            <div id="footer-text">
                <?php echo get_theme_option('Footer Text'); ?>
                <?php if ((get_theme_option('Display Footer Copyright') == 1) && $copyright = option('copyright')): ?>
                    <p><?php echo $copyright; ?></p>
                <?php endif; ?>
                <div class="row">
                    <div class="col-sm-3">
                        <img src="<?php echo img("KULEUVEN.png");?>">
                    </div>
                    <div class="col-sm-3">
                        <p>Straatstraat 22<br>
                            3000 Leuven<br>
                            016222222<br>
                        .....</p>
                    </div>
                    <div class="col-sm-2">
                        <ul>
                            <li><a href="">Menu item 1</a></li>
                            <li><a href="">Menu item 1</a></li>
                            <li><a href="">Menu item 1</a></li>
                            <li><a href="">Menu item 1</a></li>
                            <li><a href="">Menu item 1</a></li>
                            <li><a href="">Menu item 1</a></li>
                            <li><a href="">Menu item 1</a></li>
                        </ul>
                    </div>
                    <div class="col-sm-2">
                        <ul>
                            <li><a href="">Menu item 1</a></li>
                            <li><a href="">Menu item 1</a></li>
                            <li><a href="">Menu item 1</a></li>
                            <li><a href="">Menu item 1</a></li>
                            <li><a href="">Menu item 1</a></li>
                            <li><a href="">Menu item 1</a></li>
                            <li><a href="">Menu item 1</a></li>
                        </ul>
                    </div>
                    <div class="col-sm-2">
                        <ul>
                            <li><a href="">Menu item 1</a></li>
                            <li><a href="">Menu item 1</a></li>
                            <li><a href="">Menu item 1</a></li>
                            <li><a href="">Menu item 1</a></li>
                            <li><a href="">Menu item 1</a></li>

                        </ul>
                    </div>

                </div>
            </div>

            <div class="copyright">© test</div>
            <?php fire_plugin_hook('public_footer', array('view' => $this)); ?>
        </div>

    </footer><!-- end footer -->

</body>
<script>
jQuery('.grid').masonry({
  itemSelector: '.grid-item', // use a separate class for itemSelector, other than .col-
  columnWidth: '.grid-sizer',
  percentPosition: true
});

</script>
</html>
