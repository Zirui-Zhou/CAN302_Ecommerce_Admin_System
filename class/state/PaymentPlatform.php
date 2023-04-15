<?php

namespace state;

use common\Icon;

class PaymentPlatform {
    protected int $id;
    protected string $name;
    protected string $type;
    protected Icon $icon;

    public function __construct(int $id, string $name, string $type, Icon $icon) {
        $this->id = $id;
        $this->name = $name;
        $this->type = $type;
        $this->icon = $icon;
    }

    public function getId(): int {
        return $this->id;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getType(): string {
        return $this->type;
    }

    public function getIcon(): Icon {
        return $this->icon;
    }
}