<?php

beforeEach(function () {

    freshDatabase();


    $this->userRawData = [
        'email' => factory()->email(),
        'password' => '123',
    ];
});

describe('Register user', function () {
    test('user can register', function () {


        $response = client('POST', '/api/register', [
            'json' => [
                'email' => $this->userRawData['email'],
                'password' => $this->userRawData['password']
            ]
        ]);

        expect($response->getStatusCode())
            ->toBe(200);

        expect($response->getContent())
            ->toBeSuccessFormat();

        $json = json_decode($response->getContent(), true);

        expect($json['data'])
            ->toHaveKey('email')
            ->toHaveKey('password')
            ->and($json['data']['email'])->toBe($this->userRawData['email'])
            ->and(password_verify($this->userRawData['password'], $json['data']['password']))->toBeTrue();

    });


    test('user may get error when registering with existing email', function () {


        // Register first time
        $response = client('POST', '/api/register', [
            'json' => $this->userRawData
        ]);

        expect($response->getStatusCode())
            ->toBe(200);

        $response_2 = client('POST', '/api/register', [
            'json' => $this->userRawData
        ]);
        expect($response_2->getStatusCode())->toBe(422);

        expect($response_2->getContent(false))
            ->toBeJson();

        $responseArray = json_decode($response_2->getContent(false), true);
        expect($responseArray)
            ->toHaveKeys(['code', 'message', 'success', 'errors'])
            ->and($responseArray['code'])->toBe(422)
            ->and($responseArray['success'])->toBeFalse()
            ->and($responseArray['errors'])->toHaveKey('email');


    });

    test('user may get error when registering with invalid email', function ($email) {

        $response = client('POST', '/api/register', [
            'json' => [
                'email' => $email,
                'password' => $this->userRawData['password']
            ]
        ]);

        expect($response->getStatusCode())->toBe(422);

        expect($response->getContent(false))
            ->toBeErrorFormat(422);
        $responseArray = json_decode($response->getContent(false), true);
        expect($responseArray)->toHaveKey('errors'); // Fail here if missing
        expect($responseArray['errors'])->toHaveKey('email');


    })->with(
        ['invalid email' => 'test'],
        ['empty email' => ''],
        ['email without domain' => 'test@'],
        ['email without @' => 'test.com'],
        ['email with spaces' => 'test @example.com']
    );

    test('user may get error when registering with invalid password', function ($password) {

        $response = client('POST', '/api/register', [
            'json' => [
                'email' => $this->userRawData['email'],
                'password' => $password
            ]
        ]);

        expect($response->getStatusCode())->toBe(422);

        expect($response->getContent(false))
            ->toBeErrorFormat(422);

        $responseArray = json_decode($response->getContent(false), true);
        expect($responseArray)->toHaveKey('errors'); // Fail here if missing
        expect($responseArray['errors'])->toHaveKey('password');

    })->with(
        ['at least 8 character' => "We44123"],
        ['empty password'=> ""],
        ['password with spaces'=> "123 123"],
        ['password with special characters'=> "123!@#DErfg"]
    );
});

