<?php

namespace Tests\Feature;

use App\Domain\Category\Category;
use App\Domain\Category\CategoryRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase, WithoutMiddleware;

    public function testListCategoryPage()
    {
        $response = $this->get('/list-categories');

        $response->assertStatus(200);
    }

    public function testInsertCategory()
    {
        $category = $this->createCategory();

        $categoryRepository = new CategoryRepository();
        $categoryRepository->save($category);

	    $this->assertDatabaseHas('categories', [
	        'name' => 'Test name',
	    ]);
    }

    public function testEditCategory()
    {
        $category = $this->createCategory();
        $category->name = 'New test name';

        $categoryRepository = new CategoryRepository();
        $categoryRepository->save($category);

        $this->assertDatabaseHas('categories', [
            'name' => 'New test name',
        ]);
    }

    public function testGetCategory()
    {
        $category = $this->createCategory();

        $categoryRepository = new CategoryRepository();
        $categoryRepository->save($category);
        $categoryRepository->find($category->id);

        $this->assertEquals(1, $category->id);
    }

    public function testDeleteCategory()
    {
        $category = $this->createCategory();

        $categoryRepository = new CategoryRepository();
        $categoryRepository->save($category);
        $categoryRepository->delete($category->id);

        $this->assertDatabaseMissing('categories', [
            'name' => 'Test name',
        ]);
    }

    private function createCategory(): Category
    {
        $category = new Category();
        $category->name = 'Test name';

        return $category;
    }
}
