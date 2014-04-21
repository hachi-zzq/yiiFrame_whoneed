<script type="text/javascript" src="/admin/js/xheditor-1.1.14/xheditor-1.1.14-zh-cn.min.js"></script>
<script type="text/javascript">
    $('#elm1').xheditor({upImgUrl:"/uploadFile.php",upImgExt:"jpg,jpeg,gif,png"});
</script>
<form action="<?php echo Yii::app()->createUrl('admin/inner_letter/welcomeLetter')?>" method="post" class="pageForm required-validate" enctype="multipart/form-data" onsubmit="return iframeCallback(this, navTabAjaxDone);">
<input type="hidden" name="hidden_id" value="<?php echo $one['id']?>">
<div class="pageFormContent" layouth="10" style="height: 669px; overflow: auto;">
<div class="unit">
    <label>
        信函标题：
    </label>
    <input type="text" size="30" name="letter_title" value="<?php echo $one['title']?>" class="textInput">
        <span class="inputInfo">
            &nbsp;信函标题
        </span>
</div>
<div class="unit">
<label>
    信息内容：
</label>
    <textarea id="elm1" name="letter_content" rows="12" cols="80" style="width: 80%"><?php echo $one['content']?></textarea>

<dl class="nowrap">
    <dt>
        &nbsp;
    </dt>
    <dd>
        <button type="submit">
            编辑
        </button>
        &nbsp;&nbsp;
        <button type="button" class="close">
            取消
        </button>
    </dd>
</dl>
</div>
</form>