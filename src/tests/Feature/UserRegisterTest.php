<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserRegisterTest extends TestCase
{
    use RefreshDatabase;

    public function test_name_is_required(): void
    {
        $response = $this->post('/register', [
            'email'                 => 'test@example.com',
            'password'              => 'password1',
            'password_confirmation' => 'password1',
        ]);

        $response->assertSessionHasErrors(['user_name' => 'お名前を入力してください']);
    }

    public function test_email_is_required(): void
    {
        $response = $this->post('/register', [
            'user_name'             => 'テストユーザー',
            'password'              => 'password1',
            'password_confirmation' => 'password1',
        ]);

        $response->assertSessionHasErrors(['email' => 'メールアドレスを入力してください']);
    }

    public function test_password_is_required(): void
    {
        $response = $this->post('/register', [
            'user_name'             => 'テストユーザー',
            'email'                 => 'test@example.com',
            'password_confirmation' => '',
        ]);

        $response->assertSessionHasErrors(['password' => 'パスワードを入力してください']);
    }

    public function test_password_must_be_at_least_8_characters(): void
    {
        $response = $this->post('/register', [
            'user_name'             => 'テストユーザー',
            'email'                 => 'test@example.com',
            'password'              => 'pass123',
            'password_confirmation' => 'pass123',
        ]);

        $response->assertSessionHasErrors(['password' => 'パスワードは8文字以上で入力してください']);
    }

    public function test_password_confirmation_must_match(): void
    {
        $response = $this->post('/register', [
            'user_name'             => 'テストユーザー',
            'email'                 => 'test@example.com',
            'password'              => 'password1',
            'password_confirmation' => 'password2',
        ]);

        $response->assertSessionHasErrors(['password_confirmation' => 'パスワードと一致しません']);
    }

    public function test_register_success_redirects_to_email_verify(): void
    {
        $response = $this->post('/register', [
            'user_name'             => 'テストユーザー',
            'email'                 => 'test@example.com',
            'password'              => 'password1',
            'password_confirmation' => 'password1',
        ]);

        $response->assertRedirect('/email/verify');
        $this->assertDatabaseHas('users', [
            'email'          => 'test@example.com',
            'email_verified' => false,
        ]);
    }
}
