<?php

class Request
{
    private array $get;
    private array $post;
    private array $files;
    private string $method;

    public function __construct()
    {
        $this->get = $_GET;
        $this->post = $_POST;
        $this->files = $_FILES;
        $this->method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
    }

    public function get(string $key, mixed $default = null): mixed
    {
        return $this->get[$key] ?? $default;
    }
    public function post(string $key, mixed $default = null): mixed
    {
        return $this->post[$key] ?? $default;
    }

    public function file(string $key): ?array
    {
        return $this->files[$key] ?? null;
    }

    public function allGet(): array
    {
        return $this->get;
    }
    public function allPost(): array
    {
        return $this->post;
    }

    public function isPost(): bool
    {
        return $this->method === 'POST';
    }
    public function method(): string
    {
        return $this->method;
    }
    public function input(string $key, mixed $default = null): string
    {
        $value = $this->post($key) ?? $this->get($key) ?? $default;
        return htmlspecialchars(trim((string)$value));
    }
}