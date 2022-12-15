<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use App\Models\Place;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Illuminate\Testing\Fluent\AssertableJson;



class PlaceTest extends TestCase
{

    public static User $testUser;
    public static array $validData = [];
    public static array $invalidData = [];
    
    public static function setUpBeforeClass() : void
    {
        parent::setUpBeforeClass();
        // Creem usuari/a de prova
        $name = "test_" . time();
        self::$testUser = new User([
            "name"      => "{$name}",
            "email"     => "{$name}@mailinator.com",
            "password"  => "12345678"
        ]);
        // Create fake file
        $name  = "avatar.png";
        $size = 500; /*KB*/
        $upload = UploadedFile::fake()->image($name)->size($size);
        // TODO Omplir amb dades vàlides
        self::$validData = [
            "upload" => $upload,
            'name'        => 'Camp Nou',
            'description' => 'Estadio del FCB',
            'latitude'    => '6.44',
            'longitude'   => '6.44',
            'visibility_id'   => '1',
        ];
        // TODO Omplir amb dades incorrectes
        self::$invalidData = [
            "upload" => $upload,
            'name'        => 34,
            'description' => 1,
            'latitude'    => '6.44',
            'longitude'   => '6.44',
            'visibility_id'   => '1',
        ];
    }


    public function test_place_list()
    {
        // Desem l'usuari al primer test
        self::$testUser->save();
        // Comprovem que s'ha creat
        $this->assertDatabaseHas('users', [
            'email' => self::$testUser->email,
        ]);
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
        Sanctum::actingAs(self::$testUser);
        // Cridar servei web de l'API
        $response = $this->postJson("/api/places", self::$validData);
        // Revisar que no hi ha errors de validació
        $params = array_keys(self::$validData);
        $response->assertValid($params);
                
        // Check OK response
        $this->_test_ok($response, 201);
    
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
        Sanctum::actingAs(self::$testUser);
        // Cridar servei web de l'API
        $response = $this->postJson("/api/places", self::$invalidData);

        $params = [
            'name', 'description'
        ];
        $response->assertInvalid($params);
        
        // Check ERROR response
        $this->_test_error($response);
    }
    
    /**
        * @depends test_place_create
        */
    public function test_place_read(object $place)
    {
        // Read one file
        $response = $this->getJson("/api/places/{$file->id}");
        // Check OK response
        $this->_test_ok($response);
        // Check JSON exact values
        $response->assertJsonPath("data.filepath",
            fn ($filepath) => !empty($filepath)
        );
    }
    
    public function test_place_read_notfound()
    {
        $id = "not_exists";
        $response = $this->getJson("/api/places/{$id}");
        $this->_test_notfound($response);
    }
    
    /**
        * @depends test_place_create
        */
    public function test_place_update(object $file)
    {
        // Create fake file
        $name  = "photo.jpg";
        $size = 1000; /*KB*/
        $upload = UploadedFile::fake()->image($name)->size($size);
        // Upload fake file using API web service
        $response = $this->putJson("/api/places/{$place->id}", [
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
        * @depends test_place_create
        */
    public function test_place_update_error(object $file)
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
    
    public function test_place_update_notfound()
    {
        $id = "not_exists";
        $response = $this->putJson("/api/places/{$id}", []);
        $this->_test_notfound($response);
    }
    
    /**
        * @depends test_place_create
        */
    public function test_place_delete(object $file)
    {
        // Delete one file using API web service
        $response = $this->deleteJson("/api/files/{$file->id}");
        // Check OK response
        $this->_test_ok($response);
    }
    
    public function test_place_delete_notfound()
    {
        $id = "not_exists";
        $response = $this->deleteJson("/api/places/{$id}");
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
        // Eliminem l'usuari al darrer test
        self::$testUser->delete();
        // Comprovem que s'ha eliminat
        $this->assertDatabaseMissing('users', [
            'email' => self::$testUser->email,
        ]);
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
