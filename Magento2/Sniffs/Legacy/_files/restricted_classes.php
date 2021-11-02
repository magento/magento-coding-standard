<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

/**
 * Classes that are restricted to use directly.
 * A <replacement> will be suggested to be used instead.
 * Use <whitelist> to specify files and directories that are allowed to use restricted classes.
 *
 * Format: array(<class_name>, <replacement>[, array(<whitelist>)]])
 */
return [
    'Zend_Db_Select' => [
        'warning_code' => 'ZendDbSelect',
        'replacement' => '\Magento\Framework\DB\Select',
        'exclude' => [
            'Magento/Framework/DB/Select.php',
            'Magento/Framework/DB/Adapter/Pdo/Mysql.php',
            'Magento/Framework/Model/ResourceModel/Iterator.php',
            'Magento/ResourceConnections/DB/Adapter/Pdo/MysqlProxy.php'
        ]
    ],
    'Zend_Db_Adapter_Pdo_Mysql' => [
        'warning_code' => 'ZendDbAdapterPdoMysqlIsRestricted',
        'replacement' => '\Magento\Framework\DB\Adapter\Pdo\Mysql',
        'exclude' => [
            'Magento/Framework/DB/Adapter/Pdo/Mysql.php'
        ]
    ],
    'Magento\Framework\Serialize\Serializer\Serialize' => [
        'warning_code' => 'SerializerSerializeIsRestricted',
        'replacement' => 'Magento\Framework\Serialize\SerializerInterface',
        'exclude' => [
            'Magento/Framework/App/ObjectManager/ConfigLoader/Compiled.php',
            'Magento/Framework/App/Config/ScopePool.php',
            'Magento/Framework/App/ObjectManager/ConfigCache.php',
            'Magento/Framework/App/ObjectManager/ConfigLoader.php',
            'Magento/Framework/DB/Adapter/Pdo/Mysql.php',
            'Magento/Framework/DB/DataConverter/SerializedToJson.php',
            'Magento/Framework/DB/Test/Unit/DataConverter/SerializedToJsonTest.php',
            'Magento/Framework/ObjectManager/Config/Compiled.php',
            'Magento/Framework/Interception/Config/Config.php',
            'Magento/Framework/Interception/PluginList/PluginList.php',
            'Magento/Framework/App/Router/ActionList.php',
            'Magento/Framework/Serialize/Test/Unit/Serializer/SerializeTest.php',
            'src/Magento/Setup/Module/Di/Compiler/Config/Writer/Filesystem.php',
            'Magento/Sales/Setup/SerializedDataConverter.php',
            'Magento/Sales/Test/Unit/Setup/SerializedDataConverterTest.php',
            'Magento/Sales/Test/Unit/Setup/SalesOrderPaymentDataConverterTest.php',
            'Magento/Framework/Flag.php',
            'Magento/Widget/Setup/LayoutUpdateConverter.php',
            'Magento/Cms/Setup/ContentConverter.php',
            'Magento/Framework/Unserialize/Test/Unit/UnserializeTest.php',
            'Magento/Framework/Test/Unit/FlagTest.php',
            'Magento/Staging/Test/Unit/Model/Update/FlagTest.php',
            'Magento/Logging/Test/Unit/Setup/ObjectConverterTest.php'
        ]
    ],
    'ArrayObject' => [
        'warning_code' => 'ArrayObjectIsRestricted',
        'replacement' => 'Custom class, extended from ArrayObject with overwritten serialize/unserialize methods',
        'exclude' => [
                'Magento/Theme/Model/Indexer/Design/Config.php',
                'Magento/Ui/Model/Manager.php',
                'Magento/Ui/Test/Unit/Model/ManagerTest.php',
                'Magento/Backend/Model/Menu.php',
                'Magento/CatalogSearch/Model/Indexer/Fulltext.php',
                'Magento/CatalogSearch/Test/Unit/Model/Indexer/FulltextTest.php',
                'Magento/Catalog/Test/Unit/Model/ProductTest.php',
                'Magento/CatalogSearch/Model/Indexer/Fulltext.php',
                'Magento/Framework/Test/Unit/FlagTest.php',
                'Magento/Framework/Validator/Test/Unit/Constraint/PropertyTest.php',
                'Magento/Framework/Indexer/Test/Unit/BatchTest.php',
                'Magento/Framework/View/Element/UiComponent/ArrayObjectFactory.php',
                'Magento/Framework/View/Element/UiComponent/Config/Provider/Component/Definition.php',
                'Magento/Framework/Indexer/Action/Base.php',
                'Magento/MultipleWishlist/Test/Unit/Model/Search/Strategy/EmailTest.php',
                'Magento/Rma/Test/Unit/Model/RmaRepositoryTest.php',
                'Magento/Rma/Test/Unit/Model/Status/HistoryRepositoryTest.php'
            ]
    ],
    'Magento\Framework\View\Element\UiComponent\ArrayObjectFactory' => [
        'warning_code' => 'ArrayObjectFactoryIsRestricted',
        'replacement' => 'Factory that creates custom class, extended from ArrayObject with overwritten '
            . 'serialize/unserialize methods',
        'exclude' => [
                'Magento/Ui/Model/Manager.php',
                'Magento/Ui/Test/Unit/Model/ManagerTest.php',
                'Magento/Framework/View/Element/UiComponent/Config/Provider/Component/Definition.php',
            ]
    ]
];
