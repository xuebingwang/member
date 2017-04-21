<?php
/**
 * This file is part of Notadd.
 *
 * @author Qiyueshiyi <qiyueshiyi@outlook.com>
 * @copyright (c) 2017, iBenchu.org
 * @datetime 2017-02-06 14:43
 */
namespace Notadd\Member\Commands;

use Illuminate\Console\Command;
use Notadd\Member\Models\ActionPoints;
use Illuminate\Console\ConfirmableTrait;

/**
 * Class PointsCommand.
 */
class PointsCommand extends Command
{
    use ConfirmableTrait;

    protected $name = 'Points';

    protected $signature = 'points 
        {key? : Register Action Points config file path key.}
        {--path= : From file export Action Points.}
        {--all : Export all action points to database} 
        {--force= : Force export Action Points.}';

    protected $description = 'Export action points to databases';

    /**
     * @var \Notadd\Member\PointsManager
     */
    protected $pointsManager;

    public function __construct()
    {
        parent::__construct();
        $this->pointsManager = app('points');
    }

    public function handle()
    {
        if (!$this->confirmToProceed()) {
            return;
        }
        $actionPoints = [];
        $key = $this->argument('key');
        if (!empty($key) && !empty($actionPointsFile = $this->pointsManager->getFilePath($key)) && file_exists($actionPointsFile)) {
            $actionPoints = (array)require $actionPointsFile;
        }
        if (!empty($path = $this->option('path')) && file_exists($path)) {
            $actionPoints = (array)require $path;
        }
        if ($this->option('all')) {
            $actionPoints = [];
            $paths = $this->pointsManager->getFilePaths();
            foreach ($paths as $path) {
                if (empty($path) || !file_exists($path)) {
                    continue;
                }
                $actionPoints = array_merge($actionPoints, (array)require $path);
            }
        }
        if (empty($actionPoints) || count($actionPoints) < 1) {
            return $this->warn('没有要添加的行为积分.');
        }
        $i = 0;
        foreach ($actionPoints as $actionPoint) {
            if (!isset($actionPoint['name']) || !isset($actionPoint['points']) || empty($actionPoint['name']) || empty($actionPoint['points'])) {
                continue;
            }
            if (ActionPoints::where('name', $actionPoint['name'])->count()) {
                continue;
            }
            ActionPoints::addAction($actionPoint['name'], $actionPoint['points'], @$actionPoint['display_name'],
                @$actionPoint['description']);
            $i++;
        }
        $this->info("添加了 {$i} 个行为积分.");
    }
}
