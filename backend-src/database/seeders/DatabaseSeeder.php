<?php

namespace Database\Seeders;

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
        DB::table('change_plans')->delete();
        DB::table('change_requests')->delete();
        DB::table('projects')->delete();


        DB::table('tasks')->delete();
        DB::table('solutions')->delete();



        DB::table('tasks')->insert([
            'title' => 'Add a list of tags on “Components” tab',
            'tags' => 'feature;silver:low priority',
            'description' => '
# Introduction
Currently Cachet has implemented the field "tags" associated to "components" entities.
However, there is no way to see the components associated with a particular tag.
This task intends to add this feature to Cachet.

# Requirements

1. This is a new feature, and should be on authenticated area.
2. The solution should provide a section on menu with all tags associated with any component.
3. Clicking  in any link, the user should see a list of components linked to that tag.

# Objectives

Your objective is to specify all necessary modifications on current codebase, to have this feature implemented. The implementation will be outsourced, and due that be more detailed as possible.

'
        ]);

//         DB::table('tasks')->insert([
//             'title' => 'Fix a bug of Twig tags on incident templates',
//             'tags' => 'red:bug; red:high priority;twig',
//             'description' => '
        // # Introduction
        // It was found a bug related to the "incident template" feature.
        // ## Steps to reproduce:
        // 1. Create an "Incident template" with a Twig tag (for example, `{{"now"|date("U")}}` );
        // 2. Create an "incident" selecting that template created on step above. Save it;
        // 3. Try to edit the incident created on previous step, clicking on "edit button".

        // | Is expected a blank page.

        // - one
        // - two
        // - three

        // #  Objective
        // The objective of this task is to fix this behaviour.
//             '
//         ]);


        DB::table('tasks')->insert([
    'title' => 'Add a Panic button to notify all users',
    'tags' => 'feature;silver:low priority',
    'description' => '
# Introduction
A couple of stakeholders requested a new feature, called "panic button".
This is because in some emergencies, like a generalized attack, a lock down is triggered, and it is necessary to create an incident for all components.
This feature will allow to send a pre-defined message to all subscribers of all managed sites, creating an incident, and setting all components as "major outage".

# Requirements

- Create a button on internal (authenticated) user area, with label "Panic" [Image here](https://pyara-experiment-resources.s3.amazonaws.com/tasks/task-3/task3-img1.png)
- When the user clicks on this button, the server should send an email for all users.
- Although this message is out of scope of this task, just leave a placeholder to get its contents in some class (preferably in a controller).
- Don\'t forget to set all components as "major outage" state.

# Objective

Your objective is to specify all necessary modifications on current codebase, to have this feature implemented. The implementation will be outsourced, and due that be more detailed as possible.

'
]);
    }
}
