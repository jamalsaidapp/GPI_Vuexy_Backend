<?php

namespace App\Http;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;

/**
 * Class JsonResponse
 * Simple response object for Nomatis application
 * Response format:
 * {
 *   'variant': success|danger|warning,
 *   'msg': '',
 *   'data': []
 * }
 *
 * @package Nomatis
 */
class JsonResponse implements \JsonSerializable
{
    const STATUS_SUCCESS = 'success';
    const STATUS_DANGER = 'danger';
    const STATUS_WARNING = 'warning';

    /**
     * Data to be returned
     * @var mixed
     */
    private $data = [];

    /**
     * Error message in case process is not success. This will be a string.
     *
     * @var string
     */
    private $msg = '';

    /**
     * @var string
     */
    private $variant = 'success';

    /**
     * JsonResponse constructor.
     * @param mixed $data
     * @param string $msg
     * @param string $variant
     */
    public function __construct($data = [], string $msg = '', $variant = 'success')
    {
        if ($this->shouldBeJson($data)) {
            $this->data = $data;
        }

        $this->msg = $msg;
        $this->variant = $variant;
    }


    /**
     * Success with data
     *
     * @param array $data
     */
    public function success($msg, $data = [])
    {
        $res = [
            'variant' => JsonResponse::STATUS_SUCCESS,
            'data' => $data,
            'msg' => $msg,
        ];

        return response()->json($res, 200);
    }

    /**
     * Fail with error message
     * @param string $msg
     */
    public function fail($msg = '')
    {
       $res = [
            'variant' => JsonResponse::STATUS_DANGER,
            'data' => $this->data,
            'msg' => $msg,
        ];
        return response()->json($res, 404);
    }

    /**
     * Fail with error message
     * @param string $msg
     */
    public function warning($msg = '')
    {
        $res = [
            'variant' => JsonResponse::STATUS_WARNING,
            'data' => $this->data,
            'msg' => $msg,
        ];

        return response()->json($res, 201);
    }

    /**
     * @inheritdoc
     */
    public function jsonSerialize(): array
    {
        return [
            'variant' => $this->variant,
            'data' => $this->data,
            'msg' => $this->msg,
        ];
    }


    /**
     * Determine if the given content should be turned into JSON.
     *
     * @param  mixed  $content
     * @return bool
     */
    private function shouldBeJson($content): bool
    {
        return $content instanceof Arrayable ||
            $content instanceof Jsonable ||
            $content instanceof \ArrayObject ||
            $content instanceof \JsonSerializable ||
            is_array($content);
    }
}
