<!DOCTYPE html>
<html lang="<?php echo get_html_lang(); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php if ($description = option('description')) :?>
    <meta name="description" content="<?php echo $description; ?>" />
    <?php endif; ?>
    <?php
    if (isset($title)) {
        $titleParts[] = strip_formatting($title);
    }
    $titleParts[] = option('site_title');
    ?>
    <title><?php echo implode(' &middot; ', $titleParts); ?></title>

    <?php echo auto_discovery_link_tags(); ?>

    <!-- Plugin Stuff -->
    <?php fire_plugin_hook('public_head', array('view' => $this)); ?>

    <!-- Stylesheets -->
    <?php
    queue_css_file(array('iconfonts', 'app'));
    queue_css_url('https://fonts.googleapis.com/css?family=Droid+Serif:400,700|Raleway:100,300,400,600,700');
    echo head_css();
    echo theme_header_background();

    ?>

    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/jquery.slick/1.6.0/slick.css"/>
    <?php
      queue_js_file('masonry');
      echo head_js();
    ?>

    <!-- JavaScripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.2.0/js/tether.min.js" integrity="sha384-Plbmg8JY28KFelvJVai01l8WyZzrYWG825m+cZ0eDDS1f7d/js6ikvy1+X+guPIB" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.3/js/bootstrap.min.js" integrity="sha384-ux8v3A6CPtOTqOzMKiuo3d/DomGaaClxFYdCu2HPMBEkf6x2xiDyJ7gkXU0MWwaD" crossorigin="anonymous"></script>

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet">
    <script type="text/javascript" src="//cdn.jsdelivr.net/jquery.slick/1.6.0/slick.min.js"></script>
</head>
<?php echo body_tag(array('id' => @$bodyid, 'class' => @$bodyclass)); ?>
    <?php fire_plugin_hook('public_body', array('view' => $this)); ?>
        <header role="banner">
            <nav class="navbar public-nav">
              <div class="container">
                <div class="row">
                  <div class="col-md-12">
                    <button class="navbar-toggler pull-xs-right hidden-md-up" type="button" data-toggle="modal" data-target="#modalNav" aria-controls="exCollapsingNavbar2">
                      &#9776;
                    </button>
                    <a class="navbar-brand" href="<?php echo WEB_ROOT;?>">Lovaniensia</a>
                    <div class="pull-xs-right hidden-sm-down">
                      <?php echo public_nav_main(array('role' => 'navigation')) -> setUlClass('nav navbar-nav'); ?>
                    </div>
                    <form class="form-inline pull-xs-right">
                      <input class="form-control" type="text" placeholder="Search">
                      <button class="btn" type="submit"><i class="material-icons">search</i></button>
                    </form>
                  </div>
                </div>
                <div class="row">

                </div>
              </div>
            </nav>
            <?php fire_plugin_hook('public_header', array('view' => $this)); ?>
        </header>
        <div class="modal fade" role="dialog" id="modalNav">
            <div class="modal-dialog modal-lg" role="document">
              <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                  <div class="container">
                    <div class="row">
                        <div class="col-md-4 offset-md-1">
                            <span class="text-muted"> <?php echo public_nav_main(array('role' => 'navigation')); ?></span>
                        </div>
                        <div class="col-md-4">

                        </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
