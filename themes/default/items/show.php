<?php echo head(array('title' => metadata('item', array('Dublin Core', 'Title')),'bodyclass' => 'item show')); ?>
<?php $type = metadata('item','item_type_name');?>
<div class="content-wrapper breadcrumbs-section ">
  <div class="container simple-page-container">
    <div class="row">
        <div class="col-sm-12 col-xs-12 page">
            <div class='row breadcrumbs'>
              <div class="col-xs-12">
                <p id="simple-pages-breadcrumbs">
                  <span><a href="<?php echo url('/');?>">Home</a></span>
                   > <span><a href="<?php echo url('/solr-search');?>"><?php echo __("Collection");?></a></span>
                   > <?php echo metadata('item', array('Dublin Core', 'Title'),array('snippet'=>'100')); ?>
                 </p>
              </div>
            </div>
        </div>
    </div>
  </div>
</div>
<?php
  $iiif= '';
  $mirador = metadata($item, array('Item Type Metadata','Rosetta ID'));
  $universal = metadata($item, array('Dublin Core','Relation'),array("all" => true));
  foreach($universal as $row):
    if (strpos($row, 'IIIF') !== false) {
      $iiif = $row;
    }
  endforeach;
  $manifest = "";
?>
<?php if ($mirador || $universal): ?>
  <section class="item-section general-section">
    <div class="container-fluid embed">
      <div class="row">
        <div class="col-xs-12">
          <div class="image-row">
            <?php if($mirador):?>
              <?php $manifest = "https://lib.is/".$mirador.'/manifest';?>
              <iframe scrolling="no" src="http://resolver.libis.be/<?php echo $mirador;?>/representation"></iframe>
            <?php else: ?>
              <iframe src="<?php echo $iiif;?>"></iframe>
              <?php $manifest = $iiif;?>
            <?php endif;?>
          </div>
        </div>
      </div>
    </div>
  </section>
<?php else:?>
  <?php $manifest =  metadata($item, array('Item Type Metadata','External manuscript'));?>  
<?php endif; ?>
<section class="metadata-section general-section">
    <div id="content" class='container' role="main" tabindex="-1">
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
            <div class="offset-md-1 col-md-9 col-xs-12 page">
          <?php endif; ?>
          <!--<?php if ($type != ''): ?>
            <h3 class="type-title"><?php echo $type;?></h3>
          <?php endif; ?>-->
          <h1 class="section-title projecten-title"><span><?php echo metadata('item', array('Dublin Core', 'Title')); ?></span></h1>

          <?php if ($type != 'News'): ?>

              <div class="links">
                <?php if($text = metadata($item, array('Item Type Metadata','MMS ID'))):?>
                    <a class="catalogue" href="https://lib.is/<?php echo $text;?>"><i class="material-icons">&#xE89E;</i> Catalogue</a>
                <?php elseif($text = metadata($item, array('Dublin Core','Identifier'),array("index"=>"1"))):?>
                    <a class="images" href="<?php echo $text;?>"><i class="material-icons">&#xE89E;</i> Catalogue</a>
                <?php endif; ?>
                <?php if($text = metadata($item, array('Item Type Metadata','Rosetta ID'))):?>
                    <a class="images" href="//lib.is/<?php echo $text;?>/representation"><i class="material-icons">&#xE3B6;</i> Images</a>
                <?php elseif($text = metadata($item, array('Dublin Core','Relation'),array("index"=>"0"))):?>
                    <a class="images" href="<?php echo $text;?>"><i class="material-icons">&#xE3B6;</i> Images</a>
                <?php endif; ?>
                <?php if($manifest):?>
                <a target="_blank" href="<?php echo $manifest;?>">
                    <img src="http://manifests.britishart.yale.edu/logo-iiif.png" alt="IIIF Manifest">
                </a>
                <? endif;?>
              </div>
              <div class="element-set">
                <!-- creators -->
                <?php if($text = metadata('item', array('Dublin Core','Creator'),array("delimiter" => "; "))):?>
                  <div class="element">
                      <h3><?php echo __('Creator');?></h3>
                      <div class="element-text"><?php echo $text;?></div>
                  </div>
                <?php endif;?>
                <?php if($text = metadata('item', array('Dublin Core','Contributor'),array("delimiter" => "; "))):?>
                  <div class="element">
                      <h3><?php echo __('Contributor');?></h3>
                      <div class="element-text"><?php echo $text;?></div>
                  </div>
                <?php endif;?>

                <!-- coverage -->
                <?php if($text = metadata('item', array('Dublin Core','Coverage'),array("delimiter" => ", "))):?>
                  <div class="element">
                      <h3><?php echo __('Place');?></h3>
                      <?php if($text == "Brussel" || $text == "Bruxelles"):?>
                        <div class="element-text">Brussel / Bruxelles</div>
                      <?php else:?>
                        <div class="element-text"><?php echo $text;?></div>
                      <?php endif;?>
                  </div>
                <?php endif;?>

                <!-- Publisher -->
                <?php if($text = metadata('item', array('Dublin Core','Publisher'),array("delimiter" => "; "))):?>
                  <div class="element">
                      <h3><?php echo __('Publisher');?></h3>
                      <div class="element-text"><?php echo $text;?></div>
                  </div>
                <?php endif;?>

                <!-- Date -->
                <?php if($text = metadata('item', array('Dublin Core','Date'))):?>
                  <div class="element">
                      <h3><?php echo __('Date');?></h3>
                      <div class="element-text"><?php echo $text;?></div>
                  </div>
                <?php endif;?>

                <!-- taal -->
                <?php if($text = metadata('item', array('Dublin Core','Language'))):?>
                  <div class="element">
                      <h3><?php echo __('Language');?></h3>
                      <div class="element-text"><?php echo locale_get_display_language($text);?></div>
                  </div>
                <?php endif;?>

                <!-- subjects -->
                <?php if($text = metadata('item', array('Dublin Core','Subject'),array("delimiter" => ", "))):?>
                  <div class="element">
                      <h3><?php echo __('Subject');?></h3>
                      <div class="element-text"><?php echo $text;?></div>
                  </div>
                <?php endif;?>

                <?php if($text = metadata('item', array('Dublin Core','Description'))):?>
                  <div class="element">
                      <h3><?php echo __('Description');?></h3>
                      <div class="element-text"><?php echo $text;?></div>
                  </div>
                <?php endif;?>

                <!-- exemplaargegevens -->
                <?php if($text = metadata('item', array('Dublin Core','Source'))):?>
                  <div class="element">
                      <h3><?php echo __('Source');?></h3>
                      <?php if($universal):?>
                        <div class="element-text">
                          Bibliothèques de l’Université catholique de Louvain. Réserve patrimoniale
                        </div>
                      <?php else:?>
                        <div class="element-text"><?php echo $text;?></div>
                      <?php endif;?>
                  </div>
                <?php endif;?>

                <?php if($mirador && $text = metadata('item', array('Dublin Core','Identifier'))):?>
                  <div class="element">
                      <h3><?php echo __('Call number');?></h3>
                      <div class="element-text"><?php echo $text;?></div>
                  </div>
                <?php endif;?>

                <?php if($universal && $text = metadata('item', array('Dublin Core','Identifier'),array("index"=>"0"))):?>
                  <div class="element">
                      <h3><?php echo __('Call number');?></h3>
                      <div class="element-text"><?php echo $text;?></div>
                  </div>
                <?php endif;?>

                <?php if($text = metadata('item', array('Dublin Core','Has Version'),array("all"=>true))):?>
                  <div class="element">
                      <h3><?php echo __('Copies');?></h3>
                      <ul class="element-text">
                      <?php foreach($text as $cop):?>
                        <li ><?php echo $cop;?></li>
                      <?php endforeach;?>
                      </ul>
                  </div>
                <?php endif;?>

                <?php if($text = metadata('item', array('Item Type Metadata','External manuscript'),array("all"=>true))):?>
                  <?php 
                  $labels = metadata('item', array('Item Type Metadata','External manuscript txt'),array("all"=>true)); 
                  $i = 0;
                  ?>
                  <div class="element">
                      <h3><?php echo __('Externally digitised copies');?></h3>
                      <ul class="element-text">
                      <?php foreach($text as $manu):?>
                        <li ><?php echo $manu;?></li>
                        
                      <?php endforeach;?>
                      </ul>
                  </div>
                <?php endif;?>

              </div>


          <?php else:?>
              <p class="date"><?php echo metadata('item', array('Dublin Core', 'Date')); ?></p>
              <p class="description"><?php echo metadata('item', array('Dublin Core', 'Description')); ?></p>
          <?php endif; ?>
          </div>
          <!--<div class="col-md-3">
            <?php if (metadata('item', 'has tags')): ?>
            <div id="item-tags" class="element">
                <h3><?php echo __('Tags'); ?></h3>
                <div class="element-text"><?php echo tag_string('item'); ?></div>
            </div>
            <?php endif;?>
          </div>-->


        </div>
    </div>

</section>

<?php echo foot(); ?>
