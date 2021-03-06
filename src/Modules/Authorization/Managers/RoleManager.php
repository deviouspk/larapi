<?php
/**
 * Created by PhpStorm.
 * User: arthur
 * Date: 09.03.19
 * Time: 21:47.
 */

namespace Modules\Authorization\Managers;

use Modules\Authorization\Abstracts\AbstractRole;
use Modules\Authorization\Roles\AdminRole;
use Modules\Authorization\Roles\GuestRole;
use Modules\Authorization\Roles\MemberRole;
use Modules\Authorization\Roles\ScripterRole;

class RoleManager
{
    /**
     * @var AbstractRole[]
     */
    const ROLES = [
        MemberRole::class,
        ScripterRole::class,
        GuestRole::class,
        AdminRole::class
    ];

    public static function member(): MemberRole
    {
        return MemberRole::singleton();
    }

    public static function scripter(): ScripterRole
    {
        return ScripterRole::singleton();
    }

    public static function admin(): AdminRole
    {
        return AdminRole::singleton();
    }

    public static function guest(): GuestRole
    {
        return GuestRole::singleton();
    }
}
