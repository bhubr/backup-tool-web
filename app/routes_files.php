<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use bhubr\HashBack\Model\File;

$app->post('/files', function (Request $request, Response $response, $args) use ($app) {
    try {
        $params = $request->getParams();
        $attrs = $request->getParsedBody();
        if($attrs['type'] == 'D') $attrs['md5'] = '';
        $attrs['volume_id'] = $_SESSION['volume_id'];
        // $attrs['type'] = 'D';
        // $attrs['parent_id'] = 1;
        // var_dump($attrs);die();
        $file = File::create($attrs);    
    } catch(\Exception $e) {
        $errMessage = substr($e->getMessage(), 0, 3500);
        return $response->withJson(['error' => $errMessage]);
    }
    
    // $file=File::find(1);
    // var_dump(is_object($file));die();
    // return $response->write('{xx\n');
    return $response->withJson($file);
});