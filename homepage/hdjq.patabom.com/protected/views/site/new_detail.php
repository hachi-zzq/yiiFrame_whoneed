<?php include 'cheader_new_detail.php'; ?>

<!-- main -->
<div id="main_ny">
  <div class="main_top">
    <?php include 'cnav.php'; ?>
  </div>
  <div id="wrap2" class="m_t300">
  <div class="dh_title">您当前所在位置：<a href="/">首页</a>&nbsp;>>&nbsp;<a href="<?php echo $slink; ?>"><?php echo $sname; ?></a>&nbsp;>>&nbsp;<a href="" class="current"><?php echo $sname; ?> 详情</a></div>
    <div id="wrap3">
      <div class="content">
        <?php 
            $objData = HP::get_hp_article_content_obj($_GET['id']); 
            if($objData){
        ?>
        <div class="content_t">
            <h1><?php echo $objData->title; ?></h1>
            <p>
                作者：<span><?php echo $objData->author; ?></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span><?php echo $objData->submit_date;?></span>
                <div class=bshare-custom style="text-align: right;padding: 10px;">
                    <A class=bshare-qzone title=分享到QQ空间></A><A class=bshare-sinaminiblog title=分享到新浪微博></A><A class=bshare-renren title=分享到人人网></A><A class=bshare-qqmb title=分享到腾讯微博></A><A class=bshare-douban title=分享到豆瓣></A><A class="bshare-more bshare-more-icon more-style-addthis" title=更多平台></A><SPAN class="BSHARE_COUNT bshare-share-count">0</SPAN>
                </div>
                <SCRIPT src="http://static.bshare.cn/b/buttonLite.js#style=-1&amp;uuid=&amp;pophcol=2&amp;lang=zh" type=text/javascript charset="utf-8"></SCRIPT>
                <SCRIPT src="http://static.bshare.cn/b/bshareC0.js" type=text/javascript charset="utf-8"></SCRIPT>
            </p>

        </div>
        <div class="content_c">
            <?php if($objData->slave){ echo $objData->slave->intro; } ?>

        </div>

          <div class="content_footer">
              <p>《皇帝崛起》<a href="http://hd.patabom.com" target="_blank">官网地址</a></p>
              <p>《皇帝崛起》下载地址:<a href="https://itunes.apple.com/cn/app/huang-di-jue-qi/id604615270?mt=8">Ios</a>\<a href="http://cdn.patabom.com/uapk/20140321/King_V1.2.8_Rls_Us_201403210510_google_30.apk">安卓</a></p>
              <p>《皇帝崛起》<a href="http://bbs.patabom.com/forum.php?mod=forumdisplay&fid=51" target="_blank">皇帝论坛</a></p>
              <p>《皇帝崛起》<a href="http://tieba.baidu.com/p/2954458560" target="_blank">百度贴吧</a></p>
              <p>《皇帝崛起》微信服务号:ptb_cs</p>
              <p>《皇帝崛起》客服邮箱:service@friendou.com</p>
          </div>
      </div>
      <?php } ?>
    </div>
  </div>
</div>
<!-- main end -->
<?php include 'cfooter.php'; ?>