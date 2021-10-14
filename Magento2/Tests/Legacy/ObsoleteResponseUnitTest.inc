<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

$this->_view->loadLayout(['default', 'test'], true, true, false);
$this->_view->renderLayout();

protected function _addBreadcrumb($label, $title = null, $link = null)
{
    $this->getLayout()->getBlock('test')->addLink($label, $title, $link);
}

$this->editPost = $objectManagerHelper->getObject(
    TestClass::class,
    [
        '_redirect' => $this->redirect,
    ]
);

$this->_redirect('test/path');

$this->_forward('grid');

$this->_initAction()->_setActiveMenu(
    'Magento_Invitation::report_magento_invitation_order'
)->_addBreadcrumb(
    __('Invitation Report by Customers'),
    __('Invitation Report by Order Conversion Rate')
)->_addLeft(
)->_addJs(
    $this->_view->getLayout()->createBlock(TestBlock::class)->setTemplate('Test::test.phtml')
);

private function _addContent(AbstractBlock $block)
{
    return $this->_moveBlockToContainer($block, 'content');
}
