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
     * @var variablehasAlreadyhaveProtectedClassMember
     *
     * Short Description
     */
    public $variablehasAlreadyhavePublicClassMember;

    /**
     * @var variablehasAlreadyhavePrivateClassMember
     *
     * Short Description
     */
    private $variablehasAlreadyhavePrivateClassMember;

    /**
     * @var variablehasAlreadyhaveProtectedClassMember
     *
     * Short Description
     */
    protected $variablehasAlreadyhaveProtectedClassMember;
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
