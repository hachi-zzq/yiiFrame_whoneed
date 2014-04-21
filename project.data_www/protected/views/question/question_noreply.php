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
                <li><a href="/question/submit" >常见问题提交&nbsp;></a></li>
                <li><a href="/question/replyed">查看已回复问题&nbsp;></a></li>
                <li><a href="/question/noReply" class="current">等待回复问题&nbsp;></a></li>
            </ul>

        </div>

        <div id="c_right">

            <div id="que_list">
                <table>
                    <tbody>
                    <tr class="t_head">
                        <td>问题编号</td>
                        <td>问题类型</td>
                        <td>客服回复时间</td>
                        <td>状态</td>
                    </tr>
                    <?php
                    if($replyed){
                        foreach($replyed as $reply){
                            $type = Pdw_question_type::model()->find("id = '{$reply['question_type']}'")->type_name;
                            switch($reply['status']){
                                case '0':
                                    $status = '未接入';
                                    $style = 'style="color:red"';
                                    break;
                                case '1':
                                    $status = '已接入';
                                    $style = '';
                                    break;
                                case '2':
                                    $status = '正在流转处理';
                                    $style = 'style="color:green"';
                                    break;
                                case '3':
                                    $status = '流转已回复';
                                    $style = 'style="color:blue"';
                                    break;
                                case '4':
                                    $status = '已回复客户';
                                    $style = 'style="color:blue"';
                                    break;
                                default:
                                    $status = '未知';break;
                            }
                            ?>
                            <tr>
                                <td><?php echo $reply['id']?></td>
                                <td><a href="/question/detail?id=<?php echo $reply['id']?>"><?php echo $type?></a></td>
                                <td><?php echo $reply['reply_time']?></td>
                                <td>正在处理中</td>
                            </tr>
                        <?php
                        }
                    }
                    ?>
                    </tbody>
                </table>
            </div>

        </div>


    </div>


    <div id="footer">
        <p>温馨提示：请点击问题类型查看回复结果。</p>
    </div>

</div>
</body>
</html>
