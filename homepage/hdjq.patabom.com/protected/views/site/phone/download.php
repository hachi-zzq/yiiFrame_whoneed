<div class="download">
    <?php
    //get download url
    //IOS
    $objDB = HP::get_qrcode_by_id(12);
    //andriod
    $objAndroid =  HP::get_qrcode_by_id(14);
    ?>
    <ul>
        <li class="left"><a href="<?php echo $objAndroid->download_url;?>"><img src="/phone_images/download01.png" alt="" class="image image-full"></a></li>
        <li class="right"><a href="<?php echo $objDB->download_url;?>" target="_blank"><img src="/phone_images/download02.png" alt="" class="image image-full"></a></li>
    </ul>
</div>