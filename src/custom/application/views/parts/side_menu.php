<?php if($panel !== "admin") { ?>
  <!--For cover when toggle side menu-->
  <div class="side-menu-cover"></div>
<?php } ?>
    
<div class="side-menu <?php echo ($panel == "admin" ? "admin" : "desktop"); ?>">
  <div class="side-menu-header">
    <?php if($user->isLogin())  {?>
      <div class="user">
        <img class="user-picture" src="/images/profile.png"/> 

        <div class="user-name">
          <?php sp($user->account_username); ?>
        </div>

        <a class="user-edit <?php if($menu === "account_setting") { echo "active"; } ?>" href="/account/security"><i class="fas fa-user-cog fa-lg fa-fw"></i></a>
      </div> 
    <?php } else { ?>
      <div class="p1" style="text-align: center;">
        <a href="/account/login" class="btn full" style="margin-bottom: 0.5rem; color: #FFF;"><i class="fas fa-sign-in-alt"></i> <?php echo lang("LOGIN"); ?></a>
      </div>
    <?php } ?>
  </div>

  <div class="wrap-items">
    <?php $this->show('parts/side_menu_item'); ?>
  </div>
</div>