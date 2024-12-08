
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCurrentFundingToProjects extends Migration
{
    public function up()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->decimal('current_funding', 15, 2)->default(0)->after('funding_goal');
            $table->decimal('minimum_investment', 15, 2)->default(0)->after('current_funding');
        });
    }

    public function down()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn('current_funding');
            $table->dropColumn('minimum_investment');
        });
    }
}