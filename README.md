# blog_system
Test INTERN PHP TourKit

1. **Tạo Project & Cấu hình CSDL**  
   - `composer create-project --prefer-dist laravel/laravel blog_system`  
   - `cd blog_system`  
   - Sửa file `.env` theo cấu hình DB.

2. **Cài đặt DataTables**  
   - `composer require yajra/laravel-datatables-oracle`

3. **Tạo Migrations, Models & Quan hệ**  
   - `php artisan make:model Post -m`  
   - `php artisan make:model Category -m`  
   - `php artisan make:migration create_category_post_table --create=category_post`  
   - `php artisan migrate`

4. **Tạo Seeder**  
   - `php artisan make:seeder CategorySeeder`  
   - `php artisan make:seeder PostSeeder`  
   - Cập nhật `DatabaseSeeder` và chạy: `php artisan db:seed`

5. **Tạo Controller**  
   - `php artisan make:controller PostController`  
   - `php artisan make:controller CategoryController`

6. **Định nghĩa Routes**  
   - Thêm các route cần thiết (Post, Category, DataTables, …) vào file `routes/web.php`.

7. **Sửa Pagination dùng Bootstrap**  
   - Trong `app/Providers/AppServiceProvider.php` (method `boot`):  
     ```php
     use Illuminate\Pagination\Paginator;
     Paginator::useBootstrap();
     ```

8. **Tạo Views**  
   - Layout: `resources/views/layouts/app.blade.php`  
   - Categories: `resources/views/categories/index.blade.php`, `create.blade.php`, `edit.blade.php`  
   - Posts: `resources/views/posts/index.blade.php`, `create.blade.php`, `edit.blade.php`

9. **Chạy Project**  
   - `php artisan serve`
