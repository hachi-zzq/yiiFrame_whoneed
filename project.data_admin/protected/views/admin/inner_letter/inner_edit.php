<script type="text/javascript" src="/admin/js/xheditor-1.1.14/xheditor-1.1.14-zh-cn.min.js"></script>
<script type="text/javascript">
    $('#elm2').xheditor({upImgUrl:"/uploadFile.php",upImgExt:"jpg,jpeg,gif,png"});
</script>
<div class="pageContent">
<form action="/admin/auto_form/auto_add_save" method="post" class="pageForm required-validate"
      enctype="multipart/form-data" onsubmit="return iframeCallback(this, navTabAjaxDone);">
<div class="pageFormContent" layouth="10" style="height: 669px; overflow: auto;">
<div class="unit">
    <label>
        标题：
    </label>
    <input type="text" size="30" name="table50[title]" value="" class="textInput">
                <span class="inputInfo">
                    &nbsp;
                </span>
</div>

<div class="unit">
<label>
          内容：
</label>
    <textarea id="elm2" name="letter_content" rows="12" cols="80" style="width: 80%"><?php echo $one['content']?></textarea>


</div>

<div class="unit">
    <label>
             收件人：
    </label>
    <select name="table50[cat_id]">
        <?php
            if(isset($all_user) && !empty($all_user)){
                foreach($all_user as $u){
                    echo '<option value="'.$u['username'].'">'.$u['username'].'</option>';
                }
            }
        ?>
    </select>
                <span class="inputInfo">
                    &nbsp;
                </span>
</div>
<div class="unit">
    <label>
        创建时间：
    </label>
    <input type="text" format="yyyy-MM-dd HH:mm:ss" name="table50[create_time]"
           class="date textInput" size="30" value="">
    <a class="inputDateButton" href="javascript:;">
        选择
    </a>
                <span class="inputInfo">
                    &nbsp;
                </span>
</div>
<dl class="nowrap">
    <dt>
        &nbsp;
    </dt>
    <dd>
        <button type="submit">
            保存
        </button>
        &nbsp;&nbsp;
        <button type="button" class="close">
            取消
        </button>
    </dd>
</dl>
</div>
<input type="hidden" name="tid" value="50">
<input type="hidden" name="type" value="0">
</form>
</div>