<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$app->post('/files', function (Request $request, Response $response, $args) use ($app) {
    $params = $request->getParams();
    return $response->withJson($params);
});