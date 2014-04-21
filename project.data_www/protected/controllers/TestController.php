<?php
/**
 *
 *
 * @author		<Yingyh@whoneed.com>
 * @copyright	Copyright 2014
 *
 */

class TestController extends MyPageController
{
	// fx7794
    public function actionFX7794()
    {
        // step1: get localhost 7794 ip
        $arrIp = array();
        $intBid  = 0;
        $intLimit= 1000;
        $intC    = 0;
        while(true){
            $objConn = Yii::app()->db_data_log;
            $strSql = "select id,ip from pdl_channel_day_20140305 where id > {$intBid} and channel_id = 38 and sub_id = 0 limit {$intLimit}";
            try{
				$arrR = $objConn->createCommand($strSql)->queryAll();
				if(!empty($arrR)){
                    foreach($arrR as $k=>$v){
                        $arrIp[$v['ip']] = 1;
                        $intC++;

                        $intBid = $v['id'];
                    }
                }else{
                    break;
                }
            }catch(Exception $e){
                break;
            }
        }

        echo "一共有 {$intC} 次的点击.<br/><br/>";

        //step2: get the sdk user ip and k to k
        $countReg = 0;
        $strPath = '/data/tt.txt';
        /*
        echo '<table>';
        echo '<tr>';
        echo "<th>编号</th>";
        echo "<th>角色名</th>";
        echo "<th>等级</th>";
        echo "<th>元宝</th>";
        echo "<th>ip</th>";
        echo '</tr>';*/
        $f= fopen($strPath,"r");
        while(!feof($f))
        {
            /*
                $countReg++;*/
            $ip = trim(fgets($f));
            $arrLine = explode(' ', $line);
            /*
            echo '<tr>';
            echo "<td>{$countReg}</td>";
            echo "<td>{$arrLine['4']}</td>";
            echo "<td>{$arrLine['5']}</td>";
            echo "<td>{$arrLine['8']}</td>";
            echo "<td>{$arrLine['11']}</td>";
            echo '</tr>';
             */
            if($arrIp[$ip]){
                $countReg++;
                echo "<br/>{$ip}<br/>";
            }
        }
        fclose($f);
        //echo '</table>';
        echo "一共有 {$countReg} 人注册了。<br/>";

        if($countReg)
            echo "转化比例为:".($countReg / $intC * 100)."<br/>";
	}

    public function actionTmc()
    {
        $objDB = Whoneed_tmc::model()->findAll();
        if($objDB){
            foreach($objDB as $obj){
                echo "id:".$obj->id.', oid:'.$obj->oid."<br/>";
            }
        }
    }

    public function actionTest(){
        $py = MyUsePinyin::Pinyin('朱正钱');
        echo $py;
        $sum = 0;
        for($i=0;$i<strlen($py);$i++){
           $sum += ord($py[$i]);
        }
        echo 9%10;
    }


}
?>
