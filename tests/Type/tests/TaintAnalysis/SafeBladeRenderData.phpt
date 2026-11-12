--ARGS--
--no-progress --no-diff --config=./tests/Type/psalm.xml --taint-analysis --threads=1
--FILE--
<?php declare(strict_types=1);

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Blade;

/**
 * Only the template of `Blade::render()` is compiled: view data is echoed through `{{ }}`,
 * so a literal template with tainted data is not code injection.
 */

function literalTemplateWithTaintedData(Request $request): string
{
    return Blade::render('<p>{{ $name }}</p>', ['name' => (string) $request->input('name')]);
}
?>
--EXPECTF--
