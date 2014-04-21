    <div>
        <table class="list" width="98%">
            <thead>
            <tr>
                <th>渠道名称</th>
                <th>下载地址</th>
            </tr>
            </thead>
            <tbody>

            <?php
                if(isset($objPackage) && !empty($objPackage)){
                    $channel_id_param = '';
                    $sub_id_param = '';
                    if($channel_params['sub_id'] == 0){
                        $channel_id_param = 'channel_'.$channel_params['channel_id'].'.html';
                        $sub_id_param = '';
                    }else{
                        $channel_id_param = 'channel_'.$channel_params['channel_id'].'.html';
                        $sub_id_param = '?sub_id='.$channel_params['sub_id'];
                    }


            ?>
            <tr>
                <td><?php echo $channel_name?></td>
                <td><a href="<?php echo Yii::app()->params['fore_domain'].'/'.$channel_id_param.$sub_id_param?>" target="navTab"><?php echo Yii::app()->params['fore_domain'].'/'.$channel_id_param.$sub_id_param?></a></td>
            </tr>
            <?php
                }
            ?>
            </tbody>
        </table>
    </div>