<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, iBenchu.org
 * @datetime 2017-04-18 15:51
 */
namespace Notadd\Member\Handlers\Upload;

use Illuminate\Container\Container;
use Illuminate\Filesystem\Filesystem;
use Notadd\Foundation\Passport\Abstracts\SetHandler;

/**
 * Class UploadHandler.
 */
class UploadHandler extends SetHandler
{
    /**
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $files;

    /**
     * UploadHandler constructor.
     *
     * @param \Illuminate\Container\Container   $container
     * @param \Illuminate\Filesystem\Filesystem $filesystem
     */
    public function __construct(Container $container, Filesystem $filesystem)
    {
        parent::__construct($container);
        $this->messages->push($this->translator->trans('上传图片成功！'));
        $this->files = $filesystem;
    }

    /**
     * Execute Handler.
     *
     * @return bool
     */
    public function execute()
    {
        return true;
    }
}
