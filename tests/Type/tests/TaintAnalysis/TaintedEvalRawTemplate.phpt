--SKIPIF--
<?php
require getcwd() . '/vendor/autoload.php';
\Tests\Psalm\LaravelPlugin\Type\LaravelVersion::skipBelow('13.43.0');
--ARGS--
--no-progress --no-diff --config=./tests/Type/psalm.xml --taint-analysis --threads=1
--FILE--
<?php declare(strict_types=1);

use Illuminate\Http\Request;
use Illuminate\View\RawTemplate;

/**
 * A component returning a `RawTemplate` from `render()` has the template compiled as Blade
 * and executed (Laravel 13.43.0+, `stubs/13.43.0/View/RawTemplate.phpstub`).
 */

function taintedTemplate(Request $request): RawTemplate
{
    return new RawTemplate((string) $request->input('t'));
}

function literalTemplate(): RawTemplate
{
    return new RawTemplate('<div>{{ $slot }}</div>');
}
?>
--EXPECTF--
ArgumentTypeCoercion on line %d: Argument 1 of Illuminate\View\RawTemplate::__construct expects literal-string, but parent type string provided
TaintedEval on line %d: Detected tainted code passed to eval or similar
