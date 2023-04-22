<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Response;

class AuthService
{
    private function getClient()
    {
        $client = new Client([
            'base_uri' => config('services.gaming.domain'),
            'timeout'  => 60,
        ]);

        return $client;
    }

    public function send($method, $path, $options = [])
    {
        $client = $this->getClient();

        $credentials = "Basic " . config('services.gaming.api');
        $defaultOptions = [
            'headers' => [
                'Authorization' => $credentials,
                'Content-Type'  => 'application/json',
            ]
        ];

        try {
            $response = $client->request($method, $path, array_merge($defaultOptions, $options));

            return $response;
        } catch (ClientException $e) {
            if ($e->hasResponse()) {
                $exception = $e->getResponse();
                return $exception;
            }
        } catch (\Throwable $e) {
            \Log::debug($e->getMessage());
        }
    }
}
