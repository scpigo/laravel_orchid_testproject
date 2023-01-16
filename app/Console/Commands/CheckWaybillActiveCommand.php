<?php

namespace App\Console\Commands;

use App\Models\Waybill;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CheckWaybillActiveCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'waybill:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'обновить статус путевых листов';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $waybills = Waybill::query()->where('status', 1);
        $today = Carbon::today();

        /** @var Waybill $waybill */
        foreach ($waybills as $waybill) {
            $inactive_date = new Carbon($waybill->issued_at);
            $inactive_date = $inactive_date->addDays($waybill->valid_for_days);

            if ($today->gte($inactive_date)) {
                $waybill->status = 0;
                $waybill->save();
            }
        }

        return Command::SUCCESS;
    }
}
