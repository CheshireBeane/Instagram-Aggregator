# Wordpress Instagram Aggregator

A WordPress plugin for storing instagram media as a custom post type.

## Installing

Download this repo as a zip, and install on the WordPress plugins page.


## Setup

Go to the `CheshireBeane Instagram Aggregator` settings page in WordPress and input your Instagram access token.

You can then click `get media` to aggregate instagram data, as well as schedule how often to run the aggregator.

## Usage

To render instagram posts, access data like you would through a normal custom post type:

```
<?php
$args = array(
  'post_type' => 'instagram-media',
  'posts_per_page' => '8'
);

$query = new WP_Query($args);
if ($query->have_posts()) {
  while ($query->have_posts()) : $query->the_post(); ?>
  <div class='insta-tile'>
    <a target='_blank' href='<?php echo get_post_meta( get_the_ID(), 'cb_insta_link', true ); ?>'>
    <img src='<?php echo get_post_meta( get_the_ID(), 'cb_insta_image', true ); ?>' />
  </a>
</div>
<?php endwhile;

}
wp_reset_postdata();
?>
```

## Issues

Feel free to submit issues and enhancement requests.

## Contributing

CheshireBeane welcomes contributions to our [open source projects on Github](https://github.com/CheshireBeane).

Please follow the following steps if you wish to contribute to this open source project!

 1. **Fork** the repo on GitHub
 2. **Clone** the project to your own machine
 3. **Commit** changes to your own branch
 4. **Push** your work back up to your fork
 5. Submit a **Pull request** so that we can review your changes


## Authors

**Tanner Eustice** - *Initial work* - [teustice](https://github.com/teustice)


## License

This project is licensed under the MIT License
