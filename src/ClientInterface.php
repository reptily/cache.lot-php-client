<?php

namespace Cachelot;

interface ClientInterface
{
    public function close(): void;
    public function get(string $key);
    public function set(string $key, $value): string;
    public function show(): string;
    public function del(string $key): string;
    public function die(string $key, int $timeout): string;
}