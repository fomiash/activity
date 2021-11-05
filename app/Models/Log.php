<?php

namespace App\Models;

use App\Logic\ActivityData;
use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'id',
        'url',
        'visits_count',
        'last_visit_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    /**
     * @param int $page - номер страницы
     * @param int $limit - кол-во на странице
     * @return ActivityData[]
     * @throws \Exception
     */
    public static function getCollection(int $page, int $limit): array {
        $page = $page <= 1 ? 0 : ($page - 1)*$limit;
        $logs = Log::select(['url', 'visits_count', 'last_visit_at'])
            ->orderBy('id','ASC')
            ->limit($limit)
            ->offset($page)
            ->get()
            ->toArray();
        $data = [];
        foreach($logs as $log) {
            $data[] = (new ActivityData())
                ->setUrl($log['url'])
                ->setLastVisitAt(new DateTime($log['last_visit_at']))
                ->setVisits($log['visits_count']);
        }
        return $data;
    }

    public static function setAppeal(ActivityData $data) {
        $log = Log::select(['id', 'visits_count'])->where('url', $data->getUrl())->first();

        if(!$log) {
            Log::create([
                'url' => $data->getUrl(),
                'last_visit_at' => $data->getLastVisitAt()->format('Y-m-d H:i:s'),
                'visits_count' => 1
            ]);
            return;
        }

        Log::find($log->id)->update([
            'visits_count' => $log->visits_count + 1,
            'last_visit_at' => $data->getLastVisitAt()->format('Y-m-d H:i:s'),
        ]);
    }
}
