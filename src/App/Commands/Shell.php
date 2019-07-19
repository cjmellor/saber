<?php

namespace Saber;

use Symfony\Component\Process\Process;

class Shell
{
    /**
     * Run a command - shorthand
     *
     * @param string $command
     * @param callable $error
     * @return void
     */
    public function run($command, callable $error = null)
    {
        return $this->runCommand($command, $error);
    }

    /**
     * Run a command on the terminal
     *
     * @param string $command
     * @param callable $error
     * @return void
     */
    public function runCommand($command, callable $error = null)
    {
        $process = Process::fromShellCommandline($command);

        $shellOutput = '';

        $process->setTimeout(null)->run(function ($type, $line) use (&$shellOutput) {
            $shellOutput .= $line;
        });

        if ($process->getExitCode() > 0) {
            $error($process->getExitCode(), $shellOutput);
        }

        return $shellOutput;
    }
}
