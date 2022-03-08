<input id="<?= $data['id'] ?? '' ?>" class="<?= $data['class'] ?? '' ?> DatePicker unstyled" name="<?= $data['name'] ?? '' ?>" value="<?= $data['value'] ?? '' ?>" onblur="documentDirty=true;" placeholder="<?= $data['placeholder'] ?? '' ?>" <?= $data['disabled'] ?? '' ?> />
<span class="input-group-append">
    <a class="btn text-danger" href="javascript:;" onclick="document.mutate.<?= $data['name'] ?? '' ?>.value=''; documentDirty=true; return true;">
        <i class="<?= $data['icon'] ?? '' ?>" title="<?= $data['icon.title'] ?? '' ?>"></i>
    </a>
</span>
