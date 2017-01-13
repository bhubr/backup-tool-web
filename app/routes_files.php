<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use bhubr\HashBack\Model\File;

$app->post('/files', function (Request $request, Response $response, $args) use ($app) {
    $attrs = $request->getParsedBody();
    $params = $request->getParams();

    $isMp3 = array_key_exists('mp3_md5', $attrs);
    try {
        $existingFile = null;
        if($attrs['type'] == 'F') {
            $md5Field = $isMp3 ? 'mp3_md5' : 'md5';
            $existingFile = File::where($md5Field, '=', $attrs[$md5Field])
                ->where('name', '=', $attrs['name'])
                ->where('parent_id', '=', $attrs['parent_id'])->first();
            if($existingFile && $isMp3 && $existingFile->md5 !== $attrs['md5']) {
                error_log(sprintf("%s: md5 change - %s => %s ", $existingFile->name, $existingFile->md5, $attrs['md5']));
            }
        }
        else if($attrs['type'] == 'D') {
            $existingFile = File::where('name', '=', $attrs['name'])
                ->where('parent_id', '=', $attrs['parent_id'])->first();
        }
        if($attrs['type'] == 'D') $attrs['md5'] = '';
        $attrs['volume_id'] = $_SESSION['volume_id'];

        $fileExists = ! is_null( $existingFile );
        if( ! $fileExists ) {
            $file = File::create($attrs);
        }
        $payload = [
            'success' => true,
            'created' => ! $fileExists,
            'file'    => $fileExists ? $existingFile : $file
        ];
    } catch(\Exception $e) {
        $errMessage = substr($e->getMessage(), 0, 3500);
        return $response->withStatus(500)->withJson(['success' => false, 'error' => $errMessage]);
    }
    return $response->withJson($payload);
});