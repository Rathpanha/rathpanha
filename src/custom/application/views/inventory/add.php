<?php $this->show("/parts/header"); ?>
<?php /* @var $errors \GUI\ErrorMessage */ ?>

<div class="wrap-content">
  <div class="measure">
    <h3 class="m0"><?php echo lang("INVENTORY"); ?></h3>
    
    <?php \GUI\SuccessMessage::showSuccess(); ?>
    <?php $errors->showError(); ?>
    <form method="post" autocomplete="off">
      <?php \Security\CSRF::generateField(); ?>
      
      <div class="wrap-block col-two">
        <div class="left-block">
          <div class="block border">
            <div class="title"><?php echo lang("Add Inventory"); ?></div>

            <label><?php echo lang("Inventory Name"); ?> <span class="fn-red">*</span></label>
            <input type="text" name="name" required autofocus value="<?php echo $_POST['name']; ?>"/>
          </div>
        </div>
      </div>

      <div class="submit"><button class="btn"><i class="fas fa-plus"></i> <?php echo lang("Add"); ?></button></div>
    </form>
  </div>
</div>

<?php $this->show("/parts/footer"); ?>