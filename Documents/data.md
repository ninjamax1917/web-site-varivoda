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

# CRUD

47:44
