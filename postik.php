<?php
/**
 * Template Name: postik
 * Template Post Type: post, page, product
 */

// Добавление пользовательской страницы в админку
function custom_admin_menu() {
    add_menu_page(
        'Custom Post Creation', // Заголовок страницы
        'Custom Post Creation', // Название меню
        'manage_options', // Возможности (права)
        'custom-post-creation', // Слаг страницы
        'custom_post_creation_page' // Функция вывода контента страницы
    );
}
add_action('admin_menu', 'custom_admin_menu');

// Функция вывода контента страницы
function custom_post_creation_page() {
    ?>
    <div class="wrap">
        <h1><?php _e('Create Custom Post', 'textdomain'); ?></h1>
        <form method="post" action="">
            <?php
            wp_nonce_field('custom_create_post_action', 'custom_create_post_nonce');
            ?>
            <table class="form-table">
                <tr>
                    <th><label for="post_title"><?php _e('Post Title', 'textdomain'); ?></label></th>
                    <td><input type="text" id="post_title" name="post_title" value="" /></td>
                </tr>
                <tr>
                    <th><label for="post_content"><?php _e('Post Content', 'textdomain'); ?></label></th>
                    <td><textarea id="post_content" name="post_content"></textarea></td>
                </tr>
            </table>
            <p class="submit">
                <input type="submit" class="button-primary" value="<?php _e('Create Post', 'textdomain'); ?>" />
            </p>
        </form>
    </div>
    <?php
}

// Обработка данных формы и создание поста
function handle_custom_post_creation() {
    if (isset($_POST['custom_create_post_nonce']) && wp_verify_nonce($_POST['custom_create_post_nonce'], 'custom_create_post_action')) {
        $title = sanitize_text_field($_POST['post_title']);
        $content = wp_kses_post($_POST['post_content']);

        $post_data = array(
            'post_title'   => $title,
            'post_content' => $content,
            'post_status'  => 'publish',
            'post_type'    => 'post',
        );

        wp_insert_post($post_data);
    }
}
add_action('admin_post_create_custom_post', 'handle_custom_post_creation');