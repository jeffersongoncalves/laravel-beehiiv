<?php

namespace JeffersonGoncalves\Beehiiv;

use JeffersonGoncalves\Beehiiv\Resources\Automations;
use JeffersonGoncalves\Beehiiv\Resources\Posts;
use JeffersonGoncalves\Beehiiv\Resources\Publications;
use JeffersonGoncalves\Beehiiv\Resources\ReferralProgram;
use JeffersonGoncalves\Beehiiv\Resources\Segments;
use JeffersonGoncalves\Beehiiv\Resources\Subscriptions;

/**
 * Entry point exposing one resource per Beehiiv API v2 group.
 */
class Beehiiv
{
    protected BeehiivClient $client;

    public function __construct(
        string $apiKey,
        protected ?string $publicationId = null,
        protected int $defaultLimit = 10,
    ) {
        $this->client = new BeehiivClient($apiKey);
    }

    public function publications(): Publications
    {
        return new Publications($this->client);
    }

    public function subscriptions(): Subscriptions
    {
        return new Subscriptions($this->client, $this->publicationId, $this->defaultLimit);
    }

    public function posts(): Posts
    {
        return new Posts($this->client, $this->publicationId, $this->defaultLimit);
    }

    public function segments(): Segments
    {
        return new Segments($this->client, $this->publicationId);
    }

    public function automations(): Automations
    {
        return new Automations($this->client, $this->publicationId);
    }

    public function referralProgram(): ReferralProgram
    {
        return new ReferralProgram($this->client, $this->publicationId);
    }
}
