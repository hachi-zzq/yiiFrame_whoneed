<style>
    .searchBar label{
        float: none;
    }
    .tb_span{
        display: block;
        line-height: 21px;
    }
</style>

<form id="pagerForm" method="post" action="<?php echo Yii::app()->request->requestUri?>">
    <input type="hidden" name="pageNum" value="1" />
    <input type="hidden" name="numPerPage" value="<?php echo $pages->pageSize?>" />
    <input type="hidden" name="orderField" value="${param.orderField}" />
    <input type="hidden" name="orderDirection" value="${param.orderDirection}" />
    <?php
    if($arrCondition){
        foreach($arrCondition as $key=>$condition){
            echo '<input type="hidden" name="'.$key.'" value="'.$condition.'" />';
        }
    }
    ?>
</form>

<div class="pageHeader">
    <form rel="pagerForm" onsubmit="return navTabSearch(this);" action="/admin/Channel_statistic/time_search" method="post">
        <div class="searchBar" style="padding-top: 10px;">
            <label>渠道归属：</label>
            <select  name="channel_from">
                <option value="0">全部</option>
                <option value="1"<?php if($channel_from=='1') echo 'selected="selected"'?>>广告</option>
                <option value="2" <?php if($channel_from=='2') echo 'selected="selected"'?>>合作渠道</option>
            </select>
            　　　
            <label>渠道类型：</label>
            <select  name="channel_type">
                <option value="0">全部</option>
                <option value="CPA" <?php if($channel_type=='CPA') echo 'selected="selected"'?>>CPA</option>
                <option value="CPC" <?php if($channel_type=='CPC') echo 'selected="selected"'?>>CPC</option>
                <option value="CPT" <?php if($channel_type=='CPT') echo 'selected="selected"'?>>CPT</option>
                <option value="CPL" <?php if($channel_type=='CPL') echo 'selected="selected"'?>>CPL</option>
                <option value="CPM" <?php if($channel_type=='CPM') echo 'selected="selected"'?>>CPM</option>
                <option value="CPS" <?php if($channel_type=='CPS') echo 'selected="selected"'?>>CPS</option>
            </select>

<!--            　　　-->
<!--            <label>游戏选择：</label>-->
<!--            <input  name="app_district.app_name" type="text" onclick="$('#app_look_up').click()" readonly="readonly" value="全部"/>-->
<!--            <input  name="app_district.app_id" type="hidden" readonly="readonly" value=""/>-->
<!--            <a style="display: none" class="btnLook" id="app_look_up" href="/admin/Channel_statistic/appLookBack" lookupGroup="app_district">查找带回</a>-->
            <label style="margin-left: 30px;">游戏选择：</label>
            <select  name="app_id">
                <option value="0">全部</option>
                <?php
                    $objApp = Pdcc_product::model()->findAll();
                    if($objApp){
                        foreach($objApp as $app){
                ?>
                    <option value="<?php echo $app['appid']?>" <?php if($app_id == $app['appid']) echo 'selected'?>><?php echo $app['appname']?></option>

                <?php
                        }
                    }
                ?>
            </select>

        </div>
        <div class="searchBar" style="padding-top: 10px;">
            <label>时间检索：</label>
            开始时间：
            <input type="text" size="25" name="time_start" class="date" value="<?php echo $time?$time['start_time']:''?>"/>
            　　　
            结束时间：
            <input type="text" size="25" name="time_end" class="date"  value="<?php echo $time?$time['end_time']:''?>"/>

        </div>

        <div class="searchBar" style="padding-top: 10px;">
            <label>充值检索：</label>
            开始时间：
            <input type="text" size="25" name="pay_start_time" class="date" dateFmt="yyyy-MM-dd HH:mm:ss" value="<?php echo $pay_time?$pay_time['pay_start_time']:date('Y-m-d')?>" />
            　　　
            结束时间：
            <input type="text" size="25" name="pay_end_time" class="date" dateFmt="yyyy-MM-dd HH:mm:ss" value="<?php echo $pay_time?$pay_time['pay_end_time']:date('Y-m-d')?>" />


            <div class="subBar">
                <ul>
                    <li><div class="buttonActive"><div class="buttonContent"><button type="submit">检索</button></div></div></li>
                    <!--                    <li><a class="button" href="demo_page6.html" target="dialog" mask="true" title="查询框"><span>高级检索</span></a></li>-->
                </ul>
            </div>
        </div>
        <input  type="hidden" name="type" value="<?php echo $type?>">
    </form>

</div>
<div class="pageContent">
    <!--<div class="panelBar">-->
    <!--    <ul class="toolBar">-->
    <!--        <li><a class="add" href="demo_page4.html" target="navTab"><span>添加</span></a></li>-->
    <!--        <li><a title="确实要删除这些记录吗?" target="selectedTodo" rel="ids" href="demo/common/ajaxDone.html" class="delete"><span>批量删除默认方式</span></a></li>-->
    <!--        <li><a title="确实要删除这些记录吗?" target="selectedTodo" rel="ids" postType="string" href="demo/common/ajaxDone.html" class="delete"><span>批量删除逗号分隔</span></a></li>-->
    <!--        <li><a class="edit" href="demo_page4.html?uid={sid_user}" target="navTab" warn="请选择一个用户"><span>修改</span></a></li>-->
    <!--        <li class="line">line</li>-->
    <!--        <li><a class="icon" href="demo/common/dwz-team.xls" target="dwzExport" targetType="navTab" title="实要导出这些记录吗?"><span>导出EXCEL</span></a></li>-->
    <!--    </ul>-->
    <!--</div>-->
    <table class="table" width="900" layoutH="138">
        <thead>
        <tr>
            <!--    <th width="22"><input type="checkbox" group="ids" class="checkboxCtrl"></th>-->
            <!--    <th width="120" orderField="accountNo" class="asc">id编号</th>-->
            <th width="60"><span class="tb_span"  >渠道编号</span></th>
            <th width="220" >渠道名称</th>
            <th width="110" ><span class="tb_span" title="某段时间内点击数">点击数</span></th>
            <?php if($type == 'inner'){?><th width="100"><span class="tb_span" title="某段时间内的激活数">激活数</span></th><?php } ?>
            <?php if($type == 'inner'){?><th width="120" ><span class="tb_span" title="某段时间内的渠道花费 / 该时间段内的激活数">激活成本</span></th><?php } ?>
            <th width="100" orderField="accountCert"><span class="tb_span" title="某段时间内的注册数">注册数</span></th>
            <?php if($type == 'inner'){?><th width="120" ><span class="tb_span" title="某段时间内的渠道花费 / 该时间段内的注册数">注册成本</th><?php } ?>
            <?php if($type == 'inner'){?><th width="150" ><span class="tb_span" title="注册数 / 激活数">注册转化率</span></th><?php } ?>
            <?php if($type == 'inner'){?><th width="120" ><span class="tb_span" title="某段时间内的渠道花费">广告花费</span></th><?php } ?>
            <th width="150" ><span class="tb_span" title="某段时间内的充值用户数量">充值用户数</span></th>
            <th width="120" ><span class="tb_span" title="某段时间内的充值金额">充值金额</span></th>
            <th width="100" ><span class="tb_span" title="某段时间内的充值金额 / 该段时间内的充值用户数">APUR</span></th>
            <?php if($type == 'inner'){?><th width="100" ><span class="tb_span" title="除去注册当天，第二天登陆的用户数">二登数</span></th><?php } ?>
            <?php if($type == 'inner'){?><th width="150" ><span class="tb_span" title="除去注册当天第三次登陆的用户数 / 注册数">三次登录率</span></th><?php } ?>
            <?php if($type == 'inner'){?><th width="150" ><span class="tb_span" title="除去注册当天第五次登陆的用户数 / 注册数">五次登录率</span></th><?php } ?>
            <?php if($type == 'inner'){?><th width="130" ><span class="tb_span" title="除去注册当天,一周内再次登陆的次数">周活跃数</span></th><?php } ?>
            <!--    <th width="100" orderField="accountCert">充值用户数</th>-->

            <!--    <th width="70">操作</th>-->
        </tr>
        </thead>
        <tbody>
        <?php
        if(isset($all_father) && !empty($all_father)){
            $reg_sum = 0;
            $click_num = 0;
            $pay_num = 0;
            $active_nums =0;
            $cost_nums = 0;
            $week_active_nums = 0;
            $login_twice_nums = 0;
            $login_third_nums = 0;
            $login_fifth_nums = 0;
            $pay_user_count = 0;
            $startTime = $time['start_time'];                                       //开始时间
            $endTime  = $time['end_time'];                                          //结束时间

//            echo $startTime.'<br/>'.$endTime.'<br/>'.$minDay.'<br/>'.$maxDay.'<br/>';
            foreach($all_father as $f){
                ?>

                <tr target="sid_user" rel="1">
                    <!--    <td><input name="ids" value="xxx" type="checkbox"></td>-->
                    <!--    <td>--><?php //echo $f['id']?><!--</td>-->
                    <td><?php echo $f['channel_id']?></td>                                                                      <!--渠道id-->
                    <td><?php echo $f['channel_name']?>                                                                         <!--渠道名称-->
                        <a target="navTab" href="/admin/Channel_statistic/channelDailyChild?fid=<?php echo $f['channel_id']?>&type=<?php echo $type?>&start_time=<?php echo $time['start_time']?>&end_time=<?php echo $time['end_time']?>&pay_start_time=<?php echo $pay_time?$pay_time['pay_start_time']:date('Y-m-d')?>&pay_end_time=<?php echo $pay_time?$pay_time['pay_end_time']:date('Y-m-d')?>" style="color: green">
                            <?php if($f['chlid_count'] != 0) echo '('.$f['chlid_count'].'个子渠道'.')'?></a>
                    </td>
                    <td><?php echo $f['click_nums']?></td>   <!--点击数-->
                    <?php if($type == 'inner')  echo '<td>'.$f['active_nums'].'</td> '?>  <!--激活数-->

                    <?php
                    /*
                     * channel_reg_active_cost start
                     * */
                      $channelCost = Pdc_channel_cost_slave::getTimeCost($startTime,$endTime,$f['channel_id']);
                      $regCost = $channelCost['reg_cost'];
                      $activeCost = $channelCost['active_cost'];
                       $regActiveNum = MyFunction::getTimeReg($startTime,$endTime,$f['channel_id']);
                       $regNum = $regActiveNum['reg_sum'];
                       $activeNum = $regActiveNum['new_run_nums'];
                        /*
                     * channel_reg_active_cost end
                     * */

                    //渠道花费
//                    $cost = $regCost*$f['reg_sum'];

                    $regActPer = $f['active_nums']==0?0:round($f['reg_sum']/$f['active_nums'],4);

                    $APUR = $f['pay_user_count']==0?0:round($f['amount']/$f['pay_user_count'],2);

                    $loginTwicePer = $f['reg_sum'] == 0?0:round($f['login_twice_nums']/$f['reg_sum'],4);
                    $loginThirdPer = $f['reg_sum'] == 0?0:round($f['login_third_nums']/$f['reg_sum'],4);
                    $loginFifthPer = $f['reg_sum'] == 0?0:round($f['login_fifth_nums']/$f['reg_sum'],4);
                    ?>

                    <?php if($type=='inner') echo '<td>',$activeNum==0?0:round($activeCost/$activeNum,2),'</td>'?>                                              <!--激活成本-->
                    <td><?php echo $f['reg_sum']?></td>                                                                                 <!--注册数-->
                    <?php if($type=='inner') echo '<td>',$regNum==0?0:round($regCost/$regNum,2),'</td>'?>                                                          <!--注册成本-->
                    <?php if($type=='inner') echo '<td>',$regActPer*100,'%</td>'?>                                                      <!--注册转化率-->
                    <?php if($type=='inner') echo '<td>',round($regCost,2),'</td>'?>                                                       <!--广告花费-->
                    <td><?php echo $f['pay_user_count']?$f['pay_user_count']:0?></td>                                                             <!--充值用户数-->
                    <td><?php echo $f['amount']?$f['amount']:0?></td>                                                                   <!--充值金额-->
                    <td><?php echo $APUR?></td>                                                                                         <!--APUR-->
                    <?php if($type=='inner') echo '<td>',$f['login_twice_nums'],'</td>'?>                                                    <!--二登数-->
                    <?php if($type=='inner') echo '<td>',$loginThirdPer*100,'%</td>'?>                                                  <!--第三次登录数-->
                    <?php if($type=='inner') echo '<td>',$loginFifthPer*100,'%</td>'?>                                                  <!--第五次登录数-->
                    <?php if($type=='inner') echo '<td>',$f['week_active_nums'],'</td>'?>                                               <!--周活跃数-->
                </tr>
                <?php
                $reg_sum +=$f['reg_sum'];
                $click_num += $f['click_nums'];
                $pay_num +=$f['amount'];
                $active_nums +=$f['active_nums'];
                $cost_nums +=$regCost;
                $week_active_nums +=$f['week_active_nums'];
                $login_twice_nums +=$f['login_twice_nums'];
                $login_third_nums +=$f['login_third_nums'];
                $login_fifth_nums +=$f['login_fifth_nums'];
                $pay_user_count   +=$f['pay_user_count'];
            }
        }
        ?>
        <tr>
            <?php
            //总注册转化率
            $sumRegPer = 0;
            $sumAPUR = 0;
            if($active_nums==0){
                $sumRegPer ='0%';
            }else{
                $sumRegPer = 100*round($reg_sum/$active_nums,4).'%';
            }

            if($pay_user_count == 0){
                $sumAPUR = '0%';
            }else{
                $sumAPUR  = round($pay_num/$pay_user_count,2);
            }

            $sumTwicePer = $reg_sum==0?0:100*round($login_twice_nums/$reg_sum,4).'%';
            $sumThirdPer = $reg_sum==0?0:100*round($login_third_nums/$reg_sum,4).'%';
            $sumFifthPer = $reg_sum==0?0:100*round($login_fifth_nums/$reg_sum,4).'%';

            ?>

            <td colspan="2"></td>
            <td>总计：<?php echo $click_num?></td>
            <?php if($type == 'inner') echo '<td>'.$active_nums.'</td>'?>
            <?php if($type == 'inner') echo'<td></td>'?>
            <td><?php echo $reg_sum?></td>
            <?php if($type == 'inner') echo'<td></td>'?>
            <?php if($type == 'inner') echo'<td>'.$sumRegPer.'</td>'?>
            <?php  if($type == 'inner') echo '<td>',round($cost_nums,2),'</td>'?>
            <td><?php echo $pay_user_count;?></td>
            <td><?php echo $pay_num?></td>
            <td><?php echo $sumAPUR?></td>
            <?php  if($type == 'inner') echo '<td>',$login_twice_nums,'</td>'?>
            <?php  if($type == 'inner') echo '<td>',$sumThirdPer,'</td>'?>
            <?php  if($type == 'inner') echo '<td>',$sumFifthPer,'</td>'?>
            <?php  if($type == 'inner') echo '<td>'.$week_active_nums.'</td>'?>
            <!--    <td>总计：--><?php //echo $pay_users?><!--</td>-->
        </tr>

        </tbody>
    </table>
    <div class="panelBar"  style="position: relative;top: -50px;">
        <div class="pages">
            <!--        <span>显示</span>-->
            <!--        <select class="combox" name="numPerPage" onchange="navTabPageBreak({numPerPage:this.value})">-->
            <!--            <option value="20">20</option>-->
            <!--            <option value="50">50</option>-->
            <!--            <option value="100">100</option>-->
            <!--            <option value="200">200</option>-->
            <!--        </select>-->
            <span>共<?php echo $pager->itemCount?>条</span>
        </div>

        <div class="pagination" targetType="navTab" totalCount="<?php echo $pager->itemCount?>" numPerPage="<?php echo $pager->pageSize ?>" pageNumShown="10" currentPage="<?php echo $pager->currentPage+1?>"></div>

    </div>
</div>
