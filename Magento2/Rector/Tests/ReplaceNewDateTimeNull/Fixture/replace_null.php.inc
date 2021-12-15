<?php

namespace Rector\Tests\ReplaceNonNullableParameters\Fixture;

use DateTime;
use DateTimeZone;

new DateTime(null, new DateTimeZone('GMT'));

?>
-----
<?php

namespace Rector\Tests\ReplaceNonNullableParameters\Fixture;

use DateTime;
use DateTimeZone;

new DateTime('now', new DateTimeZone('GMT'));

?>
