<?php

namespace Tests\Feature;

use App\Domain\EntryType\EntryType;
use App\Domain\EntryType\EntryTypeRepository;
use App\Domain\Category\Category;
use App\Domain\Category\CategoryRepository;
use App\Domain\Entry\Entry;
use App\Domain\Entry\EntryRepository;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class EntryTest extends TestCase
{
    use RefreshDatabase, WithoutMiddleware;

    public function testListEntry()
    {
        $user = $this->createUser();
        $response = $this->actingAs($user)->get('/list-entries');

        $response->assertStatus(200);
    }

    public function testInsertEntry()
    {
        $entry = $this->createEntry();

        $entryRepository = new EntryRepository();
        $entryRepository->save($entry);

        $this->assertDatabaseHas('entries', [
            'value' => 50,
            'payment_date' => '2021-06-02',
            'status' => 'Pago',
            'description' => 'Test',
        ]);
    }

    public function testEditEntry()
    {
        $entry = $this->createEntry();
        $entry->description = 'New test description';
        $entry->value = 60;

        $entryRepository = new EntryRepository();
        $entryRepository->save($entry);

        $this->assertDatabaseHas('entries', [
            'description' => 'New test description',
            'value' => 60,
        ]);
    }

    public function testGetEntry()
    {
        $entry = $this->createEntry();

        $entryRepository = new EntryRepository();
        $entryRepository->save($entry);
        $entryRepository->find($entry->id);

        $this->assertEquals(1, $entry->id);
    }

    private function createEntry(): Entry
    {
        $entrytype = $this->createEntryType();
        $category = $this->createCategory();
        $user = $this->createUser();

        $entry = new Entry();
        $entry->value = 50;
        $entry->payment_date = '2021-06-02';
        $entry->status = 'Pago';
        $entry->description = 'Test';
        $entry->entry_type_id = $entrytype->id;
        $entry->category_id = $category->id;
        $entry->user_id = $user->id;

        return $entry;
    }

    private function createEntryType(): EntryType
    {
        $entrytype = new EntryType();
        $entrytype->name = 'Test name';
        $entrytype->id = 2;
        $entrytypeRepository = new EntryTypeRepository();
        $entrytypeRepository->save($entrytype);

        return $entrytype;
    }

    private function createCategory() : Category
    {
        $category = new Category();
        $category->name = 'Test name';
        $category->id = 2;
        $categoryRepository = new CategoryRepository();
        $categoryRepository->save($category);

        return $category;
    }

    private function createUser(): User
    {
        return User::create([
            'name' => 'Name',
            'email' => 'email@email.com',
            'password' => 'password',
        ]);
    }
}
