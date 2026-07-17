<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Console\Command;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class ArtisanController extends Controller
{
    protected array $include = [
        'view',
        'cache',
        'config',
        'theme'
    ];

    protected array $exclude = [];

    public function index() {
        $commands = $this->listCommands();

        return view('admin.artisan', compact('commands'));
    }

    protected function listCommands(): Collection
    {

        return collect(Artisan::all())
            ->map(function ($command) {
                /** @var Command $command */


                $args = collect($command->getDefinition()->getArguments())
                    ->map(function (InputArgument $arg) {
                        return [
                            'name' => $arg->getName(),
                            'required' => $arg->isRequired(),
                            'default' => $arg->getDefault(),
                            'description' => $arg->getDescription()
                        ];
                    })->values();

                $options = collect($command->getDefinition()->getOptions())
                    ->map(function (InputOption $option) {
                        return [
                            'name' => $option->getName(),
                            'description' => $option->getDescription(),
                            'default' => $option->getDefault(),
                            'required' => $option->isValueRequired()
                        ];
                    })->values();

                return [
                    'name' => $command->getName(),
                    'description' => $command->getDescription(),
                    'args' => $args,
                    'options' => $options
                ];
            })
            ->filter(function ($command) {
                return Str::startsWith($command['name'], $this->include);
            })
            ->reject(function ($command) {
                return Str::startsWith($command['name'], $this->exclude);
            })
            ->sortBy('name')
            ->values();
    }
}
