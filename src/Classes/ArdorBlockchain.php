<?php 

namespace AMBERSIVE\Ardor\Classes;

use AMBERSIVE\Ardor\Classes\ArdorBase;

use Carbon\Carbon;

use AMBERSIVE\Ardor\Models\ArdorNode;
use AMBERSIVE\Ardor\Models\ArdorTransaction;
use AMBERSIVE\Ardor\Models\ArdorTransactionBytes;

class ArdorBlockchain extends ArdorBase {

    public function __construct(ArdorNode $node = null, \GuzzleHttp\Client $client = null){
        parent::__construct($node, $client);
    }
    
    /**
     * Get a transaction from the chain
     *
     * @param  mixed $fullHash
     * @param  mixed $chain
     * @return ArdorTransaction
     */
    public function getTransaction(String $fullHash, int $chain = 0, $transformTo) {

        $response = $this->send("getTransaction", [
            "fullHash" => $fullHash,
            "chain" => $chain
        ], false, 'form_params');

        return new $transformTo($response);

    }
    
    /**
     * Returns the TransactionsBytes for a transaction
     *
     * @param  mixed $fullHash
     * @param  mixed $chain
     * @return ArdorTransactionBytes
     */
    public function getTransactionBytes(String $fullHash, int $chain = 0): ArdorTransactionBytes {

        $response = $this->send("getTransactionBytes", [
            "fullHash" => $fullHash,
            "chain" => $chain
        ], false, 'form_params');

        return new ArdorTransactionBytes($response);

    }

}