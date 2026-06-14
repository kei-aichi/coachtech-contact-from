<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Contact;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_page_redirects_to_login_when_not_authenticated(): void
    {
        $response = $this->get('/admin');

        $response->assertRedirect('/login');
    }

    public function test_authenticated_user_can_access_admin_page(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/admin');

        $response->assertStatus(200);
    }

    public function test_user_can_login(): void
    {
        $user = User::factory()->create();

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertRedirect('/admin');

        $this->assertAuthenticatedAs($user);
    }

    public function test_user_can_logout(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/logout');

        $response->assertRedirect('/');

        $this->assertGuest();
    }

    public function test_guest_cannot_access_admin(): void
    {
        $response = $this->get('/admin');

        $response->assertRedirect('/login');
    }

    public function test_guest_cannot_export_contacts(): void
    {
        $response = $this->get('/export');

        $response->assertRedirect('/login');
    }

    public function test_guest_cannot_delete_contact(): void
    {
        Category::create([
            'content' => '商品のお届けについて',
        ]);

        $contact = Contact::factory()->create();

        $response = $this->delete("/contacts/{$contact->id}");

        $response->assertRedirect('/login');
    }
}
