# HTMLBuilder - best HTML generation class there is!

__HTMLBuilder__ can be used to generate / build HTML using simple object-oriented interface.

## Feature and usage run-through

Some code snippets that showcase the __HTMLBuilder__ features and API.

### Instance retrieval

To start building your HTML you first need to create HTMLBuilder object. Constructor doesn't need any arguments.

There are two ways that you can achieve this:

 * new keyword
 * HTMLBuilder::dispatch() method

Both of them will achieve the same thing but HTMLBuilder::dispatch() method has the ability to be a one-liner (at least in PHP versions < 5.4).

#### Initialization via new keyword

```php
<?php
$html = new HTMLBuilder;
?>
```

#### Initialization via HTMLBuilder::dispatch() method

```php
<?php
$html = HTMLBuilder::dispatch();
?>
```

### HTML generation

Almost all instance methods will append a HTML tag to the generated HTML where tag name is method name. These methods support two arguments:
 * content - content inside the tag
 * attributes - tag attributes as key-value array where key is attribute name and value is attribute value

Both arguments are optional. It's also possible to pass _attributes_ as the only argument. Tag will automatically close.

To keep the tag open you have two options:
 * use HTMLBuilder::open() method before the tag method
 * use HTMLBuilder::open() method and pass tag name and attributes as arguments for this method

#### Instance methods as tags

__php__

```php
<?php
echo HTMLBuilder::dispatch()->p("Hello World");
?>
```

__html__

```html
<p>Hello World</p>
```

#### Keeping tags open to build nested HTML

##### Using HTMLBuilder::open() before tag method

__php__

```php
<?php
echo HTMLBuilder::dispatch()->open()->div()->p("Hello World");
?>
```

__html__

```html
<div><p>Hello World</p></div>
```

##### Using HTMLBuilder::open() and pass tag arguments inside it

__php__

```php
<?php
echo HTMLBuilder::dispatch()->open("div")->p("Hello World");
?>
```

__html__

```html
<div><p>Hello World</p></div>
```