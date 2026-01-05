<?php
    namespace Helpers;
    require_once __DIR__ . '/validators/index.php';
    use InvalidArgumentException;
    class Validador{

        protected static array $map = [
            "id" => 'id',
            'email' => 'email',
            'hora' => 'hora',
            'diaSemana' => 'diaSemana',
            'texto' => 'texto'
        ];

        public static function id($id, $repo, $entidade){
            return validarId_helper($id, $repo, $entidade);
        }

        public static function email($email, $nullable = false){
            return validarEmail_helper($email, $nullable);
        }

        public static function texto($texto, $campo = "Texto"){
            return validarTexto_helper($texto, $campo);
        }

        public static function hora($hora_inicio, $hora_fim){
            return validarHora_helper($hora_inicio, $hora_fim);
        }

        public static function diaSemana($dia){
            return validarDiaSemana_helper($dia);
        }

        public static function validarTudo(array $dados){
            $resultado = [];
            foreach($dados as $tipo => $params){
                if(!isset(self::$map[$tipo])){
                    throw new InvalidArgumentException("Validação não suportada: $tipo");
                }

                $metodo = self::$map[$tipo];
                $params = is_array($params) ? $params : [$params];
                $resultado[$tipo] = self::$metodo(...$params);
            }

            return $resultado;
        }

    }

?>