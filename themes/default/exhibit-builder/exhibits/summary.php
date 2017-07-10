<?php echo head(array('title' => metadata('exhibit', 'title'), 'bodyclass'=>'exhibits summary')); ?>
<section class="metadata-section general-section exhibit-show-section">
  <div id="content" class='container exhibit-container' role="main" tabindex="-1">
      <div class="row">
        <div class="col-sm-9 col-xs-12 page">
          <div class='row breadcrumbs'>
            <div class="col-xs-12">
                <p id="simple-pages-breadcrumbs">
                  <span><a href="<?php echo url('/');?>">Home</a></span>
                   > <span><a href="<?php echo url('browse/exhibits');?>">Exhibits</a></span>
                   > <?php echo metadata('exhibit', 'title'); ?>
                 </p>
             </div>
          </div>
          <div class='row image'>
            <div class="col-xs-12">
              <?php if (($exhibit->cover_image_file_id)): ?>
                  <?php
                    $file = get_record_by_id('File',$exhibit->cover_image_file_id);
                    $cover_url = $file->getWebPath('fullsize');
                  ?>
                  <div class="cover-container"><img class="cover" src="<?php echo $cover_url ?>"></div>
              <?php elseif ($exhibitImage = record_image($exhibit, 'fullsize')): ?>
                  <div class="cover-container"><?php echo $exhibitImage ?></div>
              <?php endif; ?>
            </div>
          </div>
          <div class='row top'>
            <div class="col-xs-12">
                <h1><?php echo metadata('exhibit', 'title'); ?></h1>
                <?php if (($exhibitCredits = metadata('exhibit', 'credits'))): ?>
                <div class="exhibit-credits">
                      <h3><?php echo $exhibitCredits; ?></h3>
                </div>
                <?php endif; ?>
            </div>
          </div>
          <div class='row content'>
            <div class="col-xs-12">

                <?php if ($exhibitDescription = metadata('exhibit', 'description', array('no_escape' => true))): ?>
                <div class="exhibit-description">
                    <?php echo $exhibitDescription; ?>
                </div>
                <?php endif; ?>


            </div>
        </div>
      </div>
      <div class="col-md-3 nav">
        <?php echo exhibit_builder_page_nav(); ?>
        <?php
        $pageTree = exhibit_builder_page_tree();
        if ($pageTree):
        ?>
        <nav id="exhibit-pages">
            <?php echo $pageTree; ?>
        </nav>
        <?php endif; ?>
      </div>
    </div>
  </div>
<?php echo foot(); ?>
