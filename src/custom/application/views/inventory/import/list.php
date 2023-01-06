<?php $this->show("/parts/header"); ?>

<div class="wrap-content">
  <div class="measure">
    <h3 class="m0"><?php echo lang("INVENTORY IMPORT LIST"); ?></h3>
    
    <form method="GET" autocomplete="off">
      <input type="date" name="date" value="<?php sp($date); ?>"/>
      
      <?php if(!empty($_GET['date'])) { ?>
        <a class="btn red" href="/inventory/import/list"><i class="fas fa-times"></i></a>
      <?php } ?>
        
      <button class="btn"><i class="fas fa-search"></i></button>
      <a class="btn mint" target="_blank" href="/inventory/import/print?date=<?php sp($date); ?>"><i class="fas fa-print"></i></a>
    </form>
    
    <?php if(!empty($imports->data)) { ?>
      <div class="wrap-table myt1">
        <table class="list fixed">
          <thead>
            <tr>
              <th style="width: 50px;">Nº</th>
              <th style="width: 150px;">Merchant</th>
              <th style="width: 70px;">Big</th>
              <th style="width: 70px;">Small</th>
              <th style="width: 500px;">Inventory</th>
              <th style="width: 80px;">Action</th>
            </tr>
          </thead>

          <tbody>
            <?php foreach($imports->data as $key => $value) { ?>
              <tr>
                <td><?php sp($key + 1); ?></td>
                <td class="left"><?php echo !empty($value->merchant_name) ? $value->merchant_name : "<span class='fn-red'>មិនមាន<span>"; ?></td>
                <td><?php sp(number_format($value->import_cart_big)); ?></td>
                <td><?php sp(number_format($value->import_cart_small)); ?></td>
                <td class="left no-ellipsis">
                  <?php echo InventoryImport::convertInventoryNameToHTML($value->inventories); ?>
                </td>
                <td><a href="/inventory/import/edit/<?php sp($value->import_id); ?>" class="btn btn-xsmall"><i class="fas fa-edit"></i></a></td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    
      <center><?php echo $imports->pagination; ?></center>
    <?php } else { ?>
      <label><?php sp(lang("There is no inventory import yet")) ?>.</label>
    <?php } ?>
  </div>
</div>

<?php $this->show("/parts/footer"); ?>