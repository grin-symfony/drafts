# generic-parts-bundle

Description
========

Symfony generic parts provide common tools for developing web applicaiton.

Installation
========
Make sure Composer is installed globally, as explained in the
[installation chapter](https://getcomposer.org/doc/00-intro.md)
of the Composer documentation.

### Step 1.0: Install the bundle

Open a command console and execute:

```console
	composer require green-symfony/generic-parts-bundle
```

1.0.0) or use `git clone`
--------

```console
git clone https://github.com/green-symfony/generic-parts-bundle.git
```

### 1.0.1) move this directory into `where/you/want/in/your/project/generic-parts-bundle`

add it into your `/composer.json` 

```json
"repositories":		[
	{
		"type":			"path",
		"url":			"where/you/want/in/your/project/generic-parts-bundle"
	}
],
"require": {
	"green-symfony/generic-parts-bundle": "TODO",
}
```

### 1.0.2) update and generate classes for composer autoloader

```console
composer update
composer dump-autoload -o
```

Applications that don't use Symfony Flex
--------

### Step 1.1: Enable the Bundle

Then, enable the bundle by adding it to the list of registered bundles
in the `config/bundles.php` file of your project:

```php
// config/bundles.php

return [
    // ...
    GS\GenericParts\GSGenericPartsBundle::class => ['all' => true],
];
```

### Step 2 (webpack): Add dependencies of node_modules and stimulus controllers

If you have installed `symfony/webpack-encore-bundle`

```console
composer require symfony/webpack-encore-bundle
```

add this line into your `/package.json`

```json
{
	"@green-symfony/generic-parts-stimulus": "file:vendor/green-symfony/generic-parts-bundle/assets/@green-symfony/generic-parts-stimulus"
}
```

### Step 3 (webpack): Install all the described node_modules dependencies in your app

in your `/webpack.config.js` file

```js
// ###> DOTENV (optional) ###
// the highest priority
.addPlugin(new Dotenv( {
		safe:		false,
		path:		'./.env.local',
		systemvars: true,
		silent:		true,
	}
))
.addPlugin(new Dotenv( {
		safe:		false,
		path:		'./.env',
		systemvars: true,
		silent:		true,
	}
))
// ###< DOTENV (optional) ###

// required
.enableSassLoader()
```

Open a command console and execute:

```console
yarn install --force
```

### Step 4 (webpack): Now you can register bundle's stimulus controllers in your ***/assets/bootstrap.js***

```js
import { startStimulusApp } from '@symfony/stimulus-bridge';
import {
	GSWatch,
	GSLocalMoney
} from '@green-symfony/generic-parts-stimulus';

export const app = startStimulusApp(require.context(
    '@symfony/stimulus-bridge/lazy-controller-loader!./controllers',
    true,
    /\.[jt]sx?$/
));

/* NOTE:
	twig function {{ stimulus_controller(<>) }} converts '_' -> '-', 
	so register controllers with '-' to avoid problems with finding registered controller
*/

/* ###> ALL THE CONTROLLERS OF THIS BUNDLE ### */
app.register('gs-watch',				GSWatch);
app.register('gs-local-money',			GSLocalMoney);			/* for symfony MoneyType widget */
/* ###< ALL THE CONTROLLERS OF THIS BUNDLE ### */
```

### Step 5.0 (webpack): Add entry in your ***/webpack.config.js***

```js
.addEntry('gs_generic_parts', '/vendor/green-symfony/generic-parts-bundle/assets/app.js')
```

### Step 5.1 (webpack): Enable entry in your ***/templates/base.html.twig***

```twig
{% block stylesheets %}
	{{ encore_entry_link_tags('gs_generic_parts') }}
{% endblock %}

{% block javascripts %}
	{{ encore_entry_script_tags('gs_generic_parts') }}
{% endblock %}
```

### Step 6: Load bundle's public

```console
php bin/console assets:install
```
or
```console
php bin/console a:i
```

### Step 7: Register new routes in `/config/routes/gs_generic_parts_routes.yaml`

with the following content

```yaml
gs_generic_parts_routes:
    # for api sets users timezone in session with name of yaml parameter %gs_generic_parts.timezone_session_name%
    resource:       '@GSGenericPartsBundle/config/routes.yaml'
```

Details
========

Basic features for Symfony Web Application which includes:

Twig form widgets
--------

### 1) Change form view PasswordType and MoneyType widget

1.0) In your applicaiton register new stimulus controller in ***/assets/bootstrap.js***

```js
import PasswordVisibility from '@symfony/stimulus-bridge/lazy-controller-loader?lazy=true!stimulus-password-visibility';

app.register('password-visibility', PasswordVisibility);
```

1.1) Add ***@GSGenericParts/form/gs_generic_parts_form_default.html.twig*** form theme 

```yaml
// /config/packages/twig.yaml 
twig:
    form_themes:
        - 'bootstrap_5_layout.html.twig'
        - '@GSGenericParts/form/gs_generic_parts_form_default.html.twig'
```

extra 1.2) You can overwrite ***@GSGenericParts/form/gs_generic_parts_form_default.html.twig***

```yaml
// /config/packages/twig.yaml 
twig:
    form_themes:
        - 'bootstrap_5_layout.html.twig'
        - 'form/gs_generic_parts_form_default.html.twig'
```

Just define ***/templates/form/gs_generic_parts_form_default.html.twig*** in your application
and change the content

```twig
{% use '@!GSGenericParts/form/gs_generic_parts_form_default.html.twig' %}

{# ###> PASSWORD VISIBILITY ### #}

{%- block password_widget -%}
	{{- parent() -}}
	
	Your code here
	
{%- endblock password_widget -%}

{# ###< PASSWORD VISIBILITY ### #}


{# ###> INPUT TYPE NUMBER + Symfony\Component\Form\Extension\Core\Type\MoneyType = LOCAL MONEY ### #}

{% block money_widget -%}
	{{- parent() -}}
	
	Your code here

{%- endblock money_widget %}

{# ###< INPUT TYPE NUMBER + Symfony\Component\Form\Extension\Core\Type\MoneyType = LOCAL MONEY ### #}

{# ... #}
```

Twig templates
--------
-	email `base.html.twig` template for sending emails
-	`templates/_placeholder.html.twig` for showing loading

Twig filters
--------
| TwigFilter				| description |
|:--------------------------|:------------|
| gs_trim					| php \trim(<string>) |
| gs_for_user				| return string by \\DateTime or \\DateTimeImmutable object with user locale and timezone |
| gs_array_to_attribute		| convert array to string (not for transform into html attribute, for debugging) |
| gs_binary_img				| return html img with binary image content |

Twig functions
--------
- gs_dump_array
- gs_lorem
- gs_create_form
- gs_time
- gs_echo
- gs_clear_output_buffer

Twig components
--------
- gs_alert
- gs_dt
- gs_navs
- gs_sprite	(your should have */public/images/svg/sprite.svg* file)
- gs_submit_button
- gs_watch

Public files
--------

### After `php bin/console a:i` command you have sprites.svg file

***/bundles/gsgenericparts/images/svg/sprite.svg***

This file contains sprites, you can add your own unique sprites.

And access them with the 'gs_sprite' twig component:

```twig
{{ component('gs_sprite', { id: '<>' }) }}
```

Customized services
--------
- \\Carbon\\CarbonFactory
- \\Faker\\Generator

Event subscribers
--------
-	kernel.request (for initialize):
	-	php default timezone in UTC
	-	add macros to \\Carbon\\Carbon
-	kernel.exception:
	-	answer or exception of bundle API always measure up to described structure
	
To look at awailable settings by default of this bundle open console and execute:

```console
php bin/console config:dump-reference gs_generic_parts
````

To look at real settings of this bundle open console and execute:

```console
php bin/console debug:config gs_generic_parts
````

Extra Settings
--------

### You can take `.gitignore` in your project

TODO:
-	uncomment lines for enable saving

### You can also take `Makefile` in your project

### Compiler Pass for your ***/vendor/symfony/http-kernel/Kernel.php***

To enable `monolog.logger.gs_generic_parts.debug` service when only in concrete APP_ENVs

```php
// /vendor/symfony/http-kernel/Kernel.php

use Symfony\Component\DependencyInjection\ContainerBuilder;
use GS\GenericParts\Pass\{
	GSSetAvailableEnvsForDebugLogger
};

protected function build(ContainerBuilder $container)
{
	$container
		->addCompilerPass(new GSSetAvailableEnvsForDebugLogger(
			appEnv:			$this->getEnvironment(),
			availableEnvs:	['dev'],
		))
	;
}
```
	
To enable sending error messanges of your site when in concrete APP_ENVs

```php
// /vendor/symfony/http-kernel/Kernel.php

use Symfony\Component\DependencyInjection\ContainerBuilder;
use GS\GenericParts\Pass\{
	GSSetAvailableEnvsForEmailErrorLogger
};

protected function build(ContainerBuilder $container)
{
	$container
		->addCompilerPass(new GSSetAvailableEnvsForEmailErrorLogger(
			appEnv:			$this->getEnvironment(),
			availableEnvs:	['prod'],
		))
	;
}
```

Of course you need to add from and to emails of this bundle in file ***/config/packages/gs_generic_parts.yaml*** for instance
```yaml
gs_generic_parts:
    error_logger_email:
        from:           '<>'
        to:             '<>'
```

# Services

## Reading yaml of project configs `gs_generic_parts.conf_service` 

In your `/config/services.yaml`

```yaml
services:
    _defaults:
        autowire:           true
        autoconfigure:      true
        bind:
            $confService: '@gs_generic_parts.conf_service'
```

Usage:

```php
// Get some config's value

$orderInitialMarking	= $this->confService->getPackage(
	filename:					'workflow', // or 'workflow.yaml'
	propertyAccessString:		'[framework][workflows][order][initial_marking]',
);
```

