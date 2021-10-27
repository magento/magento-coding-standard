<?php

class Foo
{
    /**
     * @var Foo
     */
    private $_classAttribute = '';

    /**
     * Foo
     */
    public $_withoutClassAttribute = '';

    /**
     * @var Test
     *
     * Short Description
     */
    protected $_classAttributeWithShortDescription = '';

    /**
     * @var
     */
    private $_emptyClassAttributeContent = '';


    /**
     * @var Foo
     * @var Bar
     */
    private $_multipleClassAttribute = '';

    private $_missingDocBlockClassAttribute = '';
}

class Bar {

    /**
     * @var variableHasAlreadyHaveProtectedClassMember
     *
     * Short Description
     */
    public $variableHasAlreadyHavePublicClassMember;

    /**
     * @var variableHasAlreadyHavePrivateClassMember
     *
     * Short Description
     */
    private $variableHasAlreadyHavePrivateClassMember;

    /**
     * @var variableHasAlreadyHaveProtectedClassMember
     *
     * Short Description
     */
    protected $variableHasAlreadyHaveProtectedClassMember;

    /**
     * @var className
     *
     * Variable name
     */
    private $variableName;

    /**
     * Correctly Formatted Protected Class Member
     *
     * @var correctlyFormattedProtectedClassMember
     */
    protected $correctlyFormattedProtectedClassMember;

    /**
     * anotherCorrectlyFormattedProtectedClassMember
     *
     * @var anotherCorrectlyFormattedProtectedClassMember
     */
    protected $anotherCorrectlyFormattedProtectedClassMember;
}

class correctlyFormattedClassMemberDocBlock
{
    /**
     * @var correctlyFormattedPublicClassMember
     */
    public $correctlyFormattedPublicClassMember;

    /**
     * @var correctlyFormattedPrivateClassMember
     */
    private $correctlyFormattedPrivateClassMember;

    /**
     * @var correctlyFormattedProtectedClassMember
     */
    protected $correctlyFormattedProtectedClassMember;

    /**
     * @var Array|\Foo_BAR
     */
    protected $array;

    /**
     * @var \FOO\BAR\TEST\Class\\FooBarInterface|
     *      \FooObject_TEST_C
     */
    private $testObject;

    /**
     * Fallback factory
     *
     * @var RulePool
     */
    protected $rulePool;

    /**
     * @var \Magento\Store\Model\StoreManager
     */
    private \Magento\Store\Model\StoreManager $decoratedStoreManager;

    /*
     * @var \Magento\Eav\Model\Entity\Attribute\SetFactory
     */
    private $attributeSetFactory;

    /**
     * A description that includes test which is the same name as the variable is allowed
     *
     * @var test
     */
    protected $test;

    /**
     * @var string
     */
    protected string $test;
}
