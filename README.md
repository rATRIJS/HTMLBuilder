# HTMLBuilder - best HTML generation class there is!

__HTMLBuilder__ can be used to generate / build HTML using simple object-oriented interface.

## Quick feature run-through

Here are some small code snippets that showcase the __HTMLBuilder__ features and API.

### Simple 'Hello World' example

This will output 'Hello World' in a paragraph tag that's in a div.

```php
<?php
echo HTMLBuilder::dispatch()->open("div")->p("Hello Wold");
?>
```

### Automatic attribute escaping

All HTML entities are automatically escaped in tag attributes.

```php
<?php
echo HTMLBuilder::dispatch()->a("HTMLBuilder on GitHub", array(
	"href" => "https://github.com/rATRIJS/HTMLBuilder",
	"title" => "See 'HTMLBuilder' on GitHub" // becomes 'See &#039;HTMLBuilder&#039; on GitHub'
));
?>
```