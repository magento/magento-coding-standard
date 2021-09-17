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

    private const FROM_CONTENT = 1;
    private const FROM_NAME = 2;
    private const FROM_ATTRIBUTE = 3;

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

        $modules = $this->getValuesFromXml($xml, '//@module', self::FROM_ATTRIBUTE, 'module');
        $this->assertNonFactoryNameModule($phpcsFile, $modules);
    }

    /**
     * Check whether specified class names are right according PSR-1 Standard.
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
                    $element->lineNumber - 1,
                    self::ERROR_CODE_CONFIG,
                );
            }
        }
    }

    /**
     * Check whether specified class names in modules are right according PSR-1 Standard.
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
                    $element->lineNumber - 1,
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
        $classes = $this->getValuesFromXml(
            $xml,
            '
            /config//resource_adapter | /config/*[not(name()="sections")]//class[not(ancestor::observers)]
                | //model[not(parent::connection)] | //backend_model | //source_model | //price_model
                | //model_token | //writer_model | //clone_model | //frontend_model | //working_model
                | //admin_renderer | //renderer',
            self::FROM_CONTENT
        );
        $classes = array_merge(
            $classes,
            $this->getValuesFromXml(
                $xml,
                '//@backend_model',
                self::FROM_ATTRIBUTE,
                'backend_model'
            )
        );
        $classes = array_merge(
            $classes,
            $this->getValuesFromXml(
                $xml,
                '/config//preference',
                self::FROM_ATTRIBUTE,
                'type'
            )
        );
        $classes = array_merge(
            $classes,
            $this->getValuesFromXml(
                $xml,
                '/logging/*/expected_models/* | /logging/*/actions/*/expected_models/*',
                self::FROM_NAME
            )
        );

        $classes = array_map(
            function (ExtendedNode $extendedNode) {
                $extendedNode->value = explode('::', trim($extendedNode->value))[0];
                return $extendedNode;
            },
            $classes
        );

        return $classes;
    }

    /**
     * Extract value from the specified $extractFrom which exist in the XML path
     *
     * @param SimpleXMLElement $xml
     * @param string $xPath
     * @param int $extractFrom
     * @param string $attr
     * @return array
     */
    private function getValuesFromXml(SimpleXMLElement $xml, string $xPath, int $extractFrom, string $attr = ''): array
    {
        $nodes = $xml->xpath($xPath) ?: [];
        return array_map(function ($item) use ($extractFrom, $attr) {
            switch ($extractFrom) {
                case self::FROM_CONTENT:
                    return new ExtendedNode((string)$item, $item);
                case self::FROM_NAME:
                    return new ExtendedNode($item->getName(), $item);
                case self::FROM_ATTRIBUTE:
                    $nodeArray = (array)$item;
                    if (isset($nodeArray['@attributes'][$attr])) {
                        return new ExtendedNode($nodeArray['@attributes'][$attr], $item);
                    }
            }
        }, $nodes);
    }
}
