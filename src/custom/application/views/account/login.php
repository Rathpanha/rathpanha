<?php $this->show("parts/header"); ?>
<?php /*@var $errors \GUI\ErrorMessage */ ?>
  
<div class="wrap-content desktop">
  <div class="wrap-login">
    <?php $errors->showError(); ?>
    <div class="block border">
      <div class="title"><?php echo lang("Login"); ?></div>  
      <form method="post">
        <?php \Security\CSRF::generateField(); ?>
        <label><?php echo lang("Username"); ?></label>
        <input class="full" name="username" type="text" placeholder="<?php echo lang("Username"); ?>" required autofocus value="<?php sp($_POST['username']); ?>"/>
                  
        <label><?php echo lang("Password"); ?></label>
        <input class="full" name="password" type="password" placeholder="••••••••" required/>                        
                  
        <div class="my1">
          <label class="rc-container"><?php echo lang("Remember Me"); ?>
            <input name="stay_login" type="checkbox">
            <span class="checkmark"></span>
          </label>
        </div>
        
        <button class="btn full"><i class="fas fa-sign-in-alt"></i> <?php echo lang("Login"); ?></button>
      </form>
    </div>
  </div>
</div>

<?php $this->show("parts/footer");?>