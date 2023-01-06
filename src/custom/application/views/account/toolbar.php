<?php $this->show("parts/header"); ?>

<div class="wrap-toolbar">
  <div class="toolbar">
    <a href="/account/security">
      <div class="item <?php if($toolbar === "security") { echo "active"; } ?>"><span><i class="fas fa-key fa-lg fa-fw"></i><br><span class="text"><?php echo lang("SECURITY"); ?></span></span></div>
    </a>
  </div>
</div>