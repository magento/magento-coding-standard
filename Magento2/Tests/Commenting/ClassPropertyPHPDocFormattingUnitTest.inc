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
     * @var correctlyFormattedPublicClassMember
     *
     * Short Description
     */
    public $correctlyFormattedPublicClassMember;

    /**
     * @var correctlyFormattedPrivateClassMember
     *
     * Short Description
     */
    private $correctlyFormattedPrivateClassMember;

    /**
     * @var correctlyFormattedProtectedClassMember
     *
     * Short Description
     */
    protected $correctlyFormattedProtectedClassMember;
}
