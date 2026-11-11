<ul class="pagination pagination-sm no-margin">
    <?php if ($page > 1): ?>
        <li p="<?= $page-1 ?>" class="goto"><a>«</a></li>
    <?php endif; ?>

    <?php for ($i=1; $i<=$pages; $i++): ?>
        <li p="<?= $i ?>" class="goto <?= ($i==$page?'active':'') ?>">
            <a><?= $i ?></a>
        </li>
    <?php endfor; ?>

    <?php if ($page < $pages): ?>
        <li p="<?= $page+1 ?>" class="goto"><a>»</a></li>
    <?php endif; ?>
</ul>
