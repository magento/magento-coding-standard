<!--
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
-->

<html>
    <head>
        <base/>
        <link/>
    </head>
    <body>
        <div class="action-dropdown">
            <button type="button" class="action-toggle" data-mage-init='{"dropdown":{}}' data-toggle="dropdown">
                <span>Test</span>
            </button>
        </div>
        <div class="fieldset-wrapper-title">
            <strong class="admin__collapsible-title" data-toggle="collapse" data-bind="attr:{'data-target': '#'+id}">
                <span data-bind="text: title"></span>
            </strong>
        </div>
        <div class="admin__collapsible-title"
            data-toggle="collapse"
            data-target="#id-content">
            <span>Test</span>
        </div>
        <strong <?= /* @noEscape */ $isCollapsable ?
            'class="admin__collapsible-title" data-toggle="collapse" data-target="#' . $id . '-content"' :
            'class="title"'; ?>>
            <span><?= $block->escapeHtml($element->getLegend()) ?></span>
        </strong>
    </body>
</html>
