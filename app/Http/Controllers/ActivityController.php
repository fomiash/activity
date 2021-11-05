<?php

namespace App\Http\Controllers;

use App\Http\Requests\LogRequest;
use App\Logic\ActivityData;
use App\Logic\JsonRpc20Config;
use App\Logic\JsonRpc20Standard;
use App\Models\Log;

class ActivityController extends Controller
{
    use JsonRpc20Standard;

    const DEFAULT_LIMIT = 50;

    public function index(LogRequest $request)
    {
        $this->id = $request->get('id');
        try {
            $method = $request->get('method');
            if ($method === 'get') {
                return response()->json($this->get($request));
            } else if ($method === 'post') {
                return response()->json($this->post($request));
            }
        } catch (\Throwable $e) {
            return response()->json($this->createJsonResponseError(JsonRpc20Config::REQUEST_ERROR, $e->getMessage()));
        }
        return response()->json($this->createJsonResponseError(JsonRpc20Config::REQUEST_ERROR, 'Undefined `method`'));
    }

    private function get(LogRequest $request)
    {
        $this->id = $request->get('id');
        try {
            $params = $request->get('params');
            $page = $params['page'] ?? 1;
            $limit = $params['limit'] ?? self::DEFAULT_LIMIT;
            $logs = Log::getCollection($page === 0 ? 1 : $page, $limit);
        } catch (\Throwable $e) {
            return $this->createJsonResponseError(JsonRpc20Config::REQUEST_ERROR, $e->getMessage());
        }

        $result = [];
        foreach ($logs as $log) {
            $result[] = (object)[
                'url' => $log->getUrl(),
                'visits' => $log->getVisits(),
                'last_visit_at' => $log->getLastVisitAt()->format('Y-m-d H:i:s')
            ];
        }

        return $this->createJsonResponseSuccess(['page' => $page, 'limit' => $limit, 'data' => $result]);
    }

    private function post(LogRequest $request)
    {
        $this->id = $request->get('id');
        try {
            Log::setAppeal((new ActivityData())
                ->setUrl($request->getUrl())
                ->setLastVisitAt($request->getVisitDate()));
        } catch (\Throwable $e) {
            return $this->createJsonResponseError(JsonRpc20Config::SERVER_ERROR, $e->getMessage());
        }
        return $this->createJsonResponseSuccess(['OK']);
    }
}


