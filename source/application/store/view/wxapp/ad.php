<div class="row-content am-cf">
    <div class="row">
        <div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
            <div class="widget am-cf">
                <form id="my-form" class="am-form tpl-form-line-form" enctype="multipart/form-data" method="post">
                    <div class="widget-body">
                        <fieldset>


                            <div class="widget-head am-cf">
                                <div class="widget-title am-fl">流量主设置</div>
                            </div>

                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-form-label form-require">广告开关 </label>
                                <div class="am-u-sm-9 am-u-end">
                                    <label class="am-radio-inline">
                                        <input type="radio" name="wxapp[is_ad]" value="0"
                                               data-am-ucheck
                                            <?= $wxapp['is_ad'] == 0 ? 'checked' : '' ?>>
                                        关闭广告
                                    </label>
                                    <label class="am-radio-inline">
                                        <input type="radio" name="wxapp[is_ad]" value="1"
                                               data-am-ucheck
                                            <?= $wxapp['is_ad'] == 1 ? 'checked' : '' ?>>
                                        开启广告
                                    </label>
                                </div>
                            </div>

                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-form-label">
                                    Banner广告
                                </label>
                                <div class="am-u-sm-9">
                                    <input type="text" class="tpl-form-input"
                                           name="wxapp[ad_banner]"
                                           value="<?= $wxapp['ad_banner'] ?>" placeholder="请填写微信流量主广告位 ID">
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-form-label">
                                    激励广告
                                </label>
                                <div class="am-u-sm-9">
                                    <input type="text" class="tpl-form-input"
                                           name="wxapp[ad_excitation]"
                                           value="<?= $wxapp['ad_excitation'] ?>" placeholder="请填写微信流量主广告位 ID">
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-form-label">
                                    视频广告
                                </label>
                                <div class="am-u-sm-9">
                                    <input type="text" class="tpl-form-input"
                                           name="wxapp[ad_video]"
                                           value="<?= $wxapp['ad_video'] ?>" placeholder="请填写微信流量主广告位 ID">
                                </div>
                            </div>
                            <div class="am-form-group">
                                <div class="am-u-sm-9 am-u-sm-push-3 am-margin-top-lg">
                                    <button type="submit" class="j-submit am-btn am-btn-secondary">保 存</button>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function () {

        /**
         * 表单验证提交
         * @type {*}
         */
        $('#my-form').superForm();

    });
</script>
