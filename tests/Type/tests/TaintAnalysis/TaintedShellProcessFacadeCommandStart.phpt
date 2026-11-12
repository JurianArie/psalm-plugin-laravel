--ARGS--
--no-progress --no-diff --config=./tests/Type/psalm.xml --taint-analysis --threads=1
--FILE--
<?php declare(strict_types=1);

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Process;

/**
 * A string command runs through a shell, so it stays a `shell` sink on the facade's
 * `command()` and `start()` (`run()` is covered by `TaintedShellProcessFacadeStatic.phpt`).
 */

function facadeCommand(Request $request): void { Process::command('ls ' . (string) $request->input('dir')); }
function facadeStart(Request $request): void { Process::start('ls ' . (string) $request->input('dir')); }
?>
--EXPECTF--
TaintedShell on line %d: Detected tainted shell code
TaintedShell on line %d: Detected tainted shell code
