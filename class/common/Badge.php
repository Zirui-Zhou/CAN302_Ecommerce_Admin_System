<?php

namespace common;

class Badge {
    protected string $text;
    protected string $style;
    protected string $icon;

    public function __construct(string $text, string $style, string $icon) {
        $this->text = $text;
        $this->style = $style;
        $this->icon = $icon;
    }

    public function getBadgeHtml(): string {
        return "
            <span class=\"badge {$this->style}\">
                <i class=\"{$this->icon}\"></i>
                {$this->text}
            </span>
        ";
    }

    public function getText(): string {
        return $this->text;
    }

    public function getStyle(): string {
        return $this->style;
    }

    public function getIcon(): string {
        return $this->icon;
    }

}