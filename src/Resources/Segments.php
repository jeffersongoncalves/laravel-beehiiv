<?php

namespace JeffersonGoncalves\Beehiiv\Resources;

use JeffersonGoncalves\Beehiiv\BeehiivClient;
use JeffersonGoncalves\Beehiiv\Resources\Concerns\ResolvesPublicationId;

class Segments
{
    use ResolvesPublicationId;

    public function __construct(
        protected BeehiivClient $client,
        protected ?string $publicationId = null,
    ) {}

    public function list(?string $publicationId = null): array
    {
        $publicationId = $this->resolvePublicationId($publicationId);

        return $this->client->get("/publications/{$publicationId}/segments");
    }

    public function get(string $id, ?string $publicationId = null): array
    {
        $publicationId = $this->resolvePublicationId($publicationId);

        return $this->client->get("/publications/{$publicationId}/segments/{$id}");
    }
}
