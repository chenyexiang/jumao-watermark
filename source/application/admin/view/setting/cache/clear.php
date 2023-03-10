<div class="row">
    <div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
        <div class="widget am-cf">
            <form id="my-form" class="am-form tpl-form-line-form" enctype="multipart/form-data" method="post">
                <div class="widget-body">
                    <fieldset>
                        <div class="widget-head am-cf">
                            <div class="widget-title am-fl">清理缓存</div>
                        </div>
                        <div class="am-form-group">
                            <label class="am-u-sm-3 am-form-label form-require">
                                缓存项
                            </label>
                            <div class="am-u-sm-9">
                                <label class="am-checkbox-inline">
                                    <input type="checkbox" name="cache[item][]" value="data"
                                           data-am-ucheck checked required>
                                    数据缓存
                                </label>
                                <label class="am-checkbox-inline">
                                    <input type="checkbox" name="cache[item][]" value="temp"
                                           data-am-ucheck checked required>
                                    临时图片
                                </label>
                            </div>
                        </div>
                        <?php if (isset($isForce) && $isForce === true): ?>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-form-label form-require"> 强制模式 </label>
                                <div class="am-u-sm-9">
                                    <label class="am-radio-inline">
                                        <input type="radio" name="cache[isForce]" value="0" checked
                                               data-am-ucheck>
                                        否
                                    </label>
                                    <label class="am-radio-inline">
                                        <input type="radio" name="cache[isForce]" value="1" data-am-ucheck>
                                        是
                                    </label>
                                    <div class="help-block">
                                        <small class="x-color-red">此操作将会强制清空所有缓存文件，包含用户授权登录状态，仅允许在开发环境中使用
                                        </small>
                                    </div>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="am-form-group">
                                <div class="am-u-sm-9 am-u-sm-push-3">
                                    <small>
                                        <a href="<?= url('', ['isForce' => true]) ?>">
                                            进入强制模式</a>
                                    </small>
                                </div>
                            </div>
                        <?php endif; ?>
                        <div class="am-form-group">
                            <div class="am-u-sm-9 am-u-sm-push-3 am-margin-top-lg">
                                <button type="submit" class="j-submit am-btn am-btn-secondary">提交
                                </button>
                            </div>
                        </div>
                    </fieldset>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(function () {

        /**
         * 表单验证提交
         * @type {*}
         */
        $('#my-form').superForm();

    });
</script>
