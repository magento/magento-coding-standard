<?php

$model = Mage :: getModel();
$label = someMethod()->getAttributeRawValue($categoryId, 'name', Mage::app()->getStore());
$eavAttribute = new Mage_Eav_Model_Mysql4_Entity_Attribute();
$lnk = Mage_Downloadable_Model_Link::getLinkDir();
$lnk = Enterprise_Mage_Downloadable_Model_Link::getLinkDir();
$lnk = new Enterprise_Mage_Downloadable_Model_Link;
$instance = new Mage();

$staticCall = SomeClass::call();

$directObject = new SomeClass;

$instance = new MagentoAllowedClass();
$model = MagentoAllowedClass :: getModel();
