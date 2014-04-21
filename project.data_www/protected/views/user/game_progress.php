<?php include Page::importFile('meta_header.php')?>

<title><?php echo CHtml::encode($pageTitle)?>--<?php echo WEB_NAME?></title>
    <link href="<?php echo Yii::app()->request->baseUrl?>/css/style.css" rel="stylesheet" type="text/css">
    <link href="<?php echo Yii::app()->baseUrl?>/css/customer.css" rel="stylesheet" type="text/css">
    <link href="<?php echo Yii::app()->baseUrl?>/css/personData.css" rel="stylesheet" type="text/css">
    <link href="<?php echo Yii::app()->baseUrl?>/css/user.css" rel="stylesheet" type="text/css">
    <script src="<?php echo Yii::app()->baseUrl?>/js/jquery-1.10.2.min.js"></script>
    <link href="<?php echo Yii::app()->baseUrl?>/css/personRecharge.css" rel="stylesheet" type="text/css">
</head>
<body>
<?php include Page::importFile('cheader.php')?>

<div class="main_body">
    <?php include Page::importFile('user_page_top.php','/common/')?>
    <div class="customer_content">
    <?php if($data['flag']=='success'):?>
        <?php if( empty($data['data']['apps']) ):?>
            <?php echo '你目前没有任何游戏存档';?>
        <?php else: ?>
            <?php //var_dump($data['data']);?>
            <div class="select_game">请选择游戏：
                <select id="select_game">
                    <?php foreach($data['data']['apps'] as $key=>$val):?>
                    <option value="<?php echo $val['app_key'];?>" <?php if($data['data']['cur_app_key']==$val['app_key']): echo 'selected'; endif;?>><?php echo $val['name'];?></option>
                    <?php endforeach;?>
                </select>
            </div>
            <?php if( empty($data['data']['vistors']) ):?>
                        <p><?php echo '当前游戏没有存档';?></p>
                  <?php else:?>
            <table class="tb_list" id="t_list">
                <tbody>
                    <tr class="tb_title">
                            <td width="200">昵称</td>
                            <td width="100">性别</td>
                            <td width="200">生成时间</td>
                            <td width="200">替换时间</td>
                            <td width="">是否为原始帐号生成的存档</td>
                            <td>选择存档</td>
                    </tr>
                        <?php foreach($data['data']['vistors'] as $key=>$val): ?>
                        <tr class="tb_content">
                            <td><?php echo $val['user_name']; ?></td>
                            <td><?php echo $val['sex']; ?></td>
                            <td><?php if(!empty($val['role_ctime'])): echo date('Y-m-d H:i:s',$val['role_ctime']);endif; ?></td>
                            <td><?php if(!empty($val['btime'])): echo date('Y-m-d H:i:s',$val['btime']);endif; ?></td>
                            <td><?php if($val['is_origal']==1): echo '是';else: echo '否';endif; ?></td>
                            <td>
                                <input type="radio" name="orignal_token" value="<?php echo $key;?>" <?php if($val['orignal_token']==$data['data']['cur_token']):echo 'checked'; endif;?>/>
                                <input type="hidden" name="orignal_token_<?php echo $key;?>" value="<?php echo $val['orignal_token'];?>"/>
                                <input type="hidden" name="operate_key_<?php echo $key;?>" value="<?php echo $val['operate_key'];?>"/>
                            </td>
                        </tr>
                        <?php endforeach;?>
                </tbody>
            </table>
            <?php endif;?>
        <?php endif;?>
    <?php else: ?>
        <p style="color:red;"><?php echo $data['info'];?><p>
    <?php endif;?>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $(".bankbox > div:first").show();
        $(".choosebank li").each(function(index){
            $(this).click(function(){
                addrssid = $(this).attr("id");
                id = addrssid.replace('ban','');
                if($("#bank"+id).attr("checked")) {
                    $(".choosebank li").removeClass('cur');
                    $("#ban"+id).addClass('cur');
                    $(".bankbox > div:visible").hide();
                    $(".bankbox > div:eq(" + index + ")").show();
                }
            });
        });
    });

    $('#t_list input[name="orignal_token"]').change(function(){
		var sub	= $(this).val();
		var oToken	= $('#t_list input[name="orignal_token_'+sub+'"]').val();
		var oKey	= $('#t_list input[name="operate_key_'+sub+'"]').val();
		$.post("/user/changeRole/",{app_key:$('#select_game').val(),o_token:oToken,o_key:oKey},
            function(res){
                if(res.flag == 'success'){
                    alert('切换存档成功');
                }else{
                    alert(res.info);
                }
            },'json');
    });

    $(function(){
        $('#select_game').change(function(){
            location.href	= "/user/gameProgress/app_key/"+$(this).val();
            });
    });
</script>
<script>
function setTab(name,cursel,n){
    for(i=1;i<=n;i++){
        var menu=document.getElementById(name+i);/* zzjs1 */
        var con=document.getElementById("con_"+name+"_"+i);/* con_zzjs_1 */
        menu.className=i==cursel?"active":"";/*三目运算 等号优先*/
        con.style.display=i==cursel?"block":"none";
    }
}
</script>
<?php include Page::importFile('cfooter.php')?>
</body>
</html>
