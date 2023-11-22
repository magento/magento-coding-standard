<?php
/**
 * Copyright 2021 Adobe
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento2\Rector\Src;

use PhpParser\Node;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\Echo_;
use Rector\Core\Rector\AbstractRector;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

class AddHtmlEscaperToOutput extends AbstractRector
{

    private $_phpFunctionsToIgnore = ['\count','\strip_tags'];

    /**
     * @inheritDoc
     */
    public function getNodeTypes(): array
    {
        return [Echo_::class];
    }

    /**
     * @inheritDoc
     */
    public function refactor(Node $node): ?Node
    {

        $echoContent  = $node->exprs[0];

        if ($echoContent instanceof Node\Expr\Ternary) {

            if (!$this->hasNoEscapeAttribute($echoContent->if) && $this->canEscapeOutput($echoContent->if)) {
                $node->exprs[0]->if = new Node\Expr\MethodCall(
                    new Node\Expr\Variable('escaper'),
                    'escapeHtml',
                    [new Node\Arg($echoContent->if)]
                );

            }

            if (!$this->hasNoEscapeAttribute($echoContent->else) && $this->canEscapeOutput($echoContent->else)) {
                $node->exprs[0]->else = new Node\Expr\MethodCall(
                    new Node\Expr\Variable('escaper'),
                    'escapeHtml',
                    [new Node\Arg($echoContent->else)]
                );

            }
            return $node;

        }

        if ($this->hasNoEscapeAttribute($echoContent)) {
            return null;
        }

        if ($this->canEscapeOutput($echoContent)) {

            $node->exprs[0] = new Node\Expr\MethodCall(
                new Node\Expr\Variable('escaper'),
                'escapeHtml',
                [new Node\Arg($echoContent)]
            );
            return $node;
        }

        return null;
    }

    private function canEscapeOutput(Node $echoContent):bool
    {
        if ($echoContent instanceof  Node\Expr\Variable) {
            return true;
        }

        if ($echoContent instanceof Node\Expr\FuncCall
            && !$this->willFunctionReturnSafeOutput($echoContent)) {

            // if string passed to __() contains html don't do anthing
            if ($echoContent->name == '__' && $this->stringContainsHtml($echoContent->args[0]->value->value)) {
                return false;
            }

            return true;
        }

        // if the echo already has escapeHtml called on $block or escaper, don't do anthing
        if ($echoContent instanceof Node\Expr\MethodCall &&
            !$this->methodReturnsValidHtmlOrUrl($echoContent)
        ) {

            // if the method is part of secureRenderer don't do anything
            if ($echoContent->var->name === 'secureRenderer') {
                return false;
            }

            return true;

        }

        return false;
    }

    private function stringContainsHtml(string $str)
    {
        return strlen($str) !== strlen(strip_tags($str));
    }

    /**
     * If the developer has marked the output as noEscape by using the @noEscape
     * we want to leave that code as it is
     */
    private function hasNoEscapeAttribute(Node $echoContent):bool
    {

        $comments = $echoContent->getComments();
        foreach ($comments as $comment) {
            if (stripos($comment->getText(), '@noEscape') !== false) {
                return true;
            }
        }
        return false;
    }

    /**
     * If method contains the keyword HTML we assume developer intends to output html
     */
    private function methodReturnsValidHtmlOrUrl(Node\Expr\MethodCall $echoContent):bool
    {
        return stripos($echoContent->name->name, 'Html') !== false
            || stripos($echoContent->name->name, 'Url') !== false;
    }

    /**
     * Some php function return safe output. They need not be escaped.
     * count, strip_tags are example
     */
    private function willFunctionReturnSafeOutput(Node\Expr\FuncCall $funcNode):bool
    {
        //@TODO did not handle things like $callback();
        $funcName = $funcNode->name->toCodeString();
        return in_array($funcName, $this->_phpFunctionsToIgnore);
    }

    /**
     * @inheritDoc
     */
    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition(
            'Add escaper methods like escapeHtml to html output',
            [
                new CodeSample(
                    'echo $productName',
                    'echo $escaper->escapeHtml($productName)'
                ),
            ]
        );
    }
}
