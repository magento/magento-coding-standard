<?php

echo $customer->getName();
echo __('Something');
?>
-----
<?php

echo $escaper->escapeHtml($customer->getName());
echo $escaper->escapeHtml(__('Something'));
?>
