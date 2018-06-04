<?php
/**
 * @copyright   2012 Rector and Board of Visitors, University of Virginia
 * @license     http://www.apache.org/licenses/LICENSE-2.0.html
 */
?>

<?php queue_css_file('results'); ?>
<?php echo head(array('title' => __('Solr Search'))); ?>
<section class="search search-solr">
    <div id="content" class='container' role="main" tabindex="-1">
        <div class="row">
            <div class="features col-md-12 col-xs-12">
              <!--<h1>Collection (<?php echo $results->response->numFound; ?>)</h1>-->
              <form id="solr-search-form">
                <div class="input-group">
                  <input class="form-control" title="Search keywords" name="q" placeholder="Search the Collection" value="" type="text">
                  <span class="input-group-btn">
                  <button class="btn btn-secondary" type="submit"><i class="material-icons"></i></button>
                  </span>
                </div>
              </form>
            </div>
        </div>
    </div>
</section>

<div class="content-wrapper bs-docs-section solr-section-applied">
  <div class="container solr-container">
    <div class="row">
      <div class="col-md-12 col-xs-12">
        <!-- Applied facets. -->
        <div id="solr-applied-facets">
          <ul>
            <!-- Get the applied facets. -->
            <?php foreach (SolrSearch_Helpers_Facet::parseFacets() as $f) : ?>
              <li>
                <!-- Facet label. -->
                <?php $label = SolrSearch_Helpers_Facet::keyToLabel($f[0]); ?>
                <span class="applied-facet-label"><?php echo $label; ?></span> >
                <?php if($label == 'Language'):?>
                  <span class="applied-facet-value"><?php echo locale_get_display_language($f[1]); ?></span>
                <?php else: ?>
                  <span class="applied-facet-value"><?php echo $f[1]; ?></span>
                <?php endif ?>
                <!-- Remove link. -->
                <?php $url = SolrSearch_Helpers_Facet::removeFacet($f[0], $f[1]); ?>
                <a href="<?php echo $url; ?>"><i class="material-icons">&#xE14C;</i></a>
            <?php endforeach; ?>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="content-wrapper bs-docs-section solr-section-results">
    <div class="container-fluid solr-container">
    <div class="row">
      <div id="solr-facets" class="col-md-3 col-xs-12">
          <!-- Facets. -->
          <h2><?php echo __('Limit your search'); ?></h2>
          <?php $i=0;?>
          <?php foreach ($results->facet_counts->facet_fields as $name => $facets) : ?>

            <!-- Does the facet have any hits? -->
            <?php if (count(get_object_vars($facets))) : ?>
                <!-- Facet label. -->
                <?php $label = SolrSearch_Helpers_Facet::keyToLabel($name); ?>
                <div class="facet">
                    <a class="facet-name" data-toggle="collapse" href="#list<?php echo $i;?>" aria-expanded="false" aria-controls="#list<?php echo $i;?>"><?php echo $label; ?></a>
                    <ul class="collapse" id="list<?php echo $i;?>">
                        <?php
                          if($label == 'Date'):
                            //extra: sort Date alphabetically
                            $facets = (get_object_vars($facets));
                            ksort($facets);
                          endif;
                        ?>
                        <!-- Facets. -->
                        <?php foreach ($facets as $value => $count) : ?>
                          <li class="<?php echo $value; ?>">
                            <!-- Facet URL. -->
                            <?php $url = SolrSearch_Helpers_Facet::addFacet($name, $value); ?>

                            <!-- Facet link. -->
                            <a href="<?php echo $url; ?>" class="facet-value">
                                <?php if($label == 'Language'):
                                  echo locale_get_display_language ($value);
                                endif ?>
                                <?php echo $value; ?>
                            </a>

                            <!-- Facet count. -->
                            (<span class="facet-count"><?php echo $count; ?></span>)
                          </li>
                          <?php $i++;?>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
          <?php endforeach; ?>
      </div>
      <div class="solr-results col-md-9 col-xs-12">
          <?php echo pagination_links(); ?>
          <!-- Results. -->
          <?php foreach ($results->response->docs as $doc) : ?>

              <!-- Document. -->
              <div class="row result">
                <div class="col-xs-12 col-md-2 img-column">
                    <?php
                    if ($doc->resulttype == 'Item') :
                        $item = get_db()->getTable($doc->model)->find($doc->modelid);
                        if($item->hasThumbnail()):
                          echo link_to_item(
                              item_image('thumbnail', array('alt' => $doc->title), 0, $item),
                              array(),
                              'show',
                              $item
                          );
                        else:?>
                          <div class="dummy"></div>
                        <?php endif;
                    endif;
                    ?>
                </div>
                <!-- Header. -->
                <div class="col-xs-12 col-md-9">

                  <!-- Record URL. -->
                  <?php $url = SolrSearch_Helpers_View::getDocumentUrl($doc); ?>

                  <!-- Title. -->
                  <h2><a href="<?php echo $url; ?>" class="result-title">
                  <?php
                  $title = is_array($doc->title) ? $doc->title[0] : $doc->title;
                  if (empty($title)) {
                      $title = '<i>'.__('Untitled').'</i>';
                  }
                  echo $title;
                  ?>
                  </a></h2>

                  <?php if ($doc->resulttype == 'Item') :?>
                    <div class="solr-metadata">
                        <?php $item = get_db()->getTable($doc->model)->find($doc->modelid);?>
                        <?php if($text = metadata($item, array('Dublin Core','Creator'),array("delimiter"=>"; "))):?>
                          <div class="element">
                              <h3><?php echo __('Creator');?></h3>
                              <div class="element-text"><p><?php echo $text;?></p></div>
                          </div>
                        <?php endif;?>
                        <?php if($text = metadata($item, array('Dublin Core','Coverage'))):?>
                          <div class="element">
                              <h3><?php echo __('Place');?></h3>
                              <div class="element-text"><p><?php echo $text;?></p></div>
                          </div>
                        <?php endif;?>
                        <?php if($text = metadata($item, array('Dublin Core','Date'))):?>
                          <div class="element">
                              <h3><?php echo __('Date');?></h3>
                              <div class="element-text"><p><?php echo $text;?></p></div>
                          </div>
                        <?php endif;?>
                        <?php if($text = metadata($item, array('Dublin Core','Subject'),array("delimiter"=>", "))):?>
                          <div class="element">
                              <h3><?php echo __('Subject');?></h3>
                              <div class="element-text"><p><?php echo $text;?></p></div>
                          </div>
                        <?php endif;?>
                      </div>
                      <div class="footer">
                          <a href="<?php echo record_url($item);?>">View item<i class="material-icons">&#xE315;</i></a>
                      </div>
                    <?php endif;?>
                </div>
              </div>
            <?php endforeach; ?>
            <?php echo pagination_links(); ?>
        </div>
    </div>
  </div>
</div>
<?php echo foot();
