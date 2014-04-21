<style type="text/css">
    .pageFormContent label{
        width: 60px;
    }
</style>


<div class="pageContent">
    <div class="tabs" currentIndex="0" eventType="click">
        <div class="tabsHeader">
            <div class="tabsHeaderContent">
                <ul>
                    <li><a href="javascript:;"><span>周结、月结</span></a></li>
                    <li><a href="javascript:;"><span>日结</span></a></li>
                    <!--                    <li><a href="demo_page2.html" class="j-ajax"><span>标题3</span></a></li>-->
                </ul>
            </div>
        </div>

        <div class="tabsContent" >
            <!--            //*text*/-->
            <div>
                <div class="pageContent">
                    <form action="/admin/channel/channelPayAdd" method="post" class="pageForm required-validate"  onsubmit="return iframeCallback(this, navTabAjaxDone);">
                        <div class="pageFormContent" layouth="10" >
                            <div class="unit">
                                <label>
                                    开始日期：
                                </label>
                                <input type="text" size="20" name="record_begin_date" class="date" value="<?php echo $time?$time['start_time']:''?>"/>
                                　　       <label>
                                    结束日期:
                                </label>　
                                <input type="text" size="20" name="record_end_date" class="date" value="<?php echo $time?$time['end_time']:''?>"/>

                            </div>

                            <div class="unit">
                                <label>
                                    渠道名称;
                                </label>
                                <input class="required" name="district.channel_name" type="text" onclick="$('#channel_cost').click()" readonly="readonly"/>
                                <input class="required" name="district.channel_id" type="hidden" readonly="readonly"/>
                                <input class="required" name="district.channel_from" type="hidden" readonly="readonly"/>
                                <a class="btnLook" id="channel_cost" href="/admin/channel/channelLookBack" lookupGroup="district">查找带回</a>
                                <span style="line-height: 18px;color: #ff0000">点击左侧按钮，进行查找</span>

                            </div>

                            <div class="unit">
                                <label>
                                    广告花费:
                                </label>
                                <label>
                                    <input style="margin-left: -5px;" name="cost" type="text" class="required"/>
                                </label>
                                <input type="hidden" name="action" value="save_channel_pay">

                            </div>


                            <dl class="nowrap">
                                <dt>
                                    &nbsp;
                                </dt>
                                <dd>
                                    <button type="submit">
                                        保存
                                    </button>
                                    &nbsp;&nbsp;
                                    <button type="button" class="close">
                                        取消
                                    </button>
                                </dd>
                            </dl>
                        </div>

                    </form>
                </div>
            </div>
            <!--            /*text*/-->

            <div>
                <!--                /*pic*/-->
                <div>
                    <div class="pageContent">
                        <div class="unit">
                            <form method="post" action="/admin/channel/createDay" onsubmit="return iframeCallback(this, navTabAjaxDone);">
                            <label>
                                结算日期：
                            </label>
                            <input type="text" id="cost_day" size="20" name="date" class="date" value=""/>

                            <label>
                                 渠道类型:
                            </label>
                                <select name="channel_type" id="channel_type">
                                    <option value="0">全部</option>
                                    <option value="CPA" >CPA</option>
                                    <option value="CPC" >CPC</option>
                                    <option value="CPT" >CPT</option>
                                    <option value="CPL" >CPL</option>
                                    <option value="CPM" >CPM</option>
                                    <option value="CPS" >CPS</option>
                                </select>
                            <button type="button" onclick="channelAjax($('#cost_day').attr('value'),$('#channel_type').attr('value'))">
                                生成
                            </button>

                        </div>
                        <div class="pageContent">
                        <table class="table" width="1200" layoutH="138">
                        <thead>
                        <tr>
                            <th width="50">渠道编号</th>
                            <th width="80" >渠道名称</th>
                            <th width="50" >激活数</th>
                            <th width="60" >注册数</th>
                            <th width="70">花费</th>
                            <th width="70">统计日期</th>
                            <th width="70">操作</th>
                        </tr>
                        </thead>
                        <tbody id="tbody">
                        </tbody>
                        </table>
                        <div class="panelBar">
<!--                            <div class="pages">-->
<!--                                <span>显示</span>-->
<!--                                <select class="combox" name="numPerPage" onchange="navTabPageBreak({numPerPage:this.value})">-->
<!--                                    <option value="20">20</option>-->
<!--                                    <option value="50">50</option>-->
<!--                                    <option value="100">100</option>-->
<!--                                    <option value="200">200</option>-->
<!--                                </select>-->
<!--                                <span>条，共${totalCount}条</span>-->
<!--                            </div>-->

<!--                            <div class="pagination" targetType="ajaxTodo" totalCount="200" numPerPage="20" pageNumShown="10" currentPage="1"></div>-->

                        </div>
                        </div>

                    </div>
                </div>

                <!--                /*pic*/-->
            </div>
        </div>



        <div class="tabsFooter">
            <div class="tabsFooterContent"></div>
        </div>
    </div>

    <p>&nbsp;</p>

</div>
<script type="text/javascript">
    function channelAjax(date,type){
        $.ajax({
            url:"/admin/channel/createDay?date="+date+"&channel_type="+type,
            success:function(res){
               var jsonCode = JSON.parse(res);
                var html = '';
               for(var i=0;i<jsonCode.length;i++){
                       html += '<tr target="sid_user" rel="1">'+
                               '<td>'+jsonCode[i].channel_id+'</td>'+
                               '<td>'+jsonCode[i].channel_name+'</td>'+
                               '<td>'+jsonCode[i].new_run_nums+'</td>'+
                               '<td>'+jsonCode[i].reg_users+'</td>'+
                               '<td><input type="text" style="width: 120px;" id="channel_cost'+jsonCode[i].channel_id+'" value="'+jsonCode[i].cost+'"/></td>'+
                               '<td >'+date+'</td>'+
                               '<td><a title="花费修改"  href="#" class="btnEdit" onclick="ajaxSave(\''+date+'\','+jsonCode[i].channel_id+')">查看明细</a></td>'+
                               '</tr>';
               }
                $('#tbody').empty();
                $('#tbody').append(html);
            },
            error:function(){
                alert('error');
            }

        })
    }

    function ajaxSave(date,channeld_id){
        var cost = $('#channel_cost'+channeld_id).attr('value');
        $.ajax({
            url:"/admin/channel/dayCostEdit?date="+date+'&channel_id='+channeld_id+'&cost='+cost,
            success:function(res){
                if(res ==1)
               alert('success');
                else
                alert('fail');
            },
            error:function(){
                alert('error');
            }
        })
    }
</script>
