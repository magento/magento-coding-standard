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
    'Zend_Json' => [
        'warning_code' => 'ZendJsonIsRestricted',
        'replacement' => 'Magento\Framework\Serialize\Serializer\Json',
        'exclude' => []
    ],
    'Zend_Json_Exception' => [
        'warning_code' => 'ZendJsonIsRestricted',
        'replacement' => '\InvalidArgumentException',
        'exclude' => []
    ],
    'Zend_Acl' => [
        'warning_code' => 'ZendAclIsRestricted',
        'replacement' => 'Laminas\Permissions\Acl\Acl',
        'exclude' => []
    ],
    'Zend_Acl_Role' => [
        'warning_code' => 'ZendAclIsRestricted',
        'replacement' => 'Laminas\Permissions\Acl\Role\GenericRole',
        'exclude' => []
    ],
    'Zend_Acl_Resource' => [
        'warning_code' => 'ZendAclIsRestricted',
        'replacement' => 'Laminas\Permissions\Acl\Resource\GenericResource',
        'exclude' => []
    ],
    'Zend_Acl_Role_Registry' => [
        'warning_code' => 'ZendAclIsRestricted',
        'replacement' => 'Laminas\Permissions\Acl\Role\Registry',
        'exclude' => []
    ],
    'Zend_Acl_Role_Registry_Exception' => [
        'warning_code' => 'ZendAclIsRestricted',
        'replacement' => 'Laminas\Permissions\Acl\Exception\InvalidArgumentException',
        'exclude' => []
    ],
    'Zend_Acl_Exception' => [
        'warning_code' => 'ZendAclIsRestricted',
        'replacement' => 'Laminas\Permissions\Acl\Exception\InvalidArgumentException',
        'exclude' => []
    ],
    'Zend_Acl_Role_Interface' => [
        'warning_code' => 'ZendAclIsRestricted',
        'replacement' => 'Laminas\Permissions\Acl\Role\RoleInterface',
        'exclude' => []
    ],
    'Zend_Currency' => [
        'warning_code' => 'ZendAclIsRestricted',
        'replacement' => 'Magento\Framework\Currency\Data\Currency',
        'exclude' => []
    ],
    'Zend_Currency_Exception' => [
        'warning_code' => 'ZendCurrencyIsRestricted',
        'replacement' => 'Magento\Framework\Currency\Exception\CurrencyException',
        'exclude' => []
    ],
    'Zend_Oauth_Http_Utility' => [
        'warning_code' => 'ZendOauthIsRestricted',
        'replacement' => 'Laminas\OAuth\Http\Utility',
        'exclude' => []
    ],
    'Zend_Measure_Weight' => [
        'warning_code' => 'ZendMeasureIsRestricted',
        'replacement' => 'Magento\Framework\Measure\Weight',
        'exclude' => []
    ],
    'Zend_Measure_Length' => [
        'warning_code' => 'ZendMeasureIsRestricted',
        'replacement' => 'Magento\Framework\Measure\Length',
        'exclude' => []
    ],
    'Zend_Validate' => [
        'warning_code' => 'ZendValidateIsRestricted',
        'replacement' => 'Magento\Framework\Validator\ValidatorChain',
        'exclude' => []
    ],
    'Zend_Validate_Regex' => [
        'warning_code' => 'ZendValidateIsRestricted',
        'replacement' => 'Laminas\Validator\Regex',
        'exclude' => []
    ],
    'Zend_Validate_Interface' => [
        'warning_code' => 'ZendValidateIsRestricted',
        'replacement' => 'Laminas\Validator\ValidatorInterface',
        'exclude' => []
    ],
    'Zend_Validate_EmailAddress' => [
        'warning_code' => 'ZendValidateIsRestricted',
        'replacement' => 'Magento\Framework\Validator\EmailAddress',
        'exclude' => []
    ],
    'Zend_Validate_StringLength' => [
        'warning_code' => 'ZendValidateIsRestricted',
        'replacement' => 'Magento\Framework\Validator\StringLength',
        'exclude' => []
    ],
    'Zend_Validate_Exception' => [
        'warning_code' => 'ZendValidateIsRestricted',
        'replacement' => 'Magento\Framework\Validator\ValidateException',
        'exclude' => []
    ],
    'Zend_Validate_File_ExcludeExtension' => [
        'warning_code' => 'ZendValidateIsRestricted',
        'replacement' => 'Laminas\Validator\File\ExcludeExtension',
        'exclude' => []
    ],
    'Zend_Validate_File_Extension' => [
        'warning_code' => 'ZendValidateIsRestricted',
        'replacement' => 'Laminas\Validator\File\Extension',
        'exclude' => []
    ],
    'Zend_Validate_File_ImageSize' => [
        'warning_code' => 'ZendValidateIsRestricted',
        'replacement' => 'Laminas\Validator\File\ImageSize',
        'exclude' => []
    ],
    'Zend_Validate_File_FilesSize' => [
        'warning_code' => 'ZendValidateIsRestricted',
        'replacement' => 'Laminas\Validator\File\FilesSize',
        'exclude' => []
    ],
    'Zend_Validate_Alnum' => [
        'warning_code' => 'ZendValidateIsRestricted',
        'replacement' => 'Magento\Framework\Validator\Alnum',
        'exclude' => []
    ],
    'Zend_Validate_Hostname' => [
        'warning_code' => 'ZendValidateIsRestricted',
        'replacement' => 'Magento\Framework\Validator\Hostname',
        'exclude' => []
    ],
    'Zend_Validate_Date' => [
        'warning_code' => 'ZendValidateIsRestricted',
        'replacement' => 'Laminas\Validator\Date',
        'exclude' => []
    ],
    'Zend_Validate_Digits' => [
        'warning_code' => 'ZendValidateIsRestricted',
        'replacement' => 'Laminas\Validator\Digits',
        'exclude' => []
    ],
    'Zend_Validate_Alpha' => [
        'warning_code' => 'ZendValidateIsRestricted',
        'replacement' => 'Laminas\I18n\Validator\Alpha',
        'exclude' => []
    ],
    'Zend_Validate_InArray' => [
        'warning_code' => 'ZendValidateIsRestricted',
        'replacement' => 'Laminas\Validator\InArray',
        'exclude' => []
    ],
    'Zend_Validate_Abstract' => [
        'warning_code' => 'ZendValidateIsRestricted',
        'replacement' => 'Laminas\Validator\AbstractValidator',
        'exclude' => []
    ],
    'Zend_Validate_NotEmpty' => [
        'warning_code' => 'ZendValidateIsRestricted',
        'replacement' => 'Magento\Framework\Validator\NotEmpty',
        'exclude' => []
    ],
    'Zend_Validate_Callback' => [
        'warning_code' => 'ZendValidateIsRestricted',
        'replacement' => 'Laminas\Validator\Callback',
        'exclude' => []
    ],
    'Zend_Validate_Ip' => [
        'warning_code' => 'ZendValidateIsRestricted',
        'replacement' => 'Laminas\Validator\Ip',
        'exclude' => []
    ],
    'Zend_Validate_Identical' => [
        'warning_code' => 'ZendValidateIsRestricted',
        'replacement' => 'Laminas\Validator\Identical',
        'exclude' => []
    ],
    'Zend_Validate_File_IsImage' => [
        'warning_code' => 'ZendValidateIsRestricted',
        'replacement' => 'Laminas\Validator\File\IsImage',
        'exclude' => []
    ],
    'Zend_Validate_File_Size' => [
        'warning_code' => 'ZendValidateIsRestricted',
        'replacement' => 'Laminas\Validator\File\FilesSize',
        'exclude' => []
    ],
    'Zend_Validate_Float' => [
        'warning_code' => 'ZendValidateIsRestricted',
        'replacement' => 'Laminas\I18n\Validator\IsFloat',
        'exclude' => []
    ],
    'Zend_Validate_Int' => [
        'warning_code' => 'ZendValidateIsRestricted',
        'replacement' => 'Laminas\I18n\Validator\IsInt',
        'exclude' => []
    ],
    'Magento\Framework\HTTP\ZendClient' => [
        'warning_code' => 'HttpZendClientIsRestricted',
        'replacement' => 'Magento\Framework\HTTP\LaminasClient',
        'exclude' => []
    ],
    'Magento\Framework\HTTP\ZendClientFactory' => [
        'warning_code' => 'HttpZendClientFactoryIsRestricted',
        'replacement' => 'Magento\Framework\HTTP\LaminasClientFactory',
        'exclude' => []
    ],
    'Zend_Http_Client' => [
        'warning_code' => 'ZendHttpIsRestricted',
        'replacement' => 'Laminas\Http\Request',
        'exclude' => []
    ],
    'Zend_Http_Response' => [
        'warning_code' => 'ZendHttpIsRestricted',
        'replacement' => 'Laminas\Http\Response',
        'exclude' => []
    ],
    'Zend_Http_Exception' => [
        'warning_code' => 'ZendHttpIsRestricted',
        'replacement' => 'Laminas\Http\Exception\RuntimeException',
        'exclude' => []
    ],
    'Zend_Http_Client_Exception' => [
        'warning_code' => 'ZendHttpIsRestricted',
        'replacement' => 'Laminas\Http\Exception\RuntimeException',
        'exclude' => []
    ],
    'Zend_Http_Client_Adapter_Interface' => [
        'warning_code' => 'ZendHttpIsRestricted',
        'replacement' => 'Laminas\Http\Client\Adapter\AdapterInterface',
        'exclude' => []
    ],
    'Zend_Filter_File_Rename' => [
        'warning_code' => 'ZendFilterIsRestricted',
        'replacement' => 'Laminas\Filter\File\Rename',
        'exclude' => []
    ],
    'Zend_Filter' => [
        'warning_code' => 'ZendFilterIsRestricted',
        'replacement' => 'Magento\Framework\Filter\FilterInput',
        'exclude' => []
    ],
    'Zend_Filter_Input' => [
        'warning_code' => 'ZendFilterIsRestricted',
        'replacement' => 'Magento\Framework\Filter\FilterInput',
        'exclude' => []
    ],
    'Zend_Filter_Interface' => [
        'warning_code' => 'ZendFilterIsRestricted',
        'replacement' => 'Laminas\Filter\FilterInterface',
        'exclude' => []
    ],
    'Zend_Filter_LocalizedToNormalized' => [
        'warning_code' => 'ZendFilterIsRestricted',
        'replacement' => 'Magento\Framework\Filter\LocalizedToNormalized',
        'exclude' => []
    ],
    'Zend_Filter_Decrypt' => [
        'warning_code' => 'ZendFilterIsRestricted',
        'replacement' => 'Laminas\Filter\Decrypt',
        'exclude' => []
    ],
    'Zend_Filter_Encrypt' => [
        'warning_code' => 'ZendFilterIsRestricted',
        'replacement' => 'Laminas\Filter\Encrypt',
        'exclude' => []
    ],
    'Zend_Filter_Encrypt_Interface' => [
        'warning_code' => 'ZendFilterIsRestricted',
        'replacement' => 'Laminas\Filter\Encrypt\EncryptionAlgorithmInterface',
        'exclude' => []
    ],
    'Zend_Filter_Alnum' => [
        'warning_code' => 'ZendFilterIsRestricted',
        'replacement' => 'Laminas\I18n\Filter\Alnum',
        'exclude' => []
    ],
    'Zend_Translate_Adapter' => [
        'warning_code' => 'ZendTranslateIsRestricted',
        'replacement' => 'Laminas\I18n\View\Helper\AbstractTranslatorHelper',
        'exclude' => []
    ],
    'Zend_File_Transfer_Exception' => [
        'warning_code' => 'ZendFileIsRestricted',
        'replacement' => 'Laminas\File\Transfer\Exception\PhpEnvironmentException',
        'exclude' => []
    ],
    'Zend_File_Transfer_Adapter_Http' => [
        'warning_code' => 'ZendFileIsRestricted',
        'replacement' => 'Magento\Framework\File\Http',
        'exclude' => []
    ],
    'Zend_File_Transfer' => [
        'warning_code' => 'ZendFileIsRestricted',
        'replacement' => 'Laminas\File\Transfer\Transfer',
        'exclude' => []
    ],
    'Zend_Date' => [
        'warning_code' => 'ZendDateIsRestricted',
        'replacement' => '\IntlDateFormatter',
        'exclude' => []
    ],
    'Zend_Locale_Format' => [
        'warning_code' => 'ZendLocaleFormatIsRestricted',
        'replacement' => 'Laminas\I18n\Filter\NumberParse, \NumberFormatter, \IntlDateFormatter',
        'exclude' => []
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
    ],
    'GraphQL\Language\Parser' => [
        'warning_code' => 'GraphQLLanguageParserIsRestricted',
        'replacement' => 'Magento\Framework\GraphQl\Query\QueryParser',
        'exclude' => []
    ]
];
