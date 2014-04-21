<form method="post" action="/interface/save_apk_info" enctype="multipart/form-data" >
    <input type="text" name="filedata" value="<?php echo $data?>"/>
    <input type="submit"/>
</form>
<?php
    echo $data;
?>