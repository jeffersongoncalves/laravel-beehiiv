<?php

namespace JeffersonGoncalves\Beehiiv\Resources;

use JeffersonGoncalves\Beehiiv\BeehiivClient;

class Publications
{
    public function __construct(
        protected BeehiivClient $client,
    ) {}

    public function list(): array
    {
        return $this->client->get('/publications');
    }

    public function get(string $publicationId): array
    {
        return $this->client->get("/publications/{$publicationId}");
    }
}
