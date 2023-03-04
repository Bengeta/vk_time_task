<?php

interface TimeToWordConvertingInterface
{
    public function convert(int $hours, int $minutes): string;
}