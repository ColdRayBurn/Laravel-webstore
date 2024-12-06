const mix = require('laravel-mix');


mix.sass('resources/beike/admin/css/bootstrap/bootstrap.scss', 'public/build/beike/admin/css/bootstrap.css');
mix.sass('resources/beike/admin/css/app.scss', 'public/build/beike/admin/css/app.css');
mix.js('resources/beike/admin/js/app.js', 'public/build/beike/admin/js/app.js');


mix.sass('beike/Installer/assets/scss/app.scss', 'public/install/css/app.css');

// design
mix.sass('resources/beike/admin/css/design/app.scss', 'public/build/beike/admin/css/design.css');

// filemanager
mix.sass('resources/beike/admin/css/filemanager/app.scss', 'public/build/beike/admin/css/filemanager.css');


mix.sass('resources/beike/shop/default/css/bootstrap/bootstrap.scss', 'public/build/beike/shop/default/css/bootstrap.css');
mix.sass('resources/beike/shop/default/css/app.scss', 'public/build/beike/shop/default/css/app.css');
mix.js('resources/beike/shop/default/js/app.js', 'public/build/beike/shop/default/js/app.js');





if (mix.inProduction()) {
  mix.version();
}
