    <footer role="contentinfo">
      <div class="container footer-container">
          <div id="footer-text">
              <?php echo get_theme_option('Footer Text'); ?>
              <?php if ((get_theme_option('Display Footer Copyright') == 1) && $copyright = option('copyright')): ?>
                  <p><?php echo $copyright; ?></p>
              <?php endif; ?>
              <div class="row">
                  <div class="col-xs-12 col-md-4">

                    <div class="contact-info leuven">
                      <b>KU Leuven Libraries Special Collections</b><br>
                      Mgr. Ladeuzeplein 21 box 5591 |
                      3000 Leuven<br>
                      bijzonderecollecties@kuleuven.be<br>
                      tel.+32 (0)16 32 46 24
                    </div>
                  </div>
                  <div class="col-md-5 col-xs-12">
                    <div class="contact-info">
                      <b>Bibliothèques de l’Université catholique de Louvain<br>
                      Réserve patrimoniale</b><br>
                      Grand-Place 45 |
                      1348 Louvain-la-Neuve<br>
                      respat-sceb@uclouvain.be<br>
                      tel. +32 (0)10 47 81 87
                    </div>
                  </div>
                </div>
                <div class="row logo-row">
                  <div class="col-xs-12">
                    <div class="logos">
                    <a href="https://uclouvain.be/en"><img class="ucl" src="<?php echo img("UCL_web.jpg");?>"></a>
                    <a href="https://uclouvain.be/en/libraries"><img class="ucl" src="<?php echo img("ucl.jpg");?>"></a>
                    <a href="https://bib.kuleuven.be/english/"><img src="<?php echo img("KULEUVEN.png");?>"></a>
                    <a href="http://libis.be"><img src="<?php echo img("libis_gray.png");?>"></a>
                    <a href="http://www.cultuurculture.be/"><img src="<?php echo img("cultuur-culture.jpg");?>"></a>
                    <a href="https://cjsm.be/"><img src="<?php echo img("flanders.png");?>"></a>
                    <a href="http://www.federation-wallonie-bruxelles.be/"><img src="<?php echo img("logo-wallonie.png");?>"></a>
                  </div>
                </div>
              </div>
          </div>
          <div class="copyright">© Lovaniensia</div>
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
