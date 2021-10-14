<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types = 1);

namespace Magento2\Sniffs\Legacy;

use DOMDocument;
use PHP_CodeSniffer\Sniffs\Sniff;
use PHP_CodeSniffer\Files\File;
use SimpleXMLElement;

class ClassReferencesInConfigurationFilesSniff implements Sniff
{
    private const ERROR_MESSAGE_CONFIG = 'Incorrect format of PHP class reference';
    private const ERROR_CODE_CONFIG = 'IncorrectClassReference';
    private const ERROR_MESSAGE_MODULE = 'Incorrect format of module reference';
    private const ERROR_CODE_MODULE = 'IncorrectModuleReference';

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

        $modules = $this->getValuesFromXmlTagAttribute($xml, '//@module', 'module');
        $this->assertNonFactoryNameModule($phpcsFile, $modules);
    }

    /**
     * Check whether specified class names are right according PSR-1 Standard.
     *
     * @param File $phpcsFile
     * @param array $elements
     */
    private function assertNonFactoryName(File $phpcsFile, array $elements)
    {
        foreach ($elements as $element) {
            if (stripos($element['value'], 'Magento') === false) {
                continue;
            }
            if (preg_match('/^([A-Z][a-z\d\\\\]+)+$/', $element['value']) !== 1) {
                $phpcsFile->addError(
                    self::ERROR_MESSAGE_CONFIG,
                    $element['lineNumber'],
                    self::ERROR_CODE_CONFIG,
                );
            }
        }
    }

    /**
     * Check whether specified class names in modules are right according PSR-1 Standard.
     *
     * @param File $phpcsFile
     * @param array $classes
     */
    private function assertNonFactoryNameModule(File $phpcsFile, array $classes)
    {
        foreach ($classes as $element) {
            if (preg_match('/^([A-Z][A-Za-z\d_]+)+$/', $element['value']) !== 1) {
                $phpcsFile->addError(
                    self::ERROR_MESSAGE_MODULE,
                    $element['lineNumber'],
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
        $doc->loadXML($phpcsFile->getTokensAsString(0, count($phpcsFile->getTokens())));
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
        $classes = $this->getValuesFromXmlTagContent(
            $xml,
            '
            /config//resource_adapter | /config/*[not(name()="sections")]//class[not(ancestor::observers)]
                | //model[not(parent::connection)] | //backend_model | //source_model | //price_model
                | //model_token | //writer_model | //clone_model | //frontend_model | //working_model
                | //admin_renderer | //renderer',
        );

        $classes = array_merge(
            $classes,
            $this->getValuesFromXmlTagAttribute(
                $xml,
                '//@backend_model',
                'backend_model'
            ),
            $this->getValuesFromXmlTagAttribute(
                $xml,
                '/config//preference',
                'type'
            ),
            $this->getValuesFromXmlTagName(
                $xml,
                '/logging/*/expected_models/* | /logging/*/actions/*/expected_models/*',
            )
        );

        $classes = array_map(
            function (array $extendedNode) {
                $extendedNode['value'] = explode('::', trim($extendedNode['value']))[0];
                return $extendedNode;
            },
            $classes
        );

        return $classes;
    }

    /**
     * Extract value from tag contents which exist in the XML path
     *
     * @param SimpleXMLElement $xml
     * @param string $xPath
     * @return array
     */
    private function getValuesFromXmlTagContent(SimpleXMLElement $xml, string $xPath): array
    {
        $nodes = $xml->xpath($xPath) ?: [];
        return array_map(function ($item) {
            return [
                'value' => (string)$item,
                'lineNumber' => dom_import_simplexml($item)->getLineNo()-1,
            ];
        }, $nodes);
    }

    /**
     * Extract value from tag names which exist in the XML path
     *
     * @param SimpleXMLElement $xml
     * @param string $xPath
     * @return array
     */
    private function getValuesFromXmlTagName(SimpleXMLElement $xml, string $xPath): array
    {
        $nodes = $xml->xpath($xPath) ?: [];
        return array_map(function ($item) {
            return [
                'value' => $item->getName(),
                'lineNumber' => dom_import_simplexml($item)->getLineNo()-1,
            ];
        }, $nodes);
    }

    /**
     * Extract value from tag attributes which exist in the XML path
     *
     * @param SimpleXMLElement $xml
     * @param string $xPath
     * @param string $attr
     * @return array
     */
    private function getValuesFromXmlTagAttribute(SimpleXMLElement $xml, string $xPath, string $attr): array
    {
        $nodes = $xml->xpath($xPath) ?: [];
        return array_map(function ($item) use ($attr) {
            $nodeArray = (array)$item;
            if (isset($nodeArray['@attributes'][$attr])) {
                return [
                    'value' => $nodeArray['@attributes'][$attr],
                    'lineNumber' => dom_import_simplexml($item)->getLineNo()-1,
                ];
            }
        }, $nodes);
    }
}
