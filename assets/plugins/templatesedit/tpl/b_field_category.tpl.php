<div class="col-12 b-category b-item b-draggable" data-name="category:<?= $data['name'] ?? '' ?>" data-title="<?= $data['title'] ?? '' ?>" data-id="<?= $data['name'] ?? '' ?>">
    <div class="row b-category-title">
        <div class="col-auto"><i class="fa fa-bars b-move"></i></div>
        <div class="col b-field-name"><?= $data['title'] ?? '' ?></div>
        <div class="col-auto"><i class="fa fa-minus-circle text-danger b-btn-del"></i></div>
    </div>
</div>
