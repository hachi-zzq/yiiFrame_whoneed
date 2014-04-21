<?php include 'cheader_new_detail.php'; ?>

<!-- main -->
<div id="main_ny">
  <div class="main_top">
    <?php include 'cnav.php'; ?>
  </div>
  <div id="wrap2" class="m_t300">
  <div class="dh_title">您当前所在位置：<a href="/">首页</a>&nbsp;>>&nbsp;<a href="/site/cdetail/id/<?php echo $id; ?>"><?php echo $sname; ?></a></div>
    <div id="wrap3">
      <div class="content">
        <div class="content_c">
            <?php if($objDB->intro){ echo $objDB->intro; } ?>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- main end -->

<?php include 'cfooter.php'; ?>

