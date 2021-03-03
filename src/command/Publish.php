<?php


namespace ke\builder\command;


use think\console\Command;
use think\console\Input;
use think\console\Output;
use think\Filesystem;

class Publish extends Command
{
    protected function configure()
    {
        $this->setName('builderComponent:publish')
            ->setDescription('Publish assets');
    }


    protected function execute(Input $input, Output $output)
    {
        $fs = new Filesystem($this->app);

        $path = __DIR__ . '/../../dist/';
        $newPath = $this->app->getRootPath() . 'public/static/builder/';
        $fs->copy($path, $newPath);

        $output->writeln('publish success!');
    }

}
