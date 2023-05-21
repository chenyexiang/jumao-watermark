<div class="row-content am-cf">
    <div class="row">
        <div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
            <div class="widget am-cf">
                <div class="widget-head am-cf">
                    <div class="widget-title am-cf">用户列表</div>
                </div>
                <div class="widget-body am-fr">
                    <!-- 工具栏 -->
                    <div class="page_toolbar am-margin-bottom-xs am-cf">
                        <form class="toolbar-form" action="">
                            <input type="hidden" name="s" value="/<?= $request->pathinfo() ?>">
                            <div class="am-u-sm-12 am-u-md-9 am-u-sm-push-3">
                                <div class="am fr">
                                    <div class="am-form-group am-fl">
                                        <div class="am-input-group am-input-group-sm tpl-form-border-form">
                                            <input type="text" class="am-form-field" name="nickName"
                                                   placeholder="请输入微信昵称"
                                                   value="<?= $request->get('nickName') ?>">
                                            <div class="am-input-group-btn">
                                                <button class="am-btn am-btn-default am-icon-search"
                                                        type="submit"></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="am-scrollable-horizontal am-u-sm-12">
                        <table width="100%" class="am-table am-table-compact am-table-striped
                         tpl-table-black am-text-nowrap">
                            <thead>
                            <tr>
                                <th>用户ID</th>
                                <th>微信昵称</th>
                                <th>解析次数</th>
                                <th>状态</th>
                                <th>注册时间</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (!$list->isEmpty()): foreach ($list as $item): ?>
                                <tr>
                                    <td class="am-text-middle"><?= $item['user_id'] ?></td>


                                    <td class="am-text-middle"><?= $item['nickName'] ?></td>
                                    <td class="am-text-middle"><?= $item['number'] ?></td>

                                    <td class="am-text-middle">
                                           <span class="j-state am-badge x-cur-p
                                           am-badge-<?= $item['is_state'] == 0 ? 'success' : 'danger' ?>"
                                                 data-id="<?= $item['user_id'] ?>"
                                                 data-state="<?= $item['is_state'] ?>">
                                               <?= $item['is_state'] == 0 ? '正常' : '禁用' ?>
                                           </span>
                                    </td>
                                    <td class="am-text-middle"><?= $item['create_time'] ?></td>

                                    <td class="am-text-middle">

                                        <div class="tpl-table-black-operation">
                                            <?php if (checkPrivilege('user/delete')): ?>
                                                <a href="javascript:void(0);"
                                                   class="item-delete tpl-table-black-operation-del"
                                                   data-id="<?= $item['user_id'] ?>">
                                                    <i class="am-icon-trash"></i> 删除
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; else: ?>
                                <tr>
                                    <td colspan="10" class="am-text-center">暂无记录</td>
                                </tr>
                            <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="am-u-lg-12 am-cf">
                        <div class="am-fr"><?= $list->render() ?> </div>
                        <div class="am-fr pagination-total am-margin-right">
                            <div class="am-vertical-align-middle">总记录：<?= $list->total() ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>

<script>
    $(function () {
        // 用户状态
        $('.j-state').click(function () {
            var data = $(this).data();
            layer.confirm('确定要' + (parseInt(data.state) === 0 ? '禁用' : '恢复') + '该用户使用权限吗？'
                , {title: '友情提示'}
                , function (index) {
                    $.post("<?= url('user/state') ?>"
                        , {
                            user_id: data.id,
                            state: Number(parseInt(data.state))
                        }
                        , function (result) {
                            result.code === 1 ? $.show_success(result.msg, result.url)
                                : $.show_error(result.msg);
                        });
                    layer.close(index);
                });
        });

        // 删除元素
        var url = "<?= url('user/delete') ?>";
        $('.item-delete').delete('user_id', url, '删除后不可恢复，确定要删除吗？');

    });
</script>

