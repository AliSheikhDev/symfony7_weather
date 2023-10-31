<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use GuzzleHttp\Client;
use Symfony\Component\HttpFoundation\Request;

class WeatherConrollerController extends AbstractController
{
	protected $apiUrl = "https://api.openweathermap.org/data/2.5/weather";
	protected $apiKey;


	/**
     * @Route("/weather/form", name="api_form")
     */
	// #[Route('/weather/form', name: 'app_weather_conroller')]
    public function index()
    {
        return $this->render('weather.html.twig');
    }


	/**
	 * @request
	 * Taking Request param as a city name 
	 * 
	 * @response
	 * Response Json as a Weather data 
	 */


	#[Route('/weather/conroller/get_weather', name: 'app_weather_conroller_get_weather')]
    public function get_weather(Request $request): JsonResponse
    {
		$jsonData = json_decode($request->getContent(), true);
		$this->apiKey = $_ENV['WEATHER_API_KEY'];
		$city = reset($jsonData);
		
		$client = new Client();
		$params = [
			'q' => $city,
			'appid' => $this->apiKey,
		];
		$response = $client->request('GET', $this->apiUrl, [
			'query' => $params,
		]);
		
		// Get the response body as a string
		$responseBody = json_decode($response->getBody()->getContents());
		return $this->json([
            'data' => $responseBody,
        ]);
    }


}
