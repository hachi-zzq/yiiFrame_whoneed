<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>客服页面</title>
    <link id="style" type="text/css" rel="stylesheet" />
    <script src="/js/jquery-1.10.2.min.js"></script>
    <link href="/css/phone/css.css" rel="stylesheet" type="text/css">
    <script type="text/javascript">
        function getValue(){
            document.getElementById('ye').value = document.getElementById('id_uploadfile').value;
        }
    </script>
</head>
<body>
<div class="top">
    <div class="fh"><a href="/question/phoneQuestion?role_name=<?php echo urldecode($_GET['role_name'])?>&game_area=<?php echo urldecode($_GET['game_area'])?>"><img src="/images/phone/fh.png" width="60" height="94"></a></div>
    <div class="logo"><img src="/images/phone/logo.png" width="230" height="21"></div>
</div>

<div class="title">
    <div class="title01">在线问题表单答疑</div>
    <div class="title02">在线问题表单答疑是直接联系我们的一个快速通道，可以通过表单答疑系统提交您所遇到的问题详细描述，我们将通过最快捷的方式回复您。</div>
    <h1></h1>
    <span></span>
</div>


<div class="con01">

    <div class="from">
        <form id="question_form" action="<?php echo Yii::app()->request->requestUri?>" method="post" enctype="multipart/form-data" onsubmit="return checkEmpty($('#id_content'),$('#phone'))">
            <ul>
                <li><span><i>*</i>服务器：</span><input name="game_area" type="text" class="input5" id="id_rolename" readonly="readonly" value="<?php echo urldecode($_GET['game_area'])?>">
                </li>

                <li><span><i>*</i>角色名：</span><input name="role_name" type="text" class="input5" id="id_rolename" readonly="readonly" value="<?php echo urldecode($_GET['role_name'])?>"></li>
                <li><span><i>*</i>问题类型：</span>
                <select id="question_type" name="question_type" class="input4">
                    <?php
                    $objQuestionType = Pdw_question_type::model()->findAll();
                    print_r($objQuestionType);
                        if($objQuestionType){
                            foreach($objQuestionType as $type){
                                ?>
                                <option value="<?php echo $type['id']?>"><?php echo $type['type_name']?></option>
                            <?php
                            }
                        }
                        ?>
                </select>
                </li>
                <li><span><i>*</i>问题详情：</span>
                    <label>
                        <textarea name="question_description" id="id_content" cols="45" rows="5" class="input7"></textarea>

                    </label>
                </li>
                <li><span>联系方式：</span><input id="phone" name="user_phone" type="text" class="input5">
                </li>
                <li><span>上传截图：</span>
                    <div style="float:left; width:100%; height:50px;margin:15px 0 0 0;">
                        <input type="file" id="id_uploadfile" name="img_thumb" onchange="getValue()" style="-moz-opacity:0;filter:alpha(opacity=0); opacity:0; position:absolute;height:50px;">
                        <input id="ye" style="color: green;border: 1px solid #b7babf; width:66%; height:50px; font-size:20px; padding:0;">
                        <input type="button" value="浏览" onclick="$('#id_uploadfile').click()" style="width:30%; height:50px; font-size:20px;float:right;">
                    </div>
                </li>
                <li class="btn"><input type="submit" value="提交"  class="from_btn01">
                    <input type="button" id="id_reset" value="重填" onclick="javascripts:location.reload();"  class="from_btn02"></li>

            </ul>
        </form>
    </div>
</div>
<script>
     function submitCheck(objContent,objPhone){
         if(objContent.val() == ''){
             alert('内容详情不能为空');
             return false;
         }

         var  reg= /^1[358][\d]{9}$/;
         if((trim(objPhone.val()) != '') && ! reg.test(objPhone.val())){
             alert('手机号码不合法');
             return false;
         }

     }


</script>
</body>
</html>
