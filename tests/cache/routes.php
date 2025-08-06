<?php
// AUTO-GENERATED FILE - DO NOT EDIT

return array (
  'staticRoutes' => 
  array (
    'GET' => 
    array (
      '/customers' => 
      array (
        'httpMethod' => 'GET',
        'path' => '/customers',
        'regex' => NULL,
        'controller' => 'Lento\\Tests\\Fixtures\\CustomersController',
        'method' => 'index',
        'argPlan' => 
        array (
          0 => 
          array (
            'inject' => 'Request',
          ),
        ),
        'propInject' => 
        array (
        ),
        'formatter' => 
        array (
          'type' => 'json',
          'options' => NULL,
        ),
        'throws' => 
        array (
        ),
      ),
      '/openapi' => 
      array (
        'httpMethod' => 'GET',
        'path' => '/openapi',
        'regex' => NULL,
        'controller' => 'Lento\\OpenAPI\\OpenAPIController',
        'method' => 'index',
        'argPlan' => 
        array (
        ),
        'propInject' => 
        array (
          0 => 
          array (
            'name' => 'router',
            'type' => 'Lento\\Router',
          ),
        ),
        'formatter' => 
        array (
          'type' => 'Lento\\Attributes\\FileFormatter',
          'options' => 
          array (
            'mimetype' => 'text/html',
            'filename' => 'documentation.html',
            'download' => false,
          ),
        ),
        'throws' => 
        array (
        ),
      ),
      '/openapi/spec.json' => 
      array (
        'httpMethod' => 'GET',
        'path' => '/openapi/spec.json',
        'regex' => NULL,
        'controller' => 'Lento\\OpenAPI\\OpenAPIController',
        'method' => 'spec',
        'argPlan' => 
        array (
        ),
        'propInject' => 
        array (
          0 => 
          array (
            'name' => 'router',
            'type' => 'Lento\\Router',
          ),
        ),
        'formatter' => 
        array (
          'type' => 'Lento\\Attributes\\FileFormatter',
          'options' => 
          array (
            'mimetype' => 'application/json',
            'filename' => 'spec.json',
            'download' => false,
          ),
        ),
        'throws' => 
        array (
        ),
      ),
    ),
    'POST' => 
    array (
      '/orders' => 
      array (
        'httpMethod' => 'POST',
        'path' => '/orders',
        'regex' => NULL,
        'controller' => 'Lento\\Tests\\Fixtures\\OrdersController',
        'method' => 'placeOrder',
        'argPlan' => 
        array (
        ),
        'propInject' => 
        array (
        ),
        'formatter' => 
        array (
          'type' => 'json',
          'options' => NULL,
        ),
        'throws' => 
        array (
        ),
      ),
    ),
  ),
  'dynamicRoutes' => 
  array (
    'GET' => 
    array (
      0 => 
      array (
        'httpMethod' => 'GET',
        'path' => '/customers/{customerId}/orders',
        'regex' => '#^/customers/(?P<customerId>[^/]+)/orders$#',
        'controller' => 'Lento\\Tests\\Fixtures\\CustomersController',
        'method' => 'getOrdersByCustomerId',
        'argPlan' => 
        array (
          0 => 
          array (
            'inject' => 'Route',
            'name' => 'customerId',
          ),
        ),
        'propInject' => 
        array (
        ),
        'formatter' => 
        array (
          'type' => 'json',
          'options' => NULL,
        ),
        'throws' => 
        array (
        ),
      ),
      1 => 
      array (
        'httpMethod' => 'GET',
        'path' => '/orders/{orderId}',
        'regex' => '#^/orders/(?P<orderId>[^/]+)$#',
        'controller' => 'Lento\\Tests\\Fixtures\\OrdersController',
        'method' => 'ping',
        'argPlan' => 
        array (
        ),
        'propInject' => 
        array (
        ),
        'formatter' => 
        array (
          'type' => 'json',
          'options' => NULL,
        ),
        'throws' => 
        array (
        ),
      ),
    ),
  ),
  'services' => 
  array (
    0 => 'Lento\\Tests\\Fixtures\\CustomersController',
    1 => 'Lento\\Tests\\Fixtures\\OrdersController',
    2 => 'Lento\\OpenAPI\\OpenAPIController',
    3 => 'Lento\\Router',
  ),
);