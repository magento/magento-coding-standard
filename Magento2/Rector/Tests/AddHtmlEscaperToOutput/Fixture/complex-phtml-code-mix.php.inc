<?php
$items = $block->getAllItems();
?>
<div class="test">
    <?php if (count($items) > 0): ?>
        <div class="counter"><?= __('Total <span>%1</span> items found', count($items)) ?></div>
        <?php foreach ($items as $item): ?>
            <a href="<?= $block->getActionUrl($item); ?>"><?= $item->getName(); ?></a>
        <?php endforeach; ?>
    <?php else: ?>
        <?= __('No items found.'); ?>
    <?php endif; ?>
</div>
-----
<?php
$items = $block->getAllItems();
?>
<div class="test">
    <?php if (count($items) > 0): ?>
        <div class="counter"><?= __('Total <span>%1</span> items found', count($items)) ?></div>
        <?php foreach ($items as $item): ?>
            <a href="<?= $block->getActionUrl($item); ?>"><?= $escaper->escapeHtml($item->getName()); ?></a>
        <?php endforeach; ?>
    <?php else: ?>
        <?= $escaper->escapeHtml(__('No items found.')); ?>
    <?php endif; ?>
</div>
