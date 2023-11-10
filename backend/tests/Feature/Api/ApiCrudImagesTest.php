<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Image;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ApiCrudImagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_anUserCanDeleteOwnAbsences()
    {
        $password = 'password';

        $user1 = User::factory()->create([
            'email' => 'email1@example.com',
            'password' => bcrypt($password),
        ]);
        $user1Token = $user1->createToken('user1-token')->plainTextToken;

        $user2 = User::factory()->create([
            'email' => 'email2@example.com',
            'password' => bcrypt($password),
        ]);
        $user2Token = $user2->createToken('user2-token')->plainTextToken;

        $image1 = Image::factory()->create([
            'user_id' => $user1->id,
        ]);

        $image2 = Image::factory()->create([
            'user_id' => $user2->id,
        ]);

        // Login with user 1
        $response = $this->json('POST', 'api/auth/login', [
            'email' => $user1->email,
            'password' => $password,
        ]);

        /**
         * DELETING OWN IMAGE
         */
        $response = $this->withHeaders([
            'Authorization' => $user1Token,
            'Accept' => 'application/json'
        ])->postJson("api/auth/images");

        // Check that the user has only one image
        $response->assertStatus(200)
            ->assertJsonCount(1);

        $response = $this->withHeaders([
            'Authorization' => $user1Token,
            'Accept' => 'application/json'
        ])->delete("api/auth/deleteImage/{$image1->id}");

        // Check status and response when a user try to delete own image
        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Image successfully deleted',
            ]);

        // Check if image was really deleted from database
        $this->assertDatabaseMissing('images', [
            'id' => $image1->id,
        ]);

        /**
         * DELETING OTHERS IMAGE
         */

        $response = $this->withHeaders([
            'Authorization' => $user1Token,
            'Accept' => 'application/json'
        ])->delete("api/auth/deleteImage/{$image2->id}");

        // Check status and response when a user try to delete others image
        $response->assertStatus(403)
            ->assertJson([
                'message' => 'Not allowed to delete this image',
            ]);

        // Check images of the user 2
        $response = $this->json('POST', 'api/auth/login', [
            'email' => $user2->email,
            'password' => $password,
        ]);

        $response = $this->withHeaders([
            'Authorization' => $user2Token,
            'Accept' => 'application/json'
        ])->postJson("api/auth/images");

        // Check that the user has only one image
        $response->assertStatus(200)
            ->assertJsonCount(1);
    }
}
