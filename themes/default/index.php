<?php echo head(array('bodyid'=>'home', 'bodyclass' =>'two-col')); ?>
<div class="jumbotron">
    <div class="container">
        <div class="row">
            <div class="intro col-md-12">
              <div class='row'>
                <div class="intro-content col-xs-12 offset-md-1 offset-lg-1 col-md-7 col-lg-7">
                    <?php echo libis_get_simple_page_content("Info");?>
                </div>
                <div class="more col-xs-12 col-md-4 col-xl-4">
                    <p><i class="material-icons">&#xE5C8;</i><a href="<?php echo url('en/about');?>">Read more</a></p>
                    <p><i class="material-icons">&#xE5C8;</i><a href="<?php echo url('fr/about');?>">En savoir plus</a></p>
                    <p><i class="material-icons">&#xE5C8;</i><a href="<?php echo url('nl/about');?>">Lees meer</a></p>
                </div>
              </div>
            </div>
        </div>
    </div>
</div>
<section class="search">
    <div id="content" class='container' role="main" tabindex="-1">
        <div class="row">
            <div class="features col-md-10 offset-md-1 col-xs-12">
              <form id="solr-search-form" action="<?php echo url("solr-search");?>">
                <div class="input-group">
                  <input type="text" class="form-control" name="q" placeholder="Search the Collection" aria-label="Search for...">
                  <span class="input-group-btn">
                    <button class="btn btn-secondary" type="submit"><i class="material-icons"></i></button>
                  </span>
                </div>
              </form>
              <p class="filter">Explore by: <a href="<?php echo url("professors");?>">professors</a></p>
            </div>
        </div>
    </div>
</section>
<section class="home">
    <div id="content" class='container' role="main" tabindex="-1">
      <div class="carousel-lov">
        <?php $items = get_records('Item',array('featured' => true),5);?>
        <?php foreach($items as $item):?>
          <div class="row">
              <div class="features image-lov col-md-5 col-xs-12">
                  <div class="card card-image">
                    <?php
                        $image = item_image('fullsize', array('class' => 'card-img-cap'),0,$item);
                    ?>
                    <?php echo link_to_item($image,array(),'show',$item); ?>
                  </div>
              </div>
              <div class="features col-md-7 col-xs-12">
                  <div class="card card-text">
                    <h1 class="section-title projecten-title">
                      <span><a href="<?php echo record_url($item);?>"><?php echo metadata($item, array('Dublin Core','Title'));?></a></span>
                    </h1>
                      <!--<?php if($text = metadata($item, array('Dublin Core','Description'))):?>
                        <div class="description element">
                          <div class="element-text">
                            <div class="element-text"><p><?php echo $text;?></p></div>
                          </div>
                        </div>
                      <?php endif;?>-->
                      <div class="card-block">
                        <?php if($text = metadata($item, array('Dublin Core','Creator'))):?>
                          <div class="element">
                              <h3><?php echo __('Creator');?></h3>
                              <div class="element-text"><p><?php echo $text;?></p></div>
                          </div>
                        <?php endif;?>
                        <?php if($text = metadata($item, array('Dublin Core','Contributor'))):?>
                          <div class="element">
                              <h3><?php echo __('Contributor');?></h3>
                              <div class="element-text"><p><?php echo $text;?></p></div>
                          </div>
                        <?php endif;?>
                        <?php if($text = metadata($item, array('Dublin Core','Publisher'))):?>
                          <div class="element">
                              <h3><?php echo __('Publisher');?></h3>
                              <div class="element-text"><p><?php echo $text;?></p></div>
                          </div>
                        <?php endif;?>
                        <?php if($text = metadata($item, array('Dublin Core','Date'))):?>
                          <div class="element">
                              <h3><?php echo __('Date');?></h3>
                              <div class="element-text"><p><?php echo $text;?></p></div>
                          </div>
                        <?php endif;?>
                      </div>
                      <div class="card-footer">
                          <a href="<?php echo record_url($item);?>">View item<i class="material-icons">&#xE315;</i></a>
                      </div>
                  </div>
              </div>
          </div>
          <?php endforeach;?>
       </div>
     </div>
</section>
<section class="news">
  <div class="container">
      <div class="row">
        <?php
          echo libis_get_news();
        ?>
      </div>
      <div class="row more-news">
        <div class="col-md-12 col-xs-12">
          <a href="<?php echo url("/items/browse?type=News");?>">read more news <i class="material-icons">&#xE315;</i></a>
        </div>
      </div>
  </div>
</section>
<script>
    jQuery(document).ready(function(){
      jQuery('.carousel-lov').slick({
        autoplay:true,
        arrows:false,
        fade:true,
        speed:1000,
        autoplaySpeed:5000
      });
    });
</script>
<?php echo foot(); ?>
