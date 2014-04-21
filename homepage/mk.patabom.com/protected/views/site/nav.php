<div id="nav" style="z-index:10000">
    <div class="content_nav">
        <a id="nav1" href="/" ><span>官网首页</span></a><a id="nav2" href="/site/articleList"><span>新闻中心</span></a><a id="nav3" href="http://bbs.patabom.com/forum.php?mod=forumdisplay&fid=36" target="_blank"><span>游戏论坛</span></a><a id="nav4" class="n_l" href="/site/gameInfo"><span>游戏资料</span></a><a id="nav5" href="/site/guider"><span>游戏攻略</span></a><a id="nav6" href="/site/customer"><span>客服中心</span></a></div>
</div>
<?php
if($current == 'index'){
    MyFunction::addClass('nav1','current');
}
if($current == 'news'){
    MyFunction::addClass('nav2','current');
}
if($current == 'download'){
    MyFunction::addClass('nav3','current');
}
if($current == 'game_info'){
    MyFunction::addClass('nav4','current');
}
if($current == 'customer'){
    MyFunction::addClass('nav6','current');
}
if($current == 'guider'){
    MyFunction::addClass('nav5','current');
}

?>