<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            'Software Development',
            'Data & AI',
            'Design & Creative',
            'Product & Project Management',
            'Marketing & Growth',
            'Sales & Business',
            'Finance & Legal',
            'HR & Operations',
            'Customer Support',
            'IT & Networking',
            'Healthcare',
            'Education',
            'Construction',
            'Hospitality',
            'Consulting',
        ];

        foreach ($categories as $name) {
            Category::updateOrCreate(
                ['slug' => Str::slug($name)],
                ['name' => $name]
            );
        }
    }
}
