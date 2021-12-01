<?php
  include_once "../bibliotecas/parametros.php";
  include_once "../bibliotecas/conexao.php";
  
    if (isset($_POST['gravar'])) {
        $queryLogin = $conn->prepare('select 1
                                        from usuarios
                                       where login = :login');
        $queryLogin->bindParam(':login', $_POST['login'], PDO::PARAM_STR);
        $queryLogin->execute();
        $query = $queryLogin->fetchAll();                                       

        if ($query = 1) {
            echo `<div class="alert alert-danger" role="alert">`;
            echo    "Erro! Já tem um usuário com este login" . "<br>";
            echo `</div>`;
        } else {
            try {
                $stmt = $conn->prepare(
                    'insert into usuarios (login, email, nome, password)
                                   values (:login, :email, :nome, md5(:password))');
                $stmt->execute(array('login' => $_POST['login'], 'email' => $_POST['email'],'nome' => $_POST['nome'],
                                    'password' => $_POST['senha']));
            
                echo `<div class="alert alert-success" role="alert">`;
                echo    "Sucesso! O usuário foi cadastrado com sucesso!";
                echo `</div>`;

            } catch(PDOException $e) {
                echo 'ERROR: ' . $e->getMessage();
            }
        }
    }
?>
<form method="post">
    <div class="form-group">
    <table class="form-group">
        <label for="nome">Nome</label>
        <input type="text" class="form-control" name="nome" id="nome" placeholder="Nome" required><br>
        <label for="Email">Email</label>
        <input type="email" class="form-control" name="email" id="email" placeholder="Email" required><br>
        <label for="login">Login</label>
        <input type="text" min="1" step="any" class="form-control" name="login" id="login" placeholder="Login" required><br>
        <label for="Senha">Senha</label>
        <input type="password" class="form-control" name="senha" id="senha" placeholder="Senha" required><br>
    </table>
    </div>
    <input type="submit" class= "btn btn-success" name="gravar" value="Gravar">
</form>
