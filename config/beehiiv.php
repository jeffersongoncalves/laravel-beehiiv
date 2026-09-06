<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Beehiiv API Key
    |--------------------------------------------------------------------------
    |
    | Find it under Settings > Integrations > API in your Beehiiv account.
    |
    */
    'api_key' => env('BEEHIIV_API_KEY', ''),

    /*
    |--------------------------------------------------------------------------
    | Default Publication ID
    |--------------------------------------------------------------------------
    |
    | Optional. Used as the default publication scope so callers don't have
    | to pass a publication ID to every publication-scoped resource method.
    |
    */
    'publication_id' => env('BEEHIIV_PUBLICATION_ID'),

    /*
    |--------------------------------------------------------------------------
    | Default Pagination Limit
    |--------------------------------------------------------------------------
    |
    | Used as the default "limit" for list endpoints when none is given.
    |
    */
    'default_limit' => env('BEEHIIV_DEFAULT_LIMIT', 10),

];
