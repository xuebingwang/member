<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-05-05 20:50
 */
namespace Notadd\Member\Handlers\Permission;

use Illuminate\Container\Container;
use Illuminate\Support\Collection;
use Notadd\Foundation\Passport\Abstracts\SetHandler as AbstractSetHandler;
use Notadd\Foundation\Permission\PermissionType;
use Notadd\Foundation\Permission\PermissionTypeManager;
use Notadd\Foundation\Setting\Contracts\SettingsRepository;
use Notadd\Member\Models\MemberGroup;

/**
 * Class SetHandler.
 */
class SetHandler extends AbstractSetHandler
{
    /**
     * @var \Notadd\Foundation\Setting\Contracts\SettingsRepository
     */
    protected $settings;

    /**
     * @var \Notadd\Foundation\Permission\PermissionTypeManager
     */
    protected $types;

    /**
     * SetHandler constructor.
     *
     * @param \Illuminate\Container\Container                         $container
     * @param \Notadd\Foundation\Setting\Contracts\SettingsRepository $settings
     * @param \Notadd\Foundation\Permission\PermissionTypeManager     $types
     */
    public function __construct(Container $container, SettingsRepository $settings, PermissionTypeManager $types)
    {
        parent::__construct($container);
        $this->types = $types;
        $this->settings = $settings;
    }

    public function execute()
    {
        $data = $this->request->input('data');
        if (!is_array($data)) {
            $this->code = 500;
            $this->errors->push($this->translator->trans('参数格式错误！'));

            return false;
        }
        $keys = new Collection();
        $this->types->types()->each(function (PermissionType $type) use ($keys) {
            collect($type->has())->each(function ($item, $key) use ($keys) {
                $keys->put($key, []);
            });
        });
        collect($data)->each(function ($type) use ($keys) {
            if (isset($type['has']) && is_array($type['has'])) {
                collect($type['has'])->each(function ($groups, $key) use ($keys) {
                    if ($keys->has($key) && is_array($groups)) {
                        collect($groups)->each(function ($group) use ($keys, $key) {
                            if (MemberGroup::query()->where('identification', $group)->count()) {
                                $keys->put($key, array_merge($keys->get($key), [$group]));
                            }
                        });
                    }
                });
            }
        });
        $this->settings->set('permissions', json_encode($keys->toArray()));
        $this->messages->push($this->translator->trans('批量更新权限值成功！'));

        return true;
    }
}
