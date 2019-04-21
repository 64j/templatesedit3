<link rel="stylesheet" href="<?= MODX_BASE_URL ?>assets/plugins/templatesedit/css/builder.css">
<div class="container container-body builder">
    <div class="row b-header align-items-center">
        <div class="col-auto"><?= $this->lang['role'] ?></div>
        <div class="col-auto">
            <?= $this->getSelectRole() ?>
        </div>
        <div class="col text-right text-success">
            <?php
            if ($this->params['templatesedit_builder_role'] == 1) {
                if (!empty($this->params['default_config'])) {
                    echo $this->lang['info_default_template'];
                } else {
                    if (!empty($this->params['check_config'])) {
                        echo $this->lang['info_saved_config_for_this_template'];
                    }
                }
            } else {
                if (!empty($this->params['check_config'])) {
                    echo $this->lang['info_saved_config_for_this_template'];
                }
            }
            ?>
        </div>
        <div class="col-auto">
            <?php
            if ($this->params['templatesedit_builder_role'] == 1) {
                if (!empty($this->params['default_config'])) {
                    ?>
                    <label class="btn btn-secondary btn-sm btn-danger" for="templatesedit_builder_del_default">
                        <input
                            type="checkbox"
                            id="templatesedit_builder_del_default"
                            name="templatesedit_builder_del_default"
                            value="1"
                            onchange="confirm('<?= $this->lang['confirm_del_default_for_all'] ?>')?(this.checked=!0,document.mutate.submit()):this.checked=!1;"
                            hidden>
                        <?= $this->lang['del_default_for_all'] ?>
                    </label>
                    <?php
                }
                ?>
                <label class="btn btn-secondary btn-sm b-btn-default" for="templatesedit_builder_set_default">
                    <input
                        type="checkbox"
                        id="templatesedit_builder_set_default"
                        name="templatesedit_builder_set_default"
                        value="1"
                        onchange="confirm('<?= $this->lang['confirm_set_default_for_all'] ?>')?(this.checked=!0,document.mutate.submit()):this.checked=!1;"
                        hidden>
                    <?= $this->lang['set_default_for_all'] ?>
                </label>
                <?php
            } else {
                ?>
                <label class="btn btn-primary btn-sm b-btn-reset" for="templatesedit_builder_get_default">
                    <input
                        type="checkbox"
                        id="templatesedit_builder_get_default"
                        name="templatesedit_builder_get_default"
                        value="1"
                        onchange="(this.checked=!0,document.mutate.submit());"
                        hidden>
                    <?= $this->lang['get_default'] ?>
                </label>
                <?php
            }
            ?>
            <label class="btn btn-sm b-btn-default b-btn-empty" for="this"><?= $this->lang['empty'] ?></label>
        </div>
    </div>
    <div class="row">
        <div class="col-auto b-fields-wrap">
            <div class="b-items-header sectionHeader"><?= $this->lang['fields'] ?></div>
            <div class="b-items b-unused-fields sectionBody">
                <?= $this->getUnusedFields() ?>
            </div>
            <div class="b-items-header sectionHeader"><?= $this->lang['tmplvars'] ?></div>
            <div class="b-items b-unused-tvars sectionBody">
                <?= $this->getUnusedTvars() ?>
            </div>
            <div class="b-items-header sectionHeader"><?= $this->lang['categories'] ?></div>
            <div class="b-items b-unused-categories sectionBody">
                <?= $this->getUnusedCategories() ?>
            </div>
        </div>
        <div class="col">
            <div id="builder" class="b-content"></div>
        </div>
    </div>
</div>
<textarea name="templatesedit_builder_data" id="templatesedit_builder_data" rows="15" style="display: none"><?= $data['config'] ?></textarea>
<script src="<?= MODX_BASE_URL ?>assets/plugins/templatesedit/js/Sortable.min.js"></script>
<script src="<?= MODX_BASE_URL ?>assets/plugins/templatesedit/js/TemplatesEditBuilder.js"></script>
<script>
  new TemplatesEditBuilder(document.getElementById('builder'), {
    dataEl: document.getElementById('templatesedit_builder_data'),
    data_fields: <?= $data['data_fields'] ?>,
    data_tvars: <?= $data['data_tvars'] ?>,
    data_categories: <?= $data['data_categories'] ?>,
    data_types: <?= $data['data_types'] ?>,
  });
</script>