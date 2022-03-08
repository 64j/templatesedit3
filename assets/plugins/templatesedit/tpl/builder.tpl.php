<link rel="stylesheet" href="<?= MODX_BASE_URL ?>assets/plugins/templatesedit/css/builder.css">
<input type="hidden" name="templatesedit_builder_action">
<div class="container container-body builder">
    <div class="row b-header align-items-center">
        <div class="col-auto"><?= $this->lang['role'] ?></div>
        <div class="col-auto">
            <?= $this->renderSelectRole() ?>
        </div>
        <div class="col text-right">
            <?php
            if (!empty($this->params['check_this_config'])) {
                ?>
                <small class="text-success"><?= $this->lang['info.there_is_config'] ?></small>
                <?php
            } else {
                if (!empty($this->params['check_base_config'])) {
                    ?>
                    <small class="text-muted"><?= $this->lang['info.used_config_role_admin'] ?></small>
                    <?php
                } elseif (!empty($this->params['check_default_config'])) {
                    ?>
                    <small class="text-muted"><?= $this->lang['info.used_default_config'] ?></small>
                    <?php
                }
            }
            ?>
        </div>
        <div class="col-auto">
            <?php
            if (!empty($this->params['check_this_config'])) {
                ?>
                <span class="btn btn-sm btn-danger" onclick="confirm('<?= $this->lang['confirm.del'] ?>')&&(document.mutate.templatesedit_builder_data.value='',document.mutate.submit())"><?= $this->lang['action.del'] ?></span>
                <?php
                if ($this->params['templatesedit_builder_role'] == 1) {
                    if ($this->params['config_is_default']) {
                        ?>
                        <span class="btn btn-sm btn-danger" onclick="confirm('<?= $this->lang['confirm.del_default'] ?>')&&(document.mutate.templatesedit_builder_action.value='del_default',document.mutate.submit())"><?= $this->lang['action.del_default'] ?></span>
                        <?php
                    }
                    ?>
                    <span class="btn btn-sm btn-secondary" onclick="confirm('<?= $this->lang['confirm.set_default'] ?>')&&(document.mutate.templatesedit_builder_action.value='set_default',document.mutate.submit())"><?= $this->lang['action.set_default'] ?></span>
                    <?php
                }
            } else {
                if (!empty($this->params['check_base_config'])) {
                    ?>
                    <span class="btn btn-sm btn-primary" onclick="(document.mutate.templatesedit_builder_action.value='set_base',document.mutate.submit())"><?= $this->lang['action.set'] ?></span>
                    <?php
                }
            }
            ?>
            <span class="btn btn-sm b-btn-default b-btn-empty"><?= $this->lang['action.empty'] ?></span>
        </div>
    </div>
    <div class="row">
        <div class="col-auto b-fields-wrap">
            <div class="b-items-header sectionHeader"><?= $this->lang['fields'] ?></div>
            <div class="b-items b-unused-fields sectionBody">
                <?= $this->renderUnusedFields() ?>
            </div>
            <div class="b-items-header sectionHeader"><?= $this->lang['tmplvars'] ?></div>
            <div class="b-items b-unused-tvars sectionBody">
                <?= $this->renderUnusedTvars() ?>
            </div>
            <div class="b-items-header sectionHeader"><?= $this->lang['categories'] ?></div>
            <div class="b-items b-unused-categories sectionBody">
                <?= $this->renderUnusedCategories() ?>
            </div>
            <div class="b-items-header sectionHeader"><?= $this->lang['import_export'] ?></div>
            <div class="b-items b-unused-categories sectionBody">
                <div class="p-1">
                    <input type="file" id="builder_file">
                </div>
                <div class="row m-0">
                    <div class="col p-0">
                        <span id="builder_import" class="btn btn-sm btn-secondary d-block rounded-0"><?= $this->lang['import.btn'] ?></span>
                    </div>
                    <div class="col p-0">
                        <span id="builder_export" class="btn btn-sm btn-default d-block rounded-0"><?= $this->lang['export.btn'] ?></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div id="builder" class="b-content"></div>
        </div>
    </div>
</div>
<textarea name="templatesedit_builder_data" id="templatesedit_builder_data" rows="15" style="display: none"><?= $data['config'] ?></textarea>
<script src="<?= MODX_BASE_URL ?>assets/plugins/templatesedit/js/Sortable.min.js"></script>
<script src="<?= MODX_BASE_URL ?>assets/plugins/templatesedit/js/TemplatesEditBuilder.js?v=3.1.9"></script>
<script>
  new TemplatesEditBuilder(document.getElementById('builder'), {
    dataEl: document.getElementById('templatesedit_builder_data'),
    data_fields: <?= $data['data_fields'] ?>,
    data_tvars: <?= $data['data_tvars'] ?>,
    data_categories: <?= $data['data_categories'] ?>,
    data_types: <?= $data['data_types'] ?>
  });
</script>
