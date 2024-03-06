<?php

namespace App\Controller;

use League\Tactician\CommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AbstractGeneralController extends AbstractController
{
    protected CommandBus $commandBus;

    public function __construct(
        CommandBus $commandBus
    )
    {
        $this->commandBus = $commandBus;
    }

}
