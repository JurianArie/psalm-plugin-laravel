--ARGS--
--no-progress --no-diff --config=./tests/Type/psalm.xml --taint-analysis --threads=1
--FILE--
<?php declare(strict_types=1);

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Blade;
use Illuminate\View\Compilers\BladeCompiler;

/**
 * `render()` compiles its string as a Blade template and executes it, and `compileString()`
 * returns the PHP code Blade runs, so a tainted template is code injection on the compiler
 * and through the `Blade` facade (`FacadeTaintForwardingHandler`).
 */

function facadeRender(Request $request): string { return Blade::render((string) $request->input('t')); }
function facadeCompileString(Request $request): string { return Blade::compileString((string) $request->input('t')); }
function compilerRender(Request $request): string { return BladeCompiler::render((string) $request->input('t')); }
function compilerCompileString(Request $request, BladeCompiler $compiler): string { return $compiler->compileString((string) $request->input('t')); }
?>
--EXPECTF--
TaintedEval on line %d: Detected tainted code passed to eval or similar
TaintedEval on line %d: Detected tainted code passed to eval or similar
TaintedEval on line %d: Detected tainted code passed to eval or similar
TaintedEval on line %d: Detected tainted code passed to eval or similar
