<?php

namespace Tests\Unit\Migrations;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class LawCaseMigrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_law_cases_table_exists()
    {
        $this->assertTrue(Schema::hasTable('law_cases'));
    }

    public function test_law_cases_table_has_required_columns()
    {
        $columns = Schema::getColumnListing('law_cases');

        $this->assertContains('id', $columns);
        $this->assertContains('case_plaintiff', $columns);
        $this->assertContains('case_defendant', $columns);
        $this->assertContains('case_description', $columns);
        $this->assertContains('case_category', $columns);
        $this->assertContains('case_status', $columns);
        $this->assertContains('case_attorney', $columns);
        $this->assertContains('case_date', $columns);
        $this->assertContains('created_at', $columns);
        $this->assertContains('updated_at', $columns);
        $this->assertContains('deleted_at', $columns);
    }

    public function test_law_cases_table_has_indexes_on_category_status_date()
    {
        $indexes = Schema::getIndexes('law_cases');
        $indexColumns = [];

        foreach ($indexes as $index) {
            $indexColumns = array_merge($indexColumns, $index['columns']);
        }

        $this->assertContains('case_category', $indexColumns);
        $this->assertContains('case_status', $indexColumns);
        $this->assertContains('case_date', $indexColumns);
    }
}
