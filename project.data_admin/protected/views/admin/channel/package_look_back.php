
<form id="pagerForm" action="<?php echo Yii::app()->request->requestUri?>">
    <input type="hidden" name="pageNum" value="1" />
    <input type="hidden" name="numPerPage" value="${model.numPerPage}" />
    <input type="hidden" name="orderField" value="${param.orderField}" />
    <input type="hidden" name="orderDirection" value="${param.orderDirection}" />
    <!--    ，带条件搜素-->
    <!--    <input type='hidden' name='game_name' value='' />-->
    <?php
    if(isset($arrCondition) && !empty($arrCondition)){
        foreach($arrCondition as $key=>$condition){
            echo "<input type='hidden' name='{$key}' value='{$condition}' />";
        }
    }
    ?>
</form>

<div class="pageHeader">
    <form rel="pagerForm" method="post" action="<?php echo Yii::app()->request->requestUri?>" onsubmit="return dwzSearch(this, 'dialog');">
        <div class="searchBar">
            <ul class="searchContent">
                <li>
                    <label>游戏包标题:</label>
                    <input class="textInput" name="pack_title" value="" type="text">
                </li>

                <li>
                    <label>游戏包路径:</label>
                    <input class="textInput" name="pack_path" value="" type="text">
                </li>
            </ul>
            <div class="subBar">
                <ul>
                    <li><div class="buttonActive"><div class="buttonContent"><button type="submit">查询</button></div></div></li>
                </ul>
            </div>
        </div>
    </form>
</div>
<div class="pageContent">

    <table class="table" layoutH="118" targetType="dialog" width="100%">
        <thead>
        <tr>
            <th orderfield="orgName">包编号</th>
            <th orderfield="orgNum">包名称</th>
            <th orderfield="leader">包路径</th>
            <th width="80">查找带回</th>
        </tr>
        </thead>
        <tbody>
        <?php
        if(isset($packages) && !empty($packages)){
            $now_date = date('Y-m-d');
            foreach($packages as $package){
                $id = $package['id'];
                $title = $package['title'];
                $packagePath = $package['package_path'];
                $create_date = date('Y-m-d',strtotime($package['create_time']));
                $create_time = $package['create_time'];
                ?>

                <tr>
                    <td><?php echo $id?></td>
                    <?php
                        if($create_date == $now_date){
                            echo "<td style='color: red;'>{$title} （*今日上传）</td>";
                        }else{
                            echo "<td>$title</td>";
                        }
                    ?>
                    <td><?php if(!file_exists(CDN_ROOT.$packagePath)): echo '<p style="color:red;">'.$packagePath.'</p>';
                              else:
                                  echo $packagePath;
                            endif;?>
                    </td>
                    <td>
                        <a class="btnSelect" href="javascript:$.bringBack({package_id:'<?php echo $id?>', package_title:'<?php echo $title?>', package_path:'<?php echo $packagePath?>'})" title="查找带回">选择</a>
                    </td>
                </tr>
            <?php
            }
        }
        ?>


        </tbody>
    </table>

    <div class="panelBar">
        <div class="pages">
            <!--            <span>每页</span>-->
            <!---->
            <!--            <select name="numPerPage" onchange="dwzPageBreak({targetType:dialog, numPerPage:'10'})">-->
            <!--                <option value="10" selected="selected">10</option>-->
            <!--                <option value="20">20</option>-->
            <!--                <option value="50">50</option>-->
            <!--                <option value="100">100</option>-->
            <!--            </select>-->
            <span>共<?php echo $pager->itemCount?>条</span>
        </div>
        <div class="pagination" targetType="dialog" totalCount="<?php echo $pager->itemCount?>" numPerPage="<?php echo $pager->pageSize?>" pageNumShown="1" currentPage="<?php echo $pager->currentPage+1?>"></div>
    </div>
</div>