<?php

namespace app\controllers;

use yii\rest\Controller;
use yii\filters\ContentNegotiator;
use yii\web\Response;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'contentNegotiator' => [
                'class' => ContentNegotiator::class,
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                ],
            ],
        ];
    }

    /**
     * @OA\Get(
     *     path="/",
     *     summary="API Information",
     *     tags={"Info"},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="ok"),
     *             @OA\Property(property="message", type="string", example="Welcome to Car Ads API"),
     *             @OA\Property(
     *                 property="endpoints",
     *                 type="object",
     *                 @OA\Property(property="POST /car/create", type="string", example="Create new car ad"),
     *                 @OA\Property(property="GET /car/{id}", type="string", example="Get car ad by ID"),
     *                 @OA\Property(property="GET /car/list", type="string", example="List all car ads")
     *             )
     *         )
     *     )
     * )
     */
    public function actionIndex()
    {
        return [
            'status' => 'ok',
            'message' => 'Welcome to Car Ads API',
            'endpoints' => [
                'POST /car/create' => 'Create new car ad',
                'GET /car/{id}' => 'Get car ad by ID',
                'GET /car/list' => 'List all car ads',
                'GET /' => 'API information (this page)'
            ]
        ];
    }

    /**
     * @OA\Get(
     *     path="/ping",
     *     summary="Health check",
     *     tags={"Health"},
     *     @OA\Response(
     *         response=200,
     *         description="Service status",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="ok"),
     *             @OA\Property(property="timestamp", type="string", example="2023-01-01T12:00:00+00:00")
     *         )
     *     )
     * )
     */
    public function actionPing()
    {
        return [
            'status' => 'ok',
            'timestamp' => date('c')
        ];
    }

    /**
     * @OA\Get(
     *     path="/version",
     *     summary="API Version",
     *     tags={"Info"},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", example="Car Ads API"),
     *             @OA\Property(property="version", type="string", example="1.0.0"),
     *             @OA\Property(property="environment", type="string", example="development")
     *         )
     *     )
     * )
     */
    public function actionVersion()
    {
        return [
            'name' => 'Car Ads API',
            'version' => '1.0.0',
            'environment' => YII_ENV
        ];
    }
}
