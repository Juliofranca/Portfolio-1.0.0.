<?php
// Para lidar com problemas de CORS, você pode incluir os seguintes headers:
header("Access-Control-Allow-Origin: https://juliofs.com"); // Se você quiser restringir a chamada apenas a domínios específicos, substitua o asterisco (*) pelo seu domínio. Exemplo: 
header("Access-Control-Allow-Methods: POST"); // Limitar o tipo de método permitido
header("Access-Control-Allow-Headers: Content-Type"); // Limitar os headers permitidos

// Permitir que qualquer domínio acesse
// header("Access-Control-Allow-Origin: *");


// Verifica se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Coleta os dados do formulário
    $nome = strip_tags(trim($_POST["fullname"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $mobile = trim($_POST["mobile"]);
    $assunto = trim($_POST["subject"]);
    $mensagemFormulario = trim($_POST["message"]);

    // Verifica se os campos obrigatórios estão preenchidos
    if (empty($nome) OR empty($mensagemFormulario) OR !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Adicione aqui seu código para tratar erros de validação.
        echo "Por favor, preencha os campos obrigatórios e forneça um email válido.";
        exit;
    }
    
    // Monta a mensagem em formato HTML
    $mensagem = "<html><body>";
    $mensagem .= "<h1>Mensagem enviada do juliofs.com</h1>";
    $mensagem .= "<p><strong>Nome:</strong> {$nome}</p>";
    $mensagem .= "<p><strong>Email:</strong> {$email}</p>";
    $mensagem .= "<p><strong>Telefone:</strong> {$mobile}</p>";
    $mensagem .= "<p><strong>Assunto:</strong> {$assunto}</p>";
    $mensagem .= "<p><strong>Mensagem:</strong><br>" . nl2br($mensagemFormulario) . "</p>";
    $mensagem .= "</body></html>";

    // Destinatário do email
    $para = "contato@juliofs.com";

    // Cabeçalhos do email
    $cabecalhos = "From: $nome <$email>\r\n";
    $cabecalhos .= "Reply-To: $email\r\n";
    $cabecalhos .= "MIME-Version: 1.0\r\n";
    $cabecalhos .= "Content-Type: text/html; charset=UTF-8\r\n";

    // Envia o email
    if (mail($para, $assunto, $mensagem, $cabecalhos)) {
        // Email enviado com sucesso
        echo json_encode(array(
            "status" => true,
            "message" => "Email successfully sent!",
            "response" => null
        ));
    } else {
        // Falha ao enviar o email
        echo json_encode(array(
            "status" => false,
            "message" => "Failed to send the email. Contact the site administrator by email at contato@juliofs.com",
            "response" => null
        ));
    }
} else {
    // Não é uma requisição POST
     echo json_encode(array(
            "status" => false,
            "message" => "Please submit the form correctly. Contact the site administrator by email at contato@juliofs.com",
            "response" => null
        ));
}
?>
