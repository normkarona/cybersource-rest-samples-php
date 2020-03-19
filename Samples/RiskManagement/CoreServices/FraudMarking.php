<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../vendor/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../Resources/ExternalConfiguration.php';

function FraudMarking($id)
{
	$riskInformationMarkingDetailsFieldsIncluded = array();
	$riskInformationMarkingDetailsFieldsIncluded[0] = "customer_email";
	$riskInformationMarkingDetailsFieldsIncluded[1] = "customer_phone";
	$riskInformationMarkingDetailsArr = [
			"notes" => "Adding this transaction as suspect",
			"reason" => "suspected",
			"fieldsIncluded" => $riskInformationMarkingDetailsFieldsIncluded,
			"action" => "add"
	];
	$riskInformationMarkingDetails = new CyberSource\Model\Riskv1decisionsidmarkingRiskInformationMarkingDetails($riskInformationMarkingDetailsArr);

	$riskInformationArr = [
			"markingDetails" => $riskInformationMarkingDetails
	];
	$riskInformation = new CyberSource\Model\Riskv1decisionsidmarkingRiskInformation($riskInformationArr);

	$requestObjArr = [
			"riskInformation" => $riskInformation
	];
	$requestObj = new CyberSource\Model\FraudMarkingActionRequest($requestObjArr);

	$commonElement = new CyberSource\ExternalConfiguration();
	$config = $commonElement->ConnectionHost();
	$merchantConfig = $commonElement->merchantConfigObject();

	$api_client = new CyberSource\ApiClient($config, $merchantConfig);
	$api_instance = new CyberSource\Api\DecisionManagerApi($api_client);

	try {
		$apiResponse = $api_instance->fraudUpdate($id, $requestObj);
		print_r(PHP_EOL);
		print_r($apiResponse);

		return $apiResponse;
	} catch (Cybersource\ApiException $e) {
		print_r($e->getResponseBody());
		print_r($e->getMessage());
	}
}

if(!defined('DO_NOT_RUN_SAMPLES')){
	echo "\nFraudMarking Sample Code is Running..." . PHP_EOL;
	$id = "5825489395116729903003";
	FraudMarking($id);
}
?>