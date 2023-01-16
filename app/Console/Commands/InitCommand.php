<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Orchid\Platform\Models\Role;

class InitCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'roles:init';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'инициализация ролей админки';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $admin = new Role();
        $admin->name = 'Админ';
        $admin->slug = 'platform.role.admin';
        $admin->permissions = [
            "platform.index" => 1,
            "platform.systems.roles" => 1,
            "platform.systems.users" => 1,
            "platform.systems.drivers" => 1,
            "platform.systems.vehicles" => 1,
            "platform.systems.waybills" => 1,
            "platform.systems.attachment" => 1,
            "platform.systems.waybills.admin" => 1,
        ];
        $admin->save();

        $user = new Role();
        $user->name = 'Пользователь';
        $user->slug = 'platform.role.user';
        $user->permissions = [
            "platform.index" => 1,
            "platform.systems.roles" => 0,
            "platform.systems.users" => 0,
            "platform.systems.drivers" => 0,
            "platform.systems.vehicles" => 0,
            "platform.systems.waybills" => 1,
            "platform.systems.attachment" => 0,
            "platform.systems.waybills.admin" => 0,
        ];
        $user->save();

        return Command::SUCCESS;
    }
}
