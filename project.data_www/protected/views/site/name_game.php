<form method="post" action="<?php echo Yii::app()->request->requestUri?>">
    <input type="text" name="user_name" value="<?php echo $name?>">
    <input type="submit" value="占卜">
</form>