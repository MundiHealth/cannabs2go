<?php


namespace PureEncapsulations\Prescription\Providers;

use Konekt\Concord\BaseModuleServiceProvider;

class ModuleServiceProvider extends BaseModuleServiceProvider
{
    protected $models = [
      \PureEncapsulations\Prescription\Models\Prescription::class
    ];
}