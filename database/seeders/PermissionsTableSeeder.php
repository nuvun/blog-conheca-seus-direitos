<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            [
                'id'    => 1,
                'title' => 'user_management_access',
            ],
            [
                'id'    => 2,
                'title' => 'permission_create',
            ],
            [
                'id'    => 3,
                'title' => 'permission_edit',
            ],
            [
                'id'    => 4,
                'title' => 'permission_show',
            ],
            [
                'id'    => 5,
                'title' => 'permission_delete',
            ],
            [
                'id'    => 6,
                'title' => 'permission_access',
            ],
            [
                'id'    => 7,
                'title' => 'role_create',
            ],
            [
                'id'    => 8,
                'title' => 'role_edit',
            ],
            [
                'id'    => 9,
                'title' => 'role_show',
            ],
            [
                'id'    => 10,
                'title' => 'role_delete',
            ],
            [
                'id'    => 11,
                'title' => 'role_access',
            ],
            [
                'id'    => 12,
                'title' => 'user_create',
            ],
            [
                'id'    => 13,
                'title' => 'user_edit',
            ],
            [
                'id'    => 14,
                'title' => 'user_show',
            ],
            [
                'id'    => 15,
                'title' => 'user_delete',
            ],
            [
                'id'    => 16,
                'title' => 'user_access',
            ],
            [
                'id'    => 17,
                'title' => 'audit_log_show',
            ],
            [
                'id'    => 18,
                'title' => 'audit_log_access',
            ],
            [
                'id'    => 19,
                'title' => 'content_management_access',
            ],
            [
                'id'    => 20,
                'title' => 'content_category_create',
            ],
            [
                'id'    => 21,
                'title' => 'content_category_edit',
            ],
            [
                'id'    => 22,
                'title' => 'content_category_show',
            ],
            [
                'id'    => 23,
                'title' => 'content_category_delete',
            ],
            [
                'id'    => 24,
                'title' => 'content_category_access',
            ],
            [
                'id'    => 25,
                'title' => 'content_tag_create',
            ],
            [
                'id'    => 26,
                'title' => 'content_tag_edit',
            ],
            [
                'id'    => 27,
                'title' => 'content_tag_show',
            ],
            [
                'id'    => 28,
                'title' => 'content_tag_delete',
            ],
            [
                'id'    => 29,
                'title' => 'content_tag_access',
            ],
            [
                'id'    => 30,
                'title' => 'content_page_create',
            ],
            [
                'id'    => 31,
                'title' => 'content_page_edit',
            ],
            [
                'id'    => 32,
                'title' => 'content_page_show',
            ],
            [
                'id'    => 33,
                'title' => 'content_page_delete',
            ],
            [
                'id'    => 34,
                'title' => 'content_page_access',
            ],
            [
                'id'    => 35,
                'title' => 'admin_access',
            ],
            [
                'id'    => 36,
                'title' => 'type_category_create',
            ],
            [
                'id'    => 37,
                'title' => 'type_category_edit',
            ],
            [
                'id'    => 38,
                'title' => 'type_category_show',
            ],
            [
                'id'    => 39,
                'title' => 'type_category_delete',
            ],
            [
                'id'    => 40,
                'title' => 'type_category_access',
            ],
            [
                'id'    => 41,
                'title' => 'post_create',
            ],
            [
                'id'    => 42,
                'title' => 'post_edit',
            ],
            [
                'id'    => 43,
                'title' => 'post_show',
            ],
            [
                'id'    => 44,
                'title' => 'post_delete',
            ],
            [
                'id'    => 45,
                'title' => 'post_access',
            ],
            [
                'id'    => 46,
                'title' => 'type_banner_create',
            ],
            [
                'id'    => 47,
                'title' => 'type_banner_edit',
            ],
            [
                'id'    => 48,
                'title' => 'type_banner_show',
            ],
            [
                'id'    => 49,
                'title' => 'type_banner_delete',
            ],
            [
                'id'    => 50,
                'title' => 'type_banner_access',
            ],
            [
                'id'    => 51,
                'title' => 'banner_create',
            ],
            [
                'id'    => 52,
                'title' => 'banner_edit',
            ],
            [
                'id'    => 53,
                'title' => 'banner_show',
            ],
            [
                'id'    => 54,
                'title' => 'banner_delete',
            ],
            [
                'id'    => 55,
                'title' => 'banner_access',
            ],
            [
                'id'    => 56,
                'title' => 'video_create',
            ],
            [
                'id'    => 57,
                'title' => 'video_edit',
            ],
            [
                'id'    => 58,
                'title' => 'video_show',
            ],
            [
                'id'    => 59,
                'title' => 'video_delete',
            ],
            [
                'id'    => 60,
                'title' => 'video_access',
            ],
            [
                'id'    => 61,
                'title' => 'partner_create',
            ],
            [
                'id'    => 62,
                'title' => 'partner_edit',
            ],
            [
                'id'    => 63,
                'title' => 'partner_show',
            ],
            [
                'id'    => 64,
                'title' => 'partner_delete',
            ],
            [
                'id'    => 65,
                'title' => 'partner_access',
            ],
            [
                'id'    => 66,
                'title' => 'setting_create',
            ],
            [
                'id'    => 67,
                'title' => 'setting_edit',
            ],
            [
                'id'    => 68,
                'title' => 'setting_show',
            ],
            [
                'id'    => 69,
                'title' => 'setting_delete',
            ],
            [
                'id'    => 70,
                'title' => 'setting_access',
            ],
            [
                'id'    => 71,
                'title' => 'city_create',
            ],
            [
                'id'    => 72,
                'title' => 'city_edit',
            ],
            [
                'id'    => 73,
                'title' => 'city_show',
            ],
            [
                'id'    => 74,
                'title' => 'city_delete',
            ],
            [
                'id'    => 75,
                'title' => 'city_access',
            ],
            [
                'id'    => 76,
                'title' => 'state_create',
            ],
            [
                'id'    => 77,
                'title' => 'state_edit',
            ],
            [
                'id'    => 78,
                'title' => 'state_show',
            ],
            [
                'id'    => 79,
                'title' => 'state_delete',
            ],
            [
                'id'    => 80,
                'title' => 'state_access',
            ],
            [
                'id'    => 81,
                'title' => 'newsletter_create',
            ],
            [
                'id'    => 82,
                'title' => 'newsletter_edit',
            ],
            [
                'id'    => 83,
                'title' => 'newsletter_show',
            ],
            [
                'id'    => 84,
                'title' => 'newsletter_delete',
            ],
            [
                'id'    => 85,
                'title' => 'newsletter_access',
            ],
            [
                'id'    => 86,
                'title' => 'relatorio_create',
            ],
            [
                'id'    => 87,
                'title' => 'relatorio_edit',
            ],
            [
                'id'    => 88,
                'title' => 'relatorio_show',
            ],
            [
                'id'    => 89,
                'title' => 'relatorio_delete',
            ],
            [
                'id'    => 90,
                'title' => 'relatorio_access',
            ],
            [
                'id'    => 91,
                'title' => 'image_create',
            ],
            [
                'id'    => 92,
                'title' => 'image_edit',
            ],
            [
                'id'    => 93,
                'title' => 'image_show',
            ],
            [
                'id'    => 94,
                'title' => 'image_delete',
            ],
            [
                'id'    => 95,
                'title' => 'image_access',
            ],
            [
                'id'    => 96,
                'title' => 'gallery_photo_create',
            ],
            [
                'id'    => 97,
                'title' => 'gallery_photo_edit',
            ],
            [
                'id'    => 98,
                'title' => 'gallery_photo_show',
            ],
            [
                'id'    => 99,
                'title' => 'gallery_photo_delete',
            ],
            [
                'id'    => 100,
                'title' => 'gallery_photo_access',
            ],
            [
                'id'    => 101,
                'title' => 'profile_password_edit',
            ],
        ];

        Permission::insert($permissions);
    }
}
