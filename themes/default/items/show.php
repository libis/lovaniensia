<?php echo head(array('title' => metadata('item', array('Dublin Core', 'Title')),'bodyclass' => 'item show')); ?>
<?php $type = metadata('item','item_type_name');?>
<?php if (metadata('item', 'has files') && $type != 'News'): ?>
  <section class="item-section general-section">
      <div class="container-fluid">
        <div class='row breadcrumbs'>
          <div class="col-xs-12">
              <p id="simple-pages-breadcrumbs">
                <span><a href="<?php echo url('/');?>">Home</a></span>
                 > <span><a href="<?php echo $type;?>"><?php echo $type;?></a></span>
                 > <?php echo metadata('item', array('Dublin Core', 'Title')); ?>
               </p>
           </div>
        </div>
          <div class="row image-row">
            <!-- The following returns all of the files associated with an item. -->
            <div id="itemfiles" class="element">
                <div class="element-text"><?php echo item_image_gallery(array('linkWrapper' => array('wrapper' => null,'class' => 'col-sm-2 col-xs-12 image')),'thumbnail'); ?></div>
            </div>
          </div>
      </div>
  </section>
<?php endif; ?>
<section class="metadata-section general-section">
    <div id="content" class='container-fluid' role="main" tabindex="-1">
        <?php if ($type == 'News'): ?>
          <div class='row breadcrumbs'>
            <div class="col-xs-12">
                <p id="simple-pages-breadcrumbs">
                  <span><a href="<?php echo url('/');?>">Home</a></span>
                   > <span><a href="<?php echo $type;?>"><?php echo $type;?></a></span>
                   > <?php echo metadata('item', array('Dublin Core', 'Title')); ?>
                 </p>
             </div>
          </div>
        <?php endif; ?>
        <div class="row content">
            <?php if (metadata('item', 'has files') && $type == 'News'): ?>
              <div class="col-sm-3 col-xs-12 page">
                <div id="itemfiles" class="element">
                    <div class="element-text"><?php echo item_image_gallery(array('linkWrapper' => array('wrapper' => null,'class' => 'col-sm-2 col-xs-12 image')),'thumbnail'); ?></div>
                </div>
              </div>
              <div class="col-sm-9 col-xs-12 page">
            <?php else:?>
              <div class="col-sm-12 col-xs-12 page">
            <?php endif; ?>
                    <?php if ($type != ''): ?>
                      <!--<h3 class="type-title"><?php echo $type;?></h3>-->
                    <?php endif; ?>
                    <h1 class="section-title projecten-title"><span><?php echo metadata('item', array('Dublin Core', 'Title')); ?></span></h1>

                    <?php if ($type != 'News'): ?>
                        <?php echo all_element_texts('item'); ?>

                        <!-- If the item belongs to a collection, the following creates a link to that collection. -->
                        <?php if (metadata('item', 'Collection Name')): ?>
                        <div id="collection" class="element">
                            <h3><?php echo __('Collection'); ?></h3>
                            <div class="element-text"><p><?php echo link_to_collection_for_item(); ?></p></div>
                        </div>
                        <?php endif; ?>

                        <!-- The following prints a list of all tags associated with the item -->
                        <?php if (metadata('item', 'has tags')): ?>
                        <div id="item-tags" class="element">
                            <h3><?php echo __('Tags'); ?></h3>
                            <div class="element-text"><?php echo tag_string('item'); ?></div>
                        </div>
                        <?php endif;?>

                        <!-- The following prints a citation for this item. -->
                        <div id="item-citation" class="element">
                            <h3><?php echo __('Citation'); ?></h3>
                            <div class="element-text"><?php echo metadata('item', 'citation', array('no_escape' => true)); ?></div>
                        </div>
                    <?php else:?>
                          <p class="date"><?php echo metadata('item', array('Dublin Core', 'Date')); ?></p>
                          <p class="description"><?php echo metadata('item', array('Dublin Core', 'Description')); ?></p>
                    <?php endif; ?>
                </div>
                <nav>
                <ul class="item-pagination navigation">
                    <li id="previous-item" class="previous"><?php echo link_to_previous_item_show("&#8249; Previous"); ?></li>
                    <li id="next-item" class="next"><?php echo link_to_next_item_show('Next &#8250;'); ?></li>
                </ul>
                </nav>

        </div>
    </div>

</section>

<?php echo foot(); ?>
