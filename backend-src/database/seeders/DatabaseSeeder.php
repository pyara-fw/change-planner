<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        DB::table('change_plans')->delete();
        DB::table('change_requests')->delete();
        DB::table('projects')->delete();

        DB::table('projects')->insert([
            'id' => 1,
            'title' => 'Experiment 1',
            'user_id' => 1
        ]);


        DB::table('change_requests')->insert([
            'title' => 'Task-1: Add a list of tags on “Components” tab',
            'description' => '
# Introduction
Currently Cachet has implemented the field "tags" associated to "components" entities.
However, there is no way to see the components associated with a particular tag.
This task intends to add this feature to Cachet.


',
            'project_id' => 1,
            'reporter_user_id' => 1,
            'assigned_user_id' => 1,
            'status' => '1'
        ]);

        DB::table('change_requests')->insert([
            'title' => 'Task-2: Fix a bug of Twig tags on incident templates',
            'description' => 'It was found a bug related to the "incident template" feature.
            Steps to reproduce:
            1. Create an "Incident template" with a Twig tag (for example, {{"now"|date("U")}} );
            2. Create an "incident" selecting that template created on step above. Save it;
            3. Try to edit the incident created on previous step, clicking on "edit button".

            Is expected a blank page.

            The objective of this task is to fix this behaviour.
            ',

            'project_id' => 1,
            'reporter_user_id' => 1,
            'assigned_user_id' => 1,
            'status' => '1'
        ]);
    }
}
