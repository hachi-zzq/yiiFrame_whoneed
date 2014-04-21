<!--//个人主页 资料 VIP 积分 背包 充值信息 站内信。。。公用-->

<div class="customer_title clearfix">
        <div class="customer_nav">
            <a href="<?php echo Yii::app()->createUrl('user')?>"  id="user">个人主页</a>
            <a href="<?php echo Yii::app()->createUrl('user/logininfo')?>" id="user_info">资料</a>
<!--            <a href="--><?php //echo Yii::app()->createUrl('user/viplevel')?><!--">VIP</a>-->
<!--            <a href="--><?php //echo Yii::app()->createUrl('user/vipscore')?><!--">积分</a>-->
<!--            <a href="--><?php //echo Yii::app()->createUrl('user/backpack')?><!--">背包</a>-->
<!--            <a href="--><?php //echo Yii::app()->createUrl('user/recharge')?><!--">充值信息</a>-->
            <a href="<?php echo Yii::app()->createUrl('innerletter')?>" id="innerletter">站内信
                <?php
                    if( ! Yii::app()->user->isGuest){
                        $letter_model = Pdw_inner_letter::model();
                        $count = $letter_model->count('to_user=:user_id and status=0',array(
                           'user_id'=>Yii::app()->user->id
                        ));
                        if($count>0){
                ?>

                <span>&nbsp;<img alt="" border="0" src="<?php echo  Yii::app()->baseUrl?>/images/new.gif" /></span>
                <?php
                        }
                    }
                ?>
            </a>
            <a href="<?php echo Yii::app()->createUrl('user/gameProgress')?>" id="game_progress">存档找回</a>
        </div>

        <?php
            if(Yii::app()->user->isGuest){
                ?>
                <div class="customer_login">
                    <a href="javascript:void(0);" data-reveal-id="myModal">登录</a>
                    <span class="customer_span">&nbsp;&nbsp;|&nbsp;&nbsp;</span>
                    <a href="javascript:void(0);" data-reveal-id="myModalRegister">注册</a>
                </div>

            <?php
            }else{
                ?>
                <div class="customer_login">
                    <span class="customer_span_out"><?php echo Yii::app()->user->name?></span>
                    <span class="customer_span_out">，欢迎您！</span>
                    <a class="customer_a_out" href="<?php echo Yii::app()->createUrl('user/logout')?>">退出登录</a>
                </div>
            <?php
            }
        ?>

    </div>
<?php


if($person_current == 'user'){
     MyFunction::addClass('user','visited');
}
if($person_current == 'user_info'){
    MyFunction::addClass('user_info','visited');
}
if($person_current == 'innerletter'){
    MyFunction::addClass('innerletter','visited');
}
if($person_current == 'game_progress'){
    MyFunction::addClass('game_progress','visited');
}



?>