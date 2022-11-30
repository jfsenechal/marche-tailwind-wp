<?php

namespace AcMarche\MarcheTail;


use AcMarche\MarcheTail\Lib\Twig;

get_header();
global $post;

$image = null;
if (has_post_thumbnail()) {
    $images = wp_get_attachment_image_src(get_post_thumbnail_id(), 'original');
    if ($images) {
        $image = $images[0];
    }
}

$tags = [];
$content = get_the_content(null, null, $post);
$content = apply_filters('the_content', $content);
$content = str_replace(']]>', ']]&gt;', $content);
$recommandations = [];

Twig::rendPage(
    '@MarcheBe/article.html.twig',
    [
        'name' => $post->post_title,
        'post' => $post,
        'excerpt' => $post->post_excerpt,
        'tags' => $tags,
        'image' => $image,
        'icone' => null,
        'recommandations' => $recommandations,
        'bgCat' => '',
        'urlBack' => '/',
        'categoryName' => '',
        'nameBack' => 'Home',
        'content' => $content,
    ]
);
get_footer();
