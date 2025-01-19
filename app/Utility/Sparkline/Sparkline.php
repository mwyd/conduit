<?php

namespace App\Utility\Sparkline;

use Illuminate\Support\Collection;

class Sparkline
{
    private int $width = 120;

    private int $height = 30;

    private float $strokeWidth = 1.2;

    private string $color = '#000000';

    public function __construct(
        private readonly Collection $data
    ) {}

    public static function make(Collection $data): self
    {
        return new self($data);
    }

    public function withWidth(int $width): self
    {
        $clone = clone $this;

        $clone->width = $width;

        return $clone;
    }

    public function getWidth(): int
    {
        return $this->width;
    }

    public function withHeight(int $height): self
    {
        $clone = clone $this;

        $clone->height = $height;

        return $clone;
    }

    public function getHeight(): int
    {
        return $this->height;
    }

    public function withStrokeWidth(float $strokeWidth): self
    {
        $clone = clone $this;

        $clone->strokeWidth = $strokeWidth;

        return $clone;
    }

    public function getStrokeWidth(): float
    {
        return $this->strokeWidth;
    }

    public function withColor(string $color): self
    {
        $clone = clone $this;

        $clone->color = $color;

        return $clone;
    }

    public function getColor(): string
    {
        return $this->color;
    }

    public function render(): string
    {
        $count = $this->data->count();

        if ($count == 0) {
            return $this->renderTemplate('');
        }

        $min = $this->data->min();
        $max = $this->data->max();

        $gap = $max - $min;

        if ($gap == 0) {
            return $this->renderTemplate(
                sprintf('0 %s, %s %s', $this->height / 2, $this->width, $this->height / 2)
            );
        }

        $step = $this->width / ($count - 1);
        $scale = ($this->height - $this->strokeWidth) / $gap;

        $reducedHeight = $this->height - ($this->strokeWidth / 2);

        $points = $this->data->map(fn ($value, $i) => ($i * $step).' '.($reducedHeight - $scale * ($value - $min)));

        return $this->renderTemplate(
            $points->join(',')
        );
    }

    private function renderTemplate(string $points): string
    {
        $width = $this->width;
        $height = $this->height;
        $color = $this->color;
        $strokeWidth = $this->strokeWidth;

        ob_start();

        include __DIR__.'/template.php';

        $data = ob_get_contents();

        ob_end_clean();

        return $data;
    }
}
