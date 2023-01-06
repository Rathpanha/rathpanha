<?php if($user->isLogin()) { ?>
  <a class="items <?php if($menu === "dashboard") { echo "active"; } ?>" href="/"><i class="fas fa-tachometer-alt fa-lg fa-fw"></i> <?php echo lang("DASHBOARD"); ?></a>

  <a class="items parent <?php if($menu === "merchant") { echo "active"; } ?>" href="#"><i class="fas fa-people-carry fa-lg fa-fw"></i> <?php echo lang("MERCHANT"); ?></a>
  <div class="wrap-sub">
    <a class="items <?php if($menu === "merchant_add") { echo "active"; } ?>" href="/merchant/add"><i class="fas fa-plus fa-lg fa-fw"></i> <?php echo lang("ADD"); ?></a>
    <a class="items <?php if($menu === "merchant_list") { echo "active"; } ?>" href="/merchant/list"><i class="fas fa-list fa-lg fa-fw"></i> <?php echo lang("LIST"); ?></a>
  </div>
  
  <a class="items parent <?php if($menu === "inventory") { echo "active"; } ?>" href="#"><i class="fas fa-boxes fa-lg fa-fw"></i> <?php echo lang("INVENTORY"); ?></a>
  <div class="wrap-sub">
    <a class="items <?php if($menu === "inventory_add") { echo "active"; } ?>" href="/inventory/add"><i class="fas fa-plus fa-lg fa-fw"></i> <?php echo lang("ADD"); ?></a>
    <a class="items <?php if($menu === "inventory_list") { echo "active"; } ?>" href="/inventory/list"><i class="fas fa-list fa-lg fa-fw"></i> <?php echo lang("LIST"); ?></a>
  </div>
  
  <a class="items parent <?php if($menu === "inventory_import") { echo "active"; } ?>" href="#"><i class="fas fa-dolly-flatbed fa-lg fa-fw"></i> <?php echo lang("INVENTORY IMPORT"); ?></a>
  <div class="wrap-sub">
    <a class="items <?php if($menu === "inventory_import_add") { echo "active"; } ?>" href="/inventory/import/add"><i class="fas fa-plus fa-lg fa-fw"></i> <?php echo lang("ADD"); ?></a>
    <a class="items <?php if($menu === "inventory_import_list") { echo "active"; } ?>" href="/inventory/import/list"><i class="fas fa-list fa-lg fa-fw"></i> <?php echo lang("LIST"); ?></a>
  </div>
  
  <a class="items parent <?php if($menu === "money") { echo "active"; } ?>" href="#"><i class="fas fa-hand-holding-usd fa-lg fa-fw"></i> <?php echo lang("MONEY RECORD"); ?></a>
  <div class="wrap-sub">
    <a class="items <?php if($menu === "money_add") { echo "active"; } ?>" href="/money/add?default=2"><i class="fas fa-plus fa-lg fa-fw"></i> <?php echo lang("ADD"); ?></a>
    <a class="items <?php if($menu === "money_list") { echo "active"; } ?>" href="/money/list?type=2"><i class="fas fa-list fa-lg fa-fw"></i> <?php echo lang("LIST"); ?></a>
  </div>
  
  <a style="border-top: 1px solid #626567; margin-top: 2rem;"  class="items" href="/account/logout"><i class="fas fa-sign-out-alt fa-lg fa-fw"></i> <?php echo lang("LOGOUT"); ?></a>
<?php } ?>