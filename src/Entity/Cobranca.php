<?php

namespace Jetimob\PortoSeguro\Entity;

use Jetimob\Http\Traits\Serializable;
use Jetimob\PortoSeguro\Exceptions\InvalidArgumentException;
use Jetimob\PortoSeguro\Validators\Validator;

/**
 * Informações referentes à forma e condição de pagamento da proposta da preferência do cliente.
 */
class Cobranca
{
    use Serializable;
    use Validator;

    protected string $formaPagamento;

    protected string $condicaoPagamento;

    protected CartaoCredito $cartaoCredito;

    /**
     *
     * Código da forma de pagamento escolhida pelo cliente. A lista das formas de pagamento são disponibilizadas
     * dentro da oferta no retorno da API de orçamento. É composto por até 3 caracteres maiúsculos.
     * Opções válidas: 'CP', 'CC', 'FAT'
     *
     * @required
     * @example CC
     *
     * @param string $formaPagamento
     * @return Cobranca
     */
    public function setFormaPagamento(string $formaPagamento): Cobranca
    {
        $this->validateEnum(strtoupper($formaPagamento), ['CP', 'CC', 'FAT']);
        $this->formaPagamento = $formaPagamento;
        return $this;
    }

    /**
     *
     * Código da condição de pagamento escolhida pelo cliente. A lista das condições de pagamento disponíveis é retornada
     * dentro da forma de pagamento ao qual pertence. É composto por 3 caracteres numéricos e preenchido com zeros à esquerda.
     * Campo obrigatório.
     *
     * @required
     * @example 000
     *
     * @param string $condicaoPagamento
     * @return Cobranca
     */
    public function setCondicaoPagamento(string $condicaoPagamento): Cobranca
    {
        $condicaoPagamento = $this->getOnlyDigits($condicaoPagamento);

        if (strlen($condicaoPagamento) > 3) {
            throw new InvalidArgumentException('A condição de pagamento é composta por no máximo 3 dígitos númericos');
        }

        $this->condicaoPagamento = $condicaoPagamento;
        return $this;
    }

    /**
     * @param CartaoCredito $cartaoCredito
     * @return Cobranca
     */
    public function setCartaoCredito(CartaoCredito $cartaoCredito): Cobranca
    {
        $this->cartaoCredito = $cartaoCredito;
        return $this;
    }

    /**
     * @param $formaPagamento
     * @param $condicaoPagamento
     * @param $cartaoCredito
     * @return static
     */
    public static function new($formaPagamento, $condicaoPagamento, $cartaoCredito): self
    {
        return (new static())
            ->setFormaPagamento($formaPagamento)
            ->setCondicaoPagamento($condicaoPagamento)
            ->setCartaoCredito($cartaoCredito);
    }
}