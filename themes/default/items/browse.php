<?php
$pageTitle = __('Browse Items');
echo head(array('title'=>$pageTitle,'bodyclass' => 'items browse'));
?>
<div class="content-wrapper breadcrumbs-section ">
  <div class="container simple-page-container">
    <div class="row">
        <div class="col-sm-12 col-xs-12 page">
            <div class='row breadcrumbs'>
              <div class="col-xs-12">
                <p id="simple-pages-breadcrumbs">
                  <span><a href="<?php echo url('/');?>">Home</a></span>
                   > News
                 </p>
              </div>
            </div>
        </div>
    </div>
  </div>
</div>
<div class="content-wrapper simple-page-section ">
  <div class="container simple-page-container">
    <!-- Content -->
        <div class="row">
            <div class="col-sm-9 col-xs-12 page">
                <div class='row top'>
                  <div class="col-xs-12">
                    <h1>News</h1>
                  </div>
                </div>
                <div class='row content'>
                  <div class="col-xs-12">
                    <?php foreach (loop('items') as $item): ?>
                    <div class="item hentry news-archive-item">
                        <h2><?php echo link_to_item(metadata('item', array('Dublin Core', 'Title')), array('class'=>'permalink')); ?></h2>
                        <h6><?php echo metadata('item', array('Dublin Core', 'Date')); ?></h6>

                        <div class="item-meta">
                        <?php if (metadata('item', 'has files')): ?>
                        <div class="item-img">
                            <?php echo link_to_item(item_image()); ?>
                        </div>
                        <?php endif; ?>

                        <?php if ($description = metadata('item', array('Dublin Core', 'Description'), array('snippet'=>250))): ?>
                        <div class="item-description">
                            <?php echo $description; ?>
                        </div>
                        <?php endif; ?>

                        <?php if (metadata('item', 'has tags')): ?>
                        <div class="tags"><p><strong><?php echo __('Tags'); ?>:</strong>
                            <?php echo tag_string('items'); ?></p>
                        </div>
                        <?php endif; ?>

                        <?php fire_plugin_hook('public_items_browse_each', array('view' => $this, 'item' =>$item)); ?>

                        </div><!-- end class="item-meta" -->
                    </div><!-- end class="item hentry" -->
                    
                    <?php endforeach; ?>
                  </div>
                </div>
            </div>
        </div>
    </div>
</div>



<?php echo foot(); ?>
