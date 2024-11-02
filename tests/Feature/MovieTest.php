<?php

namespace Tests\Feature;

use App\Enums\RoleEnums;
use App\Models\Genre;
use App\Models\User;
use App\Models\Movie;
use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class MovieTest extends TestCase
{
    use RefreshDatabase;
    protected $user;
    protected $genre;

    protected function setUp(): void
    {
        parent::setUp();
        Role::firstOrCreate(['id' => RoleEnums::ADMIN->value], ['name' => 'admin']);

        // Foydalanuvchi yaratish
        $this->user = User::factory()->create([
            'username' => 'testuser',
            'password' => Hash::make('validpassword'),
            'role_id' => RoleEnums::ADMIN->value,
        ]);

        // Janr yaratish
        $this->genre = Genre::firstOrCreate(['name' => 'Action'], ['user_id' => $this->user->id]);

        $this->actingAs($this->user);
    }

    /** @test */
    public function it_shows_movies_table()
    {
        $response = $this->get(route('dashboard.movies.list-movies'));
        $response->assertStatus(200);
        $response->assertViewIs('dashboard.movies.listmovies');
    }


    /** @test */
    public function it_creates_a_new_movie()
    {
        $movieData = [
            'title' => 'Test Movie',
            'description' => 'This is a test description',
            'user_id' => $this->user->id, // To'g'ri foydalanuvchi ID si
            'released_date' => '2022-11-22', // Formatni o'zgartiring
            'genre_id' => $this->genre->id, // To'g'ri janr ID si
            'upload_file' => UploadedFile::fake()->image('testfile.jpg'),
        ];

        $response = $this->post(route('dashboard.movies.create-movie'), $movieData);
        $response->assertRedirect(route('dashboard.movies.list-movies'));
        $this->assertDatabaseHas('movies', ['title' => 'Test Movie']);
    }

    /** @test */
    public function it_shows_update_movie_form()
    {
        $movieData = [
            'title' => 'Test Movie',
            'description' => 'This is a test description',
            'released_date' => '2022-11-22',
            'user_id' => $this->user->id,
            'genre_id' => $this->genre->id,
            'upload_file' => UploadedFile::fake()->image('testfile.jpg'),
        ];

        $movie = Movie::create($movieData);

        $response = $this->get(route('dashboard.movies.show-update-movie', $movie->id));
        $response->assertStatus(200);
        $response->assertViewIs('dashboard.movies.updatemovie');
    }

    /** @test */
    public function it_updates_a_movie()
    {
        $movie = Movie::create([
            'title' => 'Test Movie',
            'description' => 'This is a test description',
            'released_date' => '2022-11-22',
            'user_id' => $this->user->id,
            'genre_id' => $this->genre->id,
            'upload_file' => UploadedFile::fake()->image('testfile.jpg'), // Test file
        ]);

        $updateData = [
            'title' => 'Updated Movie Title',
            'description' => 'Updated description',
            'released_date' => '2022-11-22',
            'user_id' => $this->user->id,
            'genre_id' => $this->genre->id,
            'upload_file' => UploadedFile::fake()->image('testfile.jpg'), // Test file
        ];

        $response = $this->post(route('dashboard.movies.update-movie', $movie->id), $updateData);
        $response->assertRedirect(route('dashboard.movies.list-movies'));
        $this->assertDatabaseHas('movies', ['title' => 'Updated Movie Title']);
    }

    /** @test */
    public function it_deletes_a_movie()
    {
        $movieData = [
            'title' => 'Test Movie',
            'description' => 'This is a test description',
            'released_date' => '2022-11-22',
            'user_id' => $this->user->id,
            'genre_id' => $this->genre->id,
            'upload_file' => UploadedFile::fake()->image('testfile.jpg'), // Test file
        ];

        $movie = Movie::create($movieData);

        $response = $this->get(route('dashboard.movies.delete-movie', $movie->id)); // `delete` methodidan foydalaning
        $response->assertRedirect(route('dashboard.movies.list-movies'));
        $this->assertDatabaseMissing('movies', ['id' => $movie->id]);
    }
}
