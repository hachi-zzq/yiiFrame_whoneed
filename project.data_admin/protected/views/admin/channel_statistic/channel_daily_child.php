<form id="pagerForm" method="post" action="<?php echo Yii::app()->request->requestUri?>">
    <input type="hidden" name="pageNum" value="1" />
    <input type="hidden" name="numPerPage" value="${model.numPerPage}" />
    <input type="hidden" name="orderField" value="${param.orderField}" />
    <input type="hidden" name="orderDirection" value="${param.orderDirection}" />
    <?php
    if(isset($arrcondition)){
        foreach($arrcondition as $key=>$condition){
            echo "<input type='hidden' name='$key' value='$condition'>";
        }
    }
    ?>

</form>

<div class="pageHeader">
    <form rel="pagerForm" onsubmit="return navTabSearch(this);" action="w_removeSelected.html" method="post">
        <div class="searchBar">
            <!--            <ul class="searchContent">-->
            <!--                <li>-->
            <!--                    <label>我的客户：</label>-->
            <!--                    <input type="text" name="keywords" value=""/>-->
            <!--                </li>-->
            <!--                <li>-->
            <!--                    <select class="combox" name="province">-->
            <!--                        <option value="">所有省市</option>-->
            <!--                        <option value="北京">北京</option>-->
            <!--                        <option value="上海">上海</option>-->
            <!--                        <option value="天津">天津</option>-->
            <!--                        <option value="重庆">重庆</option>-->
            <!--                        <option value="广东">广东</option>-->
            <!--                    </select>-->
            <!--                </li>-->
            <!--            </ul>-->
            <!--
            <table class="searchContent">
                <tr>
                    <td>
                        我的客户：<input type="text"/>
                    </td>
                    <td>
                        <select class="combox" name="province">
                            <option value="">所有省市</option>
                            <option value="北京">北京</option>
                            <option value="上海">上海</option>
                            <option value="天津">天津</option>
                            <option value="重庆">重庆</option>
                            <option value="广东">广东</option>
                        </select>
                    </td>
                </tr>
            </table>
            -->
            <div class="subBar">
                <!--                <ul>-->
                <!--                    <li><div class="buttonActive"><div class="buttonContent"><button type="submit">检索</button></div></div></li>-->
                <!--                    <li><a class="button" href="demo_page6.html" target="dialog" mask="true" title="查询框"><span>高级检索</span></a></li>-->
                <!--                </ul>-->
            </div>
        </div>
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
            <th orderField="accountName" width="100">渠道编号</th>
            <th width="200" orderField="accountType">渠道名称</th>
            <th width="110" orderField="accountCert">点击数</th>
            <?php if($type == 'inner') {?><th width="100" orderField="accountCert">激活数</th><?php }?>
            <?php if($type == 'inner'){?><th width="100" orderField="accountCert">激活成本</th><?php } ?>
            <th width="100" orderField="accountCert">注册数</th>
            <?php if($type == 'inner'){?><th width="100" orderField="accountCert">注册成本</th><?php } ?>
            <?php if($type == 'inner'){?><th width="120" orderField="accountCert">注册转化率</th><?php } ?>
            <?php if($type == 'inner'){?><th width="100" orderField="accountCert">广告花费</th><?php } ?>
            <th width="120" orderField="accountCert">充值用户数</th>
            <th width="100" orderField="accountCert">充值金额</th>
            <th width="100" orderField="accountCert">APUR</th>
            <?php if($type == 'inner'){?><th width="100" orderField="accountCert">二登数</th><?php } ?>
            <?php if($type == 'inner'){?><th width="150" orderField="accountCert">三次登录率</th><?php } ?>
            <?php if($type == 'inner'){?><th width="150" orderField="accountCert">五次登录率</th><?php } ?>
            <?php if($type == 'inner'){?><th width="110" orderField="accountCert">周活跃数</th><?php } ?>

            <!--    <th width="100" orderField="accountCert">充值用户数</th>-->
            <!--    <th width="70">操作</th>-->
        </tr>
        </thead>
        <tbody>
        <?php
        if(isset($all_child) && !empty($all_child)){
            $all_count = 0;
            $click_nums = 0;
            $pay_amount = 0;
            $active_nums = 0;
            $cost_nums = 0;
            $pay_users_nums = 0;
            $week_active_nums = 0;
            $login_twice_nums = 0;
            $login_third_nums = 0;
            $login_fifth_nums = 0;
            foreach($all_child as $c){
                ?>

                <tr target="sid_user" rel="1">
                    <!--    <td><input name="ids" value="xxx" type="checkbox"></td>-->
                    <!--    <td>--><?php //echo $c['id']?><!--</td>-->
                    <td><?php echo $c['sub_id']?></td>
                    <td><?php echo $c['channel_name']?></td>
                    <td><?php echo $c['click_nums']?></td>
                    <?php if($type == 'inner')  echo '<td>'.$c['active_nums'].'</td> '?>

                    <?php
                    $arrCost = MyFunction::getTimeCost($time['start_time'],$time['end_time'],$c['channel_id']);
                    $regActPer = $c['active_nums']==0?0:round($c['reg_users']/$c['active_nums'],4);
                    $APUR = $c['pay_user_count']==0?0:round($c['pay_amount']/$c['pay_user_count'],2);
                    $loginTwicePer = $c['reg_users'] == 0?0:round($c['login_twice_nums']/$c['reg_users'],4);
                    $loginThirdPer = $c['reg_users'] == 0?0:round($c['login_third_nums']/$c['reg_users'],4);
                    $loginFifthPer = $c['reg_users'] == 0?0:round($c['login_fifth_nums']/$c['reg_users'],4);
                    ?>
                    <?php if($type=='inner') echo '<td>',$arrCost['active_cost_sum']?round($arrCost['active_cost_sum'],2):0,'</td>'?>
                    <td><?php echo $c['reg_users']?></td>
                    <?php if($type=='inner') echo '<td>',$arrCost['reg_cost_sum']?round($arrCost['reg_cost_sum'],2):0,'</td>'?>
                    <?php if($type=='inner') echo '<td>',$regActPer*100,'%</td>'?>
                    <?php if($type=='inner') echo '<td>',round($cost,2),'</td>'?>
                    <td><?php echo $c['pay_user_count']?$c['pay_user_count']:0?></td>
                    <td><?php echo $c['pay_amount']?$c['pay_amount']:0?></td>
                    <td><?php echo $APUR?></td>
                    <?php if($type=='inner') echo '<td>',$c['login_twice_nums'],'</td>'?>
                    <?php if($type=='inner') echo '<td>',$loginThirdPer*100,'%</td>'?>
                    <?php if($type=='inner') echo '<td>',$loginFifthPer*100,'%</td>'?>
                    <?php if($type=='inner') echo '<td>',$c['week_active'],'</td>'?>


                    <!--    <td>--><?php //echo $c['pay_users']?><!--</td>-->
                    <!--    <td>-->
                    <!--        <a title="删除" target="ajaxTodo" href="demo/common/ajaxDone.html?id=xxx" class="btnDel">删除</a>-->
                    <!--        <a title="编辑" target="navTab" href="demo_page4.html?id=xxx" class="btnEdit">编辑</a>-->
                    <!--    </td>-->
                </tr>
                <?php
                $all_count +=$c['reg_users'];
                $click_nums +=$c['click_nums'];
                $pay_amount +=$c['pay_amount'];
                $active_nums +=$c['active_nums'];
                $cost_nums +=$cost;
                $pay_users_nums +=$c['pay_user_count'];
                $week_active_nums +=$c['week_active'];
                $login_twice_nums +=$c['login_twice_nums'];
                $login_third_nums +=$c['login_third_nums'];
                $login_fifth_nums +=$c['login_fifth_nums'];

            }
        }
        ?>
        <tr>
            <?php
            //总注册转化率
            $sumRegPer = 0;
            if($active_nums==0){
                $sumRegPer ='0%';
            }else{
                $sumRegPer = 100*round($all_count/$active_nums,4).'%';
            }

            if($pay_users_nums == 0){
                $sumAPUR = '0';
            }else{
                $sumAPUR  = round($pay_amount/$pay_users_nums,2);
            }
            $sumThirdPer = $all_count==0?0:100*round($login_third_nums/$all_count,4).'%';
            $sumFifthPer = $all_count==0?0:100*round($login_fifth_nums/$all_count,4).'%';
            ?>
            <td colspan="2"></td>
            <td>总计：<?php echo $click_nums?></td>
            <?php if($type == 'inner') echo '<td>'.$active_nums.'</td>'?>
            <?php if($type == 'inner') echo'<td></td>'?>
            <td><?php echo $all_count?></td>
            <?php if($type == 'inner') echo'<td></td>'?>
            <?php if($type == 'inner') echo'<td>'.$sumRegPer.'</td>'?>
            <?php  if($type == 'inner') echo '<td>',round($cost_nums,2),'</td>'?>
            <td><?php echo $pay_users_nums?></td>
            <td><?php echo $pay_amount?></td>
            <td><?php echo $sumAPUR?></td>
            <?php  if($type == 'inner') echo '<td>',$login_twice_nums,'</td>'?>
            <?php  if($type == 'inner') echo '<td>',$sumThirdPer,'</td>'?>
            <?php  if($type == 'inner') echo '<td>',$sumFifthPer,'</td>'?>
            <?php  if($type == 'inner') echo '<td>'.$week_active_nums.'</td>'?>

            <!--    <td>总计：--><?php //echo $pay_users?><!--</td>-->
        </tr>
        </tbody>
    </table>
    <div class="panelBar">
        <div class="pages">
            <!--                <span>显示</span>-->
            <!--                <select class="combox" name="numPerPage" onchange="navTabPageBreak({numPerPage:this.value})">-->
            <!--                    <option value="20">20</option>-->
            <!--                    <option value="50">50</option>-->
            <!--                    <option value="100">100</option>-->
            <!--                    <option value="200">200</option>-->
            <!--                </select>-->
            <span>共<?php echo $pager->itemCount?>条</span>
        </div>

        <div class="pagination" targetType="navTab" totalCount="<?php echo $pager->itemCount?>" numPerPage="<?php echo $pager->pageSize ?>" pageNumShown="10" currentPage="<?php echo $pager->currentPage+1?>"></div>

    </div>
</div>
