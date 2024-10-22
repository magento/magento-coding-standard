<?php
/**
* This is the summary for a DocBlock.
*
* This is the description for a DocBlock. This text may contain
* multiple lines and even some _markdown_.
* * Markdown style lists function too
* * Just try this out once
* The section after the description contains the tags; which provide
* structured meta-data concerning the given element.
*
* @param int $example  This is an example function/method parameter description.
* @param string $example2 This is a second example.
*
*/
public function getProductListDefaultSortBy2($example, $example2)
{
return $example === $example2;
}

public function setExtensionAs(\Magento\Catalog\Api\Data\CategoryExtensionInterface $extensionAttributes)
{
    return $this->_setExtensionAttributes($extensionAttributes);
}

/**
 * Short description of method
 *
 * @param int
 * @return int
 */
public function invalidDocBlockShouldNotCauseFatalErrorInSniff(int $number): int
{
    return $number;
}

/**
 * Short description.
 *
 * @param string $text
 * @return string
 */
#[\ReturnTypeWillChange]
public function methodWithAttributeAndValidDocblockWithTypes(string $text): string
{
    return $text;
}

/**
 * Short description.
 *
 * @param string $text
 * @return string
 */
#[\ReturnTypeWillChange]
public function methodWithAttributeAndValidDocblockWithoutTypes()
{
    return $text;
}

#[\ReturnTypeWillChange]
public function methodWithAttributeAndWithoutDocblockWithTypes(string $text): string
{
    return $text;
}

#[\ReturnTypeWillChange]
public function methodWithAttributeAndWithoutDocblockWithoutTypes($text)
{
    return $text;
}

public function methodWithoutDockblockWithParameterTypeWithoutReturnType(string $text)
{
    return $text;
}

public function methodWithoutDockblockWithoutParameterTypeWithReturnType($text) : string
{
    return $text;
}

/**
 * Short description.
 *
 * @param string $text
 * @return string
 */
public function methodWithDockblockWithParameterTypeWithoutReturnType(string $text)
{
    return $text;
}

/**
 * Short description.
 *
 * @param mixed $text
 * @return string
 */
public function methodWithDockblockWithoutParameterTypeWithReturnType($text) : string
{
    return $text;
}
