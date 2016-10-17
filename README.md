# OGP plugin for Pulse CMS

## Install

1. Upload `inc/plugins/ogp.php` and `inc/tags/ogp.php`
2. Add `<?php include_once('inc/plugins/ogp.php'); ogp_render(); ?>` between `<head>` and `</head>` in `layout.php`

## Pulse tags

```
{{ogp:title:Lorem Ipsum}}
{{ogp:description:Lorem ipsum dolor sit amet, consectetur adipiscing elit}}
{{ogp:type:article}}
{{ogp:image:content/media/example.jpg}}
```
