<?php

return [
  'key' => env('ORCHESTRATE_API_KEY', 'your_api_key'),
  'host' => 'https://api.orchestrate.io/',
  'version' => 'v0',

  'cache_driver' => env('ORCHESTRATE_CACHE_DRIVER','array')
];
