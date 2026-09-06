<?php

namespace JeffersonGoncalves\Beehiiv\Resources;

use InvalidArgumentException;
use JeffersonGoncalves\Beehiiv\BeehiivClient;
use JeffersonGoncalves\Beehiiv\Resources\Concerns\ResolvesPublicationId;

class Subscriptions
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
            'email' => $filters['email'] ?? null,
            'status' => $filters['status'] ?? null,
            'tier' => $filters['tier'] ?? null,
            'cursor' => $filters['cursor'] ?? null,
            'expand[]' => $filters['expand'] ?? null,
        ], fn (mixed $value) => $value !== null);

        return $this->client->get("/publications/{$publicationId}/subscriptions", $query);
    }

    public function get(string $id, ?string $publicationId = null): array
    {
        $publicationId = $this->resolvePublicationId($publicationId);

        return $this->client->get("/publications/{$publicationId}/subscriptions/{$id}");
    }

    /** @param array<string, mixed> $attributes */
    public function create(array $attributes, ?string $publicationId = null): array
    {
        if (empty($attributes['email'])) {
            throw new InvalidArgumentException('The "email" attribute is required.');
        }

        $publicationId = $this->resolvePublicationId($publicationId);

        return $this->client->post("/publications/{$publicationId}/subscriptions", $attributes);
    }

    /** @param array<string, mixed> $attributes */
    public function update(string $id, array $attributes, ?string $publicationId = null): array
    {
        $publicationId = $this->resolvePublicationId($publicationId);

        return $this->client->put("/publications/{$publicationId}/subscriptions/{$id}", $attributes);
    }

    public function delete(string $id, ?string $publicationId = null): array
    {
        $publicationId = $this->resolvePublicationId($publicationId);

        return $this->client->delete("/publications/{$publicationId}/subscriptions/{$id}");
    }
}
