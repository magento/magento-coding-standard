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
    protected string $test1;

    /**
     * Ensure that nullable sign in the property type hint declaration is interpreted correctly
     *
     * @var string|null
     */
    protected ?string $test2;

    /**
     * @var string
     * @deprecated
     */
    protected string $badlyDeprecated;

    /**
     * @var string
     * @deprecated Why not
     */
    protected string $incorrectlyDeprecated;

    /**
     * @var string
     * @deprecated
     * @see
     */
    protected string $inaccurately;

    /**
     * @var string
     * @deprecated No reference specified
     * @see
     */
    protected string $mistakenly;

    /**
     * @var string
     * @deprecated No reference specified
     * @see Some reference
     */
    protected string $correctly;

    /**
     * @var string
     * @deprecated
     * @see Some other reference
     */
    protected string $alsoCorrect;

    /**
     * @var string
     * @see
     */
    protected string $shouldBeCorrect;

    /**
     * @var string
     * @see Message with some reference
     */
    protected string $itIsCorrect;

    /**
     * @var string
     * @deprecated This property will be removed in version 1.0.0 without replacement
     */
    protected string $deprecatedWithKeyword;

    /**
     * @var string
     */
    protected readonly string $readOnlyString;

    /**
     * @var int
     */
    protected readonly int $readOnlyInteger;
}
