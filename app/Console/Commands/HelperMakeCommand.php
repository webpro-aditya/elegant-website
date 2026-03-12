<?php

namespace App\Console\Commands;

use Illuminate\Support\Str;
use Nwidart\Modules\Commands\GeneratorCommand;
use Nwidart\Modules\Support\Config\GenerateConfigReader;
use Nwidart\Modules\Support\Stub;
use Nwidart\Modules\Traits\ModuleCommandTrait;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class HelperMakeCommand extends GeneratorCommand
{
    use ModuleCommandTrait;

    /**
     * The name of argument being used.
     *
     * @var string
     */
    protected $argumentName = 'helper';

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'module:make-helper';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate new restful helper for the specified module.';

    /**
     * Get helper name.
     *
     * @return string
     */
    public function getDestinationFilePath()
    {
        $path = $this->laravel['modules']->getModulePath($this->getModuleName());

        $helperPath = GenerateConfigReader::read('helper');

        return $path . $helperPath->getPath() . '/' . $this->getHelperName() . '.php';
    }

    /**
     * @return string
     */
    protected function getTemplateContents()
    {
        $module = $this->laravel['modules']->findOrFail($this->getModuleName());

        return (new Stub($this->getStubName(), [
            'MODULENAME' => $module->getStudlyName(),
            'HELPERNAME' => $this->getHelperName(),
            'NAMESPACE' => $module->getStudlyName(),
            'CLASS_NAMESPACE' => $this->getClassNamespace($module),
            'CLASS' => $this->getHelperNameWithoutNamespace(),
            'LOWER_NAME' => $module->getLowerName(),
            'MODULE' => $this->getModuleName(),
            'NAME' => $this->getModuleName(),
            'STUDLY_NAME' => $module->getStudlyName(),
            'MODULE_NAMESPACE' => $this->laravel['modules']->config('namespace'),
        ]))->render();
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['helper', InputArgument::REQUIRED, 'The name of the helper class.'],
            ['module', InputArgument::OPTIONAL, 'The name of module will be used.'],
        ];
    }

    /**
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['plain', 'p', InputOption::VALUE_NONE, 'Generate a plain helper', null],
            ['api', null, InputOption::VALUE_NONE, 'Exclude the create and edit methods from the helper.'],
        ];
    }

    /**
     * @return array|string
     */
    protected function getHelperName()
    {
        $helper = Str::studly($this->argument('helper'));

        if (Str::contains(strtolower($helper), 'helper') === false) {
            $helper .= 'Helper';
        }

        return $helper;
    }

    /**
     * @return array|string
     */
    private function getHelperNameWithoutNamespace()
    {
        return class_basename($this->getHelperName());
    }

    public function getDefaultNamespace(): string
    {
        $module = $this->laravel['modules'];

        return $module->config('paths.generator.helper.namespace') ?: $module->config('paths.generator.helper.path', 'Http/Helpers');
    }

    /**
     * Get the stub file name based on the options
     * @return string
     */
    protected function getStubName()
    {
        if ($this->option('plain') === true) {
            $stub = '/helper-plain.stub';
        } elseif ($this->option('api') === true) {
            $stub = '/helper-api.stub';
        } else {
            $stub = '/helper.stub';
        }

        return $stub;
    }
}
