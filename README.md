# HTMLBuilder - best HTML generation class there is!

__HTMLBuilder__ can be used to generate / build HTML using simple object-oriented interface.

## Quick Samples

Here are some small code snippets that show the __HTMLBuilder__ API.

### Simple 'Hello World'

This will output 'Hello World' in a paragraph tag that's in a div.

```php
echo HTMLBuilder::dispatch()->open("div")->p("Hello Wold");
```