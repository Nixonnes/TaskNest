<?php

namespace Core;

interface DsnGenerator
{
    public function getDsn(): string;
}