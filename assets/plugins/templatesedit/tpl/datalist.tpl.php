<datalist id="datalist<?= $data['id'] ?? '' ?>">
    <?= $data['options'] ?? '' ?>
</datalist>
<script>document.mutate.tv<?= $data['id'] ?? '' ?>.setAttribute('list', 'datalist<?= $data['id'] ?? '' ?>');</script>
