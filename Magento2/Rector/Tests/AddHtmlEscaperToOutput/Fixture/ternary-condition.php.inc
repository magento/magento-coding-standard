<?php

echo $block->canShowInfo() ?  $escaper->escapeHtml($block->getInfo()) : __('Nothing to show');

?>
-----
<?php

echo $block->canShowInfo() ?  $escaper->escapeHtml($block->getInfo()) : $escaper->escapeHtml(__('Nothing to show'));

?>
