<?php
/**
 * Obsolete configuration nodes, specific for EE
 *
 * Format: <class_name> => <replacement>
 *
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

return [
    '/config/global/full_page_cache' => '/config/global/cache_advanced/full_page',
    '/config/adminhtml/enterprise/admingws' => 'This configuration moved to admingws.xml file',
    '/config/adminhtml/enterprise/websiterestriction' => 'This configuration moved to websiterestrictions.xml file',
    '/config/global/enterprise_cms' => 'This configuration moved to menu_hierarchy.xml file',
    '/config/global/enterprise/banner' =>
        'This configuration moved to Di configuration of \Magento\Banner\Model\Config',
    '/config/global/enterprise/giftcardaccount' =>
        'This configuration moved to Di configuration of \Magento\GiftCardAccountModelPool',
    '/config/global/skip_process_modules_updates' => 'Was replaced using di',
    '/config/system/page_cache' => 'Module is eliminated. Use PageCache module instead',
    '/config/system/cms/content/versioning' => 'Functionality is eliminated',
];
