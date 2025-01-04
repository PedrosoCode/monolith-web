<?php
require_once(__DIR__ . "/../../config/Database.php");


class stcCombos {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function carregaComboPais() {
        try {
            $sql = "CALL sp_stc_combo_pais();";
            $sQuery = $this->conn->query($sql);
            return $sQuery->fetchAll(PDO::FETCH_ASSOC); 
        } catch (PDOException $e) {
            echo "Erro ao buscar países: " . $e->getMessage();
            return [];
        }
    }
    
    public function carregaComboEstado() {
        try {
            $sql = "CALL sp_stc_combo_estado();"; 
            $sQuery = $this->conn->query($sql); 
            return $sQuery->fetchAll(PDO::FETCH_ASSOC); 
        } catch (PDOException $e) {
            echo "Erro ao buscar Estados: " . $e->getMessage();
            return [];
        }
    }
    
    // public function carregaComboCidade($iCodigoEstado) {
    //     try {
    //         $sql = "CALL sp_stc_combo_cidade(:codigo_estado);";
    //         $sQuery = $this->conn->prepare($sql); // Usar prepare, não query
    //         $sQuery->bindParam(':codigo_estado', $iCodigoEstado, PDO::PARAM_INT); // Agora $sQuery é válido
    //         $sQuery->execute(); // Execute a consulta
    //         return $sQuery->fetchAll(PDO::FETCH_ASSOC); // Retorne os resultados
    //     } catch (PDOException $e) {
    //         echo "Erro ao buscar Cidades: " . $e->getMessage();
    //         return [];
    //     }
    // }  
    
    public function carregaComboCidade($iCodigoEstado) {
        try {
            // Verifica se o código do estado é -1
            if ($iCodigoEstado == -1) {
                // Faz uma consulta com todos os dados ou um valor padrão
                $sql = "CALL sp_stc_combo_cidade(-1);"; // Ou qualquer código que indique "todas as cidades"
            } else {
                // Caso contrário, realiza a consulta normal
                $sql = "CALL sp_stc_combo_cidade(:codigo_estado);";
            }
    
            // Prepara a consulta
            $sQuery = $this->conn->prepare($sql);
            
            // Se não for o caso de -1, bind o parâmetro
            if ($iCodigoEstado != -1) {
                $sQuery->bindParam(':codigo_estado', $iCodigoEstado, PDO::PARAM_INT);
            }
            
            // Executa a consulta
            $sQuery->execute();
            
            // Obtém os resultados da consulta
            $resultados = $sQuery->fetchAll(PDO::FETCH_ASSOC);

            // Verifica se o código do estado foi -1
            if ($iCodigoEstado == -1) {
                // Retorna os resultados como JSON se o código for -1
                return $resultados;
            }
            
            
            return($resultados);
            
            // // Verifica se o código do estado foi -1
            // if ($iCodigoEstado == -1) {
            //     // Retorna os resultados como JSON se o código for -1
            //     return json_encode($resultados);
            // }
            
            // // Caso contrário, apenas retorna os dados em formato array
            // return $resultados;
    
        } catch (PDOException $e) {
            echo "Erro ao buscar Cidades: " . $e->getMessage();
            return [];
        }
    }
    


}
?>
