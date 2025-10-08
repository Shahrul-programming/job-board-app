<?php

namespace Tests\Feature\Admin;

use App\Livewire\Admin\UserForm;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Livewire\Livewire;
use Tests\TestCase;

class UserFormTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_new_user(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin);

        $component = Livewire::test(UserForm::class)
            ->set('isEdit', false)
            ->set('name', 'New User')
            ->set('email', 'newuser@example.com')
            ->set('password', 'password123')
            ->set('role', 'guest')
            ->call('save');

        $component->assertDispatched('userSaved');

        $this->assertDatabaseHas('users', [
            'name' => 'New User',
            'email' => 'newuser@example.com',
            'role' => 'guest',
        ]);
    }

    public function test_admin_can_update_existing_user(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $user = User::factory()->create([
            'name' => 'Original Name',
            'email' => 'original@example.com',
            'role' => 'guest',
        ]);

        $this->actingAs($admin);

        Livewire::test(UserForm::class, ['user' => $user])
            ->set('name', 'Updated Name')
            ->set('email', 'updated@example.com')
            ->set('role', 'admin')
            ->call('save')
            ->assertDispatched('userSaved');

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
            'role' => 'admin',
        ]);
    }

    public function test_user_form_validates_required_fields(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin);

        Livewire::test(UserForm::class)
            ->set('isEdit', false)
            ->set('name', '')
            ->set('email', '')
            ->set('password', '')
            ->set('role', '')
            ->call('save')
            ->assertHasErrors(['name', 'email', 'role']);
    }

    public function test_user_form_validates_email_uniqueness(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $existingUser = User::factory()->create(['email' => 'existing@example.com']);

        $this->actingAs($admin);

        Livewire::test(UserForm::class)
            ->set('name', 'New User')
            ->set('email', 'existing@example.com')
            ->set('password', 'password123')
            ->set('role', 'guest')
            ->call('save')
            ->assertHasErrors(['email']);
    }

    public function test_user_form_validates_password_length(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin);

        Livewire::test(UserForm::class)
            ->set('name', 'New User')
            ->set('email', 'newuser@example.com')
            ->set('password', '123') // Too short
            ->set('role', 'guest')
            ->call('save')
            ->assertHasErrors(['password']);
    }

    public function test_user_form_validates_role_values(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin);

        Livewire::test(UserForm::class)
            ->set('name', 'New User')
            ->set('email', 'newuser@example.com')
            ->set('password', 'password123')
            ->set('role', 'invalid_role')
            ->call('save')
            ->assertHasErrors(['role']);
    }

    public function test_password_is_hashed_when_creating_user(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin);

        Livewire::test(UserForm::class)
            ->set('isEdit', false)
            ->set('name', 'New User')
            ->set('email', 'newuser@example.com')
            ->set('password', 'plainpassword')
            ->set('role', 'guest')
            ->call('save');

        $user = User::where('email', 'newuser@example.com')->first();

        $this->assertNotNull($user);
        $this->assertTrue(Hash::check('plainpassword', $user->password));
        $this->assertNotEquals('plainpassword', $user->password);
    }

    public function test_password_is_optional_when_updating_user(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $user = User::factory()->create(['password' => Hash::make('originalpassword')]);
        $originalPassword = $user->password;

        $this->actingAs($admin);

        Livewire::test(UserForm::class, ['user' => $user])
            ->set('name', 'Updated Name')
            ->set('email', $user->email)
            ->set('password', '') // Empty password
            ->set('role', $user->role)
            ->call('save');

        $user->refresh();
        $this->assertEquals($originalPassword, $user->password); // Password should remain unchanged
    }

    public function test_guest_cannot_access_user_form(): void
    {
        $guest = User::factory()->create(['role' => 'guest']);

        $this->actingAs($guest);

        Livewire::test(UserForm::class)
            ->set('name', 'New User')
            ->set('email', 'newuser@example.com')
            ->set('password', 'password123')
            ->set('role', 'guest')
            ->call('save')
            ->assertForbidden();
    }

    public function test_user_form_cancel_dispatches_event(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin);

        Livewire::test(UserForm::class)
            ->call('cancel')
            ->assertDispatched('userFormCancelled');
    }
}
