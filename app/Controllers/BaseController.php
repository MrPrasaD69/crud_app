<?php

namespace App\Controllers;

use App\Models\CityModel;
use App\Models\StateModel;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;


abstract class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
  
     *
     * @var array
     */
    protected $helpers = [];

    

    /**
     * @return void
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

    }

    public function getCityData(){
        $model_city = new CityModel;
        $city_data = $model_city->orderBy('city_name','ASC')->findAll();
        return $city_data;
    }

    public function getStateData(){
        $model_state = new StateModel;
        $state_data = $model_state->orderBy('state_name','ASC')->findAll();
        return $state_data;
    }
}
