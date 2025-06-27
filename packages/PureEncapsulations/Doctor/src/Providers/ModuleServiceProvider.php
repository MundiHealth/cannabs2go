<?php


namespace PureEncapsulations\Doctor\Providers;

use Konekt\Concord\BaseModuleServiceProvider;

class ModuleServiceProvider extends BaseModuleServiceProvider
{
    protected $models = [
        \PureEncapsulations\Doctor\Models\Doctor::class,
    ];
}