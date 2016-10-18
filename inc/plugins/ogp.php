<?php
/**
 * Created by PhpStorm.
 * User: hishikawa
 * Date: 2016/10/17
 * Time: 21:43
 */
class Ogp
{
    protected static $tags = array();

    public static function add($property, $content)
    {
        static::$tags[$property] = $content;
    }

    public static function render()
    {
        global $path, $page, $page_title, $page_desc, $get_id, $url_title, $blog_prefix, $ogp_default_image;
        foreach (static::$tags as $property => $content) {
            if ($property == 'image') {
                $content = static::getBaseURL() . $path . '/'. $content;
            }
            static::print_tag($property, $content);
        }

        if (!static::exists('url')) {
            if (!(empty($get_id)) && is_numeric($get_id) && $url_title && $blog_prefix) {
                $url = static::getBaseURL() . $path . '/' . $blog_prefix . '-' . strtolower($url_title);
            } elseif ($page == 'home') {
                $url = static::getBaseURL() . $path . '/';
            } else {
                $url = static::getBaseURL() . $path . '/' . $page;
            }
            static::print_tag('url', $url);
        }

        if (!static::exists('type')) {
            static::print_tag('type', 'article');
        }

        if (!static::exists('title')) {
            static::print_tag('title', $page_title);
        }

        if (!static::exists('description')) {
            static::print_tag('description', $page_desc);
        }

        if (!static::exists('image') && is_string($ogp_default_image) && !empty($ogp_default_image)) {
            static::print_tag('image', static::getBaseURL() . $path . '/' . $ogp_default_image);
        }
    }

    private static function print_tag($property, $content)
    {
        $property = htmlspecialchars($property, ENT_QUOTES, 'UTF-8');
        $content = htmlspecialchars($content, ENT_QUOTES, 'UTF-8');
        echo sprintf("<meta property=\"og:%s\" content=\"%s\" />\n", $property, $content);
    }

    private static function exists($property)
    {
        return array_key_exists($property, static::$tags);
    }

    private static function isSecure()
    {
        $isSecure = false;
        if ($_SERVER['HTTPS'] && strtolower($_SERVER['HTTPS']) == 'on') {
            $isSecure = true;
        }
        return $isSecure;
    }

    private static function getScheme()
    {
        return (static::isSecure()) ? 'https' : 'http';
    }

    private static function getHost()
    {
        return $_SERVER['HTTP_HOST'];
    }

    private static function getBaseURL()
    {
        global $ogp_base_url;
        return (isset($ogp_base_url)) ? $ogp_base_url : static::getScheme() . '://' . static::getHost();
    }

}

function ogp_render() {
    Ogp::render();
}