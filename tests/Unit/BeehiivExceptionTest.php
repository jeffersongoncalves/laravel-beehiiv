<?php

use Illuminate\Http\Client\Response;
use Illuminate\Http\Client\Response as HttpResponse;
use JeffersonGoncalves\Beehiiv\Exceptions\BeehiivException;

function fakeBeehiivResponse(int $status, array $body): Response
{
    $psr = new GuzzleHttp\Psr7\Response($status, [], json_encode($body));

    return new HttpResponse($psr);
}

it('builds the exception message from the response "message" field', function () {
    $response = fakeBeehiivResponse(404, ['message' => 'Subscription not found']);

    $exception = BeehiivException::fromResponse($response);

    expect($exception->getMessage())->toBe('Subscription not found')
        ->and($exception->getCode())->toBe(404)
        ->and($exception->errorBody())->toBe(['message' => 'Subscription not found']);
});

it('falls back to the first error title when "message" is missing', function () {
    $response = fakeBeehiivResponse(422, ['errors' => [['title' => 'Email is invalid']]]);

    $exception = BeehiivException::fromResponse($response);

    expect($exception->getMessage())->toBe('Email is invalid');
});

it('falls back to a generic message when the body has no known error keys', function () {
    $response = fakeBeehiivResponse(500, []);

    $exception = BeehiivException::fromResponse($response);

    expect($exception->getMessage())->toBe('Beehiiv API error (HTTP 500).');
});
