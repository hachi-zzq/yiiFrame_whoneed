<?php

class FinanceController extends MyAdminController{
    // 初始化
    public function init(){
        parent::init();
    }
    
    //游戏财务信息显示
    public function actionShowList(){
        //param
        $operate_cat_id = intval(Yii::app()->request->getParam('oid'));
        $game_name      = Yii::app()->request->getParam('game_name');
        if( !empty($game_name) && $game_name!=='请输入游戏名称' ){
            $cdb = new CDbCriteria();
            $cdb->select='id';
            $cdb->condition = "title like :title";
            $cdb->params = array(':title'=>'%'.$game_name.'%');
            $games = Pdw_games::model()->findAll($cdb);
            if( !empty($games) ){
                foreach($games as $game){
                    $ids[]=$game->id;
                }
            }
        }
        $game_finance = Pdf_finance::model();
        $page = intval(Yii::app()->request->getParam('pageNum')) - 1;	//	分页
        
        $cdb = new CDbCriteria();
        if( !empty($ids) ){//通过游戏名字查找有结果
            $ids = join(',',$ids);
            $cdb->condition = "game_id in($ids) and operate_cat_id='$operate_cat_id' order by id desc";
        }else if( !empty($game_name) && $game_name!=='请输入游戏名称' ){//通过游戏名字查找没有结果
            $cdb->condition = "1=2";
        }else{
            $cdb->condition = "operate_cat_id='$operate_cat_id' order by id desc";
        }
        $count = $game_finance->count($cdb);

        $pages = new CPagination($count);
        $pages->currentPage = $page;
        $pages->pageSize = self::PAGE_SIZE;
        $pages->applyLimit($cdb);

        $all = $game_finance->findAll($cdb);

        //var_dump($cdb);var_dump($all);die();
        
        $data=array();
        $data['oid']  = $operate_cat_id;
        $data['game_name']  = $game_name;
        $data['pages']= $pages;
        $data['all']=$all;
        //获取游戏名称列表
        $data['game_list']=PataBomProject::funGetGameList();
        //获取游戏运营类别
        $data['game_operate']=Pdf_finance::$operate_cat;
        //获取游戏类型
        $data['game_cat']=Pdf_finance::$game_cat_list;
        //获取SDK接入
        $data['sdk']=Pdf_finance::$sdk;
        //获取收入分成计算方式
        //$data['income_method']=Pdf_finance::$income_method;
        $data['invoice_type_list']=Pdf_finance::$invoice_type_list;
        //var_dump($data['InvoiceTypeList']);die();
        $this->display('showList',$data);
    }
    
    //添加编辑财务信息
    public function actionAddEdit(){
        $data=array();
        if( isset($_GET['id']) ){
            $objDb=Pdf_finance::model()->findByPk((int)$_GET['id']);
            $data['objDb']=$objDb;
        }
        $this->display('addEdit',$data);
    }

	public function actionDelete(){
        //删除游戏财务信息
        $ids = Yii::app()->request->getParam('ids');
        $id_array=explode(',',$ids);
        $finance_count=Pdf_finance::model()->deleteByPk($id_array);
        //删除关联表信息pdf_finance_channel
        if( count($id_array)<=1 ){
            $condition="finance_id='$ids'";
        }else{
            $condition="finance_id in ($ids)";
        }
        $finance_channel_count=Pdf_finance_channel::model()->deleteAll($condition);
        if($finance_count && $finance_channel_count){
            $reArr=array("statusCode"=>"200","message"=>"操作成功");
        }else{
            $reArr=array("statusCode"=>"-100","message"=>"删除失败,请重新选择需要删除的数据!");
        }
        echo json_encode($reArr);
	}

	public function actionSave(){
        //保存游戏财务信息
        if( !empty($_REQUEST['finance_id']) && $finance_id=intval( Yii::app()->request->getParam('finance_id') ) ){
            $Pdf_finance=Pdf_finance::model()->findByPk($finance_id);
        }else{
            $Pdf_finance=new Pdf_finance;
        }
        $message='操纵成功!';
        $Pdf_finance->game_id           = intval( Yii::app()->request->getParam('game_id') );
        $Pdf_finance->operate_cat_id    = intval( Yii::app()->request->getParam('operate_cat_id') );
        $Pdf_finance->game_cat_id       = intval( Yii::app()->request->getParam('game_cat_id') );
        $Pdf_finance->channel_name      = Yii::app()->request->getParam('channel_name');
        $Pdf_finance->sdk               = intval(Yii::app()->request->getParam('sdk') );
        //$Pdf_finance->income_cal_method = intval(Yii::app()->request->getParam('income_cal_method') );
        $Pdf_finance->income_ratio_id   = intval(Yii::app()->request->getParam('income_ratio_id') );
        //$Pdf_finance->bdr_id            = intval(Yii::app()->request->getParam('bdr_id') );
        //$Pdf_finance->turnover_tax_id   = intval(Yii::app()->request->getParam('turnover_tax_id') );
        $Pdf_finance->invoice_type      = intval(Yii::app()->request->getParam('invoice_type') );
        $Pdf_finance->invoice_ratio     = intval(Yii::app()->request->getParam('invoice_ratio') );
        
        //事务处理开始
        $transaction=$Pdf_finance->dbConnection->beginTransaction();
        //事务处理默认为false  
        //保存关联表信息pdf_finance_channel
        $transaction_result=false;
        try{
            $finance_save=$Pdf_finance->save();
            if( $finance_save ){
                $finance_id=$Pdf_finance->id;
                if( !empty($finance_id) ){
                    $channel_ratio_id=Yii::app()->request->getParam('channel_ratio_id');
                    $channel_id=Yii::app()->request->getParam('channel_id');
                    $ratio_id=Yii::app()->request->getParam('ratio_id');
                    if( is_array($channel_ratio_id) ){
                        $transaction_result=true;
                        foreach($channel_ratio_id as $key=>$val){
                            if( !empty($val) ){
                                $Pdf_finance_channel=Pdf_finance_channel::model()->findByPk( (int)$val );
                            }else{
                                $Pdf_finance_channel = new Pdf_finance_channel;
                                $Pdf_finance_channel->finance_id = $finance_id;
                            }
                            $Pdf_finance_channel->channel_id = (int)$channel_id[$key];
                            $Pdf_finance_channel->ratio_id = (int)$ratio_id[$key];
                            $finance_channel_save=$Pdf_finance_channel->save();
                            if(!$finance_channel_save){
                                if($Pdf_finance_channel->hasErrors()){
                                    $message=$Pdf_finance_channel->getErrors();
                                }
                                $transaction_result=false;
                                break;
                            }
                        }
                    }else{
                        $message=array( 'channel_ratio'=>array('必须添加支付渠道费率!') );
                    }
                }
            }else{
                if( $Pdf_finance->hasErrors() ){
                    $message=$Pdf_finance->getErrors();
                }else{
                    $message='操纵失败';
                }
            }
        }catch( Exception $e ){
            $transaction_result=false;
        }
        if(!$transaction_result ){
            $transaction->rollBack();
        }else{
            $transaction->commit();
        }
        //事务处理结束
        if($finance_save && $finance_channel_save) $reArr=array("callbackType"=>"forward","statusCode"=>"200","message"=>$message);
        else{
            $message_str='';
            foreach($message as $val) $message_str.=$val[0];
            $reArr=array("statusCode"=>"300","message"=>$message_str);
        }
        echo json_encode($reArr);
	}
    
    /*支付渠道和费率ajax删除
     *如果数据库存在数据则删除数据,并用js删掉行
     *如果不存在,直接js删掉行
     */
	public function actionChannelRatioDel(){
        $cr_id = !empty($_GET['cr_id']) ? (int)$_GET['cr_id'] : 0;
        $del_row=1;
        if( !empty($cr_id) ){
            $del_row=Pdf_finance_channel::model()->deleteByPk($cr_id);
        }
        if( $del_row===1 ) $reArr=array("statusCode"=>"200","message"=>"操作成功");
        else $reArr=array("statusCode"=>"-100","message"=>"操作失败");
        echo json_encode($reArr);
	}
    /*@$_GET['type_id'],费率形式,1表示固定,2表示阶梯
     *根据$_GET['type_id']回传不同的费率数组
     */
    public function actionAjaxGetIncomeProportionByType(){
        $type_id = (int)$_GET['type_id'];
        $array=Pdf_proportion::getProportionList($type_id);
        $reArr[]=array(0,"请选择费率");
        if( isset(Pdf_proportion::$proportion_type[$type_id]) ){
            foreach($array as $key=>$val){
                $reArr[]=array($key,$val);
            }
        }
        echo json_encode($reArr);
    }

    public function actionStatementCreate(){
        $finance_id = (int)$_REQUEST['finance_id'];
        $select_begin_time = Yii::app()->request->getParam('select_begin_time');
        $select_end_time   = Yii::app()->request->getParam('select_end_time');
        $other_amount      = (int)Yii::app()->request->getParam('other_amount');
        /*暂时不考虑坏账
        $bad_debt_a        = Yii::app()->request->getParam('bad_debt_a');
        $bad_debt_b        = Yii::app()->request->getParam('bad_debt_b');
        */
        $view['data']      = $this->getStatementData($finance_id,$select_begin_time,$select_end_time,$other_amount);
        $this->display('statementCreate',$view);
    }
    

    public function getStatementData($finance_id,$select_begin_time,$select_end_time,$other_amount=0,$bad_debt_a=0,$bad_debt_b=0){
        /*$finance_id = (int)$_REQUEST['finance_id'];
        $select_begin_time = Yii::app()->request->getParam('select_begin_time');
        $select_end_time   = Yii::app()->request->getParam('select_end_time');
        $bad_debt_amount   = Yii::app()->request->getParam('bad_debt_amount');*/
        $data = '';
        $data['finance_id'] = $finance_id;
        $data['select_begin_time'] = $select_begin_time;
        $data['select_end_time']   = $select_end_time;
        $data['bad_debt_a']        = $bad_debt_a;
        $data['bad_debt_b']        = $bad_debt_b;
        $data['other_amount']      = $other_amount;
        //查询财务信息
        $finance_obj = Pdf_finance::model()->findByPk($finance_id);
        $data['channel_name'] = $finance_obj->channel_name;//渠道,公司
        $game_name_list = PataBomProject::funGetGameList();
        $data['game_name'] = $game_name_list[$finance_obj->game_id];//游戏名字

        //查询支付渠道及费率
        $sql="select a.id,a.finance_id,a.channel_id,a.ratio_id,b.type,b.ratio from pdf_finance_channel as a join pdf_ratio as b on(a.ratio_id = b.id) where a.finance_id ='$finance_id'";
        $channel_ratio_array=Yii::app()->db_data_finance->createCommand($sql)->queryAll();
        foreach($channel_ratio_array as $key=>$val){
            $channel_ratio[$val['channel_id']]['type'] = $val['type'];
            $channel_ratio[$val['channel_id']]['ratio'] = $val['ratio'];
        }
        //var_dump($channel_ratio);die();
        //查询充值记录
        $cdb = new CDbCriteria();
        $cdb->condition = "finance_id ='$finance_id' and begin_time>=:begin_time and end_time<=:end_time order by id desc";
        $cdb->params=array(':begin_time'=>$select_begin_time,':end_time'=>$select_end_time);
        $pdf_pay_recode = new Pdf_pay_recode;
        $pay_objs = $pdf_pay_recode->findAll($cdb);
        
        //var_dump($pay_objs);var_dump($cdb->condition);die();
        $data['pay_amount_sum']     = 0;//充值总金额
        $data['channel_amount_sum'] = 0;//支付渠道总费用
        $data['pay_amount']         = array();
        $data['begin_time']         = array();
        $data['end_time']           = array();
        $data['pay_channel']        = array();
		$data['invoice_amount']     =array();

		//发票费用计算
        $data['invoice_type']  = Pdf_finance::$invoice_type_list[$finance_obj->invoice_type];
        $invoice_ratio = Pdf_ratio::getRatioById($finance_obj->invoice_ratio);
        $data['invoice_ratio'] = $invoice_ratio['ratio'];
		$data['invoice_amount_sum'] =0;
        if( !empty($pay_objs) ){
			$channel_list = Pdf_channel::getChannelList();
            foreach($pay_objs as $key=>$pay_obj){
                //充值金额
                $data['pay_amount'][$key] = $pay_obj->amount;
                //结算时间
                $data['begin_time'][$key]  = $pay_obj->begin_time;
                $data['end_time'][$key]    = $pay_obj->end_time;
                //支付渠道及费用计算
                $data['pay_channel'][$key]['channel']           = $channel_list[$pay_obj->channel_id];
                $data['pay_channel'][$key]['type']              = $channel_ratio[$pay_obj->channel_id]['type'];
                $data['pay_channel'][$key]['ratio']             = $channel_ratio[$pay_obj->channel_id]['ratio'];
                $data['pay_channel'][$key]['cal_detail']        = $this->ratioCalAmount($data['pay_channel'][$key]['ratio'],$pay_obj->amount);
                $data['pay_channel'][$key]['channel_amount']    = $data['pay_channel'][$key]['cal_detail']['sum'];
                $data['channel_amount_sum']  +=$data['pay_channel'][$key]['channel_amount'];
                $data['pay_amount_sum']      +=$data['pay_amount'][$key];

				//发票费用计算
				$data['invoice_amount'][$key] = $this->proAndRatioToVal($data['invoice_ratio'])*$data['pay_amount'][$key];
				$data['invoice_amount_sum']  += $data['invoice_amount'][$key];

				//收入分配金额计算
				if($data['other_amount']) continue;
				else{
					$data['income'][$key]= $data['pay_amount'][$key] - $data['pay_channel'][$key]['channel_amount'] - $data['invoice_amount'][$key];
				}
            }
        }
        //坏账计算----暂时不考虑

        //其它费用计算

        //收入分配总金额计算
        $data['income_sum']   = $data['pay_amount_sum'] - $data['channel_amount_sum'] - $data['invoice_amount_sum']-$data['other_amount'];
        //$data['income_cal_method']  = Pdf_finance::$income_method[$finance_obj->income_cal_method];
        $proportion_array     = str_replace('<br />',PHP_EOL,Pdf_proportion::getProportionById($finance_obj->income_ratio_id) );
        $data['income_ratio'] = $proportion_array['proportion'];
        $data['income_type'] = $proportion_array['type'];
		
		//收入分成是固定,则计算各渠道分成
		if($data['income_type'] == 1 && !$data['other_amount'] && !empty($data['income'])){
			foreach($data['income'] as $key=>$val){
				$data['income_a'][$key] = $this->proAndRatioToVal($data['income_ratio'])*$val;
				$data['income_b'][$key] = $val-$data['income_a'][$key];
			}
		}
		//var_dump($data['income']);var_dump($data['income_a']);var_dump($data['invoice_ratio']);die();
        $data['income_cal_detail'] = $this->ratioCalAmount($data['income_ratio'],$data['income_sum']);
		//var_dump($data['income_cal_detail']);die();
        $data['income_sum_a']      = $data['income_cal_detail']['sum'];
        $data['income_sum_b'] = $data['income_sum'] - $data['income_sum_a'];
        return $data;
    }


    /*@$ratio阶梯费率    格式例子为'<10000,(8%|8:92);
                                    10000-50000,(5%|5:95),
                                    >50000,1%'
     *阶梯费率转换成数组形式
     *返回数组格式例子为:  array(0=>array('native_range'=>'x<=10000',
                                          'native_ratio'=>'8%',
                                          'do_range'    =>10000,
                                          'do_ratio'    =>0.08,),
                                 1=>array('native_range'=>'10000<x<=50000',
                                          'native_ratio'=>'5%',
                                          'do_range'    =>50000,
                                          'do_ratio'    =>0.05,),
                                 'max'=>array('native_range'=>'x>50000',
                                          'native_ratio'=>'1%',
                                          'do_range'    =>50000,
                                          'do_ratio'    =>0.01,),
                                 )
     */
    public function stepToArray($ratio){
        $ratio_array=explode(';',trim($ratio," \t\n\r\0\x0B;"));
        $count=count($ratio_array);
        $next_valid='';
        $reArr=false;
        foreach($ratio_array as $key=>$val){
            if($key===0){
                preg_match('/^\<([\d]+),([\d]+(?:\.[\d]+)?%|[\d]+(?:\.[\d]+)?:[\d]+(?:\.[\d]+)?)$/',$val,$result);
                if( empty($result) ) return false;
                else{
                    $reArr[$key]['native_range']  ='x<='.$result[1];
                    $reArr[$key]['native_ratio']  =$result[2];
                    $reArr[$key]['do_range']      =$result[1];
                    $reArr[$key]['do_ratio']      =$this->proAndRatioToVal($result[2]);
                    $next_valid=$result[1];
                }
            }else if( $key!==($count-1) ){
                preg_match('/^'.$next_valid.'-([\d]+),([\d]+(?:\.[\d]+)?%|[\d]+(?:\.[\d]+)?:[\d]+(?:\.[\d]+)?)$/',trim($val),$result);
                if( empty($result) || $result[1]<=$next_valid ) return false;
                else{
                    $reArr[$key]['native_range']  =$next_valid.'<x<='.$result[1];
                    $reArr[$key]['native_ratio']  =$result[2];
                    $reArr[$key]['do_range']      =$result[1];
                    $reArr[$key]['do_ratio']      =$this->proAndRatioToVal($result[2]);
                    $next_valid=$result[1];
                }
            }else{
                preg_match('/^\>'.$next_valid.',([\d]+(?:\.[\d]+)?%|[\d]+(?:\.[\d]+)?:[\d]+(?:\.[\d]+)?)$/',trim($val),$result);
                if( empty($result) ) return false;
                else{
                    $reArr['max']['native_range']  ='x>'.$next_valid;
                    $reArr['max']['native_ratio']  =$result[1];
                    $reArr['max']['do_range']      =$next_valid;
                    $reArr['max']['do_ratio']      =$this->proAndRatioToVal($result[1]);
                }
            }
        }
        return $reArr;
    }
    //百分比,比例转成值
    public function proAndRatioToVal($ratio){
        if(preg_match('/^([\d]+(?:\.[\d]+)?)%$/',$ratio,$result)){
            $val = $result[1]/100;
        }else if(preg_match('/^([\d]+(?:\.[\d]+)?):([\d]+(?:\.[\d]+)?)$/',$ratio,$result)){
            $val = $result[1]/($result[1]+$result[2]);
        }else{
            $val = false;
        }
        return $val;
    }
    
    /*计算总金额
     *@ratio_array 费率
     *@amount 金额
     *正常返回计算结果,如参数错误返回false;
     */
    public function ratioCalAmount($ratio,$amount){
        $ratio = str_replace('<br />','',$ratio);
        if( preg_match('/^([\d]+(?:\.[\d]+)?%|[\d]+(?:\.[\d]+)?:[\d]+(?:\.[\d]+)?)$/',$ratio,$result) ){
            //匹配固定
            return array(
                        'type'=>1,
                        'step'=>'',
                        'sum'=>$this->proAndRatioToVal($result[1])*$amount
                    );
        }else{
            $reArr = array('type'=>2,
                           'step'=>'',
                           'sum'=>0,
                          );
            $ratio_array = $this->stepToArray($ratio);
            if($ratio_array){
                $pre_amount=0;
                foreach($ratio_array as $key=>$val){
                    if( $key==='max' || $amount<=$val['do_range']){
                        $reArr['step'][$key]=array( 'cal_amount'  =>($amount-$pre_amount),
                                                'native_range'=>$val['native_range'],
                                                'native_ratio'=>$val['native_ratio'],
                                                'cal_result'  =>$val['do_ratio']*($amount-$pre_amount)
                                               );
                        $reArr['sum']=$count+$reArr['step'][$key]['cal_result'];
                        return $reArr;
                    }else{
                        $reArr['step'][$key]=array( 'cal_amount'  =>($val['do_range']-$pre_amount),
                                                'native_range'=>$val['native_range'],
                                                'native_ratio'=>$val['native_ratio'],
                                                'cal_result'  =>$val['do_ratio']*($val['do_range']-$pre_amount)
                                               );
                        $count+=$reArr['step'][$key]['cal_result'];
                    }
                    $pre_amount=$val['do_range'];
                }
            }
            return false;
        }
    }

    //添加编辑充值记录
    public function actionAddEditPay(){
        $finance_id = (int)$_GET['finance_id'];
        $pay_recode_id = (int)$_GET['id'];
        if($finance_id || $pay_recode_id){
            if($pay_recode_id){
                $obj=Pdf_pay_recode::model()->findByPk($pay_recode_id);
                $data['obj'] = $obj;
                $finance_id = $obj->finance_id;
            }
             //获取渠道列表
            $channel = Pdf_finance_channel::getChannelIdByFinanceId($finance_id);
            $channel_list = Pdf_channel::getChannelList();
            $data['channel']=array();
            if( !empty($channel) ){
                foreach($channel as $key=>$val){
                    $data['channel'][$key]['id'] = $val;
                    $data['channel'][$key]['name'] = $channel_list[$val];
                }
            }
            $data['finance_id'] = $finance_id;
            $this->display('addEditPay',$data);
        }
    }

    //保存充值记录
    public function actionSavePay(){
        if( !empty($_REQUEST['pay_recode_id']) && $pay_recode_id=intval( Yii::app()->request->getParam('pay_recode_id') ) ){
            $pdf_pay_recode=Pdf_pay_recode::model()->findByPk($pay_recode_id);
        }else{
            $pdf_pay_recode=new Pdf_pay_recode;
        }
        $pdf_pay_recode->finance_id = intval( Yii::app()->request->getParam('finance_id') );
        $pdf_pay_recode->channel_id = intval( Yii::app()->request->getParam('channel_id') );
        $pdf_pay_recode->begin_time = Yii::app()->request->getParam('begin_time');
        $pdf_pay_recode->end_time = Yii::app()->request->getParam('end_time');
        $pdf_pay_recode->amount = intval( Yii::app()->request->getParam('amount') );
        $pay_save = $pdf_pay_recode->save();
        if($pay_save){
            $reArr=array("callbackType"=>"forward","statusCode"=>"200","message"=>'保存成功');
        }else{
            if($pdf_pay_recode->hasErrors()){
                $message=$pdf_pay_recode->getErrors();
            }
            $message_str='';
            foreach($message as $val) $message_str.=$val[0];
            $reArr=array("statusCode"=>"300","message"=>$message_str);
        }
        echo json_encode($reArr);
    }
    
    //显示充值记录
    public function actionShowPayList(){
        $finance_id = (int)$_GET['finance_id'];
        if($finance_id){
            $cdb = new CDbCriteria();
            $pdf_pay_recode = Pdf_pay_recode::model();
            $cdb->condition = "finance_id ='$finance_id' order by id desc";
            $count = $pdf_pay_recode->count($cdb);
            $pages = new CPagination($count);
            $pages->currentPage = $page;
            $pages->pageSize = self::PAGE_SIZE;
            $pages->applyLimit($cdb);
            $all = $pdf_pay_recode->findAll($cdb);
            $data['pages'] = $pages;
            $data['all'] = $all;
            $this->display('showPayList',$data);
        }
    }

    //删除充值记录
    public function actionDelPay(){
        $ids = Yii::app()->request->getParam('ids');
        $id_array=explode(',',$ids);
        $pay_del_count=Pdf_pay_recode::model()->deleteByPk($id_array);
        if($pay_del_count){
            $reArr=array("statusCode"=>"200","message"=>"操作成功");
        }else{
            $reArr=array("statusCode"=>"-100","message"=>"删除失败,请重新选择需要删除的数据!");
        }
        echo json_encode($reArr);
    }


    /*输出excel
     *PHPExcel用法
     *设置当前的sheet  $objPHPExcel->setActiveSheetIndex(0);
     *设置sheet的name  $objPHPExcel->getActiveSheet()->setTitle('Simple');
     *设置单元格的值   $objPHPExcel->getActiveSheet()->setCellValue('A1', 'String');
     *                 $objPHPExcel->getActiveSheet()->setCellValue('C5', '=SUM(C2:C4)');
     *合并单元格       $objPHPExcel->getActiveSheet()->mergeCells('A18:E22');
     *分离单元格       $objPHPExcel->getActiveSheet()->unmergeCells('A28:B28');
     *设置垂直居中     $objPHPExcel->getActiveSheet()->getStyle('A18')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
     */
    public function actionCreateExcel(){
        include ROOT . '/yiiframework/extentions/com/modules/PHPExcel/PHPExcel.php';
        $ratio_type = array(1=>'固定',2=>'阶梯');

        $finance_id = (int)$_REQUEST['finance_id'];

        $select_begin_time = Yii::app()->request->getParam('select_begin_time');
        $select_end_time   = Yii::app()->request->getParam('select_end_time');
        /*暂时不考虑坏账问题;
        $bad_debt_a        = (int)Yii::app()->request->getParam('bad_debt_a');
        $bad_debt_b        = (int)Yii::app()->request->getParam('bad_debt_b');
        */
        $other_amount      = (int)Yii::app()->request->getParam('other_amount');
        $data = $this->getStatementData($finance_id,$select_begin_time,$select_end_time,$other_amount);
        //var_dump($data);die();
        $other_amount=1;
        //生成excel之前先保存数据
        //var_dump($_GET);var_dump($other_amount);var_dump($pdf_other_amount->other_amount);die();
        $model = new Pdf_other_amount;
        
        $model->finance_id   = $finance_id;
        $model->begin_time   = $select_begin_time;
        $model->end_time     = $select_end_time;
        $model->bad_debt_a   = $bad_debt_a;
        $model->bad_debt_b   = $bad_debt_b;
        $model->other_amount = $other_amount;

         //var_dump($model->bad_debt_a);die();
        $model->save();
        //excel 
        $php_excel = new PHPExcel;
        $php_excel->getProperties()->setCreator("fan.you") 
                                    ->setTitle("财务报表") 
                                    ->setSubject("统计报表") 
                                    ->setDescription("统计报表");
        //设置标题及导出时间
        $php_excel->setActiveSheetIndex(0);
        $php_excel->getActiveSheet()->setCellValue('A1','财务报表')
                                    ->setCellValue('A2','导出日期:('.date('Y-m-d').')')
                                    ->mergeCells('A1:L1')
                                    ->mergeCells('A2:L2');
        $php_excel->getActiveSheet()->getStyle('A1')->getFont()->setName('黑体');
        $php_excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(20);
        $php_excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        $php_excel->getActiveSheet()->getStyle('A2')->getFont()->setName('宋体');
        $php_excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(16);
        $php_excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);//水平居中
        $php_excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);//水平居中
        //如果收入分成为固定格式,则max_
        if($data['income_type']==1){
            $max_col = 'Q';
        }else{
            $max_col = 'Q';
        }
        //垂直居中
        $php_excel->getActiveSheet()->getStyle('A:'.$max_col)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        //水平居中
        $php_excel->getActiveSheet()->getStyle('A:'.$max_col)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        //自动换行
        $php_excel->getActiveSheet()->getStyle('A:'.$max_col)->getAlignment()->setWrapText(true);
        //设置单元格宽度
        $php_excel->getActiveSheet()->getColumnDimension('A')->setWidth(24);
        $php_excel->getActiveSheet()->getColumnDimension('B')->setWidth(24);
        $php_excel->getActiveSheet()->getColumnDimension('C')->setWidth(24);
        $php_excel->getActiveSheet()->getColumnDimension('D')->setWidth(10);
        $php_excel->getActiveSheet()->getColumnDimension('E')->setWidth(24);
        $php_excel->getActiveSheet()->getColumnDimension('F')->setWidth(24);
        for($i=ord('G');$i<=ord($max_col);$i++){
            $php_excel->getActiveSheet()->getColumnDimension(chr($i))->setWidth(10);
        }
        //补充***************************
        $php_excel->getActiveSheet()->getColumnDimension('N')->setWidth(24);
        //************************
        
        //设置表头
        $php_excel->setActiveSheetIndex(0)->setCellValue('A3','实际结算周期')
                                          ->setCellValue('B3','公司名')
                                          ->setCellValue('C3','游戏名称')
                                          ->setCellValue('D3','充值金额')
                                          ->setCellValue('E3','支付渠道')
                                          ->setCellValue('F3','支付渠道费率')
                                          ->setCellValue('G3','支付渠道费')
                                          ->setCellValue('H3','其它金额')
                                          ->setCellValue('I3','增值税发票类型')
                                          ->setCellValue('J3','增值税发票费率')
                                          ->setCellValue('K3','增值税发票费')
                                          ->setCellValue('L3','分配金额')
                                          ->setCellValue('M3','分配方式')
                                          ->setCellValue('N3','甲方分成比例')
                                          ->setCellValue('O3','甲方结算金额')
                                          ->setCellValue('P3','乙方结算金额')
                                          ->setCellValue('Q3','备注');
        $php_excel->getActiveSheet()->getStyle('A3:Q3')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
        $php_excel->getActiveSheet()->getStyle('A3:Q3')->getFill()->getStartColor()->setRGB('CCCCEE');
        $php_excel->getActiveSheet()->setCellValue('B4',$data['channel_name'])
                                    ->setCellValue('C4',$data['game_name'])
                                    ->setCellValue('H4',$data['other_amount'])
                                    ->setCellValue('I4',$data['invoice_type'])
                                    ->setCellValue('J4',$data['invoice_ratio']);
        foreach($data['begin_time'] as $key=>$val){
            $pos_index = 4+$key;
            $php_excel->getActiveSheet()->setCellValue('A'.$pos_index,$val.'至'.$data['end_time'][$key])
                                        ->setCellValue('D'.$pos_index,$data['pay_amount'][$key])
                                        ->setCellValue('E'.$pos_index,$data['pay_channel'][$key]['channel'])
                                        ->setCellValue('F'.$pos_index,$data['pay_channel'][$key]['ratio'])
                                        ->setCellValue('G'.$pos_index,$data['pay_channel'][$key]['channel_amount'])
										->setCellValue('K'.$pos_index,$data['invoice_amount'][$key]);
        }
		//合并单元格
        $count = count($data['begin_time']);
        if($count>1){
            $begin_index = 4;
            $end_index   = 4+$count-1;
            $php_excel->getActiveSheet()->mergeCells('B'.$begin_index.':'.'B'.$end_index)
                                        ->mergeCells('C'.$begin_index.':'.'C'.$end_index)
                                        ->mergeCells('H'.$begin_index.':'.'H'.$end_index)
                                        ->mergeCells('I'.$begin_index.':'.'I'.$end_index)
                                        ->mergeCells('J'.$begin_index.':'.'J'.$end_index);
        }
        $php_excel->getActiveSheet()->setTitle('财务报表');

        //如果是固定分配
        if($data['income_type']==1 && !$data['other_amount']){
			foreach($data['income'] as $key=>$val){
				$pos_index = 4+$key;
				$php_excel->getActiveSheet()->setCellValue('L'.$pos_index,$val)
											->setCellValue('O'.$pos_index,$data['income_a'][$key])
											->setCellValue('P'.$pos_index,$data['income_b'][$key]);

			}
			$php_excel->getActiveSheet()->setCellValue('M4',$ratio_type[$data['income_type']])
										->setCellValue('N4',$data['income_ratio'])
										->setCellValue('Q4','乙方为sdk提供方');
			//合并单元格
			if($count>1){
				$php_excel->getActiveSheet()->mergeCells('M'.$begin_index.':'.'M'.$end_index)
											->mergeCells('N'.$begin_index.':'.'N'.$end_index)
											->mergeCells('Q'.$begin_index.':'.'Q'.$end_index);
			}

			//合计
			$php_excel->getActiveSheet()->setCellValue('A'.($count+5),'合计');
			$php_excel->getActiveSheet()->setCellValue('O'.($count+5),$data['income_sum_a']);
			$php_excel->getActiveSheet()->setCellValue('P'.($count+5),$data['income_sum_b']);
			$php_excel->getActiveSheet()->mergeCells('B'.($count+5).':N'.($count+5) );
        }else{
			$php_excel->getActiveSheet()->setCellValue('L4',$data['income_sum'])
										->setCellValue('M4',$ratio_type[$data['income_type']])
										->setCellValue('N4',$data['income_ratio'])
										->setCellValue('O4',$data['income_sum_a'])
										->setCellValue('P4',$data['income_sum_b'])
										->setCellValue('Q4','乙方为sdk提供方');
			if($count>1){
				$php_excel->getActiveSheet()->mergeCells('L'.$begin_index.':'.'L'.$end_index)
											->mergeCells('M'.$begin_index.':'.'M'.$end_index)
											->mergeCells('N'.$begin_index.':'.'N'.$end_index)
											->mergeCells('O'.$begin_index.':'.'O'.$end_index)
											->mergeCells('P'.$begin_index.':'.'P'.$end_index)
											->mergeCells('Q'.$begin_index.':'.'Q'.$end_index);
			}
		}

		//如果是阶梯分配
		if($data['income_type']==2){
			//阶梯表
			$begin_step_row = $count+6;
			//表头
			$php_excel->getActiveSheet()->setCellValue('A'.$begin_step_row,'总分配收入')
										->setCellValue('B'.$begin_step_row,'公司名')
										->setCellValue('C'.$begin_step_row,'游戏名称')
										->setCellValue('D'.$begin_step_row,'可阶梯金额')
										->setCellValue('E'.$begin_step_row,'阶梯金额说明')
										->setCellValue('F'.$begin_step_row,'分成比例')
										->setCellValue('G'.$begin_step_row,'甲方结算金额')
										->setCellValue('H'.$begin_step_row,'乙方结算金额')
										->setCellValue('A'.($begin_step_row+1),$data['income_sum'])
										->setCellValue('B'.($begin_step_row+1),$data['channel_name'])
										->setCellValue('C'.($begin_step_row+1),$data['game_name']);
            $php_excel->getActiveSheet()->getStyle('A'.$begin_step_row.':H'.$begin_step_row)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
            $php_excel->getActiveSheet()->getStyle('A'.$begin_step_row.':H'.$begin_step_row)->getFill()->getStartColor()->setRGB('CCCCEE');
			$pre_key=0;
			foreach($data['income_cal_detail']['step'] as $key=>$val){
				if('max'===$key){
					$key=$pre_key+1;
				}
				else
					$pre_key = $key;
				$php_excel->getActiveSheet()->setCellValue('D'.($begin_step_row+$key+1),$val['cal_amount'])
											->setCellValue('E'.($begin_step_row+$key+1),$val['native_range'])
											->setCellValue('F'.($begin_step_row+$key+1),$val['native_ratio'])
											->setCellValue('G'.($begin_step_row+$key+1),$val['cal_result'])
											->setCellValue('H'.($begin_step_row+$key+1),($val['cal_amount']-$val['cal_result']));
			}
			//合并
			$php_excel->getActiveSheet()->mergeCells('A'.($begin_step_row+1).':'.'A'.($begin_step_row+$key+1))
										->mergeCells('B'.($begin_step_row+1).':'.'B'.($begin_step_row+$key+1))
										->mergeCells('C'.($begin_step_row+1).':'.'C'.($begin_step_row+$key+1))
                                        ->mergeCells('B'.($begin_step_row+$key+2).':'.'F'.($begin_step_row+$key+2));
			$php_excel->getActiveSheet()->setCellValue('A'.($begin_step_row+$key+2),'合计')
										->setCellValue('G'.($begin_step_row+$key+2),$data['income_sum_a'])
										->setCellValue('H'.($begin_step_row+$key+2),$data['income_sum_b']);

		}
        
        // Excel打开后显示的工作表
        //通浏览器输出Excel报表

        header('Content-Type:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="statement.xlsx"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($php_excel,'Excel2007');
        //备份
        $save_dir = "./statement/".date('Ym')."/";
        if(!file_exists($save_dir)){
            mkdir($save_dir,0777,true);
        }
        $objWriter->save($save_dir.date('YmdHis').iconv('UTF-8','GB18030',$data['game_name']).'.xlsx');
        $objWriter->save('php://output');
        Yii::app()->end();
    }
}