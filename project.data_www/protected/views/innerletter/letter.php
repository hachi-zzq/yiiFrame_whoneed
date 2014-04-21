<?php include Page::importFile('meta_header.php')?>

<title><?php echo $pageTitle?>--<?php echo WEB_NAME?></title>
    <link href="<?php echo Yii::app()->baseUrl?>/css/style.css" rel="stylesheet" type="text/css">
    <link href="<?php echo Yii::app()->baseUrl?>/css/customer.css" rel="stylesheet" type="text/css">
    <link href="<?php echo Yii::app()->baseUrl?>/css/personRecharge.css" rel="stylesheet" type="text/css">
    <link href="<?php echo Yii::app()->baseUrl?>/css/news.css" rel="stylesheet" type="text/css">
    <link href="<?php echo Yii::app()->baseUrl?>/css/scroll.css" rel="stylesheet" type="text/css">
    <link href="<?php echo Yii::app()->baseUrl?>/css/lyz.calendar.css" rel="stylesheet" type="text/css">

    <script src="<?php echo Yii::app()->baseUrl?>/js/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->baseUrl?>/js/jquery-1.4.4.min.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->baseUrl?>/js/jquery.reveal.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->baseUrl?>/js/jquery.scroll.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->baseUrl?>/js/lyz.calendar.min.js"></script>
</head>
<body>
<?php include Page::importFile('cheader.php')?>
<div class="main_body">
    <?php include Page::importFile('user_page_top.php','/common/')?>
    <div class="customer_content">
        <p class="pad_top30">您目前尚未读消息： <span><?php echo $noRead?></span>条</p>
        <div class="rec_search">
            <form name="form1" method="post" action="<?php echo Yii::app()->createUrl('innerletter/lettersearch')?>">
                <p>检索：
                    <span class="pad_left40"></span>
                    <?php
                        if(isset($is_search) && $is_search){
                     ?>
<!--        搜索视图-->
                    开始时间
                    <input type="text" class="input_time" name="start_time" id="txtBeginDate" value="<?php echo $search_time['start_time']?>"   />
                    <span class="pad_left33"></span>
                    结束时间
                    <input type="text" class="input_time" name="end_time" id="txtEndDate" value="<?php echo $search_time['end_time']?>" />
                    <?php
                        }else{
                            ?>
<!--         列表页-->
                    开始时间
                    <input type="text" class="input_time" name="start_time" id="txtBeginDate" value="2013-10-1"   />
                    <span class="pad_left33"></span>
                    结束时间
                    <input type="text" class="input_time" name="end_time" id="txtEndDate" value="<?php echo date('Y-m-d')?>" />
                        <?php
                        }
                    ?>



                    <input type="submit" name="time_search" id="time_search" value="搜索" class="click" />
                </p>
            </form>
        </div>
        <table class="tb_list">
            <tbody>
            <tr class="tb_title">
                <td width="190">NO.</td>
                <td width="350">标题</td>
                <td width="280">日期</td>
                <td>状态</td>
            </tr>
            <?php
            if(isset($letters) && !empty($letters)){
                foreach($letters as $letter_v){
                    ?>
                    <div  id="myModal<?php echo $letter_v['id']?>"  class="reveal-modal">
                        <div class="dumascroll">
                            <div class="news_back_btn"><a class="close-reveal-modal"><img alt="" border="0" src="<?php echo Yii::app()->baseUrl?>/images/back.gif" /></a></div>
                            <div class="news_model_title">
                                <p class="news_model_detail1"><?php echo $letter_v['title']?></p>
                                <p class="news_model_detail2"><?php echo $letter_v['send_time']?></span></p>
                            </div>
                            <div class="news_model_content clearfix">
                                <?php echo strip_tags($letter_v['content'])?>
                            </div>
                        </div>
                    </div>
                    <tr class="tb_content">
                        <td><?php echo $letter_v['id']?></td>
                        <td><a class="td_a <?php if($letter_v['status']==1) echo 'read'?>" onclick="changeStatus(<?php echo $letter_v['id']?>)" href="javascript:void(0);" data-reveal-id="myModal<?php echo $letter_v['id']?>"><?php echo $letter_v['title']?></a></td>
                        <td><?php echo $letter_v['send_time']?></td>
                        <td id="status<?php echo $letter_v['id']?>"><?php echo $letter_v['status']==0?'未读':'已读';?></td>
                    </tr>
                <?php
                }
            }
            ?>
            </tbody>
        </table>
    </div>
    <div class="pagination mag_top15 mar_btm35">

        <?php
        $pre = '<img alt="" border="0" style="vertical-align:top;" src='.Yii::app()->baseUrl.'/images/bt_left.png / >';
        $next = '<img alt="" border="0" src='.Yii::app()->baseUrl.'/images/bt_right.png / >';
        $this->widget('CLinkPager',array(
                'header'=>'',
                'footer'=>'',
                'firstPageLabel' => '',
                'lastPageLabel' => '',
                'prevPageLabel' => $pre,
                'nextPageLabel' => $next,
                'pages' => $page,
                'maxButtonCount'=>13
            )
        );
        ?>
        </a>
    </div>

</div>
</div>
<?php include Page::importFile('cfooter.php')?>
<script type="text/javascript">
    $(function () {
        $("#txtBeginDate").calendar({
            controlId: "divDate", // 弹出的日期控件ID，默认: $(this).attr("id") + "Calendar"
            speed: 200,  // 三种预定速度之一的字符串("slow", "normal", or "fast")或表示动画时长的毫秒数值(如：1000),默认：200
            complement: true,  // 是否显示日期或年空白处的前后月的补充,默认：true
            readonly: true, // 目标对象是否设为只读，默认：true
            upperLimit: new Date(),  // 日期上限，默认：NaN(不限制)
            lowerLimit: new Date("2011/01/01"),// 日期下限，默认：NaN(不限制)
            callback: function () {  // 点击选择日期后的回调函数

            }
        });
        $("#txtEndDate").calendar();
    });

    function changeStatus(id){
        $.ajax({
            url:"<?php echo Yii::app()->createUrl('innerletter/SetRead')?>",
            type:"POST",
            data:'id='+id,
            success:function(res){
                setRead(id);
            },
            error:function(){
                alert('error');
            }
        })
    }

    function setRead(id){
        $('#status'+id).text('已读');
    }
</script>
</body>
</html>
