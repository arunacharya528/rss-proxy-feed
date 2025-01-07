<?php

namespace App\Services\Abstract;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;

abstract class AbstractNewsService
{
    public ?string $uri = null;

    public array $params = [];

    public array $headers = [];

    public Response $response;

    public static function make(): static
    {
        $service = new static;

        return $service;
    }

    public function setParameters(array $params): static
    {
        $this->params = $params;

        return $this;
    }

    public function setHeaders(array $headers): static
    {
        $this->headers = $headers;

        return $this;
    }

    public function getUri(): string
    {
        return $this->uri;
    }

    public function getParameters(): array
    {
        return $this->params;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * Construct http call to remote client
     */
    public function sendRequest(): static
    {
        $this->response = Http::get($this->getUri(), $this->getParameters());

        foreach ($this->getHeaders() as $key => $value) {
            $this->response = $this->response->withHeader($key, $value);
        }

        $this->exceptions($this->response);

        return $this;
    }

    public function getResponse(): Response
    {
        return $this->response;
    }

    /**
     * Method to enclose exceptions in
     *
     * @return void
     */
    abstract public function exceptions(Response $response);

    /**
     * Format your response before returning
     *
     * @return DataCollection<Data>
     */
    abstract public function formatResponse(): DataCollection;
}
