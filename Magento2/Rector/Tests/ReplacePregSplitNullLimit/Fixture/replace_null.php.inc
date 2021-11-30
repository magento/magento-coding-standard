<?php

namespace Rector\Tests\ReplaceNonNullableParameters\Fixture;

preg_split('pattern', 'subject', null, 0)

?>
    -----
<?php

namespace Rector\Tests\ReplaceNonNullableParameters\Fixture;

preg_split('pattern', 'subject', -1, 0)

?>

