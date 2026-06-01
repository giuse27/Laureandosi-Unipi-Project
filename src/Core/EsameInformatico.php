<?php

namespace Laureandosi\Core;

require_once dirname(__DIR__, 2) . '/vendor/autoload.php';

use Laureandosi\Config\FileConfigurazione;
use Laureandosi\Core\Esame;

class EsameInformatico extends Esame
{
    public readonly bool $informatico;

    public function __construct(array $esameJSON, string $cdl, string $mat)
    {
        $this->informatico = true;
        parent::__construct($esameJSON, $cdl, $mat);
    }
}