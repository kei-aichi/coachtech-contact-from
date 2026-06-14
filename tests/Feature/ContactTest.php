<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Contact;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactTest extends TestCase
{
    use RefreshDatabase;

    public function test_contact_can_be_created(): void
    {
        $category = Category::create([
            'content' => '商品のお届けについて',
        ]);

        $response = $this->post('/contacts', [
            'category_id' => $category->id,
            'first_name' => '太郎',
            'last_name' => '山田',
            'gender' => 1,
            'email' => 'test@example.com',
            'tel1' => '090',
            'tel2' => '1234',
            'tel3' => '5678',
            'address' => '愛知県',
            'building' => 'テストビル',
            'detail' => 'お問い合わせ内容です',
        ]);

        $response->assertRedirect('/thanks');

        $this->assertDatabaseHas('contacts', [
            'first_name' => '太郎',
            'last_name' => '山田',
            'email' => 'test@example.com',
            'tel' => '09012345678',
        ]);
    }

    public function test_contact_validation_fails_when_required_fields_are_empty(): void
    {
        $response = $this->post('/confirm', []);

        $response->assertSessionHasErrors([
            'first_name',
            'last_name',
            'gender',
            'email',
            'tel1',
            'tel2',
            'tel3',
            'address',
            'category_id',
            'detail',
        ]);
    }

    public function test_contact_can_be_deleted(): void
    {
        Category::create([
            'content' => '商品のお届けについて',
        ]);

        $contact = Contact::factory()->create();

        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->delete(route('contacts.destroy', $contact));

        $response->assertRedirect('/admin');

        $this->assertDatabaseMissing('contacts', [
            'id' => $contact->id,
        ]);
    }

    public function test_admin_page_can_search_contacts_by_keyword(): void
    {
        $category = Category::create([
            'content' => '商品のお届けについて',
        ]);

        Contact::create([
            'category_id' => $category->id,
            'first_name' => '太郎',
            'last_name' => '山田',
            'gender' => 1,
            'email' => 'taro@example.com',
            'tel' => '09012345678',
            'address' => '愛知県',
            'building' => 'テストビル',
            'detail' => 'テストお問い合わせ',
        ]);

        Contact::create([
            'category_id' => $category->id,
            'first_name' => '花子',
            'last_name' => '佐藤',
            'gender' => 2,
            'email' => 'hanako@example.com',
            'tel' => '08012345678',
            'address' => '東京都',
            'building' => null,
            'detail' => '別のお問い合わせ',
        ]);

        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/admin?keyword=山田');

        $response->assertStatus(200);
        $response->assertSee('山田');
        $response->assertDontSee('佐藤');
    }

    public function test_contacts_can_be_exported(): void
    {
        $category = Category::create([
            'content' => '商品のお届けについて',
        ]);

        Contact::factory()->create([
            'category_id' => $category->id,
        ]);

        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/export');

        $response->assertStatus(200);

        $response->assertHeader(
            'content-disposition',
            'attachment; filename=contacts.csv'
        );
    }
}