<?php

namespace JeffersonGoncalves\Beehiiv\Resources\Concerns;

use InvalidArgumentException;

/**
 * Shared by every publication-scoped resource so the
 * "explicit argument, else configured default, else throw" fallback
 * isn't duplicated across each resource class.
 */
trait ResolvesPublicationId
{
    protected function resolvePublicationId(?string $publicationId): string
    {
        $publicationId ??= $this->publicationId;

        if (empty($publicationId)) {
            throw new InvalidArgumentException('A publication ID is required. Pass one explicitly or set "beehiiv.publication_id".');
        }

        return $publicationId;
    }
}
