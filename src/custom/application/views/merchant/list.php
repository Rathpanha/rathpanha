<?php $this->show("/parts/header"); ?>

<div class="wrap-content">
  <div class="measure">
    <h3 class="m0"><?php echo lang("MERCHANT LIST"); ?></h3>
    
    <form method="GET" autocomplete="off">
      <select name='merchant_id' data-placeholder="Search Merchant" required>
        <option> </option>
        <?php foreach ($merchants_all as $value) { ?>
          <option value='<?php echo $value->merchant_id; ?>'><?php sp("{$value->merchant_id} " . $value->merchant_name); ?></option>
        <?php } ?>
      </select>
      <button class="btn"><i class="fas fa-search"></i></button>
    </form>
    
    <?php if(!empty($merchants->data)) { ?>
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
            <?php foreach($merchants->data as $key => $value) { ?>
              <tr>
                <td><?php sp($value->merchant_id); ?></td>
                <td class="left"><?php sp($value->merchant_name); ?></td>
                <td><?php sp(Date::convertToReadable($value->merchant_added_datetime)); ?></td>
                <td><a href="/merchant/edit/<?php sp($value->merchant_id); ?>" class="btn btn-xsmall"><i class="fas fa-edit"></i></a></td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    
      <center><?php echo $merchants->pagination; ?></center>
    <?php } else { ?>
      <label><?php sp(lang("There is no merchant yet")) ?>.</label>
    <?php } ?>
  </div>
</div>

<script>
  $("select[name='merchant_id']").chosen({search_contains: true, allow_single_deselect: false});
</script>

<?php $this->show("/parts/footer"); ?>