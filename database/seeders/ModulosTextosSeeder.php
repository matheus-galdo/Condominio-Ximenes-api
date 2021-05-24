<?php

namespace Database\Seeders;

use App\Models\ModuloTexto;
use App\Models\Sistema\Modulos;
use App\Models\Sistema\UserType;
use Illuminate\Database\Seeder;

class ModulosTextosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = [
            ['modulo' => 'regras-normas', 'conteudo' => '<p><strong>ANEXO I – REGRAS E ORIENTAÇÕES – CONDOMINIO RESIDENCIAL XIMENES II&nbsp;</strong></p><p><br data-cke-filler="true"></p><p><strong>REGRAS:</strong></p><p><br data-cke-filler="true"></p><ol><li>Horário de funcionamento da portaria para entrega e devolução das chaves é das 7h às 23h59;</li><li>Não entrar nas escadas molhados e/ou com os pés ou corpo cheios de areia;</li><li>Usar a ducha do condomínio sempre que necessário de forma moderada e responsável;</li><li>É proibido qualquer ruído ou som alto de modo que venha a incomodar os vizinhos, considerando que a PERTURBAÇÃO DO SOSSEGO ALHEIO a qualquer momento do dia ou da noite, é considerado CONTRAVENÇÃO PENAL prevista no artigo 42 da Lei 3.688, de outubro de 1941, que dispõe:<ol><li>Perturbar alguém, o trabalho ou o sossego alheio:<ol><li>Com gritaria e algazarra; (...)</li><li>abusando de instrumento sonoros ou sinais acústicos; (...)</li></ol></li></ol></li><li>É proibido som automotivo ou manual na garagem do condomínio;</li><li>É proibido utilizar com volume audível nas unidades vizinhas, aparelhos sonoros, instrumentos musicais, alto-falantes, bem como máquinas de qualquer espécie que provoquem ruídos de alta intensidade.</li><li>É proibido o uso de água para limpeza de tendas ou barracas, assim como para lavagem de veículos nas dependências do condomínio;</li><li>É vedado lançar papéis, pontas de cigarro, fragmentos de lixo, líquidos e quaisquer objetos pelas janelas, terraços e outras aberturas para a via pública ou áreas comuns do edifício, sob pena de multa.</li><li>É proibido deixar lixo no hall dos andares, à porta das respectivas unidades autônomas ou em quaisquer áreas comuns do Condomínio. Todo o lixo deve ser acondicionado em sacos plásticos fechados e colocados na lixeira do condomínio;</li><li>Não é permitido estender roupas, tapetes e/ou qualquer objeto em geral, nas sacadas ou outros locais visíveis do exterior do edifício, sob pena de multa.</li><li>É proibido manusear os extintores do condomínio desnecessariamente;</li><li>Não é permitido jogar nos vasos sanitários das áreas comuns e privativas, qualquer objeto suscetível de provocar entupimentos, inclusive pontas de cigarro, papel e toalhas higiênicas, sob pena de multa.</li><li>É proibido estacionar os veículos fora dos limites das respectivas vagas;</li><li>É expressamente proibido estacionar o veículo fora das respectivas vagas, obstruindo as vagas vizinhas ou a pista de manobra e circulação, independentemente de seus direitos.</li><li>As locações limitam-se apenas à unidade locada (apartamento), o locatário está ciente que não é permitido o acesso ao terraço dos blocos.</li><li>Os funcionários do condomínio não estão autorizados a realizarem serviços para proprietários em nome do condomínio fora do seu horário de trabalho, exceto quando for para manter a ordem e o bom andamento comum ao condomínio.</li><li>Os funcionários estão autorizados a tomar as providências cabíveis para fazer cumprir as regras do condomínio;</li><li>Por medida de segurança e conservação, é recomendável que os pais orientem seus filhos sobre os bons costumes e a boa convivência;</li><li>Nas áreas comuns do condomínio só é permitido o trânsito de animais no colo; (consulte o proprietário do apartamento que está sendo alugado para verificar se é aceito animais em sua unidade condominial);</li><li>Cada proprietário possui horário de checkin e checkout estabelecido para a sua unidade condominial, consulte seu locador.</li></ol><p><br data-cke-filler="true"></p><p><strong>Ao realizar a locação o locatário está ciente e de acordo com as regras do Condomínio Edifício Ximenes II, sabendo, inclusive que o não cumprimentos das regras pode acarretar em multa de acordo com a convenção do condomínio.</strong></p>'],
            ['modulo' => 'contatos', 'conteudo' => 'lorem impsum'],
            ['modulo' => 'funcionamento', 'conteudo' => 'lorem impsum'],
        ];

        foreach ($types as $type) {

            $modulo = Modulos::where('nome', $type['modulo'])->first();

            ModuloTexto::create([
                'modulo_sistema_id' => $modulo->id,
                'conteudo' => $type['conteudo'],
            ]);
        }
    }
}
