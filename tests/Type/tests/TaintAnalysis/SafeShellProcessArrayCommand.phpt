--ARGS--
--no-progress --no-diff --config=./tests/Type/psalm.xml --taint-analysis --threads=1
--FILE--
<?php declare(strict_types=1);

use Illuminate\Http\Request;
use Illuminate\Process\PendingProcess;
use Illuminate\Support\Facades\Process;

/**
 * An array command is passed to `proc_open()` as an argument list, without a shell, so a
 * tainted element cannot inject a command: no `TaintedShell` on the instance or facade forms.
 */

function instanceRun(Request $request, PendingProcess $process): void { $process->run(['ls', (string) $request->input('dir')]); }
function instanceCommand(Request $request, PendingProcess $process): void { $process->command(['ls', (string) $request->input('dir')]); }
function instanceStart(Request $request, PendingProcess $process): void { $process->start(['ls', (string) $request->input('dir')]); }
function facadeRun(Request $request): void { Process::run(['ls', (string) $request->input('dir')]); }
function facadeCommand(Request $request): void { Process::command(['ls', (string) $request->input('dir')]); }
function facadeStart(Request $request): void { Process::start(['ls', (string) $request->input('dir')]); }
?>
--EXPECTF--
