<?php

namespace Tests\Feature;

use App\User;
use App\Institution;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    protected $data = [
        'nome' => 'admin',
        'email' => 'admin@admin.com',
        'institution_id' => 'ifma',
        'endereco' => 'rua 3',
        'senha' => 'admin123',
        'senha_confirmation' => 'admin123'
    ];

    public function testCreateNewUser()
    {
        // $this->withoutExceptionHandling();
        $response = $this->post(
            '/users',
            $this->data
        );

        // dd(User::first()->institution);

        $response->assertOk();
        $this->assertCount(1, User::all());
    }

    public function testUserNameIsRequired()
    {
        // $this->withoutExceptionHandling();
        $response = $this->post(
            '/users',
            array_merge(
                $this->data,
                ['nome' => '']
            )
        );

        $response->assertSessionHasErrors('nome');
    }

    public function testUserEmailIsRequired()
    {
        // $this->withoutExceptionHandling();
        $response = $this->post(
            '/users',
            array_merge(
                $this->data,
                ['email' => '']
            )
        );

        $response->assertSessionHasErrors('email');
    }

    public function testUserNameIsUnique()
    {
        // $this->withoutExceptionHandling();
        $this->post(
            '/users',
            $this->data,
        );

        $response = $this->post(
            '/users',
            $this->data,
        );

        $response->assertSessionHasErrors('email');
    }

    public function testUserEmailIsValide()
    {
        // $this->withoutExceptionHandling();
        $response = $this->post(
            '/users',
            array_merge(
                $this->data,
                ['email' => 'admin']
            )
        );

        $response->assertSessionHasErrors('email');
    }

    public function testUserInstitutionIsRequired()
    {
        // $this->withoutExceptionHandling();
        $response = $this->post(
            '/users',
            array_merge(
                $this->data,
                ['institution_id' => '']
            )
        );

        $response->assertSessionHasErrors('institution_id');
    }

    public function testUserAddressIsRequired()
    {
        // $this->withoutExceptionHandling();
        $response = $this->post(
            '/users',
            array_merge(
                $this->data,
                ['endereco' => '']
            )
        );

        $response->assertSessionHasErrors('endereco');
    }

    public function testUserPasswordIsRequired()
    {
        // $this->withoutExceptionHandling();
        $response = $this->post(
            '/users',
            array_merge(
                $this->data,
                ['senha' => '']
            )
        );

        $response->assertSessionHasErrors('senha');
    }

    public function testUserPasswordHasMinOf8Chars()
    {
        // $this->withoutExceptionHandling();
        $response = $this->post(
            '/users',
            array_merge(
                $this->data,
                ['senha' => '123']
            )
        );

        $response->assertSessionHasErrors('senha');
    }

    public function testUserPasswordConfirmation()
    {
        // $this->withoutExceptionHandling();
        $response = $this->post(
            '/users',
            array_merge(
                $this->data,
                ['senha_confirmation' => 'admin1234']
            )
        );

        $response->assertSessionHasErrors('senha');
    }

    public function testUserInstitutionCreatedAutomatically()
    {
        $this->withoutExceptionHandling();
        $response = $this->post(
            '/users',
            $this->data
        );

        $this->assertCount(1, Institution::all());
    }
}
