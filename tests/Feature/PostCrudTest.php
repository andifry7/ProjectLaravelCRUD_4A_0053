<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PostCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_cannot_access_protected_routes(): void
    {
        $this->get('/profile')->assertRedirect('/login');
        $this->get('/home')->assertRedirect('/login');
        $this->get('/posts/create')->assertRedirect('/login');
        $this->post('/posts', [])->assertRedirect('/login');
        $this->get('/posts/1/edit')->assertRedirect('/login');
        $this->put('/posts/1', [])->assertRedirect('/login');
        $this->delete('/posts/1')->assertRedirect('/login');
    }

    public function test_authenticated_user_can_access_profile_page(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/profile');

        $response->assertStatus(200);
        $response->assertSee($user->name);
        $response->assertSee($user->email);
        $response->assertSee('Ke Dashboard');
    }

    public function test_authenticated_user_sees_dashboard_with_posts(): void
    {
        $user = User::factory()->create();
        Post::create([
            'title'     => 'Berita Dashboard',
            'content'   => 'Konten dashboard.',
            'published' => 'yes',
            'publisher' => 'Redaksi',
            'image'     => null,
        ]);

        $response = $this->actingAs($user)->get('/home');

        $response->assertStatus(200);
        $response->assertSee('Berita Dashboard');
        $response->assertSee('Tambah Berita Baru');
        $response->assertSee('Edit');
        $response->assertSee('Hapus');
    }

    public function test_authenticated_user_can_create_post_with_image_upload(): void
    {
        Storage::fake('public');
        $user = User::factory()->create();

        $image = UploadedFile::fake()->image('news.jpg');

        $postData = [
            'title'      => 'Test News Title',
            'content'    => 'This is test content of the news.',
            'published'  => 'yes',
            'publisher'  => 'Media Test',
            'event_date' => '2026-07-17',
            'source_url' => 'https://example.com',
            'image'      => $image,
        ];

        $response = $this->actingAs($user)->post('/posts', $postData);

        $response->assertRedirect('/home');
        $this->assertDatabaseHas('posts', [
            'title'     => 'Test News Title',
            'publisher' => 'Media Test',
            'published' => 'yes',
        ]);

        $post = Post::first();
        $this->assertNotNull($post->image);
        Storage::disk('public')->assertExists($post->image);
    }

    public function test_anyone_can_read_post_details(): void
    {
        $post = Post::create([
            'title'     => 'Public News',
            'content'   => 'Content of public news.',
            'published' => 'yes',
            'publisher' => 'Publisher Public',
            'image'     => null,
        ]);

        $response = $this->get('/posts/' . $post->id);

        $response->assertStatus(200);
        $response->assertSee('Public News');
        $response->assertSee('Content of public news.');
    }

    public function test_public_index_does_not_show_crud_buttons(): void
    {
        $response = $this->get('/posts');

        $response->assertStatus(200);
        $response->assertDontSee('Tambah Berita Baru');
        $response->assertDontSee('route(\'posts.create\')');
    }

    public function test_authenticated_user_can_update_post(): void
    {
        Storage::fake('public');
        $user = User::factory()->create();
        $post = Post::create([
            'title'     => 'Original Title',
            'content'   => 'Original content.',
            'published' => 'yes',
            'image'     => null,
        ]);

        $newImage = UploadedFile::fake()->image('updated.jpg');

        $updatedData = [
            'title'     => 'Updated Title',
            'content'   => 'Updated content.',
            'published' => 'no',
            'publisher' => 'New Publisher',
            'image'     => $newImage,
        ];

        $response = $this->actingAs($user)->put('/posts/' . $post->id, $updatedData);

        $response->assertRedirect('/home');
        $this->assertDatabaseHas('posts', [
            'id'        => $post->id,
            'title'     => 'Updated Title',
            'published' => 'no',
        ]);

        $post->refresh();
        $this->assertNotNull($post->image);
        Storage::disk('public')->assertExists($post->image);
    }

    public function test_authenticated_user_can_delete_post(): void
    {
        $user = User::factory()->create();
        $post = Post::create([
            'title'     => 'To be deleted',
            'content'   => 'Delete me.',
            'published' => 'yes',
            'image'     => null,
        ]);

        $response = $this->actingAs($user)->delete('/posts/' . $post->id);

        $response->assertRedirect('/home');
        $this->assertDatabaseMissing('posts', [
            'id' => $post->id,
        ]);
    }
}
