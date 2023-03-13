<div class="widget am-cf">
    <div class="widget-body">
        <!--        <div class="tpl-page-state am-margin-top-xl">-->
        <!--            <div class="tpl-page-state-title am-text-center">已是最新版本</div>-->
        <!--        </div>-->
        <?php if (isset($list)): ?>
            <div class="tpl-page-state am-margin-top-xl">
                <div class="tpl-page-state-title am-text-center"><?= $list['code'] == -1 ? '已是最新版本' : '检测到新版本' ?></div>
                <div class="tpl-page-state-title am-text-center"><?= empty($list['msg']) ? '' : $list['msg'] ?></div>
            </div>
            <?php if ($list['code'] != -1): ?>
                <div class="tpl-page-state-content tpl-error-content">
                    <p>最新 v<?= $list['data']['version'] ?> 版本可更新</p>
                </div>

                <div class="widget-head am-cf">
                    <div class="widget-title am-fl">v<?= $list['data']['version'] ?> 版本更新内容</div>
                </div>

                <div style="font-size: 14px">
                    <?= $list['data']['msg'] ?><br>
                </div>

                <div class="am-form-group am-margin-top-lg">
                    <div class="am-u-sm-12 am-u-sm-push-0 am-margin-top-lg">
                        <button type="submit" class="j-submit am-btn am-btn-secondary">立即更新</button>
                    </div>
                </div>
            <?php endif; ?>

        <?php endif; ?>


    </div>
</div>

<script>
    $(function () {

        // 删除元素
        var url = "<?= url('setting.update/upDate') ?>";
        $('.j-submit').delete('id', url, '确定要更新吗？<br>更新将覆盖本地文件，请注意备份！');

    });
</script>
