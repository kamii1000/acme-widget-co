# acme-widget-co

###Stack:
 - Symfony 5.0
 - Webpack
 - Bootstrap
 - JQuery
 - Font awesome

###Usage:
* Clone this repository
* Run `composer install` to install required PHP packages. This will take few minutes.
* Run `npm install` to install required packages for webpack.
* Run `npm run build` to build assets (css, js, etc).

To run the app, you can either use symfony development server or apache/nginx.
* For Symfony dev server: 
  * Go to https://symfony.com/download and follow to instruction to install symfony.
  * Once the Symfony is installed, go to app's root directory and run `symfony server:start`.
  * You can now access the app on http://127.0.0.1:8000.
* For apache/nginx:  
  * Open `config/packages/assets.yaml` and uncomment the line 4 and 5.
  * Add your own URL on line 5. It should look something like this.
  ```
  framework:
    assets:
      json_manifest_path: '%kernel.project_dir%/public/build/manifest.json'
      base_urls:
        - 'http://localhost/acme-widget-co/public/'
  

  ```
  * You will have to point the virtualhost to (or open to URL to) `public` directory of app, the one you added in above step.
---

There is a directory `demo_data` which contains the json files for initial data of products, shipping rules and promotions.