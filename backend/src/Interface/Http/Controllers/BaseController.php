<?php declare(strict_types = 1);

namespace App\Interface\Http\Controllers;

use Psr\Http\Message\ResponseInterface as Response;

abstract class BaseController
{

	public function makeDataResponse(Response $response, array $data, int $statusCode): Response
	{
		$json = json_encode([
			'status' => $this->getStatus($statusCode),
			'data' => $data,
		]);

		return $this->prepareJsonResponse($response, $json, $statusCode);
	}


	public function makeMessageResponse(Response $response, string $message, int $statusCode): Response
	{
		$json = json_encode([
			'status' => $this->getStatus($statusCode),
			'message' => $message,
		]);

		return $this->prepareJsonResponse($response, $json, $statusCode);
	}

	private function prepareJsonResponse($response, string $jsonData, int $statusCode): Response
	{
		$response->getBody()->write($jsonData);

		return $response->withStatus($statusCode)->withHeader('Content-Type', 'application/json');
	}

	private function getStatus(int $statusCode): string
	{
		if ($statusCode <= 299) {
			return "success";
		} elseif ($statusCode >= 300 && $statusCode <= 399) {
			return "redirect";
		} else {
			return "error";
		}

	}
}