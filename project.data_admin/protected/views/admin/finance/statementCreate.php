<form id="pagerForm" method="post" action="<?php echo Yii::app()->request->requestUri?>">
    <input type="hidden" name="pageNum" value="1" />
    <input type="hidden" name="numPerPage" value="${model.numPerPage}" />
    <input type="hidden" name="orderField" value="${param.orderField}" />
    <input type="hidden" name="orderDirection" value="${param.orderDirection}" />
</form>
<div class="pageHeader">
    <form id="search" rel="pagerForm" onsubmit="return navTabSearch(this);" action="/admin/finance/statementCreate/" method="post">
        <input type="hidden" name="finance_id" value="<?php echo $data['finance_id']; ?>">
        <div class="searchBar" style="padding-top: 10px;">
            <label>开始时间：</label><input type="text" size="20" name="select_begin_time" class="date" value="<?php echo $data['select_begin_time']?$data['select_begin_time']:date('Y-m-d'); ?>"/><label>结束时间：</label><input type="text" size="20" name="select_end_time" class="date"  value="<?php echo $data['select_end_time']?$data['select_end_time']:date('Y-m-d'); ?>"/></li>
        </div>
        <div class="searchBar" style="padding-top: 10px;">
            <li><label>其它金额：</label><input type="text" size="20" name="other_amount" value="<?php echo $data['other_amount']? $data['other_amount']:''; ?>"/></li>
            <div class="subBar">
                <ul>
                    <li><div class="buttonActive"><div class="buttonContent"><button type="submit">查看报表</button></div></div></li><input type="button" onclick="return createExcel(this)" value="导出为EXCEL"/>
                </ul>
            </div>
        </div>
    </form>
</div>
<script>
    function createExcel(){
        var site_url="/admin/finance/createExcel/";
        var param   = $("#search",navTab.getCurrentPanel()).serialize();// 获取当前navTab中的xxxId
        var url     =(site_url+param).replace(/&|=/ig,'/');
        window.location.href=url;
    }
</script>
<div class="pageContent">
    <?php if(empty($data['begin_time'])): ?>
    <p style="color:red;font-size:20px">当前日期范围没有充值记录</p>
    <?php else: ?>
    <table class="table" width="1300" nowrapTD="false">
        <thead>
            <tr align='center'>
                <th width="160px;">实际结算周期</th>
                <th width="100px">公司名</th>
                <th width="100px">游戏名称</th>
                <th width="60px">充值金额</th>
                <th width="100px">支付渠道</th>
                <th width="120px">支付渠道费率</th>
                <th width="60px">支付渠道费</th>
                <th width="60px">其它费用</th>
                <th width="100px">增值税发票类型</th>
                <th width="50px">增值税发票费率</th>
                <th width="50px">增值税发票费</th>
                <th width="50px">分配金额</th>
                <th width="120">分成比例</th>
                <th width="50px">甲方结算金额</th>
                <th width="50px">乙方结算金额</th>
                <th width="70px">备注</th>
            </tr>
        </thead>
        <tbody>
            <?php $row_count = count($data['begin_time']);?>
            <?php foreach($data['begin_time'] as $key=>$val):?>
            <tr>
                <td style="height:60px;"><?php echo $data['begin_time'][$key].'至'.$data['end_time'][$key]; ?></td><!--实际结算周期-->
                <?php if($key==0): ?><td style="height:60px;" rowspan="<?php echo $row_count;?>"><?php echo $data['channel_name'];?></td><?php endif; ?><!--公司名/渠道名-->
                <?php if($key==0): ?><td style="height:60px;" rowspan="<?php echo $row_count;?>"><?php echo $data['game_name'];?></td><?php endif; ?><!--游戏名称-->
                <td style="height:60px;"><?php echo $data['pay_amount'][$key]; ?></td><!--充值金额-->
                <td style="height:60px;"><?php echo $data['pay_channel'][$key]['channel']; ?></td><!--支付渠道-->
                <td style="height:60px;"><?php echo $data['pay_channel'][$key]['ratio']; ?></td><!--支付渠道费率-->
                <td style="height:60px;"><?php echo $data['pay_channel'][$key]['channel_amount']; ?></td><!--支付渠道费-->

                <?php if($key==0): ?><td style="height:60px;" rowspan="<?php echo $row_count;?>"><?php echo $data['other_amount'];?></td><?php endif; ?><!--其它费用-->
                <?php if($key==0): ?><td style="height:60px;" rowspan="<?php echo $row_count;?>"><?php echo $data['invoice_type'];?></td><?php endif; ?><!--增值税发票类型-->
                <?php if($key==0): ?><td style="height:60px;" rowspan="<?php echo $row_count;?>"><?php echo $data['invoice_ratio'];?></td><?php endif; ?><!--增值税发票费率-->
                <?php if($key==0): ?><td style="height:60px;" rowspan="<?php echo $row_count;?>"><?php echo $data['invoice_amount'][$key]; ?></td><?php endif; ?><!--增值税发票费-->
                <?php if($key==0): ?><td style="height:60px;" rowspan="<?php echo $row_count;?>"><?php echo $data['income_sum'];?></td><?php endif; ?><!--分成金额-->
                <?php if($key==0): ?><td style="height:60px;" rowspan="<?php echo $row_count;?>"><?php echo $data['income_ratio'];?></td><?php endif; ?><!--分成比例-->
                <?php if($key==0): ?><td style="height:60px;" rowspan="<?php echo $row_count;?>"><?php echo $data['income_sum_a'];?></td><?php endif; ?><!--甲方结算金额-->
                <?php if($key==0): ?><td style="height:60px;" rowspan="<?php echo $row_count;?>"><?php echo $data['income_sum_b'];?></td><?php endif; ?><!--乙方结算金额-->
                <?php if($key==0): ?><td style="height:60px;" rowspan="<?php echo $row_count;?>">乙方为sdk提供方</td><?php endif; ?>
            </tr>
            <?php endforeach;?>
        </tbody>
    </table>
    <?php endif;?>
</div>
