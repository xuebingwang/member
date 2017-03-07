<?php
/**
 * This file is part of Notadd.
 *
 * @author        Qiyueshiyi <qiyueshiyi@outlook.com>
 * @copyright (c) 2017, iBenchu.org
 * @datetime      2017-02-16 10:55
 */

namespace Notadd\Member;

use Notadd\Member\Models\ActionPoints;

class PointsManager
{
    const PATH_PERFIX = 'action-points.paths.';

    /**
     * @param string $key
     * @param string $path
     */
    public function registerFilePath(string $key, string $path)
    {
        if (! app('config')->has(static::PATH_PERFIX . $key)) {
            app('config')->set(static::PATH_PERFIX . $key, $path);
        }
    }

    /**
     * @param string $key
     *
     * @return string
     */
    public function getFilePath(string $key)
    {
        return app('config')->get(static::PATH_PERFIX . $key, '');
    }

    /**
     * @return array
     */
    public function getFilePaths()
    {
        return app('config')->get(rtrim(static::PATH_PERFIX, '.'), []);
    }

    public function get(string $name)
    {
        return ActionPoints::findByName($name);
    }
}
