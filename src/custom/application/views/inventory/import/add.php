<?php $this->show("/parts/header"); ?>
<?php /* @var $errors \GUI\ErrorMessage */ ?>

<div class="wrap-content">
  <div class="measure">
    <h3 class="m0"><?php echo lang("INVENTORY IMPORT"); ?></h3>
    
    <?php \GUI\SuccessMessage::showSuccess(); ?>
    <?php $errors->showError(); ?>
    <form method="post" autocomplete="off">
      <?php \Security\CSRF::generateField(); ?>
      
      <div class="wrap-block col-two">
        <div class="left-block">
          <div class="block border">
            <div class="title"><?php echo lang("Infomation"); ?></div>
            <div class="wrap-block col-two">
              <div class="full-block m0">
                <label><?php echo lang("Datetime"); ?> / ថ្ងៃខែនិងម៉ោង <span class="fn-red">*</span></label>
                <input type="datetime-local" name="datetime" required value="<?php echo date("Y-m-d\TH:i", strtotime(Date::getYesterdayDateTime())); ?>"/>
              </div>
              
              <div class="full-block m0">
                <label><?php echo lang("Merchant Name"); ?> / ឈ្មោះម្ចាស់ </label>
                <select name='merchant_id' data-placeholder="Select Merchant">
                  <option></option>
                  <?php foreach ($merchants as $value) { ?>
                    <option value='<?php echo $value->merchant_id; ?>'><?php sp($value->merchant_name); ?></option>
                  <?php } ?>
                </select>
              </div>
              
              <div class="left-block m0">
                <label><?php sp(lang("Big Cart")); ?> / រទេះធំ <span class="fn-red">*</span></label>
                <input type="number" name="cart_big" value="0" required/>
              </div>
              
              <div class="right-block m0">
                <label><?php sp(lang("Small Cart")); ?> / រទេះតូច <span class="fn-red">*</span></label>
                <input type="number" name="cart_small" value="0" required/>
              </div>
            </div>
          </div>
        </div>
        
        <div class="right-block">
          <div class="block border">
            <div class="title"><?php sp(lang("Inventory")); ?> / ទំនិញ</div>
            
            <label><?php sp(lang("Inventory")); ?> / ទំនិញ <span class="fn-red">*</span></label>
            <select name='inventories[]' data-placeholder="Select Inventory" required multiple>
              <option></option>
              <?php foreach ($inventories as $value) { ?>
                <option value='<?php echo $value->inventory_id; ?>'><?php sp($value->inventory_name); ?></option>
              <?php } ?>
            </select>
          </div>
        </div>
      </div>

      <div class="submit"><button class="btn"><i class="fas fa-plus"></i> <?php echo lang("Add"); ?></button></div>
    </form>
  </div>
</div>

<script>
  $("select[name='merchant_id']").chosen({search_contains: true, allow_single_deselect: true});
  $("select[name='inventories[]']").chosen({search_contains: true, allow_single_deselect: true});
</script>

<?php $this->show("/parts/footer"); ?>