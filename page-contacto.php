<?php 
/*
Template Name: Chat GPT4
*/
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
get_header();

?>
<form method="post">
    <label for="mensaje">Escribe tu pregunta:</label>
    <textarea name="mensaje" id="mensaje" rows="4"></textarea>
    <button type="submit">Enviar</button>
</form>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['mensaje'])) {
    $respuesta = conectar_a_chatgpt(sanitize_text_field($_POST['mensaje']));
    echo '<p><strong>Respuesta:</strong> ' . esc_html($respuesta) . '</p>';
}
?>
<?php 
	get_footer(); 
?>
