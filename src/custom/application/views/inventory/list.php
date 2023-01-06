<?php $this->show("/parts/header"); ?>

<div class="wrap-content">
  <div class="measure">
    <h3 class="m0"><?php echo lang("INVENTORY LIST"); ?></h3>
    
    <form method="GET" autocomplete="off">
      <select name='inventory_id' data-placeholder="Search Inventory" required>
        <option> </option>
        <?php foreach ($inventories_all as $value) { ?>
          <option value='<?php echo $value->inventory_id; ?>'><?php echo "{$value->inventory_id} " . $value->inventory_name; ?></option>
        <?php } ?>
      </select>

      <script>
        $("select[name='inventory_id']").chosen({search_contains: true, allow_single_deselect: false});
      </script>
        
      <button class="btn"><i class="fas fa-search"></i></button>
    </form>
    
    <?php if(!empty($inventories->data)) { ?>
      <div class="wrap-table myt1">
        <table class="list">
          <thead>
            <tr>
              <th>ID</th>
              <th>NAME</th>
              <th>ADDED ON</th>
              <th>Action</th>
            </tr>
          </thead>

          <tbody>
            <?php foreach($inventories->data as $key => $value) { ?>
              <tr>
                <td><?php sp($value->inventory_id); ?></td>
                <td class="left"><?php sp($value->inventory_name); ?></td>
                <td><?php sp(Date::convertToReadable($value->inventory_added_datetime)); ?></td>
                <td><a href="/inventory/edit/<?php sp($value->inventory_id); ?>" class="btn btn-xsmall"><i class="fas fa-edit"></i></a></td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    
      <center><?php echo $inventories->pagination; ?></center>
    <?php } else { ?>
      <label><?php sp(lang("There is no inventory yet")) ?>.</label>
    <?php } ?>
  </div>
</div>

<?php $this->show("/parts/footer"); ?>