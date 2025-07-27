<?php

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| The closure you provide to your test functions is always bound to a specific PHPUnit test
| case class. By default, that class is "PHPUnit\Framework\TestCase". Of course, you may
| need to change it using the "pest()" function to bind a different classes or traits.
|
*/

pest()->extend(Tests\TestCase::class)->in('Feature');

const BASE_DIR = __DIR__ . '/../';
/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
|
| When you're writing tests, you often need to check that values meet certain conditions. The
| "expect()" function gives you access to a set of "expectations" methods that you can use
| to assert different things. Of course, you may extend the Expectation API at any time.
|
*/

expect()->extend('toBeSuccessFormat', function () {

    return $this->toBeJson()
        ->json()
        ->toHaveKey('code')
        ->toHaveKey('message')
        ->toHaveKey('success')
        ->toHaveKey('data')
        ->data;
});

expect()->extend('toBeErrorFormat', function (int $code) {

    return $this->toBeJson()
        ->json()
        ->toHaveKeys(['code', 'message', 'success'])
        ->success->toBeFalse()
        ->code->toBe($code);
});

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
|
| While Pest is very powerful out-of-the-box, you may have some testing code specific to your
| project that you don't want to repeat in every file. Here you can also expose helpers as
| global functions to help you to reduce the number of lines of code in your test files.
|
*/

function factory()
{
    return \Faker\Factory::create();
}

function repository($repositoryClass)
{
    $database = new \Core\Database();
    return new $repositoryClass($database);
}

/**
 * remove all data from the database
 *
 * @return void
 */
function freshDatabase(): void
{
    // Reset the database or any necessary setup before each test
    $database = new \Core\Database();
    $database->reset();
}

/**
 * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
 */
function client($method = 'GET', $uri = '', $options = []): \Symfony\Contracts\HttpClient\ResponseInterface
{
    $client = \Symfony\Component\HttpClient\HttpClient::create([
        "base_uri" => "http://localhost:8888",
        "headers" => [
            "Accept" => "application/json",
            "Content-Type" => "application/json",
        ],
    ]);

    return $client->request($method, $uri, $options);
}