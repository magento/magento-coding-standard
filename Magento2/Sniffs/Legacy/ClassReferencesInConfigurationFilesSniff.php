<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento2\Sniffs\Legacy;

use DOMDocument;
use PHP_CodeSniffer\Sniffs\Sniff;
use PHP_CodeSniffer\Files\File;
use SimpleXMLElement;

class ClassReferencesInConfigurationFilesSniff implements Sniff
{
    private const ERROR_MESSAGE_CONFIG = 'Attribute does not follow expected format';
    private const ERROR_CODE_CONFIG = 'WrongXML';
    private const ERROR_MESSAGE_MODULE = 'Attribute does not follow expected format in module';
    private const ERROR_CODE_MODULE = 'WrongXMLModule';

    /**
     * @inheritdoc
     */
    public function register()
    {
        return [
            T_INLINE_HTML,
        ];
    }

    /**
     * @inheritdoc
     */
    public function process(File $phpcsFile, $stackPtr)
    {
        if ($stackPtr > 0) {
            return;
        }

        // We need to format the incoming XML to avoid tags split into several lines. In that case, PHP's DOMElement
        // returns the position of the closing /> as the position of the tag, and we need the position of <
        // instead, as it is the one we compare with $stackPtr later on.
        $xml = simplexml_load_string($this->getFormattedXML($phpcsFile));
        if ($xml === false) {
            $phpcsFile->addError(
                sprintf(
                    "Couldn't parse contents of '%s', check that they are in valid XML format",
                    $phpcsFile->getFilename(),
                ),
                $stackPtr,
                self::ERROR_CODE_CONFIG
            );
        }

        $classes = $this->collectClassesInConfig($xml);
        $this->assertNonFactoryName($phpcsFile, $classes);

        $modules = $this->getXmlAttributeValues($xml, '//@module', 'module');
        $this->assertNonFactoryNameModule($phpcsFile, $modules);
    }

    /**
     * Check whether specified classes or module names correspond to a file according PSR-1 Standard.
     *
     * @param File $phpcsFile
     * @param ExtendedNode[] $elements
     */
    private function assertNonFactoryName(File $phpcsFile, array $elements)
    {
        foreach ($elements as $element) {
            if (stripos($element->value, 'Magento') === false) {
                continue;
            }
            if (preg_match('/^([A-Z][a-z\d\\\\]+)+$/', $element->value) !== 1) {
                $phpcsFile->addError(
                    self::ERROR_MESSAGE_CONFIG,
                    $element->element->getLineNo() - 1,
                    self::ERROR_CODE_CONFIG,
                );
            }
        }
    }

    /**
     * Check whether specified classes or module names correspond to a file according PSR-1 Standard.
     *
     * @param File $phpcsFile
     * @param ExtendedNode[] $classes
     */
    private function assertNonFactoryNameModule(File $phpcsFile, array $classes)
    {
        foreach ($classes as $element) {
            if (preg_match('/^([A-Z][A-Za-z\d_]+)+$/', $element->value) !== 1) {
                $phpcsFile->addError(
                    self::ERROR_MESSAGE_MODULE,
                    $element->element->getLineNo() - 1,
                    self::ERROR_CODE_MODULE,
                );
            }
        }
    }

    /**
     * Format the incoming XML to avoid tags split into several lines.
     *
     * @param File $phpcsFile
     * @return false|string
     */
    private function getFormattedXML(File $phpcsFile)
    {
        $doc = new DomDocument('1.0');
        $doc->formatOutput = true;
        $doc->loadXML($phpcsFile->getTokensAsString(0, 999999));
        return $doc->saveXML();
    }

    /**
     * Parse an XML for references to PHP class names in selected tags or attributes
     *
     * @param SimpleXMLElement $xml
     * @return array
     */
    private function collectClassesInConfig(SimpleXMLElement $xml): array
    {
        $classes = $this->getXmlNode(
            $xml,
            '
            /config//resource_adapter | /config/*[not(name()="sections")]//class[not(ancestor::observers)]
                | //model[not(parent::connection)] | //backend_model | //source_model | //price_model
                | //model_token | //writer_model | //clone_model | //frontend_model | //working_model
                | //admin_renderer | //renderer'
        );
        $classes = array_merge($classes, $this->getXmlAttributeValues($xml, '//@backend_model', 'backend_model'));
        $classes = array_merge($classes, $this->getXmlAttributeValues($xml, '/config//preference', 'type'));
        $classes = array_merge(
            $classes,
            $this->getXmlNodeNames(
                $xml,
                '/logging/*/expected_models/* | /logging/*/actions/*/expected_models/*'
            )
        );

        $classes = array_map(
            function (ExtendedNode $extendedNode) {
                $extendedNode->value = explode('::', trim($extendedNode->value))[0];
                return $extendedNode;
            },
            $classes
        );
        $classes = array_filter(
            $classes,
            function ($value) {
                return !empty($value);
            }
        );

        return $classes;
    }

    /**
     * Get XML node text values using specified xPath
     *
     * The node must contain specified attribute
     *
     * @param SimpleXMLElement $xml
     * @param string $xPath
     * @return array
     */
    private function getXmlNode(SimpleXMLElement $xml, string $xPath): array
    {
        $result = [];
        $nodes = $xml->xpath($xPath) ?: [];
        foreach ($nodes as $node) {
            $result[] = new ExtendedNode((string)$node, $node);
        }
        return $result;
    }

    /**
     * Get XML node names using specified xPath
     *
     * @param SimpleXMLElement $xml
     * @param string $xpath
     * @return array
     */
    private function getXmlNodeNames(SimpleXMLElement $xml, string $xpath): array
    {
        $result = [];
        $nodes = $xml->xpath($xpath) ?: [];
        foreach ($nodes as $node) {
            $result[] = new ExtendedNode($node->getName(), $node);
        }
        return $result;
    }

    /**
     * Get XML node attribute values using specified xPath
     *
     * @param SimpleXMLElement $xml
     * @param string $xPath
     * @param string $attributeName
     * @return array
     */
    private function getXmlAttributeValues(SimpleXMLElement $xml, string $xPath, string $attributeName): array
    {
        $result = [];
        $nodes = $xml->xpath($xPath) ?: [];
        foreach ($nodes as $node) {
            $nodeArray = (array)$node;
            if (isset($nodeArray['@attributes'][$attributeName])) {
                $result[] = new ExtendedNode($nodeArray['@attributes'][$attributeName], $node);
            }
        }
        return $result;
    }
}
