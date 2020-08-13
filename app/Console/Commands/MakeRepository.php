<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputArgument;

class MakeRepository extends GeneratorCommand
{
    protected $name = "make: repository";

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:repository {name} {model}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create new repository class';


    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Repository';


    protected function replaceClass($stub, $name) {
        $stub = parent::replaceClass($stub, $name);

        return str_replace(
            ["DummyRepository", "DummyModel"],
            [$this->argument('name'), $this->argument('model')],
            $stub
        );
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return  app_path() . '/Console/Commands/Stubs/make-repository.stub';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Repository';
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the repository.'],
            ['model', InputArgument::REQUIRED, 'The name of the model.'],
        ];
    }
}
