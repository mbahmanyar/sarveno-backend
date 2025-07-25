<?php

beforeEach(function () {

    freshDatabase();

    $this->user = repository(\App\Repositories\UserRepository::class)
        ->create(\App\Models\User::initiate(
            [
                'email' => factory()->email(),
                'password' => 'Aa123456'
            ])->hashPassword());

    $this->token = new \Core\Token()->generate($this->user->email);
});

test('user can see list of shopping items', function () {

    for ($i = 0; $i < 10; $i++) {
        repository(\App\Repositories\ShoppingItemRepository::class)
            ->create(
                \App\Models\ShoppingItem::initiate([
                    'user_id' => $this->user->id,
                    'name' => factory()->name(),
                    'note' => factory()->paragraph(),
                    'quantity' => 3
                ]));
    }


    $response = client('GET', '/api/shopping-items', [
        'headers' => [
            'Authorization' => "Bearer {$this->token}"]

    ]);

    expect($response->getStatusCode())->toBe(200);

    expect($response->getContent(false))
        ->toBeSuccessFormat();

    $data = json_decode($response->getContent(false), true)['data'];

    expect($data)->toBeArray()
        ->toHaveCount(10)
        ->each(function ($item) {
            $item->toHaveKey('id');
            $item->toHaveKey('user_id');
            $item->toHaveKey('name');
            $item->toHaveKey('note');
            $item->toHaveKey('quantity');
            $item->toHaveKey('is_checked');
            $item->toHaveKey('created_at');
            $item->toHaveKey('updated_at');
        });


});


test('user can see his shopping item', function () {

    $payload = [
        'user_id' => $this->user->id,
        'name' => factory()->name(),
        'note' => factory()->paragraph(),
        'quantity' => 3
    ];
    repository(\App\Repositories\ShoppingItemRepository::class)
        ->create(
            \App\Models\ShoppingItem::initiate($payload));

    $response = client('GET', '/api/shopping-items/1', [
        'headers' => [
            'Authorization' => "Bearer {$this->token}"]

    ]);

    expect($response->getStatusCode())->toBe(200);

    expect($response->getContent(false))
        ->toBeSuccessFormat();

    $responseArray = json_decode($response->getContent(false), true)['data'];

    expect($responseArray['user_id'])->toBe($this->user->id)
        ->and($responseArray['name'])->toBe($payload['name']);

})->only();