<?php $this->show("/account/toolbar"); ?>
<?php /* @var $errors \GUI\ErrorMessage */ ?>

<div class="wrap-content">
  <div class="measure">
    <?php \GUI\SuccessMessage::showSuccess(); ?>
    <?php $errors->showError(); ?>
    <form method="post" autocomplete="off">
      <?php \Security\CSRF::generateField(); ?>

      <div class="wrap-block col-two">
        <div class="left-block">
          <div class="block border">
            <div class="title"><?php echo lang("Change Password"); ?></div>

            <label><?php echo lang("Current Password"); ?> <span class="fn-red">*</span></label>
            <input type="password" name="password_current" required autofocus/>

            <label><?php echo lang("New Password"); ?> <span class="fn-red">*</span></label>
            <input type="password" name="password_new" required/>

            <label><?php echo lang("Confirm New Password"); ?> <span class="fn-red">*</span></label>
            <input type="password" name="password_new_confirm" required/>
          </div>
        </div>
      </div>

      <div class="submit"><button class="btn"><i class="fas fa-exchange-alt"></i> <?php echo lang("Change"); ?></button></div>
    </form>
  </div>
</div>

<?php $this->show("/parts/footer"); ?>