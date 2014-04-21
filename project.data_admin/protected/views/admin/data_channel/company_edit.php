<style type="text/css">
    .pageFormContent label{
        width: 80px;
    }
</style>
<form action="/admin/data_channel/saveAddEdit" method="post" class="pageForm required-validate"  onsubmit="return iframeCallback(this, navTabAjaxDone);">
    <div class="pageFormContent" layouth="10" >
        <div class="unit">
            <label>
                公司名称;
            </label>
            <input type="text" name="company_name" class="required textInput valid" value="<?php echo $company->company?>">

        </div>

        <div class="unit">
            <label>
                公司缩写;
            </label>
            <input type="text" name="company_name_short" value="<?php echo $company->company_ab?>">

            </div>
            <input type="hidden" name="action" value="edit_company">
            <input type="hidden" name="id" value="<?php echo $company->id?>">
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