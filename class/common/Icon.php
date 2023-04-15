<?php

namespace common;

class Icon {
    protected string $icon;
    protected string $color;

    public function __construct(string $icon, string $color) {
        $this->icon = $icon;
        $this->color = $color;
    }

    public function getIconHtml(): string {
        return "
            <i 
                class='{$this->icon}'
                style='color: {$this->color}'
            >
            </i>
        ";
    }

    public function getIcon(): string {
        return $this->icon;
    }

    public function getColor(): string {
        return $this->color;
    }
}