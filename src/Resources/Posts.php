<?php

namespace JeffersonGoncalves\Beehiiv\Resources;

use InvalidArgumentException;
use JeffersonGoncalves\Beehiiv\BeehiivClient;
use JeffersonGoncalves\Beehiiv\Resources\Concerns\ResolvesPublicationId;

class Posts
{
    use ResolvesPublicationId;

    public function __construct(
        protected BeehiivClient $client,
        protected ?string $publicationId = null,
        protected int $defaultLimit = 10,
    ) {}

    /** @param array<string, mixed> $filters */
    public function list(?string $publicationId = null, array $filters = []): array
    {
        $publicationId = $this->resolvePublicationId($publicationId);

        $query = array_filter([
            'limit' => $filters['limit'] ?? $this->defaultLimit,
            'status' => $filters['status'] ?? null,
            'cursor' => $filters['cursor'] ?? null,
        ], fn (mixed $value) => $value !== null);

        return $this->client->get("/publications/{$publicationId}/posts", $query);
    }

    public function get(string $id, ?string $publicationId = null): array
    {
        $publicationId = $this->resolvePublicationId($publicationId);

        return $this->client->get("/publications/{$publicationId}/posts/{$id}");
    }

    /** @param array<string, mixed> $attributes */
    public function create(array $attributes, ?string $publicationId = null): array
    {
        if (empty($attributes['title'])) {
            throw new InvalidArgumentException('The "title" attribute is required.');
        }

        $publicationId = $this->resolvePublicationId($publicationId);

        return $this->client->post("/publications/{$publicationId}/posts", $attributes);
    }

    public function delete(string $id, ?string $publicationId = null): array
    {
        $publicationId = $this->resolvePublicationId($publicationId);

        return $this->client->delete("/publications/{$publicationId}/posts/{$id}");
    }
}
