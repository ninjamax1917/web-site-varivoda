# в AppServiceProvider.php добавить

public function boot(): void
{
Model::shouldBeStrict(!app()->isProduction());
}

    помогает в локальной разработке

# Автоматическая генерация контроллера "ресурсного типа"

vendor/bin/sail php artisan make:controller ArticleController --resource --model=Article --requests

# Удобный вывод route-list

vendor/bin/sail php artisan route:list

class="block px-4 py-2 font-semibold text-gray-900 dark:text-white hover:bg-gray-400/40 dark:hover:bg-gray-600">
800
