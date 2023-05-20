# Dynamic Bits

> A demo WordPress plugin to place dynamic PHP content in cached/static pages via JS.

## How does it work

Decide on a dynamic task, and a name for it.\
Let's use the current time, and the name `time`.

Place an empty span or div on the page with the data attribute dynbit set to the name.
```html
<span data-dynbit="time"></span>
```

In this demo plugin we place it via the `wp_footer` hook, but it can be placed in many ways.

When a cached page (or uncached page) is loaded, the empty span is in the DOM, and our JS comes into play.

The JS grabs all the tasks defined by the `data-dynbit` attribute on page load, and sends them to WordPress' AJAX URL.

WordPress Core in turn accepts that AJAX post because we have a `wp_ajax_dynbits` hook.

Inside this hook we unpack the tasks given, and look for a function with a matching name.\
The `time` function will get its results from a `dynbit_time()` function.\
In our PHP file I've autoloaded all PHP files in the `tasks` folder.

```php
function dynbit_time()
{
    return [
        'success' => true,
        'data'    => date('H:i:s'),
    ];
}
```

The results for all tasks are sent back trough the AJAX call and received by our JS.

Finally our JS loops over the tasks, and for the successful ones it places the HTML in the DOM.

The beauty of this setup is that after installation, adding a *dynamic bit* requires just 2 things:
- A task in the form of a PHP function.
- An empty span or div.

