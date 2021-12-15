<?php

namespace Rector\Tests\ReplaceNonNullableParameters\Fixture;

mb_strpos('haystack with needle', 'needle', null, 'utf-8')

?>
-----
<?php

namespace Rector\Tests\ReplaceNonNullableParameters\Fixture;

mb_strpos('haystack with needle', 'needle', 0, 'utf-8')

?>
