<?php

declare(strict_types=1);

namespace App\Logic;


trait JsonRpc20Standard
{
    private $id = 0;

    protected function createJsonRequest(string $method, array $params = []): object
    {
        $request = [
            'jsonrpc' => '2.0',
            'id' => $this->id,
            'method' => $method,
            'params' => $params
        ];

        return (object)$request;
    }

    protected function createJsonResponseError(int $errorNumber, string $errorMessage = null): object
    {
        return $this->createJsonResponse([], $errorNumber, $errorMessage);
    }

    protected function createJsonResponseSuccess(array $data = []): object
    {
        return $this->createJsonResponse($data);
    }

    private function createJsonResponse(array $result, int $errorNumber = null, string $errorMessage = null): object
    {
        $response = [
            'jsonrpc' => '2.0',
            'id' => $this->id,
            'result' => $result,
        ];

        if (!is_null($errorNumber)) {
            $errorNumber = isset(JsonRpc20Config::RPC_ERRORS[$errorNumber]) ? $errorNumber : JsonRpc20Config::UNDEFINED_ERROR;
            unset($response['result']);

            $response['error'] = (object)[
                'code' => $errorNumber,
                'message' => JsonRpc20Config::RPC_ERRORS[$errorNumber],
                'data' => $errorMessage
            ];
        }

        return (object)$response;
    }
}


