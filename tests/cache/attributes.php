<?php
// AUTO-GENERATED FILE - DO NOT EDIT

return array (
  'Lento\\Tests\\Fixtures\\CustomersController' => 
  array (
    '__class' => 
    array (
      0 => 
      array (
        'name' => 'Lento\\Attributes\\Controller',
        'args' => 
        array (
          0 => '/customers',
        ),
      ),
    ),
    'methods' => 
    array (
      'index' => 
      array (
        '__method' => 
        array (
          0 => 
          array (
            'name' => 'Lento\\Attributes\\Get',
            'args' => 
            array (
            ),
          ),
        ),
        'parameters' => 
        array (
          'request' => 
          array (
          ),
        ),
      ),
      'getOrdersByCustomerId' => 
      array (
        '__method' => 
        array (
          0 => 
          array (
            'name' => 'Lento\\Attributes\\Get',
            'args' => 
            array (
              0 => '/{customerId}/orders',
            ),
          ),
          1 => 
          array (
            'name' => 'Lento\\Attributes\\Summary',
            'args' => 
            array (
              0 => 'List customer orders',
            ),
          ),
          2 => 
          array (
            'name' => 'Lento\\Attributes\\Tags',
            'args' => 
            array (
              0 => 
              array (
                0 => 'orders',
                1 => 'customers',
              ),
            ),
          ),
        ),
        'parameters' => 
        array (
          'customerId' => 
          array (
            0 => 
            array (
              'name' => 'Lento\\Attributes\\Param',
              'args' => 
              array (
              ),
            ),
          ),
        ),
      ),
    ),
  ),
  'Lento\\Tests\\Fixtures\\OrdersController' => 
  array (
    '__class' => 
    array (
      0 => 
      array (
        'name' => 'Lento\\Attributes\\Controller',
        'args' => 
        array (
          0 => '/orders',
        ),
      ),
      1 => 
      array (
        'name' => 'Lento\\Attributes\\Tags',
        'args' => 
        array (
          0 => 
          array (
            0 => 'orders',
          ),
        ),
      ),
    ),
    'methods' => 
    array (
      'placeOrder' => 
      array (
        '__method' => 
        array (
          0 => 
          array (
            'name' => 'Lento\\Attributes\\Post',
            'args' => 
            array (
            ),
          ),
          1 => 
          array (
            'name' => 'Lento\\Attributes\\Summary',
            'args' => 
            array (
              0 => 'Place an order',
            ),
          ),
        ),
      ),
      'ping' => 
      array (
        '__method' => 
        array (
          0 => 
          array (
            'name' => 'Lento\\Attributes\\Get',
            'args' => 
            array (
              0 => '/{orderId}',
            ),
          ),
          1 => 
          array (
            'name' => 'Lento\\Attributes\\Summary',
            'args' => 
            array (
              0 => 'Get order details',
            ),
          ),
        ),
      ),
    ),
  ),
  'Lento\\OpenAPI\\OpenAPIController' => 
  array (
    '__class' => 
    array (
      0 => 
      array (
        'name' => 'Lento\\Attributes\\Ignore',
        'args' => 
        array (
        ),
      ),
      1 => 
      array (
        'name' => 'Lento\\Attributes\\Controller',
        'args' => 
        array (
          0 => '/openapi',
        ),
      ),
    ),
    'properties' => 
    array (
      'router' => 
      array (
        0 => 
        array (
          'name' => 'Lento\\Attributes\\Inject',
          'args' => 
          array (
          ),
        ),
      ),
    ),
    'methods' => 
    array (
      'index' => 
      array (
        '__method' => 
        array (
          0 => 
          array (
            'name' => 'Lento\\Attributes\\Get',
            'args' => 
            array (
            ),
          ),
          1 => 
          array (
            'name' => 'Lento\\Attributes\\FileFormatter',
            'args' => 
            array (
              'filename' => 'documentation.html',
              'mimetype' => 'text/html',
              'download' => false,
            ),
          ),
        ),
      ),
      'spec' => 
      array (
        '__method' => 
        array (
          0 => 
          array (
            'name' => 'Lento\\Attributes\\Get',
            'args' => 
            array (
              0 => '/spec.json',
            ),
          ),
          1 => 
          array (
            'name' => 'Lento\\Attributes\\FileFormatter',
            'args' => 
            array (
              'filename' => 'spec.json',
              'mimetype' => 'application/json',
              'download' => false,
            ),
          ),
        ),
      ),
    ),
  ),
);