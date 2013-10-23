# Asset
A new approach in organizing assets in your web application.


## Usage Example

**Create assets folders and within this folder create two folders (plugins and pages).**
* {path}/assets
* {path}/assets/plugins
* {path}/assets/pages



**Initialize Asset class by giving it full path to your public assets and path to the two folders
created in the previous step.**
```php
use Asset\Asset;

Asset::init('http://www.example.com/assets', '{path}/assets/plugins', '{path}/assets/pages');
```


**To print the scripts and styles in your master view add these lines**
```php
Asset::styles();
Asset::scripts();
```


**Now you are ready to create your plugins and pages in the early created folders and use easily in views.**

First add the start.php file in the pages folder .. This file will be called at the start of assets
You also can add end.php file which will be called at the end of assets

*File: {path}/assets/pages/start.php*
```php
<?php

Asset::add('jquery' , '//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js');
```

----------------------------------------------------------------------------------------

In the plugins folder add as many plugins as you want e.g. for select2 plugin.

*File: {path}/assets/plugins/select2.php*
```php
<?php

Asset::add('select2', 'plugins/select2/select2.css');
Asset::add('select2', 'plugins/select2/select2.min.js');
```

----------------------------------------------------------------------------------------

Add another plugin e.g. for isotope plugin

*File: {path}/assets/plugins/isotope.php*
```php
<?php

Asset::add('masonry', 'plugins/isotope/isotope.min.js', 'jquery');
```

----------------------------------------------------------------------------------------

Now to use these plugins in any view just add this line for the specified view.

```php
Asset::addPlugins(array('select2', 'isotope'));
```