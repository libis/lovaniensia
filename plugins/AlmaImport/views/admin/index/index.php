<?php echo head(array('title'=>'Alma Import')); ?>
<div id="primary">
    <div id="alma-import-form">

        <?php echo flash(); ?>
        <form name="contact_form" id="contact-form"  method="post" enctype="multipart/form-data" accept-charset="utf-8">
            <?php echo $status;?>

            <div id="form-instructions">
                <p>Insert a list of id's below, seperated by pipe.</p>
                <p>For example 9983524100101488|9983524100101488</p>
            </div>
            <div class="field">
              <?php echo $this->formLabel('ids', 'A list of ids: '); ?>
              <div class='inputs'>
              <?php echo $this->formTextarea('ids', $ids, array('class'=>'textinput', 'rows' => '10')); ?>
              </div>
            </div>

            <div class="field">
              <?php echo $this->formLabel('item types', 'Item type'); ?>
              <div class='inputs'>
                <select name="item-type">
                  <?php foreach($item_types as $item_type): ?>
                      <option value="<?php echo $item_type->id ?>"><?php echo $item_type->name ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
            <div class="field">
              <?php echo $this->formLabel('collection', 'Collection'); ?>
              <div class='inputs'>
                <select name="collection">
                  <option value="">-none-</option>
                  <?php foreach($collections as $collection): ?>
                      <option value="<?php echo $collection->id ?>"><?php echo metadata($collection,array('Dublin Core','Title')); ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
            <div class="field">
              <?php echo $this->formLabel('images', 'Images'); ?>
              <div class='inputs'>
                <p class="explanation">Download or redownload images? Images not present in ALMA are left untouched.</p>
                <input type="checkbox" name="images" value="image">
              </div>
            </div>

            <div class="field">
              <?php echo $this->formSubmit('send', 'Insert'); ?>
            </div>

        </form>
        <?php
          $records = get_records(
            'Item',
            array(
                'advanced' => array(
                    array(
                        'element_id' => 172,
                        'type' => 'is not empty'
                    )
                )
            ),
            9999          
          );
          
          $ids_array = array();
          foreach($records as $record):
              if(metadata($record,array("Item Type Metadata","MMS ID"))):
                  $ids_array[] = metadata($record,array("Item Type Metadata","MMS ID"));
              endif;    
          endforeach;
          
        ?>
        <div class="field">
          <input type="submit" name="send" id="update-all" value="Update all"> 
        </div>
        <div class="happenings">

        </div>
    </div>
</div>
<script>
	jQuery( document ).ready(function() {
    var arr = <?php echo json_encode($ids_array); ?>;
    var i = 0;
    var max = arr.length;
    //console.log(arr);
    jQuery('#update-all').click(function(event) {
      
            event.preventDefault();
            jQuery(".happenings").html("Starting update, don't close this page<br><br>");
            updateRecord();
            
    });

    function updateRecord(){
      jQuery.ajax({
        url: '<?php echo url("alma-import/index/update/");?>'+ arr[i],
        type: 'GET',
        beforeSend: function() {
        },
        complete: function() {
          i++;
          if (i<max) {
            updateRecord();
          }
          if(i == max){
            jQuery('.happenings').append("<br>We're done, you can close this window!");
          }
          
        },
        success: function(result) {
          jQuery('.happenings').append(result);          
          console.log("Success ");
        }
      });
    }

    });
	</script>
<?php //echo foot();
