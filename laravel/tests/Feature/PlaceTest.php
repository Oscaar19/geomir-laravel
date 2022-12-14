<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;

use App\Models\User;
use Laravel\Sanctum\Sanctum;



class PlaceTest extends TestCase
{

    public static User $testUser;

    public function test_place_list()
    {
        // List all files using API web service
        $response = $this->getJson("/api/places");
        // Check OK response
        $this->_test_ok($response);
        // Check JSON dynamic values
        $response->assertJsonPath("data",
            fn ($data) => is_array($data)
        );
    }
    
    public function test_place_create() : object
    {
        // Create test user (BD store later)
        $name = "test_" . time();
        self::$testUser = new User([
            "name"      => "{$name}",
            "email"     => "{$name}@mailinator.com",
            "password"  => "12345678"
        ]);

        Sanctum::actingAs(
            self::$testUser,
            ['*'] // grant all abilities to the token
        );

        // Create fake file
        $name  = "avatar.png";
        $size = 500; /*KB*/
        $upload = UploadedFile::fake()->image($name)->size($size);
        // Upload fake file using API web service
        $response = $this->postJson("/api/places", [
            "upload" => $upload,
            'name'        => 'Camp Nou',
            'description' => 'Estadio del FCB',
            'latitude'    => '6.44',
            'longitude'   => '6.44',
            // 'author_id'      => self::$testUser->id,
            'visibility_id'   => '1',

        ]);
        // Check OK response
        $this->_test_ok($response, 201);
        // Check validation errors
        $response->assertValid(["upload"]);
        $response->assertValid(["name"]);
        $response->assertValid(["description"]);
        $response->assertValid(["latitude"]);
        $response->assertValid(["longitude"]);
        $response->assertValid(["visibility_id"]);
    
        // Check JSON dynamic values
        $response->assertJsonPath("data.id",
            fn ($id) => !empty($id)
        );
        // Read, update and delete dependency!!!
        $json = $response->getData();
        return $json->data;
    }
    
    public function test_place_create_error()
    {
        // Create fake file with invalid max size
        $name  = "avatar.png";
        $size = 5000; /*KB*/
        $upload = UploadedFile::fake()->image($name)->size($size);
        // Upload fake file using API web service
        $response = $this->postJson("/api/places", [
            "upload" => $upload,
            'name'        => 'Camp Nou',
            'description' => 'Estadio del FCB',
            'latitude'    => '6.44',
            'longitude'   => '6.44',
            'visibility_id'   => '1',
        ]);
        // Check ERROR response
        $this->_test_error($response);
    }
    
    /**
        * @depends test_file_create
        */
    public function test_file_read(object $file)
    {
        // Read one file
        $response = $this->getJson("/api/files/{$file->id}");
        // Check OK response
        $this->_test_ok($response);
        // Check JSON exact values
        $response->assertJsonPath("data.filepath",
            fn ($filepath) => !empty($filepath)
        );
    }
    
    public function test_file_read_notfound()
    {
        $id = "not_exists";
        $response = $this->getJson("/api/files/{$id}");
        $this->_test_notfound($response);
    }
    
    /**
        * @depends test_file_create
        */
    public function test_file_update(object $file)
    {
        // Create fake file
        $name  = "photo.jpg";
        $size = 1000; /*KB*/
        $upload = UploadedFile::fake()->image($name)->size($size);
        // Upload fake file using API web service
        $response = $this->putJson("/api/files/{$file->id}", [
            "upload" => $upload,
        ]);
        // Check OK response
        $this->_test_ok($response);
        // Check validation errors
        $response->assertValid(["upload"]);
        // Check JSON exact values
        $response->assertJsonPath("data.filesize", $size*1024);
        // Check JSON dynamic values
        $response->assertJsonPath("data.filepath",
            fn ($filepath) => str_contains($filepath, $name)
        );
    }
    
    /**
        * @depends test_file_create
        */
    public function test_file_update_error(object $file)
    {
        // Create fake file with invalid max size
        $name  = "photo.jpg";
        $size = 3000; /*KB*/
        $upload = UploadedFile::fake()->image($name)->size($size);
        // Upload fake file using API web service
        $response = $this->putJson("/api/files/{$file->id}", [
            "upload" => $upload,
        ]);
        // Check ERROR response
        $this->_test_error($response);
    }
    
    public function test_file_update_notfound()
    {
        $id = "not_exists";
        $response = $this->putJson("/api/files/{$id}", []);
        $this->_test_notfound($response);
    }
    
    /**
        * @depends test_file_create
        */
    public function test_file_delete(object $file)
    {
        // Delete one file using API web service
        $response = $this->deleteJson("/api/files/{$file->id}");
        // Check OK response
        $this->_test_ok($response);
    }
    
    public function test_file_delete_notfound()
    {
        $id = "not_exists";
        $response = $this->deleteJson("/api/files/{$id}");
        $this->_test_notfound($response);
    }
    
    protected function _test_ok($response, $status = 200)
    {
        // Check JSON response
        $response->assertStatus($status);
        // Check JSON properties
        $response->assertJson([
            "success" => true,
            "data"    => true // any value
        ]);
    }
    
    protected function _test_error($response)
    {
        // Check response
        $response->assertStatus(422);
        // Check validation errors
        $response->assertInvalid(["upload"]);
        // Check JSON properties
        $response->assertJson([
            "message" => true, // any value
            "errors"  => true, // any value
        ]);       
        // Check JSON dynamic values
        $response->assertJsonPath("message",
            fn ($message) => !empty($message) && is_string($message)
        );
        $response->assertJsonPath("errors",
            fn ($errors) => is_array($errors)
        );
    }
    
    protected function _test_notfound($response)
    {
        // Check JSON response
        $response->assertStatus(404);
        // Check JSON properties
        $response->assertJson([
            "success" => false,
            "message" => true // any value
        ]);
        // Check JSON dynamic values
        $response->assertJsonPath("message",
            fn ($message) => !empty($message) && is_string($message)
        );       
    }
}
