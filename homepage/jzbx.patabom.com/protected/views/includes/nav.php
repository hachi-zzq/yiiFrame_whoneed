<div id="main_top">
    <div class="nav">
        <a id="index" href="/" class="m_l340">官网首页</a><a id="news" href="/article/articlelist">新闻中心</a><a id="game_download" href="/game/download">游戏下载</a><a id="game_info" href="/article/gameInfo">游戏介绍</a><a href="http://bbs.patabom.com/forum.php?mod=forumdisplay&fid=52" target="_blank">游戏论坛</a></div>
</div>
<?php
if($current == 'index'){
    MyFunction::addClass('index','current');
}
if($current == 'news'){
    MyFunction::addClass('news','current');
}
if($current == 'download'){
    MyFunction::addClass('game_download','current');
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