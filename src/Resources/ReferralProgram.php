<?php

namespace JeffersonGoncalves\Beehiiv\Resources;

use JeffersonGoncalves\Beehiiv\BeehiivClient;
use JeffersonGoncalves\Beehiiv\Resources\Concerns\ResolvesPublicationId;

class ReferralProgram
{
    use ResolvesPublicationId;

    public function __construct(
        protected BeehiivClient $client,
        protected ?string $publicationId = null,
    ) {}

    public function get(?string $publicationId = null): array
    {
        $publicationId = $this->resolvePublicationId($publicationId);

        return $this->client->get("/publications/{$publicationId}/referral_program");
    }
}
