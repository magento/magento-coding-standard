<?php
/** @var Magento\Framework\View\Element\Template $block */
/** @var Magento\Framework\Escaper $escaper */
?>

<section>
    <h1>This unescaped output is fine here; other sniffs will complain about it though.</h1>

    <?php echo $block->getSomeString(); ?>
    <?= $block->getSomeString(); ?>
    <?= /** @noEscape */ $block->getSomeString(); ?>
    <?= /** @escapeNotVerified */ $block->getSomeString(); ?>
</section>

<section>
    <h1>These should be using equivalent methods on the `$escaper` class, not the `$block` class.</h1>

    Note that I couldn't find any use of this method in any templates within Magento.
    <?= $block->escapeCss($block->getSomeString()); ?>

    <?= $block->escapeHtml(__($block->getSomeString())) ?>
    <?= $block->escapeHtml(__($block->getSomeString())); ?>
    <?= $block->escapeHtml(__($block->getSomeString()), ['strong', 'em', 'span']) ?>

    <div class="<?= $block->escapeHtmlAttr($block->getSomeString()) ?>"></div>
    <div class="<?= $block->escapeHtmlAttr($block->getSomeString(), true) ?>"></div>
    <div class="<?= $block->escapeHtmlAttr($block->getSomeString(), false); ?>"></div>

    <script type="text/x-magento-init">
    {
        "#chart_<?= $block->escapeJs($block->getData('html_id')) ?>_period": {
            "Magento_Backend/js/dashboard/chart": {}
        }
    }
    </script>

    The only example of this method being used was in a block class, rather than a template.
    <?php
    foreach ($block->getItems() as $item) {
        $item['sku'] = $block->escapeJsQuote($item['sku']);
    }
    ?>

    The only example of this method being used was in a block class, rather than a template.
    <?= $block->escapeQuote(__($block->getData('welcome'))); ?>

    <a href="<?= $block->escapeUrl($block->getUrl('adminhtml/notification/index')) ?>"> link text </a>

    Note that I couldn't find any use of this method in any templates within Magento.
    <?= $block->escapeXssInUrl($block->getSomeString()); ?>
</section>

<section>
    <h1>These are edge cases for formatting differences</h1>

    <?php
        $block->escapeHtml('');
        $block ->escapeHtml('');
        $block-> escapeHtml('');
        $block
            ->escapeHtml('');
        $block

            ->escapeHtml('');
        $block->
            escapeHtml('');
        $block-> // comment
            escapeHtml('');
        $block /* comment */
            ->escapeHtml('');

        $block /* comment */ -> /* comment */ escapeHtml('');
    ?>
</section>

<section>
    <h1>These close-matches shouldn't be flagged by this sniff.</h1>

    <?= $block->escapeHTML(__($block->getSomeString())) ?>
    <?= $block->escapeHtmlString(__($block->getSomeString())) ?>
    <?= $block->escapeHtmlAttribute($block->getSomeString()) ?>
    <?= $block->escapeCSS($block->getSomeString()); ?>
    <?= $block->escapeJS($block->getData('html_id')) ?>
    <?= $block->escapeJavaScript($block->getData('html_id')) ?>
    <?= $block->escapeQuotes(__($block->getData('welcome'))); ?>
    <?= $block->escapeURL($block->getUrl('adminhtml/notification/index')) ?>
</section>
