<?php $this->show("/parts/header"); ?>
<?php /* @var $errors \GUI\ErrorMessage */ ?>

<div class="wrap-content">
  <div class="measure">
    <h3 class="m0"><?php echo lang("MONEY RECORD"); ?></h3>
    
    <?php \GUI\SuccessMessage::showSuccess(); ?>
    <?php $errors->showError(); ?>
    <form method="post" autocomplete="off">
      <?php \Security\CSRF::generateField(); ?>
      
      <div class="wrap-block col-two">
        <div class="left-block">
          <div class="block border">
            <div class="title"><?php echo lang("Add Record"); ?></div>
            
            <div class="wrap-block col-two">
              <div class="left-block">
                <label><?php echo lang("Date"); ?> <span class="fn-red">*</span></label>
                <input type="date" name="date" required value="<?php echo Date::getNowDate(); ?>"/>
              </div>
              
              <div class="right-block">
                <label><?php echo lang("Type"); ?> <span class="fn-red">*</span></label>
                <select name="type" required>
                  <option value="1" <?php if($_GET['default'] === "1") { echo "selected"; } ?>>ប្រាក់សាងសង់ទីលានរទេះ</option>
                  <option value="2" <?php if($_GET['default'] === "2") { echo "selected"; } ?>>ប្រាក់អគ្គិសនីនិងទឹក</option>
                </select>
              </div>
              
              <div class="left-block">
                <label><?php echo lang("Income"); ?> / ចំណូល ៛ <span class="fn-red">*</span></label>
                <input type="number" name="amount_income" step="100" autofocus/>
              </div>
              
              <div class="right-block">
                <label><?php echo lang("Expense"); ?> / ចំណាយ ៛ <span class="fn-red">*</span></label>
                <input type="number" name="amount_expense" step="100"/>
              </div>
            </div>

            <label><?php echo lang("Note"); ?></label>
            <textarea name="note" rows="4" style="height: auto;"></textarea>
          </div>
        </div>
      </div>

      <div class="submit"><button class="btn"><i class="fas fa-plus"></i> <?php echo lang("Add"); ?></button></div>
    </form>
  </div>
</div>

<?php $this->show("/parts/footer"); ?>