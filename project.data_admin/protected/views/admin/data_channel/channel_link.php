    <div>
        <table class="list" width="98%">
            <thead>
            <tr>
                <th>渠道名称</th>
                <th>下载地址</th>
            </tr>
            </thead>
            <tbody>

            <tr>
                <td><?php echo $channel_name?></td>
<!--                <td><a href="--><?php //echo Yii::app()->params['fore_domain'].'/'.$company_ab.'_'.$product_ab.'_'.$channel_id.'_'.$sub_id?><!--" target="navTab">--><?php //echo Yii::app()->params['fore_domain'].'/'.$company_ab.'_'.$product_ab.'_'.$channel_id.'_'.$sub_id?><!--</a></td>-->
                <td>
                    <a href="<?php echo Yii::app()->params['fore_domain'].'/'.$link_param?>" target="navTab">
                        <?php echo Yii::app()->params['fore_domain'].'/'.$link_param?>
                    </a>
                </td>
            </tr>
            </tbody>
        </table>
    </div>