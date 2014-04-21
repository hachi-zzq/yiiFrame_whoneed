<?php include 'cheader_new_detail.php'; ?>
<div id="main_ny">
    <div class="main_top">
        <?php include 'cnav.php'; ?>
    </div>
    <div id="wrap2" class="m_t300">
        <div class="dh_title">您当前所在位置：<a href="/">首页</a>&nbsp;>>&nbsp;<a>姓名预测</a></div>
        <div id="wrap3">
            <div class="content">
                <div class="content_t">
                    <h1>姓名测你前世是什么皇帝</h1>

                </div>
                <div class="content_c">
                    <?php
                        if( ! $result){
                    ?>

                    <div class="youxi01">
                        <form id="name_game" method="post" action="<?php echo Yii::app()->request->requestUri?>">
                        <div class="youxi_input">
                            <input type="text" class="youxi_wb01" name="test_name" value="" placeholder="请输入您的名字">
                        </div>
                        <!--<div class="youxi_button"><input name="" type="button" class="youxi_an01"></div>-->
                        <div class="youxi_button"><a href="javascript:" onclick="$('#name_game').submit()"></a></div>
                    </div>
                    <?php
                        }else{
                            ?>

                    <div class="youxi02" >
                        <div class="youxi_input2"><?php echo $result?$result->keyword:''?></div>
                        <!-- <div class="youxi_button2"><input name="" type="button" class="youxi_an02"></div>-->
                        <div class="youxi_button2"><a href="/site/nameGame"></a></div>

                    </div>
                    <p>
                        <?php echo $result?$result->value:''?>
                    </p>
                <?php
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <?php include 'cfooter.php'?>