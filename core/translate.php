<?php

/* This is global array of translation strings used for internal theme translation */

global $herald_translate;

$herald_translate = array(
	'no_comments' => array( 'text' => esc_html__( 'Comentários', 'herald' ), 'desc' => 'Comment meta data (if zero comments)' ),
	'one_comment' => array( 'text' => esc_html__( '1 Comentário', 'herald' ), 'desc' => 'Comment meta data (if 1 comment)' ),
	'multiple_comments' => array( 'text' => esc_html__( '% Comentários', 'herald' ), 'desc' => 'Comment meta data (if more than 1 comments)' ),
	'views' => array( 'text' => esc_html__( 'Visualizações', 'herald' ), 'desc' => 'Used in post meta data (number of views)' ),
	'min_read' => array( 'text' => esc_html__( 'Min Read', 'herald' ), 'desc' => 'Used in post meta data (reading time)' ),
	'read_more' => array( 'text' => esc_html__( 'Read More', 'herald' ), 'desc' => 'Label for read more link' ),
	'tagged_as' => array( 'text' => esc_html__( 'Mais sobre', 'herald' ), 'desc' => 'Text for tags area on single post' ),
	'category' => array('text' => esc_html__(' ', 'herald'), 'desc' => 'Category title prefix'),
	'tag' => array('text' => esc_html__('Tópico: ', 'herald'), 'desc' => 'Tag title prefix'),
	'author' => array('text' => esc_html__(' ', 'herald'), 'desc' => 'Author title prefix'),
	'archive' => array('text' => esc_html__('Arquivo - ', 'herald'), 'desc' => 'Archive title prefix'),
	'search_placeholder' => array('text' => esc_html__('Pesquisa livre', 'herald'), 'desc' => 'Search placeholder text'),
	'search_results_for' => array('text' => esc_html__('Resultados de pesquisa para - ', 'herald'), 'desc' => 'Title for search results template'),
	'newer_entries' => array('text' => esc_html__('Newer Entries', 'herald'), 'desc' => 'Pagination (prev/next) link text'),
	'older_entries' => array('text' => esc_html__('Older Entries', 'herald'), 'desc' => 'Pagination (prev/next) link text'),
	'previous_posts' => array('text' => esc_html__('Anterior', 'herald'), 'desc' => 'Pagination (numeric) link text'),
	'next_posts' => array('text' => esc_html__('Próximo', 'herald'), 'desc' => 'Pagination (numeric) link text'),
	'load_more' => array('text' => esc_html__('Carregar mais', 'herald'), 'desc' => 'Pagination (load more) link text'),
	'about_author' => array('text' => esc_html__('Sobre o autor', 'herald'), 'desc' => '"About author" area title on single post template'),
	'view_all_posts' => array('text' => esc_html__('Mais artigos deste autor', 'herald'), 'desc' => 'View all posts link text in author area'),
	'share_text' => array('text' => esc_html__('Partilha', 'herald'), 'desc' => 'Share text in vertical meta bar on single post template'),
	'related' => array('text' => esc_html__('Recomendamos', 'herald'), 'desc' => 'Related posts area title'),
	'comment_button' => array('text' => esc_html__('Click here to post a comment', 'herald'), 'desc' => 'Comment form opener button'),
	'comment_action' => array('text' => esc_html__('Comentarios', 'herald'), 'desc' => 'Comment action button in sticky bottom bar'),
	'comment_text' => array('text' => esc_html__('Comment', 'herald'), 'desc' => 'Comment form text area label'),
	'comment_email' => array('text' => esc_html__('Email', 'herald'), 'desc' => 'Comment form email label'),
	'comment_name' => array('text' => esc_html__('Name', 'herald'), 'desc' => 'Comment form name label'),
	'comment_website' => array('text' => esc_html__('Website', 'herald'), 'desc' => 'Comment form website label'),
	'comment_submit' => array('text' => esc_html__('Post comment', 'herald'), 'desc' => 'Comment form submit button text'),
	'comment_reply' => array('text' => esc_html__('Reply', 'herald'), 'desc' => 'Comment reply button text'),
	'comment_cancel_reply' => array('text' => esc_html__('Cancel reply', 'herald'), 'desc' => 'Comment cancel reply text'),
	'page_of' => array('text' => esc_html__('Page %s of %s', 'herald'), 'desc' => 'Paginated/multi-page post navigation label'),
	'404_title' => array('text' => esc_html__('404 error: Page not found', 'herald'), 'desc' => '404 page title'),
	'404_subtitle' => array('text' => esc_html__('What is happening?', 'herald'), 'desc' => '404 page sub-title'),
	'404_text' => array('text' => esc_html__('The page that you are looking for does not exist on this website. You may have accidentally mistype the page address, or followed an expired link. Anyway, we will help you get back on track. Why not try to search for the page you were looking for:', 'herald'), 'desc' => '404 page text'),
	'content_none' => array('text' => esc_html__('Este autor ainda não tem artigos publicados no JUP.', 'herald'), 'desc' => 'Message when there are no posts on archive pages. i.e Empty Category'),
	'content_none_search' => array('text' => esc_html__('Não existem resultados', 'herald'), 'desc' => 'Message when there are no search results.') 
);

?>
