<?php

use App\Models\User\Org;
use Illuminate\Database\Seeder;
use Webpatser\Uuid\Uuid;

class OrgsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Org::create(
            [
                'name'=>'这就办信息技术有限责任公司',
                'id'=>1,
                'uuid'=>Uuid::generate(),
            ]
        );
    }
}
