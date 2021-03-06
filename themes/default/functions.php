<?php
function public_nav_main_bootstrap() {
    $partial = array('common/menu-partial.phtml', 'default');
    $nav = public_nav_main();  // this looks like $this->navigation()->menu() from Zend
    $nav->setPartial($partial);
    return $nav->render();
}

function simple_nav(){
    $page = get_current_record('SimplePagesPage');

    $links = simple_pages_get_links_for_children_pages();
    if(!$links):
        $links = simple_pages_get_links_for_children_pages($page->parent_id);
    endif;

    $html="<ul class='simple-nav'>";
    foreach($links as $link):
        $html .= "<li><a href='".$link['uri']."'>".$link['label']."</a></li>";
    endforeach;
    $html .="</ul>";

    return $html;
}

function libis_get_simple_page_content($title) {
    $page = get_record('SimplePagesPage', array('title' => $title));
    if($page):
        return $page->text;
    else:
        return false;
    endif;
}

function libis_get_featured_items(){
  $items = get_records('items',array('featured' => true),5);
}

function libis_get_news($items)
{
    //$items = get_records('Item', array('type'=>'News','sort_field' => 'added', 'sort_dir' => 'd'), 3);
    if ($items): ?>
      <?php $col = 12 / sizeof($items);?>
      <?php foreach ($items as $item) :?>
        <div class="col-md-12 col-lg-<?php echo $col;?> news-item">
            <h6>News <span><?php echo metadata($item, array('Dublin Core', 'Date')); ?></span></h6>
            <h3><?php echo metadata($item, array('Dublin Core', 'Title')); ?></h3>
            <p class="description">
              <?php echo metadata($item, array('Dublin Core', 'Description'), array('snippet'=>250)); ?>
            </p>
            <p class="read-more">
              <?php echo link_to_item('Read more', array(), 'show', $item); ?>
            </p>
        </div>
      <?php endforeach;?>
    <?php endif;
}
