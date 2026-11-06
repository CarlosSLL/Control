<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement('ALTER TABLE materiales ALTER COLUMN cantidad DROP DEFAULT');
        DB::statement('ALTER TABLE materiales ALTER COLUMN cantidad TYPE integer USING cantidad::integer');
        DB::statement('ALTER TABLE materiales ALTER COLUMN cantidad SET DEFAULT 0');
        DB::statement('ALTER TABLE materiales ALTER COLUMN cantidad SET NOT NULL');
    }

    public function down(): void
    {
        DB::statement('ALTER TABLE materiales ALTER COLUMN cantidad DROP DEFAULT');
        DB::statement('ALTER TABLE materiales ALTER COLUMN cantidad TYPE varchar USING cantidad::varchar');
    }
};
