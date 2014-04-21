<?php include Page::importFile('meta_header.php')?>

<title>客服服务中心-问题提交</title>
    <link type="text/css" href="/css/tmp_style.css" rel="stylesheet" />
    <script src="/js/jquery-1.10.2.min.js"></script>
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

            <div id="submit">
                <form action="/question/submit" method="post" enctype="multipart/form-data" >
                    <div class="text_input">
                        <label>问题类型：</label>
                        <?php
                        $objQuestionType = Pdw_question_type::model()->findAll();
                        ?>
                        <select id="question_type" name="question_type" onchange="changeDisplay()">
                            <?php
                                if($objQuestionType){
                                    foreach($objQuestionType as $type){
                            ?>
                            <option value="<?php echo $type['id']?>"><?php echo $type['type_name']?></option>
                            <?php
                                    }
                                }
                            ?>
                        </select>
                    </div>
                    <div class="text_input">
                        <label>游戏名称：</label>
                        <select id="gameName" name="game_id">
                            <?php
                                $objGames = Pdw_games::model()->findAll();
                                if($objGames){
                                    foreach($objGames as $game){
                            ?>
                            <option value="<?php echo $game['id']?>"><?php echo $game['title']?></option>
                            <?php
                                    }
                                }
                            ?>
                        </select>
                    </div>
                    <div class="text_input">
                        <label>游戏区服：</label>
                        <select id="game_area" name="game_area" >
                            <option value="一区">一区</option>
                            <option value="二区">二区</option>
                            <option value="三区">三区</option>
                        </select>
                    </div>

                    <div class="text_input">
                        <label>所属平台：</label>
                        <select id="flatform_id" name="flatform_id" >
                            <?php
                                $objChannel = Pdc_channel::model()->findAll();
                                if($objChannel){
                                    foreach($objChannel as $channel){
                                ?>
                            <option value="<?php echo $channel['id']?>"><?php echo $channel['channel_name']?></option>
                            <?php
                                    }
                                }
                            ?>
                        </select>
                    </div>
                    <div class="text_input" id="role_name">
                        <label>角色名：</label> <input type="text"  name="role_name"/>
                    </div>

                    <div class="text_input" id="recharge_type">
                        <label>充值类型：</label>
                        <select name="recharge_type">
                            <?php
                                $rechargeType = Pdw_recharge_type::model()->findAll();
                                if($rechargeType){
                                    foreach($rechargeType as $type){
                            ?>
                                <option value="<?php echo $type['id']?>"><?php echo $type['name']?></option>
                            <?php
                                    }
                                }
                            ?>

                        </select>
                    </div>

                    <div class="text_input" id="recharge_order_number">
                        <label>充值订单号：</label> <input type="text"  name="recharge_order_number"/>
                    </div>

                    <div class="text_input" id="recharge_card_number">
                        <label>充值卡号：</label> <input type="text"  name="recharge_card_number"/>
                    </div>

                    <div class="text_input">
                        <label>问题描述：</label> <textarea id="description" name="question_description" ></textarea>
                    </div>
                    <div class="text_input">
                        <label>联系方式：</label> <input type="text" id="phone" name="user_phone" />
                    </div>
                    <div class="text_input">
                        <label>上传截图：</label> <input type="file"  id="img" name="img_thumb" /> <span>*截图不要超过1M</span>
                    </div>
                    <div class="text_input">
                        <input type="submit" value="提交" id="sub" />
                    </div>
                </form>
            </div>

        </div>


    </div>


    <div id="footer">
        <p>温馨提示：常见问题提交后，客服会在24小时内作出回复，届时，可以点击"查看已回复问题"来查看。</p>
    </div>

</div>
<script>
    function changeDisplay(){
        var opt = $('#question_type').val();

        if(opt == '1'){
            $('#recharge_type').show();
            $('#recharge_order_number').show();
            $('#recharge_card_number').show();
        }else{
            $('#recharge_type').hide();
            $('#recharge_order_number').hide();
            $('#recharge_card_number').hide();
        }
    }
</script>
</body>
</html>
