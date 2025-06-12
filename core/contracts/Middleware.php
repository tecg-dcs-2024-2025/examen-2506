<?php

namespace Tecgdcs\Contracts;

interface Middleware
{
    public function handle(): void;
}