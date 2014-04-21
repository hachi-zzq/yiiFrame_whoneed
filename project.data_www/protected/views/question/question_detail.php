<?php include Page::importFile('meta_header.php')?>

<title>客服服务中心-问题提交</title>
    <link type="text/css" href="/css/tmp_style.css" rel="stylesheet" />
</head>
<body>
<div class="main_body">


    <div class="header">
        <div class="clearfix">
            <div class="logo left"></div>
            <div class="lg right"><span>***</span>&nbsp;&nbsp;欢迎您！&nbsp;&nbsp;<a href="#">退出登录</a></div></div>

        <div id="header_top" class="clearfix">

            <div id="title"><h1>客户服务中心<span>|</span>问题提交</h1></div>

            <div id="nav">
                <ul>
                    <li><a href="#">首页</a></li>
                    <li><a href="#">游戏</a></li>
                    <li><a href="#">新闻</a></li>
                    <li><a href="#">充值</a></li>
                    <li><a href="#">个人中心</a></li>
                </ul>
            </div>

        </div>

        <div id="header_title"><h3>问题提交 — 常见问题提交</h3></div>

    </div>




    <div id="content" class="clearfix">

        <div id="c_left">
            <ul>
                <li><a href="/question/submit" class="current">常见问题提交&nbsp;></a></li>
                <li><a href="/question/replyed">查看已回复问题&nbsp;></a></li>
                <li><a href="/question/noReply">等待回复问题&nbsp;></a></li>
            </ul>

        </div>

        <div id="c_right">
            <div id="que_detail">
                <table>
                    <tbody>
                    <?php
                    $style = '';
                    switch($detail['status']){
                        case '4':
                            $status = '已回复';
                            $style = 'style="color:red"';
                            break;
                        default:
                            $status = '正在处理中';break;
                    }
                    ?>
                    <tr>
                        <td class="b_left">问题编号： <span><?php echo $detail->id?></span></td>
                        <td>问题类型： <span><?php echo $detail->question_type?></span></td>
                        <td>问题状态： <span class="mark"><?php echo $status?></span></td>
                    </tr>

                    <tr>
                        <td class="b_left">所属游戏： <span><?php echo $detail->game_id?></span></td>
                        <td>服务器： <span><?php echo $detail->game_area?></span></td>
                        <td>角色名： <span><?php echo $detail->role_name?></span></td>
                    </tr>

                    <tr>
                        <td class="b_left">联系方式： <span><?php echo $detail->user_phone?></span></td>
                        <td></td>
                        <td></td>
                    </tr>
                    </tbody>
                </table>

                <p class="b_left">客服回复:</p>
                <div style="color: white;margin: 20px;"><?php echo $detail->reply_content?></div>

                <p class="b_left">问题描述:</p>
                <div style="color: white;margin: 20px;"><?php echo $detail->question_description?></div>
            </div>
        </div>


    </div>


    <div id="footer">
        <p>温馨提示：请点击问题类型查看回复结果。</p>
    </div>

</div>
</body>
</html>
