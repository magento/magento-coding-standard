<?php
/**
 * Classes that are restricted to use directly.
 * A <replacement> will be suggested to be used instead.
 * Use <whitelist> to specify files and directories that are allowed to use restricted classes.
 *
 * Format: array(<class_name>, <replacement>[, array(<whitelist>)]])
 *
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
return [
    'Zend_Db_Select' => [
        'exclude' => [
            'Magento/ResourceConnections/DB/Adapter/Pdo/MysqlProxy.php'
        ],
    ],
    'Magento\Framework\Serialize\Serializer\Serialize' => [
        'exclude' => [
            'Magento/Framework/Test/Unit/FlagTest.php',
            'Magento/Staging/Test/Unit/Model/Update/FlagTest.php',
            'Magento/Logging/Test/Unit/Setup/ObjectConverterTest.php'
        ]
    ],
    'ArrayObject' => [
        'exclude' => [
            'Magento/MultipleWishlist/Test/Unit/Model/Search/Strategy/EmailTest.php',
            'Magento/Rma/Test/Unit/Model/RmaRepositoryTest.php',
            'Magento/Rma/Test/Unit/Model/Status/HistoryRepositoryTest.php'
        ]
    ]
];