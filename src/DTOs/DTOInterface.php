<?php

namespace LeandroNunes\C6Bank\DTOs;

interface DTOInterface
{
    public function toArray(): array;

    public static function fromArray(array $data): self;
}
