<?php

namespace JeffersonGoncalves\Beehiiv\Resources;

use JeffersonGoncalves\Beehiiv\BeehiivClient;
use JeffersonGoncalves\Beehiiv\Resources\Concerns\ResolvesPublicationId;

class Automations
{
    use ResolvesPublicationId;

    public function __construct(
        protected BeehiivClient $client,
        protected ?string $publicationId = null,
    ) {}

    public function list(?string $publicationId = null): array
    {
        $publicationId = $this->resolvePublicationId($publicationId);

        return $this->client->get("/publications/{$publicationId}/automations");
    }

    public function get(string $id, ?string $publicationId = null): array
    {
        $publicationId = $this->resolvePublicationId($publicationId);

        return $this->client->get("/publications/{$publicationId}/automations/{$id}");
    }
}
