<?php

it('returns a.blade.php successful response', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
});
