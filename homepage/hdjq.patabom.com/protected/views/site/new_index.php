<?php include 'cheader_new.php'; ?>
<style>
    #pagination ul a,#pagination ul {
        color: rgb(219, 171, 171);
    }
</style>
<!-- main -->
<div id="main_ny">
  <div class="main_top">
    <?php include 'cnav.php'; ?>
  </div>
  <div id="wrap2" class="m_t300">
  <div class="dh_title">您当前所在位置：<a href="/">首页</a>&nbsp;>>&nbsp;<a href="<?php echo $slink; ?>" class="current"><?php echo $sname; ?></a></div>
    <div id="wrap3">
      <div class="content">
        <?php 
            
            $arrData    = HP::get_hp_article_list($stype);
            $arrType    = HP::get_hp_type($stype);
        ?>
        <ul class="news_list">
        <?php 
            if($arrData['data']){
               foreach($arrData['data'] as $data){
        ?>
            <li><span class="left list_type">[<?php echo $arrType[$data['type']] ?>]</span>&nbsp;<a href="<?php echo $dlink; ?>/id/<?php echo $data['id']; ?>" title="<?php echo $data['title']; ?>"><?php echo $data['title']; ?></a><span class="right list_time"><?php echo date('Y-m-d', strtotime($data['submit_date']));?></span></li>
        <?php 
                }
            } 
        ?>
        </ul>
        <div id="pagination" class="pagination">
          <ul id="yw0" class="yiiPager">
            <?php echo $arrData['page'] ?>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- main end -->

<?php include 'cfooter.php'; ?>
