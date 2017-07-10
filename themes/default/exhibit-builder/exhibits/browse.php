<?php
$title = __('Browse Exhibits');
echo head(array('title' => $title, 'bodyclass' => 'exhibits browse'));
?>
<section class="metadata-section general-section exhibit-show-section">
  <div id="content" class='container exhibit-container' role="main" tabindex="-1">
      <div class="row">
        <div class="col-sm-12 col-xs-12 page">
          <div class='content'>
            <h1><?php echo $title; ?> <?php echo __('(%s total)', $total_results); ?></h1>
            <?php if (count($exhibits) > 0): ?>

            <!--<nav class="navigation secondary-nav">
                <?php echo nav(array(
                    array(
                        'label' => __('Browse All'),
                        'uri' => url('exhibits')
                    )
                )); ?>
            </nav>-->

            <?php echo pagination_links(); ?>

          <?php $exhibitCount = 0; ?>
          <?php foreach (loop('exhibit') as $exhibit): ?>
              <?php $exhibitCount++; ?>
              <div class="row exhibit <?php if ($exhibitCount%2==1) echo ' even'; else echo ' odd'; ?>">
                <div class="col-sm-3 page">

                  <?php if ($exhibitImage = record_image($exhibit, 'square_thumbnail')): ?>
                      <?php echo exhibit_builder_link_to_exhibit($exhibit, $exhibitImage, array('class' => 'image')); ?>
                  <?php endif; ?>
                </div>
                <div class="col-sm-9 page">
                  <h2><?php echo link_to_exhibit(); ?></h2>
                  <?php if ($exhibitDescription = metadata('exhibit', 'description', array('no_escape' => true))): ?>
                  <div class="description"><?php echo $exhibitDescription; ?></div>
                  <?php endif; ?>
                  <?php if ($exhibitTags = tag_string('exhibit', 'exhibits')): ?>
                  <p class="tags"><?php echo $exhibitTags; ?></p>
                  <?php endif; ?>
                </div>
              </div>
          <?php endforeach; ?>

          <?php echo pagination_links(); ?>

          <?php else: ?>
          <p><?php echo __('There are no exhibits available yet.'); ?></p>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</section>
<?php echo foot(); ?>
