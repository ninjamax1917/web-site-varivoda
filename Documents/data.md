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

  <section class="pt-20">
        <div class="card bg-gray-600 w-96 shadow-sm">
            <figure>
                <img src="/images/carousel/cctv/1.jpg" alt="Shoes" />
            </figure>
            <div class="flex items-center justify-center h-20">
                <h2 class="text-lg text-center text-gray-200">
                    Гостинично-ресторанный комплекс "Династия"
                </h2>
            </div>
        </div>
    </section>

    я хочу для секции
    <figure>
                    <img src="/images/carousel/cctv/1.jpg" alt="Shoes" />
                </figure>
                использовать swiper.js для свайпа изображенийи
    <figure>
                    <img src="/images/carousel/cctv/1.jpg" alt="Shoes" />
                </figure>
                использовать swiper.js для свайпа изображений
