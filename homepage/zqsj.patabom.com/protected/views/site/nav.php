<div class="nav"><a href="/" id="index" >首页</a><a href="/site/articleList/" id="news">新闻公告</a><a href="/site/download" id="download">下载</a><a href="/site/gameInfo" class="m_l50" id="game_info">游戏资料</a><a href="/site/guider" id="guider">游戏攻略</a><a id="forum" href="http://bbs.patabom.com/forum.php?mod=forumdisplay&fid=41" target="_blank">论坛</a><img class="img_pos" alt="二维码" border="0" src="<?php echo Yii::app()->params['img_domain'].Pdw_homepage_qrcode::model()->find("id = 39")->qrcode_img?>" width="105" height="105" /></div>
<?php
if($current == 'index'){
    MyFunction::addClass('index','current');
}
if($current == 'news'){
    MyFunction::addClass('news','current');
}
if($current == 'download'){
    MyFunction::addClass('download','current');
}
if($current == 'game_info'){
    MyFunction::addClass('game_info','current');
}
if($current == 'forum'){
    MyFunction::addClass('nav5','current');
}
if($current == 'guider'){
    MyFunction::addClass('guider','current');
}


?>