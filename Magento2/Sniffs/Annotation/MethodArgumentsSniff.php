<?php

/**
 * Copyright 2021 Adobe
 * All Rights Reserved.
 */

declare(strict_types=1);

namespace Magento2\Sniffs\Annotation;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

/**
 * Sniff to validate method arguments annotations
 */
class MethodArgumentsSniff implements Sniff
{
    /**
     * @var array
     */
    private $validTokensBeforeClosingCommentTag = [
        'T_WHITESPACE',
        'T_PUBLIC',
        'T_PRIVATE',
        'T_PROTECTED',
        'T_STATIC',
        'T_ABSTRACT',
        'T_FINAL'
    ];

    /**
     * @var array
     */
    private $invalidTypes = [
        'null',
        'false',
        'true',
        'self'
    ];

    /**
     * @inheritdoc
     */
    public function register(): array
    {
        return [
            T_FUNCTION
        ];
    }

    /**
     * Validates whether valid token exists before closing comment tag
     *
     * @param string $type
     *
     * @return bool
     */
    private function isTokenBeforeClosingCommentTagValid(string $type): bool
    {
        return in_array($type, $this->validTokensBeforeClosingCommentTag);
    }

    /**
     * Validates whether comment block exists
     *
     * @param File $phpcsFile
     * @param int $previousCommentClosePtr
     * @param int $stackPtr
     *
     * @return bool
     */
    private function validateCommentBlockExists(File $phpcsFile, int $previousCommentClosePtr, int $stackPtr): bool
    {
        $tokens = $phpcsFile->getTokens();
        $attributeFlag = false;
        for ($tempPtr = $previousCommentClosePtr + 1; $tempPtr < $stackPtr; $tempPtr++) {
            $tokenCode = $tokens[$tempPtr]['code'];

            // Ignore attributes e.g. #[\ReturnTypeWillChange]
            if ($tokenCode === T_ATTRIBUTE_END) {
                $attributeFlag = false;
                continue;
            }
            if ($attributeFlag) {
                continue;
            }

            if ($tokenCode === T_ATTRIBUTE) {
                $attributeFlag = true;
                continue;
            }

            if (!$this->isTokenBeforeClosingCommentTagValid($tokens[$tempPtr]['type'])) {
                return false;
            }
        }

        return true;
    }

    /**
     * Checks whether the parameter type is invalid
     *
     * @param string $type
     *
     * @return bool
     */
    private function isInvalidType(string $type): bool
    {
        return in_array(strtolower($type), $this->invalidTypes);
    }

    /**
     * Get arguments from method signature
     *
     * @param File $phpcsFile
     * @param int $openParenthesisPtr
     * @param int $closedParenthesisPtr
     *
     * @return array
     */
    private function getMethodArguments(File $phpcsFile, int $openParenthesisPtr, int $closedParenthesisPtr): array
    {
        $tokens = $phpcsFile->getTokens();
        $methodArguments = [];
        for ($i = $openParenthesisPtr; $i < $closedParenthesisPtr; $i++) {
            $argumentsPtr = $phpcsFile->findNext(T_VARIABLE, $i + 1, $closedParenthesisPtr);
            if ($argumentsPtr === false) {
                break;
            } elseif ($argumentsPtr < $closedParenthesisPtr) {
                $arguments = $tokens[$argumentsPtr]['content'];
                $methodArguments[] = $arguments;
                $i = $argumentsPtr - 1;
            }
        }

        return $methodArguments;
    }

    /**
     * Get parameters from method annotation
     *
     * @param array $paramDefinitions
     *
     * @return array
     */
    private function getMethodParameters(array $paramDefinitions): array
    {
        $paramName = [];
        foreach ($paramDefinitions as $paramDefinition) {
            if (isset($paramDefinition['paramName'])) {
                $paramName[] = $paramDefinition['paramName'];
            }
        }

        return $paramName;
    }

    /**
     * Validates whether @inheritdoc without braces [@inheritdoc] exists or not
     *
     * @param File $phpcsFile
     * @param int $previousCommentOpenPtr
     * @param int $previousCommentClosePtr
     */
    private function validateInheritdocAnnotationWithoutBracesExists(
        File $phpcsFile,
        int $previousCommentOpenPtr,
        int $previousCommentClosePtr
    ): bool {
        return $this->validateInheritdocAnnotationExists(
            $phpcsFile,
            $previousCommentOpenPtr,
            $previousCommentClosePtr,
            '@inheritdoc'
        );
    }

    /**
     * Validates whether @inheritdoc with braces [{@inheritdoc}] exists or not
     *
     * @param File $phpcsFile
     * @param int $previousCommentOpenPtr
     * @param int $previousCommentClosePtr
     */
    private function validateInheritdocAnnotationWithBracesExists(
        File $phpcsFile,
        int $previousCommentOpenPtr,
        int $previousCommentClosePtr
    ): bool {
        return $this->validateInheritdocAnnotationExists(
            $phpcsFile,
            $previousCommentOpenPtr,
            $previousCommentClosePtr,
            '{@inheritdoc}'
        );
    }

    /**
     * Validates inheritdoc annotation exists
     *
     * @param File $phpcsFile
     * @param int $previousCommentOpenPtr
     * @param int $previousCommentClosePtr
     * @param string $inheritdocAnnotation
     *
     * @return bool
     */
    private function validateInheritdocAnnotationExists(
        File $phpcsFile,
        int $previousCommentOpenPtr,
        int $previousCommentClosePtr,
        string $inheritdocAnnotation
    ): bool {
        $tokens = $phpcsFile->getTokens();
        for ($ptr = $previousCommentOpenPtr; $ptr < $previousCommentClosePtr; $ptr++) {
            if (strtolower($tokens[$ptr]['content']) === $inheritdocAnnotation) {
                return true;
            }
        }

        return false;
    }

    /**
     * Validates if annotation exists for parameter in method annotation
     *
     * @param File $phpcsFile
     * @param int $argumentsCount
     * @param int $parametersCount
     * @param int $previousCommentOpenPtr
     * @param int $previousCommentClosePtr
     * @param int $stackPtr
     */
    private function validateParameterAnnotationForArgumentExists(
        File $phpcsFile,
        int $argumentsCount,
        int $parametersCount,
        int $previousCommentOpenPtr,
        int $previousCommentClosePtr,
        int $stackPtr
    ): void {
        if ($argumentsCount > 0 && $parametersCount === 0) {
            $inheritdocAnnotationWithoutBracesExists = $this->validateInheritdocAnnotationWithoutBracesExists(
                $phpcsFile,
                $previousCommentOpenPtr,
                $previousCommentClosePtr
            );
            $inheritdocAnnotationWithBracesExists = $this->validateInheritdocAnnotationWithBracesExists(
                $phpcsFile,
                $previousCommentOpenPtr,
                $previousCommentClosePtr
            );
            if ($inheritdocAnnotationWithBracesExists) {
                $phpcsFile->addError(
                    '{@inheritdoc} does not import parameter annotation',
                    $stackPtr,
                    'InheritDoc'
                );
            } elseif ($this->validateCommentBlockExists($phpcsFile, $previousCommentClosePtr, $stackPtr)
                && !$inheritdocAnnotationWithoutBracesExists
            ) {
                $phpcsFile->addError(
                    'Missing @param for argument in method annotation',
                    $stackPtr,
                    'ParamMissing'
                );
            }
        }
    }

    /**
     * Validates whether comment block have extra the parameters listed in method annotation
     *
     * @param File $phpcsFile
     * @param int $argumentsCount
     * @param int $parametersCount
     * @param int $stackPtr
     */
    private function validateCommentBlockDoesnotHaveExtraParameterAnnotation(
        File $phpcsFile,
        int $argumentsCount,
        int $parametersCount,
        int $stackPtr
    ): void {
        if ($argumentsCount < $parametersCount && $argumentsCount > 0) {
            $phpcsFile->addError(
                'Extra @param found in method annotation',
                $stackPtr,
                'ExtraParam'
            );
        } elseif ($argumentsCount > 0 && $argumentsCount != $parametersCount && $parametersCount != 0) {
            $phpcsFile->addError(
                '@param is not found for one or more params in method annotation',
                $stackPtr,
                'ParamMissing'
            );
        }
    }

    /**
     * Validates whether the argument name exists in method parameter annotation
     *
     * @param int $stackPtr
     * @param int $ptr
     * @param File $phpcsFile
     * @param array $methodArguments
     * @param array $paramDefinitions
     */
    private function validateArgumentNameInParameterAnnotationExists(
        int $stackPtr,
        int $ptr,
        File $phpcsFile,
        array $methodArguments,
        array $paramDefinitions
    ): void {
        $parameterNames = $this->getMethodParameters($paramDefinitions);
        if (!in_array($methodArguments[$ptr], $parameterNames)) {
            $error = $methodArguments[$ptr] . ' parameter is missing in method annotation';
            $phpcsFile->addError($error, $stackPtr, 'ArgumentMissing');
        }
    }

    /**
     * Validates whether parameter present in method signature
     *
     * @param int $ptr
     * @param int $paramDefinitionsArguments
     * @param array $methodArguments
     * @param File $phpcsFile
     * @param array $paramPointers
     */
    private function validateParameterPresentInMethodSignature(
        int $ptr,
        string $paramDefinitionsArguments,
        array $methodArguments,
        File $phpcsFile,
        array $paramPointers
    ): void {
        if (!in_array($paramDefinitionsArguments, $methodArguments)) {
            $phpcsFile->addError(
                $paramDefinitionsArguments . ' parameter is missing in method arguments signature',
                $paramPointers[$ptr],
                'ArgumentMissing'
            );
        }
    }

    /**
     * Validates whether the parameters are in order or not in method annotation
     *
     * @param array $paramDefinitions
     * @param array $methodArguments
     * @param File $phpcsFile
     * @param array $paramPointers
     */
    private function validateParameterOrderIsCorrect(
        array $paramDefinitions,
        array $methodArguments,
        File $phpcsFile,
        array $paramPointers
    ): void {
        $parameterNames = $this->getMethodParameters($paramDefinitions);
        $paramDefinitionsCount = count($paramDefinitions);
        for ($ptr = 0; $ptr < $paramDefinitionsCount; $ptr++) {
            if (isset($methodArguments[$ptr]) && isset($parameterNames[$ptr])
                && in_array($methodArguments[$ptr], $parameterNames)
            ) {
                if ($methodArguments[$ptr] != $parameterNames[$ptr]) {
                    $phpcsFile->addError(
                        $methodArguments[$ptr] . ' parameter is not in order',
                        $paramPointers[$ptr],
                        'ParamOrder'
                    );
                }
            }
        }
    }

    /**
     * Validate whether duplicate annotation present in method annotation
     *
     * @param int $stackPtr
     * @param array $paramDefinitions
     * @param array $paramPointers
     * @param File $phpcsFile
     * @param array $methodArguments
     */
    private function validateDuplicateAnnotationDoesnotExists(
        int $stackPtr,
        array $paramDefinitions,
        array $paramPointers,
        File $phpcsFile,
        array $methodArguments
    ): void {
        $argumentsCount = count($methodArguments);
        $parametersCount = count($paramPointers);
        if ($argumentsCount <= $parametersCount && $argumentsCount > 0) {
            $duplicateParameters = [];
            foreach ($paramDefinitions as $i => $paramDefinition) {
                if (isset($paramDefinition['paramName'])) {
                    $parameterContent = $paramDefinition['paramName'];
                    foreach (array_slice($paramDefinitions, $i + 1) as $nextParamDefinition) {
                        if (isset($nextParamDefinition['paramName'])
                            && $parameterContent === $nextParamDefinition['paramName']
                        ) {
                            $duplicateParameters[] = $parameterContent;
                        }
                    }
                }
            }

            foreach ($duplicateParameters as $value) {
                $phpcsFile->addError(
                    $value . ' duplicate found in method annotation',
                    $stackPtr,
                    'DuplicateParam'
                );
            }
        }
    }

    /**
     * Validate parameter annotation format is correct or not
     *
     * @param int $ptr
     * @param File $phpcsFile
     * @param array $methodArguments
     * @param array $paramDefinitions
     * @param array $paramPointers
     */
    private function validateParameterAnnotationFormatIsCorrect(
        int $ptr,
        File $phpcsFile,
        array $methodArguments,
        array $paramDefinitions,
        array $paramPointers
    ): void {
        switch (count($paramDefinitions)) {
            case 0:
                $phpcsFile->addError(
                    'Missing both type and parameter',
                    $paramPointers[$ptr],
                    'Malformed'
                );
                break;
            case 1:
                if (preg_match('/^\$.*/', $paramDefinitions[0])) {
                    $phpcsFile->addError(
                        'Type is not specified',
                        $paramPointers[$ptr],
                        'NoTypeSpecified'
                    );
                }
                break;
            case 2:
                if ($this->isInvalidType($paramDefinitions[0])) {
                    $phpcsFile->addError(
                        $paramDefinitions[0] . ' is not a valid PHP type',
                        $paramPointers[$ptr],
                        'NotValidType'
                    );
                }

                $this->validateParameterPresentInMethodSignature(
                    $ptr,
                    ltrim($paramDefinitions[1], '&'),
                    $methodArguments,
                    $phpcsFile,
                    $paramPointers
                );
                break;
            default:
                if (preg_match('/^\$.*/', $paramDefinitions[0])) {
                    $phpcsFile->addError(
                        'Type is not specified',
                        $paramPointers[$ptr],
                        'NoTypeSpecified'
                    );
                    if ($this->isInvalidType($paramDefinitions[0])) {
                        $phpcsFile->addError(
                            $paramDefinitions[0] . ' is not a valid PHP type',
                            $paramPointers[$ptr],
                            'NotValidType'
                        );
                    }
                }
                break;
        }
    }

    /**
     * Validate method parameter annotations
     *
     * @param int $stackPtr
     * @param array $paramDefinitions
     * @param array $paramPointers
     * @param File $phpcsFile
     * @param array $methodArguments
     * @param int $previousCommentOpenPtr
     * @param int $previousCommentClosePtr
     *
     * @SuppressWarnings(PHPMD.UnusedLocalVariable)
     */
    private function validateMethodParameterAnnotations(
        int $stackPtr,
        array $paramDefinitions,
        array $paramPointers,
        File $phpcsFile,
        array $methodArguments,
        int $previousCommentOpenPtr,
        int $previousCommentClosePtr
    ): void {
        $argumentCount = count($methodArguments);
        $paramCount = count($paramPointers);
        $this->validateParameterAnnotationForArgumentExists(
            $phpcsFile,
            $argumentCount,
            $paramCount,
            $previousCommentOpenPtr,
            $previousCommentClosePtr,
            $stackPtr
        );
        $this->validateCommentBlockDoesnotHaveExtraParameterAnnotation(
            $phpcsFile,
            $argumentCount,
            $paramCount,
            $stackPtr
        );
        $this->validateDuplicateAnnotationDoesnotExists(
            $stackPtr,
            $paramDefinitions,
            $paramPointers,
            $phpcsFile,
            $methodArguments
        );
        $this->validateParameterOrderIsCorrect(
            $paramDefinitions,
            $methodArguments,
            $phpcsFile,
            $paramPointers
        );
        $this->validateFormattingConsistency(
            $paramDefinitions,
            $methodArguments,
            $phpcsFile,
            $paramPointers
        );
        $tokens = $phpcsFile->getTokens();

        foreach ($methodArguments as $ptr => $methodArgument) {
            if (isset($paramPointers[$ptr])) {
                $this->validateArgumentNameInParameterAnnotationExists(
                    $stackPtr,
                    $ptr,
                    $phpcsFile,
                    $methodArguments,
                    $paramDefinitions
                );
                $paramContent = $tokens[$paramPointers[$ptr] + 2]['content'];
                $paramContentExplode = explode(' ', $paramContent);
                $this->validateParameterAnnotationFormatIsCorrect(
                    $ptr,
                    $phpcsFile,
                    $methodArguments,
                    $paramContentExplode,
                    $paramPointers
                );
            }
        }
    }

    /**
     * @inheritdoc
     */
    public function process(File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();
        $numTokens = count($tokens);
        $previousCommentOpenPtr = $phpcsFile->findPrevious(T_DOC_COMMENT_OPEN_TAG, $stackPtr - 1, 0);
        $previousCommentClosePtr = $phpcsFile->findPrevious(T_DOC_COMMENT_CLOSE_TAG, $stackPtr - 1, 0);
        if ($previousCommentClosePtr && $previousCommentOpenPtr) {
            $methodName = $tokens[$stackPtr + 2]['content'];
            if ($methodName !== '__construct'
                && !$this->validateCommentBlockExists($phpcsFile, $previousCommentClosePtr, $stackPtr)
            ) {
                $phpcsFile->addError('Comment block is missing', $stackPtr, 'NoCommentBlock');
                return;
            }
        } else {
            return;
        }

        $openParenthesisPtr = $phpcsFile->findNext(T_OPEN_PARENTHESIS, $stackPtr + 1, $numTokens);
        $closedParenthesisPtr = $phpcsFile->findNext(T_CLOSE_PARENTHESIS, $stackPtr + 1, $numTokens);
        $methodArguments = $this->getMethodArguments($phpcsFile, $openParenthesisPtr, $closedParenthesisPtr);
        $paramPointers = $paramDefinitions = [];
        for ($tempPtr = $previousCommentOpenPtr; $tempPtr < $previousCommentClosePtr; $tempPtr++) {
            if (strtolower($tokens[$tempPtr]['content']) === '@param') {
                $paramPointers[] = $tempPtr;
                $content = preg_replace('/\s+/', ' ', $tokens[$tempPtr + 2]['content'], 2);
                $paramAnnotationParts = explode(' ', $content, 3);
                if (count($paramAnnotationParts) === 1) {
                    if ((preg_match('/^\$.*/', $paramAnnotationParts[0]))) {
                        $paramDefinitions[] = [
                            'type' => null,
                            'paramName' => rtrim(ltrim($tokens[$tempPtr + 2]['content'], '&'), ','),
                            'comment' => null
                        ];
                    } else {
                        $paramDefinitions[] = [
                            'type' => $tokens[$tempPtr + 2]['content'],
                            'paramName' => null,
                            'comment' => null
                        ];
                    }
                } else {
                    $paramDefinitions[] = [
                        'type' => $paramAnnotationParts[0],
                        'paramName' => rtrim(ltrim($paramAnnotationParts[1], '&'), ','),
                        'comment' => $paramAnnotationParts[2] ?? null,
                    ];
                }
            }
        }

        $this->validateMethodParameterAnnotations(
            $stackPtr,
            $paramDefinitions,
            $paramPointers,
            $phpcsFile,
            $methodArguments,
            $previousCommentOpenPtr,
            $previousCommentClosePtr
        );
    }

    /**
     * Validates function params format consistency.
     *
     * @param array $paramDefinitions
     * @param array $methodArguments
     * @param File $phpcsFile
     * @param array $paramPointers
     *
     * @see https://devdocs.magento.com/guides/v2.4/coding-standards/docblock-standard-general.html#format-consistency
     */
    private function validateFormattingConsistency(
        array $paramDefinitions,
        array $methodArguments,
        File $phpcsFile,
        array $paramPointers
    ): void {
        $argumentPositions = [];
        $commentPositions = [];
        $tokens = $phpcsFile->getTokens();
        foreach ($methodArguments as $ptr => $methodArgument) {
            if (isset($paramPointers[$ptr])) {
                $paramContent = $tokens[$paramPointers[$ptr] + 2]['content'];
                $paramDefinition = $paramDefinitions[$ptr];
                if (isset($paramDefinition['paramName'])) {
                    $argumentPositions[] = strpos($paramContent, $paramDefinition['paramName']);
                }

                $commentPositions[] = $paramDefinition['comment']
                    ? strrpos($paramContent, $paramDefinition['comment']) : null;
            }
        }

        if (!$this->allParamsAligned($argumentPositions, $commentPositions)
            && !$this->noneParamsAligned($argumentPositions, $commentPositions, $paramDefinitions)
        ) {
            $phpcsFile->addError(
                'Method arguments visual alignment must be consistent',
                $paramPointers[0],
                'VisualAlignment'
            );
        }
    }

    /**
     * Check all params are aligned.
     *
     * @param array $argumentPositions
     * @param array $commentPositions
     *
     * @return bool
     */
    private function allParamsAligned(array $argumentPositions, array $commentPositions): bool
    {
        return count(array_unique($argumentPositions)) === 1
            && count(array_unique(array_filter($commentPositions))) <= 1;
    }

    /**
     * Check none of params are aligned.
     *
     * @param array $argumentPositions
     * @param array $commentPositions
     * @param array $paramDefinitions
     *
     * @return bool
     */
    private function noneParamsAligned(array $argumentPositions, array $commentPositions, array $paramDefinitions): bool
    {
        $flag = true;
        foreach ($argumentPositions as $index => $argumentPosition) {
            $commentPosition = $commentPositions[$index];
            $type = $paramDefinitions[$index]['type'];
            if ($type === null) {
                continue;
            }

            $paramName = $paramDefinitions[$index]['paramName'];
            if (($argumentPosition !== strlen($type) + 1) ||
                (isset($commentPosition) && ($commentPosition !== $argumentPosition + strlen($paramName) + 1))
            ) {
                $flag = false;
                break;
            }
        }

        return $flag;
    }
}
