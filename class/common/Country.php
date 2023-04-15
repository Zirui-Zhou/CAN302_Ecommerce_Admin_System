<?php

namespace common;

class Country {
    protected string $code;
    protected string $name;

    public function __construct(string $code, string $name) {
        $this->code = $code;
        $this->name = $name;
    }

    public function getCode(): string {
        return $this->code;
    }

    public function getName(): string {
        return $this->name;
    }

}