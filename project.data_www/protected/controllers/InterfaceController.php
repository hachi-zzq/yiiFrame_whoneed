<?php
/**
 * 接口
 *
 * @author      黑冰<001.black.ice@gmail.com>
 * @copyright	Copyright 2014
 *
 */

class InterfaceController extends MyPageController
{
	// index
    public function actionIndex()
    {
        $this->funRC();
	}
	
    // save the online apk info
    public function actionSave_apk_info()
    {
        //获取到消息实体
        $type       = trim($_GET['type']);
        $dataField  = 'apk_data';
        $jsonData   = $type == 'POST' ? $_POST[$dataField] : $_GET[$dataField];

        if($jsonData){
            $arrData = json_decode($jsonData,TRUE);
            $count = count($arrData);
            $successCount = 0;
            foreach($arrData as $data){
                $package_model = new Pdc_package();
                $package_model->id = $data['id'];
                $package_model->title = $data['title'];
                $package_model->package_path = $data['package_path'];
                $package_model->package_path_md5 = $data['package_path_md5'];
                $package_model->create_time = $data['create_time'];
                $package_model->status = $data['status'];
                if($package_model->save()){
                    $successCount ++;
                }else{
                    //save exception
                    MyFunction::saveException('save_apk_info','apk数据入库失败');
                }
             }
            if($count == $successCount){
                $arrRet = array('error'=>0,'error_msg'=>'','count'=>$count,'success_count'=>$successCount);
            }else{
                $arrRet = array('error'=>1,'error_msg'=>'some data missing','count'=>$count,'success_count'=>$successCount);
            }
        }else{
            $arrRet = array('error'=>2,'error_msg'=>'data is null','count'=>0,'success_count'=>0);
        }
        echo json_encode($arrRet);
    }

    // do function
    function funRC()
    {
        echo "你的行为已经被记录，请立刻离开!";
    }
}
?>
