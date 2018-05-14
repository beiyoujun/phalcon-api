<?php

namespace Niden\Middleware;

use Niden\Exception\Exception;
use Niden\Http\Response;
use Phalcon\Events\Event;
use Phalcon\Http\Request;
use Phalcon\Mvc\Micro;
use Phalcon\Mvc\Micro\MiddlewareInterface;

/**
 * Class PayloadMiddleware
 *
 * @package Niden\Middleware
 *
 * @property Response $response
 */
class PayloadMiddleware implements MiddlewareInterface
{
    /**
     * @param Event $event
     * @param Micro $api
     *
     * @return bool
     */
    public function beforeExecuteRoute(Event $event, Micro $api)
    {
        /** @var Request $request */
        $request = $api->getService('request');
        /** @var Response $response */
        $response = $api->getService('response');
        if (true === $request->isPost()) {
            try {
                $data = json_decode($request->getRawBody(), true);
                $this->checkJson();
                $this->checkDataElement($data);
                $this->parsePayload($data);
            } catch (Exception $ex) {
                /** @var Response $response */
                $response->sendError($event->getType(), $ex->getMessage());

                return false;
            }
        }

        return true;
    }

    /**
     * Call me
     *
     * @param Micro $api
     *
     * @return bool
     */
    public function call(Micro $api)
    {
        return true;
    }

    /**
     * Checks if the 'data' element has been sent
     *
     * @param array $data
     *
     * @throws Exception
     */
    private function checkDataElement(array $data)
    {
        if (true !== isset($data['data'])) {
            throw new Exception('"data" element not present in the payload');
        }
    }

    /**
     * Check if we have a JSON error
     *
     * @throws Exception
     */
    private function checkJson()
    {
        if (JSON_ERROR_NONE !== json_last_error()) {
            throw new Exception('Malformed JSON');
        }
    }

    /**
     * Parses the payload and injects the posted data in the POST array
     *
     * @param array $data
     */
    private function parsePayload(array $data)
    {
        $_POST = $data['data'];
    }
}
