<?php

namespace AMBERSIVE\Ardor\Contracts;

use AMBERSIVE\Ardor\Abstracts\ContractDefault;

use AMBERSIVE\Ardor\Models\ArdorPrunableMessage;

class DefaultFundingContract extends ContractDefault {

    public $name = "ElearningGradeCertificate";

    public function run(ArdorPrunableMessage $message):bool {
        return true;
    }

}