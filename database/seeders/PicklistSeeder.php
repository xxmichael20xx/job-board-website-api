<?php

namespace Database\Seeders;

use App\Models\Picklist;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class PicklistSeeder extends Seeder
{
    /**
     * Prepare the picklist data
     *
     * @return array
     */
    public function data(): array
    {
        return [
            [
                'name' => 'Job Skills',
                'slug' => 'job-skills',
                'description' => 'List of job skills',
                'items' => [
                    [
                        'name' => 'Laravel',
                        'slug' => 'laravel',
                        'description' => 'A PHP framework for web artisans'
                    ],
                    [
                        'name' => 'React',
                        'slug' => 'react',
                        'description' => 'A JavaScript library for building user interfaces'
                    ],
                    [
                        'name' => 'Node.js',
                        'slug' => 'node-js',
                        'description' => 'A JavaScript runtime built on Chrome\'s V8 JavaScript engine'
                    ],
                    [
                        'name' => 'Python',
                        'slug' => 'python',
                        'description' => 'A high-level programming language for general-purpose programming'
                    ],
                    [
                        'name' => 'Django',
                        'slug' => 'django',
                        'description' => 'A high-level Python web framework that encourages rapid development'
                    ],
                    [
                        'name' => 'Vue.js',
                        'slug' => 'vue-js',
                        'description' => 'A progressive JavaScript framework for building user interfaces'
                    ],
                    [
                        'name' => 'Angular',
                        'slug' => 'angular',
                        'description' => 'A platform for building mobile and desktop web applications'
                    ],
                    [
                        'name' => 'Ruby on Rails',
                        'slug' => 'ruby-on-rails',
                        'description' => 'A server-side web application framework written in Ruby'
                    ],
                    [
                        'name' => 'SQL',
                        'slug' => 'sql',
                        'description' => 'A domain-specific language used in programming and designed for managing data held in a relational database management system'
                    ],
                    [
                        'name' => 'Java',
                        'slug' => 'java',
                        'description' => 'A high-level, class-based, object-oriented programming language'
                    ]
                ]
            ]
        ];

    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->data() as $_picklist) {
            $picklistItems = Arr::pull($_picklist, 'items');

            /** @var Picklist $picklist */
            $picklist = Picklist::query()->firstOrCreate($_picklist);

            // Attach the items
            foreach ($picklistItems as $picklistItem) {
                $picklist->items()->firstOrCreate($picklistItem);
            }
        }
    }
}
