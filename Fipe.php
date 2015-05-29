<?php 
class Fipe {
	private $__baseUrl = "http://www2.fipe.org.br/IndicesConsulta";
	private $anoReferenciaInicial = 2015;
	private $mesReferenciaInicial = 5;
	private $codigoTipoVeiculo = 1;
	private $codigoTabelaReferencia = 179;
	private $codigoModelo; 
	private $codigoMarca = 22; 
	private $ano;
	private $codigoTipoCombustivel;
	private $anoModelo;
	private $modeloCodigoExterno;

	public function Fipe() {
		$this->carregarTabelaReferencia();
	}

	private function carregarTabelaReferencia () {
		if (date('Y') != $this->anoReferenciaInicial || date('n') != $this->mesReferenciaInicial) {
			$timestampReferencia = mktime(0, 0, 0, $this->mesReferenciaInicial, 15, $this->anoReferenciaInicial);
			$diferencaTimestamp = time() - $timestampReferencia;
			$mesesDiferenca = floor(($diferencaTimestamp / (60 * 60 * 24 * 30)));
			$mesesDiferenca = $mesesDiferenca + (date('n') - date('n', strtotime("+$mesesDiferenca months", $timestampReferencia)));
			$this->codigoTabelaReferencia += $mesesDiferenca;
		}
	}

	public function post($url, $params) {
		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
		$resultado = curl_exec($curl);
		curl_close($curl);
		return $resultado;
	}

	public function consultarMarcas() {
		$url = $this->__baseUrl . "-ConsultarMarcas";
		$params = array(
			"codigoTabelaReferencia" => $this->codigoTabelaReferencia,
			"codigoTipoVeiculo" => $this->codigoTipoVeiculo
		);
		return json_decode($this->post($url, $params));
	}

	public function consultarModelos($codigoMarca) {
		$url = $this->__baseUrl . "-ConsultarModelos";
		$params = array(
			"codigoTabelaReferencia" => $this->codigoTabelaReferencia,
			"codigoTipoVeiculo" => $this->codigoTipoVeiculo,
			"codigoModelo" => "",
			"codigoMarca" => $codigoMarca,
			"ano" => "", 
			"codigoTipoCombustivel" => "", 
			"anoModelo" => "",
			"modeloCodigoExterno" => ""
		);
		return json_decode($this->post($url, $params));
	}

	public function consultarAnoModelo($codigoMarca, $codigoModelo) {
		$url = $this->__baseUrl . "-ConsultarAnoModelo";
		$params = array(
			"codigoTabelaReferencia" => $this->codigoTabelaReferencia,
			"codigoTipoVeiculo" => $this->codigoTipoVeiculo,
			"codigoModelo" => $codigoModelo,
			"codigoMarca" => $codigoMarca,
			"ano" => "", 
			"codigoTipoCombustivel" => "", 
			"anoModelo" => "",
			"modeloCodigoExterno" => ""
		);
		return json_decode($this->post($url, $params));
	}
}
