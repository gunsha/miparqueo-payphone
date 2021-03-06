<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

session_start();
include_once './library/api/Transaction.php';
include_once './library/Configuration.php';
include_once './library/common/Constants.php';
include_once './Parameters.php';

$config = ConfigurationManager::Instance();

$params = new Parameters();
$config->Token = $params->Token;
$config->ApplicationId = $params->ApplicationId;
$config->ApplicationPublicKey = $params->ApplicationPublicKey;
$config->PrivateKey = $params->PrivateKey;

$config->ClientId = $params->ClientId;
$config->ClientSecret =$params->ClientSecret;
$config->RefreshToken = $_SESSION['refresh'];

$instance = new Transaction();
try {
    $id = $_SESSION['TransactionId'];
    $response = $instance->GetTransactionById($id);
    if($response->Status == Constants::STATUS_APPROVED){
        $_SESSION['approved'] = true;
    }
    echo json_encode($response);
} catch (PayPhoneWebException $exc) {
    header('HTTP/1.1 '.$exc->StatusCode.' Error');
    echo json_encode($exc->ErrorList);
}