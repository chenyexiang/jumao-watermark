<div class="row-content am-cf">
    <div class="row">
        <div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
            <div class="widget am-cf">
                <form id="my-form" class="am-form tpl-form-line-form" enctype="multipart/form-data" method="post">
                    <div class="widget-body">
                        <fieldset>
                            <div class="widget-head am-cf">
                                <div class="widget-title am-fl">小程序设置</div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-form-label form-require">
                                    AppID <span class="tpl-form-line-small-title">小程序ID</span>
                                </label>
                                <div class="am-u-sm-9">
                                    <input type="text" class="tpl-form-input" name="wxapp[app_id]"
                                           value="<?= $wxapp['app_id'] ?>" required>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-form-label form-require">
                                    AppSecret <span class="tpl-form-line-small-title">小程序密钥</span>
                                </label>
                                <div class="am-u-sm-9">
                                    <input type="password" class="tpl-form-input" name="wxapp[app_secret]"
                                           value="<?= $wxapp['app_secret'] ?>" required>
                                </div>
                            </div>


                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-form-label form-require">
                                    解析接口
                                </label>
                                <div class="am-u-sm-9 am-u-end">
                                    <label class="am-radio-inline">
                                        <input type="radio" name="wxapp[is_analysis]" value="0"
                                               data-am-ucheck
                                            <?= $wxapp['is_analysis'] == 0 ? 'checked' : '' ?>>
                                        第三方接口
                                    </label>
                                    <label class="am-radio-inline">
                                        <input type="radio" name="wxapp[is_analysis]" value="1"
                                               data-am-ucheck
                                            <?= $wxapp['is_analysis'] == 1 ? 'checked' : '' ?>>
                                        内置接口
                                    </label>
                                </div>
                            </div>

                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-form-label form-require">
                                    限制用户下载
                                </label>
                                <div class="am-u-sm-9 am-u-end">
                                    <label class="am-radio-inline">
                                        <input type="radio" name="wxapp[is_download]" value="0"
                                               data-am-ucheck
                                            <?= $wxapp['is_download'] == 0 ? 'checked' : '' ?>>
                                        关闭
                                    </label>
                                    <label class="am-radio-inline">
                                        <input type="radio" name="wxapp[is_download]" value="1"
                                               data-am-ucheck
                                            <?= $wxapp['is_download'] == 1 ? 'checked' : '' ?>>
                                        开启
                                    </label>
                                </div>
                                <small class="am-u-sm-9 am-margin-top">开启前请先开启流量主的激励广告。开启后用户需看一次激励广告后可在24小时内不限次数下载视频</small>

                            </div>


                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-form-label">
                                    小程序 <span class="tpl-form-line-small-title">公告</span>
                                </label>
                                <div class="am-u-sm-9">
                                    <input type="text" class="tpl-form-input" name="wxapp[notice]"
                                           value="<?= $wxapp['notice'] ?>">
                                </div>
                            </div>
                            <div class="widget-head am-cf">
                                <div class="widget-title am-fl">下载接口设置</div>
                            </div>


                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-form-label">
                                    视频下载接口
                                </label>
                                <div class="am-u-sm-9">
                                    <input type="text" class="tpl-form-input" name="wxapp[download_video]"
                                           value="<?= $wxapp['download_video'] ?>">
                                </div>
                                <small class="am-u-sm-9 am-margin-top">非必要不用动这里，默认接口是https://你的域名/video.php?url=</small>

                            </div>

                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-form-label">
                                    图片下载接口
                                </label>
                                <div class="am-u-sm-9">
                                    <input type="text" class="tpl-form-input" name="wxapp[download_image]"
                                           value="<?= $wxapp['download_image'] ?>">
                                </div>
                                <small class="am-u-sm-9 am-margin-top">非必要不用动这里，默认接口是https://你的域名/image.php?url=</small>

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
