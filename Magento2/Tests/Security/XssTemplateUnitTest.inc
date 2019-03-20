<!--unsafe-->

<?php $block->getSomeData(); echo $block->getSomeData(); /* @escapeNotVerified */ echo $block->getSomeData();?>
<?=  $block->getTitle();?>
<?php echo $object->getSomeMethod($block->getHtmlId());?>
<?php echo "Title: $title";?>
<?php echo $block->escapeUrl($var) . $var . 'bla';?>
<?php echo /* @escapeNotVerified */ $var;?>
<?= $someVar?>
<?php echo __("bla");?>

<?php echo $object->methodHtml() .
    $var .
    $block->getSomeData();
?>
<?php echo '\'' . $code . '\',\'' . $block->escapeQuote($data['parentSymbol']) . '\''; ?>
<?php echo "\"" . $code . "\",\"" . $block->escapeQuote($data['parentSymbol']) . "\""; ?>
<?php echo $res = $var . $tt . $var ? 1 : 2 ? $var : 5; ?>
<?php echo $res = $var . $tt . $var ? 1 : 2 ? $block->getExtendedElement($switchAttributeCode)->print() : 5; ?>
<?php print $var;?>
<?php echo <<<END
Some text goes here $variable.
END;
?>
<?php echo ($my_false) . (($c) ? $block->escapeUrl( $block->my_funct() . $var) : (false) ? sizeof ($var) :'bla bla'); ?>

<!--safe-->
<input name="form_key" type="hidden" value="<?php echo $block->escapeUrl($var) ?>" />
<input name="form_key" type="hidden" value="<?php echo $block->escapeQuote('bla') ?>" />
<input name="form_key" type="hidden" value="<?php echo $block->escapeXssInUrl("bla bla") ?>" />
echo $var;
<?php echo $block->getHtmlId("bla bla") ?>
<?php echo $block->getIdHtml("bla bla") ?>
<?= $block->getIdHtml("bla bla"); ?>
<?php echo "\$var1"; ?>
<?php echo '$var'; ?>
<?php echo "bla"; ?>
<?php echo 'bla'; ?>
<?php echo (real)$var;?>
<?php echo (int)$var; ?>
<?php echo (bool)$var; ?>
<?php echo count($var); ?>
<?php echo $object->methodHtml(); ?>
<?php pecho($var);?>
<?php echo $object->methodHtml() .
    (bool)$var .
    $block->escapeXssInUrl("bla bla");
?>
<?php /* @noEscape */ echo '\'' . $code . '\',\'' . $block->escapeQuote($data['parentSymbol']) . '\''; ?>
<?= $block->getExtendedElement($switchAttributeCode)->toHtml(); ?>
<?= $block->escapeHtml($_filter->getFilter()->getClearLinkText()) ?>
<?php echo ($card->default) ? $block->escapeHtml(__('Yes')) : $block->escapeHtml(__('No')); ?>
<?php echo $res = $var . $tt . $var ? 1 : 2 ? $block->getExtendedElement($switchAttributeCode)->toHtml() : 5; ?>
<?php echo $var % 2; ?>
<?php echo $var ** 2;?>
<?php echo $block->escapeJs($js); ?>
<?php echo $block->escapeCss($css); ?>
<?php echo $block->getJsLayout($jsLayout); ?>
<?= /* @noEscape */ json_encode($config) ?>
