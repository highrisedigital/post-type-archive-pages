# Post Type Archive Pages

This plugin provides the ability to have a normal post edit screen which can be used for the post type archive pages. One of the problems with post type archive views in WordPress, is that there is no where to edit the content of this page in WordPress e.g. page title.

The plugin adds a menu item in the WordPress admin for each post types which is marked as having an archive when it was registered. When this menu item is clicked it gives a normal post edit screen where users can add a title and content as well as a featured image. These can then be output on the post type archive pages.

## FAQ

### How do I output the post type title on a post type archive page?

The title that is added to a post type archive page in the WordPress admin can be output on the post type archive template using the following example:

```php
<?php echo hdptap_get_post_type_archive_title( get_queried_object()->name ); ?>
```

The above would output the title for the current post type. This could be placed in the template file for this post types archive template.

### How do I output the post type content on a post type archive page?

The content that is added to a post type archive page in the WordPress admin can be output on the post type archive template using the following example:

```php
<?php echo hdptap_get_post_type_archive_content( get_queried_object()->name ); ?>
```

The above would output the content for the current post type. This could be placed in the template file for this post types archive template.

### How do I output the post type featured image or post thumbnail on a post type archive page?

The featured image that is added to a post type archive page in the WordPress admin can be output on the post type archive template using the following example:

```php
<?php echo hdptap_get_post_type_archive_post_thumbnail( get_queried_object()->name ); ?>
```

The above would output the post thumbnail or featured for the current post type. This could be placed in the template file for this post types archive template. It also takes the normal args, after the post type name added above which can be added to `get_the_post_thumbnail()` such as `$size` and `$attr`.
