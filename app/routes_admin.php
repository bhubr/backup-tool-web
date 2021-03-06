<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Cartalyst\Sentinel\Users\EloquentUser;
use Illuminate\Support\Str;
use Doctrine\Common\Inflector\Inflector;

$app->get('/admin', function (Request $request, Response $response, $args) use ($app) {
    $loggedUser = $app->getContainer()->sentinel->check();

    if (!$loggedUser) {
        echo 'You need to be logged in to access this page.';

        return;
    }

    if (!$loggedUser->hasAccess('user.*')) {
        echo "You don't have the permission to access this page.";

        return;
    }

    // echo 'Welcome to the admin page.';
    $app->getContainer()->view->render($response, 'admin/index.twig');
});

$app->get('/admin/{plural}', function (Request $request, Response $response, $args) use ($app) {
    $name = $request->getAttribute('csrf_name');
    $value = $request->getAttribute('csrf_value');

    $models = ['users', 'hosts', 'volumes', 'files'];
    $plural = $args['plural'];
    $singular = Inflector::singularize($plural);
    $modelClass = 'bhubr\\HashBack\\Model\\' . ucfirst($singular);
    // if( !in_array($args['what'], $authorizedModels))
    // $models = array_map( function($plural) {
    //     $plural = 
    //     return [
    //         'plural' => $plural,
    //         'labelPlural' => ucfirst($plural)
    //     ];
    // }, $authorizedModels );

    $fields = [
        'users'   => ['first_name', 'last_name', 'email'],
        'hosts'   => ['parent_id', 'name', 'type', 'md5'],
        'volumes' => ['name', 'mount_point', 'uuid'],
        'files'   => ['parent_id', 'name', 'type', 'md5']
    ];

    $loggedUser = $app->getContainer()->sentinel->check();

    if (!$loggedUser) {
        echo 'You need to be logged in to access this page.';

        return;
    }

    if (!$loggedUser->hasAccess('user.*')) {
        echo "You don't have the permission to access this page.";

        return;
    }

    $entries = $modelClass::all();

    // echo 'Welcome to the admin page.';
    $app->getContainer()->view->render($response, 'admin/tables.twig', [
        'entries' => $entries,
        'csrfName' => $name,
        'csrfValue' => $value,
        'models' => $models,
        'plural' => $plural,
        'fields' => $fields[$plural]
    ]);
});

// $app->get('/admin/places', function (Request $request, Response $response, $args) use ($app) {
//     // $session = new \RKA\Session();
//     // $user = $session->get('user');
//     $name = $request->getAttribute('csrf_name');
//     $value = $request->getAttribute('csrf_value');

//     $entries = Place::all();
//     // $countries = Country::all();

//     // $this->view->offsetSet('user', $user );
//     // $this->view->offsetSet('loggedIn', ! empty($user) );
//     $this->view->render($response, 'admin/places.twig', [
//         'entries'   => $entries,
//         'csrfName' => $name,
//         'csrfValue' => $value

//         // 'countries' => $countries
//     ]);
//     return $response;
// } );

// $app->get('/admin/places/{id}', function (Request $request, Response $response, $args) use ($app) {
//     $route = $request->getAttribute('route');
//     $id = $route->getArgument('id');
//     $entry = Place::find($id);

//     $name = $request->getAttribute('csrf_name');
//     $value = $request->getAttribute('csrf_value');

//     $this->view->render($response, 'admin/place_edit.twig', [
//         'entry'   => $entry,
//         'csrfName' => $name,
//         'csrfValue' => $value
//     ]);
//     return $response;
// } );

// $app->post('/admin/places', function (Request $request, Response $response, $args) use ($app) {
//     $attributes = $request->getParsedBody();
//     $attributes['slug'] = Str::slug($attributes['name']);
//     // $country = Country::find($attributes['country_id']);
//     try {
//         $place = Place::create($attributes);
//         // $place->country()->associate($country);
//         // $place->save();
//     } catch( \Exception $e ) {
//         die( $e->getMessage() . " " . $e->getCode() );
//     }
//     $uri = $request->getUri();
//     return $response = $response->withRedirect($uri); //, 403);
// } );

// $app->get('/admin/schools', function (Request $request, Response $response, $args) use ($app) {
//     // $session = new \RKA\Session();
//     // $user = $session->get('user');
//     $name = $request->getAttribute('csrf_name');
//     $value = $request->getAttribute('csrf_value');

//     $entries = School::all();
//     // $countries = Country::all();

//     // $this->view->offsetSet('user', $user );
//     // $this->view->offsetSet('loggedIn', ! empty($user) );
//     $this->view->render($response, 'admin/schools.twig', [
//         'entries'   => $entries,
//         'csrfName' => $name,
//         'csrfValue' => $value

//         // 'countries' => $countries
//     ]);
//     return $response;
// } );

// $app->post('/admin/schools', function (Request $request, Response $response, $args) use ($app) {
//     $attributes = $request->getParsedBody();
//     $attributes['slug'] = Str::slug($attributes['name']);
//     // $country = Country::find($attributes['country_id']);
//     try {
//         $school = School::create($attributes);
//         // $place->country()->associate($country);
//         // $place->save();
//     } catch( \Exception $e ) {
//         die( $e->getMessage() . " " . $e->getCode() );
//     }
//     $uri = $request->getUri();
//     return $response = $response->withRedirect($uri); //, 403);
// } );

// $app->get('/admin/schools/{slug}', function (Request $request, Response $response, $args) use ($app) {
//     $route = $request->getAttribute('route');
//     $slug = $route->getArgument('slug');
//     $entry = School::where('slug', '=', $slug)->first();

//     $name = $request->getAttribute('csrf_name');
//     $value = $request->getAttribute('csrf_value');

//     $this->view->render($response, 'admin/school_edit.twig', [
//         'entry'   => $entry,
//         'csrfName' => $name,
//         'csrfValue' => $value
//     ]);
//     return $response;
// } );

// $app->post('/admin/schools/{slug}', function (Request $request, Response $response, $args) use ($app) {
//     $route = $request->getAttribute('route');
//     $slug = $route->getArgument('slug');
//     $entry = School::where('slug', '=', $slug)->first();

//     $params = $request->getParams();

//     if (array_key_exists('places', $params)) {
//         $placeIds = array_keys($params['places']);
//         foreach( $placeIds as $placeId ) {
//             $entry->places()->attach($placeId);
//         }
//     }

//     $newValues = [
//         'name' => $params['name'],
//         'slug' => $params['slug'],
//     ];
//     $entry->fill($newValues);
//     $entry->save();

//     return $response;
// } );



// $app->post('/admin/users', function (Request $request, Response $response, $args) use ($app) {
//     $attributes = $request->getParsedBody();
//     $attributes['password'] = 'toto';
//     $attributes['email'] = Str::slug($attributes['first_name']) . '.' . Str::slug($attributes['last_name']) . '@local.net';
//     // $attributes['slug'] = Str::slug($attributes['name']);
//     // $country = Country::find($attributes['country_id']);
//     try {
//         $place = EloquentUser::create($attributes);
//         // $place->country()->associate($country);
//         // $place->save();
//     } catch( \Exception $e ) {
//         die( $e->getMessage() . " " . $e->getCode() );
//     }
//     $uri = $request->getUri();
//     return $response = $response->withRedirect($uri); //, 403);
// } );


// $app->get('/admin/styles', function (Request $request, Response $response, $args) use ($app) {
//     $name = $request->getAttribute('csrf_name');
//     $value = $request->getAttribute('csrf_value');

//     $entries = Style::all();
//     $this->view->render($response, 'admin/styles.twig', [
//         'entries'   => $entries,
//         'csrfName' => $name,
//         'csrfValue' => $value
//     ]);
//     return $response;
// } );

// $app->post('/admin/styles', function (Request $request, Response $response, $args) use ($app) {
//     $attributes = $request->getParsedBody();
//     $attributes['slug'] = Str::slug($attributes['name']);
//     try {
//         $style = Style::create($attributes);
//     } catch( \Exception $e ) {
//         die( $e->getMessage() . " " . $e->getCode() );
//     }
//     $uri = $request->getUri();
//     return $response = $response->withRedirect($uri); //, 403);
// } );
