<?php

/**
 * Resolucionador de problemas de PO com Simplex. 
 * Suporta apenas única fase (e.g. menor ou igual).
 */
class Simprecs
{
    /**
     * Qtd de variáveis de decisão
     */
    protected $qtdVars;

    /**
     * Qtd de restrições
     */
    protected $qtdRestricoes;

    /**
     * Maximizar ou minimizar?
     */
    protected $objetivo;

    /**
     * Função objetiva.
     */
    protected $funcObj;

    /**
     * Matriz de restrições.
     */
    protected $restricoes;

    /**
     * Matriz de cálculo.
     */
    protected $calculo;

    /**
     * Construtor.
     * 
     * @param int $vars qtd de variáveis
     * @param int $rest qtd de restricões
     * @param string $gonnaWhat 'max' ou 'min'?
     */
    public function __construct($vars, $rest, $gonnaWhat)
    {
        if (!is_int($vars) || !is_int($rest)) return null;

        if ($gonnaWhat != 'max' && $gonnaWhat != 'min') return null;

        $this->qtdVars = $vars;
        $this->qtdRestricoes = $rest;
        $this->objetivo = $gonnaWhat;
    }

    /**
     * Insere os fatores da funcão objetiva.
     * 
     * @param array $fatores fatores da funcão objetiva, ordenados
     * 
     * @abstract exemplo para 2 vars de decisão
     * $fatores = [15, 50]
     * 
     * @return bool
     */
    public function setFuncObj($fatores)
    {
        // É array?
        if (!is_array($fatores)) return false;

        // Tem a qtd de fatores suficiente para todas as variáveis?
        if (count($fatores) != $this->qtdVars) return false;

        // Define o conjunto de fatores
        $this->funcObj = $fatores;
    }

    /**
     * Insere as restricões.
     * 
     * @param array $rest restricões
     * 
     * @abstract exemplo para 3 restricões
     * numa PO com 2 variáveis de decisão
     * $rest = [
     *      [1, 0, '<=', 4],
     *      [0, 1, '<=', 6],
     *      [3, 2, '<=', 18]
     * ]
     * 
     * @return bool
     */
    public function setRestricoes($rests)
    {
        // Verifica se a qtd de restricões bate com o informado
        if (count($rests) != $this->qtdRestricoes) return false;

        // Verifica se as restricões estão montadas adequadamente
        foreach ($rests as $rest)
        {
            // A restricão é um array?
            if (!is_array($rest)) return false;

            // A restricão tem todos os itens?
            if (count($rest) != ($this->qtdVars + 2)) return false;

            // A restricão está com seus itens com valores adequados?
            $index = 0;
            foreach ($rest as $item)
            {
                // Se for o penúltimo parâmetro, verifica se é uma das
                // operacões válidas
                // Senão verifica se é número
                if ($index = $this->qtdVars) {
                    if ($item != '<=') return false;
                } else {
                    if (!is_numeric($item)) return false;
                }
                $index++;
            }
        }

        // Insere as restricões no atributo
        $this->restricoes = $rests;
    }

    /**
     * Retorna a qtd de variáveis
     */
    public function getQtdVars()
    {
        return $this->qtdVars;
    }

    /**
     * Retorna a qtd de restricões
     */
    public function getQtdRestricoes()
    {
        return $this->qtdRestricoes;
    }

    /**
     * Realiza o cálculo.
     */
    public function sabatize()
    {
        
    }

    /**
     * Gera uma matriz de cálculo.
     */
    protected function geraMatrizCalculo()
    {
        $linhas = $this->qtdRestricoes + 1;
        $colunas = $this->qtdVars + $this->qtdRestricoes + 1;
    }
}