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
       // if the echo already has escapeHtml called on $block or escaper, don't do anthing

       $echoContent  = $node->exprs[0];

       if($echoContent instanceof  Node\Expr\Variable || $echoContent instanceof Node\Expr\FuncCall){
           $node->exprs[0] = new Node\Expr\MethodCall(new Node\Expr\Variable('escaper'),'escapeHtml',[new Node\Arg($echoContent)]);
           return $node;
       }

       if($echoContent instanceof Node\Expr\MethodCall && $echoContent->name != 'escapeHtml'){

           $node->exprs[0] = new Node\Expr\MethodCall(new Node\Expr\Variable('escaper'),'escapeHtml',[new Node\Arg($echoContent)]);
           return $node;
       }

        return null;
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
