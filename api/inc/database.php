<?php
class database
{
//ste é um método público chamado EXE_QUERY. O nome sugere que ele é usado para executar consultas SQL que esperam retornar resultados (como SELECT).
    public function EXE_QUERY($query, $parameters = null, $debug = true, $close_connection=true){
        $results=null;
//Criação da Conexão PDO para se conectar ao banco de dados MySQL.
        $connection = new PDO(
            'mysql:host='.DB_SERVER.
            ';dbname='.DB_NAME.
            ';charset='.DB_CHARSET, 
            DB_USERNAME,
            DB_PASSWORD,
//array(PDO::ATTR_PERSISTENT => true) define um atributo para a conexão PDO. PDO::ATTR_PERSISTENT tenta usar conexões persistentes ao banco de dados, o que pode melhorar o desempenho em algumas situações, pois a conexão pode ser reutilizada entre diferentes requisições.
            array(PDO::ATTR_PERSISTENT=>true));

//Configuração de Erros (Debug)
            if($debug){
                $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
            }
//Execução da Consulta (Try-Catch)  é usado para lidar com possíveis erros durante a execução da consulta.
            try{
                if ($parameters != null){
                    $gestor = $connection->prepare($query);
                    $gestor->execute($parameters);
                    $results = $gestor->fetchAll          (PDO::FETCH_ASSOC);
                } else {
                    $gestor = $connection->prepare($query);
                    $gestor->execute();
                    $results = $gestor->fetchAll                    (PDO::FETCH_ASSOC);
                }

            }catch(PDOException $e){
                return false;                
            }

            if ($close_connection){
                $connection = null;
            }
            return $results;
        }
//Este é um método público chamado EXE_NON_QUERY. O nome sugere que ele é usado para executar consultas SQL que não esperam retornar resultados diretamente, mas sim modificar dados (como INSERT, UPDATE, DELETE).
        public function EXE_NON_QUERY($query, $parameters = null, $debug = true, $close_connection=true){


            $connection = new PDO(
                'mysql:host='.DB_SERVER.
                ';dbname='.DB_NAME. 
                ';charset='.DB_CHARSET,
                DB_USERNAME,
                DB_PASSWORD,
                array(PDO::ATTR_PERSISTENT=>true));

                if($debug){
                    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
                }

                $connection->beginTransaction();
                try{
                    if($parameters != null) {
                        $gestor = $connection->prepare($query);
                        $gestor->execute($parameters);
                    } else {
                        $gestor = $connection->prepare($query);
                        $gestor->execute();
                    }
//Commit da Transação: $connection->commit(); confirma as alterações feitas dentro da transação e as torna permanentes no banco de dados. Isso só é executado se a consulta for bem-sucedida.
                    $connection->commit();                    
                } catch (PDOException $e){
//Rollback em Caso de Erro: Se ocorrer uma exceção PDOException, $connection->rollBack(); desfaz todas as alterações feitas dentro da transação, restaurando o banco de dados ao estado anterior ao início da transação. A função então retorna false, indicando que a operação falhou.
                    $connection->rollBack();
                    return false;
                }

                if($close_connection){
                    $connection = null;
                }
                return true;
        }
    }
?>