<?php echo head(array('bodyid'=>'home', 'bodyclass' =>'two-col')); ?>
<div class="jumbotron">
    <div class="container">
        <div class="row">
            <div class="intro col-md-12">
              <div class='row'>
                <div class="intro-content col-xs-12 offset-md-1 col-md-7 col-lg-6">
                    <?php echo libis_get_simple_page_content("homepage-info");?>
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
              <form id="solr-search-form">
              <div class="input-group">
                <input type="text" class="form-control" placeholder="Search the Collection" aria-label="Search for...">
                <span class="input-group-btn">
                  <button class="btn btn-secondary" type="button"><i class="material-icons"></i></button>
                </span>
              </div>
              </form>
              <p class="filter">Explore by: <a href="">collection</a>, <a href="">contribution</a> or <a href="">place of printing</a></p>
            </div>
        </div>
    </div>
</section>
<section class="home">
    <div id="content" class='container' role="main" tabindex="-1">
      <div class="carousel-lov">
          <div class="row">
              <div class="features image-lov col-md-5 col-xs-12">
                  <div class="card card-image">
                      <img class="card-img-cap" src="<?php echo img('ph/bg6.png');?>" alt="Card image">
                  </div>
              </div>
              <div class="features col-md-7 col-xs-12">
                    <div class="card card-text">
                        <h1 class="section-title projecten-title">
                          <span>Stirpivm historiæ pemptades sex sive libri XXX</span>
                        </h1>
                        <div class="description element">
                          <div class="element-text">
                            <p>Heruitgave van het Latijnse Cruydeboeck uit 1583. Voor de titelpagina werd dezelfde gravure gebruikt als in Clusius' <em>Rariorum Plantarum Historia</em>, dat ook bij Plantijn werd gedrukt.</p>
                          </div>
                        </div>
                        <div class="card-block">
                            <div id="collection" class="element">
                                <h3>Onderwerp</h3>
                                <div class="element-text"><p>Botanica</p></div>
                            </div>
                            <div id="collection" class="element">
                                <h3>Maker</h3>
                                <div class="element-text"><p>Rembert Dodoens</p></div>
                            </div>
                            <div id="collection" class="element">
                                <h3>Datum</h3>
                                <div class="element-text"><p>1616</p></div>
                            </div>
                            <div id="collection" class="element">
                                <h3>Uitgever</h3>
                                <div class="element-text"><p>Balthasar en Jan Moretus, Plantijn, Antwerpen. Balthasar en Jan Moretus, Plantijn, Antwerpen</p></div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <a href="">View item<i class="material-icons">&#xE315;</i></a>
                        </div>
                    </div>
                </div>
              </div>
              <div class="row">
                  <div class="features image-lov col-md-5 col-xs-12">
                      <div class="card card-image">
                          <img class="card-img-cap" src="<?php echo img('ph/home3.jpeg');?>" alt="Card image">
                      </div>
                  </div>
                  <div class="features col-md-7 col-xs-12">
                      <div class="card card-text">
                          <h1 class="section-title projecten-title">
                            <span>Proin sit amet magna</span>
                          </h1>
                          <div class="description element">
                            <div class="element-text">
                              <p>Heruitgave van het Latijnse Cruydeboeck uit 1583. Voor de titelpagina werd dezelfde gravure gebruikt als in Clusius' <em>Rariorum Plantarum Historia</em>, dat ook bij Plantijn werd gedrukt.</p>
                            </div>
                          </div>

                          <div class="card-block">
                              <div id="collection" class="element">
                                  <h3>Onderwerp</h3>
                                  <div class="element-text"><p>Botanica</p></div>
                              </div>

                              <div id="collection" class="element">
                                  <h3>Maker</h3>
                                  <div class="element-text"><p>Rembert Dodoens</p></div>
                              </div>

                              <div id="collection" class="element">
                                  <h3>Datum</h3>
                                  <div class="element-text"><p>1616</p></div>
                              </div>

                              <div id="collection" class="element">
                                  <h3>Uitgever</h3>
                                  <div class="element-text"><p>Balthasar en Jan Moretus, Plantijn, Antwerpen</p></div>
                              </div>
                          </div>
                          <div class="card-footer">
                              <a href="">View item<i class="material-icons">&#xE315;</i></a>
                          </div>
                      </div>
                  </div>
                </div>
           </div>
       </div>
   </div>
</section>
<section class="news">
  <div class="container">
      <div class="row ">
          <div class="col-md-12 col-lg-4 news-item">
              <h6>News <span>02-06-2017</span></h6>
              <h3>Sed luctus blandit</h3>
              <p class="description">
                Nam pulvinar fringilla egestas. Donec nulla quam, condimentum at metus ut, semper luctus massa. Proin sit amet magna non augue bibendum iaculis nec nec lorem.
              </p>
              <p class="read-more">
                <a href="">Read more</a>
              </p>
          </div>
          <div class="col-md-12 col-lg-4 news-item">
              <h6>News <span>02-06-2017</span></h6>
              <h3>Sed luctus blandit</h3>
              <p class="description">
                Nam pulvinar fringilla egestas. Donec nulla quam, condimentum at metus ut, semper luctus massa. Proin sit amet magna non augue bibendum iaculis nec nec lorem.
              </p>
              <p class="read-more">
                <a href="">Read more</a>
              </p>
          </div>
          <div class="col-md-12 col-lg-4 news-item">
              <h6>News <span>02-06-2017</span></h6>
              <h3>Sed luctus blandit</h3>
              <p class="description">
                Nam pulvinar fringilla egestas. Donec nulla quam, condimentum at metus ut, semper luctus massa. Proin sit amet magna non augue bibendum iaculis nec nec lorem.
              </p>
              <p class="read-more">
                <a href="">Read more</a>
              </p>
          </div>
      </div>
      <div class="row more-news">
        <div class="col-md-12 col-xs-12">
          <a href="">read more news <i class="material-icons">&#xE315;</i></a>
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
