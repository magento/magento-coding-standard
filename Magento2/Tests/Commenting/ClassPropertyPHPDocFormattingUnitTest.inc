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
}
