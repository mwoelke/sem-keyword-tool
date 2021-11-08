<?php

namespace App\Helper;

use App\Repository\DomainRepository;

class DomainHelper
{
    public function __construct(private DomainRepository $domainRepository)
    {
    }
}