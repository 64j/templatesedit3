<div class="col-12">
    <div id="image_for_<?= $data['name'] ?? '' ?>" class="image_for_field" data-image="<?= $data['value'] ?? '' ?>" onclick="BrowseServer('<?= $data['name'] ?? '' ?>')" style="background-image: url('<?= $data['value'] ?>');"></div>
    <script>document.getElementById('<?= $data['name'] ?? '' ?>').addEventListener('change', renderTvImageCheck, false);</script>
</div>
