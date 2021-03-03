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
        $path = __DIR__ . '/../../dist/';
        $newPath = $this->app->getRootPath() . 'public/static/builder/';
        $this->copyDir($path, $newPath);

        $output->writeln('publish success!');
    }


    protected function copyDir($src, $des)
    {
        $dir = opendir($src);
        if (!is_dir($des)) {
            mkdir($des, 0755, true);
        }
        while (false !== ($file = readdir($dir))) {
            if (($file != '.') && ($file != '..')) {
                if (is_dir($src . '/' . $file)) {
                    $this->copyDir($src . '/' . $file, $des . '/' . $file);
                } else {
                    copy($src . '/' . $file, $des . '/' . $file);
                }
            }
        }
        closedir($dir);
    }

}
