<?php


namespace ke\builder;


use ke\builder\command\Publish;
use think\Service;

class ComponentService extends Service
{
    public function boot(): void
    {
        $this->commands(['builderComponent:publish'=>Publish::class]);
    }

}
