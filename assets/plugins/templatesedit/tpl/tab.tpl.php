<!-- tab<?= $data['name'] ?? '' ?> -->
<div class="tab-page" id="tab<?= $data['name'] ?? '' ?>">
    <h2 class="tab"><?= $data['title'] ?? '' ?></h2>
    <script><?= $data['tabsObject'] ?? '' ?>.addTabPage(document.getElementById('tab<?= $data['name'] ?? '' ?>'));</script>
    <?= $data['content'] ?? '' ?>
</div>
<!-- end #tab<?= $data['name'] ?? '' ?> -->
