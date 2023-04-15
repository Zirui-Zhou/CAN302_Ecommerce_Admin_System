<?php

namespace state;

use common\Badge;

class ProductState {
    protected int $id;
    protected string $name;
    protected Badge $badge;

    public function __construct(int $id, string $name, Badge $badge) {
        $this->id = $id;
        $this->name = $name;
        $this->badge = $badge;
    }

    public function getId(): int {
        return $this->id;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getBadge(): Badge {
        return $this->badge;
    }

}