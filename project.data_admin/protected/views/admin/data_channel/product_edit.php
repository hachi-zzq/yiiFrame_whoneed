<style type="text/css">
    .pageFormContent label{
        width: 80px;
    }
</style>
<form action="/admin/data_channel/saveAddEditProduct" method="post" class="pageForm required-validate"  onsubmit="return iframeCallback(this, navTabAjaxDone);">
    <div class="pageFormContent" layouth="10" >
        <div class="unit">
            <label>产品选择:</label>
            <input class="required" name="district.game_name" type="text" onclick="$('#edit_product_game_back').click()" readonly="readonly" value="<?php echo $product->appname?>"/>
            <input class="required" name="district.id" type="text" readonly="readonly" value="<?php echo $product->appid?>"/>
            <a class="btnLook" style="display: none" id="edit_product_game_back" href="/admin/channel/gameBack" lookupGroup="district">查找带回</a>
        </div>
        <div class="unit">
            <label>
                产品缩写;
            </label>
            <input type="text" name="product_ab" value="<?php echo $product->app_ab?>">
        </div>
        <input type="hidden" name="action" value="edit_product">
        <input type="hidden" name="company_id" value="<?php echo $_GET['id']?>">
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