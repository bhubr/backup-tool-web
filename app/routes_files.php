<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use bhubr\HashBack\Model\File;

$app->post('/files', function (Request $request, Response $response, $args) use ($app) {
    $params = $request->getParams();
    $attrs = $request->getParsedBody();
    $attrs['type'] = 'D';
    $attrs['parent_id'] = 1;
    // var_dump($attrs);die();
    try {
        $file = File::create($attrs);    
    } catch(\Exception $e) {
        die($e->getMessage());
    }
    
    // $file=File::find(1);
    // var_dump(is_object($file));die();
    return $response->withJson($file);
});