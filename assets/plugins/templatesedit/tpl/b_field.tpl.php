<div class="col-12 b-field b-item b-draggable<?= $data['rowClass'] ?? '' ?>" title="<?= $data['title'] ?? '' ?>" data-name="<?= $data['name'] ?? '' ?>" data-title="<?= $data['title'] ?? '' ?>" data-type="<?= $data['type'] ?? '' ?>" data-category="<?= $data['category'] ?? 0 ?>"<?= $data['attr'] ?? '' ?>>
    <div class="row align-items-center">
        <div class="col-auto"><i class="fa fa-bars b-move"></i></div>
        <div class="col b-field-name"><?= $data['name'] ?? '' ?></div>
        <div class="col-auto"><i class="fa fa-cog b-btn-settings"></i></div>
        <div class="col-auto"><i class="fa fa-minus-circle text-danger b-btn-del"></i></div>
    </div>
</div>
