<?php

namespace Tests\Feature;

use App\Domain\EntryType\EntryType;
use App\Domain\EntryType\EntryTypeRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class EntryTypeTest extends TestCase

{
    use RefreshDatabase, WithoutMiddleware;

    public function testListEntryType()
    {
        $response = $this->get('/list-entriestypes');

        $response->assertStatus(200);
    }

    public function testInsertEntryType()
    {
        $entrytype = $this->createEntryType();

        $entrytypeRepository = new EntryTypeRepository();
        $entrytypeRepository->save($entrytype);

        $this->assertDatabaseHas('entry_types', [
            'name' => 'Test name',
        ]);
    }

    public function testEditEntryType()
    {
        $entrytype = $this->createEntryType();
        $entrytype->name = 'New test name';

        $entrytypeRepository = new EntryTypeRepository();
        $entrytypeRepository->save($entrytype);

        $this->assertDatabaseHas('entry_types', [
            'name' => 'New test name',
        ]);
    }

    public function testGetEntryType()
    {
        $entrytype = $this->createEntryType();

        $entrytypeRepository = new EntryTypeRepository();
        $entrytypeRepository->save($entrytype);
        $entrytypeRepository->find($entrytype->id);

        $this->assertEquals(1, $entrytype->id);
    }

    private function createEntryType(): EntryType
    {
        $entrytype = new EntryType();
        $entrytype->name = 'Test name';

        return $entrytype;
    }
}
